<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OnlineShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class OnlineShopeApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->active();
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
    public function active()
    {
        $onlineShop = OnlineShop::where('is_active', 1)->get();
        foreach ($onlineShop as $ol) {
            $ol->logo = asset('image/logo/' . strtolower($ol->name) . '.png');
            $ol->icon = asset('image/icon/' . strtolower($ol->name) . '.png');
        };
        return response()->json($onlineShop);
    }
}
