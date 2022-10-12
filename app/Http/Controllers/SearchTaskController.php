<?php

namespace App\Http\Controllers;

use App\Models\DailyTask;
use App\Models\Expedition;
use Illuminate\Http\Request;

class SearchTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expedition = Expedition::all();
        return view('online_shop/task/search_task', [
            "title" => "Pencarian",
            "menu" => "Online Shop",
            "expeditions" => $expedition,
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
