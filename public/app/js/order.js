
let tableOrder;
let listOrder = [];

let can_view = $('.can_view').val();
let can_edit = $('.can_edit').val();
let can_delete = $('.can_delete').val();

function formatoFecha(texto) {
    return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g, '$3/$2/$1');
}

$(document).ready(function () {
    tableOrder = $('#myTableOrder').DataTable({
        order: [[0, 'desc']],
        dom: 'rtip',
        ajax: function (data, callback, settings) {
            console.log(data);
            $.get('/orden/list', {
                cod_document: $('#filter_cod_document').val(),
                business: $('#filter_business').val(),
                expected_date: $('#filter_expected_date').val(),
                end_date: $('#filter_end_date').val(),
                status: $('#filter_status').val(),
            }, function (res) {
                console.log(res);
                listOrder = [];
                res.data.forEach(element => {
                    listOrder[element.id] = element;
                });
                callback({
                    recordsTotal: res.total,
                    recordsFiltered: res.total,
                    data: res.data
                });
            })
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
            { data: 'cod_document' },
            { data: 'name' },
            { data: 'order_business' },
            { data: 'delivery_place' },
            {
                data: function (data) {
                    return formatoFecha(data.expected_date);
                }
            },
            {
                data: function (data) {
                    if (data.end_date == null) {
                        return "Por confirmar"
                    }
                    else {
                        return formatoFecha(data.end_date);
                    }
                }
            },
            {
                data: function (data) {
                    if (data.status == 1) {
                        return '<div class="badge bg-secondary mt-2">Por Planificar</div>';
                    }
                    else if (data.status == 2) {
                        return '<div class="badge bg-warning mt-2">En Proceso</div>';
                    }
                    else if (data.status == 3) {
                        return '<div class="badge bg-success mt-2">Finalizado</div>';
                    }
                }

            },
            {
                data: function (data) {
                    if (can_view) {
                        return '<div class="text-center"><a class="btn btn-primary btn-sm mr-1" id="" data-bs-toggle="modal" data-bs-target="#order-show-modal" data-toggle="tooltip" data-placement="top" title="Ver registro" onclick="show_order(' + data.id + ')"><i class="fas fa-eye"></i></a></div>'
                    }
                    else {
                        return '';
                    }
                }
            },
            {
                data: function (data) {
                    if (can_edit) {
                        if (data.status == 1) {
                            return '<div><a href="/orden/'+data.id+'" class="btn btn-success btn-sm mr-1" id="order_id" data-toggle="tooltip" data-placement="top" title="Editar registro"><i class="fas fa-edit"></i></a></div>'
                        }
                        if (data.status == 2) {
                            return '<div><a href="/orden/'+data.id+'" class="btn btn-success btn-sm mr-1" id="order_id" data-toggle="tooltip" data-placement="top" title="Editar registro"><i class="fas fa-edit"></i></a></div>'
                        }
                        if (data.status == 3) {
                            return '<div><a ref="#" class="btn btn-success btn-sm mr-1 disabled" id="order_id" data-toggle="tooltip" data-placement="top" title="Editar registro"><i class="fas fa-edit"></i></a></div>'
                        }
                    }
                    else {
                        return '';
                    }
                }
            },
            {
                data: function (data) {
                    if (can_delete) {
                        return '<div><a class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar registro" onclick="delete_order(' + data.id + ')"><i class="fas fa-trash-alt"></i></a></div>'
                    }
                    else {
                        return '';
                    }
                }
            },

        ]
    });
});


/*
$(document).ready(function () {
    tableOrder = $('#myTableOrder').DataTable({        
        dom: 'rtip',             
        paging: true,
        //processing: true,
        serverSide: true,
        ajax: function (data, callback, settings) {
            console.log(data);            
            $.get('/orden/list', {
                cod_document: $('#filter_cod_document').val(),
                business: $('#filter_business').val(),
                start_date: $('#filter_start_date').val(),
                expected_date: $('#filter_expected_date').val(),
                status: $('#filter_status').val(),
            }, function (res) {
                console.log(res);
                listOrder = [];
                res.data.forEach(element => {
                    listOrder[element.id] = element;
                });
                callback({
                    recordsTotal: res.total,
                    recordsFiltered: res.total,
                    data: res.data
                });
            })
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
            { data: 'cod_document' },
            { data: 'business' },
            { data: 'requested' },
            { data: 'phone' },
            { data: 'delivery_place' },
            {
                data: function (data) {
                    return formatoFecha(data.start_date);
                }
            },
            {
                data: function (data) {
                    return formatoFecha(data.expected_date);
                }
            },
            {
                data: function (data) {
                    if (data.end_date == null) {
                        return "Por confirmar"
                    }
                    else {
                        return formatoFecha(data.end_date);
                    }
                }
            },
            {
                data: function (data) {
                    if (data.status == 1) {
                        return '<div class="badge bg-warning text-dark mt-2">Registrado</div>';
                    }
                    else if (data.status == 2) {
                        return '<div class="badge bg-primary mt-2">En Proceso</div>';
                    }
                    else {
                        return '<div class="badge bg-success mt-2">Finalizado</div>';
                    }
                }

            },
            {
                data: function (data) {
                    return '<div> <a class="btn btn-success btn-sm mr-1" id="order_id" data-bs-toggle="modal" data-bs-target="#order-edit-modal" data-toggle="tooltip" data-placement="top" title="Editar registro" onclick="edit_order(' + data.id + ')"><i class="fas fa-edit"></i></a><a class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Eliminar registro" onclick="delete_order(' + data.id + ')"><i class="fas fa-trash-alt"></i></a></div>'
                }
            },

        ]
    });
});
*/
function search() {
    tableOrder.ajax.reload();
}


function show_order(id) {
    $.ajax({
        method: 'GET',
        url: '/orden/show/' + id,
        beforeSend: function () {
            document.getElementById('PageLoadProgressOS').style.display = "block";
        },
        statusCode: {
            200: function (data) {
                console.log(data);
                document.getElementById('cod_document_show').value = data[0].cod_document;
                document.getElementById('business_show').value = data[0].name;
                document.getElementById('requested_show').value = data[0].requested;
                document.getElementById('phone_show').value = data[0].phone;
                document.getElementById('email_show').value = data[0].email;
                document.getElementById('delivery_place_show').value = data[0].delivery_place;
                document.getElementById('expected_date_show').value = data[0].expected_date;
                document.getElementById('end_date_show').value = data[0].end_date;
                document.getElementById('status_show').value = data[0].status;
                document.getElementById('order_business_show').value = data[0].order_business;
                document.getElementById('note_show').value = data[0].note;
                document.getElementById('PageLoadProgressOS').style.display = "none";
            },
            500: function () {
                console.log('error');
            }
        }

    });
}



function delete_order(id) {

    Swal.fire({
        title: '¿Está seguro de dar de baja la orden?',
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
                url: '/orden/delete/' + id,
                statusCode: {
                    200: function (response) {
                        Swal.fire({
                            title: 'Borrado!',
                            text: 'La orden fue dada de baja..',
                            icon: 'success',
                            customClass: 'swal-height'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                tableOrder.ajax.reload();
                            }
                            else {
                                tableOrder.ajax.reload();
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



