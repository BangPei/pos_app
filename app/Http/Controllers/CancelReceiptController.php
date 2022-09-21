<?php

namespace App\Http\Controllers;

use App\Models\CancelReceipt;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCancelReceiptRequest;
use App\Http\Requests\UpdateCancelReceiptRequest;

class CancelReceiptController extends Controller
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
     * @param  \App\Http\Requests\StoreCancelReceiptRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCancelReceiptRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CancelReceipt  $cancelReceipt
     * @return \Illuminate\Http\Response
     */
    public function show(CancelReceipt $cancelReceipt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CancelReceipt  $cancelReceipt
     * @return \Illuminate\Http\Response
     */
    public function edit(CancelReceipt $cancelReceipt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCancelReceiptRequest  $request
     * @param  \App\Models\CancelReceipt  $cancelReceipt
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCancelReceiptRequest $request, CancelReceipt $cancelReceipt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CancelReceipt  $cancelReceipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(CancelReceipt $cancelReceipt)
    {
        //
    }
}
