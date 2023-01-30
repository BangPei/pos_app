<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OnlineShop;
use Illuminate\Http\Request;
use NVuln\TiktokShop\Client;

class TiktokApiController extends Controller
{

    public $code = "ROW_07xHjwAAAABTpmVYZgZzPSYDx8NQ2nU03QmO-I6A3xp-KURBbVLFHbd7Ho7sf2dfpQ85Dl3G8IAVvYMwEce-LGzqK47hcigD";
    public $apiKey = "67eui64gqqriu";
    public $shopId = "7494670387281169228";
    public $apiSecret = "da24ac38ba6931114cd43e7b49f1bd0a7ae2f2e1";
    public $refreshToken = "ROW_ZjYwOTRkN2VmNmFhNDk3OTU1NDgxN2UwNzRmMWMxMTM2NzYyNGEyNzM2NmQ5OQ";
    public $access_token = "ROW_eAxJMAAAAADn98JTwrilby-8D5Me_l6_35jN75WHBB8ZqhOUIAQxbIG8_5peAVbBUkiZ_3pXJx51EKTNDjcAlk8UrCn4wrN9QPWraQaTvCp_NrkxMlxTgw";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return $this->getOrderDetail("576947223578839163");
        // return $this->getOrders();
        // return $this->getRefreshToken();
        // return $this->getAccessToken();
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

    public function getOrderDetail($listOrder)
    {
        $client = new Client($this->apiKey, $this->apiSecret);
        $client->setAccessToken($this->access_token);
        $client->setShopId($this->shopId);
        $orders = $client->Order->getOrderDetail($listOrder);
        $orderList = $orders['order_list'];
        $validOrders = [];
        foreach ($orderList as $order) {
            (int)$order['create_time'];
            (int)$order['update_time'];
            $validItems = [];
            foreach ($order['order_line_list'] as $item) {
                $itemData = $this->mapingOrder($order, $item);
                array_push($validItems, $itemData);
            }
            $order['order_line_list'] = $validItems;

            array_push($validOrders, $this->mapingOrderHeader($order));
        }
        return $validOrders;
    }

    public function getOrders()
    {
        $client = new Client($this->apiKey, $this->apiSecret);
        $client->setAccessToken($this->access_token);
        $client->setShopId($this->shopId);
        $more = true;
        $nextCursor = null;
        $fullOrder = [];
        $listOrder = [];
        $orders = $client->Order->getOrderList([
            'order_status' => 112,
            'page_size' => 50,
            'sort_type' => 2
        ]);
        $more = $orders['more'];
        $nextCursor = $orders['next_cursor'];
        foreach ($orders['order_list'] as $order) {
            array_push($listOrder, $order['order_id']);
        }
        $orderFull = $this->getOrderDetail($listOrder);
        foreach ($orderFull as $order) {
            array_push($fullOrder, $order);
        }

        while ($more) {
            $listOrder = [];
            $orders = $client->Order->getOrderList([
                'order_status' => 112,
                'page_size' => 50,
                'sort_type' => 2,
                'cursor' => $nextCursor,
            ]);
            $more = $orders['more'];
            $nextCursor = $orders['next_cursor'];
            foreach ($orders['order_list'] as $order) {
                array_push($listOrder, $order['order_id']);
            }
            $orderFull = $this->getOrderDetail($listOrder);
            foreach ($orderFull as $order) {
                array_push($fullOrder, $order);
            }
        }
        return $orderFull;
    }

    private function mapingOrder($headerObject, $detail)
    {
        $itemData = null;
        $itemData['image_url'] = $detail['sku_image'];
        $itemData['item_name'] = $detail['product_name'];
        $itemData['item_sku'] = $detail['seller_sku'];
        $itemData['variation'] = $detail['sku_name'];
        $itemData['order_item_id'] = null;
        $itemData['sku_id'] = $detail['sku_id'];
        $itemData['qty'] = 1;
        $itemData['original_price'] = $detail['original_price'];
        $itemData['discounted_price'] = $detail['sale_price'];
        $itemData['product_id'] = (int)$detail['product_id'];
        $itemData['order_id'] = (int)$detail['order_line_id'];
        $itemData['order_type'] = null;
        $itemData['order_status'] = $this->getOrderStatus($detail['display_status'])['status'];
        $itemData['tracking_number'] = $detail['tracking_number'];

        return $itemData;
    }

    private function mapingOrderHeader($headerObject)
    {
        $platform = OnlineShop::where('name', 'TikTok')->first();
        $fixData = null;
        $fixData["create_time_online"] = date('Y-m-d H:i:s', (int)$headerObject['create_time']);
        $fixData["update_time_online"] = date('Y-m-d H:i:s', (int)$headerObject['update_time']);
        $fixData["message_to_seller"] = null;
        $fixData["order_no"] = $headerObject['order_id'];
        $fixData["order_status"] = $this->getOrderStatus($headerObject['order_status'])['status'];
        $fixData["show_request"] = $this->getOrderStatus($headerObject['order_status'])['show_request'];
        $fixData["tracking_number"] = $headerObject['tracking_number'] ?? "";
        $fixData["delivery_by"] = $headerObject['shipping_provider'];
        $fixData["pickup_by"] = $headerObject['shipping_provider'];
        $fixData["total_amount"] = 0;
        $fixData["total_qty"] = count($headerObject['order_line_list']);
        $fixData["items"] = $headerObject['order_line_list'];
        $fixData["status"] = 1;
        $fixData["online_shop_id"] = $platform->id;
        $fixData["order_id"] = (string)$headerObject['order_id'];
        $fixData["shipping_provider_type"] = $headerObject['delivery_option'] ?? "";
        $fixData["product_picture"] = null;
        $fixData["package_picture"] = null;
        return $fixData;
    }

    private function getOrderStatus($status)
    {
        $orderStatus = array();
        switch ($status) {
            case 100:
                $orderStatus = [
                    "status" => "BELUM BAYAR",
                    "show_request" => false
                ];
                break;
            case 111:
                $orderStatus = [
                    "status" => "MENUNGGU DIPROSES",
                    "show_request" => false
                ];
                break;
            case 112:
                $orderStatus = [
                    "status" => "SIAP KIRIM",
                    "show_request" => false
                ];
                break;
            case 114:
                $orderStatus = [
                    "status" => "PENGIRIMAN PARSIAL",
                    "show_request" => false
                ];
                break;
            case 121:
                $orderStatus = [
                    "status" => "TRANSIT",
                    "show_request" => false
                ];
                break;
            case 122:
                $orderStatus = [
                    "status" => "TERKIRIM",
                    "show_request" => false
                ];
                break;
            case 130:
                $orderStatus = [
                    "status" => "SELESAI",
                    "show_request" => false
                ];
                break;
            case 140:
                $orderStatus = [
                    "status" => "BATAL",
                    "show_request" => false
                ];
                break;

            default:
                $orderStatus = [
                    "status" => (string)$status,
                    "show_request" => false
                ];
                break;
        }
        return $orderStatus;
    }

    public function getAccessToken()
    {
        $host = "https://auth.tiktok-shops.com";
        $path = "/api/v2/token/get";
        $url = $host . $path . '?app_key=' . $this->apiKey . '&app_secret=' . $this->apiSecret . '&auth_code=' . $this->code . '&grant_type=authorized_code';
        return $this->curlRequest($url, "GET");
    }
    public function getRefreshToken()
    {
        $host = "https://auth.tiktok-shops.com";
        $path = "/api/v2/token/refresh";
        $url = $host . $path . '?app_key=' . $this->apiKey . '&app_secret=' . $this->apiSecret . '&refresh_token=' . $this->refreshToken . '&grant_type=refresh_token';
        return $this->curlRequest($url, "GET");
    }

    public function curlRequest($url, $method, $fieldRequest = null)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($fieldRequest),
        ));

        $response = curl_exec($curl);
        // if (json_decode($response)->error == "error_auth") {
        //     $access =  $this->getRefreshToken();
        // }
        curl_close($curl);
        return $response;
    }
}
