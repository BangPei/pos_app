<?php

namespace App\Http\Controllers;

use App\Models\Uom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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
        $uom = $request->validate([
            'name' => 'required',
            'description' => '',
            'created_by_id' => '',
            'edit_by_id' => '',
        ]);
        $uom['created_by_id'] = auth()->user()->id;
        $uom['edit_by_id'] = auth()->user()->id;
        Uom::Create($uom);
        session()->flash('message', 'Berhasil menambahkan satuan ' . $uom['name']);
        return Redirect::to('uom');
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
        $uom = $request->validate([
            'name' => 'required',
            'description' => '',
        ]);
        $uom['id'] = $request->input('id');
        $uom['edit_by_id'] = auth()->user()->id;
        Uom::where('id', $uom['id'])->update([
            'name' => $uom['name'],
            'description' => $uom['description'],
            'edit_by_id' => $uom['edit_by_id'],
        ]);
        session()->flash('message', 'Berhasil merubah satuan ' . $uom['name']);
        return Redirect::to('uom');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Uom  $uom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Uom $uom)
    {
        $uom['is_active'] = $uom['is_active'] == 1 ? 0 : 1;
        Uom::where('id', $uom->id)->update([
            'name' => $uom->name,
            'description' => $uom->description,
            'is_active' => $uom->is_active,
            'created_by_id' => $uom->created_by_id,
            'edit_by_id' => auth()->user()->id,
        ]);
        return Redirect::to('uom');
    }
}
