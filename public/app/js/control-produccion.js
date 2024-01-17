function formatoFecha(texto) {
    return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g, '$3/$2/$1');
}

function date(date) {

    let d = new Date(date);
    let valor, fecha;
    let datestring = ("0" + d.getDate()).slice(-2) + "/" + ("0" + (d.getMonth() + 1)).slice(-2) + "/" +
        d.getFullYear() + " " + ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2)
        + ":" + ("0" + d.getSeconds()).slice(-2);

    if (d.getHours() >= 12) {
        valor = 'p. m.';
    }
    else {
        valor = 'a. m.';
    }

    fecha = datestring + ' ' + valor;

    return fecha;
}

$(document).ready(function () {
    $('.list-group').sortable({
        connectWith: '.list-group',
        stop: function (event, ui) {
            let idpr = $('#idproject').val();
            let origen = $(this).attr('id');
            let tareaId = ui.item.data('id');
            let estado = ui.item.parent().attr('id');
            let posicion = ui.item.index();
            console.log('origen:' + origen + ', id: ' + tareaId + ', ' + 'destino:' + estado + ' , ' + posicion);

            if (origen == "entrada" && estado == "completada") {
                Swal.fire(
                    'Considerar lo siguiente!',
                    'La actividad de entrada debe ser asignada primero a la lista de proceso, para continuar con el flujo del control correcto.',
                    'warning'
                )
                    .then(function () {
                        window.location = '/control/' + idpr;

                    });
            }
            else {
                $.ajax({
                    url: '/control/' + tareaId,
                    method: 'PUT',
                    data: {
                        estado: estado,
                        origen: origen,
                        idproject: $('#idproject').val(),
                        orden: ui.item.index()
                    },
                    success: function (data) {
                        console.log(data);
                        
                        if(data['message'] == true){
                            toastr.success("Actividad completada con exito!!");
                        }
                        if(data['message'] == false){
                            toastr.error("Se ha producido un reproceso!!");
                        }                        

                        if (data['avance'] < 40) {
                            $(".progress-project").css({ 'width': data['avance'] + '%' });
                            $(".progress-project-des").text(data['avance'] + '%' + ' completado');
                            $(".progress-project").removeClass('bg-warning');
                            $(".progress-project").removeClass('bg-success');
                            $(".progress-project").addClass('bg-secondary')
                        }
                        if (data['avance'] >= 40 && data['avance'] < 80) {
                            $(".progress-project").css({ 'width': data['avance'] + '%' });
                            $(".progress-project-des").text(data['avance'] + '%' + ' completado');
                            $(".progress-project").removeClass('bg-secondary');
                            $(".progress-project").addClass('bg-warning')
                        }
                        if (data['avance'] >= 80) {
                            $(".progress-project").css({ 'width': data['avance'] + '%' });
                            $(".progress-project-des").text(data['avance'] + '%' + ' completado');
                            $(".progress-project").removeClass('bg-warning');
                            $(".progress-project").addClass('bg-success')
                        }

                    }
                });
            }


        }
    });
});

$(".task-button").on("click", function () {
    let tableBodyCM = document.getElementById('list-comments');
    let taskId = $(this).data('taskid');
    $('#task-id').val(taskId);
    limpiar_datos_actividad();
    console.log(taskId);
    $.ajax({
        url: '/comment/' + taskId,
        method: 'GET',
        beforeSend: function () {
            $('#nodataComent td').text('Procesando...');
        },
        success: function (data) {
            console.log(data);
            for (let actividad of data['activity']) {
                $('#name-a').text(actividad.actividad);
                $('#start-date-a').text(formatoFecha(actividad.start_date));
                $('#expected_date-a').text(formatoFecha(actividad.expected_date));

                if (actividad.true_start == null) {
                    $('#true_start-a').text('Por confirmar...');
                    $('#true_start-a').removeClass('text-success');
                    $('#true_start-a').addClass('text-danger');
                    $('#true_start-a').addClass('fw-bold');
                }
                else {
                    if (actividad.true_start > actividad.start_date) {
                        $('#true_start-a').text(formatoFecha(actividad.true_start));
                        $('#true_start-a').removeClass('text-success');
                        $('#true_start-a').addClass('text-danger');
                        $('#true_start-a').addClass('fw-bold');
                    }
                    else {
                        $('#true_start-a').text(formatoFecha(actividad.true_start));
                        $('#true_start-a').removeClass('text-danger');
                        $('#true_start-a').addClass('text-success');
                        $('#true_start-a').addClass('fw-bold');
                    }

                }
                if (actividad.end_date == null) {
                    $('#end_date-a').text('Por confirmar...');
                    $('#end_date-a').removeClass('text-success');
                    $('#end_date-a').addClass('text-danger');
                    $('#end_date-a').addClass('fw-bold');
                }
                else {
                    $('#end_date-a').text(formatoFecha(actividad.end_date));
                    $('#end_date-a').removeClass('text-danger');
                    $('#end_date-a').addClass('text-success');
                    $('#end_date-a').addClass('fw-bold');
                }
                $('#status-a').removeClass('badge');
                if (actividad.status == "Completada") {
                    $('#status-a').removeClass('bg-warning');
                    $('#status-a').removeClass('bg-secondary');
                    $('#status-a').removeClass('bg-success');
                    $('#status-a').addClass('badge');
                    $('#status-a').addClass('bg-success');
                }
                if (actividad.status == "Proceso") {
                    $('#status-a').removeClass('bg-success');
                    $('#status-a').removeClass('bg-secondary');
                    $('#status-a').removeClass('bg-warning');
                    $('#status-a').addClass('badge');
                    $('#status-a').addClass('bg-warning');
                }
                if (actividad.status == "Entrada") {
                    $('#status-a').removeClass('bg-success');
                    $('#status-a').removeClass('bg-warning');
                    $('#status-a').removeClass('bg-info');
                    $('#status-a').addClass('badge');
                    $('#status-a').addClass('bg-secondary');
                }

                if(actividad.status == "Entrada"){
                    $('#status-a').text('Registrada')
                }
                
                if(actividad.status == "Proceso"){
                    $('#status-a').text('En proceso')
                }
                if(actividad.status == "Completada"){
                    $('#status-a').text(actividad.status);
                }
                
                $('#stage_id-a').text(actividad.etapa);
            }

            if (data['comments'].length > 0) {
                for (let comentario of data['comments']) {
                    let file = 0;
                    for (let resource of data['resources']) {
                        if (comentario.id == resource.resourceable_id) {
                            file = 1;
                            console.log(file);
                        }
                    }
                    $('#nodataComent').remove();
                    let newRow = tableBodyCM.insertRow(-1);
                    newRow.innerHTML = '<td style="font-size:11px" class="fw-bold">' + comentario.body + '</td><td style="font-size:11px" class="fw-bold">' + file + '</td><td style="font-size:11px;width:165px" class="fw-bold">' + date(comentario.created_at) + '</td><td style="font-size:11px" class="fw-bold">' + comentario.name + '</td><td><button type="button" class="btn btn-sm" data-toggle="tooltip" data-placement="top" title="Editar nota" onclick="edit_comment(' + comentario.id + ')"><img src="../images/iconos/editar.jpeg" style="width:25px"></button></td>';
                }
            }
            else {
                $('#list-comments tr').remove();
                $('#list-comments').append('<tr id="nodataComent"><td colspan="12">No hay comentarios ingresados...</td></tr>');
            }
        }
    });
});

function LoadComments(taskId) {
    let tableBodyCM = document.getElementById('list-comments');
    $.ajax({
        method: 'GET',
        url: '/comment/' + taskId,
        success: function (data) {
            $('#list-comments tr').remove();
            for (let i = 0; i < data['comments'].length; i++) {
                let file = 0;
                for (let j = 0; j < data['resources'].length; j++) {
                    if (data['comments'][i].id == data['resources'][j].resourceable_id) {
                        file = 1;
                        console.log(file);
                    }
                }
                let newRow = tableBodyCM.insertRow(-1);
                newRow.innerHTML = '<td style="font-size:11px" class="fw-bold">' + data['comments'][i].body + '</td><td style="font-size:11px" class="fw-bold">' + file + '</td><td style="font-size:11px;width:165px" class="fw-bold">' + date(data['comments'][i].created_at) + '</td><td style="font-size:11px" class="fw-bold">' + data['comments'][i].name + '</td><td><button type="button" class="btn btn-sm" data-toggle="tooltip" data-placement="top" title="Editar nota" onclick="edit_comment(' + data['comments'][i].id + ')"><img src="../images/iconos/editar.jpeg" style="width:25px"></button></td>';
            }

        }
    });

}

function add_comentario() {

    let data = new FormData();
    let taskId = $('#task-id').val();
    data.append('comentario', $('#comentario').val());
    data.append('taskId', taskId);
    data.append('recurso', $('#adjunto')[0].files[0]);

    $.ajax({
        method: 'POST',
        url: '/comment',
        processData: false,
        contentType: false,
        mimeType: 'multipart/form-data',
        dataType: 'json',
        data: data,
        statusCode: {
            422: function (response) {
                let validacion = [
                    'comentario'
                ];

                let errors = response.responseJSON.errors;
                validacion.forEach(function (valor) {
                    document.getElementById(valor + '-error').innerText = '';
                    if (errors[valor]) {
                        let mensajes = errors[valor];
                        for (let i = 0; i < mensajes.length; i++) {
                            let div = document.createElement('div');
                            let mensaje = document.getElementById(valor + '-error').appendChild(div);
                            mensaje.innerText = mensajes[i];
                            mensaje.className += 'mt-1';
                            document.getElementById(valor + '-error').style.color = 'red';
                            document.getElementById(valor).className += ' is-invalid';
                        }
                    }
                    else {
                        document.getElementById(valor + '-error').innerText = '';
                        document.getElementById(valor).classList.remove('is-invalid');
                    }

                });

            },
            200: function (response) {
                console.log(response);
                LoadComments(taskId);
                $('#comentario').val('');
                document.getElementById('comentario').classList.remove('is-invalid');
                $("#comentario-error").text('');
                let elemento = document.querySelector("#adjunto");
                elemento.value = "";

                $('html, body #activity-comment-modal').animate({ scrollTop: 0 }, 'slow');
            },
            500: function () {
                console.log('Comuniquese con soporte');
            }
        }

    })
}

function selectFile() {
    $('#file_input').remove();
    const inputFile = document.createElement("input");
    inputFile.type = "file";
    inputFile.style.opacity = 0;
    inputFile.id = "file_input";
    inputFile.name = "file_input";
    inputFile.accept = "image/*";
    document.body.appendChild(inputFile);
    inputFile.onchange = (e) => {
        if (e.target.files) {
            nameFile.innerText = e.target.files[0].name;
        }
    };
    inputFile.click();
}

function subir_photo() {
    
    if (typeof $('#file_input')[0] === 'undefined') {        
        Swal.fire(
            'No hay evidencia del Proyecto completado',
            'Debe seleccionar un imagen...!',
            'warning'
        )
    }
    else {
        let data = new FormData();

        let project_id = $('#project_id').val();
        data.append('file_input', $('#file_input')[0].files[0]);
        data.append('project_id', project_id);

        $.ajax({
            method: 'POST',
            url: '/upload',
            processData: false,
            contentType: false,
            mimeType: 'multipart/form-data',
            dataType: 'json',
            data: data,
            statusCode: {
                422: function (response) {
                    let errors = response.responseJSON.errors;
                    console.log(errors['file_input']);
                    for (let i = 0; i < errors['file_input'].length; i++) {
                        alert(errors['file_input'][i]);
                    }
                    $('#nameFile').text('');
                },
                200: function (response) {
                    console.log(response);
                    Swal.fire(
                        'Bien hecho!',
                        response['message'],
                        'success'
                    ).then(function () {
                        window.location = '/control';
                    });

                },
                500: function () {
                    console.log('Comuniquese con soporte');
                }
            }

        })
    }


}

function edit_comment(id) {

    $.ajax({
        url: '/comment/edit/' + id,
        method: 'GET',
        success: function (data) {
            console.log(data);
            $('#info').text('Editar información de trabajo:')
            $('#comment-id').val(id);
            $('#comentario').val(data['success'].body);

            if (data['filename']) {
                $('.download').text('Descargar archivo: ' + data['filename']);
                $(".download").attr("href", data['resource']);
            }
            else {
                $('.download').text('');
                $(".download").attr("href", '');
            }

            document.getElementById('btn-comment-create').style.display = "none";
            document.getElementById('btn-comment-update').style.display = "block";
            document.getElementById('btn-comment-update').style.background = '#3a3b49';

            $("#activity-comment-modal").animate({ scrollTop: $('#activity-comment-modal')[0].scrollHeight }, 1000);
            $('#comentario').focus();

        },
        error: function () {
            console.log('Comuniquese con soporte');
        }
    });
}

function update_comment() {

    //let data = new FormData();
    let id = $('#comment-id').val();
    let taskId = $('#task-id').val();
    let comentario = $('#comentario').val();
    //data.append('comentario', $('#comentario').val());

    $.ajax({
        url: '/comment/update/' + id,
        method: 'PUT',
        //processData: false,
        //contentType: false,
        //mimeType: 'multipart/form-data',
        data: { comentario: comentario },
        statusCode: {
            422: function (response) {
                let errors = response.responseText;

                let valor1 = errors.replace('{\"message\":\"', "");
                let valor2 = valor1.replace('."', "");
                let valor3 = valor2.split(',', 1);
                document.getElementById('comentario-error').innerHTML = valor3;
                document.getElementById('comentario-error').style.color = 'red';
                $('#comentario').addClass('is-invalid');
            },
            200: function (data) {
                console.log(data);
                LoadComments(taskId);
                $('#info').text('Agregar información de trabajo:')
                $('#comentario').val('');
                document.getElementById('comentario').classList.remove('is-invalid');
                let elemento = document.querySelector("#adjunto");
                document.getElementById('btn-comment-create').style.display = "block";
                document.getElementById('btn-comment-update').style.display = "none";
                document.getElementById('btn-comment-update').style.background = '#3a3b49';
                elemento.value = "";
                $('.download').text('');
                $('html, body #activity-comment-modal').animate({ scrollTop: 0 }, 'slow');
            },
            500: function () {
                console.log('Comuniquese con soporte');
            }
        }

    });

}

function limpiar_datos_actividad() {
    $('#name-a').text('');
    $('#start-date-a').text('');
    $('#expected_date-a').text('');
    $('#true_start-a').text('');
    $('#end_date-a').text('');
    $('#status-a').text('');
    $('#stage_id-a').text('');
    $('.download').text('');
}

function btn_limpiar_comment() {
    $('#info').text('Agregar información de trabajo:')
    document.getElementById('btn-comment-create').style.display = "block";
    document.getElementById('btn-comment-update').style.display = "none";
    $('#comment-id').val('');
    $('#comentario').val('');

    let elemento = document.querySelector("#adjunto");
    elemento.value = "";
    document.getElementById('comentario').classList.remove('is-invalid');
    $("#comentario-error").text('');
    $('#list-comments tr').remove();
    $('#list-comments').append('<tr id="nodataComent"><td colspan="12">No hay comentarios ingresados...</td></tr>');
    limpiar_datos_actividad();
}