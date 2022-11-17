<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JdIdAccessToken;
use App\Models\OnlineShop;
use Illuminate\Http\Request;
use Purnamasari\JD\JdClient;
use Purnamasari\JD\Request\SellerOrderGetOrderInfoByOrderIdRequest;

class JdIdApiController extends Controller
{
    // autorization to get code
    // https://oauth.jd.id/oauth2/to_login?app_key=9F23BA2F9CA861DA67405D20FB28DA21&response_type=code&redirect_uri=https://www.seller.jd.id/callback&scope=snsapi_base 

    public $code = "ZwmJXI";
    public $appKey = "9F23BA2F9CA861DA67405D20FB28DA21";
    public $appSecret = "ee86509d7b4c4edcbae467cd31117470";
    public $accsessToken = "041ef20a611b428b8e6cf72482bfb5cexzwy";
    public $refreshToken = "6deedacb16294a65b60a074ccb177b26rhy2";
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
        return $this->show(1117685142);
        // return $this->refreshToken();
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
        try {
            $auth = $this->refreshToken();
            $c = new JdClient();
            $c->appKey = $this->appKey;
            $c->appSecret = $this->appSecret;
            $c->accessToken = $this->accsessToken;
            $c->serverUrl = $this->host;
            $req = new SellerOrderGetOrderInfoByOrderIdRequest();
            $req->setOrderId($id);
            $resp = $c->execute($req, $auth->access_token);
            $response = $resp->jingdong_seller_order_getOrderInfoByOrderId_response;
            // if ($resp->error_response) {
            //     return response()->json(['message' => $resp->error_response->en_desc], 500);
            // }
            $platform = OnlineShop::where('name', 'JDID')->first();
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

            $fixData["total_amount"] = (float) $order->paySubtotal;
            $fixData["total_qty"] = $order->orderSkuNum;
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
                $itemData['sku_id'] = (string)$item->skuId;
                $itemData['qty'] = $item->skuNumber;
                $itemData['original_price'] = $item->jdPrice;
                $itemData['discounted_price'] = $item->costPrice;
                $itemData['product_id'] = null;
                $itemData['order_id'] = null;
                $itemData['order_type'] = (string)$order->orderType;
                $itemData['order_status'] = null;
                $itemData['tracking_number'] = null;
                $fixData["message_to_seller"] = $item->buyerMessage ?? "";
                array_push($items, $itemData);
            }
            $fixData['items'] = $items;
            return $fixData;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
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

    public function getAccessToken()
    {
        $url =  "https://oauth.jd.id/oauth2/access_token?app_key=" . $this->appKey . "&app_secret=" . $this->appSecret . "&grant_type=authorization_code&code=" . $this->code;
        $response = $this->curlRequest($url);
        return $response;
    }
    public function refreshToken()
    {
        $accessAuth = JdIdAccessToken::all()->first();
        $url =  "https://oauth.jd.id/oauth2/refresh_token?app_key=" . $this->appKey . "&app_secret=" . $this->appSecret . "&grant_type=refresh_token&refresh_token=" . $accessAuth->refresh_token;
        $res = $this->curlRequest($url);

        $auth = json_decode($res);
        if ($auth->code == 0) {
            JdIdAccessToken::where('id', $accessAuth->id)->update([
                "access_token" => $auth->access_token,
                "refresh_token" => $auth->refresh_token,
                "open_id" => $auth->open_id,
                "scope" => $auth->scope,
                "expires_in" => $auth->expires_in,
                "open_id" => $auth->open_id,
            ]);
            return JdIdAccessToken::all()->first();
        } else {
            return $res;
        }
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
