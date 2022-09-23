<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DailyTask;
use App\Models\Receipt;
use Illuminate\Http\Request;

class DailyTaskApiController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $dailyTask = DailyTask::where('expedition_id', $request->expedition['id'])->where('date', $request->date)->first();
        if ($dailyTask) {
            return 'error';
        } else {
            $dailyTask->date = $request->date;
            $dailyTask->expedition_id = $request->expedition['id'];
            $dailyTask->total_package = $request->total_package;
            $dailyTask->save();
            return response()->json($dailyTask->save());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dailyTask = DailyTask::where('id', $id)->first();
        return response()->json($dailyTask);
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
        try {
            $dailyTask = $request;
            Receipt::where('daily_task_id', $id)->delete();
            $receipts = [];
            for ($i = 0; $i < count($dailyTask->receipts); $i++) {
                $receipt = new Receipt();
                $receipt->daily_task_id =  $dailyTask['id'];
                $receipt->number =  $dailyTask->receipts[$i]["number"];
                $receipt->save();
                array_push($receipts, $receipt);
            }
            $dailyTask->receipts = $receipts;
            return response()->json($dailyTask);
        } catch (\Throwable $th) {
            return $th;
        }
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
