<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use NVuln\TiktokShop\Client;

class TiktokApiController extends Controller
{

    public $code = "ROW_jeXEnwAAAABTpmVYZgZzPSYDx8NQ2nU03QmO-I6A3xp-KURBbVLFHfd3eViLfJd-TkO_THb5reeybGK38MR6kdn1M6CrPAL2";
    public $apiKey = "67eui64gqqriu";
    public $shopId = "7494670387281169228";
    public $apiSecret = "da24ac38ba6931114cd43e7b49f1bd0a7ae2f2e1";
    public $refreshToken = "ROW_NWZiODljNGZmZDAzZTdkOGM2YzliYjgzNDM0NzE1YWQxYjcxMzgxOGM4MDZjYw";
    public $access_token = "ROW_8vEmEAAAAADn98JTwrilby-8D5Me_l6_131Prz0mSVzvo2SRiFr1N4zV1HJpfHiAYM5aUIaK84obf5al6NpnbTLYekbzDpA5h7Sjo7KkJsTRxVWdqTVppQ";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->getOrders();
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
        return $orders;
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
        return $fullOrder;
    }
    public function getShippingInfo()
    {
        $client = new Client($this->apiKey, $this->apiSecret);
        $client->setAccessToken($this->access_token);
        $client->setShopId($this->shopId);
        $orders = $client->Logistic->getShippingInfo("576892428622465293");
        return $orders;
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

    protected function prepareSignature($uri, $params)
    {
        $paramsToBeSigned = $params;
        $stringToBeSigned = '';

        // 1. Extract all query param EXCEPT ' sign ', ' access_token ', reorder the params based on alphabetical order.
        unset($paramsToBeSigned['sign'], $paramsToBeSigned['access_token']);
        ksort($paramsToBeSigned);

        // 2. Concat all the param in the format of {key}{value}
        foreach ($paramsToBeSigned as $k => $v) {
            if (!is_array($v)) {
                $stringToBeSigned .= "$k$v";
            }
        }

        // 3. Append the request path to the beginning
        $stringToBeSigned = $uri . $stringToBeSigned;

        // 4. Wrap string generated in step 3 with app_secret.
        $stringToBeSigned = $this->getAppSecret() . $stringToBeSigned . $this->apiSecret;

        // 7. Use sha256 to generate sign with salt(secret).
        $params['sign'] = hash_hmac('sha256', $stringToBeSigned, $this->apiSecret);
    }
}
