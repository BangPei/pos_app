<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Uom;
use Exception;
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
                'convertion' => 'required',
                'stock_id' => 'required',
                'category_id' => 'required',
                'uom_id' => 'required',
                'image' => '',
            ]
        );

        $product['is_active'] = true;
        if (isset($product['image'])) {
            $product['image'] = $request->file('image')->store('product-image');
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
            "uoms" => Stock::all(),
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
        try {
            $product = $request;
            if ($request->ajax()) {
                Product::where('id', $product['id'])->update([
                    'name' => $product['name'],
                    'category_id' => $product['category']['id'],
                    'edit_by_id' => auth()->user()->id,
                    'is_active' => $product['is_active'] ? 1 : 0,
                ]);
            }
            return response()->json($product);
        } catch (Exception $e) {
            print($e);
        }
    }
    public function changeStatus(Request $request)
    {
        $product = $request;
        if ($request->ajax()) {
            Product::where('id', $product['id'])->update([
                'name' => $product['name'],
                'is_active' => $product['is_active'] ? 1 : 0,
                'category_id' => $product['category_id'],
                'edit_by_id' => auth()->user()->id,
            ]);
        }
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
