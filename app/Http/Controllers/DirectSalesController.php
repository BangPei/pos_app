<?php

namespace App\Http\Controllers;

use App\Models\DirectSales;
use App\Http\Requests\UpdateDirectSalesRequest;
use App\Models\Atm;
use App\Models\DirectSalesDetail;
use App\Models\PaymentType;
use App\Models\Stock;
use App\Models\TempTransaction;
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

    public $printer = "cashier_pos";
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
        $ds->date = $request->date;
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
        $ds->reduce_value = $request->reduce_value;
        $ds->save();

        $details = [];
        for ($i = 0; $i < count($request->details); $i++) {
            $detail = new DirectSalesDetail();
            $detail->direct_sales_id = $ds["id"];
            $detail->product_barcode = $request->details[$i]["product"]['barcode'];
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

        $connector = new WindowsPrintConnector($this->printer);
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
        $timestamp = strtotime($ds->date);
        $printer->text("Tanggal : " . date('d-m-Y H:i:s', $timestamp) . "\n");
        $printer->text("Kasir : " . auth()->user()->name . "\n");
        if (isset($ds->customer_name)) {
            $printer->text("Pembeli : " . $ds->customer_name . "\n");
        }
        for ($i = 1; $i < 33; $i++) {
            $printer->text("_");
        }
        foreach ($ds['details'] as $detail) {
            $printer->text($detail->product_name . "\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text(number_format($detail->price, 0, ',', ',') . " x " . number_format($detail->qty, 0, ',', ',') . " = " . number_format($detail->subtotal, 0, ',', ',') . "\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
        }
        for ($i = 1; $i < 33; $i++) {
            $printer->text("_");
        }
        $printer->feed();
        $printer->initialize();
        $printer->text($this->textPos("Total Qty", "(" . number_format($ds->total_item, 0, ',', ',') . ")"));
        $printer->text($this->textPos("Subtotal", number_format($ds->subtotal, 0, ',', ',')));
        $printer->text($this->textPos("Diskon 1", number_format($ds->discount, 0, ',', ',')));
        $printer->text($this->textPos("Diskon 2", number_format($ds->additional_discount, 0, ',', ',')));
        if ($ds->reduce !== 0) {
            $printer->text($this->textPos("Biaya Kartu (" . $ds->reduce . "%)", number_format($ds->reduce_value, 0, ',', ',')));
        }
        $printer->text($this->textPos("Total", number_format($ds->amount, 0, ',', ',')));
        for ($i = 1; $i < 33; $i++) {
            $printer->text("_");
        }
        if ($ds->paymentType->show_cash) {
            $printer->text($this->textPos("Cash", number_format($ds->cash, 0, ',', ',')));
            $printer->text($this->textPos("Kembalian", number_format($ds->change, 0, ',', ',')));
            for ($i = 1; $i < 33; $i++) {
                $printer->text("=");
            }
        }
        $printer->feed();
        $printer->initialize();
        $printer->selectPrintMode(Printer::MODE_FONT_B);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("Terimakasih !!!\n");
        $printer->text("Selamat Berbelanja Kembali !!!\n");
        $printer->feed(5);
        $printer->cut();
        $printer->close();
        return response()->json($ds);
    }

    public function printPrice(Request $request)
    {
        $connector = new WindowsPrintConnector($this->printer);
        $printer = new Printer($connector);
        $printer->selectPrintMode(Printer::MODE_FONT_B | Printer::MODE_DOUBLE_HEIGHT);
        $printer->text("Toko SS Bumi Indah\n");
        $printer->selectPrintMode();
        for ($i = 1; $i < 33; $i++) {
            $printer->text("_");
        }
        $printer->feed();
        $printer->selectPrintMode(Printer::MODE_FONT_B | Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text("RP. " . $request->price);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->feed();
        $printer->initialize();
        $printer->selectPrintMode(Printer::MODE_FONT_B | Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);
        $printer->text($request->name);
        $printer->setTextSize(8, 4);
        $printer->feed(5);
        $printer->cut();
        $printer->close();
        return response()->json($request);
    }

    function textPos($leftStr, $rightStr, $fontSize = 1)
    {
        $maxChar = (int)(32 / $fontSize);
        $emptySpace = $maxChar - strlen($leftStr) - strlen($rightStr);
        $space = str_repeat(' ', $emptySpace);
        return $leftStr . $space . $rightStr;
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

    public function stock(Request $request)
    {
        $stock = Stock::where('id', $request['stock_id'])->first();
        $tempTrans = TempTransaction::where(
            [
                ['stock_id', $request['stock_id']],
                // ['user_id', auth()->user()->id]
            ]
        )->get();
        if (count($tempTrans) > 0) {
            $tmpVal = 0;
            foreach ($tempTrans as $trans) {
                $tmpVal = $tmpVal + ($trans->qty * $trans->convertion);
            }

            $outValue = ($request->qty * $request->convertion) + $tmpVal;
            $value = $stock->value - $outValue;
            if ($value < 0) {
                return response()->json(['message' => "Stock Tidak Cukup"], 500);
            } else {
                if ($this->myArrayContainsWord($tempTrans, $request['product_id'])) {
                    $trans = TempTransaction::where(
                        [
                            ['stock_id', $request['stock_id']],
                            ['product_id', $request['product_id']],
                            ['user_id', auth()->user()->id]
                        ]
                    )->first();
                    $trans->qty = $request->qty + $trans->qty;
                    $trans->update();
                } else {
                    $this->postNewStock($stock, $request);
                }
                return response()->json($tempTrans);
            }
        } else {
            $this->postNewStock($stock, $request);
        }
        // return response()->json($tempTrans);
        // $stock = Stock::where('id', $request['stock_id'])->first();
        // if ($request->param == "min") {
        //     $value = $stock->value - ($request->qty * $request->convertion);
        // } else {
        //     $value = $stock->value + ($request->qty * $request->convertion);
        // }
        // if ($value < 0) {
        //     return response()->json(['message' => "Stock Tidak Cukup"], 500);
        // } else {
        //     $stock->value = $value;
        //     $stock = Stock::where('id', $stock['id'])->update([
        //         'value' => (int)$stock['value'],
        //     ]);
        //     return response()->json($stock);
        // }
    }

    private function myArrayContainsWord($myArray, $word)
    {
        foreach ($myArray as $element) {
            if (
                $element->product_id == $word ||
                (!empty($myArray['product_id']) && $this->myArrayContainsWord($myArray['product_id'], $word))
            ) {
                return true;
            }
        }
        return false;
    }
    private function postNewStock($stock, $request)
    {
        $outValue = $request->qty * $request->convertion;
        $value = $stock->value - $outValue;
        if ($value < 0) {
            return response()->json(['message' => "Stock Tidak Cukup"], 500);
        } else {
            $tempTran = new TempTransaction();
            $tempTran->qty = $request->qty;
            $tempTran->convertion = $request->convertion;
            $tempTran->stock_id = $request->stock_id;
            $tempTran->product_id = $request->product_id;
            $tempTran->user_id = auth()->user()->id;
            $tempTran->save();
            return response()->json($tempTran);
        }
    }
}
