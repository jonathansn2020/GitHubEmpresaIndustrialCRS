@extends('adminlte::page')

@section('title', 'Lista de reprocesos')

@section('content_header')

@stop
@section('content')
<div class="py-3">
    <div class="card">
        <div class="card-header py-3" style="background-color: rgb(33,136,201);">
            <span class="col-form-label col-form-label-lg text-white">Reprocesos en la fabricación - {{$project->name}}</span>
            <a href="{{route('control.index')}}" class="btn btn-success btn-xl float-right"><i class="fa fa-arrow-circle-left "></i></a>
        </div>
        <input type="hidden" id="project_id" value="{{$project->id}}">
        <div class="card-body table-responsive col-form-label col-form-label-sm">
            <table class="table table-sm table-bordered table-hover text-center" width="100%">
                <thead style="background-color: rgb(204,204,204);">
                    <tr>
                        <th>N°</th>
                        <th>Actividad</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0 ?>
                    @foreach($reworks as $rework)
                    <?php $i++ ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td>{{$rework->actividad}}</td>
                        <td></i><button type="button" class="btn btn-success btn-sm task-button" data-activityid="{{$rework->actividad_id}}" data-taskid="{{$rework->id_pivot}}">Reproceso</button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-body py-0 col-form-label col-form-label-sm"><strong>Datos de la actividad:</strong></div>
        <div class="card-body col-form-label col-form-label-sm">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-2 mb-2">
                    <label style="font-size:13px" class="col-form-label col-form-label-sm">Actividad:</label>
                    <br><span style="font-size:13px" id="rework_activ"></span>
                </div>
                <div class="col-12 col-md-4 col-lg-2 mb-2">
                    <label style="font-size:13px" class="col-form-label col-form-label-sm">Inicio planificado:</label>
                    <br><span style="font-size:13px" id="rework_inc_planif"></span>
                </div>
                <div class="col-12 col-md-4 col-lg-2 mb-2">
                    <label style="font-size:13px" class="col-form-label col-form-label-sm">Fin planificado:</label>
                    <br><span style="font-size:13px" id="rework_fin_planif"></span>
                </div>
                <div class="col-12 col-md-4 col-lg-2 mb-2">
                    <label style="font-size:13px" class="col-form-label col-form-label-sm">Inicio real:</label>
                    <br><span style="font-size:13px" id="rework_inc_real"></span>
                </div>
                <div class="col-12 col-md-4 col-lg-2 mb-2">
                    <label style="font-size:13px" class="col-form-label col-form-label-sm">Fin real:</label>
                    <br><span style="font-size:13px" id="rework_fin_real"></span>
                </div>
                <div class="col-12 col-md-4 col-lg-2 mb-2">
                    <label style="font-size:13px" class="col-form-label col-form-label-sm">Operario asignado:</label>
                    <br><span style="font-size:13px" id="rework_operator"></span>
                </div>
            </div>
        </div>
        <div class="card-body py-0 col-form-label col-form-label-sm"><strong>Detalles del reproceso:</strong></div>
        <div id="PageLoadProgress" class="mb-2 p-2" style="display:none;margin:0 auto;width:120px;border:#014c8d 1px solid;background-color:#eeeeee"><img src="{{asset('images/gif/Progress-circle.gif')}}" alt="Progress"><span class="ml-1" style="color: #0069A5;font-size:12.5px">Cargando...</span></div>
        <div class="card-body table-responsive col-form-label col-form-label-sm">
            <table class="table table-sm table-bordered table-hover text-center" width="100%">
                <thead style="background-color: rgb(204,204,204);">
                    <tr>
                        <th class="align-text-top text-sm" scope="col">Reproceso</th>
                        <th class="align-text-top text-sm" scope="col">Inicio corrección de reproceso</th>
                        <th class="align-text-top text-sm" scope="col">Fin corrección de reproceso</th>
                    </tr>
                </thead>
                <tbody class="text-sm" id="list-reworks">
                    <tr id="nodata">
                        <td colspan="12">No hay datos de reproceso...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
@stop
@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    function formatoFecha(texto) {
        return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g, '$3/$2/$1');
    }

    $(".task-button").on("click", function() {
        let tablaRework = document.getElementById('list-reworks');
        let taskId = $(this).data('taskid');
        let activityId = $(this).data('activityid');
        let project_id = $("#project_id").val();

        console.log(taskId);
        console.log(activityId);

        $.ajax({
            url: '/rework/' + taskId,
            method: 'GET',
            data: {
                activityId: activityId,
                project_id: project_id
            },
            beforeSend: function() {
                document.getElementById('PageLoadProgress').style.display = "block";
            },
            success: function(response) {

                $("#rework_activ").text(response['data2'][0].actividad);
                $("#rework_inc_planif").text(formatoFecha(response['data2'][0].start_date));
                $("#rework_fin_planif").text(formatoFecha(response['data2'][0].expected_date));
                $("#rework_operator").text(response['data2'][0].operator);

                if(response['data2'][0].true_start == null){
                    $('#rework_inc_real').text('Por confirmar...');
                }
                else{                
                    $("#rework_inc_real").text(formatoFecha(response['data2'][0].true_start));
                }

                if(response['data2'][0].end_date == null){
                    $('#rework_fin_real').text('Por confirmar...');
                }
                else{                
                    $("#rework_fin_real").text(formatoFecha(response['data2'][0].end_date));
                }                

                $('#list-reworks').append('<tr id="nodata"><td colspan="12">No hay datos de reproceso...</td></tr>')
                $('#list-reworks tr').remove();
                
                if (response['data'].length <= 0) {
                    $('#list-reworks tr').remove();
                    $('#list-reworks').append('<tr id="nodata"><td colspan="12">No hay datos de reproceso...</td></tr>');
                } else {
                    
                    for (let i = 0; i < response['data'].length; i++) {   
                                         
                        let newRow = tablaRework.insertRow(-1);
                        let count = tablaRework.rows.length;
                        if(response['data'][i].start == null && response['data'][i].end == null){                            
                            //$('#list-reworks tr').remove();                           
                            $('#list-reworks').append('<tr id="nodata"><td colspan="12">No hay datos de reproceso...</td></tr>')
                        }
                        else{                            
                            if(response['data'][i].start != null && response['data'][i].end != null){
                                newRow.innerHTML = '<th scope="row" style="font-size:12px">' + count + '</th><td style="font-size:12px" class="fw-bold">' + formatoFecha(response['data'][i].start) +' '+response['data'][i].start_hour +'</td><td style="font-size:12px" class="fw-bold">' + formatoFecha(response['data'][i].end) +' '+response['data'][i].end_hour +'</td>';
                            }                            
                            if(response['data'][i].start != null && response['data'][i].end == null){
                                let end = 'Por confirmar...'
                                newRow.innerHTML = '<th scope="row" style="font-size:12px">' + count + '</th><td style="font-size:12px" class="fw-bold">' + formatoFecha(response['data'][i].start) +' '+response['data'][i].start_hour +'</td><td style="font-size:12px" class="fw-bold">' + end + '</td>';
                            }
                            
                        }
                        
                    }
                }
                document.getElementById('PageLoadProgress').style.display = "none";
            },
            error: function() {
                console.log('Consulte a soporte...');
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    })
</script>
@stop