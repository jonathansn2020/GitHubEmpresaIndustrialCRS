let c_activity = 0;
let actividades = [];

function add_one_activity() {

    let dataSend = {}

    let tableBodyA = document.getElementById('list-activities');

    let select_ope = document.getElementById('operator_id');
    let desc_ope = select_ope.options[select_ope.selectedIndex].innerHTML;

    let select_f = document.getElementById('stage_id');
    let desc_fase = select_f.options[select_f.selectedIndex].innerHTML;

    dataSend.project_id = document.getElementById('project_id').value;
    dataSend.name_activity = document.getElementById('name_activity').value;
    dataSend.priority = document.getElementById('priority').value;
    dataSend.start_date = document.getElementById('start_date').value;
    dataSend.expected_date = document.getElementById('expected_date').value;
    dataSend.stage_id = document.getElementById('stage_id').value;
    dataSend.operator_id = document.getElementById('operator_id').value;
    dataSend.desc_ope = desc_ope;
    dataSend.desc_fase = desc_fase;
    dataSend.select_f = select_f.value;
    console.log(dataSend);

    $.ajax({
        method: 'POST',
        url: '/planning',
        data: dataSend,
        beforeSend: function () {
            document.getElementById('PageLoadProgresAct').style.display = "block";
            document.getElementById('btn-add-activity').disabled = true;
        },
        statusCode: {
            422: function (response) {
                console.log(response.responseJSON.errors);
                document.getElementById('PageLoadProgresAct').style.display = "none";
                c_activity--;
                let validacion = [
                    'name_activity', 'priority', 'start_date', 'expected_date', 'stage_id', 'operator_id'
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

                    document.getElementById('btn-add-activity').disabled = false;

                });
            },
            200: function (response) {
                console.log(response);
                c_activity++;
                $('#nodataActivity').remove();
                let newRow = tableBodyA.insertRow(-1);
                let count = tableBodyA.rows.length;
                newRow.classList.add('bg-secondary');
                newRow.innerHTML = '<th scope="row" style="font-size:12px">' + count + '</th><input type = "hidden" value = "' + c_activity + '" ><input type="hidden" class="activity_id_n" value="' + response['success'][8] + '"><td style="font-size:12px" class="fw-bold name_activity_n">' + response['success'][0] + '</td><input type="hidden" class="validarRow stage_id_n" value="' + response['success'][7] + '"><td style="font-size:12px" class="fw-bold">' + response['success'][1] + '</td><td><input type="text" style="font-size:12px" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold validarRow priority_n" name="priority" readonly value=' + response['success'][2] + '></td><td><input type="text" style="font-size:12px" class="form-control form-control-sm form-control-plaintext fw-bold text-center bg-light validarRow start_date_n" name="start_date" readonly value=' + formatoFecha(response['success'][3]) + '></td><td><input type="text" style="font-size:12px" class="form-control form-control-sm form-control-plaintext text-center bg-light fw-bold validarRow expected_date_n" name="expected_date" readonly value=' + formatoFecha(response['success'][4]) + '></td><input type="hidden" class="validarRow operator_id_n" value="' + response['success'][9] + '"><td style="font-size:12px" class="fw-bold">' + response['success'][5] + '</td><td><button class="btn btn-sm btn-danger" onclick="delete_row_project_activity(this)"><i class="fas fa-trash-alt"></i></button></td>';

                document.getElementById('PageLoadProgresAct').style.display = "none";
                document.getElementById('btn-add-activity').disabled = false;

                removeDataActivity();

            },
            500: function () {
                console.log('error');
            }
        }
    });

}

function store_activities() {
    //Contar los campos que comparten clase
    let cantidad = $('.validarRow').length;
    //Inicializar un contador
    let contador = 0;
    //Marcar con borde rojo todos los vacíos
    $('.validarRow').each(function () {
        if ($(this).val() === '') {
            $(this).addClass('border-danger');
        } else {
            $(this).removeClass('border-danger');
        }
    });
    //Hacer foco en el primer vacío
    $('.validarRow').each(function () {
        if ($(this).val() === '') {
            $(this).focus();
            return false;
        }
        contador++;
    });

    if (cantidad === contador) {
        console.log('No hay vacíos!');
        c_activity = 0;
        document.querySelectorAll('#list-activities tr').forEach(function (e) {
            c_activity++;
            let object = {
                c_activity: c_activity,
                name: e.querySelector('.name_activity_n').innerHTML,
                priority: e.querySelector('.priority_n').value,
                start_date: formatoFecha(e.querySelector('.start_date_n').value),
                expected_date: formatoFecha(e.querySelector('.expected_date_n').value),
                stage_id: e.querySelector('.stage_id_n').value,
                activity_id: e.querySelector('.activity_id_n').value,
                operator_id: e.querySelector('.operator_id_n').value,
                project_id: document.getElementById('project_id').value
            };

            actividades.push(object);

        });
        console.log(actividades);

        let objetos = JSON.stringify(actividades);

        $.ajax({
            method: 'POST',
            url: '/planning/store',
            data: { objetos: objetos },
            beforeSend: function () {
                document.getElementById('btn-add-activity').disabled = true;
            },
            statusCode: {
                200: function (response) {
                    console.log(response);
                    $('#project-activities-modal').modal('hide');
                    limpiar();
                    Swal.fire(
                        'Bien hecho!',
                        response['message'],
                        'success'
                    ).then(function () {
                        actividades = [];
                        tableProject.ajax.reload();
                    });
                    document.getElementById('btn-add-activity').disabled = false;
                },
                500: function () {
                    console.log('Error');
                }
            }
        });
    }
}


function delete_row_project_activity(e) {

    let tableBodyA = document.getElementById('list-activities');
    let row = e.parentNode.parentNode;
    tableBodyA.removeChild(row);

    let rows = tableBodyA.getElementsByTagName('tr');
    for (let i = 0; i < rows.length; i++) {
        let row = rows[i];
        let items = row.getElementsByTagName('th')[0];
        items.innerHTML = i + 1;
    }

    let index = actividades.findIndex(el => el.c_activity == row.getElementsByTagName('input')[0].value);

    actividades.splice(index, 1);
    console.log(actividades);

    if (tableBodyA.rows.length == 0) {
        $('#list-activities').append('<tr id="nodataActivity"><td colspan="12">No hay datos ingresados...</td></tr>');
    }
    else {
        $('#nodataActivity').remove();
    }

}

function limpiar() {

    document.getElementById('name_activity').value = "";
    document.getElementById('priority').value = "";
    document.getElementById('start_date').value = "";
    document.getElementById('expected_date').value = "";
    $("#stage_id").val('');
    $("#operator_id").val('');
    document.getElementById('name_activity').classList.remove('is-invalid');
    document.getElementById('priority').classList.remove('is-invalid');
    document.getElementById('start_date').classList.remove('is-invalid');
    document.getElementById('expected_date').classList.remove('is-invalid');
    document.getElementById('stage_id').classList.remove('is-invalid');
    document.getElementById('operator_id').classList.remove('is-invalid');
    $("#name_activity-error div").remove();
    $("#priority-error div").remove();
    $("#start_date-error div").remove();
    $("#expected_date-error div").remove();
    $("#stage_id-error div").remove();
    $("#operator_id-error div").remove();

    actividades = [];
    $('#list-activities tr').remove();
    $('#list-activities').append('<tr id="nodataActivity"><td colspan="12">No hay datos ingresados...</td></tr>');

}

function removeDataActivity() {

    document.getElementById('name_activity').value = "";
    document.getElementById('priority').value = "";
    document.getElementById('start_date').value = "";
    document.getElementById('expected_date').value = "";
    $("#stage_id").val('');
    $("#operator_id").val('');
    document.getElementById('name_activity').classList.remove('is-invalid');
    document.getElementById('priority').classList.remove('is-invalid');
    document.getElementById('start_date').classList.remove('is-invalid');
    document.getElementById('expected_date').classList.remove('is-invalid');
    document.getElementById('stage_id').classList.remove('is-invalid');
    document.getElementById('operator_id').classList.remove('is-invalid');

    $("#name_activity-error div").remove();
    $("#priority-error div").remove();
    $("#start_date-error div").remove();
    $("#expected_date-error div").remove();
    $("#stage_id-error div").remove();
    $("#operator_id-error div").remove();

}



