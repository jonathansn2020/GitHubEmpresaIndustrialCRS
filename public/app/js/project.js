
let proyectos = [];
let c_prod = 0;
let tableProject;
let listProject = [];

let can_planning = $('.can_planning').val();
let can_view = $('.can_view').val();
let can_edit = $('.can_edit').val();

$(document).ready(function () {
    tableProject = $('#myTableProject').DataTable({
        order: [[0, 'desc']],
        dom: 'rtip',
        ajax: function (data, callback, settings) {
            console.log(data);
            $.get('/project/list', {
                order_business: $('#filter_order_business').val(),
                name: $('#filter_name').val(),
                start_date_p: $('#filter_start_date_p').val(),
                expected_date_p: $('#filter_expected_date_p').val(),
                status: $('#filter_status').val(),

            }, function (res) {
                console.log(res);
                listProject = [];
                res.data.forEach(element => {
                    listProject[element.id] = element;
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
            {
                data: function (data) {
                    return formatoFecha(data.start_date_p);
                }
            },
            {
                data: function (data) {
                    return formatoFecha(data.expected_date_p);
                }
            },
            {
                data: function (data) {
                    if (data.end_date_p == null) {
                        return "Por confirmar"
                    }
                    else {
                        return formatoFecha(data.end_date_p);
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
                    else {
                        return '<div class="badge bg-success mt-2">Finalizado</div>';
                    }
                }

            },
            {
                data: function (data) {
                    if(can_planning){
                        if (data.status == 1) {
                            return '<div class="text-center"><a class="btn btn-danger btn-sm mr-1" id="project_id" data-bs-toggle="modal" data-bs-target="#project-activities-modal" data-toggle="tooltip" data-placement="top" title="Planificar proyecto" onclick="show_project(' + data.id + ')"><i class="fas fa-file-signature" style="color:white"></i></a></div>'
                        }
                        if (data.status == 2) {
                            return '<div class="text-center"><a class="btn btn-secondary btn-sm mr-1 disabled" id="project_id"><i class="fas fa-file-signature" style="color:white"></i></a></div>'
                        }
                        if (data.status == 3) {
                            return '<div class="text-center"><a class="btn btn-secondary btn-sm mr-1 disabled" id="project_id"><i class="fas fa-file-signature" style="color:white"></i></a></div>'
                        }
                    }
                    else{
                        return "";
                    }                    
                }
            },
            {
                data: function (data) {
                    if (can_view) {
                        return '<div><a class="btn btn-primary btn-sm mr-1" id="" data-bs-toggle="modal" data-bs-target="#project-show-modal" data-toggle="tooltip" data-placement="top" title="Ver registro" onclick="show_planning_project(' + data.id + ')"><i class="fas fa-eye"></i></a></div>'
                    }
                    else{
                        return "";
                    }                    
                }
            },
            {
                data: function (data) {
                    if (can_edit) {
                        if (data.status == 1) {
                            return '<div><a class="btn btn-success btn-sm mr-1" id="" data-bs-toggle="modal" data-bs-target="#project-edit-modal" data-toggle="tooltip" data-placement="top" title="Editar registro" onclick="edit_project(' + data.id + ')"><i class="fas fa-edit"></i></a></div>'
                        }
                        if (data.status == 2) {
                            return '<div><a class="btn btn-success btn-sm mr-1" id="" data-bs-toggle="modal" data-bs-target="#project-edit-modal" data-toggle="tooltip" data-placement="top" title="Editar registro" onclick="edit_project(' + data.id + ')"><i class="fas fa-edit"></i></a></div>'
                        }
                        if (data.status == 3) {
                            return '<div><a class="btn btn-success btn-sm mr-1 disabled"><i class="fas fa-edit"></i></a></div>'
                        }
                    }
                    else{
                        return "";
                    }                      
                }
            },

        ]
    });
});

function search() {
    tableProject.ajax.reload();
}

function formatoFecha(texto) {
    return texto.replace(/^(\d{4})-(\d{2})-(\d{2})$/g, '$3/$2/$1');
}

function add_product_order() {

    let dataSend = {};
    dataSend.name = document.getElementById('name').value;
    dataSend.summary = document.getElementById('summary').value;
    dataSend.long = document.getElementById('long').value;
    dataSend.width = document.getElementById('width').value;
    dataSend.thickness = document.getElementById('thickness').value;
    dataSend.rows = document.getElementById('rows').value;
    dataSend.tube = document.getElementById('tube').value;
    dataSend.start_date_p = document.getElementById('start_date_p').value;
    dataSend.expected_date_p = document.getElementById('expected_date_p').value;
    dataSend.status = '1';

    let tableBody = document.getElementById('list-products');

    console.log(dataSend);

    $.ajax({
        method: 'POST',
        data: dataSend,
        url: '/project',
        beforeSend: function () {
            document.getElementById('btn-add-product').disabled = true;
            document.getElementById('PageLoadProgress').style.display = "block";
        },
        statusCode: {
            422: function (response) {
                console.log(response.responseJSON.errors);
                c_prod--;
                let validacion = [
                    'name', 'summary', 'long', 'width', 'thickness', 'rows', 'tube', 'start_date_p', 'expected_date_p'
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
                    document.getElementById('btn-add-product').disabled = false;

                });
            },
            200: function (response) {
                console.log(response);
                c_prod++;
                $('#nodata').remove();
                let newRow = tableBody.insertRow(-1);
                let count = tableBody.rows.length;
                newRow.innerHTML = '<th scope="row" style="font-size:12.5px">' + count + '</th><input type="hidden" style="font-size:12.5px" value="' + c_prod + '"><td class="fw-bold" style="font-size:12.5px">' + response['success'][0] + '</td><td><input type="text" style="font-size:12.5px" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold start_date_p" name="start_date" readonly value=' + formatoFecha(response['success'][2]) + '></td><td><input type="text" style="font-size:12.5px" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold expected_date_p" name="expected_date" readonly value=' + formatoFecha(response['success'][3]) + '></td><td><button class="btn btn-danger" onclick="delete_row_project(this)"><i class="fas fa-trash-alt"></i></button></td>';

                let object = {
                    c_prod: c_prod,
                    name: dataSend.name,
                    summary: dataSend.summary,
                    long: dataSend.long,
                    width: dataSend.width,
                    thickness: dataSend.thickness,
                    rows: dataSend.rows,
                    tube: dataSend.tube,
                    start_date_p: dataSend.start_date_p,
                    expected_date_p: dataSend.expected_date_p,
                    status: dataSend.status,
                };

                proyectos.push(object);
                console.log(proyectos);
                document.getElementById('PageLoadProgress').style.display = "none";
                removeDataProject();
                Swal.fire({
                    title: '¿Desea continuar?',
                    text: "Podra agregar un nuevo proyecto a la orden de fabricación",
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'si, continuar',
                    cancelButtonText: 'No',
                    customClass: 'swal-height',
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('btn-add-product').disabled = false;
                        document.getElementById('btn_create_order').disabled = false;
                    }
                    else {
                        removeDataProject();
                        $('#project-modal').modal('hide');
                        document.getElementById('btn-add-product').disabled = false;
                        document.getElementById('btn_create_order').disabled = false;

                    }

                })

            },
            500: function () {
                console.log('error');
            }

        }
    });

}

function show_planning_project(id) {

    let tableBodyEdAT = document.getElementById('list-activities-show');
    $.ajax({
        method: 'GET',
        url: '/project/show/' + id,
        beforeSend: function () {
            document.getElementById('PageLoadProgresshow').style.display = "block";
        },
        statusCode: {
            200: function (response) {
                console.log(response['data']);

                document.getElementById('order_business_show').value = response['order'].order_business;
                document.getElementById('business_show').value = response['user'].name;
                document.getElementById('delivery_place_show').value = response['order'].delivery_place;
                document.getElementById('expected_date_show').value = formatoFecha(response['order'].expected_date);

                document.getElementById('name_p_show').value = response['data'].name;
                document.getElementById('summary_p_show').value = response['data'].summary;
                document.getElementById('long_p_show').value = response['data'].long;
                document.getElementById('width_p_show').value = response['data'].width;
                document.getElementById('thickness_p_show').value = response['data'].thickness;
                document.getElementById('rows_p_show').value = response['data'].rows;
                document.getElementById('tube_p_show').value = response['data'].tube;
                document.getElementById('start_date_p_show').value = response['data'].start_date_p;
                document.getElementById('expected_date_p_show').value = response['data'].expected_date_p;
                document.getElementById('end_date_p_show').value = response['data'].end_date_p;
                document.getElementById('status_p_show').value = response['data'].status;
                document.getElementById('PageLoadProgresshow').style.display = "none";

                $('#nodataActivityshow').remove();

                if (response['actividades'].length <= 0) {
                    $('#list-activities-show tr').remove();
                    $('#list-activities-show').append('<tr id="nodataActivityshow"><td colspan="12">No hay datos ingresados...</td></tr>');
                }
                else {
                    for (let i = 0; i < response['actividades'].length; i++) {
                        console.log(response['actividades'][i]);
                        
                        let newRow = tableBodyEdAT.insertRow(-1);
                        let count = tableBodyEdAT.rows.length;

                        if (response['actividades'][i].fin_real != null && response['actividades'][i].status == "Completada") {
                            if (response['actividades'][i].fin_real > response['actividades'][i].fecha_fin) {
                                newRow.innerHTML = '<th scope="row" style="font-size:12px">' + count + '</th><td style="font-size:12px" class="fw-bold name_activity_n">' + response['actividades'][i].actividad + '</td><td style="font-size:12px" class="fw-bold stage_id_n">' + response['actividades'][i].etapa + '</td><td style="font-size:12px" class="fw-bold priority_n">' + response['actividades'][i].prioridad + '</td><td style="font-size:12px" class="fw-bold start_date_n">' + formatoFecha(response['actividades'][i].fecha_inicio) + '</td><td style="font-size:12px" class="fw-bold expected_date_n">' + formatoFecha(response['actividades'][i].fecha_fin) + '</td><td style="font-size:12px" class="fw-bold true_start_n">' + formatoFecha(response['actividades'][i].inicio_real) + '</td><td style="font-size:12px" class="fw-bold text-danger end_date_n">' + formatoFecha(response['actividades'][i].fin_real) + '</td><td style="font-size:12px" class="fw-bold operator_id_n">' + response['actividades'][i].operador + '</td></td><td style="font-size:12px" class="fw-bold status_activity_n badge bg-danger">Completada fuera de fecha</td>';
                            }
                            else {
                                newRow.innerHTML = '<th scope="row" style="font-size:12px">' + count + '</th><td style="font-size:12px" class="fw-bold name_activity_n">' + response['actividades'][i].actividad + '</td><td style="font-size:12px" class="fw-bold stage_id_n">' + response['actividades'][i].etapa + '</td><td style="font-size:12px" class="fw-bold priority_n">' + response['actividades'][i].prioridad + '</td><td style="font-size:12px" class="fw-bold start_date_n">' + formatoFecha(response['actividades'][i].fecha_inicio) + '</td><td style="font-size:12px" class="fw-bold expected_date_n">' + formatoFecha(response['actividades'][i].fecha_fin) + '</td><td style="font-size:12px" class="fw-bold true_start_n">' + formatoFecha(response['actividades'][i].inicio_real) + '</td><td style="font-size:12px" class="fw-bold text-success end_date_n">' + formatoFecha(response['actividades'][i].fin_real) + '</td><td style="font-size:12px" class="fw-bold operator_id_n">' + response['actividades'][i].operador + '</td></td><td style="font-size:12px" class="fw-bold status_activity_n badge bg-success">' + response['actividades'][i].status + '</td>';
                            }
                        }
                        if (response['actividades'][i].fin_real == null && response['actividades'][i].status == "Proceso") {
                            newRow.innerHTML = '<th scope="row" style="font-size:12px">' + count + '</th><td style="font-size:12px" class="fw-bold name_activity_n">' + response['actividades'][i].actividad + '</td><td style="font-size:12px" class="fw-bold stage_id_n">' + response['actividades'][i].etapa + '</td><td style="font-size:12px" class="fw-bold priority_n">' + response['actividades'][i].prioridad + '</td><td style="font-size:12px" class="fw-bold start_date_n">' + formatoFecha(response['actividades'][i].fecha_inicio) + '</td><td style="font-size:12px" class="fw-bold expected_date_n">' + formatoFecha(response['actividades'][i].fecha_fin) + '</td><td style="font-size:12px" class="fw-bold true_start_n">' + formatoFecha(response['actividades'][i].inicio_real) + '</td><td style="font-size:12px" class="fw-bold end_date_n">---/---/---</td><td style="font-size:12px" class="fw-bold operator_id_n">' + response['actividades'][i].operador + '</td></td><td style="font-size:12px" class="badge bg-warning text-dark fw-bold status_activity_n">' + response['actividades'][i].status + '</td>';
                        }
                        if (response['actividades'][i].fin_real == null && response['actividades'][i].status == "Entrada") {
                            newRow.innerHTML = '<th scope="row" style="font-size:12px">' + count + '</th><td style="font-size:12px" class="fw-bold name_activity_n">' + response['actividades'][i].actividad + '</td><td style="font-size:12px" class="fw-bold stage_id_n">' + response['actividades'][i].etapa + '</td><td style="font-size:12px" class="fw-bold priority_n">' + response['actividades'][i].prioridad + '</td><td style="font-size:12px" class="fw-bold start_date_n">' + formatoFecha(response['actividades'][i].fecha_inicio) + '</td><td style="font-size:12px" class="fw-bold expected_date_n">' + formatoFecha(response['actividades'][i].fecha_fin) + '</td><td style="font-size:12px" class="fw-bold true_start_n">---/---/---</td><td style="font-size:12px" class="fw-bold end_date_n">---/---/---</td><td style="font-size:12px" class="fw-bold operator_id_n">' + response['actividades'][i].operador + '</td></td><td style="font-size:12px" class="badge bg-info fw-bold status_activity_n">' + response['actividades'][i].status + '</td>';
                        }
                    }                    

                }

            },
            500: function () {
                console.log('error');
            }
        }

    });

}


function edit_project(id) {
    let tableBodyEdAT = document.getElementById('list-activities-edit');
    $.ajax({
        method: 'GET',
        url: '/project/edit/' + id,
        beforeSend: function () {
            document.getElementById('PageLoadProgress').style.display = "block";
        },
        statusCode: {
            200: function (response) {
                console.log(response['data']);

                document.getElementById('order_business_edit').value = response['order'].order_business;
                document.getElementById('business_edit').value = response['user'].name;
                document.getElementById('delivery_place_edit').value = response['order'].delivery_place;
                document.getElementById('expected_date_edit').value = formatoFecha(response['order'].expected_date);

                document.getElementById('id').value = response['data'].id;
                document.getElementById('name').value = response['data'].name;
                document.getElementById('summary').value = response['data'].summary;
                document.getElementById('long').value = response['data'].long;
                document.getElementById('width').value = response['data'].width;
                document.getElementById('thickness').value = response['data'].thickness;
                document.getElementById('rows').value = response['data'].rows;
                document.getElementById('tube').value = response['data'].tube;
                document.getElementById('start_date_p').value = response['data'].start_date_p;
                document.getElementById('expected_date_p').value = response['data'].expected_date_p;
                document.getElementById('end_date_p').value = response['data'].end_date_p;
                document.getElementById('status').value = response['data'].status;
                document.getElementById('PageLoadProgress').style.display = "none";

                $('#nodataActivityedit').remove();

                if (response['actividades'].length <= 0) {
                    $('#list-activities-edit tr').remove();
                    $('#list-activities-edit').append('<tr id="nodataActivityedit"><td colspan="12">No hay datos ingresados...</td></tr>');
                }
                else {
                    for (let i = 0; i < response['actividades'].length; i++) {
                        console.log(response['actividades'][i]);
                        
                        let newRow = tableBodyEdAT.insertRow(-1);
                        let count = tableBodyEdAT.rows.length;
                        if (response['actividades'][i].fin_real != null && response['actividades'][i].status == "Completada") {
                            if (response['actividades'][i].fin_real > response['actividades'][i].fecha_fin) {
                                newRow.innerHTML = '<th scope="row" style="font-size:12px">' + count + '</th><td style="font-size:12px" class="fw-bold name_activity_n">' + response['actividades'][i].actividad + '</td><td style="font-size:12px" class="fw-bold stage_id_n">' + response['actividades'][i].etapa + '</td><td style="font-size:12px" class="fw-bold priority_n">' + response['actividades'][i].prioridad + '</td><td style="font-size:12px" class="fw-bold start_date_n">' + formatoFecha(response['actividades'][i].fecha_inicio) + '</td><td style="font-size:12px" class="fw-bold expected_date_n">' + formatoFecha(response['actividades'][i].fecha_fin) + '</td><td style="font-size:12px" class="fw-bold true_start_n">' + formatoFecha(response['actividades'][i].inicio_real) + '</td><td style="font-size:12px" class="fw-bold text-danger end_date_n">' + formatoFecha(response['actividades'][i].fin_real) + '</td><td style="font-size:12px" class="fw-bold operator_id">' + response['actividades'][i].operador + '</td><td style="font-size:12px" class="fw-bold status_activity_n badge bg-danger">Completada fuera de fecha</td>';
                            }
                            else {
                                newRow.innerHTML = '<th scope="row" style="font-size:12px">' + count + '</th><td style="font-size:12px" class="fw-bold name_activity_n">' + response['actividades'][i].actividad + '</td><td style="font-size:12px" class="fw-bold stage_id_n">' + response['actividades'][i].etapa + '</td><td style="font-size:12px" class="fw-bold priority_n">' + response['actividades'][i].prioridad + '</td><td style="font-size:12px" class="fw-bold start_date_n">' + formatoFecha(response['actividades'][i].fecha_inicio) + '</td><td style="font-size:12px" class="fw-bold expected_date_n">' + formatoFecha(response['actividades'][i].fecha_fin) + '</td><td style="font-size:12px" class="fw-bold true_start_n">' + formatoFecha(response['actividades'][i].inicio_real) + '</td><td style="font-size:12px" class="fw-bold text-success end_date_n">' + formatoFecha(response['actividades'][i].fin_real) + '</td><td style="font-size:12px" class="fw-bold operator_id">' + response['actividades'][i].operador + '</td><td style="font-size:12px" class="fw-bold status_activity_n badge bg-success">' + response['actividades'][i].status + '</td>';
                            }
                        }
                        if (response['actividades'][i].fin_real == null && response['actividades'][i].status == "Proceso") {
                            newRow.innerHTML = '<th scope="row" style="font-size:12px">' + count + '</th><td style="font-size:12px" class="fw-bold name_activity_n">' + response['actividades'][i].actividad + '</td><td style="font-size:12px" class="fw-bold stage_id_n">' + response['actividades'][i].etapa + '</td><td style="font-size:12px" class="fw-bold priority_n">' + response['actividades'][i].prioridad + '</td><td style="font-size:12px" class="fw-bold start_date_n">' + formatoFecha(response['actividades'][i].fecha_inicio) + '</td><td style="font-size:12px" class="fw-bold expected_date_n">' + formatoFecha(response['actividades'][i].fecha_fin) + '</td><td style="font-size:12px" class="fw-bold true_start_n">' + formatoFecha(response['actividades'][i].inicio_real) + '</td><td style="font-size:12px" class="fw-bold end_date_n">----/----/----</td><td style="font-size:12px" class="fw-bold operator_id">' + response['actividades'][i].operador + '</td><td style="font-size:12px" class="badge bg-warning text-dark fw-bold status_activity_n">' + response['actividades'][i].status + '</td>';
                        }
                        if (response['actividades'][i].fin_real == null && response['actividades'][i].status == "Entrada") {
                            newRow.innerHTML = '<th scope="row" style="font-size:12px">' + count + '</th><td style="font-size:12px" class="fw-bold name_activity_n">' + response['actividades'][i].actividad + '</td><td style="font-size:12px" class="fw-bold stage_id_n">' + response['actividades'][i].etapa + '</td><td style="font-size:12px" class="fw-bold priority_n">' + response['actividades'][i].prioridad + '</td><td style="font-size:12px" class="fw-bold start_date_n">' + formatoFecha(response['actividades'][i].fecha_inicio) + '</td><td style="font-size:12px" class="fw-bold expected_date_n">' + formatoFecha(response['actividades'][i].fecha_fin) + '</td><td style="font-size:12px" class="fw-bold true_start_n">----/----/----</td><td style="font-size:12px" class="fw-bold end_date_n">----/----/----</td><td style="font-size:12px" class="fw-bold operator_id">' + response['actividades'][i].operador + '</td><td style="font-size:12px" class="badge bg-info fw-bold status_activity_n">' + response['actividades'][i].status + '</td>';
                        }

                    }
                }

            },
            500: function () {
                console.log('error');
            }
        }

    });
}

function update_project() {

    let dataSend = {};
    dataSend.id = document.getElementById('id').value
    dataSend.name = document.getElementById('name').value;
    dataSend.summary = document.getElementById('summary').value;
    dataSend.long = document.getElementById('long').value;
    dataSend.width = document.getElementById('width').value;
    dataSend.thickness = document.getElementById('thickness').value;
    dataSend.rows = document.getElementById('rows').value;
    dataSend.tube = document.getElementById('tube').value;
    dataSend.status = document.getElementById('status').value;
    dataSend.start_date_p = document.getElementById('start_date_p').value;
    dataSend.expected_date_p = document.getElementById('expected_date_p').value;
    console.log(dataSend);
    $.ajax({
        method: 'PUT',
        data: dataSend,
        url: '/project/update/' + dataSend.id,
        beforeSend: function () {
            document.getElementById('PageLoadProgress').style.display = "block";
            document.getElementById('btn-edit-project').disabled = true;
        },
        statusCode: {
            422: function (response) {
                console.log(response.responseJSON.errors);
                document.getElementById('alert-validacion').classList.remove('d-none');
                let validacion = [
                    'name', 'summary', 'long', 'width', 'thickness', 'rows', 'tube', 'status', 'start_date_p', 'expected_date_p'
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
                    document.getElementById('btn-edit-project').disabled = false;
                });

            },
            200: function (response) {
                console.log(response);
                removeDataProjectEdit();
                document.getElementById('PageLoadProgress').style.display = "none";
                document.getElementById('btn-edit-project').disabled = false;

                $('#project-edit-modal').modal('hide');
                Swal.fire(
                    'Bien hecho!',
                    response['message'],
                    'success'
                ).then(function () {
                    tableProject.ajax.reload();
                });

            },
            500: function () {
                console.log('error, comuniquese con soporte');
            }

        }

    });
}

function show_project(id) {
    let tableBodyA = document.getElementById('list-activities');
    $.ajax({
        method: 'GET',
        url: '/project/' + id,
        statusCode: {
            200: function (response) {
                console.log(response['data']);

                document.getElementById('project_id').value = response['data'].id;
                document.getElementById('name_project').value = response['data'].name;
                document.getElementById('start_date_pp').value = formatoFecha(response['data'].start_date_p);
                document.getElementById('expected_date_pp').value = formatoFecha(response['data'].expected_date_p);

                for (let i = 0; i < response['activities'].length; i++) {
                    c_activity++;
                    $('#nodataActivity').remove();
                    let newRow = tableBodyA.insertRow(-1);
                    let count = tableBodyA.rows.length;
                    newRow.innerHTML = '<th scope="row" style="font-size:12px">' + count + '</th><input type="hidden" value="' + c_activity + '"><input type="hidden" class="activity_id_n" value="' + response['activities'][i].id + '"><td style="font-size:12px" class="fw-bold name_activity_n">' + response['activities'][i].name + '</td><input type="hidden" name="stage_id" class="validarRow stage_id_n" value="' + response['activities'][i].stage_id + '"><td style="font-size:12px" class="form-control form-control-sm text-center fw-bold">' + response['activities'][i].stage.name + '</td><td><select style="font-size:12px" class="form-control form-control-sm text-center fw-bold validarRow priority_n" name="priority"><option value="">Seleccionar...</option><option selected="selected" value="Alta">Alta</option><option value="Media">Media</option><option value="Baja">Baja</option></select></td><td><input type="date" style="font-size:12px" class="form-control form-control-sm form-control-plaintext fw-bold text-center bg-light validarRow start_date_n" name="start_date" value=""></td><td><input type="date" style="font-size:12px" class="form-control form-control-sm form-control-plaintext fw-bold text-center bg-light validarRow expected_date_n" name="expected_date" value=""></td><td><select style="font-size:12px" class="selectOperator validarRow form-control form-control-sm bg-white fw-bold text-center operator_id_n" name="operator_id"></select></td><td><button class="btn btn-sm btn-danger" onclick="delete_row_project_activity(this)"><i class="fas fa-trash-alt"></i></button></td>';
                }

                $(".selectOperator").empty();
                $(".selectOperator").append('<option value="">Elegir...</option>');

                for (let i = 0; i < response['operators'].length; i++) {
                    $('.selectOperator').append('<option value="' + response['operators'][i].id + '">' + response['operators'][i].name + '</option>');
                }
            },
            500: function () {
                console.log('error');
            }
        }
    })
}

function delete_row_project(e) {

    let tableBody = document.getElementById('list-products');
    let row = e.parentNode.parentNode;
    tableBody.removeChild(row);

    let rows = tableBody.getElementsByTagName('tr');
    for (let i = 0; i < rows.length; i++) {
        let row = rows[i];
        let items = row.getElementsByTagName('th')[0];
        items.innerHTML = i + 1;
    }

    let index = proyectos.findIndex(el => el.c_prod == row.getElementsByTagName('input')[0].value);

    proyectos.splice(index, 1);
    console.log(proyectos);

    if (tableBody.rows.length == 0) {
        $('#list-products').append('<tr id="nodata"><td colspan="12">No hay datos ingresados...</td></tr>');
    }
    else {
        $('#nodata').remove();
    }

}

function removeDataProjectShow() {
    document.getElementById('name_p_show').value = "";
    document.getElementById('summary_p_show').value = "";
    document.getElementById('long_p_show').value = "";
    document.getElementById('width_p_show').value = "";
    document.getElementById('thickness_p_show').value = "";
    document.getElementById('rows_p_show').value = "";
    document.getElementById('start_date_p_show').value = "";
    document.getElementById('expected_date_p_show').value = "";
    document.getElementById('end_date_p_show').value = "";

    $("#tube_p_show").val('');
    $("#status_p_show").val('');

    document.getElementById('PageLoadProgresshow').style.display = "none";

    $('#list-activities-show tr').remove();
    $('#list-activities-show').append('<tr id="nodataActivityshow"><td colspan="12">No hay datos ingresados...</td></tr>');
}

function removeDataProjectEdit() {
    document.getElementById('name').value = "";
    document.getElementById('summary').value = "";
    document.getElementById('long').value = "";
    document.getElementById('width').value = "";
    document.getElementById('thickness').value = "";
    document.getElementById('rows').value = "";
    document.getElementById('start_date_p').value = "";
    document.getElementById('expected_date_p').value = "";
    $("#tube").val('');
    $("#status").val('');
    document.getElementById('name').classList.remove('is-invalid');
    document.getElementById('summary').classList.remove('is-invalid');
    document.getElementById('long').classList.remove('is-invalid');
    document.getElementById('width').classList.remove('is-invalid');
    document.getElementById('thickness').classList.remove('is-invalid');
    document.getElementById('tube').classList.remove('is-invalid');
    document.getElementById('rows').classList.remove('is-invalid');
    document.getElementById('status').classList.remove('is-invalid');
    document.getElementById('start_date_p').classList.remove('is-invalid');
    document.getElementById('expected_date_p').classList.remove('is-invalid');

    document.getElementById('PageLoadProgress').style.display = "none";
    document.getElementById('alert-validacion').classList.add('d-none');

    $("#name-error div").remove();
    $("#summary-error div").remove();
    $("#long-error div").remove();
    $("#width-error div").remove();
    $("#thickness-error div").remove();
    $("#tube-error div").remove();
    $("#rows-error div").remove();
    $("#start_date_p-error div").remove();
    $("#expected_date_p-error div").remove();
    $("#status-error div").remove();

    $('#list-activities-edit tr').remove();
    $('#list-activities-edit').append('<tr id="nodataActivityedit"><td colspan="12">No hay datos ingresados...</td></tr>');
}

function removeDataProject() {

    document.getElementById('name').value = "";
    document.getElementById('summary').value = "";
    document.getElementById('long').value = "";
    document.getElementById('width').value = "";
    document.getElementById('thickness').value = "";
    document.getElementById('rows').value = "";
    document.getElementById('start_date_p').value = "";
    document.getElementById('expected_date_p').value = "";
    $("#tube").val('');
    document.getElementById('name').classList.remove('is-invalid');
    document.getElementById('summary').classList.remove('is-invalid');
    document.getElementById('long').classList.remove('is-invalid');
    document.getElementById('width').classList.remove('is-invalid');
    document.getElementById('thickness').classList.remove('is-invalid');
    document.getElementById('tube').classList.remove('is-invalid');
    document.getElementById('rows').classList.remove('is-invalid');
    document.getElementById('start_date_p').classList.remove('is-invalid');
    document.getElementById('expected_date_p').classList.remove('is-invalid');

    document.getElementById('PageLoadProgress').style.display = "none";
    document.getElementById('alert-validacion').classList.add('d-none');

    $("#name-error div").remove();
    $("#summary-error div").remove();
    $("#long-error div").remove();
    $("#width-error div").remove();
    $("#thickness-error div").remove();
    $("#tube-error div").remove();
    $("#rows-error div").remove();
    $("#start_date_p-error div").remove();
    $("#expected_date_p-error div").remove();

}