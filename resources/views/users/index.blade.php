@extends('adminlte::page')

@section('title', 'Lista de usuarios')

@section('content_header')

@stop
@section('content')
@include('users.modal.user-create-modal')
@include('users.modal.user-update-password-modal')
<div class="py-3">
    <div class="card">
    <div class="card-header py-3" style="background-color: rgb(33,136,201);">
            <span class="col-form-label col-form-label-lg text-white">Lista de usuarios del sistema</span>
            @can('Crear Usuarios')
                <a style="background-color:#3A416F;border-radius:50%" data-bs-toggle="modal" data-bs-target="#user-create-modal" data-toggle="tooltip" data-placement="bottom" title="Agregar nuevo usuario" class="btn btn-sm float-right text-white"><i class="fas fa-plus" style="color:white"></i></a>
            @endcan
        </div>   
        
        <input type="hidden" class="can_edit" value="{{auth()->user()->can('Actualizar Usuarios')}}">
        <input type="hidden" class="can_delete" value="{{auth()->user()->can('Eliminar Usuarios')}}">
        <input type="hidden" class="can_pass" value="{{auth()->user()->can('Cambiar Password')}}">

        <div class="card-body table-responsive col-form-label col-form-label-sm">
            <table id="myTableUser" class="table table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Rol</th>
                        <th>Email</th>
                        <th>Acciones</th>                       
                        <th></th>                                            
                        <th></th>                        
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
<script src="{{asset('app/js/user.js')}}"></script>
@stop