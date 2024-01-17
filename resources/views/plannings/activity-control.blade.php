@extends('adminlte::page')

@section('title', 'Control de la Producción')

@section('content_header')

@stop
@section('content')
@include('plannings.modal.activity-comment')

<div class="container">
    <div class="row">
        <h1 class="col-form-label col-form-label-md text-dark" style="background-color: rgb(204,204,204)">PROYECTO: {{$project->name}}
            <input type="hidden" id="project_id" value="{{$project->id}}">
            <div class="ml-2 float-right"><a href="{{route('control.index')}}" class="btn btn-success btn-sm"><i class="fa fa-arrow-circle-left "></i></a></div>
            <div class="float-right">INICIO PLANIFICADO: {{date("d/m/Y", strtotime($project->start_date_p))}}</div>
            <input type="hidden" id="idproject" value="{{$project->id}}"><br>
            <div class="float-right">FIN PLANIFICADO: {{date("d/m/Y", strtotime($project->expected_date_p))}}</div>
            <span class="progress-project-des">{{$avance}}% completado</span>
            <div class="progress mt-2" style="width:25%">
                @if($avance < 40) <div style="width:{{$avance . '%'}}" class="progress-bar progress-bar-striped bg-secondary progress-bar-animated progress-project">
            </div>
            @elseif($avance >= 40 && $avance < 80) <div style="width:{{$avance . '%'}}" class="progress-bar progress-bar-striped bg-warning progress-bar-animated progress-project">
    </div>
    @elseif($avance >= 80)
    <div style="width:{{$avance . '%'}}" class="progress-bar progress-bar-striped bg-success progress-bar-animated progress-project"></div>
    @endif
</div>
</h1>
<div class="col-md-4 mt-2">
    <div class="card">
        <div class="card-header bg-secondary">
            Actividades Registradas
        </div>
        <div id="entrada" class="list-group">
            @foreach ($activities as $tarea)
            @if($tarea->pivot->status == 'Entrada')
            <div class="list-group-item col-form-label col-form-label-sm" data-id="{{ $tarea->id }}">
                {{ $tarea->name }}
                <div class="mt-1">
                    <div class="badge bg-primary">{{$tarea->pivot->priority}}</div>
                    <button type="button" class="btn btn-sm badge bg-warning mb-1 task-button" data-bs-toggle="modal" data-bs-target="#activity-comment-modal" data-taskid="{{ $tarea->pivot->id }}">
                        Ver más
                    </button>
                    <div style="font-size: 12px;float:right">Fecha inicio: {{date("d/m/Y", strtotime($tarea->pivot->start_date))}}</div>
                </div>
                <span style="font-size: 12px;">#{{$tarea->pivot->id}}</span>
                <span style="font-size: 12px;float:right">{{$tarea->stage->name}}</span>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>

<div class="col-md-4 mt-2">
    <div class="card">
        <div class="card-header bg-warning text-white">
            Actividades En proceso
        </div>
        <div id="proceso" class="list-group">
            @foreach ($activities as $tarea)
            @if($tarea->pivot->status == 'Proceso')
            <div class="list-group-item col-form-label col-form-label-sm" data-id="{{ $tarea->id }}">
                {{ $tarea->name }}
                <div class="mt-1">
                    <div class="badge bg-primary">{{$tarea->pivot->priority}}</div>
                    <button type="button" class="btn btn-sm badge bg-warning mb-1 task-button" data-bs-toggle="modal" data-bs-target="#activity-comment-modal" data-taskid="{{ $tarea->pivot->id }}">
                        Ver más
                    </button>
                    <div style="font-size: 12px;float:right">Fecha inicio: {{date("d/m/Y", strtotime($tarea->pivot->start_date))}}</div>
                </div>
                <span style="font-size: 12px;">#{{$tarea->pivot->id}}</span>
                <span style="font-size: 12px;float:right">{{$tarea->stage->name}}</span>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>

<div class="col-md-4 mt-2">
    <div class="card">
        <div class="card-header bg-success">
            Actividades Completadas
            @if($avance == 100)
            <div style="float:right;display:inline-block">
                <svg onclick="selectFile()" xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-camera ml-1" viewBox="0 0 16 16">
                    <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z" />
                    <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
                </svg>
                <span id="nameFile"></span>
                <button type="button" class="btn btn-primary btn-sm ml-1" onclick="subir_photo();"><i class="fas fa-check" style="color:white"></i></button>
            </div>
            @endif
        </div>
        <div id="completada" class="list-group">
            @foreach ($activities as $tarea)
            @if($tarea->pivot->status == 'Completada')
            <div class="list-group-item col-form-label col-form-label-sm" data-id="{{ $tarea->id }}">
                {{ $tarea->name }}
                <div class="mt-1">
                    <div class="badge bg-primary">{{$tarea->pivot->priority}}</div>
                    <button type="button" class="btn btn-sm badge bg-warning mb-1 task-button" data-bs-toggle="modal" data-bs-target="#activity-comment-modal" data-taskid="{{ $tarea->pivot->id }}">
                        Ver más
                    </button>
                    <div style="font-size: 12px;float:right">Fecha inicio: {{date("d/m/Y", strtotime($tarea->pivot->start_date))}}</div>
                </div>
                <span style="font-size: 12px;">#{{$tarea->pivot->id}} </span>
                <span style="font-size: 12px;float:right">{{$tarea->stage->name}}</span>
            </div>
            @endif
            @endforeach
        </div>

        

    </div>
</div>
</div>

</div>

@stop
@section('css')
@include('layout-admin.base-css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<style type="text/css">
    .list-group {
        min-height: 10px;
    }
</style>
@stop
@section('js')
@include('layout-admin.base-js')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{asset('app/js/control-produccion.js')}}"></script>
@stop              
        
    
