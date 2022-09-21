<?php

namespace App\Http\Controllers;

use App\Models\DailyTask;
use App\Http\Requests\StoreDailyTaskRequest;
use App\Http\Requests\UpdateDailyTaskRequest;
use App\Models\Expedition;
use Yajra\DataTables\Utilities\Request as UtilitiesRequest;

class DailyTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UtilitiesRequest $request)
    {
        $dailyTask = DailyTask::with('expeditions')->get();
        if ($request->ajax()) {
            return datatables()->of($dailyTask)->make(true);
        }
        return view('online_shop/task/index', ["title" => "Tugas Harian", "menu" => "Online Shope"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $expedition = Expedition::all();
        return view('online_shop/task/form', [
            "title" => "Tugas Harian",
            "menu" => "Online Shop",
            "expedition" => $expedition,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDailyTaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDailyTaskRequest $request)
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
     * @param  \App\Http\Requests\UpdateDailyTaskRequest  $request
     * @param  \App\Models\DailyTask  $dailyTask
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDailyTaskRequest $request, DailyTask $dailyTask)
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
