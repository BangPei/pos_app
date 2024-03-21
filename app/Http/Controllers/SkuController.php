<?php

namespace App\Http\Controllers;

use App\Models\Sku;
use App\Models\SkuDetail;
use App\Models\SkuGift;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SkuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('online_shop/sku/index', ["title" => "SKU Generator", "menu" => "Online Shop",]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('online_shop/sku/sku-form', [
            "title" => "Form SKU",
            "menu" => "Online Shop"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sku = new Sku();
        $sku->code = Str::random(32);
        $sku->name = $request->name;
        $sku->total_item = $request->total_item;
        $sku->save();

        for ($i = 0; $i < count($request['gifts']); $i++) {
            $data = $request->gifts[$i];
            $gift = new SkuGift();
            $gift->qty = $data['qty'];
            $gift->product_barcode = $data['product']['barcode'];
            $gift->sku_id = $sku->id;
            $gift->save();
        }
        for ($i = 0; $i < count($request['details']); $i++) {
            $data = $request->details[$i];
            $details = new SkuDetail();
            $details->qty = $data['qty'];
            $details->product_barcode = $data['product']['barcode'];
            $details->sku_id = $sku->id;
            $details->is_variant = $data['is_variant'];
            $details->save();
        }
        return response()->json($sku->with('details')->with('gifts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function show(Sku $sku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function edit(Sku $sku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sku $sku)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sku $sku)
    {
        //
    }
}
