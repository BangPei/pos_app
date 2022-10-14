<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lazada\LazopClient;
use Lazada\LazopRequest;

class lazadaApiController extends Controller
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
        $code = "0_112922_5yiLbQhBbDXIPN4G6NzELkUw821";
        $accessToken = "50000000317b51qacxzhr6monxnRA1582c50ee6F1kksAzpfAkFr9nTTepqYKi1v";

        $c = new LazopClient($lazadaUrl, $apiKey, $apiSecret);
        $orderUrl = new LazopRequest('/orders/get', 'GET');
        $itemsUrl = new LazopRequest('/order/items/get', 'GET');
        // $orderUrl->addApiParam('update_before', '2018-02-10T16:00:00+08:00');
        $orderUrl->addApiParam('sort_direction', 'ASC');
        // $orderUrl->addApiParam('offset', '0');
        // $orderUrl->addApiParam('limit', '10');
        // $orderUrl->addApiParam('update_after', '2022-10-14T09:00:00+08:00');
        // $orderUrl->addApiParam('sort_by', 'updated_at');
        // $orderUrl->addApiParam('created_before', '2018-02-10T16:00:00+08:00');
        $orderUrl->addApiParam('created_after', '2022-10-10T00:00:00+00:00');
        $orderUrl->addApiParam('status', 'packed');
        $orders =  $c->execute($orderUrl, $accessToken);
        $jsonObject = json_decode($orders);
        foreach ($jsonObject->data->orders as $od) {
            $itemsUrl->addApiParam('order_id', $od->order_id);
            $items = $c->execute($itemsUrl, $accessToken);
            $od->items = json_decode($items);
        }
        return $jsonObject;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //request pickup order
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) // show order
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
