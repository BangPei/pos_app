<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\ModalPrice;
use App\Models\Product;
use App\Models\PurchaseDetail;
use App\Models\Stock;
use App\Models\StockHistory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Utilities\Request as UtilitiesRequest;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UtilitiesRequest $request)
    {
        $po = Purchase::all();
        if ($request->ajax()) {
            return datatables()->of($po)->make(true);
        }
        return view(
            'purchase.index',
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
    public function create()
    {
        $supplier = Supplier::all();
        return view(
            'purchase.form',
            [
                "title" => "Form Pembelian",
                "menu" => "Aplikasi Pembelian",
                'supplier' => $supplier,
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePurchaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $po = new Purchase();
        $po->code = $this->poCode();
        $po->invoice_no = $request->invoice_no;
        $po->dpp = (float) $request->dpp;
        $po->discount_extra = (float) $request->discount_extra;
        $po->date = $request->date;
        $po->payment_type = $request->payment_type;
        if ($po->payment_type != "lunas") {
            if ($request->due_date == null || $request->due_date == "") {
                return response()->json(['message' => "Tanggal Jatuh Tempo Tidak Bokeh Kosong"], 400);
            } else {
                $po->due_date = $request->due_date;
            }
            $po->status = 0;
        } else {
            $po->due_date = null;
            $po->status = 1;
            $po->payment_date = $po->date;
        }
        $po->is_distributor = $request->is_distributor == "true" ? 1 : 0;
        $po->tax_in_price = $request->tax_in_price == "true" ? 1 : 0;
        $po->pic = $request->pic;
        $po->tax = (int) $request->tax;
        $po->subtotal = (float) $request->subtotal;
        $po->tax_paid = (float) $request->tax_paid;
        $po->total_amount =  (float)$request->total_amount;
        $po->amount =  (float)$request->amount;
        if ($request->is_distributor == "false" || $request->is_distributor == false) {
            $po->supplier_id = null;
        } else {
            if ($request->supplier == null) {
                return response()->json(['message' => "Supplier Tidak Bokeh Kosong"], 400);
            } else {
                $po->supplier_id = $request->supplier['id'];
            }
        }
        $po->save();
        for ($i = 0; $i < count($request->details); $i++) {
            $detail = $request->details[$i];
            $stock = Stock::where('id', $detail['stock']['id'])->first();
            $poDetail = new PurchaseDetail();
            $poDetail->purchase_id = $po->id;
            $poDetail->stock_id = $detail['stock']['id'];
            $poDetail->convertion = $detail['convertion'];
            $poDetail->product_barcode = $detail['product_barcode'];
            $poDetail->qty = (int) $detail['qty'];
            $poDetail->subtotal = (float) $detail['subtotal'];
            $poDetail->price_per_pcs = (float) $detail['price_per_pcs'];
            if (isset($detail['uom'])) {
                $poDetail->uom_id = (int) $detail['uom']['id'] ?? null;
            }
            Stock::where('id', $poDetail->stock_id)->update([
                'value' => $stock->value + ($poDetail->convertion * $poDetail->qty),
            ]);
            $poDetail->save();

            $history = new StockHistory();
            $history->type = 1;
            $history->date = $po->date;
            $history->trans_code = $po->code;
            $history->qty = ($poDetail->convertion * $poDetail->qty);
            $history->old_qty = $stock->value;
            $history->stock_id = $poDetail->stock_id;
            $history->note = "Penambahan Qty dari kode barang " . $poDetail->product_barcode;
            $history->save();

            for ($j = 0; $j < count($detail['detail_modals']); $j++) {
                $modal = $detail['detail_modals'][$j];
                $detailModal = new ModalPrice();
                $detailModal->purchase_detail_id = $poDetail->id;
                $detailModal->current_price = (float) $modal['current_price'];
                $detailModal->dpp = (float) $modal['dpp'];
                $detailModal->modal = (float) $modal['modal'];
                $detailModal->new_price = (float) $modal['new_price'];
                $detailModal->tax_paid = (float) $modal['tax_paid'];
                $detailModal->periode = $po->date;
                $detailModal->margin_after_tax = (float) $modal['margin_after_tax'];
                $detailModal->margin_before_tax = (float) $modal['margin_before_tax'];
                $detailModal->product_barcode = $modal['product']['barcode'];
                Product::where('barcode', $detailModal->product_barcode)->update([
                    'price' => $detailModal->new_price,
                ]);
                $detailModal->save();
            }
        }
        $po = Purchase::with(['details' => function ($detail) {
            $detail->with('detail_modals');
        }])->find($po->id);
        return response()->json($po);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $po = Purchase::with(['details' => function ($detail) {
            $detail->with('detail_modals');
        }])->find($id);
        return response()->json($po);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit($code)
    {
        $po = Purchase::where('code', $code)->with(['details' => function ($query) {
            $query->with('detail_modals');
        }])->first();
        return view(
            'purchase.view-po',
            [
                "title" => "Form Pembelian",
                "menu" => "Aplikasi Pembelian",
                'po' => $po,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePurchaseRequest  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }

    private function poCode()
    {
        $code = "PO";
        $currDate = date("ymd");
        $n = 0;
        $n2 = "";
        $models = Purchase::where('code', 'LIKE', "%{$currDate}%")->orderBy('code', 'desc')->take(1)->get();
        if (count($models) != 0) {
            $n2 = substr($models[0]->code, -4);
            $n2 = str_pad($n2 + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $n2 = str_pad($n + 1, 4, 0, STR_PAD_LEFT);
        }

        $fullCode = $code . "" . $currDate . "" . $n2;
        return $fullCode;
    }
}
