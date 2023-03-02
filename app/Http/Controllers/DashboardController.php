<?php

namespace App\Http\Controllers;

use App\Models\DirectSales;

class DashboardController extends Controller
{
    public function index()
    {
        $from = date("Y-m-d") . " 00:00:00";
        $to = date("Y-m-d") . " 23:59:59";
        $subtotal = DirectSales::whereBetween('date', [$from, $to])->sum('subtotal');
        return view(
            'home/home',
            [
                "title" => "Dashboard",
                "menu" => "Home",
                "subtotal" => $subtotal ?? 0,
            ]
        );
    }
}
