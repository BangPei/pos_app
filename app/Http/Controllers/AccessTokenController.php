<?php

namespace App\Http\Controllers;

use App\Models\AccessToken;
use App\Http\Requests\StoreAccessTokenRequest;
use App\Http\Requests\UpdateAccessTokenRequest;

class AccessTokenController extends Controller
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
     * @param  \App\Http\Requests\StoreAccessTokenRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccessTokenRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccessToken  $accessToken
     * @return \Illuminate\Http\Response
     */
    public function show(AccessToken $accessToken)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccessToken  $accessToken
     * @return \Illuminate\Http\Response
     */
    public function edit(AccessToken $accessToken)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAccessTokenRequest  $request
     * @param  \App\Models\AccessToken  $accessToken
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccessTokenRequest $request, AccessToken $accessToken)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccessToken  $accessToken
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccessToken $accessToken)
    {
        //
    }
}
