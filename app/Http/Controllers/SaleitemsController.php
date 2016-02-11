<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Saleitem;
use App\Http\Requests\SaleitemRequest;
use Illuminate\Support\Facades\Auth;

class SaleitemsController extends Controller
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
        $saleitems = Auth::user()->saleitems;

        return view('saleitems.index')->with(['saleitems' => $saleitems]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('saleitems.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleitemRequest $request)
    {
        $saleitem = new Saleitem($request->all());
        $saleitem['country_of_origin'] = Auth::user()->getCountry();

        Auth::user()->saleitems()->save($saleitem);

        return redirect ('saleitems');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $saleitem = Saleitem::findOrFail($id);

        return view('saleitems.show')->with(['saleitem' => $saleitem]);
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
