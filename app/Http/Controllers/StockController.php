<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Requests\UpdateStockRequest;
use App\Models\Product;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stock = Stock::orderBy('name', 'asc')->with('products');
        if (request('search')) {
            if (request('search-type') == "name") {
                $stock->where('name', 'like', '%' . request('search') . '%');
            } else {
                $product = Product::where('barcode', request('search'))->first();
                if (isset($product->stock_id)) {
                    $stock->where('id', $product->stock_id);
                } else {
                    $stock->where('name', request('search'));
                }
            }
        }
        return view('master/product/product-stock', [
            "title" => "Stock",
            "menu" => "Master",
            "search" => request('search'),
            "count" => count($stock->get()),
            "stocks" => $stock->paginate(20)->withQueryString()
        ]);
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
     * @param  \App\Http\Requests\StoreStockRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stock = $request->validate([
            'name' => 'required',
            'value' => 'required',
        ]);
        $stock['created_by_id'] = auth()->user()->id;
        $stock['edit_by_id'] = auth()->user()->id;
        Stock::Create($stock);
        session()->flash('message', 'Berhasil Menambah group Stock ' . $stock['name']);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStockRequest  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStockRequest $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $stock = Stock::find($request->input('stock-id'));
        $stock->delete();
        return Redirect::to('/stock');
    }
    public function delete(Request $request)
    {
        $stock = Stock::find($request->input('stock-id'));
        $stock->delete();
        return back();
    }

    public function updateStock(Request $request)
    {
        $stock = $request->validate(
            [
                'value' => 'required',
            ]
        );
        $stock['id'] = $request->input('id');
        Stock::where('id', $stock['id'])->update([
            'value' => (int)$stock['value'] * $request->input('convertion'),
        ]);
        // return back();
    }
}
