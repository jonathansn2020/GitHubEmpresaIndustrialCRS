@extends('adminlte::page')

@section('title', 'Editar rol')

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
                <span class="col-form-label col-form-label-lg text-white">Editar Usuario</span>
            </div>
            <div class="card-body">
                {!! Form::model($user, ['route' => ['users.update', $user], 'method' => 'put']) !!}
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
                <div class="form-group">
                    {!! Form::label('email', 'Email: ', ['style' => 'font-size:14px']) !!}
                    {!! Form::text('email', null, [
                            'class' => 'form-control form-control-sm ' . ($errors->has('email') ? 'is-invalid' : ''),
                            'placeholder' => 'Escriba su email',
                    ]) !!}
                    @error('email')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('roles', 'Rol: ', ['style' => 'font-size:14px']) !!}
                    {!! Form::select('roles', $roles, null, ['class' => 'form-control form-control-sm']) !!}
                </div>

                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm mt-2"><i
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
@stop
