<?php

namespace App\Http\Controllers;

use App\Models\DirectSales;
use App\Http\Requests\UpdateDirectSalesRequest;
use App\Models\Atm;
use App\Models\DefaultPayment;
use App\Models\DirectSalesDetail;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\Reduce;
use Illuminate\Http\Request;
use Yajra\DataTables\Utilities\Request as UtilitiesRequest;

class DirectSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UtilitiesRequest $request)
    {
        $directSales = DirectSales::all();
        foreach ($directSales as $ds) {
            $dsDetails = DirectSalesDetail::where('direct_sales_id', $ds->id)->get();
            $ds->details = $dsDetails;
        }
        if ($request->ajax()) {
            return datatables()->of($directSales)->make(true);
        }
        // var_dump($directSales);
        return view(
            'transaction.index',
            [
                "title" => "Detail Transaksi Keluar",
                "menu" => "Transaksi",
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(UtilitiesRequest $request)
    {
        $products = Product::all();
        if ($request->ajax()) {
            return datatables()->of($products)->make(true);
        }
        $paymentType = PaymentType::all();
        $banks = Atm::all();
        // print($paymentType);
        // die();
        return view('transaction/direct_sales', [
            "title" => "Aplikasi Kasir",
            "menu" => "Transaksi",
            "payment" => $paymentType,
            "bank" => $banks,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDirectSalesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $code = "DS";
        $currDate = date("ymd");
        $n = 0;
        $n2 = "";
        $models = DirectSales::where('code', 'LIKE', "%{$currDate}%")->orderBy('code', 'desc')->take(1)->get();
        if (count($models) != 0) {
            $n2 = substr($models[0]->code, -4);
            $n2 = str_pad($n2 + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $n2 = str_pad($n + 1, 4, 0, STR_PAD_LEFT);
        }

        $fullCode = $code . "" . $currDate . "" . $n2;
        $ds = new DirectSales();
        $ds->code = $fullCode;
        $ds->customer_name = $request->customer_name;
        $ds->amount = $request->amount;
        $ds->discount = $request->discount;
        $ds->additional_discount = $request->additional_discount;
        $ds->cash = $request->cash;
        $ds->change = $request->change;
        $ds->subtotal = $request->subtotal;
        $ds->total_item = $request->total_item;
        $ds->created_by_id = auth()->user()->id;
        $ds->edit_by_id = auth()->user()->id;
        $ds->payment_type_id = $request->payment_type_id;
        $ds->reduce = $request->reduce;
        $ds->save();

        $details = [];
        for ($i = 0; $i < count($request->details); $i++) {
            $detail = new DirectSalesDetail();
            $detail->direct_sales_id = $ds["id"];
            $detail->product_id = $request->details[$i]["product_id"];
            $detail->price = $request->details[$i]["price"];
            $detail->qty = $request->details[$i]["qty"];
            $detail->discount = $request->details[$i]["discount"];
            $detail->subtotal = $request->details[$i]["subtotal"];
            $detail->save();
            array_push($details, $detail);
        }
        $ds->details = $details;
        return response()->json($ds);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DirectSales  $directSales
     * @return \Illuminate\Http\Response
     */
    public function show(DirectSales $directSales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DirectSales  $directSales
     * @return \Illuminate\Http\Response
     */
    public function edit(DirectSales $directSales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDirectSalesRequest  $request
     * @param  \App\Models\DirectSales  $directSales
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDirectSalesRequest $request, DirectSales $directSales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DirectSales  $directSales
     * @return \Illuminate\Http\Response
     */
    public function destroy(DirectSales $directSales)
    {
        //
    }
}
