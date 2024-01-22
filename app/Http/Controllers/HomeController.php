<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Carbon;


class HomeController extends Controller
{

    public function index()
    {
        date_default_timezone_set("America/Lima");

        $date = Carbon::now()->locale('es');
        $mes = ucfirst($date->monthName);
        $pedidos=[];   
        $total_orden_mes=[];     
        
        if ($mes == 'September') {
            $mes = 'Setiembre';
        } else {
            $mes;
        }        
        
        $order_day = DB::table('orders')
            ->select(DB::raw("count(*) as cantidad_ordenes"))
            ->whereMonth('created_at', date('m'))
            ->whereDay('created_at', date('d'))
            ->get();

        $projects_month = DB::table('orders')
            ->select(DB::raw("count(*) as cantidad_proyectos"))
            ->whereIn('status', [1, 2])
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->get();

        $orders_date = DB::table('orders')
            ->select(DB::raw("count(*) as c_orden_retraso"))
            ->whereIn('status', [2, 3])
            ->whereMonth('end_date', '>=', DB::raw("month(expected_date)"))
            ->whereDay('end_date', '>', DB::raw("day(expected_date)"))
            ->whereMonth('expected_date', date('m'))
            ->whereYear('expected_date', date('Y'))
            ->get();

        $users = DB::table('reworks')
            ->select(DB::raw("count(*) as cantidad_reprocesos"))
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->get();

        $data_orders = DB::table('orders')
            ->select(DB::raw("count(*) as cantidad, DATE_FORMAT(created_at, '%M') as mes"))
            ->whereYear('created_at', date('Y'))
            ->groupBy('mes')
            ->orderBy('created_at')
            ->get();

        foreach ($data_orders as $data_order) {
            if ($data_order->mes == 'January') {
                $total_orden_mes[] = ['name' => 'Enero', 'y' => $data_order->cantidad];
            }
            if ($data_order->mes == 'February') {
                $total_orden_mes[] = ['name' => 'Febrero', 'y' => $data_order->cantidad];
            }
            if ($data_order->mes == 'March') {
                $total_orden_mes[] = ['name' => 'Marzo', 'y' => $data_order->cantidad];
            }
            if ($data_order->mes == 'April') {
                $total_orden_mes[] = ['name' => 'Abril', 'y' => $data_order->cantidad];
            }
            if ($data_order->mes == 'May') {
                $total_orden_mes[] = ['name' => 'Mayo', 'y' => $data_order->cantidad];
            }
            if ($data_order->mes == 'June') {
                $total_orden_mes[] = ['name' => 'Junio', 'y' => $data_order->cantidad];
            }
            if ($data_order->mes == 'July') {
                $total_orden_mes[] = ['name' => 'Julio', 'y' => $data_order->cantidad];
            }
            if ($data_order->mes == 'August') {
                $total_orden_mes[] = ['name' => 'Agosto', 'y' => $data_order->cantidad];
            }
            if ($data_order->mes == 'September') {
                $total_orden_mes[] = ['name' => 'Setiembre', 'y' => $data_order->cantidad];
            }
            if ($data_order->mes == 'October') {
                $total_orden_mes[] = ['name' => 'Octubre', 'y' => $data_order->cantidad];
            }
            if ($data_order->mes == 'November') {
                $total_orden_mes[] = ['name' => 'Noviembre', 'y' => $data_order->cantidad];
            }
            if ($data_order->mes == 'December') {
                $total_orden_mes[] = ['name' => 'Diciembre', 'y' => $data_order->cantidad];
            }
        }

        $orders = DB::table('orders')
            ->select(DB::raw("count(*) as cantidad, status as estado"))
            ->whereYear('created_at', date('Y'))
            ->groupBy('status')
            ->get();

        foreach ($orders as $order) {
            if ($order->estado == '1') {
                $pedidos[] = ['name' => 'Registrada', 'data' => [$order->cantidad]];
            }
            if ($order->estado == '2') {
                $pedidos[] = ['name' => 'En Proceso', 'data' => [$order->cantidad]];
            }
            if ($order->estado == '3') {
                $pedidos[] = ['name' => 'Completada', 'data' => [$order->cantidad]];
            }
        }

        return view('dashboard.index', compact('mes', 'order_day', 'projects_month', 'orders_date', 'users'), ['data1' => json_encode($pedidos), 'data2' => json_encode($total_orden_mes)]);
    }
}
