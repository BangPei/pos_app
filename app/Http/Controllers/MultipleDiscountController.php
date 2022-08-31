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
        $md->is_active = $request['is_active'] ? 1 : 0;
        $md->created_by_id = auth()->user()->id;
        $md->edit_by_id = auth()->user()->id;
        $md->save();

        $details = [];

        for ($i = 0; $i < count($request->details); $i++) {
            $detail = new MultipleDiscountDetail();
            $detail->multiple_discount_id = $md["id"];
            $detail->item_convertion_barcode = $request->details[$i]["item_convertion"]['barcode'];
            $detail->is_active = $request->details[$i]['is_active'] ? 1 : 0;
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
            MultipleDiscountDetail::where('multiple_discount_id', $multipleDiscount['id'])->delete();
            $details = [];
            for ($i = 0; $i < count($multipleDiscount->details); $i++) {
                $detail = new MultipleDiscountDetail();
                $detail->multiple_discount_id =  $multipleDiscount['id'];
                $detail->item_convertion_barcode =  $multipleDiscount->details[$i]["item_convertion"]['barcode'];
                $detail->is_active =  $multipleDiscount->details[$i]["is_active"] ? 1 : 0;
                $detail->save();
                array_push($details, $details);
            }

            MultipleDiscount::where('id', $multipleDiscount['id'])->update([
                'name' => $multipleDiscount['name'],
                'min_qty' => $multipleDiscount['min_qty'],
                'discount' => $multipleDiscount['discount'],
                'edit_by_id' => auth()->user()->id,
                'is_active' => $multipleDiscount['is_active'] ? 1 : 0,
            ]);

            $multipleDiscount->details = $details;
            return response()->json($multipleDiscount);
        } catch (Exception $e) {
            print($e);
        }
    }

    public function changeStatus(Request $request)
    {
        $md = $request;
        if ($request->ajax()) {
            MultipleDiscount::where('id', $md['id'])->update([
                'name' => $md['name'],
                'min_qty' => $md['min_qty'],
                'discount' => $md['discount'],
                'edit_by_id' => auth()->user()->id,
                'is_active' => $md['is_active'] ? 1 : 0,
            ]);
            MultipleDiscountDetail::where('multiple_discount_id', $md['id'])->update([
                "is_active" => $md['is_active'] ? 1 : 0,
            ]);
        }
        return response()->json($md);
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
