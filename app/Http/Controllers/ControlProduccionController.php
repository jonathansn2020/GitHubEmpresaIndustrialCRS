<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Project;
use App\Models\Rework;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\LoadProject;

class ControlProduccionController extends Controller
{

    public function index()
    {

        return view('plannings.index');
    }

    public function listControlProduccion()
    {

        $projects = Project::join('orders', 'projects.order_id', '=', 'orders.id')
            ->join('users','users.id','=','orders.user_id')
            ->select(
                'projects.id as id',
                'orders.cod_document',
                'users.name as cliente',
                'projects.name',
                'projects.progress',                
                'projects.start_date_p',
                'projects.expected_date_p',
                'projects.end_date_p',
                'projects.url_photo',
                'projects.status'
            )
            ->where('projects.status', '2')
            ->orwhere('projects.status', '3')
            ->orderby('orders.cod_document')
            ->paginate();

        return response()->json($projects);
    }


    public function controlProduccion($id)
    {
        $i = 0;
        $project = Project::find($id);
        $activities = $project->activities;

        foreach ($activities as $a) {
            if ($a->pivot->status == "Completada") {
                $i++;
            }
        }

        $valor = ($i * 100) / ($project->activities->count());
        $avance = round($valor, 2);
        
        return view('plannings.activity-control', compact('activities', 'project', 'avance'));
    }

    public function update(Request $request, $id)
    {
        $avance = "";        
        $i = 0;

        date_default_timezone_set("America/Lima");
        $date_now = new Carbon();

        $activity = Activity::find($id);

        $activity->projects()->updateExistingPivot($request->idproject, [
            'status'    => $request->estado,
            'position' => $request->orden
        ]);

        $project = Project::find($request->idproject);
        $activities = $project->activities;
        $order = $project->order;

        if (($request->origen == "registrada" && $request->estado == "proceso")) {
            $message = "ninguno";
            $activity->projects()->updateExistingPivot($request->idproject, [
                'end_date'    => null,
                'true_start'  => $date_now
            ]);

            $pivot_id_ap = DB::table('activity_project')
                ->where('activity_project.activity_id', $id)
                ->where('activity_project.project_id', $request->idproject)
                ->get();

            $reworks = DB::table('reworks')
                ->where('reworks.activity_project_id', $pivot_id_ap[0]->id)
                ->get();

            foreach ($reworks as $rework) {
                if (isset($rework->start_date) && !isset($rework->start)) {
                    $rework = Rework::find($rework->id);
                    $rework->update([
                        'start'      => $date_now,
                        'start_hour' => $date_now->toTimeString()
                    ]);
                }
            }

            $avance = $project->progress;
        }


        if (($request->origen == "registrada" && $request->estado == "registrada")) {
            $message = "ninguno";
            $activity->projects()->updateExistingPivot($request->idproject, [
                'end_date'    => null
            ]);
            $avance = $project->progress;
        }
        if (($request->origen == "proceso" && $request->estado == "registrada") || ($request->origen == "proceso" && $request->estado == "proceso")) {
            $message = "ninguno";
            $activity->projects()->updateExistingPivot($request->idproject, [
                'end_date'    => null,
            ]);
            $avance = $project->progress;
        }
        if ($request->origen == "completada" && $request->estado == "completada") {
            $activity->projects()->updateExistingPivot($request->idproject, [
                'end_date'    => null,
            ]);
            $avance = $project->progress;
        }
        if ($request->origen == "proceso" && $request->estado == "completada") {

            $message = true;

            $activity->projects()->updateExistingPivot($request->idproject, [
                'end_date'    => $date_now,
            ]);

            $pivot_id_ap = DB::table('activity_project')
                ->where('activity_project.activity_id', $id)
                ->where('activity_project.project_id', $request->idproject)
                ->get();

            $reworks = DB::table('reworks')
                ->where('reworks.activity_project_id', $pivot_id_ap[0]->id)
                ->get();

            foreach ($reworks as $rework) {
                if (isset($rework->start_date) && !isset($rework->end)) {
                    $rework = Rework::find($rework->id);
                    $rework->update([
                        'end'      => $date_now,
                        'end_hour' => $date_now->toTimeString()
                    ]);                    
                }
            }

            foreach ($activities as $a) {
                if ($a->pivot->status == "Completada") {
                    $i++;
                }
            }
            $valor = ($i * 100) / ($project->activities->count());
            $avance = round($valor, 2);
            $project->progress = $avance;
            if ($project->progress == 100) {
                $project->end_date_p = $date_now;
                $project->status = '3';
                $order->status = '3';
                $order->end_date = $date_now;
            }
            $project->save();
            $order->save();
        }
        if ($request->origen == "completada" && $request->estado == "proceso") {

            $message = false;

            $activity->projects()->updateExistingPivot($request->idproject, [
                'end_date'    => null,
            ]);

            $id_activity_project = DB::table('activity_project')
                ->where('activity_project.activity_id', $id)
                ->where('activity_project.project_id', $request->idproject)
                ->get();

            Rework::create([
                'start_date'            => $date_now,
                'hour'                  => $date_now->toTimeString(),
                'activity_project_id'   => $id_activity_project[0]->id
            ]);

            foreach ($activities as $a) {
                if ($a->pivot->status == "Proceso") {
                    $i++;
                    break;
                }
            }
            $valor = ($i * 100) / ($project->activities->count());
            $avance = round($project->progress - $valor, 2);
            if ($avance < 0.09) {
                $project->progress = 0.00;
            } else {
                $project->progress = $avance;
            }

            if ($project->progress < 100) {
                $project->end_date_p = null;
                $project->status = '2';
                $order->status = '2';
                $order->end_date = null;
            }

            $project->save();
            $order->save();
        }
        if ($request->origen == "completada" && $request->estado == "registrada") {

            $message = false;
            
            $activity->projects()->updateExistingPivot($request->idproject, [
                'end_date'    => null,
            ]);

            $id_activity_project = DB::table('activity_project')
                ->where('activity_project.activity_id', $id)
                ->where('activity_project.project_id', $request->idproject)
                ->get();

            Rework::create([
                'start_date'            => $date_now,
                'hour'                  => $date_now->toTimeString(),
                'activity_project_id'   => $id_activity_project[0]->id
            ]);

            foreach ($activities as $a) {
                if ($a->pivot->status == "Registrada") {
                    $i++;
                    break;
                }
            }
            $valor = ($i * 100) / ($project->activities->count());
            $avance = round($project->progress - $valor, 2);
            if ($avance < 0.09) {
                $project->progress = 0.00;
            } else {
                $project->progress = $avance;
            }

            if ($project->progress < 100) {
                $project->status = '2';
                $project->end_date_p = null;
                $order->status = '2';
                $order->end_date = null;
            }
            $order->save();
            $project->save();
        }

        return response()->json(['avance' => $avance, 'message' => $message]);
    }

    public function upload(LoadProject $request){
        
        if ($request->file('file_input')) {
            $file = $request->file('file_input');
            $name = $file->getClientOriginalName();
            $valor = Storage::putFileAs('public/projects', $file, $name);            
            $url = str_replace('public/','storage/',$valor);  
            
            $project = Project::find($request->project_id);
            
            $project->update(['url_photo'  => $url]);            

            return response()->json(['message' => 'Se subió la imagen del radiador terminado']);
        }

    }
}
