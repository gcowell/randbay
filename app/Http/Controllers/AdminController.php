<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Saleitem;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use App\Jobs\SendMail;
use Illuminate\Foundation\Bus\DispatchesJobs;


class AdminController extends Controller
{
    use DispatchesJobs;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin.check');
        $this->saleitemPath = Config::get('saleitems.filepath');
    }


//**********************************************************************************************************************

//ADMIN HOMEPAGE
    public function index()
    {
        return view('admin.index');
    }

//**********************************************************************************************************************

//RETURNS ALL UNCHECKED SALEITEMS
    public function saleitemsMonitoring()
    {
        $saleitem = new Saleitem();
        $unchecked_saleitems = $saleitem->getUnchecked();

        return view('admin.checksaleitems')->with(['unchecked_saleitems' => $unchecked_saleitems]);
    }


//**********************************************************************************************************************

//RETURNS ALL UNCHECKED SALEITEMS
    public function markAsChecked(Request $request)
    {

        $id_array = Input::except('_token');

        foreach ($id_array as $id)
        {
            $saleitem = Saleitem::findOrFail($id);
            $saleitem->setCheckedTrue();
            $saleitem->save();
        }

        return redirect('johnpupperman/saleitems');
    }

//**********************************************************************************************************************

//DELETES AN OFFENDING SALEITEM AND WARNS SELLER
    public function adminDelete($id)
    {
        $saleitem = Saleitem::findOrFail($id);

        //EXTRACT DETAILS FROM SALEITEM
        $fileName = $saleitem->id.'.'.$saleitem->image_type;

         //DELETE ITEM
        $saleitem->delete();

        //IMAGE FILE REMOVAL
        if(file_exists($this->saleitemPath . $fileName))
        {
            unlink($this->saleitemPath . $fileName); //remove the file
        }

        //SEND EMAIL TO WARN SELLER
        $emailAddress = $saleitem->seller_paypal_email;
        $data =
            [
                'id'                => $saleitem->id,
                'description'       => $saleitem->description,
                'image_type'        => $saleitem->image_type,
            ];

        $job = (new SendMail($emailAddress, 'removed', $data));
        $this->dispatch($job);

        return redirect('johnpupperman/saleitems');

        //TODO DEPLOY - Update all email links to http://randbay.com

    }


}
