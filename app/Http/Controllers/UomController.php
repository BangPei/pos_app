<?php

namespace App\Http\Controllers;

use App\Models\Uom;
use Illuminate\Http\Request;
use Yajra\DataTables\Utilities\Request as UtilitiesRequest;

class UomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UtilitiesRequest $request)
    {
        $listuom = Uom::all();
        if ($request->ajax()) {
            return datatables()->of($listuom)->make(true);
        }
        return view('master/uom', ["title" => "Uom", "menu" => "Master"]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Uom  $uom
     * @return \Illuminate\Http\Response
     */
    public function show(Uom $uom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Uom  $uom
     * @return \Illuminate\Http\Response
     */
    public function edit(Uom $uom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Uom  $uom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Uom $uom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Uom  $uom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Uom $uom)
    {
        //
    }
}
