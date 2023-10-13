@extends('adminlte::page')

@section('title', 'Nuevo rol')

@section('content_header')

@stop
@section('content')
    <div class="py-2">
        @if (session('info'))
            <div class="alert alert-success" role="alert">
                <strong>Muy bien!</strong> {{ session('info') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header py-3" style="background-color: rgb(33,136,201);">
                <span class="col-form-label col-form-label-lg text-white">Editar Rol {{$role->name}}</span>
            </div>
            <div class="card-body">
                {!! Form::model($role, ['route' => ['roles.update', $role], 'method' => 'put']) !!}
                <div class="form-group">
                    {!! Form::label('name', 'Nombre: ', ['style' => 'font-size:14px']) !!}
                    {!! Form::text('name', null, [
                        'class' => 'form-control form-control-sm ' . ($errors->has('name') ? 'is-invalid' : ''),
                        'placeholder' => 'Escriba un nombre',
                    ]) !!}
                    @error('name')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <strong style="font-size: 14px">Acceso Completo</strong><br>
                {!! Form::checkbox('Todos', null, null, ['class' => 'check_todos mt-2']) !!}
                <label style="font-size: 12px">Seleccionar todos</label>

                <br><strong style="font-size: 14px">Permisos</strong>

                @error('permissions')
                    <br>
                    <small class="text-danger">
                        <strong>{{ $message }}</strong>
                    </small>
                    <br>
                @enderror
                <div class="row mt-2">
                    @foreach ($permissions as $permission)
                        <div class="col-12 col-md-6 col-lg-3">
                            <label style="font-size: 12px">
                                {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'ck mr-1']) !!}
                                {{ $permission->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm mt-2"><i
                        class="fas fa-sign-out-alt"></i> Cancelar</a>
                <button type="submit" class="btn btn-sm mt-2 text-white" style="background-color:#3a3b49"><i class="fas fa-check-circle text-white"></i>
                    Actualizar</button>

                {!! Form::close() !!}
            </div>

        </div>
    </div>
@stop
@section('css')
    @include('layout-admin.base-css')
@stop
@section('js')
    @include('layout-admin.base-js')
    <script>
        $(document).ready(function() {
            $(".check_todos").click(function(event) {
                if ($(this).is(":checked")) {
                    $(".ck:checkbox:not(:checked)").attr("checked", "checked");
                } else {
                    $(".ck:checkbox:checked").removeAttr("checked");
                }
            });
        });
    </script>
@stop