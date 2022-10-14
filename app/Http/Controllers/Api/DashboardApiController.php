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
        $lazadaUrl = "https://api.lazada.co.id/rest";
        $apiKey = "112922";
        $apiSecret = "4XaWknTPJSPdwCXcL8HUOWHKuTMQPyvq";
        $code = "0_112922_5yiLbQhBbDXIPN4G6NzELkUw821";
        $accessToken = "50000000317b51qacxzhr6monxnRA1582c50ee6F1kksAzpfAkFr9nTTepqYKi1v";

        // $c = new LazopClient("https://auth.lazada.com/rest", $apiKey, $apiSecret);
        // $request = new LazopRequest('/datamoat/login');
        // $request->addApiParam('time', time());
        // $request->addApiParam('appName', 'SSmart10');
        // $request->addApiParam('userId', 'ID67XG9JEA');
        // $request->addApiParam('tid', 'tkssmart10@gmail.com');
        // $request->addApiParam('userIp', '180.243.11.214');
        // $request->addApiParam('ati', '202cb962ac59075b964b07152d234b70');
        // $request->addApiParam('loginResult', 'fail');
        // $request->addApiParam('loginMessage', 'password is not corret');
        // var_dump($c->execute($request));
        // $c = new LazopClient("https://auth.lazada.com/rest", $apiKey, $apiSecret);
        // $request = new LazopRequest('/auth/token/create');
        // $request->addApiParam('code', $code);
        // // $request->addApiParam('uuid', 'This field is currently invalid,  do not use this field please');
        // return $c->execute($request);
        $c = new LazopClient($lazadaUrl, $apiKey, $apiSecret);
        $request = new LazopRequest('/orders/get', 'GET');
        // $request->addApiParam('update_before', '2018-02-10T16:00:00+08:00');
        $request->addApiParam('sort_direction', 'DESC');
        // $request->addApiParam('offset', '0');
        // $request->addApiParam('limit', '10');
        // $request->addApiParam('update_after', '2022-10-14T09:00:00+08:00');
        // $request->addApiParam('sort_by', 'updated_at');
        // $request->addApiParam('created_before', '2018-02-10T16:00:00+08:00');
        $request->addApiParam('created_after', '2022-10-14T00:00:00+00:00');
        $request->addApiParam('status', 'ready_to_ship');
        return $c->execute($request, $accessToken);
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
