<?php

namespace App\Http\Controllers;

use App\Models\MultipleDiscount;
use App\Models\ItemConvertion;
use App\Models\MultipleDiscountDetail;
use Exception;
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
        $products = ItemConvertion::all();
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
            $detail->item_convertion_id = $request->details[$i]["item_convertion_id"];
            $detail->is_active = true;
            array_push($details, $detail);
        }
        $md->details()->saveMany($details);
        $md->details = $details;
        return response()->json($md);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MultipleDiscount  $multipleDiscount
     * @return \Illuminate\Http\Response
     */
    public function show(UtilitiesRequest $request)
    {
        $multipleDiscount = new MultipleDiscount();
        if ($request->ajax()) {
            $multipleDiscount = MultipleDiscount::where('id', $request->id)->first();
        }
        return response()->json($multipleDiscount);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MultipleDiscount  $multipleDiscount
     * @return \Illuminate\Http\Response
     */
    public function edit(MultipleDiscount $multipleDiscount, UtilitiesRequest $request)
    {
        $products = ItemConvertion::all();
        if ($request->ajax()) {
            return datatables()->of($products)->make(true);
        }
        return view('discount/multiple/form', [
            "title" => "Diskon Form",
            "menu" => "Diskon",
            "multipleDiscount" => $multipleDiscount,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMultipleDiscountRequest  $request
     * @param  \App\Models\MultipleDiscount  $multipleDiscount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $multipleDiscount = $request;
            if ($request->ajax()) {

                MultipleDiscountDetail::where('multiple_discount_id', $multipleDiscount['id'])->delete();
                $details = [];
                $is_active = 0;
                for ($i = 0; $i < count($multipleDiscount->details); $i++) {
                    $detail = new MultipleDiscountDetail();
                    $detail->multiple_discount_id =  $multipleDiscount['id'];
                    $detail->item_convertion_id =  $multipleDiscount->details[$i]["item_convertion"]['id'];
                    $detail->is_active =  $multipleDiscount->details[$i]["is_active"] ? 1 : 0;
                    $detail->save();
                    $is_active = $detail->is_active == 1 ? +1 : +0;
                    array_push($details, $details);
                }
                MultipleDiscount::where('id', $multipleDiscount['id'])->update([
                    'name' => $multipleDiscount['name'],
                    'min_qty' => $multipleDiscount['min_qty'],
                    'discount' => $multipleDiscount['discount'],
                    'edit_by_id' => auth()->user()->id,
                    'is_active' => $is_active > 0 ? 1 : 0,
                ]);

                $multipleDiscount->details = $details;
            }
            return response()->json($$multipleDiscount);
        } catch (Exception $e) {
            print($e);
        }
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
