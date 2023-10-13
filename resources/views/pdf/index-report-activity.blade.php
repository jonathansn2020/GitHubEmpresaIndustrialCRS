@extends('adminlte::page')

@section('title', 'Generar Reporte Actividades')

@section('content_header')

@stop
@section('content')
@include('orders.modal.order-show-modal')
<div class="py-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <form action="{{route('pdf.report-activity-rework')}}" method="post" target="_blank">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-2">
                                    <small class="fw-bold">Fecha de inicio:</small>
                                    <input type="date" name="start_date_i" id="start_date_i" class="form-control form-control-sm mt-1" required>
                                </div>
                                <div class="col-12 col-md-2">
                                    <small class="fw-bold">Fecha de fin:</small>
                                    <input type="date" name="start_date_f" id="start_date_f" class="form-control form-control-sm mt-1" required>
                                </div>
                                <div class="col-12 col-md-4">
                                    <small class="fw-bold">Actividad:</small>
                                    <select name="activity_id" class="form-control form-control-sm mt-1" required>
                                        <option value="">Seleccionar...</option>
                                        @foreach($activities as $activity)
                                        <option value="{{$activity->id}}">{{$activity->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-md-3">
                                    <small class="fw-bold"></small><br>
                                    <button type="submit" class="btn btn-danger">Generar <i class="fas fa-file-pdf "></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('css')
@include('layout-admin.base-css')
@stop