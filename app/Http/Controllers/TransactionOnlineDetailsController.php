<?php

namespace App\Http\Controllers;

use App\Models\TransactionOnlineDetails;
use App\Http\Requests\StoreTransactionOnlineDetailsRequest;
use App\Http\Requests\UpdateTransactionOnlineDetailsRequest;

class TransactionOnlineDetailsController extends Controller
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
     * @param  \App\Http\Requests\StoreTransactionOnlineDetailsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransactionOnlineDetailsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransactionOnlineDetails  $transactionOnlineDetails
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionOnlineDetails $transactionOnlineDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransactionOnlineDetails  $transactionOnlineDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionOnlineDetails $transactionOnlineDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransactionOnlineDetailsRequest  $request
     * @param  \App\Models\TransactionOnlineDetails  $transactionOnlineDetails
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionOnlineDetailsRequest $request, TransactionOnlineDetails $transactionOnlineDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransactionOnlineDetails  $transactionOnlineDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionOnlineDetails $transactionOnlineDetails)
    {
        //
    }
}
