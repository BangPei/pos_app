<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Expedition;
use Illuminate\Http\Request;
use Yajra\DataTables\Utilities\Request as UtilitiesRequest;

class ExpeditionApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Expedition::all();
    }

    public function dataTable(UtilitiesRequest $request)
    {
        $expedition = Expedition::all();
        if ($request->ajax()) {
            return datatables()->of($expedition)->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $expedition = $request->validate([
            'name' => 'required',
            'description' => '',
            'alias' => 'required',
            'image' => '',
        ]);
        $file = $request->file('image');
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $file->move(public_path('public/Image'), $filename);
        $expedition['image'] = $filename;
        return response()->json(Expedition::Create($expedition));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $expedition = $request;
        $file = $request->file('image');
        $filename = rand() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('public/Image'), $filename);
        Expedition::where('id', $id)->update([
            'name' => $expedition['name'],
            'description' => $expedition['description'],
            'alias' => $expedition['alias'],
            'image' => $filename
        ]);
        return response()->json($expedition);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
