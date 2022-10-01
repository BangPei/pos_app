<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lazada\LazopClient;
use Lazada\LazopRequest;

class DashboardApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lazadaUrl = "https://api.lazada.co.id/rest";
        $apiKey = "112922";
        $apiSecret = "4XaWknTPJSPdwCXcL8HUOWHKuTMQPyvq";

        $lazOp = new LazopClient($lazadaUrl, $apiKey, $apiSecret);
        $lazRequest = new LazopRequest('/orders/get', 'GET');
        $response = $lazOp->execute($lazRequest, "50000701413ciXiuemuBRRkAD16a98672Bv6rvTCjFtiVfVTFE4nTxDKoMmuySb8");
        return response()->json($response);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
