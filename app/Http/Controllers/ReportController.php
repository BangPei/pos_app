<?php

namespace App\Http\Controllers;

use App\Models\DailyTask;
use App\Models\DirectSales;
use App\Models\DirectSalesDetail;
use App\Models\PaymentType;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
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
        $directSales = DirectSales::orderBy('date', 'DESC');

        $payments = PaymentType::all();

        if (request('code')) {
            $directSales->where('code', 'like', request('code'));
        }
        if (request('product')) {
            $details = DirectSalesDetail::where('product_barcode', request('product'))
                ->orWhere('product_name', 'like', "%" . request('product') . "%")
                ->get();
            $listId = [];
            for ($i = 0; $i < count($details); $i++) {
                array_push($listId, $details[$i]->direct_sales_id);
            }
            $directSales->whereIn('id', $listId);
        }
        if (request('from') && request('to')) {
            $from = Carbon::createFromFormat('d F Y', request('from'))->format('Y-m-d');
            $to = Carbon::createFromFormat('d F Y', request('to'))->format('Y-m-d');
            $directSales->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:59']);
        }
        if (request('payment')) {
            $directSales->where('payment_type_id', (int)request('payment'));
        }
        $sum = $directSales->sum('amount');
        $ds = $directSales->paginate(request('perpage') ?? 20)->withQueryString();
        $json = json_decode($ds->toJson());
        return view('report/direct_sales/daily', [
            "title" => "Lapran Harian",
            "menu" => "Laporan",
            "directSales" => $ds,
            "payments" => $payments,
            "amount" => $sum,
            "query" => [
                "dateFrom" => request('from'),
                "dateTo" => request('to'),
                "payment" => request('payment'),
                "code" => request('code'),
                "product" => request('product'),
                "perpage" => request('perpage'),
            ],
            "page" => [
                "total" => $json->total,
                "per_page" => $json->per_page,
                "current_page" => $json->current_page,
                "last_page" => $json->last_page,
                "from" => $json->from,
                "to" => $json->to,
            ]

        ]);
    }
    public function hourly()
    {
        $directSales = [];
        $hours = [];
        $sum = 0;
        $data = 0;

        if (request('date')) {
            $date = Carbon::createFromFormat('d F Y', request('date'))->format('Y-m-d');
            $directSales = DirectSales::selectRaw("DATE_FORMAT(date, '%H') hour, sum(amount) amount,count(*) data")
                ->whereBetween('date', [$date . ' 00:00:00', $date . ' 23:59:59'])
                ->groupBy('hour')
                ->orderBy('hour', 'asc')
                ->get()
                ->makeHidden(['createdBy', 'editBy', 'details', 'paymentType', 'bank']);
            $sum = DirectSales::selectRaw("sum(amount) sum")
                ->whereBetween("date", [$date . ' 00:00:00', $date . ' 23:59:59'])->sum('amount');
            $data = DirectSales::whereBetween("date", [$date . ' 00:00:00', $date . ' 23:59:59'])->count();

            for ($i = 0; $i < 24; $i++) {
                if ($i < 10) {
                    array_push($hours, "0" . $i);
                } else {
                    array_push($hours, (string)$i);
                }
            }

            for ($i = 0; $i < count($hours); $i++) {
                $filter = $directSales->filter(function ($ds) use ($i, $hours) {
                    return $ds['hour'] === $hours[$i];
                });
                if (count($filter) == 0) {
                    $directSales->push([
                        'hour' => $hours[$i],
                        'data' => 0,
                        'amount' => 0
                    ]);
                }
            }
        }


        return view('report/direct_sales/hourly', [
            "title" => "Lapran Perjam",
            "menu" => "Laporan",
            "date" => request('date'),
            "directSales" => (count($directSales) != 0) ? $directSales->sortBy('hour') : [],
            "total" => [
                "amount" => $sum,
                "data" => $data
            ],
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
