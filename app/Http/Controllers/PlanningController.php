<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Http\Requests\StorePlanning;
use Exception;
use Carbon\Carbon;
use App\Models\Project;

class PlanningController extends Controller
{

    public function showOneActivity(StorePlanning $request)
    {
        $activity = [];

        try {

            $actv = Activity::create([
                'name'      => $request->name_activity,
                'stage_id'  => $request->stage_id,
                'user_id'   => auth()->user()->id
            ]);


            $activity[0] = $request->name_activity;
            $activity[1] = $request->desc_fase;
            $activity[2] = $request->priority;
            $activity[3] = $request->start_date;
            $activity[4] = $request->expected_date;
            $activity[5] = $request->desc_ope;
            $activity[6] = $request->stage_id;
            $activity[7] = $request->select_f;
            $activity[8] = $actv->id;
            $activity[9] = $request->operator_id;
        } catch (Exception $e) {
            return response()->json(['message' => 'No se agrego la actividad al proyecto', 'error' => $e->getMessage()]);
        }

        return response()->json(['success' => $activity]);
    }

    public function store(Request $request)
    {
        date_default_timezone_set("America/Lima");

        $actividades  = json_decode($request->objetos);
        $activity = new Activity();
        $id = "";

        try {
            foreach ($actividades as $actividad) {

                $data_start = Carbon::createFromFormat('d/m/Y', $actividad->start_date);
                $data_expected = Carbon::createFromFormat('d/m/Y', $actividad->expected_date);

                $activity->projects()->attach(
                    (int)$actividad->activity_id,
                    [
                        'activity_id' => $actividad->activity_id,
                        'priority' => $actividad->priority,
                        'start_date'    => $data_start->format('Y-m-d'),
                        'expected_date' => $data_expected->format('Y-m-d'),
                        'status' => 'Registrada',
                        'project_id' => $actividad->project_id,
                        'operator_id' => $actividad->operator_id
                    ]
                );
                $id = (int)$actividad->project_id;
            }
            $project = Project::find($id);
            $project->update(['status' => 2]);
            $order = $project->order;
            $order->status = '2';
            $order->save();

        } catch (Exception $e) {
            return response()->json(['message' => 'No se registraron las actividades', 'error' => $e->getMessage()]);
        }

        return response()->json(['message' => 'Se registraron las actividades correctamente']);
    }
}
