@extends('adminlte::page')

@section('title', 'Lista de Proyectos')

@section('content_header')

@stop
@section('content')
@include('projects.modal.project-edit-modal')
@include('projects.modal.project-show-modal')
@include('projects.modal.project-activities-modal')
<div class="py-3">
    <div class="card">
        <div class="card-header py-3" style="background-color: rgb(33,136,201);">
            <span class="col-form-label col-form-label-lg text-white">Lista de proyectos de fabricación</span>
        </div>
        <div class="d-flex justify-content-center text-center mt-2">
            <div class="mr-2">
                <small class="fw-bold">Codigo Orden cliente:</small>
                <input type="text" class="form-control form-control-sm mr-3 border-info" name="filter_order_business" id="filter_order_business" placeholder="Buscar">
            </div>
            <div class="mr-2">
                <small class="fw-bold">Proyecto:</small>
                <input type="text" class="form-control form-control-sm border-info" name="filter_name" id="filter_name" placeholder="Buscar">
            </div>
            <div class="mr-2">
                <small class="text-center fw-bold">Inic.Planificado:</small>
                <input type="date" class="form-control form-control-sm border-info" name="filter_start_date_p" id="filter_start_date_p">
            </div>
            <div class="mr-2">
                <small class="text-center fw-bold">Fin.Planificado:</small>
                <input type="date" class="form-control form-control-sm border-info" name="filter_expected_date_p" id="filter_expected_date_p">
            </div>
            <div>
                <small class="fw-bold">Estado:</small>
                <select class="form form-control form-control-sm border-info" name="filter_status" id="filter_status">
                    <option value="">TODOS</option>
                    <option value="1">REGISTRADA</option>
                    <option value="2">EN PROCESO</option>
                    <option value="3">COMPLETADA</option>
                </select>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-2 mb-1">
            <button class="btn btn-sm btn-info w-25 text-white" onclick="search()"><i class="fas fa-search"></i> BUSCAR</button>
        </div>

        <input type="hidden" class="can_planning" value="{{auth()->user()->can('Planificar Proyectos')}}">
        <input type="hidden" class="can_view" value="{{auth()->user()->can('Actualizar Ordenes')}}">
        <input type="hidden" class="can_edit" value="{{auth()->user()->can('Actualizar Proyectos')}}">

        <div class="card-body table-responsive" style="font-size:13px">
            <table id="myTableProject" class="table table-bordered table-hover" width="100%">
                <thead style="background-color: rgb(204,204,204);">
                    <tr>
                        <th>Codigo</th>
                        <th>Proyecto</th>
                        <th>Ord.Cliente</th>                        
                        <th>Inic.Planificado</th>
                        <th>Fin.Planificado</th>
                        <th>Fin.Real</th>
                        <th>Estado</th>
                        <th width="10px">Acciones</th>
                        <th width="10px"></th>
                        <th width="10px"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@stop
@section('css')
@include('layout-admin.base-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
@stop
@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
@include('layout-admin.base-js')
<script src="{{asset('app/js/project.js')}}"></script>
<script src="{{asset('app/js/planning.js')}}"></script>
@stop