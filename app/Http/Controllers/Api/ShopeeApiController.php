<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ShopeeApiController extends Controller
{

    public $secondAccessToken = "6c576c7a5a4248566357666b6e4d6745";
    public $secondRefreshToken = "4f454c42734e4859646e42676d744279";
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
        // return $this->getLink();
        // return $this->getAccessToken();
        // return $this->getRefreshToken();
        return $this->getOrders("READY_TO_SHIP");
    }

    public function getLink()
    {
        $timestamp = time();
        $partner_id = 2005013;
        $host = "https://partner.shopeemobile.com";
        $partner_key = "f0d2dcf11820ed84a4937f7ab3c2f9bceb3a1904ecd51ef604a0c9f263fa3fd6";
        $path = "/api/v2/shop/auth_partner";
        $sign = hash_hmac('sha256', utf8_encode($partner_id . $path . $timestamp), $partner_key, false);
        $url = $host . $path . "?timestamp=" . $timestamp . "&partner_id=" . $partner_id . "&sign=" . $sign . "&redirect=https://www.google.com";
        return $url;
    }

    public function getAccessToken()
    {
        $host = "https://partner.shopeemobile.com";
        $path = "/api/v2/auth/token/get";
        $timestamp = time();
        $partner_id = 2005013;
        $code = "655351526472676852744f5a774a4c68";
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
        $refreshToken = "684b48595844784c446d4262614a7164";
        $host = "https://partner.shopeemobile.com";
        $path = "/api/v2/auth/access_token/get";
        $timestamp = time();
        $partner_id = 2005013;
        $shop_id = 285374341;
        $partner_key = "f0d2dcf11820ed84a4937f7ab3c2f9bceb3a1904ecd51ef604a0c9f263fa3fd6";
        $sign = hash_hmac('sha256', utf8_encode($partner_id . $path . $timestamp), $partner_key, false);
        $url = $host . $path . '?timestamp=' . $timestamp . '&partner_id=' . $partner_id . '&sign=' . $sign;
        return $this->curlRequest(
            $url,
            "POST",
            array(
                'partner_id' => $partner_id,
                "refresh_token" => $refreshToken,
                'shop_id' => $shop_id,
            ),
        );
    }

    public function getOrders($status = "PROCESSED")
    {
        // status == "PROCESSED" -> telah di proses pada web seller shopee
        // status == "READY_TO_SHIP" ->belum di print pada web seller shopee atau belum ada resi / kecuali instant atau sameday

        $time_from = (int)(time() - (60 * 60 * 24 * 3));
        $timestamp = time();
        $path = "/api/v2/order/get_order_list";
        $sign = hash_hmac('sha256', utf8_encode($this->partner_id . $path . $timestamp . $this->secondAccessToken . $this->shop_id), $this->partner_key);
        $url = $this->host . $path . '?timestamp=' . $timestamp . '&partner_id=' . $this->partner_id . '&sign=' . $sign . '&access_token=' . $this->secondAccessToken . '&shop_id=' . $this->shop_id . '&page_size=100&time_from=' . $time_from . '&time_to=' . (int)time() . '&time_range_field=update_time&order_status=' . $status;
        $response =  $this->curlRequest($url, "GET");
        $res =  json_decode($response)->response;
        $order_list = [];
        foreach ($res->order_list as $order) {
            array_push($order_list, $order->order_sn);
        }
        $details = $this->getOrderDetails($order_list);
        $orders =  json_decode($details)->response->order_list;
        foreach ($orders as $order) {
            $logist = $this->getTrackingNumber($order->order_sn);
            $trackingNumber = json_decode($logist)->response->tracking_number ?? "";
            $order->tracking_number = $trackingNumber;
            // $order->logistic = json_decode($logist)->response;
        }
        return $orders;
    }

    public function getOrderDetails($orderList)
    {
        $timestamp = time();
        $path = "/api/v2/order/get_order_detail";
        $sign = hash_hmac('sha256', utf8_encode($this->partner_id . $path . $timestamp . $this->secondAccessToken . $this->shop_id), $this->partner_key);
        $url = $this->host . $path . '?timestamp=' . $timestamp . '&partner_id=' . $this->partner_id . '&sign=' . $sign . '&access_token=' . $this->secondAccessToken . '&shop_id=' . $this->shop_id . '&order_sn_list=' . join(',', $orderList) . '&response_optional_fields=item_list,shipping_carrier,total_amount,prescription_images,package_list';
        $response =  $this->curlRequest($url, "GET");
        return $response;
    }

    public function getTrackingNumber($order_sn)
    {
        $timestamp = time();
        $path = "/api/v2/logistics/get_tracking_number";
        $sign = hash_hmac('sha256', utf8_encode($this->partner_id . $path . $timestamp . $this->secondAccessToken . $this->shop_id), $this->partner_key);
        $url = $this->host . $path . '?timestamp=' . $timestamp . '&partner_id=' . $this->partner_id . '&sign=' . $sign . '&access_token=' . $this->secondAccessToken . '&shop_id=' . $this->shop_id . '&order_sn=' . $order_sn;
        $response =  $this->curlRequest($url, "GET");
        return $response;
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

        curl_close($curl);
        return $response;
    }
}
