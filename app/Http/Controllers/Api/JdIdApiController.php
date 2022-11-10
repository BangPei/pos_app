<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OnlineShop;
use Illuminate\Http\Request;
use Purnamasari\JD\JdClient;
use Purnamasari\JD\Request\SellerOrderGetOrderInfoByOrderIdRequest;

class JdIdApiController extends Controller
{
    // autorization to get code
    // https://oauth.jd.id/oauth2/to_login?app_key=9F23BA2F9CA861DA67405D20FB28DA21&response_type=code&redirect_uri=https://www.seller.jd.id/callback&scope=snsapi_base 

    public $code = "aaZkto";
    public $appKey = "9F23BA2F9CA861DA67405D20FB28DA21";
    public $appSecret = "ee86509d7b4c4edcbae467cd31117470";
    public $accsessToken = "95a865bf76fb4e87a80735d36e21ad19ody1";
    public $refreshToken = "2181015f99184231ac55b58f946df0f0mje4";
    public $openId = "6PX-UgIKmBZBUFgOSL9M9h5QcWFfoh6670lah9ocZ3Y";
    public $scope = "snsapi_base";
    public $host = "https://open-api.jd.id/routerjson";
    public $v = "2.0";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->getOrderByOrderId(1117112907);
    }

    private function getOrderStatus($status)
    {
        $orderStatus = "";
        switch ($status) {
            case 1:
                $orderStatus = "awaiting shipment";
                break;
            case 2:
                $orderStatus = "awaiting acceptance";
                break;
            case 5:
                $orderStatus = "cancel";
                break;
            case 6:
                $orderStatus = "complete";
                break;
            case 7:
                $orderStatus = "ready to ship";
                break;

            default:
                # code...
                break;
        }
        return $orderStatus;
    }

    public function getOrderByOrderId($orderId)
    {
        try {
            $c = new JdClient();
            $c->appKey = $this->appKey;
            $c->appSecret = $this->appSecret;
            $c->accessToken = $this->accsessToken;
            $c->serverUrl = $this->host;
            $req = new SellerOrderGetOrderInfoByOrderIdRequest();
            $req->setOrderId($orderId);
            $resp = $c->execute($req, $this->accsessToken);
            $response = $resp->jingdong_seller_order_getOrderInfoByOrderId_response;
            $platform = OnlineShop::where('name', 'JD.ID')->first();
            $order = $response->result->model;
            $fixData = null;
            $fixData["create_time_online"] = date('Y-m-d H:i:s', $order->createTime);
            $fixData["update_time_online"] = null;
            $fixData["message_to_seller"] = null;
            $fixData["order_no"] = (string)$order->orderId;
            $fixData["order_status"] = $this->getOrderStatus($order->orderState);
            $fixData["tracking_number"] = $order->expressNo ?? "";
            $fixData["delivery_by"] = $order->carrierCompany;
            $fixData["pickup_by"] = $order->carrierCompany;

            $fixData["total_amount"] = (float) $order->totalPrice;
            $fixData["total_qty"] = 0;
            // $fixData["items"] = $order->items;
            $fixData["status"] = 1;
            $fixData["online_shop_id"] = $platform->id;
            $fixData["order_id"] = (string)$order->orderId;
            $fixData["shipping_provider_type"] = null;
            $fixData["product_picture"] = null;
            $fixData["package_picture"] = null;
            $items = [];
            foreach ($order->orderSkuinfos as $item) {
                $itemData = null;
                $itemData['image_url'] = $item->skuImage;
                $itemData['item_name'] = $item->skuName;
                $itemData['item_sku'] = null;
                $itemData['variation'] = null;
                $itemData['order_item_id'] = null;
                $itemData['sku_id'] = $item->skuId;
                $itemData['qty'] = 1;
                $itemData['original_price'] = $item->jdPrice;
                $itemData['discounted_price'] = $item->costPrice;
                $itemData['product_id'] = null;
                $itemData['order_id'] = null;
                $itemData['order_type'] = $order->orderType;
                $fixData["message_to_seller"] = $item->buyerMessage;
                array_push($items, $itemData);
            }
            $fixData['items'] = $items;
            return $fixData;
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

    public function getGoSendOrderStatus($orderId)
    {
        $timestamp = ("timestamp=" . rawurlencode(date('Y-m-d H:i:s', time()) . ".000+0700")) . PHP_EOL;
        $method = "jingdong.seller.order.getGoSendOrderStatus";
        $buyParamJson = json_encode(array("orderId" => $orderId));
        $sign = $this->signGenerator($method, $timestamp, $buyParamJson);
        $url = $this->host . "?v=" . $this->v . "&method=" . $method . "&app_key=" . $this->appKey . "&access_token=" . $this->accsessToken . "&" . $timestamp . "&360buy_param_json=" . $buyParamJson . "&sign=" . $sign;
        $response = $this->curlRequest($url);
        return $url;
    }

    public function getAccessToken()
    {
        $url =  "https://oauth.jd.id/oauth2/access_token?app_key=" . $this->appKey . "&app_secret=" . $this->appSecret . "&grant_type=authorization_code&code=" . $this->code;
        $response = $this->curlRequest($url);
        return $response;
    }
    public function refreshToken()
    {
        $url =  "https://oauth.jd.id/oauth2/refresh_token?app_key=" . $this->appKey . "&app_secret=" . $this->appSecret . "&grant_type=refresh_token&refresh_token=" . $this->refreshToken;
        $res = $this->curlRequest($url);
        return $res;
    }

    public function signGenerator($method, $timestamp, $buyParamJson)
    {
        $params = array();
        $params['method'] = $method;
        $params['timestamp'] = $timestamp;
        $params['360buy_param_json'] = $buyParamJson;
        $params['access_token'] = $this->accsessToken;
        $params['app_key'] = $this->appKey;
        $params['v'] = $this->v;

        ksort($params);
        $stringToBeSigned = '';
        foreach ($params as $k => $v) {
            $stringToBeSigned .= "$k$v";
        }
        unset($k, $v);

        // $var = "360buy_param_json" . $buyParamJson . "access_token" . $this->accsessToken . "app_key" . $this->appKey . "method" . $method . "timestamp" . $timestamp . "v" . $this->v;
        $spliceValue = $this->appSecret . $stringToBeSigned . $this->appSecret;
        $encriptValue = md5($spliceValue);
        $upperEncript = strtoupper($encriptValue);
        return $upperEncript;
    }

    public function curlRequest($url, $fieldRequest = null)
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
            // CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => json_encode($fieldRequest),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
