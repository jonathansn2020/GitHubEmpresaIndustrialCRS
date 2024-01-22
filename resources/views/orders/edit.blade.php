@extends('adminlte::page')

@section('title', 'Editar Orden de fabricación')

@section('content_header')

@stop
@section('content')
@include('orders.modal.order-create-modal')
<div class="container py-2">
    <form action="{{route('orders.update', $order[0]->id)}}" method="post">
        @method('put')
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card" style="border-radius: 10px; border: 1px solid rgb(117,115,113)">
                    <div class="card-header" style="border-radius: 10px 10px 0px 0px; border: 1px solid rgb(117,115,113); background-color: rgb(33,136,201);">
                        <h1 class="h5" style="color:#ffffff">Editar orden de fabricación</h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-4 col-lg-5">
                                <label class="col-form-label col-form-label-sm" for="orders.user_id">Cliente:</label>
                                <input type="text" class="form-control form-control-sm bg-white" name="user_id" placeholder="Ingrese nombre de la empresa" value="{{$order[0]->name}}" readonly required>
                            </div>
                            <div class="mb-3 col-12 col-md-4 col-lg-4">
                                <label class="col-form-label col-form-label-sm" for="orders.requested">Nombre del solicitante:</label>
                                <input type="text" class="form-control form-control-sm" name="requested" value="{{old('requested',$order[0]->requested)}}" placeholder="Ingrese nombre del solicitante">
                            </div>
                            <div class="mb-3 col-12 col-md-4 col-lg-3">
                                <label class="col-form-label col-form-label-sm" for="orders.order_business">Orden del cliente:</label>
                                <input type="text" class="form-control form-control-sm" name="order_business" value="{{old('order_business',$order[0]->order_business)}}" placeholder="Ingrese orden del cliente">
                                @error('order_business')
                                <small class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12 col-md-4 col-lg-3">
                                <label class="col-form-label col-form-label-sm" for="orders.phone">Teléfono:</label>
                                <input type="text" class="form-control form-control-sm" name="phone" value="{{old('phone',$order[0]->phone)}}" placeholder="Ingrese su número">
                                @error('phone')
                                <small class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>
                            <div class="mb-3 col-12 col-md-4 col-lg-3">
                                <label for="orders.email" class="col-form-label col-form-label-sm">Email:</label>
                                <div class="input-group input-group-sm">
                                    <input type="email" name="email" class="form-control form-control-sm" value="{{old('email',$order[0]->email)}}" placeholder="Ingrese su correo">
                                    <span class="input-group-text fw-bold" id="email">@</span>
                                </div>
                                @error('email')
                                <small class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>
                            <div class="mb-3 col-12 col-md-4 col-lg-6">
                                <label class="col-form-label col-form-label-sm" for="orders.delivery_place">Dirección de entrega:</label>
                                <input type="text" class="form-control form-control-sm" name="delivery_place" value="{{old('delivery_place',$order[0]->delivery_place)}}" placeholder="Ingrese su dirección">
                                @error('delivery_place')
                                <small class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>
                            <div class="mb-3 col-12 col-md-6 col-lg-3">
                                <label class="col-form-label col-form-label-sm" for="orders.sexpected_date">Fec.entrega solicitada:</label>
                                <input type="date" class="form-control form-control-sm" name="expected_date" value="{{old('expected_date',$order[0]->expected_date)}}" placeholder="Ingrese fecha prevista">
                                @error('expected_date')
                                <small class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>
                            <div class="mb-3 col-12 col-md-6 col-lg-3">
                                <label class="col-form-label col-form-label-sm" for="end_date">Fecha de entrega real:</label>
                                <input type="date" class="form-control form-control-sm bg-secondary" name="end_date" value="{{$order[0]->end_date}}" placeholder="Ingrese fecha finalizacion" readonly>
                            </div>
                            <div class="mb-3 col-12 col-md-6 col-lg-3">
                                <label class="col-form-label col-form-label-sm" for="status">Estado:</label>
                                <select class="form-control form-control-sm" name="status">
                                    <option value="">Seleccionar...</option>
                                    <option value="1" {{old('status', $order[0]->status) == '1' ? 'selected' : ''}}>Registrada</option>
                                    <option value="2" {{old('status', $order[0]->status) == '2' ? 'selected' : ''}}>En Proceso</option>
                                    <option value="3" {{old('status', $order[0]->status) == '3' ? 'selected' : ''}}>Completada</option>
                                </select>
                                @error('status')
                                <small class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-2 col-12">
                                <label class="col-form-label col-form-label-sm" for="note">Nota:</label>
                                <textarea class="form-control form-control-sm" name="note" id="note" cols="30" rows="3" placeholder="Por favor ingrese una descripción">{{old('note',$order[0]->note)}}</textarea>
                            </div>
                        </div>
                        <div class="float-right">
                            <a href="{{route('orders.index')}}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-sign-out-alt"></i>
                                Cancelar
                            </a>
                            <button type="input" class="btn btn-sm text-white" style="background-color:#3a3b49"><i class="fas fa-check-circle text-white"></i>Actualizar</button>
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
@stop