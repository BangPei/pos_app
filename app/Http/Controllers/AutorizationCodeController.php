<?php

namespace App\Http\Controllers;

use App\Models\AutorizationCode;
use App\Http\Requests\StoreAutorizationCodeRequest;
use App\Http\Requests\UpdateAutorizationCodeRequest;

class AutorizationCodeController extends Controller
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
     * @param  \App\Http\Requests\StoreAutorizationCodeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAutorizationCodeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AutorizationCode  $autorizationCode
     * @return \Illuminate\Http\Response
     */
    public function show(AutorizationCode $autorizationCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AutorizationCode  $autorizationCode
     * @return \Illuminate\Http\Response
     */
    public function edit(AutorizationCode $autorizationCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAutorizationCodeRequest  $request
     * @param  \App\Models\AutorizationCode  $autorizationCode
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAutorizationCodeRequest $request, AutorizationCode $autorizationCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AutorizationCode  $autorizationCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(AutorizationCode $autorizationCode)
    {
        //
    }
}
