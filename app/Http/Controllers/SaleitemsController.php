<?php

namespace App\Http\Controllers;

use App\Currencies;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Saleitem;
use App\Http\Requests\SaleitemRequest;
use App\Http\Requests\SaleitemUpdateRequest;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;


class SaleitemsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['except' => 'returnRandomItems' ]);
        $this->middleware('banned.check',['except' => 'returnRandomItems' ]);

        $this->moveDestinationPath = Config::get('saleitems.filepath');
    }



//**********************************************************************************************************************

    //SHOW ALL USER'S SALEITEMS
    public function index()
    {
        $saleitems = Auth::user()->saleitems()
                                 ->orderBy('created_at', 'desc')
                                 ->simplePaginate(5);

        return view('saleitems.index')->with(['saleitems' => $saleitems]);
    }

//**********************************************************************************************************************

    //DIRECT TO SALEITEMS CREATION FORM
    public function create()
    {
        return view('saleitems.create');
    }

//**********************************************************************************************************************

    //STORE SALEITEM IN DATABASE
    public function store(SaleitemRequest $request)
    {

        //INITIALISE ITEM
        $saleitem = new Saleitem($request->all());

        $currencies = new Currencies();
        $saleitem->currency_rate = $currencies->getApplicableRate($request->native_currency);

        $saleitem->country_of_origin = Auth::user()->getCountry();
        $saleitem->matched = 'false';

        //MAKE SURE ITEM IS NOT ENGAGED
        $saleitem->engaged_until = Carbon::now()->subMinutes(1);

        //INITIALISE SELLER RATING FROM USER
        $saleitem->seller_rating = Auth::user()->seller_rating;

        //SAVE IN ORDER TO GENERATE ID FOR FILE NAMING
        Auth::user()->saleitems()->save($saleitem);

        //FILE RELATED STUFF
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension(); // getting image extension
        $fileName = $saleitem->id.'.'.$extension; // renaming image
        $file->move($this->moveDestinationPath, $fileName);

        //RECORD IMAGE EXT IN DB
        $saleitem->image_type = $extension;

        //SAVE
        Auth::user()->saleitems()->save($saleitem);

        return redirect ('saleitems');
    }

//**********************************************************************************************************************

    //SHOW SELECTED SALEITEM
    public function show($id)
    {
        $saleitem = Saleitem::findOrFail($id);

        return view('saleitems.show')->with(['saleitem' => $saleitem]);
    }

//**********************************************************************************************************************

    //FOR A GIVEN SALE ITEM, FINDS THE TRANSACTION IT BELONGS TO
    public function showSaleItemTransaction($id)
    {
        $saleitem = Saleitem::findOrFail($id);
        $transaction = $saleitem->getAssociatedTransaction();

        return redirect('transactions/'. $transaction->id);

    }


//**********************************************************************************************************************

    public function update(SaleitemUpdateRequest $request, $id)
    {
        $saleitem = Auth::user()->saleitems()->findOrFail($id);

        $saleitem->description = $request->description;
        $saleitem->price = $request->price;
        $saleitem->domestic_postage_cost = $request->domestic_postage_cost;
        $saleitem->international = $request->international;

        if($request->world_postage_cost)
        {
            $saleitem->world_postage_cost = $request->world_postage_cost;
        }

        Auth::user()->saleitems()->save($saleitem);

        $file = $request->file('image');

        if($file)
        {
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $fileName = $saleitem->id.'.'.$extension; // renaming image

            if(file_exists($this->moveDestinationPath . $fileName))
            {
                unlink($this->moveDestinationPath . $fileName); //remove the file
            }

            $file->move($this->moveDestinationPath, $fileName);
            $saleitem->image_type = $extension;

            Auth::user()->saleitems()->save($saleitem);
        }

        Session::flash('updated' ,'Item updated successfully');

        return view('saleitems.show')->with(['saleitem' => $saleitem]);

    }

//**********************************************************************************************************************

    public function destroy($id)
    {
        $saleitem = Saleitem::findOrFail($id);
        $saleitem->delete();

        //IMAGE FILE REMOVAL
        $fileName = $saleitem->id.'.'.$saleitem->image_type;

        if(file_exists($this->moveDestinationPath . $fileName))
        {
            unlink($this->moveDestinationPath . $fileName); //remove the file
        }

        Session::flash('deleted' ,'Item deleted successfully');

        return redirect('/saleitems' );
    }

//**********************************************************************************************************************

    public function rate($id)
    {

        $rating = Input::get('rating');

        if ($rating == null)
        {
            return Redirect::back()->withErrors(['Please leave a rating between 1 and 5 stars']);
        }


        $saleitem = Saleitem::findOrFail($id);
        $saleitem->addRating($rating);
        $saleitem->save();

        $seller = $saleitem->seller;
        $new_seller_rating = $seller->updateSellerRating();
        $seller->cascadeSellerRating($new_seller_rating);

        $transaction = $saleitem->getAssociatedTransaction();

        $transaction->addRating($rating);
        $transaction->save();


        $notification = new Notification();
        $notification_type = 'rated-type';
        $notification->generate($seller->id, $transaction->id, $notification_type );

        $notification_details =
        [
            'item_description' => $saleitem->description,
            'item_img_path' => $saleitem->id . '.' . $saleitem->image_type,
            'item_rating' => $saleitem->rating
        ];

        $notification->setDetails($notification_details);



        return redirect('/transactions/'. $transaction->id);

    }


    public function returnRandomItems(Request $request)
    {
        if(!$request->ajax())
        {
            return redirect('/');
            exit;
        }

        $saleitem = new Saleitem();
        $random_saleitems = $saleitem->getRandomItems();

        $returnHTML = view('partials.selling_now_banner')->with('random_saleitems', $random_saleitems)->render();

        return response()->json(['success' => true, 'html'=>$returnHTML]);


    }





}
