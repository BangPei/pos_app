<?php

namespace App\Http\Controllers;

use App\Models\DailyTaskDetail;
use App\Http\Requests\StoreDailyTaskDetailRequest;
use App\Http\Requests\UpdateDailyTaskDetailRequest;

class DailyTaskDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreDailyTaskDetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDailyTaskDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DailyTaskDetail  $dailyTaskDetail
     * @return \Illuminate\Http\Response
     */
    public function show(DailyTaskDetail $dailyTaskDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DailyTaskDetail  $dailyTaskDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyTaskDetail $dailyTaskDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDailyTaskDetailRequest  $request
     * @param  \App\Models\DailyTaskDetail  $dailyTaskDetail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDailyTaskDetailRequest $request, DailyTaskDetail $dailyTaskDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DailyTaskDetail  $dailyTaskDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyTaskDetail $dailyTaskDetail)
    {
        //
    }
}
