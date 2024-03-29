<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Expedition;
use App\Models\OnlineShop;
use App\Models\ShopeAccessToken;
use Illuminate\Http\Request;

class ShopeeApiController extends Controller
{
    public $partner_id = 2005013;
    public $host = "https://partner.shopeemobile.com";
    public $partner_key = "f0d2dcf11820ed84a4937f7ab3c2f9bceb3a1904ecd51ef604a0c9f263fa3fd6";
    public $shop_id = 285374341;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // return $this->getOrderByNoV2("221214MET95VCM");
        // return $this->getAccessToken();
        // return $this->getLink();
    }

    public function rts($orderSn)
    {
        $param = $this->getShippingParameter($orderSn);
        $addressList = $param->pickup->address_list;
        $pickupAddress = null;
        foreach ($addressList as $address) {
            if (str_contains(join(',', $address->address_flag), 'pickup_address')) {
                $pickupAddress = $address;
            }
        }
        foreach ($pickupAddress->time_slot_list as $times) {
            $times->date =  date('Y-m-d H:i:s',  $times->date);
        }
        $pickupTimeId = $pickupAddress->time_slot_list[0]->pickup_time_id;
        return $this->shipOrder($orderSn, $pickupAddress->address_id, $pickupTimeId);
    }

    public function getShippingParameter($orderSn)
    {
        try {
            $auth = $this->getRefreshToken();
            $timestamp = time();
            $path = "/api/v2/logistics/get_shipping_parameter";
            $sign = hash_hmac('sha256', utf8_encode($this->partner_id . $path . $timestamp . $auth->access_token . $this->shop_id), $this->partner_key);
            $url = $this->host . $path . '?timestamp=' . $timestamp . '&partner_id=' . $this->partner_id . '&sign=' . $sign . '&access_token=' . $auth->access_token . '&shop_id=' . $this->shop_id . '&order_sn=' . $orderSn;
            $response =  $this->curlRequest($url, "GET");
            return json_decode($response)->response;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function shipOrder($orderSn, $addressId, $pickupTimeId)
    {
        try {
            $auth = $this->getRefreshToken();
            $timestamp = time();
            $path = "/api/v2/logistics/ship_order";
            $sign = hash_hmac('sha256', utf8_encode($this->partner_id . $path . $timestamp . $auth->access_token . $this->shop_id), $this->partner_key);
            $url = $this->host . $path . '?timestamp=' . $timestamp . '&partner_id=' . $this->partner_id . '&sign=' . $sign . '&access_token=' . $auth->access_token . '&shop_id=' . $this->shop_id;
            $response =  $this->curlRequest(
                $url,
                "POST",
                array(
                    "order_sn" => $orderSn,
                    "pickup" => array(
                        "address_id" => $addressId,
                        "pickup_time_id" => $pickupTimeId,
                        "tracking_number" => ""
                    )
                )
            );
            return $response;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function getLink()
    {
        $host = "https://partner.shopeemobile.com";
        $path = "/api/v2/shop/auth_partner";
        $timestamp = time();
        $sign = hash_hmac('sha256', utf8_encode($this->partner_id . $path . $timestamp), $this->partner_key, false);
        $url = $host . $path . "?partner_id=" . $this->partner_id . "&timestamp=" . $timestamp . "&sign=" . $sign . "&redirect=https://www.google.com";
        $newUrl=str_replace(" ","",$url);
        return $newUrl;
    }

    public function getAccessToken()
    {
        $host = "https://partner.shopeemobile.com";
        $path = "/api/v2/auth/token/get";
        $timestamp = time();
        $partner_id = 2005013;
        $code = "6662474c747775477a76467242726c69";
        $shop_id = 285374341;
        $partner_key = "f0d2dcf11820ed84a4937f7ab3c2f9bceb3a1904ecd51ef604a0c9f263fa3fd6";
        $sign = hash_hmac('sha256', utf8_encode($partner_id . $path . $timestamp), $partner_key, false);
        $url = $host . $path . '?timestamp=' . $timestamp . '&partner_id=' . $partner_id . '&sign=' . $sign;
        return $this->curlRequest(
            $url,
            "POST",
            array(
                'partner_id' => $partner_id,
                'code' => $code,
                'shop_id' => $shop_id,
            ),
        );
    }
    public function getRefreshToken()
    {
        $accessAuth = ShopeAccessToken::all()->first();
        $host = "https://partner.shopeemobile.com";
        $path = "/api/v2/auth/access_token/get";
        $timestamp = time();
        $partner_id = 2005013;
        $shop_id = 285374341;
        $partner_key = "f0d2dcf11820ed84a4937f7ab3c2f9bceb3a1904ecd51ef604a0c9f263fa3fd6";
        $sign = hash_hmac('sha256', utf8_encode($partner_id . $path . $timestamp), $partner_key, false);
        $url = $host . $path . '?timestamp=' . $timestamp . '&partner_id=' . $partner_id . '&sign=' . $sign;
        $response =  $this->curlRequest(
            $url,
            "POST",
            array(
                'partner_id' => $partner_id,
                "refresh_token" => $accessAuth->refresh_token,
                'shop_id' => $shop_id,
            ),
        );
        $auth = json_decode($response);
        if ($auth->error == "") {
            ShopeAccessToken::where('id', $accessAuth->id)->update([
                "access_token" => $auth->access_token,
                "refresh_token" => $auth->refresh_token,
                "expire_in" => $auth->expire_in,
                "shop_id" => $auth->shop_id,
            ]);
            return ShopeAccessToken::all()->first();
        } else {
            return $response;
        }
    }

    public function getFullOrder($status = "PROCESSED")
    {
        $fullOrder = [];
        $nextCursor = null;
        $isMore = true;
        while ($isMore) {
            $auth = $this->getRefreshToken();
            $res = $this->getOrders($status, $nextCursor, $auth->access_token);
            $isMore = $res->more == 1 ? true : false;
            $nextCursor = $res->next_cursor;
            foreach ($res->order_list as $order) {
                $response = $this->getOrderByNoV2($order->order_sn);
                foreach ($response as $order) {
                    array_push($fullOrder, $order);
                }
            }
        }
        return $fullOrder;
    }

    public function getOrders($status = "PROCESSED", $nextCursor = null, $access_token)
    {
        // status == "PROCESSED" -> telah di proses pada web seller shopee
        // status == "READY_TO_SHIP" ->belum di print pada web seller shopee atau belum ada resi / kecuali instant atau sameday
        try {
            $time_from = (int)(time() - (60 * 60 * 24 * 3));
            $timestamp = time();
            $path = "/api/v2/order/get_order_list";
            $sign = hash_hmac('sha256', utf8_encode($this->partner_id . $path . $timestamp . $access_token . $this->shop_id), $this->partner_key);
            $url = $this->host . $path . '?timestamp=' . $timestamp . '&partner_id=' . $this->partner_id . '&sign=' . $sign . '&access_token=' .  $access_token . '&shop_id=' . $this->shop_id . '&page_size=50&time_from=' . $time_from . '&time_to=' . (int)time() . '&time_range_field=update_time&order_status=' . $status . '&cursor=' . $nextCursor;
            $response =  $this->curlRequest($url, "GET");
            if (json_decode($response)->error != "") {
                return response()->json(['message' => json_decode($response)->message], 500);
            }
            $res =  json_decode($response)->response;
            return $res;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function getOrderDetails($orderList, $access_token)
    {
        $auth = $this->getRefreshToken();
        $timestamp = time();
        $path = "/api/v2/order/get_order_detail";
        $sign = hash_hmac('sha256', utf8_encode($this->partner_id . $path . $timestamp . $access_token . $this->shop_id), $this->partner_key);
        $url = $this->host . $path . '?timestamp=' . $timestamp . '&partner_id=' . $this->partner_id . '&sign=' . $sign . '&access_token=' . $access_token . '&shop_id=' . $this->shop_id . '&order_sn_list=' . join(',', $orderList) . '&response_optional_fields=item_list,shipping_carrier,total_amount,prescription_images';
        $response =  $this->curlRequest($url, "GET");
        return $response;
    }

    public function getOrderByNo($orderSn)
    {
        try {
            $auth = $this->getRefreshToken();
            $timestamp = time();
            $path = "/api/v2/order/get_order_detail";
            $sign = hash_hmac('sha256', utf8_encode($this->partner_id . $path . $timestamp . $auth->access_token . $this->shop_id), $this->partner_key);
            $url = $this->host . $path . '?timestamp=' . $timestamp . '&partner_id=' . $this->partner_id . '&sign=' . $sign . '&access_token=' . $auth->access_token . '&shop_id=' . $this->shop_id . '&order_sn_list=' . $orderSn . '&response_optional_fields=item_list,shipping_carrier,total_amount,prescription_images';
            $response =  $this->curlRequest($url, "GET");
            if (json_decode($response)->error != "") {
                return response()->json(['message' => json_decode($response)->message . ' On Number ' . $orderSn], 500);
            }
            $logist = $this->getTrackingNumber($orderSn, $auth->access_token);
            $orderList = json_decode($response)->response->order_list;
            foreach ($orderList as $order) {
                $trackingNumber = json_decode($logist)->response->tracking_number ?? "";
                $order->trackingNumber = $trackingNumber;
            }
            return $orderList;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage() . ' On Number ' . $orderSn], 500);
        }
    }
    public function getOrderByNoV2($orderSn)
    {
        try {
            $fullOrder = [];
            $auth = $this->getRefreshToken();
            $platform = OnlineShop::where('name', 'Shopee')->first();
            $timestamp = time();
            $path = "/api/v2/order/get_order_detail";
            $sign = hash_hmac('sha256', utf8_encode($this->partner_id . $path . $timestamp . $auth->access_token . $this->shop_id), $this->partner_key);
            $url = $this->host . $path . '?timestamp=' . $timestamp . '&partner_id=' . $this->partner_id . '&sign=' . $sign . '&access_token=' . $auth->access_token . '&shop_id=' . $this->shop_id . '&order_sn_list=' . $orderSn . '&response_optional_fields=item_list,shipping_carrier,total_amount,prescription_images';
            $response =  $this->curlRequest($url, "GET");
            if (json_decode($response)->error != "") {
                return response()->json(['message' => json_decode($response)->message . ' On Number ' . $orderSn], 500);
            }
            $logist = $this->getTrackingNumber($orderSn, $auth->access_token);
            $orderList = json_decode($response)->response->order_list;
            foreach ($orderList as $order) {
                $total_qty = 0;
                $fixData = null;
                $items = [];
                $trackingNumber = json_decode($logist)->response->tracking_number ?? "";
                $fixData["create_time_online"] = date('Y-m-d H:i:s', $order->create_time);
                $fixData["update_time_online"] = date('Y-m-d H:i:s', $order->update_time);
                $fixData["message_to_seller"] = $order->message_to_seller;
                $fixData["order_no"] = $order->order_sn;
                $fixData["order_status"] = $this->getOrderStatus($order->order_status)['status'];
                $fixData["show_request"] = $this->getOrderStatus($order->order_status)['show_request'];
                $fixData["tracking_number"] = $trackingNumber;
                $fixData["delivery_by"] = $order->shipping_carrier;
                $fixData["pickup_by"] = $order->shipping_carrier;
                $fixData["total_amount"] = $order->total_amount;
                $fixData["status"] = 1;
                $fixData["online_shop_id"] = $platform->id;
                $fixData["order_id"] = null;
                $fixData["product_picture"] = null;
                $fixData["package_picture"] = null;
                $fixData["shipping_provider_type"] = null;
                foreach ($order->item_list as $itemOrder) {
                    $item = null;
                    $item['image_url'] = $itemOrder->image_info->image_url;
                    $item['item_name'] = $itemOrder->item_name;
                    $item['item_sku'] = $itemOrder->item_sku;
                    $item['variation'] = $itemOrder->model_name;
                    $item['order_item_id'] = $itemOrder->order_item_id;
                    $item['qty'] = $itemOrder->model_quantity_purchased;
                    $item['original_price'] = (float)$itemOrder->model_original_price;
                    $item['discounted_price'] = (float)$itemOrder->model_discounted_price;
                    $item['product_id'] = $itemOrder->item_id;
                    $item['sku_id'] = null;
                    $item['order_id'] = null;
                    $item['order_type'] = null;
                    $item['order_status'] = $this->getOrderStatus($order->order_status)['status'];
                    $item['tracking_number'] = null;
                    $total_qty = $total_qty + $item['qty'];
                    array_push($items, $item);
                }
                $fixData["total_qty"] = $total_qty;
                $fixData["items"] = $items;
                array_push($fullOrder, $fixData);
            }
            return $fullOrder;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage() . ' On Number ' . $orderSn], 500);
        }
    }

    public function getTrackingNumber($order_sn, $AccessToken)
    {
        try {

            $timestamp = time();
            $path = "/api/v2/logistics/get_tracking_number";
            $sign = hash_hmac('sha256', utf8_encode($this->partner_id . $path . $timestamp . $AccessToken . $this->shop_id), $this->partner_key);
            $url = $this->host . $path . '?timestamp=' . $timestamp . '&partner_id=' . $this->partner_id . '&sign=' . $sign . '&access_token=' . $AccessToken . '&shop_id=' . $this->shop_id . '&order_sn=' . $order_sn;
            $response =  $this->curlRequest($url, "GET");
            if (json_decode($response)->error != "") {
                return response()->json(['message' => json_decode($response)->message], 500);
            }
            return $response;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function getProducts()
    {
        try {
            $auth = $this->getRefreshToken();
            $timestamp = time();
            $path = "/api/v2/product/get_item_list";
            $sign = hash_hmac('sha256', utf8_encode($this->partner_id . $path . $timestamp . $auth->access_token . $this->shop_id), $this->partner_key);
            $url = $this->host . $path . '?timestamp=' . $timestamp . '&partner_id=' . $this->partner_id . '&sign=' . $sign . '&access_token=' . $auth->access_token . '&shop_id=' . $this->shop_id . '&offset=0&page_size=50&item_status=NORMAL';
            $response =  $this->curlRequest($url, "GET");
            if (json_decode($response)->error != "") {
                return response()->json(['message' => json_decode($response)->message], 500);
            }
            return $response;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
    public function getBuyerInvoiceInfo($orderSn)
    {
        try {
            $auth = $this->getRefreshToken();
            $timestamp = time();
            $path = "/api/v2/order/get_buyer_invoice_info";
            $sign = hash_hmac('sha256', utf8_encode($this->partner_id . $path . $timestamp . $auth->access_token . $this->shop_id), $this->partner_key);
            $url = $this->host . $path . '?timestamp=' . $timestamp . '&partner_id=' . $this->partner_id . '&sign=' . $sign . '&access_token=' . $auth->access_token . '&shop_id=' . $this->shop_id;
            $response =  $this->curlRequest(
                $url,
                "POST",
                array(
                    "queries" => [array("order_sn" => $orderSn)],

                )
            );
            if (json_decode($response)->error != "") {
                return response()->json(['message' => json_decode($response)->message], 500);
            }
            return $response;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
    public function getProductSearch()
    {
        try {
            $auth = $this->getRefreshToken();
            $timestamp = time();
            $path = "/api/v2/product/search_item";
            $sign = hash_hmac('sha256', utf8_encode($this->partner_id . $path . $timestamp . $auth->access_token . $this->shop_id), $this->partner_key);
            $url = $this->host . $path . '?timestamp=' . $timestamp . '&partner_id=' . $this->partner_id . '&sign=' . $sign . '&access_token=' . $auth->access_token . '&shop_id=' . $this->shop_id . '&page_size=50&item_name=zee';
            $response =  $this->curlRequest($url, "GET");
            if (json_decode($response)->error != "") {
                return response()->json(['message' => json_decode($response)->message], 500);
            }
            $listProductId = json_decode($response)->response->item_id_list;
            $products = $this->getProductInfo(join(",", $listProductId), $auth->access_token);
            return $products;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
    public function getProductInfo($productId, $access_token)
    {
        try {
            $timestamp = time();
            $path = "/api/v2/product/get_item_base_info";
            $sign = hash_hmac('sha256', utf8_encode($this->partner_id . $path . $timestamp . $access_token . $this->shop_id), $this->partner_key);
            $url = $this->host . $path . '?timestamp=' . $timestamp . '&partner_id=' . $this->partner_id . '&sign=' . $sign . '&access_token=' . $access_token . '&shop_id=' . $this->shop_id . '&item_id_list=' . $productId . '&need_complaint_policy=true&need_tax_info=true';
            $response =  $this->curlRequest($url, "GET");
            if (json_decode($response)->error != "") {
                return response()->json(['message' => json_decode($response)->message], 500);
            }
            return $response;
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

    private function getOrderStatus($status)
    {
        $orderStatus = array();
        switch ($status) {
            case "READY_TO_SHIP":
                $orderStatus = [
                    "status" => "DIKEMAS",
                    "show_request" => true
                ];
                break;
            case "IN_CANCEL":
                $orderStatus = [
                    "status" => "PENGAJUAN PEMBATALAN",
                    "show_request" => false
                ];
                break;
            case "CANCELLED":
                $orderStatus = [
                    "status" => "BATAL",
                    "show_request" => false
                ];
                break;
            case "COMPLETED":
                $orderStatus = [
                    "status" => "SELESAI",
                    "show_request" => false
                ];
                break;
            case "PROCESSED":
                $orderStatus = [
                    "status" => "SIAP KIRIM",
                    "show_request" => false
                ];
                break;
            case "UNPAID":
                $orderStatus = [
                    "status" => "BELUM BAYAR",
                    "show_request" => false
                ];
                break;
            case "SHIPPED":
                $orderStatus = [
                    "status" => "DALAM PENGIRIMAN",
                    "show_request" => false
                ];
                break;
            case "INVOICE_PENDING":
                $orderStatus = [
                    "status" => "INVOICE PENDING",
                    "show_request" => false
                ];
                break;
            default:
                $orderStatus = [
                    "status" => $status,
                    "show_request" => false
                ];
                break;
        }
        return $orderStatus;
    }
    private function getExpedition($trackingNumber)
    {
        $expeditionName = null;
        if (str_contains($trackingNumber, "SPXID")) {
            $expeditionName = "Shopee Express"; // get shopee expedition
        } elseif (str_contains($trackingNumber, "CM") || str_contains($trackingNumber, "JT") || str_contains($trackingNumber, "JY")) {
            $expeditionName = "JNE Reguler"; // get JNE Regular expedition
        } elseif (str_contains($trackingNumber, "JP")) {
            $expeditionName = "J&T Express"; // get JNE Regular expedition  
        }
        //get Shopee
        $expedition = Expedition::where('name', $expeditionName)->first();
        return $expedition->id;
    }
}
