<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Stock;
use App\Models\Product;
use App\Models\TempTransaction;
use App\Models\Uom;
use Illuminate\Http\Request;

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
            "categories" => Category::all(),
            "uoms" => Uom::all(),
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
            'category' => 'required',
        ]);
        $stock['category_id'] = $stock['category']['id'];
        $stock['created_by_id'] = auth()->user()->id;
        $stock['edit_by_id'] = auth()->user()->id;
        if (!isset($request->products)) {
            return response()->json(['message' => 'Product Tidak Boleh Kosong'], 400);
        } else {
            $stock =  Stock::Create($stock);
            for ($i = 0; $i < count($request->products); $i++) {
                $product = new Product();
                $product->stock_id = $stock['id'];
                $product->uom_id = $request->products[$i]['uom']['id'];
                $product->convertion = $request->products[$i]['convertion'];
                $product->price = $request->products[$i]['price'];
                $product->barcode = $request->products[$i]['barcode'];
                $product->name = $request->products[$i]['name'];
                $product->is_active = $request->products[$i]['is_active'];
                $product->created_by_id = auth()->user()->id;
                $product->edit_by_id = auth()->user()->id;
                $product->save();
            }
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
            "stock" => $stock,
            "categories" => Category::all(),
            "uoms" => Uom::all(),
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
        $bool = true;
        if (count($stock->products) == 0) {
            return response()->json(['message' => 'Product Tidak Boleh Kosong'], 400);
        }
        $filter = array_filter($stock->products, function ($val) {
            return $val['is_active'] == 1;
        });
        $bool = count($filter) > 0 ? 1 : 0;
        Stock::where('id', $request->id)->update([
            'name' => $request->name,
            'value' => $request->value,
            'is_active' => $bool,
            'category_id' => $request->category['id'],
            'edit_by_id' => auth()->user()->id,
        ]);
        Product::where('stock_id', $stock['id'])->delete();
        // $products = [];
        for ($i = 0; $i < count($stock->products); $i++) {
            $product = new Product();
            $product->stock_id = $stock['id'];
            $product->uom_id = $stock->products[$i]['uom']['id'];
            $product->convertion = $stock->products[$i]['convertion'];
            $product->price = $stock->products[$i]['price'];
            $product->barcode = $stock->products[$i]['barcode'];
            $product->name = $stock->products[$i]['name'];
            $product->is_active = $stock->products[$i]['is_active'];
            $product->created_by_id = auth()->user()->id;
            $product->edit_by_id = auth()->user()->id;
            $product->save();
            // array_push($products, $product);
        }
        // $stock['products'] = $products;
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
        return back();
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

    public function changeStatus(Request $request)
    {
        $stock = $request;
        if ($request->ajax()) {
            Stock::where('id', $stock['id'])->update([
                'is_active' => $stock['is_active'],
                'edit_by_id' => auth()->user()->id,
            ]);

            Product::where('stock_id', $stock['id'])->update([
                'is_active' => $stock['is_active'],
                'edit_by_id' => auth()->user()->id,
            ]);
        }
        return response()->json($stock);
    }
}
