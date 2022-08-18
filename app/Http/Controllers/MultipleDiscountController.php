<?php

namespace App\Http\Controllers;

use App\Models\MultipleDiscount;
use App\Http\Requests\StoreMultipleDiscountRequest;
use App\Http\Requests\UpdateMultipleDiscountRequest;
use App\Models\Product;
use Yajra\DataTables\Utilities\Request as UtilitiesRequest;

class MultipleDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UtilitiesRequest $request)
    {
        $multipleDiscount = MultipleDiscount::all();
        if ($request->ajax()) {
            return datatables()->of($multipleDiscount)->make(true);
        }
        return view('discount/multiple/index', ["title" => "Paket Diskon", "menu" => "Diskon"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(UtilitiesRequest $request)
    {
        $products = Product::all();
        if ($request->ajax()) {
            return datatables()->of($products)->make(true);
        }
        return view('discount/multiple/form', [
            "title" => "Diskon Form",
            "menu" => "Diskon"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMultipleDiscountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMultipleDiscountRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MultipleDiscount  $multipleDiscount
     * @return \Illuminate\Http\Response
     */
    public function show(MultipleDiscount $multipleDiscount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MultipleDiscount  $multipleDiscount
     * @return \Illuminate\Http\Response
     */
    public function edit(MultipleDiscount $multipleDiscount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMultipleDiscountRequest  $request
     * @param  \App\Models\MultipleDiscount  $multipleDiscount
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMultipleDiscountRequest $request, MultipleDiscount $multipleDiscount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MultipleDiscount  $multipleDiscount
     * @return \Illuminate\Http\Response
     */
    public function destroy(MultipleDiscount $multipleDiscount)
    {
        //
    }
}
