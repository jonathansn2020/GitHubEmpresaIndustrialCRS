let tableStage;

let can_edit = $('.can_edit').val();
let can_delete = $('.can_delete').val();

$(document).ready(function () {

    tableStage = $('#mytablestage').DataTable({
       
        ajax: {
            url: '/stage/list',
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
                data: function (data) {
                    if(can_edit){
                        return '<div class="text-center"><a class="btn btn-success btn-sm mr-1" id="stage_id" data-bs-toggle="modal" data-bs-target="#stage-edit-modal" data-toggle="tooltip" data-placement="top" title="Editar registro" onclick="edit_stage(' + data.id + ')"><i class="fas fa-edit"></i></a></div>'
                    }
                    else{
                        return '';
                    }
                }
            },
            {
                data: function (data) {
                    if(can_delete){
                        return '<div><a class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar registro" onclick="delete_stage(' + data.id + ')"><i class="fas fa-trash-alt"></i></a></div>'
                    }
                    else{
                        return '';
                    }
                }
            }
        ]

    });

});


function add_stage() {

    let dataSend = {};
    dataSend.name = document.getElementById('name').value;    

    $.ajax({
        method: 'POST',
        data: dataSend,
        url: '/stage',
        beforeSend: function () {
            document.getElementById('btn-add-stage').disabled = true;
            document.getElementById('PageLoadProgress').style.display = "block";
        },
        statusCode: {
            422: function (response) {
                document.getElementById('alert-validacion').classList.remove('d-none');
                let validacion = [
                    'name'
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
                    document.getElementById('btn-add-stage').disabled = false;

                });
            },
            200: function (response) {
                removeDataStage();
                document.getElementById('PageLoadProgress').style.display = "none";
                document.getElementById('btn-add-stage').disabled = false;

                $('#stage-create-modal').modal('hide');
                Swal.fire(
                    'Bien hecho!',
                    response['message'],
                    'success'
                ).then(function () {
                    tableStage.ajax.reload();
                });

            },
            500: function () {
                console.log('Error comuniquese con soporte.');
            }
        }
    });
}

function edit_stage(id) {    
    $.ajax({
        method:'GET',
        url:'/stage/'+id,
        beforeSend: function () {
            document.getElementById('btn-edit-stage').disabled = true;
            document.getElementById('PageLoadProgressEditS').style.display = "block";
        },
        statusCode:{
            200: function(data){
                console.log(data)                
                document.getElementById('id_stage_edit').value = data.id;
                document.getElementById('name_stage_edit').value = data.name;                

                document.getElementById('PageLoadProgressEditS').style.display = "none";
                document.getElementById('btn-edit-stage').disabled = false;
            },
            500: function(){
                console.log('Error comuniquese con soporte.');
            }
        }
    });
}

function update_stage() {

    let dataSend = {};
    dataSend.id = document.getElementById('id_stage_edit').value;
    dataSend.name_stage_edit = document.getElementById('name_stage_edit').value;    
   
    $.ajax({
        method: 'PUT',
        data: dataSend,
        url: '/stage/'+dataSend.id,
        beforeSend: function () {
            document.getElementById('btn-edit-stage').disabled = true;
            document.getElementById('PageLoadProgressEditS').style.display = "block";
        },
        statusCode: {
            422: function (response) {
                document.getElementById('alert-validacion-edits').classList.remove('d-none');
                let validacion = [
                    'name_stage_edit'
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
                    document.getElementById('PageLoadProgressEditS').style.display = "none";
                    document.getElementById('btn-edit-stage').disabled = false;

                });
            },
            200: function (response) {
                removeDataEditStage();
                document.getElementById('PageLoadProgressEditS').style.display = "none";
                document.getElementById('btn-edit-stage').disabled = false;

                $('#stage-edit-modal').modal('hide');
                Swal.fire(
                    'Bien hecho!',
                    response['message'],
                    'success'
                ).then(function () {
                    tableStage.ajax.reload();
                });

            },
            500: function () {
                console.log('Error comuniquese con soporte.');
            }
        }
    });
}


function delete_stage(id) {

    Swal.fire({
        title: '¿Está seguro de dar de baja la etapa de fabricación?',
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
                url: '/stage/' + id,
                statusCode: {
                    200: function (response) {
                        Swal.fire({
                            title: 'Borrado!',
                            text: 'La etapa fue dada de baja!',
                            icon: 'success',
                            customClass: 'swal-height'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                tableStage.ajax.reload();
                            }
                            else {
                                tableStage.ajax.reload();
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

function removeDataStage(){

    document.getElementById('name').value = "";    
    document.getElementById('alert-validacion').classList.add('d-none');
    document.getElementById('name').classList.remove('is-invalid');   
    $("#name-error div").remove();

}

function removeDataEditStage(){

    document.getElementById('name_stage_edit').value = "";    
    document.getElementById('alert-validacion-edits').classList.add('d-none');
    document.getElementById('name_stage_edit').classList.remove('is-invalid');   
    $("#name_stage_edit-error div").remove();  
   
}