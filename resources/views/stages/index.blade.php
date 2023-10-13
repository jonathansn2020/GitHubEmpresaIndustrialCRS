@extends('adminlte::page')

@section('title', 'Lista de Etapas de fabricación')

@section('content_header')

@stop
@section('content')
@include('stages.modal.stage-create')
@include('stages.modal.stage-edit')
<div class="py-3">
    <div class="card">
        <div class="card-header py-3" style="background-color: rgb(33,136,201);">
            <span class="col-form-label col-form-label-lg text-white">Lista de etapas fabricación</span>
            @can('Crear Etapas')
                <a style="border-radius:50%" data-bs-toggle="modal" data-bs-target="#stage-create-modal" data-toggle="tooltip" data-placement="bottom" title="Agregar nuevo registro" class="btn btn-success btn-sm float-right"><i class="fas fa-plus" style="color:white"></i></a>
            @endcan
        </div>

        <input type="hidden" class="can_edit" value="{{auth()->user()->can('Actualizar Etapas')}}">
        <input type="hidden" class="can_delete" value="{{auth()->user()->can('Eliminar Etapas')}}">

        <div class="card-body table-responsive col-form-label col-form-label-sm">
            <table id="mytablestage" class="table table-bordered table-hover" width="100%">
                <thead style="background-color: rgb(204,204,204);">
                    <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th width="10px">Acciones</th>
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
<script src="{{asset('app/js/stage.js')}}"></script>
@stop