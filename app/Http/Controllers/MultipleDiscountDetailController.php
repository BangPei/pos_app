<?php

namespace App\Http\Controllers;

use App\Models\MultipleDiscount;
use App\Models\MultipleDiscountDetail;
use Illuminate\Http\Request;

class MultipleDiscountDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MultipleDiscountDetail  $multipleDiscountDetail
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $detail = new MultipleDiscountDetail();
        $multiple = new MultipleDiscount();
        if ($request->ajax()) {
            $detail = MultipleDiscountDetail::where([
                ['is_active', 1],
                ['product_id', $request->product_id]
            ])->first();
            if (isset($detail)) {
                $multiple = MultipleDiscount::where('id', $detail->multiple_discount_id)->first();
                $detail->program = $multiple;
            }
        }
        return response()->json($detail);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MultipleDiscountDetail  $multipleDiscountDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(MultipleDiscountDetail $multipleDiscountDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MultipleDiscountDetail  $multipleDiscountDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MultipleDiscountDetail $multipleDiscountDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MultipleDiscountDetail  $multipleDiscountDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(MultipleDiscountDetail $multipleDiscountDetail)
    {
        //
    }
}
