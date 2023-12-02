<?php

namespace App\Http\Controllers;

use App\Models\DirectSales;
use App\Models\Product;
use App\Models\Stock;

class DashboardController extends Controller
{
    public function index()
    {
        $from = date("Y-m-d") . " 00:00:00";
        $to = date("Y-m-d") . " 23:59:59";
        $subtotal = DirectSales::whereBetween('date', [$from, $to])->sum('subtotal');
        $totalOrder = DirectSales::whereBetween('date', [$from, $to])->count();

        $transByMonth = app('App\Http\Controllers\DirectSalesController')->groupByMonth();
        $transByWeek = app('App\Http\Controllers\DirectSalesController')->getAWeekData(date('Y-m-d'));
        $emptyStock = app('App\Http\Controllers\StockController')->getEmptyStock()->count();
        return view(
            'home/home',
            [
                "title" => "Dashboard",
                "menu" => "Home",
                "subtotal" => $subtotal ?? 0,
                "totalOrder" => $totalOrder ?? 0,
                "totalProduct" => Stock::count(),
                "stock" => $emptyStock,
                "trans" => $transByMonth,
                "transWeek" => $transByWeek,
            ]
        );
    }
}
