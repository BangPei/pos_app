<?php

namespace App\Http\Controllers;

use App\Models\DirectSales;
use App\Models\Product;

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
        $emptyStock = 0;
        $products = Product::with('stock')->get();
        foreach ($products as $pr) {
            $stock = $pr->stock?->value ?? 0 / $pr->convertion;
            if ($stock < 1) {
                $emptyStock++;
            }
        }
        return view(
            'home/home',
            [
                "title" => "Dashboard",
                "menu" => "Home",
                "subtotal" => $subtotal ?? 0,
                "totalOrder" => $totalOrder ?? 0,
                "totalProduct" => $products->count() ?? 0,
                "stock" => $emptyStock,
                "trans" => $transByMonth,
                "transWeek" => $transByWeek,
            ]
        );
    }
}
