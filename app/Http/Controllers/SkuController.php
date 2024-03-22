<?php

namespace App\Http\Controllers;

use App\Models\Sku;
use App\Models\SkuDetail;
use App\Models\SkuGift;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Utilities\Request as UtilitiesRequest;

class SkuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UtilitiesRequest $request)
    {
        $sku = Sku::all();
        if ($request->ajax()) {
            return datatables()->of($sku)->make(true);
        }
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
        try {
            $sku = new Sku();
            $sku->code = Str::random(20);
            $sku->name = $request->name;
            $sku->total_item = $request->total_item;
            $sku->save();

            if (isset($request['gifts'])) {
                for ($i = 0; $i < count($request['gifts']); $i++) {
                    $data = $request->gifts[$i];
                    $gift = new SkuGift();
                    $gift->qty = $data['qty'];
                    $gift->product_barcode = $data['product']['barcode'];
                    $gift->sku_id = $sku->id;
                    $gift->save();
                }
            }
            for ($i = 0; $i < count($request['details']); $i++) {
                $data = $request->details[$i];
                $details = new SkuDetail();
                $details->qty = $data['qty'];
                $details->product_barcode = $data['product']['barcode'];
                $details->sku_id = $sku->id;
                $details->is_variant = $data['is_variant'] == "true" ? 1 : 0;;
                $details->save();
            }
            $newSku = Sku::where('id', $sku->id)->with(['details', 'gifts'])->first();
            return response()->json($newSku);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], $th->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $sku = Sku::where('id', $request->id)->first();
        return response()->json($sku);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function edit(Sku $sku)
    {
        return view('online_shop/sku/sku-form', [
            "title" => "Form SKU",
            "menu" => "Online Shop",
            "sku" => $sku,
        ]);
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
