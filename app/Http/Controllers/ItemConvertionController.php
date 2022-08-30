<?php

namespace App\Http\Controllers;

use App\Models\ItemConvertion;
use App\Http\Requests\StoreItemConvertionRequest;
use App\Http\Requests\UpdateItemConvertionRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\Utilities\Request as UtilitiesRequest;

class ItemConvertionController extends Controller
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
    public function dataTable(UtilitiesRequest $request)
    {
        $itemConvertion = ItemConvertion::all();
        if ($request->ajax()) {
            return datatables()->of($itemConvertion)->make(true);
        }
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
     * @param  \App\Http\Requests\StoreItemConvertionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemConvertionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemConvertion  $itemConvertion
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $product = new ItemConvertion();
        if ($request->ajax()) {
            $product = ItemConvertion::where('barcode', $request->barcode)->first();
        }
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemConvertion  $itemConvertion
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemConvertion $itemConvertion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemConvertionRequest  $request
     * @param  \App\Models\ItemConvertion  $itemConvertion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemConvertionRequest $request, ItemConvertion $itemConvertion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemConvertion  $itemConvertion
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemConvertion $itemConvertion)
    {
        //
    }
}
