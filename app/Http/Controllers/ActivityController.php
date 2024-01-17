<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Http\Requests\StoreActivity;
use App\Http\Requests\UpdateActivity;
use App\Models\Stage;
use Exception;

class ActivityController extends Controller
{

    public function index()
    {

        $stages = Stage::all();
        return view('activities.index', compact('stages'));
    }

    public function listactivities()
    {

        $activities = Activity::join('stages', 'stages.id', '=', 'activities.stage_id')
            ->select(
                'activities.id as id',
                'activities.name as name',
                'stages.name as fase'
            )
            ->orderby('activities.id')
            ->paginate();        

        return response()->json($activities);
    }

    public function store(StoreActivity $request)
    {       
        $activity = Activity::create([
            'name'      => $request->input('name'),
            'stage_id'  => $request->input('stage_id')
        ]);

        return response()->json(['message' => "Se registro la actividad $activity->name con exito!"]);
    }

    public function edit(Activity $activity)
    {

        return response()->json($activity);

    }

    public function update(UpdateActivity $request, Activity $activity)
    {             
        $activity->update([
            'name'      => $request->input('name_edit'),
            'stage_id'  => $request->input('stage_id_edit')
        ]);

        return response()->json(['message' => "Se actualizó la actividad $activity->name con exito!"]);
    }

    public function destroy(Activity $activity)
    {

        $activity->delete();

        return response()->json(['message' => 'La actividad fue eliminada correctamente!']);
    }
}
