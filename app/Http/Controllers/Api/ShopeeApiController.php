<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ShopeeApiController extends Controller
{

    public $accessToken = "7768646e6e7a55727479535144594670";
    public $refreshToken = "5a63685568424b646a5872706f587773";
    public $partner_id = 2005013;
    public $host = "https://partner.shopeemobile.com";
    public $partner_key = "4b69516851696d63516958464c745877696d7770697348666870474355745774";
    public $shop_id = 285374341;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getOrders()
    {

        $create_time = Carbon::now()->subDays(4)->format('c');
        $time_from = Carbon::now()->subDay(60 * 60 * 24 * 3)->format('c');
        $timestamp = time();
        $path = "/api/v2/order/get_order_list";
        $sign = hash_hmac('sha256', utf8_encode($this->partner_id . $path . $timestamp), $this->partner_key);
        $url = $this->host . $path . '?timestamp=' . $timestamp . '&partner_id=' . $this->partner_id . '&sign=' . $sign . '&access_token=' . $this->accessToken . '&shop_id=' . $this->shop_id . '&page_size=100&time_from=' . $time_from . '$time_to=' . time();

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
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
}
