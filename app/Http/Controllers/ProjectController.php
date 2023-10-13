<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\StoreProject;
use App\Http\Requests\UpdateProject;
use App\Models\Activity;
use App\Models\Stage;
use App\Models\Operator;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function showProject(StoreProject $request)
    {

        $request->validate([
            'name'              => 'required',
            'summary'           => 'nullable',
            'long'              => 'required',
            'width'             => 'required',
            'thickness'         => 'required',
            'rows'              => 'required',
            'tube'              => 'required',
            'start_date_p'      => 'required',
            'expected_date_p'   => 'required',
        ]);

        $project = [];

        try {
            $project[0] = $request->name;
            $project[2] = $request->start_date_p;
            $project[3] = $request->expected_date_p;
        } catch (Exception $e) {
            return response()->json(['message' => 'No se agrego el proyecto a fabricar', 'error' => $e->getMessage()]);
        }

        return response()->json(['success' => $project]);
    }

    public function index()
    {
        $stages = Stage::all();
        $operators = Operator::all();
        return view('projects.index', compact('stages', 'operators'));
    }

    public function listprojects(Request $request)
    {

        $projects = Project::join('orders', 'projects.order_id', '=', 'orders.id')
            ->select(
                'projects.id',
                'projects.name',
                'orders.cod_document',
                'orders.order_business',
                'projects.progress',
                'projects.start_date_p',
                'projects.expected_date_p',
                'projects.end_date_p',
                'projects.status'                
            )
            ->when($request->order_business, fn ($query, $order_business)
            => $query->where('orders.order_business', 'like', '%' . $order_business . '%'))
            ->when($request->name, fn ($query, $name)
            => $query->where('projects.name', 'like', '%' . $name . '%'))
            ->when($request->start_date_p, fn ($query, $start_date_p)
            => $query->where('projects.start_date_p', $start_date_p . '%'))
            ->when($request->expected_date_p, fn ($query, $expected_date_p)
            => $query->where('projects.expected_date_p', $expected_date_p))
            ->when($request->status, fn ($query, $status)
            => $query->where('projects.status', 'like', '%' . $status . '%'))
            ->orderby('projects.id')
            ->paginate();

        return response()->json($projects);
    }

    public function showProjectPlannig($id)
    {
        try {
            $project = Project::find($id);
            $order = $project->order;

            $user = $order->user;

            $plannig = DB::table('activity_project')
                ->select(DB::raw("activities.name as actividad, stages.name as etapa, 
                activity_project.priority as prioridad, activity_project.start_date as fecha_inicio,
                activity_project.expected_date as fecha_fin, activity_project.true_start as inicio_real, 
                activity_project.end_date as fin_real, operators.name as operador, activity_project.status"))
                ->join('projects', 'projects.id', '=', 'activity_project.project_id')
                ->join('activities', 'activities.id', '=', 'activity_project.activity_id')
                ->join('stages', 'stages.id', '=', 'activities.stage_id')
                ->join('operators', 'operators.id', '=', 'activity_project.operator_id')
                ->where('activity_project.project_id', $id)
                ->orderBy('activity_project.activity_id')
                ->get();
        } catch (Exception $e) {
            return response()->json(['message' => 'Hubo un problema en obtener los datos del proyecto', 'error' => $e->getMessage()]);
        }

        return response()->json(['data' => $project, 'order' => $order, 'user' => $user, 'actividades' => $plannig]);
    }

    public function show($id)
    {
        try {
            $project = Project::find($id);
            $activities = Activity::with('stage')->get();
            $operators = Operator::all();
        } catch (Exception $e) {
            return response()->json(['message' => 'Hubo un problema en obtener los datos del proyecto', 'error' => $e->getMessage()]);
        }

        return response()->json(['data' => $project, 'activities' => $activities, 'operators' => $operators]);
    }

    public function edit($id)
    {
        try {
            $project = Project::find($id);
            $order = $project->order;

            $user = $order->user;

            $plannig = DB::table('activity_project')
                ->select(DB::raw("activities.name as actividad, stages.name as etapa, 
                activity_project.priority as prioridad, activity_project.start_date as fecha_inicio,
                activity_project.expected_date as fecha_fin, activity_project.true_start as inicio_real, 
                activity_project.end_date as fin_real, operators.name as operador, activity_project.status"))
                ->join('projects', 'projects.id', '=', 'activity_project.project_id')
                ->join('activities', 'activities.id', '=', 'activity_project.activity_id')
                ->join('stages', 'stages.id', '=', 'activities.stage_id')
                ->join('operators', 'operators.id', '=', 'activity_project.operator_id')
                ->where('activity_project.project_id', $id)
                ->orderBy('activity_project.activity_id')
                ->get();

        } catch (Exception $e) {
            return response()->json(['message' => 'Hubo un problema en obtener los datos del proyecto', 'error' => $e->getMessage()]);
        }

        return response()->json(['data' => $project, 'order' => $order, 'user' => $user, 'actividades' => $plannig]);
    }

    public function update(UpdateProject $request, Project $project)
    {
        try {

            $project->update($request->all());
        } catch (Exception $e) {
            return response()->json(['message' => 'No se actualizo el registro del proyecto', 'error' => $e->getMessage()]);
        }
        return response()->json(['message' => 'Datos editados correctamente!']);
    }
}
