@extends('adminlte::page')

@section('title', 'Generar Reporte Ordenes')

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
                        <form action="{{route('pdf.report-order-time')}}" method="post" target="_blank">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <small class="fw-bold">Fecha de inicio:</small>
                                    <input type="date" name="expected_date_i" id="expected_date_i" class="form-control form-control-sm mt-1" required>
                                </div>
                                <div class="col-12 col-md-4">
                                    <small class="fw-bold">Fecha de fin:</small>
                                    <input type="date" name="expected_date_f" id="expected_date_f" class="form-control form-control-sm mt-1" required>
                                </div>
                                <div class="col-12 col-md-4">
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
