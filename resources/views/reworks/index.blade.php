@extends('adminlte::page')

@section('title', 'Retrabajos')

@section('content_header')

@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mt-2">
            <div id="reproceso"></div>
        </div>
    </div>
    <div class="mt-3 float-right"><a href="{{route('control.index')}}" class="btn btn-success btn-xl"><i class="fa fa-arrow-circle-left "></i></a></div>
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
    Highcharts.setOptions({
        colors: ['#20c997', 'rgb(127,178,186)', 'rgb(254,176,83)', 'rgb(218,109,133)', '#28a745', '#e83e8c', '#dc3545', '#17a2b8', '#64E572', '#9F9655', '#FFF263', '#6AF9C4']
    });
    Highcharts.chart('reproceso', {
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
            text: 'REPROCESOS EN LA FABRICACIÓN DE <?= $project->name ?>'
        },
        subtitle: {
            align: 'left',
            text: 'Ver actividades con reprocesos'
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
                    format: '{point.y:.f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: cantidad <b>{point.y:.f} reproceso(s)</b><br/>'
        },

        series: [{
            name: 'Reproceso en trabajo',
            colorByPoint: true,
            data: <?= $dataR ?>,
            //pointPadding: -0.2,
            //pointPlacement: 0            
        }],

    });
</script>
@stop