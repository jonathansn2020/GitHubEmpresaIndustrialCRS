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
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <small class="fw-bold">Fecha de inicio:</small>
                            <input type="date" name="end_date_i" id="end_date_i" class="form-control form-control-sm mt-1" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <small class="fw-bold">Fecha de fin:</small>
                            <input type="date" name="end_date_f" id="end_date_f" class="form-control form-control-sm mt-1" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <small class="fw-bold"></small><br>
                            <button type="button" class="btn btn-sm btn-success" onclick="report_reworks()">Generar <i class="fas fa-check-circle"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-8">
                    <div id="dashboard-column-reworks"></div>
                </div>
                <div class="col-12 col-md-4">
                    <div id="dashboard-column-reworks-promed"></div>
                </div>
            </div>            
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
    Highcharts.chart('dashboard-column-reworks', {
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
            text: 'Porcentaje de Reprocesos (PR), <?= date("Y") ?>'
        },
        subtitle: {
            align: 'left',
            text: 'Ver porcentaje de reprocesos'
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
                text: 'Total de reprocesos'
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
                    format: '{point.y:.f}%'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: valor <b>{point.y:.f}%</b><br/>'
        },

        series: [{
            name: 'Unidades reprocesadas / Unidades producidas',
            colorByPoint: true,
            data: <?= $data ?>
        }]
    });

    function report_reworks() {
        let end_date_i = document.getElementById('end_date_i').value;
        let end_date_f = document.getElementById('end_date_f').value;
        console.log(end_date_i + '/' + end_date_f);
        if (end_date_i == "" || end_date_f == "") {
            Swal.fire(
                'El gráfico no pudo ser generado!',
                'Debe ingresar los datos de fecha inicio y fin',
                'warning'
            )
        }
        if (end_date_i > end_date_f) {
            Swal.fire(
                'El gráfico no pudo ser generado!',
                'La fecha de inicio no puede ser mayor a la fecha final',
                'warning'
            )
        } else {
            $.ajax({
                method: 'POST',
                url: '/grafico/reworkG',
                data: {
                    end_date_i: end_date_i,
                    end_date_f: end_date_f
                },
                success: function(data) {
                    console.log(data['dataA'])
                   
                    Highcharts.chart('dashboard-column-reworks', {
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
                            text: 'Porcentaje de Reprocesos (PR), <?= date("Y") ?>'
                        },
                        subtitle: {
                            align: 'left',
                            text: 'Ver porcentaje de reprocesos'
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
                                text: 'Total de reprocesos'
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
                                    format: '{point.y:.f}%'
                                }
                            }
                        },

                        tooltip: {
                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: valor <b>{point.y:.f}%</b><br/>'
                        },

                        series: [{
                            name: 'Unidades reprocesadas / Unidades producidas',
                            colorByPoint: true,
                            data: data['dataA']
                        }]
                    });

                    Highcharts.chart('dashboard-column-reworks-promed', {
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
                            text: 'Porcentaje de Reprocesos (PR), <?= date("Y") ?>'
                        },
                        subtitle: {
                            align: 'left',
                            text: 'Ver porcentaje de reprocesos'
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
                                text: 'Total de reprocesos'
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
                                    format: '{point.y:.f}%'
                                }
                            }
                        },

                        tooltip: {
                            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                            pointFormat: '<span style="color:{point.color}">{point.name}</span>: valor <b>{point.y:.f}%</b><br/>'
                        },

                        series: [{
                            name: 'Unidades reprocesadas / Unidades producidas',
                            colorByPoint: true,
                            data: data['dataB']
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

    Highcharts.chart('dashboard-column-reworks-promed', {
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
            text: 'Promedio de Reprocesos (PR), <?= date("Y") ?>'
        },
        subtitle: {
            align: 'left',
            text: 'Ver porcentaje de reprocesos'
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
                text: 'Total de reprocesos'
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
                    format: '{point.y:.f}%'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: valor <b>{point.y:.f}%</b><br/>'
        },

        series: [{
            name: 'Porcentaje de reprocesos / cantidad',
            colorByPoint: true,
            data: <?= $data2 ?>
        }]
    });

</script>
@stop