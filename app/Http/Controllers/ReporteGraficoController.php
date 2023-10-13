<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ReporteGraficoController extends Controller
{
    public function orderLate()
    {
        $orders_month = [];
        $orders = DB::table('orders')
            ->select(DB::raw("count(*) as cantidad, DATE_FORMAT(expected_date, '%M') as mes"))
            ->whereMonth('end_date', '>=', DB::raw("month(expected_date)"))
            ->whereDay('end_date', '>', DB::raw("day(expected_date)"))            
            ->whereYear('expected_date', date('Y'))
            ->groupBy('mes')
            ->orderBy('expected_date')
            ->get();

        foreach ($orders as $order) {
            if ($order->mes == 'January') {
                $orders_month[] = ['name' => 'Enero', 'y' => $order->cantidad];
            }
            if ($order->mes == 'February ') {
                $orders_month[] = ['name' => 'Febrero', 'y' => $order->cantidad];
            }
            if ($order->mes == 'March ') {
                $orders_month[] = ['name' => 'Marzo', 'y' => $order->cantidad];
            }
            if ($order->mes == 'April ') {
                $orders_month[] = ['name' => 'Abril', 'y' => $order->cantidad];
            }
            if ($order->mes == 'May') {
                $orders_month[] = ['name' => 'Mayo', 'y' => $order->cantidad];
            }
            if ($order->mes == 'June') {
                $orders_month[] = ['name' => 'Junio', 'y' => $order->cantidad];
            }
            if ($order->mes == 'July') {
                $orders_month[] = ['name' => 'Julio', 'y' => $order->cantidad];
            }
            if ($order->mes == 'August') {
                $orders_month[] = ['name' => 'Agosto', 'y' => $order->cantidad];
            }
            if ($order->mes == 'September') {
                $orders_month[] = ['name' => 'Setiembre', 'y' => $order->cantidad];
            }
            if ($order->mes == 'October') {
                $orders_month[] = ['name' => 'Octubre', 'y' => $order->cantidad];
            }
            if ($order->mes == 'November') {
                $orders_month[] = ['name' => 'Noviembre', 'y' => $order->cantidad];
            }
            if ($order->mes == 'December') {
                $orders_month[] = ['name' => 'Diciembre', 'y' => $order->cantidad];
            }
        }

        return view('graficos.orders_late', ['data1' => json_encode($orders_month)]);
    }

    public function grafico_orden_retraso(Request $request)
    {
        $fechaInicio = date($request->month_start);
        $fechaFin = date($request->month_end);

        $fecha_inicio = strtotime($fechaInicio);
        $fecha_fin = strtotime($fechaFin);

        $mes_inicio = date("n", $fecha_inicio);
        $mes_fin = date("n", $fecha_fin);
        $año = date("Y", $fecha_inicio);

        $data = [];

        $orders_filter = DB::table('orders')
            ->select(DB::raw("count(*) as cantidad, DATE_FORMAT(expected_date, '%M') as mes"))
            ->whereDay('end_date', '>', DB::raw("day(expected_date)"))
            ->whereMonth('end_date', '>=', DB::raw("month(expected_date)"))
            ->whereMonth('expected_date', '>=', $mes_inicio)
            ->whereMonth("expected_date", '<=', $mes_fin)
            ->whereYear('expected_date', $año)
            ->groupBy('mes')
            ->orderBy('expected_date')
            ->get();

        foreach ($orders_filter as $order_filter) {
            if ($order_filter->mes == 'January') {
                $data[] = ['name' => 'Enero', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'February ') {
                $data[] = ['name' => 'Febrero', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'March ') {
                $data[] = ['name' => 'Marzo', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'April ') {
                $data[] = ['name' => 'Abril', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'May') {
                $data[] = ['name' => 'Mayo', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'June') {
                $data[] = ['name' => 'Junio', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'July') {
                $data[] = ['name' => 'Julio', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'August') {
                $data[] = ['name' => 'Agosto', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'September') {
                $data[] = ['name' => 'Setiembre', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'October') {
                $data[] = ['name' => 'Octubre', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'November') {
                $data[] = ['name' => 'Noviembre', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'December') {
                $data[] = ['name' => 'Diciembre', 'y' => $order_filter->cantidad];
            }
        }

        return response()->json($data);
    }

    public function orderTime()
    {
        $orders_month = [];
        $orders = DB::table('orders')
            ->select(DB::raw("count(*) as cantidad, DATE_FORMAT(expected_date, '%M') as mes"))
            ->whereDay('expected_date', '>=', DB::raw("day(end_date)"))
            ->whereMonth('expected_date', '>=', DB::raw("month(end_date)"))
            ->whereNotNull('end_date')
            ->whereYear('expected_date', date('Y'))
            ->groupBy('mes')
            ->orderBy('expected_date')
            ->get();

        foreach ($orders as $order) {
            if ($order->mes == 'January') {
                $orders_month[] = ['name' => 'Enero', 'y' => $order->cantidad];
            }
            if ($order->mes == 'February ') {
                $orders_month[] = ['name' => 'Febrero', 'y' => $order->cantidad];
            }
            if ($order->mes == 'March ') {
                $orders_month[] = ['name' => 'Marzo', 'y' => $order->cantidad];
            }
            if ($order->mes == 'April ') {
                $orders_month[] = ['name' => 'Abril', 'y' => $order->cantidad];
            }
            if ($order->mes == 'May') {
                $orders_month[] = ['name' => 'Mayo', 'y' => $order->cantidad];
            }
            if ($order->mes == 'June') {
                $orders_month[] = ['name' => 'Junio', 'y' => $order->cantidad];
            }
            if ($order->mes == 'July') {
                $orders_month[] = ['name' => 'Julio', 'y' => $order->cantidad];
            }
            if ($order->mes == 'August') {
                $orders_month[] = ['name' => 'Agosto', 'y' => $order->cantidad];
            }
            if ($order->mes == 'September') {
                $orders_month[] = ['name' => 'Setiembre', 'y' => $order->cantidad];
            }
            if ($order->mes == 'October') {
                $orders_month[] = ['name' => 'Octubre', 'y' => $order->cantidad];
            }
            if ($order->mes == 'November') {
                $orders_month[] = ['name' => 'Noviembre', 'y' => $order->cantidad];
            }
            if ($order->mes == 'December') {
                $orders_month[] = ['name' => 'Diciembre', 'y' => $order->cantidad];
            }
        }

        return view('graficos.orders_time', ['data1' => json_encode($orders_month)]);
    }

    public function grafico_orden_tiempo(Request $request)
    {
        $fechaInicio = date($request->month_start);
        $fechaFin = date($request->month_end);

        $fecha_inicio = strtotime($fechaInicio);
        $fecha_fin = strtotime($fechaFin);

        $mes_inicio = date("n", $fecha_inicio);
        $mes_fin = date("n", $fecha_fin);
        $año = date("Y", $fecha_inicio);

        $data = [];

        $orders_filter = DB::table('orders')
            ->select(DB::raw("count(*) as cantidad, DATE_FORMAT(expected_date, '%M') as mes"))
            ->whereDay('expected_date', '>=', DB::raw("day(end_date)"))
            ->whereMonth('expected_date', '>=', DB::raw("month(end_date)"))
            ->whereMonth('expected_date', '>=', $mes_inicio)
            ->whereMonth('expected_date', '<=', $mes_fin)
            ->whereYear('expected_date', date('Y'))
            ->whereNotNull('end_date')
            ->groupBy('mes')
            ->orderBy('expected_date')
            ->get();

        foreach ($orders_filter as $order_filter) {
            if ($order_filter->mes == 'January') {
                $data[] = ['name' => 'Enero', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'February ') {
                $data[] = ['name' => 'Febrero', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'March ') {
                $data[] = ['name' => 'Marzo', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'April ') {
                $data[] = ['name' => 'Abril', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'May') {
                $data[] = ['name' => 'Mayo', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'June') {
                $data[] = ['name' => 'Junio', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'July') {
                $data[] = ['name' => 'Julio', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'August') {
                $data[] = ['name' => 'Agosto', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'September') {
                $data[] = ['name' => 'Setiembre', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'October') {
                $data[] = ['name' => 'Octubre', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'November') {
                $data[] = ['name' => 'Noviembre', 'y' => $order_filter->cantidad];
            }
            if ($order_filter->mes == 'December') {
                $data[] = ['name' => 'Diciembre', 'y' => $order_filter->cantidad];
            }
        }

        return response()->json($data);
    }
}
