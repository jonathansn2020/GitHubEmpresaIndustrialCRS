
let tableTask;

let can_edit = $('.can_edit').val();
let can_delete = $('.can_delete').val();

$(document).ready(function () {

    tableTask = $('#myTableTask').DataTable({
        ajax: {
            url: '/activity/list',
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
        columns: [    
            {
                data: 'id'
            },        
            {
                data: 'name'
            },
            {
                data: 'fase'
            },
            {
                data: function (data) {
                    if(can_edit){
                        return '<div class="text-center"><a class="btn btn-success btn-sm mr-1" id="activity_id" data-bs-toggle="modal" data-bs-target="#activity-edit-modal" data-toggle="tooltip" data-placement="top" title="Editar registro" onclick="edit_activity(' + data.id + ')"><i class="fas fa-edit"></i></a></div>'
                    }
                    else{
                        return "";
                    }
                }
            },
            {
                data: function (data) {
                    if(can_delete){
                        return '<div><a class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar registro" onclick="delete_activity(' + data.id + ')"><i class="fas fa-trash-alt"></i></a></div>'
                    }
                    else{
                        return "";
                    }
                }
            },
        ]

    });

});


function add_activity() {

    let dataSend = {};
    dataSend.name = document.getElementById('name').value;
    dataSend.stage_id = document.getElementById('stage_id').value;

    $.ajax({
        method: 'POST',
        data: dataSend,
        url: '/activity',
        beforeSend: function () {
            document.getElementById('btn-add-activity').disabled = true;
            document.getElementById('PageLoadProgress').style.display = "block";
        },
        statusCode: {
            422: function (response) {
                document.getElementById('alert-validacion').classList.remove('d-none');
                let validacion = [
                    'name', 'stage_id'
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
                    document.getElementById('PageLoadProgress').style.display = "none";
                    document.getElementById('btn-add-activity').disabled = false;

                });
            },
            200: function (response) {
                removeDataActivity();
                document.getElementById('PageLoadProgress').style.display = "none";
                document.getElementById('btn-add-activity').disabled = false;

                $('#activity-create-modal').modal('hide');
                Swal.fire(
                    'Bien hecho!',
                    response['message'],
                    'success'
                ).then(function () {
                    tableTask.ajax.reload();
                });

            },
            500: function () {
                console.log('Error comuniquese con soporte.');
            }
        }
    });

}

function edit_activity(id) {    
    $.ajax({
        method:'GET',
        url:'/activity/'+id,
        beforeSend: function () {
            document.getElementById('btn-edit-activity').disabled = true;
            document.getElementById('PageLoadProgressedit').style.display = "block";
        },
        statusCode:{
            200: function(response){
                console.log(response)                
                document.getElementById('id_edit').value = response.id;
                document.getElementById('name_edit').value = response.name;
                document.getElementById('stage_id_edit').value = response.stage_id;

                document.getElementById('PageLoadProgressedit').style.display = "none";
                document.getElementById('btn-edit-activity').disabled = false;
            },
            500: function(){
                console.log('Error comuniquese con soporte.');
            }
        }
    });
}

function update_activity() {

    let dataSend = {};
    dataSend.id = document.getElementById('id_edit').value;
    dataSend.name_edit = document.getElementById('name_edit').value;
    dataSend.stage_id_edit = document.getElementById('stage_id_edit').value;
    console.log(dataSend);
    $.ajax({
        method: 'PUT',
        data: dataSend,
        url: '/activity/'+dataSend.id,
        beforeSend: function () {
            document.getElementById('btn-edit-activity').disabled = true;
            document.getElementById('PageLoadProgressedit').style.display = "block";
        },
        statusCode: {
            422: function (response) {
                document.getElementById('alert-validacion-edit').classList.remove('d-none');
                let validacion = [
                    'name_edit', 'stage_id_edit'
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
                    document.getElementById('PageLoadProgressedit').style.display = "none";
                    document.getElementById('btn-edit-activity').disabled = false;

                });
            },
            200: function (response) {
                removeDataEditActivity();
                document.getElementById('PageLoadProgressedit').style.display = "none";
                document.getElementById('btn-edit-activity').disabled = false;

                $('#activity-edit-modal').modal('hide');
                Swal.fire(
                    'Bien hecho!',
                    response['message'],
                    'success'
                ).then(function () {
                    tableTask.ajax.reload();
                });

            },
            500: function () {
                console.log('Error comuniquese con soporte.');
            }
        }
    });

}

function delete_activity(id) {

    Swal.fire({
        title: '¿Está seguro de dar de baja la actividad?',
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
                url: '/activity/' + id,
                statusCode: {
                    200: function (response) {
                        Swal.fire({
                            title: 'Borrado!',
                            text: 'La actividad fue dada de baja!',
                            icon: 'success',
                            customClass: 'swal-height'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                tableTask.ajax.reload();
                            }
                            else {
                                tableTask.ajax.reload();
                            }
                        })
                    },
                    500: function () {
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

function removeDataEditActivity(){
    document.getElementById('name_edit').value = "";
    $("#stage_id_edit").val('');
    document.getElementById('alert-validacion-edit').classList.add('d-none');
    document.getElementById('name_edit').classList.remove('is-invalid');
    document.getElementById('stage_id_edit').classList.remove('is-invalid');
    $("#name_edit-error div").remove();
    $("#stage_id_edit-error div").remove();
}

function removeDataActivity() {
    document.getElementById('name').value = "";
    $("#stage_id").val('');
    document.getElementById('alert-validacion').classList.add('d-none');
    document.getElementById('name').classList.remove('is-invalid');
    document.getElementById('stage_id').classList.remove('is-invalid');
    $("#name-error div").remove();
    $("#stage_id-error div").remove();
}