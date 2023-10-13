@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1></h1>
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-6 col-xl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4 text-center">
                    <div class="float-right text-success">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <h5 class="mb-3" style="font-size:18px"><strong>Ordenes de fabricación del dia</strong></h5>
                    <div class="">
                        <h4><span class="badge bg-secondary"><strong>{{$order_day[0]->cantidad_ordenes}}</strong></span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4 text-center">
                    <div class="float-right text-info">
                        <i class="fas fa-industry"></i>
                    </div>
                    <h5 class="mb-3" style="font-size:18px">
                        <strong>
                            Total de radiadores por producir en
                            {{$mes}}
                        </strong>
                    </h5>
                    <div class="">
                        <h4><span class="badge bg-secondary"><strong>{{$projects_month[0]->cantidad_proyectos}}</strong></span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4 text-center">
                    <div class="float-right text-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h5 class="mb-3" style="font-size:18px">
                        <strong>
                            Ordenes con retraso de entrega en
                            {{$mes}}
                        </strong>
                    </h5>
                    <div class="">
                        <h4><span class="badge bg-secondary"><strong>{{$orders_date[0]->c_orden_retraso}}</strong></span></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4 text-center">
                    <div class="float-right text-primary">
                        <i class="fa fa-tasks"></i>
                    </div>
                    <h5 class="mb-3" style="font-size:18px">
                        <strong>
                            Cantidad de reprocesos en el mes de
                            {{$mes}}
                        </strong>
                    </h5>
                    <div class="">
                        <h4><span class="badge bg-secondary"><strong>{{$users[0]->cantidad_reprocesos}}</strong></span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-8">
            <div id="dashboard-column-spline"></div>
        </div>
        <div class="col-12 col-md-4">
            <div id="dashboard-column"></div>
        </div>
    </div>
</div>

@stop

@section('css')

@stop

@section('js')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    Highcharts.chart('dashboard-column', {
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
        colors: ['rgb(127,178,186)', 'rgb(254,181,106)', 'rgb(44,175,254)'],
        chart: {
            type: 'column'
        },
        title: {
            text: 'Estado del total de las ordenes del año <?= date("Y") ?>',
            align: 'center'
        },
        subtitle: {
            text: '',
            align: 'left'
        },
        xAxis: {
            categories: ['Estado de pedidos'],
            crosshair: true,
            accessibility: {
                description: 'Orden(es)'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total de ordenes',
            }
        },
        tooltip: {
            valueSuffix: ' (orden(es) de fabricación)'
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.f}'
                }
            }
        },
        series: <?= $data1 ?>
    });

    Highcharts.chart('dashboard-column-spline', {
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
        colors: ['rgb(86,220,255)', 'rgb(60,251,141)', 'rgb(255,183,108)', 'rgb(128, 135, 232)', 'rgb(127,178,186)', '#64E572', '#9F9655', '#FFF263', '#6AF9C4'],
        chart: {
            type: 'column'
        },
        title: {
            align: 'center',
            text: 'Total de las ordenes de fabricación por mes del año <?= date("Y") ?>'
        },
        subtitle: {
            align: 'left',
            text: ''
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
                text: 'Total de ordenes'
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
                    format: '{point.y:.f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: total <b>{point.y:.f}</b><br/>'
        },

        series: [{
            name: 'Ordenes del mes',
            colorByPoint: true,
            data: <?= $data2 ?>,                    
            
        }, {
            type: 'spline',
            name: 'Ordenes del mes',
            color: '#03deec',
            data: <?= $data2 ?>,
            marker: {
                lineWidth: 5,
                lineColor: Highcharts.getOptions().colors[5],
                fillColor: 'white'
            },
            
        }, ]

    });
</script>
@stop