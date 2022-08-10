<?php

namespace App\Http\Controllers;

use App\Models\Atm;
use App\Http\Requests\StoreAtmRequest;
use App\Http\Requests\UpdateAtmRequest;
use Yajra\DataTables\Utilities\Request as UtilitiesRequest;

class AtmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UtilitiesRequest $request)
    {
        $atm = Atm::all();
        if ($request->ajax()) {
            return datatables()->of($atm)->make(true);
        }
        return view('master/atm', ["title" => "Bank", "menu" => "Master"]);
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
     * @param  \App\Http\Requests\StoreAtmRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAtmRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Atm  $atm
     * @return \Illuminate\Http\Response
     */
    public function show(Atm $atm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Atm  $atm
     * @return \Illuminate\Http\Response
     */
    public function edit(Atm $atm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAtmRequest  $request
     * @param  \App\Models\Atm  $atm
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAtmRequest $request, Atm $atm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Atm  $atm
     * @return \Illuminate\Http\Response
     */
    public function destroy(Atm $atm)
    {
        //
    }
}
