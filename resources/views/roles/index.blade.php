@extends('adminlte::page')

@section('title', 'Lista de roles')

@section('content_header')

@stop
@section('content')
    <div class="py-3">
        @if (session('info'))
            <div class="alert alert-success" role="alert">
                <strong>Muy bien!</strong> {{ session('info') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header py-3" style="background-color: rgb(33,136,201);">
                <span class="col-form-label col-form-label-lg text-white">Lista de roles del sistema</span>
                @can('Crear Roles')
                    <a href="{{ route('roles.create') }}" style="background-color:#3A416F;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Agregar nuevo rol" class="btn btn-sm float-right text-white"><i class="fas fa-plus" style="color:white"></i></a>
                @endcan
            </div>
            <div class="card-body table-responsive col-form-label col-form-label-sm">
                <table class="table table-bordered table-hover" width="100%">
                    <thead class="bg-secondary">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td width="200px">
                                    @can('Actualizar Roles')
                                        <a class="btn btn-sm bg-success" href="{{ route('roles.edit', $role) }}">Editar</a>
                                    @endcan
                                    @can('Eliminar Roles')
                                        <a class="btn btn-danger btn-sm" onclick="delete_role({{$role->id}})">Eliminar</a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
        function delete_role(id) {           

            Swal.fire({
                title: '¿Está seguro de dar de baja al rol?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'si, borralo!',
                cancelButtonText: 'No, cancelar!',
                customClass: 'swal-height'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'DELETE',
                        url: '/role/' + id,
                        statusCode: {
                            200: function(response) {
                                Swal.fire({
                                    title: 'Borrado!',
                                    text: 'El rol ' +response['rol']+ ' fue dado de baja!',
                                    icon: 'success',
                                    customClass: 'swal-height'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location = '/role';
                                    } else {
                                        window.location = '/role';
                                    }
                                })
                            },
                            500: function() {
                                Swal.fire({
                                    title: 'Ups!',
                                    text: 'Se tubo problemas, consulte con soporte..!',
                                    icon: 'error',
                                    customClass: 'swal-height'
                                })
                            }
                        }
                    })
                }
            })
        }
    </script>
@stop
