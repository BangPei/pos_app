<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\TempTransaction;
use Illuminate\Http\Request;

class TempTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $temp = TempTransaction::all();
        return $temp;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $temp = new TempTransaction();
        $temp->stock_id = $request->stock_id;
        $temp->product_id = $request->product_id;
        $temp->user_id = $request->user_id;
        $temp->convertion = $request->convertion;
        $temp->qty = $request->qty;
        $temp->save();
        return $temp;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TempTransaction  $tempTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $temp = TempTransaction::where([
            'product_id' => $request->product_id,
            'user_id' => $request->user_id
        ])->update([
            'qty' => $request->qty,
        ]);
        return $temp;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TempTransaction  $tempTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(TempTransaction $tempTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TempTransaction  $tempTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TempTransaction $tempTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TempTransaction  $tempTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
    }

    public function deleteStockByUser(Request $request)
    {
        TempTransaction::where([
            ['stock_id', $request->stock_id],
            ['product_id', $request->product_id],
            ['user_id', auth()->user()->id],
        ])->delete();
    }
    public function deleteTransaction()
    {
        TempTransaction::where('user_id', auth()->user()->id)->delete();
    }

    public function postStockByUser(Request $request)
    {
        $stock = Stock::where('id', $request['stock_id'])->first();
        $tempTrans = TempTransaction::where(
            [
                ['stock_id', $request['stock_id']],
            ]
        )->get();

        $tmpVal = 0;
        foreach ($tempTrans as $trans) {
            if (($trans->product_id == $request['product_id']) && ($trans->user_id == auth()->user()->id)) {
                $trans->qty = $trans->qty + $request['qty'];
            }
            $tmpVal = $tmpVal + ($trans->qty * $trans->convertion);
        }
        $newData = $tmpVal + ($request->qty * $request->convertion);
        $value = $stock->value - $newData;
        if ($value < 0) {
            return response()->json(['message' => "Stock Tidak Cukup"], 500);
        } else {
            if ($this->myArrayContainsWord($tempTrans, $request['product_id'], auth()->user()->id)) {
                $trans = TempTransaction::where(
                    [
                        ['stock_id', $request['stock_id']],
                        ['product_id', $request['product_id']],
                        ['user_id', auth()->user()->id]
                    ]
                )->first();
                $trans->qty =  $trans->qty + $request['qty'];
                $trans->update();
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

    public function updateStockByUser(Request $request)
    {
        $stock = Stock::where('id', $request['stock_id'])->first();
        $tempTrans = TempTransaction::where(
            [
                ['stock_id', $request['stock_id']],
            ]
        )->get();

        $tmpVal = 0;
        foreach ($tempTrans as $trans) {
            if (($trans->product_id == $request['product_id']) && ($trans->user_id == auth()->user()->id)) {
                $trans->qty = $request['qty'];
            }
            $tmpVal = $tmpVal + ($trans->qty * $trans->convertion);
        }
        $value = $stock->value - $tmpVal;
        if ($value < 0) {
            return response()->json(['message' => "Stock Tidak Cukup"], 500);
        } else {
            $trans = TempTransaction::where(
                [
                    ['stock_id', $request['stock_id']],
                    ['product_id', $request['product_id']],
                    ['user_id', auth()->user()->id]
                ]
            )->first();
            $trans->qty = $request['qty'];
            $trans->update();
            return response()->json($trans);
        }
    }

    private function myArrayContainsWord($myArray, $productId, $userId)
    {
        foreach ($myArray as $element) {
            if (
                ($element->product_id == $productId ||
                    (!empty($myArray['product_id']) && $this->myArrayContainsWord($myArray['product_id'], $productId, $userId)))
                && ($element->user_id == $userId ||
                    (!empty($myArray['user_id']) && $this->myArrayContainsWord($myArray['user_id'], $userId, $userId)))
            ) {
                return true;
            }
        }
        return false;
    }
}
