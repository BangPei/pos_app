<?php

namespace App\Http\Controllers;

use App\Models\DirectSales;
use App\Http\Requests\StoreDirectSalesRequest;
use App\Http\Requests\UpdateDirectSalesRequest;
use App\Models\Product;
use Yajra\DataTables\Utilities\Request as UtilitiesRequest;

class DirectSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UtilitiesRequest $request)
    {
        $products = Product::all();
        if ($request->ajax()) {
            return datatables()->of($products)->make(true);
        }
        return view('transaction/direct_sales', ["title" => "Aplikasi Kasir", "menu" => "Transaksi"]);
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
     * @param  \App\Http\Requests\StoreDirectSalesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDirectSalesRequest $request)
    {
        $ds = json_decode($request, true);
        var_dump($ds);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DirectSales  $directSales
     * @return \Illuminate\Http\Response
     */
    public function show(DirectSales $directSales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DirectSales  $directSales
     * @return \Illuminate\Http\Response
     */
    public function edit(DirectSales $directSales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDirectSalesRequest  $request
     * @param  \App\Models\DirectSales  $directSales
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDirectSalesRequest $request, DirectSales $directSales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DirectSales  $directSales
     * @return \Illuminate\Http\Response
     */
    public function destroy(DirectSales $directSales)
    {
        //
    }
}
