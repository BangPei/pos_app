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
        // https://auth.lazada.com/oauth/authorize?response_type=code&force_auth=true&redirect_uri=https://www.google.com&client_id=112922
        $lazadaUrl = "https://api.lazada.com/rest";
        $apiKey = "112922";
        $apiSecret = "4XaWknTPJSPdwCXcL8HUOWHKuTMQPyvq";
        $code = "0_112922_ut3ggTd3vLKkmyeamK4MyBsj68244";
        $accessToken = "50000000317b51qacxzhr6monxnRA1582c50ee6F1kksAzpfAkFr9nTTepqYKi1v";

        $c = new LazopClient($lazadaUrl, $apiKey, $apiSecret);
        $orderUrl = new LazopRequest("/auth/token/create");
        $orderUrl->addApiParam('code', $code);
        $orders =  $c->execute($orderUrl);
        return $orders;
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
