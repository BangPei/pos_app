<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ItemConvertion;
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
        $product = new Product();
        $product->barcode = $request->barcode;
        $product->name = $request->name;
        $product->category_id = $request->category['id'];
        $product->created_by_id = auth()->user()->id;
        $product->edit_by_id = auth()->user()->id;
        $product->save();

        $itemConvertion = [];
        for ($i = 0; $i < count($request->items_convertion); $i++) {
            $Convertion = new ItemConvertion();
            $Convertion->product_id =  $product['id'];
            $Convertion->barcode =  $request->items_convertion[$i]["barcode"];
            $Convertion->name =  $request->items_convertion[$i]["name"];
            $Convertion->qtyConvertion =  $request->items_convertion[$i]["qtyConvertion"];
            $Convertion->price =  $request->items_convertion[$i]["price"];
            $Convertion->uom_id =  $request->items_convertion[$i]["uom"]['id'];
            // $Convertion->save();
            array_push($itemConvertion, $Convertion);
        }
        $product->itemsConvertion()->saveMany($itemConvertion);
        $product->items_convertion = $itemConvertion;
        return response()->json($product);
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
        $product = $request;

        Product::where('barcode', $product['barcode'])->update([
            'name' => $product['name'],
            'barcode' => $product['barcode'],
            'category_id' => $product['category']['id'],
            'edit_by_id' => auth()->user()->id,
        ]);
        ItemConvertion::where('product_id', $product['id'])->delete();
        $itemConvertion = [];
        for ($i = 0; $i < count($request->items_convertion); $i++) {
            $Convertion = new ItemConvertion();
            $Convertion->product_id =  $product['id'];
            $Convertion->barcode =  $request->items_convertion[$i]["barcode"];
            $Convertion->name =  $request->items_convertion[$i]["name"];
            $Convertion->qtyConvertion =  $request->items_convertion[$i]["qtyConvertion"];
            $Convertion->price =  $request->items_convertion[$i]["price"];
            $Convertion->uom_id =  $request->items_convertion[$i]["uom"]['id'];
            $Convertion->save();
            array_push($itemConvertion, $Convertion);
        }

        $product->items_convertion = $itemConvertion;
        return response()->json($product);
    }
    public function changeStatus(Request $request)
    {
        $product = $request;
        if ($request->ajax()) {
            Product::where('barcode', $product['barcode'])->update([
                'name' => $product['name'],
                'barcode' => $product['barcode'],
                'is_active' => $product['is_active'],
                'category_id' => $product['category_id'],
                'edit_by_id' => auth()->user()->id,
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
