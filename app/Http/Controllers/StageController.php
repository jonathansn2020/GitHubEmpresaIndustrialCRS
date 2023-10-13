<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stage;
use App\Http\Requests\UpdateStage;
use App\Http\Requests\StoreStage;

class StageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('stages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function liststages()
    {
        $stages = Stage::select('id', 'name')->paginate();

        return response()->json($stages);
    }

    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStage $request)
    {
        $stage = Stage::create([
            'name'  => $request->input('name')
        ]);

        return response()->json(['message' => "Se registro la etapa $stage->name con exito!"]);
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
    public function edit(Stage $stage)
    {
        return response()->json($stage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStage $request, Stage $stage)
    {       
        $stage->update([
            'name'  => $request->input('name_stage_edit')
        ]);

        return response()->json(['message' => "Se actualizó la etapa $stage->name con exito!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stage $stage)
    {
        $stage->delete();

        return response()->json(['message' => 'La etapa fue eliminada correctamente!']);
    }
}
