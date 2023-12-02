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
        switch (request('tab')) {
            case 'active':
                $stock = Stock::where('is_active', 1)->orderBy(request('order') ?? 'name', request('sort') ?? 'asc')->with('products');
                break;
            case 'disactive':
                $stock = Stock::where('is_active', 0)->orderBy(request('order') ?? 'name', request('sort') ?? 'asc')->with('products');
                break;
            case 'empty-stock':
                $stock = $this->getEmptyStock(request('order') ?? 'name', request('sort') ?? 'asc');
                break;
            default:
                $stock = Stock::orderBy(request('order') ?? 'name', request('sort') ?? 'asc')->with('products');
                break;
        }

        if (request('search')) {
            $products = Product::where('barcode', request('search'))
                ->orWhere('name', 'like', "%" . request('search') . "%")
                ->get();
            $listId = [];
            for ($i = 0; $i < count($products); $i++) {
                array_push($listId, $products[$i]->stock_id);
            }
            $stock->whereIn('id', $listId);
        }
        $count = $stock->count();
        $stockRecord = $stock->paginate(request('perpage') ?? 20)->withQueryString();
        $json = json_decode($stockRecord->toJson());

        return view('master/product/product-stock', [
            "title" => "Stock",
            "menu" => "Master",
            "count" => $count,
            "stocks" => $stockRecord,
            "tab" => [
                "all" => Stock::count(),
                "active" => Stock::where('is_active', 1)->count(),
                "disActive" => Stock::where('is_active', 0)->count(),
                "empty-stock" => $this->getEmptyStock()->count(),
            ],
            "query" => [
                'tab' => request('tab'),
                "search" => request('search'),
                "order" => request('order'),
                "sort" => request('sort'),
                "perpage" => request('perpage'),
            ],
            "page" => [
                "total" => $json->total,
                "per_page" => $json->per_page,
                "current_page" => $json->current_page,
                "last_page" => $json->last_page,
                "from" => $json->from,
                "to" => $json->to,
            ]
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

    public function getEmptyStock($order = "name", $sort = "asc")
    {
        $listId = [];
        $products = Product::with('stock')->get();
        foreach ($products as $pr) {
            $value = ($pr->stock?->value ?? 0) / $pr->convertion;
            if ($value < 1) {
                array_push($listId, $pr->stock_id);
            }
        }
        return Stock::whereIn('id', $listId)->orderBy($order, $sort)->with('products');
    }
}
