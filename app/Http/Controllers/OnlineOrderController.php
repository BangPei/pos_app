<?php

namespace App\Http\Controllers;

use App\Models\OnlineOrder;
use App\Http\Requests\StoreOnlineOrderRequest;
use App\Http\Requests\UpdateOnlineOrderRequest;

class OnlineOrderController extends Controller
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
     * @param  \App\Http\Requests\StoreOnlineOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOnlineOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OnlineOrder  $onlineOrder
     * @return \Illuminate\Http\Response
     */
    public function show(OnlineOrder $onlineOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OnlineOrder  $onlineOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(OnlineOrder $onlineOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOnlineOrderRequest  $request
     * @param  \App\Models\OnlineOrder  $onlineOrder
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOnlineOrderRequest $request, OnlineOrder $onlineOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OnlineOrder  $onlineOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(OnlineOrder $onlineOrder)
    {
        //
    }
}
