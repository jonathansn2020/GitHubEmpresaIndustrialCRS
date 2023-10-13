let tableUser;

let can_edit = $('.can_edit').val();
let can_delete = $('.can_delete').val();
let can_pass = $('.can_pass').val();

$(document).ready(function () {
    tableUser = $('#myTableUser').DataTable({
        ajax: {
            url: '/users/list',
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
                data: 'roles[0].name'
            }, 
            {
                data: 'email'
            },            
            {
                data: function (data) {
                    if(can_edit){
                        return '<div><a href="/user/edit/'+data.id+'" class="btn btn-sm bg-success">Editar</a></div>'
                    }
                    else{
                        return '';
                    }
                }
            },
            {
                data: function (data) {                  
                    if(can_delete){
                        return '<div><a class="btn btn-danger btn-sm" onclick="delete_user(' + data.id + ')">Eliminar</a></div>'
                    }
                    else{
                        return '';
                    }               
                }
            },
            {
                data: function (data) {
                    if(can_pass){
                        return '<div><a class="btn btn-sm text-white" style="background-color:#3a3b49" data-bs-toggle="modal" data-bs-target="#user-password-modal" onclick="password_user(' + data.id + ')">Cambiar password</a></div>'
                    }
                    else{
                        return '';
                    }    
                }
            }
        ]

    });

});

function add_user() {
    
    let data = new FormData();
    data.append('name', $('#name').val());
    data.append('email', $('#email').val());
    data.append('password', $('#password').val());
    data.append('password_confirmation', $('#password_confirmation').val());
    data.append('profile_photo_path', $('#profile_photo_path')[0].files[0]);   

    $.ajax({
        method: 'POST',        
        url: '/user',
        processData: false,
        contentType: false,
        mimeType: 'multipart/form-data',
        dataType : 'json',
        data: data,
        beforeSend: function () {
            document.getElementById('btn-add-user').disabled = true;
            document.getElementById('PageLoadProgress').style.display = "block";
        },
        statusCode: {
            422: function (response) {
                let validacion = [
                    'name', 'email', 'password','profile_photo_path'
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
                    document.getElementById('btn-add-user').disabled = false;

                });
            },
            200: function (response) {
                console.log(response);
                user_create_clear();
                document.getElementById('PageLoadProgress').style.display = "none";
                document.getElementById('btn-add-user').disabled = false;

                $('#user-create-modal').modal('hide');
                Swal.fire(
                    'Bien hecho!',
                    response['message'],
                    'success'
                ).then(function () {
                    tableUser.ajax.reload();
                });

            },
            500: function () {
                console.log('Error comuniquese con soporte.');
            }
        }
    });

}

function password_user(id) {
    $.ajax({
        method: 'GET',
        url: '/user/password/' + id,
        beforeSend: function () {
            document.getElementById('btn-pass-user').disabled = true;
            document.getElementById('PageLoadProgressPass').style.display = "block";
        },
        statusCode: {
            200: function (response) {
                console.log(response)
                document.getElementById('user_id_pass').value = response.id;
                document.getElementById('user_email_pass').value = response.email;
                document.getElementById('btn-pass-user').disabled = false;
                document.getElementById('PageLoadProgressPass').style.display = "none";
            },
            500: function () {
                console.log('Comuniquese con soporte.');
            }
        }
    });

}

function update_password_user() {

    let dataP = {};
    dataP.user_id_pass = document.getElementById('user_id_pass').value;
    dataP.user_password = document.getElementById('user_password').value;
    
    $.ajax({
        method: 'PUT',
        data: dataP,
        url: '/user/password/' + dataP.user_id_pass,
        beforeSend: function () {
            document.getElementById('btn-pass-user').disabled = true;
            document.getElementById('PageLoadProgressPass').style.display = "block";
        },
        statusCode: {
            422: function (response) {
                let validacion = [
                    'user_password'
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
                    document.getElementById('PageLoadProgressPass').style.display = "none";
                    document.getElementById('btn-pass-user').disabled = false;

                });
            },
            200: function (response) {
                user_password_clear();
                document.getElementById('PageLoadProgressPass').style.display = "none";
                document.getElementById('btn-pass-user').disabled = false;

                $('#user-password-modal').modal('hide');
                Swal.fire(
                    'Se actualizo el password!',
                    response['message'],
                    'success'
                ).then(function () {
                    tableUser.ajax.reload();
                });

            },
            500: function () {
                console.log('Comuniquese con soporte.');
            }
        }
    });
}

function delete_user(id) {

    console.log(id);

    Swal.fire({
        title: '¿Está seguro de dar de baja al usuario?',
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
                url: '/user/' + id,
                statusCode: {
                    200: function (response) {
                        Swal.fire({
                            title: 'Borrado!',
                            text: 'El usuario fue dada de baja!',
                            icon: 'success',
                            customClass: 'swal-height'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                tableUser.ajax.reload();
                            }
                            else {
                                tableUser.ajax.reload();
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

function user_clear() {
    document.getElementById('user_name_show').value = "";
    document.getElementById('user_email_show').value = "";
}

function user_create_clear() {
    document.getElementById('name').value = "";
    document.getElementById('email').value = "";
    document.getElementById('password').value = "";
    document.getElementById('password_confirmation').value = "";
    let elemento = document.querySelector("#profile_photo_path");
    elemento.value = "";

    document.getElementById('name').classList.remove('is-invalid');
    document.getElementById('email').classList.remove('is-invalid');
    document.getElementById('password').classList.remove('is-invalid');
    document.getElementById('profile_photo_path').classList.remove('is-invalid');
    $("#name-error div").remove();
    $("#email-error div").remove();
    $("#password-error div").remove();
    $("#profile_photo_path-error div").remove();
}

function user_password_clear(){
    document.getElementById('user_password').value = "";
    document.getElementById('user_password').classList.remove('is-invalid');
    $("#user_password-error div").remove();
}