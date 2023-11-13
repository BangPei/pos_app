<?php

namespace App\Http\Controllers;

use App\Models\DailyTask;
use App\Models\DirectSales;
use App\Models\Expedition;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class ReportController extends Controller
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        //
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

    public function daily()
    {
        $directSales = null;
        if (request('date')) {
            $date = Carbon::createFromFormat('d F Y', request('date'))->format('Y-m-d');
            $directSales = DirectSales::selectRaw("DATE_FORMAT(date, '%H') hour, sum(amount) amount,count(*) data")
                ->whereBetween('date', [$date . ' 00:00:00', $date . ' 23:59:59'])
                ->groupBy('hour')
                ->orderBy('hour', 'asc')
                ->get()
                ->makeHidden(['createdBy', 'editBy', 'details', 'paymentType', 'bank']);
        }

        return view('report/daily_task/daily', [
            "title" => "Lapran Harian",
            "menu" => "Laporan",
            "date" => request('date'),
            "directSales" => $directSales,
        ]);
    }
    public function dailyTaskByDate(Request $request)
    {
        $data = $request->validate([
            'date' => '',
        ]);
        $dailyTask = DailyTask::where('date', $data['date'])->get();
        return $dailyTask;
    }
    public function dailyTaskByExpedition(Request $request)
    {
        $data = $request->validate([
            'expedition' => '',
        ]);
        $dailyTask = DailyTask::where('expedition_id', $data['expedition'])->get();
        return $dailyTask;
    }
    public function dailyTaskExpeditionByMonthYear(Request $request)
    {
        $data = $request->validate([
            'expedition' => '',
            'year' => '',
            'month' => '',
        ]);
        $dailyTask = DailyTask::where('expedition_id', $data['expedition'])->year('date', $data['year'])->month('date', $data['month'])->get();
        return $dailyTask;
    }
    public function dailyTaskExpeditionByYear(Request $request)
    {
        $data = $request->validate([
            'expedition' => '',
            'date' => '',
        ]);
        $dailyTask = DailyTask::where('expedition_id', $data['expedition'])->year('date', $data['year'])->get();
        return $dailyTask;
    }
}
