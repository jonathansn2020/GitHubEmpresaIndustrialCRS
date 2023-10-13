<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Project;
use App\Http\Requests\StoreOrder;
use App\Http\Requests\UpdateOrder;
use Spatie\Permission\Models\Role;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /*public function index()
    {
        $orders = Order::all();
        
        return view('orders.index', compact('orders'));
    }*/
    public function index()
    {

        return view('orders.index');
    }

    public function listorders(Request $request)
    {

        $orders = Order::query()
            ->select('orders.id as id','orders.cod_document','users.name','orders.order_business',
            'orders.delivery_place','orders.expected_date','orders.end_date','orders.status')
            ->join('users','users.id','=','orders.user_id')
            ->when($request->cod_document, fn ($query, $cod_document)
            => $query->where('order_business', 'like', '%' . $cod_document . '%'))
            ->when($request->business, fn ($query, $business)
            => $query->where('users.name', 'like', '%' . $business . '%'))
            ->when($request->expected_date, fn ($query, $expected_date)
            => $query->where('expected_date', $expected_date))
            ->when($request->end_date, fn ($query, $end_date)
            => $query->where('end_date', $end_date))
            ->when($request->status, fn ($query, $status)
            => $query->where('status', 'like', '%' . $status . '%'))
            ->orderby('orders.id')
            ->paginate(10000);
        
        return response()->json($orders);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = Role::with('users')->where('name','Cliente')->get();        
        
        return view('orders.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrder $request)
    {
        $proyectos  = json_decode($request->projects);        
      
        $objeto = new Order();

        try {

            if ($objeto->getCodigoCorrelativo()[0]->codigo == null) {
                $id = "ORF000000000001";
            } else {
                $id = $objeto->getCodigoCorrelativo()[0]->codigo;
            }

            $orden = Order::create([                
                'requested'          => $request->orders['requested'],
                'phone'              => $request->orders['phone'],
                'email'              => $request->orders['email'],
                'delivery_place'     => $request->orders['delivery_place'],
                'expected_date'      => $request->orders['expected_date'],
                'note'               => $request->orders['note'],
                'status'             => '1',
                'cod_document'       => $id,
                'order_business'     => $request->orders['order_business'],
                'user_id'            => $request->orders['user_id']
            ]);

            foreach ($proyectos as $proyecto) {
                Project::create([
                    'name'              => $proyecto->name,
                    'summary'           => $proyecto->summary,
                    'long'              => $proyecto->long,
                    'width'             => $proyecto->width,
                    'thickness'         => $proyecto->thickness,
                    'rows'              => $proyecto->rows,
                    'tube'              => $proyecto->tube,
                    'start_date_p'      => $proyecto->start_date_p,
                    'expected_date_p'   => $proyecto->expected_date_p,                    
                    'status'            => $proyecto->status,
                    'order_id'          => $orden->id

                ]);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'No se registro la orden de fabricación', 'error' => $e->getMessage()]);
        }

        return response()->json(['message' => 'Se realizo el registro de la orden satisfactoriamente']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order = Order::select('orders.id','orders.cod_document','users.name','orders.order_business',
        'orders.requested','orders.phone','orders.email','orders.delivery_place'
        ,'orders.expected_date','orders.end_date','orders.status','orders.note')
        ->join('users','users.id','=','orders.user_id')
        ->where('orders.id', $order->id)
        ->get();

        return response()->json($order);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {       

        $order = Order::select('orders.id','orders.cod_document','users.name','orders.order_business',
        'orders.requested','orders.phone','orders.email','orders.delivery_place'
        ,'orders.expected_date','orders.end_date','orders.status','orders.note')
        ->join('users','users.id','=','orders.user_id')
        ->where('orders.id', $order->id)
        ->get();            
        
        return view('orders.edit', compact('order'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrder $request, Order $order)
    {
        
        $order->update([
            'requested'          => $request->input('requested'),
            'phone'              => $request->input('phone'),
            'email'              => $request->input('email'),
            'delivery_place'     => $request->input('delivery_place'),
            'expected_date'      => $request->input('expected_date'),
            'note'               => $request->input('note'),
            'status'             => $request->input('status'),            
            'order_business'     => $request->input('order_business')          
        ]);

        return redirect()->route('orders.index')->with('info', "La Orden $order->cod_document se actualizó satisfactoriamente");       
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $orden = Order::find($id);
            $orden->delete();
        } catch (Exception $e) {
            return response()->json(['message' => 'No se dio de baja el registro de la orden', 'error' => $e->getMessage()]);
        }
        return response()->json(['message' => 'La orden fue eliminada correctamente!']);
    }
}
