<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Requests\UpdateStockRequest;
use App\Models\Product;
use App\Models\TempTransaction;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use SebastianBergmann\Template\Template;

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
        return view('master/product/form-stock', [
            "title" => "Form Stock",
            "menu" => "Master",
        ]);
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
        $stock =  Stock::Create($stock);
        if (isset($request->products)) {
            $products = [];
            for ($i = 0; $i < count($request->products); $i++) {
                $Product = Product::where('id', $request->products[$i]['id'])->update([
                    'stock_id' => $stock['id']
                ]);
                array_push($products, $Product);
            }
            $stock['products'] = $products;
        }
        session()->flash('message', 'Berhasil Menambah group Stock ' . $stock['name']);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $stock = new Stock();
        if ($request->ajax()) {
            $stock = Stock::where('id', $request->id)->with('products')->first();
        }
        return response()->json($stock);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        $stock = Stock::where('id', $stock->id)->with('products')->first();
        return view('master/product/form-stock', [
            "title" => "Form Stock",
            "menu" => "Master",
            "stock" => $stock
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStockRequest  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $stock = $request;
        Stock::where('id', $request->id)->update([
            'name' => $request->name,
            'value' => $request->value,
            'edit_by_id' => auth()->user()->id,
        ]);
        Product::where('stock_id', $stock['id'])->update([
            'stock_id' => null
        ]);
        $products = [];
        for ($i = 0; $i < count($stock->products); $i++) {
            $Product = Product::where('id', $stock->products[$i]['id'])->update([
                'stock_id' => $stock['id']
            ]);
            array_push($products, $Product);
        }
        $stock['products'] = $products;
        return response()->json($stock);
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
    public function delete()
    {
        TempTransaction::where('user_id', auth()->user()->id)->delete();
    }

    public function updateStock(Request $request)
    {
        $stock = $request->validate(
            [
                'value' => 'required',
            ]
        );
        $stock['id'] = $request->input('id');
        $convertion = $request->input('convertion');
        if ($convertion != NULL) {
            Stock::where('id', $stock['id'])->update([
                'value' => (int)$stock['value'] * $request->input('convertion'),
            ]);
        } else {
            Stock::where('id', $stock['id'])->update([
                'value' => (int)$stock['value'],
            ]);
        }
        return back();
    }
}
