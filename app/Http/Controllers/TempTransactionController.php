<?php

namespace App\Http\Controllers;

use App\Models\TempTransaction;
use Illuminate\Http\Request;

class TempTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $temp = TempTransaction::all();
        return $temp;
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
        $temp = new TempTransaction();
        $temp->stock_id = $request->stock_id;
        $temp->product_id = $request->product_id;
        $temp->user_id = $request->user_id;
        $temp->convertion = $request->convertion;
        $temp->qty = $request->qty;
        $temp->save();
        return $temp;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TempTransaction  $tempTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $temp = TempTransaction::where([
            'product_id' => $request->product_id,
            'user_id' => $request->user_id
        ])->update([
            'qty' => $request->qty,
        ]);
        return $temp;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TempTransaction  $tempTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(TempTransaction $tempTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TempTransaction  $tempTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TempTransaction $tempTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TempTransaction  $tempTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(TempTransaction $tempTransaction)
    {
        //
    }
}
