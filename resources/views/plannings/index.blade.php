@extends('adminlte::page')

@section('title', 'Control de la Producción')

@section('content_header')

@stop
@section('content')

<div class="py-3">
    <div class="card">
        <div class="card-header py-3" style="background-color: rgb(33,136,201);">
            <span class="col-form-label col-form-label-lg text-white">Lista de control de la producción de radiadores</span>
        </div>

        <input type="hidden" class="can_control" value="{{auth()->user()->can('Realizar Control de Radiadores')}}">
        <input type="hidden" class="can_graf_rework" value="{{auth()->user()->can('Ver Gráfico de Reprocesos de Radiadores')}}">
        <input type="hidden" class="can_control_view" value="{{auth()->user()->can('Ver Detalle de Reprocesos de Radiadores')}}">

        <div class="card-body table-responsive" style="font-size:13px">
            <table id="myTableProduccion" class="table table-bordered table-hover text-center" width="100%">
                <thead style="background-color: rgb(204,204,204);">
                    <tr>
                        <th class="align-middle text-sm" scope="col">Codigo</th>
                        <th class="align-middle text-sm" scope="col">Empresa</th>
                        <th class="align-middle text-sm" scope="col">Proyecto Radiador</th>
                        <th class="align-middle text-sm" scope="col">Completado</th>                       
                        <th class="align-middle text-sm" scope="col">Inic.Planific</th>
                        <th class="align-middle text-sm" scope="col">Fin.Planific</th>
                        <th class="align-middle text-sm" scope="col">Fin.Real</th>
                        <th class="align-middle text-sm" scope="col">Estado</th>
                        <th class="align-middle text-sm" scope="col" width="10px">Control de la Producción</th>
                        <th class="align-middle text-sm" scope="col" width="10px"></th>
                        <th class="align-middle text-sm" scope="col" width="10px"></th>
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
<script>
    function formatoFecha(texto) {
        return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g, '$3/$2/$1');
    }

    let can_control = $('.can_control').val();
    let can_graf_rework = $('.can_graf_rework').val();
    let can_control_view = $('.can_control_view').val();

    $(document).ready(function() {
        $('#myTableProduccion').DataTable({
            order: [[0, 'desc']],
            ajax: {
                url: '/control/listcontrol',
                type: 'GET'
            },
            dataSrc: 'data',
            language: {

                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Registros del _START_ al _END_ del total de _TOTAL_",
                "sInfoEmpty": "Registros del 0 al 0 de un total de 0",
                "sInfoFiltered": "(filtrado)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }

            },
            columns: [{
                    data: 'cod_document'
                },
                {
                    data: 'cliente'
                },
                {
                    data: 'name'
                },
                {
                    data: function(data) {
                        if (data.progress >= 80 && data.progress <= 100) {
                            return '<div class="badge bg-success">' + data.progress + '%</div>';
                        }
                        if(data.progress >= 40 && data.progress < 80){
                            return '<div class="badge bg-warning">' + data.progress + '%</div>';
                        }
                        if(data.progress >= 0 && data.progress < 40){
                            return '<div class="badge bg-secondary">' + data.progress + '%</div>';
                        }                        
                    }
                },               
                {
                    data: function(data) {
                        return formatoFecha(data.start_date_p);
                    }
                },
                {
                    data: function(data) {
                        return formatoFecha(data.expected_date_p);
                    }
                },
                {
                    data: function(data) {
                        if (data.end_date_p == null) {
                            return "Por confirmar"
                        } else {
                            return formatoFecha(data.end_date_p);
                        }
                    }
                },
                {
                    data: function(data) {
                        if (data.status == 2) {
                            return '<div class="badge bg-warning mt-2">En Proceso</div>';
                        } else {
                            return '<div class="badge bg-success mt-2">Finalizado</div>';
                        }
                    }

                },
                {
                    data: function(data) {
                        if (can_control) {
                            if (data.progress == 100) {
                                if(data.url_photo){
                                    return '<div class="text-center"> <a href="#" class="btn btn-success btn-sm disabled" data-toggle="tooltip" data-placement="top" title="Realizar control"><i class="fa fa-lock"></i></a></div>'
                                }
                                else{
                                    return '<div class="text-center"> <a href="/control/' + data.id + '" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Realizar control"><i class="fa fa-check"></i></a></div>'
                                }                                
                            }
                            if (data.progress < 100) {
                                return '<div class="text-center"> <a href="/control/' + data.id + '" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Realizar control"><i class="fa fa-spin fa-cog"></i></a></div>'
                            }
                        }
                        else{
                            return "";
                        }                        
                    }
                },
                {
                    data: function(data) {
                        if (can_graf_rework) {
                            return '<div><a href="/reproceso/' + data.id + '" class="btn btn-secondary btn-sm ml-1" data-toggle="tooltip" data-placement="top" title="Ver reprocesos"><i class="fas fa-chart-bar"></i></a></div>'
                        }
                        else{
                            return "";
                        }
                    }
                },
                {
                    data: function(data) {
                        if (can_control_view) {
                            return '<div><a href="/reproceso/show/' + data.id + '" class="btn btn-primary btn-sm ml-1" data-toggle="tooltip" data-placement="top" title="Ver lista de reprocesos"><i class="fa fa-tasks"></i></a></div>'
                        }  
                        else{
                            return "";
                        }                      
                    }
                },
            ]

        });

    });
</script>
@stop