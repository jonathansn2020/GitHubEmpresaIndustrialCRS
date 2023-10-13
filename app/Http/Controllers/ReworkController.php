<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Activity_project;
use App\Models\Rework;
use Illuminate\Support\Facades\DB;


class ReworkController extends Controller
{
    public function index($id)
    {       
        $reprocesos = [];

        $project = Project::find($id);

        $reworks = DB::table('activity_project')
            ->select(DB::raw("count(*) as cantidad, activities.name as actividad, projects.name as radiador"))
            ->join('reworks', 'reworks.activity_project_id', '=', 'activity_project.id')
            ->join('projects', 'projects.id', '=', 'activity_project.project_id')
            ->join('activities', 'activities.id', '=', 'activity_project.activity_id')
            ->where('activity_project.project_id', $id)
            ->groupBy('activities.name', 'projects.name')
            ->orderBy('reworks.start_date')
            ->orderBy('reworks.hour')
            ->get();

        foreach ($reworks as $rework) {
            $reprocesos[] = ['name' => $rework->actividad, 'y' => $rework->cantidad];
        }
        return view('reworks.index', compact('project'), ['dataR' => json_encode($reprocesos)]);
    }

    public function showRework($id)
    {

        $project = Project::find($id);        

        $reworks =  DB::table('activity_project')
            ->select(DB::raw("activities.id as actividad_id, activities.name as actividad, reworks.activity_project_id as id_pivot"))
            ->join('reworks', 'reworks.activity_project_id', '=', 'activity_project.id')
            ->join('projects', 'projects.id', '=', 'activity_project.project_id')
            ->join('activities', 'activities.id', '=', 'activity_project.activity_id')
            ->where('activity_project.project_id', $id)
            ->groupBy('actividad_id', 'actividad', 'id_pivot')
            ->orderBy('reworks.start_date')
            ->orderBy('reworks.hour')
            ->get();

        return view('reworks.show', compact('project', 'reworks'));
    }

    public function listRework(Request $request, $id)
    {

        $rework = Rework::select('*')
            ->where('activity_project_id', $id)
            ->orderBy('start')
            ->get();

        $data_ap =  DB::table('activity_project')
                    ->select(DB::raw("activities.name as actividad, activity_project.start_date, 
                    activity_project.expected_date,activity_project.true_start, activity_project.end_date,
                    operators.name as operator"))
                    ->join('reworks', 'reworks.activity_project_id', '=', 'activity_project.id')
                    ->join('operators', 'operators.id', '=', 'activity_project.operator_id')
                    ->join('projects', 'projects.id', '=', 'activity_project.project_id')
                    ->join('activities', 'activities.id', '=', 'activity_project.activity_id')
                    ->where('activity_project.project_id', $request->project_id)
                    ->where('activity_project.activity_id', $request->activityId)
                    ->where('reworks.activity_project_id', $id)
                    ->distinct()
                    ->get();                  
        
        return response()->json(['data' => $rework, "data2" => $data_ap]);
    }
}
