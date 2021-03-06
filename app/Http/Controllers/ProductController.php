<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Uom;
use GuzzleHttp\Promise\Create;
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
            'created_by' => '',
            'edit_by' => '',
        ]);

        // $product['slug'] = Str::lower($product['name']);
        // $product['slug'] = str_replace(' ', '-', $product['slug']);
        $product['price'] = floatval(str_replace(',', '', $product['price']));
        $product['created_by'] = auth()->user()->id;
        $product['edit_by'] = auth()->user()->id;
        Product::Create($product);
        return Redirect::to('product');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
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
    public function update(Request $request, $id)
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
        $product['edit_by'] = auth()->user()->id;
        Product::where('barcode', $product['barcode'])->update([
            'name' => $product['name'],
            'barcode' => $product['barcode'],
            'price' => $product['price'],
            'category_id' => $product['category_id'],
            'uom_id' => $product['uom_id'],
            'description' => $product['description'],
            'edit_by' => $product['edit_by'],
        ]);
        return Redirect::to('product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product['is_active'] = $product['is_active'] == 1 ? 0 : 1;
        Product::where('barcode', $product->barcode)->update([
            'barcode' => $product->barcode,
            'name' => $product->name,
            'price' => $product->price,
            'category_id' => $product->category_id,
            'uom_id' => $product->uom_id,
            'description' => $product->description,
            'is_active' => $product->is_active,
            'created_by' => $product->created_by,
            'edit_by' => $product->edit_by,
        ]);
        return Redirect::to('product');
    }
}
