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

        $c = new LazopClient("https://auth.lazada.com/rest", $apiKey, $apiSecret);
        // $request = new LazopRequest('/datamoat/login');
        // $request->addApiParam('time', time());
        // $request->addApiParam('appName', 'SSmart10');
        // $request->addApiParam('userId', 'ssmart10');
        // $request->addApiParam('tid', 'tkssmart10@gmail.com');
        // $request->addApiParam('userIp', '180.243.11.214');
        // $request->addApiParam('ati', '202cb962ac59075b964b07152d234b70');
        // $request->addApiParam('loginResult', 'fail');
        // $request->addApiParam('loginMessage', 'password is not corret');
        // var_dump($c->execute($request));
        $request = new LazopRequest('/auth/token/create');
        $request->addApiParam('code', '0_100132_2DL4DV3jcU1UOT7WGI1A4rY91');
        // $request->addApiParam('uuid', 'This field is currently invalid,  do not use this field please');
        var_dump($c->execute($request));
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
