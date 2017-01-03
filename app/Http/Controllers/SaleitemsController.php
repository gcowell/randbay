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
use App\Jobs\SendMail;
use App\Jobs\AddMailingAddress;

use Illuminate\Support\Facades\Config;


class SaleitemsController extends Controller
{

    public function __construct()
    {
        $this->moveDestinationPath = Config::get('saleitems.filepath');
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

        //ITEM IS NOT MATCHED WITH BUYORDER
        $saleitem->matched = 'false';

        //MAKE SURE ITEM IS NOT ENGAGED
        $saleitem->engaged_until = Carbon::now()->subMinutes(1);

        //SAVE IN ORDER TO GENERATE ID FOR FILE NAMING
        $saleitem->save();

        //FILE RELATED STUFF
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension(); // getting image extension
        $fileName = $saleitem->id.'.'.$extension; // renaming image
        $file->move($this->moveDestinationPath, $fileName);

        //RECORD IMAGE EXT IN DB
        $saleitem->image_type = $extension;

        //SAVE
        $saleitem->save();

        //SEND CONFIRMATION EMAIL
        $emailAddress = $saleitem->seller_paypal_email;
        $data =
            [
                'id'                => $saleitem->id,
                'description'       => $saleitem->description,
                'image_type'        => $saleitem->image_type,
                'native_currency'   => $currencies->getSymbol($saleitem->native_currency),
                'price'             => $saleitem->price,
                'image_path'        => $this->moveDestinationPath

            ];

        $job = (new SendMail($emailAddress, 'forsale', $data));
        $this->dispatch($job);

        //ADD TO MAILING LIST
        $job = (new AddMailingAddress($emailAddress));
        $this->dispatch($job);

        //FLASH NOTIFICATION
        Session::flash('item_for_sale', $saleitem);

        return redirect ('/');
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
