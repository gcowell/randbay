<?php

namespace App\Http\Controllers;

use App\Saleitem;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\BuyorderRequest;
use App\Http\Controllers\Controller;
use App\Buyorder;
use Auth;

class BuyordersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => 'create']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buyorders = Buyorder::all();

        return view('buyorder.index')->with(['buyorders' => $buyorders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('buyorders.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function find(BuyorderRequest $request)
    {
        $buyorder = new Buyorder($request->all());
        $buyorder['country'] = Auth::user()->getCountry();

        $saleitem = new Saleitem();
        $result = $saleitem->matchOrderToSaleitem($buyorder);

        if($result)
        {
            Auth::user()->buyorders()->save($buyorder);

        }

        return view('buyorders.match')->with(['saleitem' => $result, 'buyorder' => $buyorder ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
