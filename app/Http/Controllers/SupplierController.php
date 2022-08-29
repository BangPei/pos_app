<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UpdateSupplierRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Utilities\Request as UtilitiesRequest;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UtilitiesRequest $request)
    {
        $supplier = Supplier::all();
        if ($request->ajax()) {
            return datatables()->of($supplier)->make(true);
        }
        return view('master/supplier/supplier', ["title" => "Supplier", "menu" => "Master",]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master/supplier/form', [
            "title" => "Supplier Form",
            "menu" => "Master"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSupplierRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $supplier = $request->validate([
            'name' => 'required',
            'phone' => '',
            'npwp' => '',
            'pic' => '',
            'mobile' => '',
            'address' => '',
        ]);
        Supplier::Create($supplier);
        session()->flash('message', $supplier['name'] . ' Berhasil disimpan.');
        return Redirect::to('/supplier/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        return view('master/supplier/form', [
            "title" => "Product Form",
            "menu" => "Master",
            "supplier" => $supplier,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSupplierRequest  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $supplier->update($request->all());
        session()->flash('message', 'Berhasil merubah ' . $supplier['name']);
        return Redirect::to('/supplier');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
