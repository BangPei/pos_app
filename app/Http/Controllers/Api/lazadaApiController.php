<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OnlineShop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Lazada\LazopClient;
use Lazada\LazopRequest;

class lazadaApiController extends Controller
{

    public $lazadaUrl = "https://api.lazada.co.id/rest";
    public $apiKey = "112922";
    public $apiSecret = "4XaWknTPJSPdwCXcL8HUOWHKuTMQPyvq";
    public $code = "0_112922_5yiLbQhBbDXIPN4G6NzELkUw821";
    public $accessToken = "50000000225yiUVobiUOeqBM9pwOQfgYn1fkQ1c392f7ehsrGfGcv6MRvmssxTJi";
    public $refresh_token = "50001001e25rm5ebrBPvuckIJiwFRyHC4GrrB1da769e9RpyTuRx17QBIks8M3Iv";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return $this->packed("ASC");
        return $this->show(992854877011100);
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

    public function getFullOrder($status, $sorting = "DESC")
    {
        try {
            $fullOrder = [];
            $offset = 0;
            $limit = 100;
            $data = $this->getOrders($status, $sorting, $limit, $offset);
            $offset = $data->count;
            foreach ($data->orders as $order) {
                $c = new LazopClient($this->lazadaUrl, $this->apiKey, $this->apiSecret);
                $itemsUrl = new LazopRequest('/order/items/get', 'GET');
                $itemsUrl->addApiParam('order_id', $order->order_id);
                $items = $c->execute($itemsUrl, $this->accessToken);
                $itemDecode = json_decode($items);
                $validItems = [];
                if ($order->statuses[0] == "pending") {
                    foreach ($itemDecode->data as $item) {
                        $itemData = $this->mapingOrder($order, $item);
                        array_push($validItems, $itemData);
                    }
                } else {
                    foreach ($itemDecode->data as $item) {
                        if ($item->tracking_code !== "") {
                            $itemData = $this->mapingOrder($order, $item);
                            array_push($validItems, $itemData);
                        }
                    }
                }
                $order->items = $validItems;

                $fixData = $this->mapingOrderHeader($order);
                array_push($fullOrder, $fixData);
            }
            while ($offset == $limit) {
                $data = $this->getOrders($status, $sorting, $limit, $offset);
                $offset = $offset = $data->count;
                foreach ($data->orders as $order) {
                    $c = new LazopClient($this->lazadaUrl, $this->apiKey, $this->apiSecret);
                    $itemsUrl = new LazopRequest('/order/items/get', 'GET');
                    $itemsUrl->addApiParam('order_id', $order->order_id);
                    $items = $c->execute($itemsUrl, $this->accessToken);
                    $itemDecode = json_decode($items);
                    $validItems = [];
                    foreach ($itemDecode->data as $item) {
                        $itemData = $this->mapingOrder($order, $item);
                        array_push($validItems, $itemData);
                    }
                    $order->items = $validItems;

                    $fixData = $this->mapingOrderHeader($order);
                    array_push($fullOrder, $fixData);
                }
            }
            return $fullOrder;
            // $data = $this->getOrders($status, $sorting, $limit, $offset);
            // $offset = $offset = $data->count;
            // foreach ($data->orders as $order) {
            //     $c = new LazopClient($this->lazadaUrl, $this->apiKey, $this->apiSecret);
            //     $itemsUrl = new LazopRequest('/order/items/get', 'GET');
            //     $itemsUrl->addApiParam('order_id', $order->order_id);
            //     $items = $c->execute($itemsUrl, $this->accessToken);
            //     $itemDecode = json_decode($items);
            //     $validItems = [];
            //     if ($order->statuses[0] == "pending") {
            //         foreach ($itemDecode->data as $item) {
            //             $itemData = $this->mapingOrder($order, $item);
            //             array_push($validItems, $itemData);
            //         }
            //     } else {
            //         foreach ($itemDecode->data as $item) {
            //             if ($item->tracking_code !== "") {
            //                 $itemData = $this->mapingOrder($order, $item);
            //                 array_push($validItems, $itemData);
            //             }
            //         }
            //     }
            //     $order->items = $validItems;

            //     $fixData = $this->mapingOrderHeader($order);
            //     array_push($fullOrder, $fixData);
            // }
            // return $fullOrder;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function getOrders($status, $sorting, $limit, $offset)
    {
        try {
            $c = new LazopClient($this->lazadaUrl, $this->apiKey, $this->apiSecret);
            $orderUrl = new LazopRequest('/orders/get', 'GET');
            $orderUrl->addApiParam('sort_direction',  $sorting);
            $orderUrl->addApiParam('limit', $limit);
            $orderUrl->addApiParam('offset', $offset);
            $orderUrl->addApiParam('created_after', Carbon::now()->subDays(4)->format('c'));
            $orderUrl->addApiParam('status', $status);
            $orders =  $c->execute($orderUrl, $this->accessToken);
            return json_decode($orders)->data;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
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

    public function getCount()
    {
        $orders = $this->orderCenter("packed", '1');
        $rts = $this->orderCenter("ready_to_ship", '1');
        $pending = $this->orderCenter("pending", '1');
        $dataCount = null;
        $dataCount["packed"] = $orders->countTotal;
        $dataCount["pending"] = $pending->countTotal;
        $dataCount["rts"] = $rts->countTotal;
        $dataCount["total"] = $rts->countTotal + $pending->countTotal + $orders->countTotal;
        return $dataCount;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) // show order
    {
        try {
            $c = new LazopClient($this->lazadaUrl, $this->apiKey, $this->apiSecret);
            $request = new LazopRequest('/order/get', 'GET');
            $itemsUrl = new LazopRequest('/order/items/get', 'GET');

            //get order
            $request->addApiParam('order_id', $id);
            $order = $c->execute($request, $this->accessToken);
            $jsonObject = json_decode($order)->data;

            // // get items order and tracking number
            $itemsUrl->addApiParam('order_id', $jsonObject->order_id);
            $items = $c->execute($itemsUrl, $this->accessToken);
            $itemDecode = json_decode($items);
            $validItems = [];
            foreach ($itemDecode->data as $item) {
                $itemData = $this->mapingOrder($jsonObject, $item);
                array_push($validItems, $itemData);
            }
            $jsonObject->items = $validItems;

            $fixData = $this->mapingOrderHeader($jsonObject);

            return $fixData;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage() . ' On Number ' . $id], 500);
            // return $th;
        }
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

    private function mapingOrder($headerObject, $detail)
    {
        $itemData = null;
        $itemData['image_url'] = $detail->product_main_image;
        $itemData['item_name'] = $detail->name;
        $itemData['item_sku'] = $detail->sku;
        $itemData['variation'] = $detail->variation;
        $itemData['order_item_id'] = $detail->order_item_id;
        $itemData['sku_id'] = $detail->sku_id;
        $itemData['qty'] = 1;
        $itemData['original_price'] = $detail->item_price;
        $itemData['discounted_price'] = $detail->paid_price;
        $itemData['product_id'] = (int)$detail->product_id;
        $itemData['order_id'] = (int)$detail->order_id;
        $itemData['order_type'] = $detail->order_type;
        $itemData['order_status'] = $detail->status;
        $itemData['tracking_number'] = $detail->tracking_code;
        $headerObject->tracking_number = $detail->tracking_code !== "" ? $detail->tracking_code : "";
        $headerObject->shipping_provider_type = $detail->shipping_provider_type;
        $headerObject->shipment_provider = $detail->shipment_provider;
        $headerObject->status = $detail->status;
        return $itemData;
    }
    private function mapingOrderHeader($headerObject)
    {
        $platform = OnlineShop::where('name', 'Lazada')->first();
        $deliveryBy = "";
        $pickupBy = "";
        if ($headerObject->statuses[0] != "pending") {
            if ($headerObject->shipment_provider !== "") {
                $splited = explode(",", $headerObject->shipment_provider);
                $deliveryBy = str_replace(" Delivery: ", "", $splited[1]);
                $pickupBy = str_replace("Pickup: ", "", $splited[0]);
            }
        }
        $fixData = null;
        $fixData["create_time_online"] = $headerObject->created_at;
        $fixData["update_time_online"] = $headerObject->updated_at;
        $fixData["message_to_seller"] = null;
        $fixData["order_no"] = (string)$headerObject->order_number;
        $fixData["order_status"] = $headerObject->status; //$this->getOrderStatus($headerObject->status);
        $fixData["tracking_number"] = $headerObject->tracking_number ?? "";
        $fixData["delivery_by"] = $deliveryBy;
        $fixData["pickup_by"] = $pickupBy;
        $fixData["total_amount"] = (float) $headerObject->price;
        $fixData["total_qty"] = $headerObject->items_count;
        $fixData["items"] = $headerObject->items;
        $fixData["status"] = 1;
        $fixData["online_shop_id"] = $platform->id;
        $fixData["order_id"] = (string)$headerObject->order_id;
        $fixData["shipping_provider_type"] = $headerObject->shipping_provider_type ?? "";
        $fixData["product_picture"] = null;
        $fixData["package_picture"] = null;
        return $fixData;
    }

    private function getOrderStatus($status)
    {
        $orderStatus = "";
        switch ($status) {
            case "pending":
                $orderStatus = "PESANAN BARU";
                break;
            case "topack":
                $orderStatus = "DIKEMAS";
                break;
            case "returned":
                $orderStatus = "RETURN";
                break;
            case "canceled":
                $orderStatus = "BATAL";
                break;
            case "delivered":
                $orderStatus = "SELESAI";
                break;
            case "ready_to_ship":
                $orderStatus = "SIAP KIRIM";
                break;
            case "unpaid":
                $orderStatus = "BELUM BAYAR";
                break;
            case "failed":
                $orderStatus = "GAGAL KIRIM";
                break;
            case "shipped":
                $orderStatus = "DI PICKUP";
                break;
            case "shipping":
                $orderStatus = "DALAM PENGIRIMAN";
                break;
            case "lost":
                $orderStatus = "PAKET HILANG";
                break;
            default:
                $orderStatus = $status;
                break;
        }
        return $orderStatus;
    }
}
