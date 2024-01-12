<?php

namespace App\Http\Controllers;

use App\Models\DirectSales;
use App\Models\Atm;
use App\Models\DirectSalesDetail;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\Stock;
use App\Models\TempTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
        $directSales = DirectSales::query();
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
    public function groupByMonth()
    {
        $year = date('Y', time());
        $currDs  = $this->getDataByMonth($year);
        $prevDs  = $this->getDataByMonth($year - 1);
        $currTotal = 0;
        $prevTotal = 0;
        for ($i = 0; $i < count($currDs); $i++) {
            $currTotal = $currDs[$i]['amount'] + $currTotal;
        }
        for ($i = 0; $i < count($prevDs); $i++) {
            $ds = $prevDs[$i];
            $prevTotal =$prevTotal+ $ds['amount'];
        }
        return [
            $year => $currDs,
            ($year - 1) => $prevDs,
            'total' . $year => $currTotal,
            'total' . ($year - 1) => $prevTotal
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

    private function dsCode()
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
        return $fullCode;
    }

    public function store(Request $request)
    {

        $ds = new DirectSales();
        $ds->code = $this->dsCode();
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
            $stock = Stock::where('id', $request->details[$i]["product"]['stock']['id'])->first();
            $detail = new DirectSalesDetail();
            $detail->direct_sales_id = $ds["id"];
            $detail->product_barcode = $request->details[$i]["product"]['barcode'];
            $detail->price = $request->details[$i]["price"];
            $detail->qty = $request->details[$i]["qty"];
            $detail->product_name = $request->details[$i]["product_name"];
            $detail->discount = $request->details[$i]["discount"];
            $detail->program = $request->details[$i]["program"];
            $detail->subtotal = $request->details[$i]["subtotal"];
            $detail->convertion = $request->details[$i]["convertion"];
            $detail->uom = $request->details[$i]["uom"] ?? "";
            $detail->category = $request->details[$i]["category"] ?? "";
            $detail->save();
            Stock::where('id', $request->details[$i]["product"]['stock']['id'])->update([
                'value' => $stock->value - ($detail->convertion * $detail->qty),
            ]);
            array_push($details, $detail);
        }
        // $ds->details = $details;
        $ds = DirectSales::where('id', $ds->id)->first();
        TempTransaction::where('user_id', auth()->user()->id)->delete();

        if ($request->isPrinted) {
            $this->printReceipt($ds);
        }
        return response()->json($ds);
    }

    public function randomTransaction()
    {

        $listProductName = [
            'milna', 'prenagen', 'morinaga', 'chil go', 'nutrive', 'benecol', 'zee', 'diabetasol',
            "BMT", 'chilmil', 'chil mil', 'chilkid', "chil kid", 'chil school', 'chilschool', 'fitbar',
            'entrasol',
        ];
        $morinaga = [
            'morinaga', 'chil go', "BMT", 'chilmil', 'chil mil', 'chilkid',
            "chil kid", 'chil school', 'chilschool'
        ];

        $listDiscount = [
            //chil school gold 800-1600 gr
            ["barcode" => "8992802180047", 'discount' => 10000],
            ["barcode" => "8992802001137", 'discount' => 10000],
            ["barcode" => "8992802180085", 'discount' => 10000],
            ["barcode" => "8992802180030", 'discount' => 10000],
            ["barcode" => "8992802001144", 'discount' => 14000],
            ["barcode" => "8992802001151", 'discount' => 14000],

            //chil kid gold 800-1600 gr
            ["barcode" => "8992802003032", 'discount' => 14000],
            ["barcode" => "8992802003049", 'discount' => 14000],
            ["barcode" => "8992802180153", 'discount' => 10000],
            ["barcode" => "8992802180146", 'discount' => 10000],
        ];
        $products = [];
        for ($i = 0; $i < count($listProductName); $i++) {
            $product = Product::where('name', 'LIKE', '%' . $listProductName[$i] . '%')->where('is_active', 1)->where('price', '>', 0)->get();
            if (count($product) > 0) {
                for ($j = 0; $j < count($product); $j++) {
                    array_push($products, $product[$j]);
                }
            }
        }

        $morinagas = [];
        for ($i = 0; $i < count($morinaga); $i++) {
            $product = Product::where('name', 'LIKE', '%' . $morinaga[$i] . '%')->where('is_active', 1)->where('price', '>', 0)->get();
            if (count($product) > 0) {
                for ($j = 0; $j < count($product); $j++) {
                    array_push($morinagas, $product[$j]);
                }
            }
        }
        $arrDs = [];
        for ($i = 0; $i < 1; $i++) {
            $ds = $this->setRandomTrans($products, $listDiscount, $morinagas);
            $this->printReceipt($ds);
            array_push($arrDs, $ds);
        }
        return  Response()->json($arrDs);
    }

    private function setRandomTrans($products, $listDiscount, $morinagas)
    {
        $more = true;

        $strDate = [];
        $strHours = [];
        $minutes = [];
        $seconds = [];
        for ($i = 1; $i <= 31; $i++) {
            $str = $i < 10 ? "0" . $i : "" . $i . "";
            array_push($strDate, date('Y-m-' . $str));
        }
        for ($i = 8; $i <= 21; $i++) {
            $str = $i < 10 ? "0" . $i : "" . $i . "";
            array_push($strHours, $str);
        }
        for ($i = 0; $i <= 59; $i++) {
            $str = $i < 10 ? "0" . $i : "" . $i . "";
            array_push($minutes, $str);
        }
        for ($i = 0; $i <= 59; $i++) {
            $str = $i < 10 ? "0" . $i : "" . $i . "";
            array_push($seconds, $str);
        }

        //to get random array index from list
        $k = array_rand($strDate);
        $v = $strDate[$k];

        $j = array_rand($strHours);
        $i = $strHours[$j];

        $s = array_rand($minutes);
        $m = $minutes[$s];

        $ss = array_rand($seconds);
        $cs = $seconds[$ss];

        $ds = new DirectSales();
        $ds->code = str_replace("-", "", "DS" . ltrim($v, "2") . random_int(1000, 9999));
        $ds->date = $v . " " . $i . ":" . $m . ":" . $cs;
        $ds->customer_name = "--";
        $ds->discount = 0;
        $ds->additional_discount = 25000;
        $ds->subtotal = 0;
        $ds->amount = 0;
        $ds->cash = 0;
        $ds->change = 0;
        $ds->total_item = 0;
        $ds->created_by_id = auth()->user()->id;
        $ds->edit_by_id = auth()->user()->id;
        $ds->payment_type_id = 3;
        $ds->reduce = 0;
        $ds->is_cash = 1;
        $ds->bank_id = null;
        $ds->reduce_value = 0;

        $details = [];
        while ($more) {
            $pr = $products[array_rand($products)];
            $barcode = $pr['barcode'];
            $detail = new DirectSalesDetail();
            $detail->direct_sales_id = $ds["id"];
            $detail->product_barcode = $barcode;
            $detail->price = $pr->price;
            $detail->qty = 1;
            $detail->product_name = $pr['name'];
            $detail->discount = 0;
            $detail->program = 0;
            $detail->subtotal = $pr->price;
            $detail->convertion = $pr['convertion'];
            $detail->uom = '';
            $detail->category = "";
            for ($i = 0; $i < count($listDiscount); $i++) {
                $discount = $listDiscount[$i];
                if ($barcode == $discount['barcode']) {
                    $detail->discount = $discount['discount'];
                    $ds->discount = $ds->discount + $detail->discount;
                }
            }
            if (count($details) == 0) {
                $ds->total_item = $ds->total_item + $detail->qty;
                $ds->subtotal = $ds->subtotal + $detail->subtotal;
                array_push($details, $detail);
            } else {
                if (!($this->checkBarcode($details, $barcode))) {
                    $ds->total_item = $ds->total_item + $detail->qty;
                    $ds->subtotal = $ds->subtotal + $detail->subtotal;
                    array_push($details, $detail);
                } else {
                    foreach ($details as $d) {
                        if ($d->product_barcode === $barcode) {
                            $d->qty = $d->qty + 1;
                            $d->subtotal = $d->price * $d->qty;
                            $ds->total_item = $ds->total_item + 1;
                            $ds->subtotal = $ds->subtotal + $d->price;
                        }
                    }
                }
            }

            if (($ds->subtotal - $ds->discount) >= 300000 && ($ds->subtotal - $ds->discount) <= 500000) {
                $intCheck = 0;
                foreach ($details as $dt) {
                    $moriFilter = Arr::where($morinagas, function ($value, $key) use ($dt) {
                        return $value['barcode'] === $dt->product_barcode;
                    });
                    if (count($moriFilter) === 0) {
                        $intCheck = $intCheck + 1;
                    }
                }
                if ($intCheck > 0) {
                    $more = false;
                } else {
                    $more = true;
                }
            }

            if (($ds->subtotal - $ds->discount) > 500000) {
                $more = false;
            }
        }
        if (!$more) {
            $ds->amount = $ds->subtotal - ($ds->additional_discount + $ds->discount);
            if ($ds->amount > 300000 && $ds->amount <= 350000) {
                $ds->cash = 350000;
            } elseif ($ds->amount > 350000 && $ds->amount <= 400000) {
                $ds->cash = 400000;
            } elseif ($ds->amount > 400000 && $ds->amount <= 450000) {
                $ds->cash = 450000;
            } elseif ($ds->amount > 450000 && $ds->amount <= 500000) {
                $ds->cash = 500000;
            } elseif ($ds->amount > 500000 && $ds->amount <= 550000) {
                $ds->cash = 550000;
            } elseif ($ds->amount > 550000 && $ds->amount <= 600000) {
                $ds->cash = 600000;
            } elseif ($ds->amount <= 300000) {
                $ds->cash = 300000;
            } elseif ($ds->amount > 600000 && $ds->amount <= 650000) {
                $ds->cash = 650000;
            } elseif ($ds->amount > 650000 && $ds->amount <= 700000) {
                $ds->cash = 700000;
            } elseif ($ds->amount > 700000 && $ds->amount <= 750000) {
                $ds->cash = 750000;
            } else {
                $ds->cash = 800000;
            }
        }
        $ds->change = $ds->cash - $ds->amount;
        $ds->details = $details;
        return $ds;
    }

    public function printStruct(Request $request)
    {
        $date = date('ymd');
        $ds = new DirectSales();
        $ds->code = "DS" . $date . random_int(1000, 9999) . "_1";
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
            $detail->convertion = $request->details[$i]["convertion"];
            $detail->uom = $request->details[$i]["uom"] ?? "";
            $detail->category = $request->details[$i]["category"] ?? "";
            array_push($details, $detail);
        }
        $ds->details = $details;
        TempTransaction::where('user_id', auth()->user()->id)->delete();

        $this->printReceipt($ds);
        return response()->json($ds);
    }

    public function printRealStruck($code)
    {
        $directSales = DirectSales::where('code', $code)->first();
        $this->printReceipt($directSales);
        return back();
    }

    public function printReceipt(DirectSales $ds)
    {
        $connector = new WindowsPrintConnector(env("POS_PRINTER"));
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
            $printer->text(number_format($detail->price, 0, ',', ',') . " x " . number_format($detail->qty, 0, ',', ',') . " = Rp." . number_format($detail->subtotal, 0, ',', ',') . "\n");
            if ($detail->program > 0) {
                $printer->text("Rp.-" . number_format($detail->program, 0, ',', ',') . "\n");
            }
            if ($detail->discount > 0) {
                $totalDiscount = $detail->discount * $detail->qty;
                $printer->text(number_format($detail->discount, 0, ',', ',') . " x " . number_format($detail->qty, 0, ',', ',') . " = Rp." . number_format($totalDiscount, 0, ',', ',') . "\n");
            }
            $printer->setJustification(Printer::JUSTIFY_LEFT);
        }
        for ($i = 1; $i < 33; $i++) {
            $printer->text("_");
        }
        $printer->feed();
        $printer->initialize();
        $printer->text($this->textPos("Total Qty", "(" . number_format($ds->total_item, 0, ',', ',') . ")"));
        $printer->text($this->textPos("Subtotal", number_format($ds->subtotal, 0, ',', ',')));
        $printer->text($this->textPos("Program", number_format($ds->discount, 0, ',', ',')));
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
        $printer->feed(3);
        $printer->cut();
        $printer->close();
    }

    public function printPrice(Request $request)
    {
        $connector = new WindowsPrintConnector(env("POS_PRINTER"));
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
    public function update(Request $request)
    {
        $ds = DirectSales::where('code', $request->code)->first();
        $this->printReceipt($ds);
        return response()->json($ds);
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

    public function getDataByMonth($year)
    {
        $months = ['January', "February", 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $directSales = DirectSales::selectRaw('year(date) year, monthname(date) month,MONTH(date) no, sum(amount) amount,count(*) data')
            ->whereYear('date', $year)
            ->groupBy('year', 'month', 'no')
            ->orderBy('year', 'desc')
            ->orderBy('no', 'asc')
            ->get()
            ->makeHidden(['createdBy', 'editBy', 'details', 'paymentType', 'bank']);

        for ($i = 0; $i < count($months); $i++) {
            $filter = $directSales->filter(function ($ds) use ($i) {
                return (int)$ds['no'] === ($i + 1);
            });
            if (count($filter) == 0) {
                $directSales->push([
                    'year' => $year,
                    'month' => $months[$i],
                    'no' => $i + 1,
                    'data' => 0,
                    'amount' => 0
                ]);
            }
        }

        return $directSales->sortBy(function ($ds) {
            return $ds['no'];
        });
    }
    public function getAWeekData($date = null)
    {
        $dates = [];
        if (!isset($date)) {
            $date = Carbon::now()->toDateString();
        }
        for ($i = 0; $i <= 6; $i++) {
            $_date = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' 00:00:00')->subDays($i)->toDateString();
            array_push($dates, $_date);
        }
        $firstDate = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' 00:00:00')->subDays(6)->toDateTimeString();
        $secondDate = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' 23:59:59')->toDateTimeString();
        $directSales = DirectSales::selectRaw("DATE_FORMAT(date, '%Y-%m-%d') transDate, sum(amount) amount,count(*) data")
            ->whereBetween('date', [$firstDate, $secondDate])
            ->groupBy('transDate')
            ->orderBy('transDate', 'desc')
            ->get()
            ->makeHidden(['createdBy', 'editBy', 'details', 'paymentType', 'bank']);

        for ($i = 0; $i < count($dates); $i++) {
            $filter = $directSales->filter(function ($ds) use ($i, $dates) {
                return $ds['transDate'] === $dates[$i];
            });
            if (count($filter) == 0) {
                $directSales->push([
                    'transDate' => $dates[$i],
                    'data' => 0,
                    'amount' => 0
                ]);
            }
        }
        return $directSales;
    }

    public function getByDateHour($date, $hour)
    {
        if (($date == null || $date == "") || ($hour == null || $hour == "")) {
            return response()->json("Date or Hour can not be empty", 400);
        }
        $dateHour = $date . " " . $hour;
        $directSales = DirectSales::where('date', 'like', '%' . $dateHour . '%')->get();
        return response()->json($directSales);
    }

    private function checkBarcode($myArray, $barcode)
    {
        foreach ($myArray as $element) {
            if (($element->product_barcode == $barcode || (!empty($myArray['product_barcode']) && $this->checkBarcode($myArray['product_barcode'], $barcode)))) {
                return true;
            }
        }
        return false;
    }
}
