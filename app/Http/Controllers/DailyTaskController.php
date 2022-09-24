<?php

namespace App\Http\Controllers;

use App\Models\DailyTask;
use App\Http\Controllers\Controller;
use App\Models\Expedition;
use Illuminate\Http\Request;
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
        $dailyTask = DailyTask::all();
        $expeditions = Expedition::all();
        if ($request->ajax()) {
            return datatables()->of($dailyTask)->make(true);
        }
        return view(
            'online_shop/task/index',
            [
                "title" => "Tugas Harian",
                "menu" => "Online Shope",
                "expeditions" => $expeditions,
            ]
        );
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
     * @param  \App\Http\Requests\StoreDailyTaskRequest  $request
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
        return view(
            'online_shop/task/form',
            [
                "title" => "Tugas Harian",
                "menu" => "Online Shop",
                "dailyTask" => $dailyTask
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDailyTaskRequest  $request
     * @param  \App\Models\DailyTask  $dailyTask
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
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
