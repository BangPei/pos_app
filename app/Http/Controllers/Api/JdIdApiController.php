<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JdIdApiController extends Controller
{
    // autorization to get code
    // https://oauth.jd.id/oauth2/to_login?app_key=9F23BA2F9CA861DA67405D20FB28DA21&response_type=code&redirect_uri=https://www.seller.jd.id/callback&scope=snsapi_base 

    public $code = "8W9oj5";
    public $appKey = "9F23BA2F9CA861DA67405D20FB28DA21";
    public $appSecret = "ee86509d7b4c4edcbae467cd31117470";
    public $accsessToken = "3b1605ecebe1456ea33a70192e940bbbnja1";
    public $refreshToken = "b80b4fc3bd1e4ed8b905c215c4d5a3cbmyzn";
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
        return $this->getGoSendOrderStatus(1117112907);
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
        // $res = $this->curlRequest($url);
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
        $response = json_decode($res);
        $response->expires_in =  date('Y-m-d H:i:s', $response->expires_in);
        return $response;
    }

    public function signGenerator($method, $timestamp, $buyParamJson = null)
    {
        $var = "360buy_param_json" . $buyParamJson . "access_token" . $this->accsessToken . "app_key" . $this->appKey . "method" . $method . "timestamp" . $timestamp . "v" . $this->v;
        $final = $this->appSecret . $var . $this->appSecret;
        return strtoupper(md5($final));
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
            // CURLOPT_CUSTOMREQUEST => $method,
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
