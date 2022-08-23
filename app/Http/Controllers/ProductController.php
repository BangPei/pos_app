<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
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
    public function index(UtilitiesRequest $request)
    {
        $products = Product::all();
        if ($request->ajax()) {
            return datatables()->of($products)->make(true);
        }
        return view('master/product/product', ["title" => "Product", "menu" => "Master",]);
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
            "categories" => Category::all(),
            "uoms" => Uom::all(),
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
        $product = $request->validate([
            'barcode' => 'required',
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'uom_id' => 'required',
            'description' => '',
            'created_by_id' => '',
            'edit_by_id' => '',
        ]);

        // $product['slug'] = Str::lower($product['name']);
        // $product['slug'] = str_replace(' ', '-', $product['slug']);
        $product['price'] = floatval(str_replace(',', '', $product['price']));
        $product['created_by_id'] = auth()->user()->id;
        $product['edit_by_id'] = auth()->user()->id;
        Product::Create($product);
        session()->flash('message', $product['name'] . ' Berhasil disimpan.');
        return Redirect::to('/product/create');
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
            $product = Product::where('barcode', $request->barcode)->first();
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
        $product = $request->validate([
            'barcode' => 'required',
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'uom_id' => 'required',
            'description' => '',
        ]);

        $product['price'] = floatval(str_replace(',', '', $product['price']));
        $product['edit_by_id'] = auth()->user()->id;
        Product::where('barcode', $product['barcode'])->update([
            'name' => $product['name'],
            'barcode' => $product['barcode'],
            'price' => $product['price'],
            'category_id' => $product['category_id'],
            'uom_id' => $product['uom_id'],
            'description' => $product['description'],
            'edit_by_id' => $product['edit_by_id'],
        ]);
        session()->flash('message', 'Berhasil merubah ' . $product['name']);
        return Redirect::to('/product' . '/' . $product['barcode'] . '/' . 'edit');
    }
    public function changeStatus(Request $request)
    {
        $product = $request;
        $product['edit_by_id'] = auth()->user()->id;
        if ($request->ajax()) {
            Product::where('barcode', $product['barcode'])->update([
                'name' => $product['name'],
                'barcode' => $product['barcode'],
                'is_active' => $product['is_active'],
                'price' => $product['price'],
                'category_id' => $product['category_id'],
                'uom_id' => $product['uom_id'],
                'description' => $product['description'],
                'edit_by_id' => $product['edit_by_id'],
            ]);
        }
        return response()->json($product);
        // return Redirect::to('/product' . '/' . $product['barcode'] . '/' . 'edit');
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
