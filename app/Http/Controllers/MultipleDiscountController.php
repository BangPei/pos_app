<?php

namespace App\Http\Controllers;

use App\Models\MultipleDiscount;
use App\Http\Requests\UpdateMultipleDiscountRequest;
use App\Models\MultipleDiscountDetail;
use App\Models\Product;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        $md = new MultipleDiscount();
        $md->name = $request['name'];
        $md->min_qty = $request['min_qty'];
        $md->discount = $request['discount'];
        $md->is_active = true;
        $md->created_by_id = auth()->user()->id;
        $md->edit_by_id = auth()->user()->id;
        $md->save();

        $details = [];

        for ($i = 0; $i < count($request->details); $i++) {
            $detail = new MultipleDiscountDetail();
            $detail->multiple_discount_id = $md["id"];
            $detail->product_id = $request->details[$i]["product_id"];
            $detail->is_active = true;
            $detail->save();
            array_push($details, $detail);
        }
        $md->details = $details;
        return response()->json($md);
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
