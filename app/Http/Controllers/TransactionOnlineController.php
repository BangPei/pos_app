<?php

namespace App\Http\Controllers;

use App\Models\TransactionOnline;
use App\Http\Requests\StoreTransactionOnlineRequest;
use App\Http\Requests\UpdateTransactionOnlineRequest;
use Illuminate\Http\Client\Request;

class TransactionOnlineController extends Controller
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
     * @param  \App\Http\Requests\StoreTransactionOnlineRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransactionOnline  $transactionOnline
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionOnline $transactionOnline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransactionOnline  $transactionOnline
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionOnline $transactionOnline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransactionOnlineRequest  $request
     * @param  \App\Models\TransactionOnline  $transactionOnline
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionOnlineRequest $request, TransactionOnline $transactionOnline)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransactionOnline  $transactionOnline
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionOnline $transactionOnline)
    {
        //
    }
}
