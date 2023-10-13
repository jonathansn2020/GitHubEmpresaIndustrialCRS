
let tableOperator;

let can_edit = $('.can_edit').val();
let can_delete = $('.can_delete').val();

$(document).ready(function () {

    tableOperator = $('#myTableOperator').DataTable({
        ajax: {
            url: '/operator/list',
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
                data: 'name'
            },
            {
                data: 'document'
            },
            {
                data: 'phone'
            },
            {
                data: 'email'
            },
            {
                data: 'position'
            },
            {
                data: function (data) {
                    if(can_edit){
                        return '<div class="text-center"> <a href="/operator/' + data.id + '" class="btn btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="top" title="Editar registro"><i class="fas fa-edit"></i></a></div>'
                    }
                    else{
                        return '';
                    }
                }
            },
            {
                data: function (data) {
                    if(can_delete){
                        return '<div><a class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar registro" onclick="delete_operator(' + data.id + ')"><i class="fas fa-trash-alt"></i></a></div>'
                    }
                    else{
                        return '';
                    }
                }
            }
        ]

    });

});

function add_operator() {

    let dataSend = {};
    dataSend.name = document.getElementById('name').value;
    dataSend.phone = document.getElementById('phone').value;
    dataSend.document = document.getElementById('document').value;
    dataSend.email = document.getElementById('email').value;
    dataSend.position = document.getElementById('position').value;

    $.ajax({
        method: 'POST',
        data: dataSend,
        url: '/operator',
        beforeSend: function () {
            document.getElementById('btn-add-operator').disabled = true;
            document.getElementById('PageLoadProgress').style.display = "block";
        },
        statusCode: {
            422: function (response) {
                let validacion = [
                    'name', 'document', 'phone', 'position', 'email'
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
                    document.getElementById('btn-add-operator').disabled = false;

                });
            },
            200: function (response) {
                operator_create_clear();
                document.getElementById('PageLoadProgress').style.display = "none";
                document.getElementById('btn-add-operator').disabled = false;

                $('#operator-create-modal').modal('hide');
                Swal.fire(
                    'Bien hecho!',
                    response['message'],
                    'success'
                ).then(function () {
                    tableOperator.ajax.reload();
                });

            },
            500: function () {
                console.log('Error comuniquese con soporte.');
            }
        }
    });

}

function update_operator() {

    let dataSend = {};

    dataSend.id = document.getElementById('operator_id').value;
    dataSend.name = document.getElementById('name').value;
    dataSend.phone = document.getElementById('phone').value;
    dataSend.document = document.getElementById('document').value;
    dataSend.email = document.getElementById('email').value;
    dataSend.position = document.getElementById('position').value;

    $.ajax({
        method: 'PUT',
        data: dataSend,
        url: '/operator/'+dataSend.id,
        beforeSend: function () {
            document.getElementById('btn_edit_operator').disabled = true;
            document.getElementById('PageLoadProgressEdit').style.display = "block";
        },
        statusCode: {
            422: function (response) {
                let validacion = [
                    'name', 'document', 'phone', 'position', 'email'
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
                    document.getElementById('PageLoadProgressEdit').style.display = "none";
                    document.getElementById('btn_edit_operator').disabled = false;

                });
            },
            200: function (response) {
                operator_create_clear();
                document.getElementById('PageLoadProgressEdit').style.display = "none";
                document.getElementById('btn_edit_operator').disabled = false;

                Swal.fire(
                    'Bien hecho!',
                    response['message'],
                    'success'
                ).then(function () {
                    window.location = '/operator';
                });

            },
            500: function () {
                console.log('Error comuniquese con soporte.');
            }
        }
    });


}


function delete_operator(id) {

    Swal.fire({
        title: '¿Está seguro de dar de baja al operador?',
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
                url: '/operator/' + id,
                statusCode: {
                    200: function (response) {
                        Swal.fire({
                            title: 'Borrado!',
                            text: 'El operario fue dado de baja!',
                            icon: 'success',
                            customClass: 'swal-height'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                tableOperator.ajax.reload();
                            }
                            else {
                                tableOperator.ajax.reload();
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

function operator_create_clear() {

    document.getElementById('name').value = "";
    document.getElementById('phone').value = "";
    document.getElementById('document').value = "";
    document.getElementById('email').value = "";
    document.getElementById('position').value = "";
    document.getElementById('name').classList.remove('is-invalid');
    document.getElementById('phone').classList.remove('is-invalid');
    document.getElementById('document').classList.remove('is-invalid');
    document.getElementById('email').classList.remove('is-invalid');
    document.getElementById('position').classList.remove('is-invalid');
    $("#name-error div").remove();
    $("#phone-error div").remove();
    $("#document-error div").remove();
    $("#email-error div").remove();
    $("#position-error div").remove();

}