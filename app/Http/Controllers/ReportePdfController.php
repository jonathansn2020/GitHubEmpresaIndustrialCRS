<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Operator;

use Barryvdh\DomPDF\Facade\Pdf;

class ReportePdfController extends Controller
{
    public function orderIndex(){

        return view('pdf.index-report-order');
    }

    public function reportOrderTime(Request $request)
    {
        date_default_timezone_set("America/Lima");

        $date_now = new Carbon();
        $hour = $date_now->toTimeString();       
        $expected_date_i = $request->expected_date_i; 
        $expected_date_f = $request->expected_date_f;       

        $orders = Order::join('users', 'users.id','=', 'orders.user_id')
                        ->join('projects', 'projects.order_id','=', 'orders.id')
                        ->select('orders.id','users.name','orders.order_business', 'projects.name as project',
                        'orders.delivery_place','orders.expected_date','orders.end_date','orders.status')
                        ->whereBetween('orders.expected_date',[$request->expected_date_i, $request->expected_date_f])                       
                        ->where(DB::raw('orders.end_date'),'<=',DB::raw('orders.expected_date'))
                        ->orderby('orders.id')
                        ->get();
        
        $pdf = Pdf::loadView('pdf.report-order-time', compact('orders','date_now','hour','expected_date_i','expected_date_f'));
        return $pdf->stream('report-order-time.pdf');               
    }

    public function activityIndex(){      
       
        $activities = Activity::all();
        return view('pdf.index-report-activity', compact('activities'));
    }

    public function reportActivityRework(Request $request)
    {
        date_default_timezone_set("America/Lima");

        $date_now = new Carbon();
        $hour = $date_now->toTimeString();    
        $start_date_i = $request->start_date_i; 
        $start_date_f = $request->start_date_f;
        $activity_id = $request->activity_id;

        $actividad = Activity::find($request->activity_id);
        
        $activities = DB::table('reworks')
        ->select(DB::raw("projects.name as proyecto, reworks.start_date, 
        reworks.start, reworks.start_hour, reworks.end, reworks.end_hour"))
        ->join('activity_project','activity_project.id','=','reworks.activity_project_id')
        ->join('operators', 'operators.id', '=', 'activity_project.operator_id')
        ->join('activities', 'activities.id', '=', 'activity_project.activity_id')
        ->join('projects', 'projects.id', '=', 'activity_project.project_id')        
        ->where('activity_project.activity_id',$request->activity_id)  
        ->whereBetween('reworks.start_date',[$request->start_date_i, $request->start_date_f])   
        ->orderBy('reworks.start_date')
        ->orderBy('reworks.hour')
        ->get();   

        $pdf = Pdf::loadView('pdf.report-activity-rework', compact('activities','date_now','hour','start_date_i','start_date_f','actividad'));
        return $pdf->stream('report-activity-rework.pdf');   
    }

    public function operatorIndex(){   

        $operators = Operator::all();
        return view('pdf.index-report-operator', compact('operators'));
    }

    public function reportOperatorRework(Request $request)
    {
        date_default_timezone_set("America/Lima");

        $date_now = new Carbon();
        $hour = $date_now->toTimeString();    
        $start_date_i = $request->start_date_i; 
        $start_date_f = $request->start_date_f;
        $operator_id = $request->operator_id;      

        $operator = Operator::find($operator_id);
        
        $operators = DB::table('reworks')
        ->select(DB::raw("orders.order_business, projects.name as proyecto, activities.name as actividad, reworks.start_date, 
        reworks.start, reworks.start_hour, reworks.end, reworks.end_hour"))
        ->join('activity_project','activity_project.id','=','reworks.activity_project_id')
        ->join('operators', 'operators.id', '=', 'activity_project.operator_id')
        ->join('activities', 'activities.id', '=', 'activity_project.activity_id')
        ->join('projects', 'projects.id', '=', 'activity_project.project_id')
        ->join('orders', 'orders.id', '=', 'projects.order_id')
        ->where('activity_project.operator_id',$request->operator_id)  
        ->whereBetween('reworks.start_date',[$request->start_date_i, $request->start_date_f])   
        ->orderBy('reworks.start_date')
        ->orderBy('reworks.hour')
        ->get();               

        $pdf = Pdf::loadView('pdf.report-operator-rework', compact('operators','operator','date_now','hour','start_date_i','start_date_f'));
        return $pdf->stream('report-operator-rework.pdf');   
    }
}
