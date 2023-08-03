<?php

namespace App\Http\Controllers;

use App\Models\OnlineShop;
use App\Http\Requests\StoreOnlineShopRequest;
use App\Http\Requests\UpdateOnlineShopRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Utilities\Request as UtilitiesRequest;

class OnlineShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UtilitiesRequest $request)
    {
        $platform  = OnlineShop::query();
        if ($request->ajax()) {
            return datatables()->of($platform)->make(true);
        }
        return view('online_shop/platform/index', ["title" => "Platform", "menu" => "Online Shop",]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOnlineShopRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOnlineShopRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OnlineShop  $onlineShop
     * @return \Illuminate\Http\Response
     */
    public function show(OnlineShop $onlineShop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OnlineShop  $onlineShop
     * @return \Illuminate\Http\Response
     */
    public function edit(OnlineShop $onlineShop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOnlineShopRequest  $request
     * @param  \App\Models\OnlineShop  $onlineShop
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOnlineShopRequest $request, OnlineShop $onlineShop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OnlineShop  $onlineShop
     * @return \Illuminate\Http\Response
     */
    public function destroy(OnlineShop $onlineShop)
    {
        //
    }

    public function changeStatus(Request $request)
    {
        try {
            OnlineShop::where('id', $request['id'])->update([
                'is_active' => $request['is_active'],
                'name' => $request['name'],
                'logo' => $request['logo'],
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
