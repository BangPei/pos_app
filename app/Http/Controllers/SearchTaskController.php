<?php

namespace App\Http\Controllers;

use App\Models\DailyTask;
use App\Models\Expedition;
use Illuminate\Http\Request;
use Yajra\DataTables\Utilities\Request as UtilitiesRequest;

class SearchTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UtilitiesRequest $request)
    {
        $display = "";
        if ($request->ajax()) {
            $dailyTask = DailyTask::select('*');
            return datatables()->of($dailyTask)
                ->filter(function ($data) use ($request) {
                    if ($request->get('expedition')) {
                        if ($request->get('date') == "") {
                            $data->where('expedition_id', (int)$request->get('expedition'))->get();
                        } else {
                            $date = date('Y-m-d', $request->get('date'));
                            $data->where('date', $date)->where('expedition_id', (int)$request->get('expedition'))->get();
                        }
                    } else {
                        $date = date('Y-m-d', $request->get('date'));
                        $data->where('date', $date)->get();
                    }
                })->make(true);
        }
        return view('online_shop/task/search_task', [
            "title" => "Pencarian",
            "menu" => "Online Shop",
            "expeditions" => Expedition::all(),
            "display" => $display,
        ]);
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
     * @param  \App\Models\DailyTask  $dailyTask
     * @return \Illuminate\Http\Response
     */
    public function show(DailyTask $dailyTask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DailyTask  $dailyTask
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyTask $dailyTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DailyTask  $dailyTask
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DailyTask $dailyTask)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DailyTask  $dailyTask
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyTask $dailyTask)
    {
        //
    }
}
