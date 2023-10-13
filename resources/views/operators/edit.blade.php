@extends('adminlte::page')

@section('title', 'Operario de fabricación')

@section('content_header')

@stop
@section('content')
<div class="container py-4">
    <form action="" action="" method="post">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-12 col-md-8 col-lg-6 m-auto">
                <div class="card" style="border-radius: 10px; border: 1px solid rgb(117,115,113)">
                    <div class="card-header" style="border-radius: 10px 10px 0px 0px; border: 1px solid rgb(117,115,113); background-color: rgb(33,136,201);">
                        <h1 class="h5" style="color:#ffffff">Actualizar operario de fabricación</h1>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            @csrf
                            <div class="row">
                                <div class="col mb-3 col-12">
                                    <input type="hidden" id="operator_id" value="{{$operator->id}}">
                                    <label for="name" class="col-form-label col-form-label-sm">Nombre:</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text style-icon-fas">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="name" id="name" class="form-control style-input form-control-sm bg" placeholder="Ingresar su nombre" value="{{$operator->name}}" required>
                                    </div>
                                    <small style="font-size:12.5px" id="name-error"></small>
                                </div>
                                <div class="col mb-3 col-12">
                                    <label for="document" class="col-form-label col-form-label-sm">N° documento:</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text style-icon-fas">
                                                <i class="fas fa-id-card"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="document" id="document" class="form-control style-input form-control-sm bg" placeholder="Ingresar número de documento" value="{{$operator->document}}" required>
                                    </div>
                                    <small style="font-size:12.5px" id="document-error"></small>
                                </div>
                                <div class="col mb-3 col-12">
                                    <label for="phone" class="col-form-label col-form-label-sm">Teléfono:</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text style-icon-fas">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="phone" id="phone" class="form-control style-input form-control-sm bg" placeholder="Ingresar su teléfono" value="{{$operator->phone}}" required>
                                    </div>
                                    <small style="font-size:12.5px" id="phone-error"></small>
                                </div>
                                <div class="col mb-3 col-12">
                                    <label for="email" class="col-form-label col-form-label-sm">Email:</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text style-icon-fas">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                        </div>
                                        <input type="email" name="email" id="email" class="form-control style-input form-control-sm bg" placeholder="Ingresar su email" value="{{$operator->email}}" required>
                                    </div>
                                    <small style="font-size:12.5px" id="email-error"></small>
                                </div>
                                <div class="col mb-3 col-12">
                                    <label for="position" class="col-form-label col-form-label-sm">Cargo:</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <div class="input-group-text style-icon-fas">
                                                <i class="fas fa-sitemap"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="position" id="position" class="form-control style-input form-control-sm bg" placeholder="Ingresar su cargo" value="{{$operator->position}}" required>
                                    </div>
                                    <small style="font-size:12.5px" id="position-error"></small>
                                </div>
                            </div>
                        </form>
                        <div id="PageLoadProgressEdit" class="mb-3 p-2" style="display:none;margin:0 auto;width:120px;border:#014c8d 1px solid;background-color:#eeeeee"><img src="{{asset('images/gif/Progress-circle.gif')}}" alt="Progress"><span class="ml-1" style="color: #0069A5;font-size:12.5px">Cargando...</span></div>
                        <div class="float-right">
                            <a href="{{route('operators.index')}}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-sign-out-alt"></i>
                                Cancelar
                            </a>
                            <button type="button" class="btn btn-sm text-white" style="background-color:#3a3b49" id="btn_edit_operator" onclick="update_operator()">
                                <i class="fas fa-check-circle text-white"></i>
                                Actualizar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@stop
@section('css')
@include('layout-admin.base-css')
@stop
@section('js')
@include('layout-admin.base-js')
<script src="{{asset('app/js/operator.js')}}"></script>
@stop