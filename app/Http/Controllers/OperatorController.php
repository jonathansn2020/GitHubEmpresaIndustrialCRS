<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operator;
use App\Http\Requests\StoreOperator;
use App\Http\Requests\UpdateOperator;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('operators.index');
    }

    public function listarOperators()
    {

        $operators = Operator::select('id', 'name', 'document', 'phone', 'email', 'position')->paginate();

        return response()->json($operators);
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
    public function store(StoreOperator $request, Operator $operator)
    {
        $operator = $operator::create([
            'name'      => $request->input('name'),
            'document'  => $request->input('document'),
            'phone'     => $request->input('phone'),
            'email'     => $request->input('email'),
            'position'  => $request->input('position')
        ]);

        return response()->json(['message' => "Se registro el operador $operator->name con exito!"]);
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
    public function edit(Operator $operator)
    {
        return view('operators.edit', compact('operator'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOperator $request, Operator $operator)
    {

        $operator->update([
            'name'      => $request->input('name'),
            'document'  => $request->input('document'),
            'phone'     => $request->input('phone'),
            'email'     => $request->input('email'),
            'position'  => $request->input('position')
        ]);

        return response()->json(['message' => "Se actualizó el operario $operator->name con exito!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Operator $operator)
    {
        $operator->delete();

        return response()->json(['message' => 'El operador fue eliminada correctamente!']);
    }
}
