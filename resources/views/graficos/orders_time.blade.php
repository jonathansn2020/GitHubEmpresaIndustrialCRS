@extends('adminlte::page')

@section('title', 'Gráficos Estadísticos')

@section('content_header')

@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card d-flex justify-content-center text-center mt-2">
                <div class="row card-body">
                    <div class="col-12 col-md-6 col-lg-4">
                        <small class="fw-bold">Mes de inicio:</small>
                        <input type="month" name="mes_start" id="month_start" class="form-control form-control-sm mt-1">
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <small class="fw-bold">Mes final:</small>
                        <input type="month" name="mes_end" id="month_end" class="form-control form-control-sm mt-1">
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <small class="fw-bold">Generar gráfico:</small><br>
                        <button type="button" class="btn btn-success btn-sm mt-1" onclick="orders_time()">
                            <i class="fas fa-check-circle"></i> ACEPTAR
                        </button>
                    </div>
                </div>
            </div>
            <div id="grafico2"></div>
        </div>
    </div>
</div>


@stop
@section('css')
@include('layout-admin.base-css')
@stop
@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    Highcharts.setOptions({
        colors: ['#20c997']
    });
    Highcharts.chart('grafico2', {
        lang: {
            downloadCSV: "Descarga CSV",
            downloadXLS: "Descarga formato excel XLS",
            viewFullscreen: "Ver en pantalla completa",
            downloadPNG: "Descargar imagen PNG",
            downloadJPEG: "Descargar imagen JPEG",
            downloadPDF: "Descargar documento PDF",
            downloadSVG: "Descargar imagen SVG",
            downloadCSV: "Descargar formato excel CSV",
        },
        chart: {
            type: 'column'
        },
        title: {
            align: 'left',
            text: 'Ordenes de fabricación, <?= date("Y") ?>'
        },
        subtitle: {
            align: 'left',
            text: 'Ver total de ordenes entregadas a tiempo por mes'
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total de ordenes entregadas'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.0f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: total <b>{point.y:.f}</b><br/>'
        },

        series: [{
            name: 'Ordenes entregadas a la fecha',
            colorByPoint: true,
            data: <?= $data1 ?>
        }]
    });

    function orders_time() {
        let month_start = document.getElementById('month_start').value;
        let month_end = document.getElementById('month_end').value;
        console.log(month_start + '/' + month_end);
        if (month_start == "" || month_end == "") {
            Swal.fire(
                'El gráfico no pudo ser generado!',
                'Debe ingresar los datos del mes inicio y fin',
                'warning'
            )
        } 
        if (month_start > month_end) {
            Swal.fire(
                'El gráfico no pudo ser generado!',
                'El mes de inicio no puede ser mayor al mes final',
                'warning'
            )
        } 
        else {
            $.ajax({
                method: 'POST',
                url: '/grafico/atiempo',
                data: {
                    month_start: month_start,
                    month_end: month_end
                },
                success: function(data) {
                    Highcharts.chart('grafico2', {
                        lang: {
                            downloadCSV: "Descarga CSV",
                            downloadXLS: "Descarga formato excel XLS",
                            viewFullscreen: "Ver en pantalla completa",
                            downloadPNG: "Descargar imagen PNG",
                            downloadJPEG: "Descargar imagen JPEG",
                            downloadPDF: "Descargar documento PDF",
                            downloadSVG: "Descargar imagen SVG",
                            downloadCSV: "Descargar formato excel CSV",
                        },
                        chart: {
                            type: 'column'
                        },
                        title: {
                            align: 'left',
                            text: 'Ordenes de fabricación, <?= date("Y") ?>'
                        },
                        subtitle: {
                            align: 'left',
                            text: 'Ver total de ordenes entregadas a tiempo por mes'
                        },
                        accessibility: {
                            announceNewData: {
                                enabled: true
                            }
                        },
                        xAxis: {
                            type: 'category'
                        },
                        yAxis: {
                            title: {
                                text: 'Total de ordenes entregadas'
                            }

                        },
                        legend: {
                            enabled: false
                        },
                        plotOptions: {
                            series: {
                                borderWidth: 0,
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.y:.0f}'
                                }
                            }
                        },

                        tooltip: {
                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: total <b>{point.y:.f}</b><br/>'
                        },

                        series: [{
                            name: 'Ordenes entregadas a la fecha',
                            colorByPoint: true,
                            data: data
                        }]
                    });
                },
                error: function() {
                    console.log('Consulte a soporte...');
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

    }
</script>
@stop