<?php

namespace App\Http\Controllers;

use App\Models\Expedition;
use App\Http\Requests\UpdateExpeditionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Utilities\Request as UtilitiesRequest;

class ExpeditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UtilitiesRequest $request)
    {
        $expedition = Expedition::all();
        if ($request->ajax()) {
            return datatables()->of($expedition)->make(true);
        }
        return view('online_shop/expedition/index', ["title" => "Expedisi", "menu" => "Online Shop",]);
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
     * @param  \App\Http\Requests\StoreExpeditionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $expedition = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'alias' => 'required',
        ]);
        Expedition::Create($expedition);
        session()->flash('message', 'Berhasil Menambah Expedisi ' . $expedition['name']);
        return Redirect::to('bank');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expedition  $expedition
     * @return \Illuminate\Http\Response
     */
    public function show(Expedition $expedition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expedition  $expedition
     * @return \Illuminate\Http\Response
     */
    public function edit(Expedition $expedition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateExpeditionRequest  $request
     * @param  \App\Models\Expedition  $expedition
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateExpeditionRequest $request, Expedition $expedition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expedition  $expedition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expedition $expedition)
    {
        //
    }
}
