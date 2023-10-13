<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class CustomerController extends Controller
{ 
    public function index()
    {                
        return view('dashboard-customer.index');
    }
    
    public function listarOrderCustomers(){

        $orders = Order::query()
            ->select('orders.id','orders.order_business','projects.name as radiador','users.name as name',
            'orders.delivery_place','orders.expected_date','orders.end_date','orders.status')            
            ->join('users','users.id','=','orders.user_id')
            ->join('projects','projects.order_id','=','orders.id')            
            ->where('user_id', auth()->user()->id)
            ->orderby('orders.id')
            ->paginate();

        return response()->json($orders);

    }    
    
    public function show(Order $order)
    {
        $order = Order::join('projects','projects.order_id','=','orders.id')
                 ->join('activity_project','activity_project.project_id','=','projects.id')
                 ->select('orders.order_business','orders.expected_date','orders.end_date',
                 'orders.delivery_place','orders.phone','projects.name','projects.progress',
                 'projects.long','projects.width','projects.thickness','projects.rows','projects.tube',
                 'projects.url_photo','projects.status','projects.created_at','activity_project.true_start','projects.end_date_p')
                 ->where('orders.id', $order->id)
                 ->get();        
        
        return response()->json($order);
    }
   
}
