<?php

namespace App\Http\Controllers;

use App\Models\Atm;
use App\Http\Requests\StoreAtmRequest;
use App\Http\Requests\UpdateAtmRequest;
use Illuminate\Support\Facades\Redirect;
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
        $atm = $request->validate([
            'name' => 'required',
            'description' => '',
            'created_by_id' => '',
            'edit_by_id' => '',
        ]);
        $atm['created_by_id'] = auth()->user()->id;
        $atm['edit_by_id'] = auth()->user()->id;
        Atm::Create($atm);
        return Redirect::to('bank');
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
        $atm = $request->validate([
            'name' => 'required',
            'description' => '',
        ]);
        $atm['id'] = $request->input('id');
        $atm['edit_by_id'] = auth()->user()->id;
        Atm::where('id', $atm['id'])->update([
            'name' => $atm['name'],
            'description' => $atm['description'],
            'edit_by_id' => $atm['edit_by_id'],
        ]);
        return Redirect::to('bank');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Atm  $atm
     * @return \Illuminate\Http\Response
     */
    public function destroy(Atm $atm)
    {
        $atm['is_active'] = $atm['is_active'] == 1 ? 0 : 1;
        Atm::where('id', $atm->id)->update([
            'name' => $atm->name,
            'description' => $atm->description,
            'is_active' => $atm->is_active,
            'created_by_id' => $atm->created_by_id,
            'edit_by_id' => auth()->user()->id,
        ]);
        return Redirect::to('bank');
    }
}
