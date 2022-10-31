<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Lazada\LazopClient;
use Lazada\LazopRequest;

class lazadaApiController extends Controller
{

    public $lazadaUrl = "https://api.lazada.co.id/rest";
    public $apiKey = "112922";
    public $apiSecret = "4XaWknTPJSPdwCXcL8HUOWHKuTMQPyvq";
    public $code = "0_112922_5yiLbQhBbDXIPN4G6NzELkUw821";
    public $accessToken = "50000000317b51qacxzhr6monxnRA1582c50ee6F1kksAzpfAkFr9nTTepqYKi1v";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orderCenter("packed", '100', "DESC");
        $rts = $this->orderCenter("ready_to_ship", '1');
        $pending = $this->orderCenter("pending", '1');
        $orders->totalPacked = $orders->countTotal;
        $orders->totalRts = $rts->countTotal;
        $orders->totalPending = $pending->countTotal;
        $orders->allTotal = $orders->totalRts + $orders->totalPending + $orders->totalPacked;
        return $orders;
    }

    public function packed($sorting)
    {
        $orders = $this->orderCenter("packed", '100', $sorting);
        $rts = $this->orderCenter("ready_to_ship", '1');
        $pending = $this->orderCenter("pending", '1');
        $orders->totalPacked = $orders->countTotal;
        $orders->totalRts = $rts->countTotal;
        $orders->totalPending = $pending->countTotal;
        $orders->allTotal = $orders->totalRts + $orders->totalPending + $orders->totalPacked;
        return $orders;
    }

    public function pending($sorting)
    {
        $orders = $this->orderCenter("packed", '1');
        $rts = $this->orderCenter("ready_to_ship", '1');
        $pending = $this->orderCenter("pending", '100', $sorting);
        $pending->totalPacked = $orders->countTotal;
        $pending->totalRts = $rts->countTotal;
        $pending->totalPending = $pending->countTotal;
        $pending->allTotal = $pending->totalRts + $pending->totalPending + $pending->totalPacked;
        return $pending;
    }
    public function rts($sorting)
    {
        $orders = $this->orderCenter("packed", '1');
        $rts = $this->orderCenter("ready_to_ship", '100', $sorting);
        $pending = $this->orderCenter("pending", '1');
        $rts->totalPacked = $orders->countTotal;
        $rts->totalRts = $rts->countTotal;
        $rts->totalPending = $pending->countTotal;
        $rts->allTotal = $rts->totalRts + $rts->totalPending + $rts->totalPacked;
        return $rts;
    }

    private function orderCenter($status, $limit = 100, $sort = "ASC")
    {
        $c = new LazopClient($this->lazadaUrl, $this->apiKey, $this->apiSecret);
        $orderUrl = new LazopRequest('/orders/get', 'GET');
        $itemsUrl = new LazopRequest('/order/items/get', 'GET');
        $orderUrl->addApiParam('sort_direction',  $sort);
        $orderUrl->addApiParam('limit', $limit);
        $orderUrl->addApiParam('created_after', Carbon::now()->subDays(4)->format('c'));
        $orderUrl->addApiParam('status', $status);
        $orders =  $c->execute($orderUrl, $this->accessToken);
        if (json_decode($orders)->code == "0") {
            $jsonObject = json_decode($orders)->data;
            foreach ($jsonObject->orders as $od) {
                $itemsUrl->addApiParam('order_id', $od->order_id);
                $items = $c->execute($itemsUrl, $this->accessToken);
                $itemDecode = json_decode($items);
                $validItems = [];
                if ($od->statuses[0] == "pending") {
                    $validItems = $itemDecode->data;
                } else {
                    foreach ($itemDecode->data as $item) {
                        if ($item->tracking_code !== "") {
                            array_push($validItems, $item);
                            $od->tracking_number = $item->tracking_code;
                            $od->shipping_provider_type = $item->shipping_provider_type;
                            $od->shipment_provider = $item->shipment_provider;
                        }
                    }
                }
                $od->items = $validItems;
            }
            return $jsonObject;
        } else {
            return response()->json(['message' => json_decode($orders)->message . ' on status ' . $status], 500);
        }
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

    public function readyToShipp($tracking_number, $shipment_provider, $order_item_ids) //request pickup order
    {
        $c = new LazopClient($this->lazadaUrl, $this->apiKey, $this->apiSecret);
        $request = new LazopRequest('/order/rts');
        $request->addApiParam('delivery_type', 'dropship');
        $request->addApiParam('shipment_provider',  $shipment_provider);
        $request->addApiParam('order_item_ids', $order_item_ids);
        $request->addApiParam('tracking_number', $tracking_number);
        $orders =  $c->execute($request, $this->accessToken);
        return $orders;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) // show order
    {
        $c = new LazopClient($this->lazadaUrl, $this->apiKey, $this->apiSecret);
        $request = new LazopRequest('/order/get', 'GET');
        $itemsUrl = new LazopRequest('/order/items/get', 'GET');
        $request->addApiParam('order_id', $id);
        $order = $c->execute($request, $this->accessToken);
        $jsonObject = json_decode($order)->data;

        $itemsUrl->addApiParam('order_id', $jsonObject->order_id);
        $items = $c->execute($itemsUrl, $this->accessToken);
        $itemDecode = json_decode($items);
        $jsonObject->items = $itemDecode->data;
        $jsonObject->tracking_number =  $itemDecode->data[0]->tracking_code;
        return $jsonObject;
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
