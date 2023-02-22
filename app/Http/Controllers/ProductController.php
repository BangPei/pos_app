<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Uom;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Utilities\Request as UtilitiesRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::orderBy('name', 'asc');
        if (request('search')) {
            $product->where('barcode', request('search'))
                ->orWhere('name', 'like', '%' . request('search') . '%');
        }

        return view('master/product/product', [
            "title" => "Product",
            "menu" => "Master",
            "search" => request('search'),
            "products" => $product->paginate(20)->withQueryString(),
            // "count" => count($product->get()),
            // "active" => count($product->where('is_active', true)->get()),
            // "disactive" => count($product->where('is_active', false)->get()),
        ]);
    }
    public function dataTable(UtilitiesRequest $request)
    {
        $product = Product::with(['stock', 'program' => function ($query) {
            $query->with('multipleDiscount');
        }]);
        if ($request->ajax()) {
            return datatables()->of($product)->make(true);
        }
    }

    public function mapping()
    {
        $products = Product::where('stock_id', "")->orWhere('stock_id', 0)->get();
        foreach ($products as $pr) {
            $stock = Stock::where('name', $pr->name)->first();
            if (isset($stock)) {
                Product::where('id', $pr->id)->update([
                    'stock_id' => $stock->id,
                ]);
            }
        }
        // return Redirect::to('product');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master/product/form', [
            "title" => "Product Form",
            "menu" => "Master",
            "categories" => Category::where('is_active', 1)->get(),
            "uoms" => Uom::all(),
            "stocks" => Stock::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = $request->validate(
            [
                'barcode' => 'required',
                'name' => 'required',
                'price' => 'required',
                'convertion' => 'required|numeric|min:1',
                'stock_id' => 'required',
                'category_id' => 'required',
                'uom_id' => 'required',
                'image' => 'image|file',
            ]
        );
        $product['is_active'] = true;
        if (isset($product['image'])) {
            $product['image'] = $request->file('image')->store('product');
        }
        $product['created_by_id'] = auth()->user()->id;
        $product['edit_by_id'] = auth()->user()->id;

        Product::create($product);

        return Redirect::to('product');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $product = new Product();
        if ($request->ajax()) {
            $product = Product::where('id', $request->id)->first();
        }
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('master/product/form', [
            "title" => "Product Form",
            "menu" => "Master",
            "categories" => Category::all(),
            "uoms" => Uom::all(),
            "stocks" => Stock::all(),
            "product" => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $product = $request->validate(
            [
                'barcode' => 'required',
                'name' => 'required',
                'price' => 'required',
                'convertion' => 'required|numeric|min:1',
                'stock_id' => 'required',
                'category_id' => 'required',
                'uom_id' => 'required',
                'image' => 'image|file',
            ]
        );
        $product['id'] = $request->input('id');
        $product['image'] = isset($product['image']) ? $request->file('image')->store('product') : null;
        Product::where('id', $product['id'])->update([
            'name' => $product['name'],
            'is_active' => $product['is_active'] = true,
            'image' => $product['image'],
            'edit_by_id' => auth()->user()->id,
            'barcode' => $product['barcode'],
            'price' => $product['price'],
            'convertion' => $product['convertion'],
            'stock_id' => $product['stock_id'],
            'category_id' => $product['category_id'],
            'uom_id' => $product['uom_id'],
        ]);
        session()->flash('message', 'Berhasil merubah satuan ' . $request['name']);
        // return Redirect::to("/product/" . $product['id'] . "/edit");
        return back();
    }
    public function changeStatus(Request $request)
    {
        $product = $request;
        if ($request->ajax()) {
            Product::where('id', $product['id'])->update([
                'is_active' => $product['is_active'],
                'edit_by_id' => auth()->user()->id,
            ]);
        }
        return response()->json($product);
    }
    public function updatePrice(Request $request)
    {
        $product = $request->validate(
            [
                'price' => 'required',
            ]
        );
        $product['id'] = $request->input('id');
        Product::where('id', $product['id'])->update([
            'price' => $product['price'],
        ]);
        return back();
    }
    public function barcode($barcode)
    {
        $product = new Product();
        $product = Product::where('barcode', $barcode)->with(['stock', 'program' => function ($query) {
            $query->with('multipleDiscount');
        }])->first();
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->is_active = $product->is_active == 1 ? 0 : 1;
        // $product['is_active'] = $product['is_active'] == 1 ? 0 : 1;
        // Product::where('barcode', $product->barcode)->update([
        //     'barcode' => $product->barcode,
        //     'name' => $product->name,
        //     'price' => $product->price,
        //     'category_id' => $product->category_id,
        //     'uom_id' => $product->uom_id,
        //     'description' => $product->description,
        //     'is_active' => $product->is_active,
        //     'created_by_id' => $product->created_by_id,
        //     'edit_by_id' => auth()->user()->id,
        // ]);
        print($product);
        die();
        return Redirect::to('product');
    }
}
