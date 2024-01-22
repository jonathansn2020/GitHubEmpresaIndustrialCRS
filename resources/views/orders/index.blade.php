@extends('adminlte::page')

@section('title', 'Lista de Ordenes de fabricación')

@section('content_header')

@stop
@section('content')
@include('orders.modal.order-show-modal')
<div class="py-3">
    @if (session('info'))
        <div class="alert alert-success" role="alert">
            <strong>Muy bien!</strong> {{ session('info') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header py-3" style="background-color: rgb(33,136,201);">
            <span class="col-form-label col-form-label-lg text-white">Lista de ordenes de fabricación</span>
            @can('Crear Ordenes')
                <a href="{{route('orders.create')}}" style="border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Agregar nuevo registro" class="btn btn-success btn-sm float-right"><i class="fas fa-plus" style="color:white"></i></a>
            @endcan
        </div>
        <div class="d-flex justify-content-center text-center mt-2">
            <div class="mr-2">
                <small class="fw-bold">Codigo Orden cliente:</small>
                <input type="text" class="form-control form-control-sm mr-3 border-info" name="filter_cod_document" id="filter_cod_document" placeholder="Buscar">
            </div>
            <div class="mr-2">
                <small class="fw-bold">Empresa:</small>
                <input type="text" class="form-control form-control-sm border-info" name="filter_business" id="filter_business" placeholder="Buscar">
            </div>
            <div class="mr-2">
                <small class="text-center fw-bold">Fec.Entrega.Solic:</small>
                <input type="date" class="form-control form-control-sm border-info" name="filter_expected_date" id="filter_expected_date">
            </div>
            <div class="mr-2">
                <small class="text-center fw-bold">Fec.Entrega.Real:</small>
                <input type="date" class="form-control form-control-sm border-info" name="filter_end_date" id="filter_end_date">
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

        <input type="hidden" class="can_view" value="{{auth()->user()->can('Ver Ordenes')}}">
        <input type="hidden" class="can_edit" value="{{auth()->user()->can('Actualizar Ordenes')}}">
        <input type="hidden" class="can_delete" value="{{auth()->user()->can('Eliminar Ordenes')}}">
                
        <div class="card-body table-responsive" style="font-size:13px">
            <table id="myTableOrder" class="table table-bordered table-hover" width="100%">
                <thead style="background-color: rgb(204,204,204);">
                    <tr>
                        <th>Codigo</th>
                        <th>Empresa</th>
                        <th>Ord.Cliente</th>                      
                        <th>Lugar.Entrega</th>
                        <th>Fec.Entrg.Solic</th>
                        <th>Fec.Entrg.Real</th>                        
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
<script src="{{asset('app/js/order.js')}}"></script>
@stop