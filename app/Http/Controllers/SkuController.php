<?php

namespace App\Http\Controllers;

use App\Models\Sku;
use Illuminate\Http\Request;

class SkuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('online_shop/sku/index', ["title" => "SKU Generator", "menu" => "Online Shop",]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('online_shop/sku/sku-form', [
            "title" => "Form SKU",
            "menu" => "Online Shop"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function show(Sku $sku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function edit(Sku $sku)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sku $sku)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sku  $sku
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sku $sku)
    {
        //
    }
}
