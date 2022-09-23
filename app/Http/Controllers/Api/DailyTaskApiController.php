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
        try {
            $dailyTask = DailyTask::where('expedition_id', $request->expedition['id'])->where('date', $request->date)->first();
            if ($dailyTask) {
                return response()->json(['message' => 'Tugas Harian Untuk Expedisi Tersebut Sudah Dibuat !'], 400);
            } else {
                $dailyTask = new DailyTask();
                $dailyTask->expedition_id = $request->expedition['id'];
                $dailyTask->date = $request->date;
                $dailyTask->total_package = $request->total_package;
                return response()->json($dailyTask->save());
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
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
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
    public function total(Request $request, $id)
    {
        try {
            return response()->json(DailyTask::where('id', $id)->update([
                "total_package" => $request['total_package']
            ]));
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
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