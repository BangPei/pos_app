<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Utilities\Request as UtilitiesRequest;

class PaymentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UtilitiesRequest $request)
    {
        $paymentType = PaymentType::all();
        if ($request->ajax()) {
            return datatables()->of($paymentType)->make(true);
        }
        return view('master/payment-type', ["title" => "Payment", "menu" => "Master"]);
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
        $paymentType = $request->validate([
            'name' => 'required',
            'description' => '',
            'created_by_id' => '',
            'edit_by_id' => '',
        ]);
        $paymentType['created_by_id'] = auth()->user()->id;
        $paymentType['edit_by_id'] = auth()->user()->id;
        PaymentType::Create($paymentType);
        return Redirect::to('payment');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentType $paymentType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentType $paymentType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentType $paymentType)
    {
        $request['edit_by_id'] = auth()->user()->id;
        $paymentType->update($request->all());
        // $paymentType = $request->validate([
        //     'name' => 'required',
        //     'description' => '',
        // ]);
        // $paymentType['id'] = $request->input('id');
        // $paymentType['edit_by_id'] = auth()->user()->id;
        // PaymentType::where('id', $paymentType['id'])->update([
        //     'name' => $paymentType['name'],
        //     'description' => $paymentType['description'],
        //     'edit_by_id' => $paymentType['edit_by_id'],
        // ]);
        return Redirect::to('payment');
    }

    public function changeStatus(Request $request)
    {
        $payment = $request;
        if ($request->ajax()) {
            PaymentType::where('id', $payment['id'])->update([
                'is_active' => $payment['is_active'],
                'edit_by_id' => auth()->user()->id,
            ]);
        }
        return response()->json($payment);
    }
    public function changePayment(Request $request)
    {
        $payment = $request;
        if ($request->ajax()) {
            if ($payment['is_default']) {
                PaymentType::where('id', '!=', $payment['id'])->update([
                    'is_default' => 0,
                ]);
            }
            PaymentType::where('id', $payment['id'])->update([
                'is_default' => $payment['is_default'],
            ]);
        }
        return response()->json($payment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentType $paymentType)
    {
        $paymentType['is_active'] = $paymentType['is_active'] == 1 ? 0 : 1;
        PaymentType::where('id', $paymentType->id)->update([
            'name' => $paymentType->name,
            'description' => $paymentType->description,
            'is_active' => $paymentType->is_active,
            'created_by_id' => $paymentType->created_by_id,
            'edit_by_id' => auth()->user()->id,
        ]);
        return Redirect::to('payment');
    }

    public function get()
    {
        $paymentTypes = PaymentType::all();
        return response()->json($paymentTypes);
    }
}
