<?php

namespace App\Http\Controllers;

use App\Models\ShopInfo;
use App\Http\Requests\StoreShopInfoRequest;
use App\Http\Requests\UpdateShopInfoRequest;

class ShopInfoController extends Controller
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
     * @param  \App\Http\Requests\StoreShopInfoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShopInfoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShopInfo  $shopInfo
     * @return \Illuminate\Http\Response
     */
    public function show(ShopInfo $shopInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShopInfo  $shopInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(ShopInfo $shopInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateShopInfoRequest  $request
     * @param  \App\Models\ShopInfo  $shopInfo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShopInfoRequest $request, ShopInfo $shopInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShopInfo  $shopInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShopInfo $shopInfo)
    {
        //
    }
}
