<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
        if (!request('tab')) {
            return redirect()->to('product?tab=all&order=name&sort=asc');
        }
        $product = Product::with('stock');

        switch (request('tab')) {
            case 'active':
                $product->where('is_active', 1);
                break;
            case 'disactive':
                $product->where('is_active', 0);
                break;
            case 'empty-stock':
                $product = $this->getEmptyStock();
                break;
            default:
                $product;
                break;
        }

        if (request('search')) {
            $product->where('barcode', request('search'))
                ->orWhere('name', 'like', '%' . request('search') . '%');
        }
        if (request('order')) {
            if (request('order') == "value") {
                $product->with(['stock' => function ($q) {
                    $q->orderBy(request('order'), request('sort') ?? 'asc');
                }]);
            } else {
                $product->orderBy(request('order') ?? 'name', request('sort') ?? 'asc');
            }
        }
        $productRecord = $product->paginate(request('perpage') ?? 20)->withQueryString();
        $json = json_decode($productRecord->toJson());

        return view('master/product/product', [
            "title" => "Product",
            "menu" => "Master",
            "search" => request('search'),
            "products" => $productRecord,
            "tab" => [
                "all" => Product::count(),
                "active" => Product::where('is_active', 1)->count(),
                "disActive" => Product::where('is_active', 0)->count(),
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
    public function dataTable(UtilitiesRequest $request)
    {
        $product = Product::with('stock')->with(['program' => function ($query) {
            $query->with('multipleDiscount');
        }]);
        if ($request->ajax()) {
            return datatables()->of($product)->make(true);
        }
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
            $product2 = Product::where('id', $product['id'])->first();
            $stock = Stock::where('id', $product2->stock_id)->with('products')->first();
            $active = $stock->products->filter(function ($val) {
                return $val->is_active == 1;
            });
            if (count($active) > 0) {
                Stock::where('id', $stock->id)->update([
                    'is_active' => 1
                ]);
            } else {
                Stock::where('id', $stock->id)->update([
                    'is_active' => 0
                ]);
            }
        }
        return response()->json(true);
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
        $product = Product::where('barcode', $barcode)->with('stock')->with(['program' => function ($query) {
            $query->with('multipleDiscount');
        }])->first();

        if (isset($product)) {
            if ($product->is_active == 0) {
                return response()->json(['message' => 'Produk dengan code ' . $barcode . ' tidak aktif'], 400);
            }
            return response()->json($product);
        } else {
            return response()->json(['message' => 'Produk dengan code ' . $barcode . ' tidak tersedia'], 404);
        }
    }
    public function checkBarcode($barcode)
    {
        $product = Product::where('barcode', $barcode)->with('stock')->first();
        if (isset($product)) {
            if ($product->stock != null) {
                return response()->json(['message' => 'Barcode sudah terdaftar pada group ' . $product->stock->name ?? '---'], 400);
            }
        }
        return response()->json(true);
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

    public function getEmptyStock()
    {
        $listId = [];
        $products = Product::with('stock')->get();
        foreach ($products as $pr) {
            $value = ($pr->stock?->value ?? 0) / $pr->convertion;
            if ($value < 1) {
                array_push($listId, $pr->id);
            }
        }
        return Product::whereIn('id', $listId)->with('stock');
    }
}
