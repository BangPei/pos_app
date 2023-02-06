<?php

namespace App\Http\Controllers;

use App\Models\DirectSales;
use App\Http\Requests\UpdateDirectSalesRequest;
use App\Models\Atm;
use App\Models\DirectSalesDetail;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
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
        if ($request->ajax()) {
            return datatables()->of($directSales)->make(true);
        }
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
        $paymentType = PaymentType::where('is_active', 1)->get();
        $banks = Atm::where('is_active', 1)->get();
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
        $ds->is_cash = $request->is_cash;
        $ds->bank_id = $request->bank_id;
        $ds->save();

        $details = [];
        for ($i = 0; $i < count($request->details); $i++) {
            $detail = new DirectSalesDetail();
            $detail->direct_sales_id = $ds["id"];
            $detail->item_convertion_barcode = $request->details[$i]["product"]['barcode'];
            $detail->price = $request->details[$i]["price"];
            $detail->qty = $request->details[$i]["qty"];
            $detail->product_name = $request->details[$i]["product_name"];
            $detail->discount = $request->details[$i]["discount"];
            $detail->program = $request->details[$i]["program"];
            $detail->subtotal = $request->details[$i]["subtotal"];
            $detail->save();
            array_push($details, $detail);
        }
        // $ds->details = $details;
        $ds = DirectSales::where('id', $ds->id)->first();

        $connector = new WindowsPrintConnector("cashier_dev");
        $printer = new Printer($connector);

        // $img = EscposImage::load("{{assets('/image/logo/logo.png')}}");
        // $printer->graphics($img, 20);
        $printer->selectPrintMode(Printer::MODE_FONT_B | Printer::MODE_DOUBLE_HEIGHT);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Toko SS Bumi Indah\n");
        $printer->selectPrintMode();
        $printer->feed();
        $testStr = $ds->code;
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        // $printer->pdf417Code($testStr);
        $printer->text("NO Trans : " . $testStr . "\n");
        $printer->text("Tanggal : " . date('d-m-Y H:i:s', time()) . "\n");
        $printer->text("Kasir : " . auth()->user()->name . "\n");
        for ($i = 1; $i < 33; $i++) {
            $printer->text("_");
        }
        $printer->text("\n");
        foreach ($ds['details'] as $detail) {
            $printer->setJustification();
            $printer->text($detail->product_name . "\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text($detail->price . " x " . $detail->qty . " = " . $detail->subtotal . "\n");
            $printer->setJustification();
        }
        $printer->setLineSpacing();
        for ($i = 1; $i < 33; $i++) {
            $printer->text("_");
        }
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text("Subtotal : " . $ds->subtotal . "\n");
        $printer->text("Total Qty : " . $ds->total_item . "\n");
        $printer->text("Diskon 1 : " . $ds->discount . "\n");
        $printer->text("Diskon 2 : " . $ds->additional_discount . "\n");
        $printer->text("Total : " . $ds->amount . "\n");
        for ($i = 1; $i < 33; $i++) {
            $printer->text("_");
        }
        $printer->text("Cash : " . $ds->cash . "\n");
        $printer->text("Kembalian : " . $ds->change . "\n");
        for ($i = 1; $i < 33; $i++) {
            $printer->text("_");
        }
        $printer->selectPrintMode(Printer::MODE_FONT_B);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Terimakasih !!!\n");
        $printer->text("Selamat Berbelanja Kembali !!!\n");
        $printer->feed(5);
        $printer->cut();
        $printer->close();
        return response()->json($ds);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DirectSales  $directSales
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $directSales = new DirectSales();
        if ($request->ajax()) {
            $directSales = DirectSales::where('code', $request->code)->first();
        }
        return response()->json($directSales);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DirectSales  $directSales
     * @return \Illuminate\Http\Response
     */
    public function edit($code)
    {
        $directSales = DirectSales::where('code', $code)->first();
        $paymentType = PaymentType::where('is_active', 1)->get();
        $banks = Atm::where('is_active', 1)->get();
        return view('transaction/direct_sales', [
            "title" => "Aplikasi Kasir",
            "menu" => "Transaksi",
            "payment" => $paymentType,
            "bank" => $banks,
            'directSales' => $directSales,
        ]);
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
