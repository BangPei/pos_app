<?php

namespace App\Http\Controllers;

use App\Models\HistoryStock;
use Illuminate\Http\Request;
use Yajra\DataTables\Utilities\Request as UtilitiesRequest;

class HistoryStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function dataTable($stockId, UtilitiesRequest $request)
    {
        $product = HistoryStock::where('stock_id', $stockId);
        if ($request->ajax()) {
            return datatables()->of($product)->make(true);
        }
    }
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
     * @param  \App\Models\HistoryStock  $historyStock
     * @return \Illuminate\Http\Response
     */
    public function show(HistoryStock $historyStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HistoryStock  $historyStock
     * @return \Illuminate\Http\Response
     */
    public function edit(HistoryStock $historyStock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HistoryStock  $historyStock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HistoryStock $historyStock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HistoryStock  $historyStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(HistoryStock $historyStock)
    {
        //
    }
}
