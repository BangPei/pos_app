<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DailyTask;
use App\Models\Receipt;
use Yajra\DataTables\Utilities\Request as UtilitiesRequest;
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
        $dailyTask = DailyTask::all();
        return response()->json($dailyTask);
    }

    public function dataTable(UtilitiesRequest $request)
    {
        $dailyTask = DailyTask::all();
        if ($request->ajax()) {
            return datatables()->of($dailyTask)->make(true);
        }
    }

    public function getCurrentTask()
    {
        $dailyTask = DailyTask::where('status', 0)->get();
        return response()->json($dailyTask);
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
            $dailyTask = DailyTask::where('expedition_id', $request->expedition['id'])->where('date', $request->date)->where('status', 0)->first();
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
    public function multiple(Request $request)
    {
        try {
            foreach ($request as $task) {
                $dailyTask = DailyTask::where('expedition_id', $task->expedition['id'])->where('date', $task->date)->where('status', 0)->first();
                if ($dailyTask) {
                    return response()->json(['message' => 'Tugas Harian Untuk Expedisi' . $task->expedition['name'] . ' Sudah Dibuat !'], 400);
                } else {
                    $dailyTask = new DailyTask();
                    $dailyTask->expedition_id = $task->expedition['id'];
                    $dailyTask->date = $task->date;
                    $dailyTask->total_package = $task->total_package;
                    $dailyTask->save();
                }
            }
            return response()->json(['message' => "Berhasil Membuat Tugas Harian"], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function receipt(Request $request, $id)
    {
        $receipt = Receipt::where('number', $request['number'])->first();
        if ($receipt) {
            return response()->json(['message' => 'Nomor Resi ' . $receipt->number . ' Sudah Diinput pada tanggal ' . date_format($receipt->created_at, 'd-m-Y')], 400);
        } else {
            $receipt = new Receipt();
            $receipt->daily_task_id = $id;
            $receipt->number = $request->number;
            $receipt->save();
        }
        return response()->json($receipt);
    }

    public function receiptByDailyTaskId($id)
    {
        $receipt = Receipt::where('daily_task_id', $id)->get();
        return response()->json($receipt);
    }

    public function deleteReceipt(Request $request)
    {
        Receipt::where('number', $request['number'])->delete();

        return response()->json();
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
                "total_package" => $request['total_package'],
                "left" => $request['total_package'] - $request['picked'],
                "date" => $request['date']
            ]));
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function picked(Request $request, $id)
    {
        try {
            return response()->json(DailyTask::where('id', $id)->update([
                "picked" => $request['picked'],
                "left" => $request['total_package'] - $request['picked'],
                "date" => $request['date']
            ]));
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function finish(Request $request, $id)
    {
        try {
            return response()->json(DailyTask::where('id', $id)->update([
                "status" => 1,
                "date" => $request['date']
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
        DailyTask::where('id', $id)->delete();

        return response()->json();
    }
}
