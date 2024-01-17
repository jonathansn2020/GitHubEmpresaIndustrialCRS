@extends('adminlte::page')

@section('title', 'Dashboard Customer')

@section('content_header')
@stop

@section('content')
@include('dashboard-customer.modal.order-show-modal')
<div class="py-3">
    <div class="card">
        <div class="card-header py-3" style="background-color: rgb(33,136,201);">
            <span class="col-form-label col-form-label-lg text-white">Resultados de las ordenes de fabricación</span>
        </div>
        <div class="card-body table-responsive" style="font-size:13px">
            <table id="TableOrderCustomer" class="table table-bordered table-hover text-center" width="100%">
                <thead style="background-color: rgb(204,204,204);">
                    <tr>
                        <th class="align-middle">Orden</th>
                        <th class="align-middle">Radiador/Producto</th>
                        <th class="align-middle">Empresa/Solicitante</th>
                        <th class="align-middle">Lugar de entrega indicada</th>
                        <th class="align-middle">Fecha de entrega solicitada</th>
                        <th class="align-middle">Fecha de entrega real</th>
                        <th class="align-middle">Estado</th>
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
<script>
    let tableOrder;

    function formatoFecha(texto) {
        return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g, '$3/$2/$1');
    }

    function date(date) {

        let d = new Date(date);
        let fecha;
        let datestring = ("0" + d.getDate()).slice(-2) + "/" + ("0" + (d.getMonth() + 1)).slice(-2) + "/" +
            d.getFullYear();    
      

        return datestring;
    }
    $(document).ready(function() {

        tableOrder = $('#TableOrderCustomer').DataTable({
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: '/lista_consulta_clientes',
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
                    data: 'order_business'
                },
                {
                    data: 'radiador'
                },
                {
                    data: 'name'
                },
                {
                    data: 'delivery_place'
                },
                {
                    data: function(data) {
                        return formatoFecha(data.expected_date);
                    }
                },
                {
                    data: function(data) {
                        if (data.end_date == null) {
                            return "Por confirmar"
                        } else {
                            return formatoFecha(data.end_date);
                        }
                    }
                },
                {
                    data: function(data) {
                        console.log(data.status)
                        if (data.status == 1) {
                            return '<div class="badge bg-secondary mt-2">Por Planificar</div>';
                        } else if (data.status == 2) {
                            return '<div class="badge bg-warning mt-2">En Proceso</div>';
                        } else if (data.status == 3) {
                            return '<div class="badge bg-success mt-2">Finalizado</div>';
                        }
                    }
                },
                {
                    data: function(data) {
                        if(data.status == 1){
                            return '<div class="text-center"><a class="btn btn-primary btn-sm mr-1 disabled" id="" data-bs-toggle="modal" data-bs-target="" data-toggle="" data-placement="top" title="Ver registro"><i class="fas fa-eye"></i></a></div>'
                        }
                        else{
                            return '<div class="text-center"><a class="btn btn-primary btn-sm mr-1" id="" data-bs-toggle="modal" data-bs-target="#customer-show-modal" data-toggle="tooltip" data-placement="top" title="Ver registro" onclick="show_order_customer(' + data.id + ')"><i class="fas fa-eye"></i></a></div>'
                        }                        
                    }
                },

            ]

        });

    });

    function show_order_customer(id) {
        $('.texto').text('');
        $('.image-radiador').text('');
        $(".image-radiador").attr("src", '');
        $(".image-radiador").hide();
        $.ajax({
            method: 'GET',
            url: '/order/' + id,
            beforeSend: function() {
                document.getElementById('PageLoadProgress').style.display = "block";
            },
            statusCode: {
                200: function(data) {

                    console.log(data);
                    document.getElementById('order_business').innerText = data[0].order_business;
                    document.getElementById('expected_date').innerText = formatoFecha(data[0].expected_date);
                    if (data[0].end_date == null) {
                        document.getElementById('end_date').innerText = "Por confirmar";
                    } else {
                        document.getElementById('end_date').innerText = formatoFecha(data[0].end_date);
                    }
                    document.getElementById('delivery_place').innerText = data[0].delivery_place;
                    document.getElementById('phone').innerText = data[0].phone;
                    document.getElementById('name').innerText = data[0].name;
                    document.getElementById('long').innerText = data[0].long + '"';
                    document.getElementById('width').innerText = data[0].width + '"';
                    document.getElementById('thickness').innerText = data[0].thickness + '"';
                    document.getElementById('rows').innerText = data[0].rows;
                    document.getElementById('tube').innerText = data[0].tube + ' Ø';

                    if (data[0].status == 1) {
                        document.getElementById('status').classList.remove("badge", "bg-success", "mt-2");
                        document.getElementById('status').classList.remove("badge", "bg-warning", "mt-2");
                        document.getElementById('status').innerText = 'Por Planificar';
                        document.getElementById('status').classList.add("badge", "bg-secondary", "mt-2");
                    } else if (data[0].status == 2) {
                        document.getElementById('status').classList.remove("badge", "bg-secondary", "mt-2");
                        document.getElementById('status').classList.remove("badge", "bg-success", "mt-2");
                        document.getElementById('status').innerText = 'En Proceso';
                        document.getElementById('status').classList.add("badge", "bg-warning", "mt-2");
                    } else if (data[0].status == 3) {
                        document.getElementById('status').classList.remove("badge", "bg-secondary", "mt-2");
                        document.getElementById('status').classList.remove("badge", "bg-warning", "mt-2");
                        document.getElementById('status').innerText = 'Finalizado';
                        document.getElementById('status').classList.add("badge", "bg-success", "mt-2");
                    }

                    if (data[0].created_at == null) {
                        document.getElementById('planificar').innerText = 'Por confirmar';
                    } else {
                        document.getElementById('planificar').innerText = date(data[0].created_at);
                    }
                    if (data[0].true_start == null) {
                        document.getElementById('proceso').innerText = 'Por confirmar';
                    } else {
                        document.getElementById('proceso').innerText = formatoFecha(data[0].true_start);
                    }
                    if (data[0].end_date_p == null) {
                        document.getElementById('finalizado').innerText = 'Por confirmar';
                    } else {
                        document.getElementById('finalizado').innerText = formatoFecha(data[0].end_date_p);
                    }

                    var base_url = window.location.origin;
                    if (data[0].url_photo) {
                        $('.texto').text('Imagen del radiador terminado:');
                        $(".image-radiador").show();
                        $(".image-radiador").attr("src", base_url + '/' + data[0].url_photo);
                    } else {
                        $('.texto').text('');
                        $(".image-radiador").hide();
                        $(".image-radiador").attr("src", '');
                    }

                    $("#progress").css({
                        'width': data[0].progress + '%'
                    });
                    $(".progress-description").text(data[0].progress + '%');
                    if (data[0].progress < 40) {
                        $(".progress-project").css({
                            'width': data[0].progress + '%'
                        });
                        $(".progress-description").text(data[0].progress + '%' + ' completado');
                        $(".progress-project").removeClass('bg-warning');
                        $(".progress-project").removeClass('bg-success');
                        $(".progress-project").addClass('bg-secondary')
                    }
                    if (data[0].progress >= 40 && data[0].progress < 80) {
                        $(".progress-project").css({
                            'width': data[0].progress + '%'
                        });
                        $(".progress-description").text(data[0].progress + '%' + ' completado');
                        $(".progress-project").removeClass('bg-secondary');
                        $(".progress-project").addClass('bg-warning')
                    }
                    if (data[0].progress >= 80) {
                        $(".progress-project").css({
                            'width': data[0].progress + '%'
                        });
                        $(".progress-description").text(data[0].progress + '%' + ' completado');
                        $(".progress-project").removeClass('bg-warning');
                        $(".progress-project").addClass('bg-success')
                    }
                    document.getElementById('PageLoadProgress').style.display = "none";

                },
                500: function() {
                    console.log('error');
                }
            }

        });
    }
</script>
@stop