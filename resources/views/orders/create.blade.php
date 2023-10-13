@extends('adminlte::page')

@section('title', 'Orden de fabricación')

@section('content_header')

@stop
@section('content')
@include('orders.modal.order-create-modal')
<div class="container py-2">
    <form action="" id="formContent" action="" method="post">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card" style="border-radius: 10px; border: 1px solid rgb(117,115,113)">
                    <div class="card-header" style="border-radius: 10px 10px 0px 0px; border: 1px solid rgb(117,115,113); background-color: rgb(33,136,201);">
                        <h1 class="h5" style="color:#ffffff">Nueva orden de fabricación</h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-12 col-md-4 col-lg-5">
                                <label class="col-form-label col-form-label-sm" for="orders.user_id">Cliente:</label>
                                <select name="user_id" class="form-control form-control-sm" id="orders.user_id" required>
                                    <option value="">Seleccionar...</option>
                                    @foreach($users[0]->users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                                <small style="font-size:12.5px" id="orders.user_id-error"></small>
                            </div>
                            <div class="mb-3 col-12 col-md-4 col-lg-4">
                                <label class="col-form-label col-form-label-sm" for="orders.requested">Nombre del solicitante:</label>
                                <input type="text" class="form-control form-control-sm" name="requested" id="orders.requested" placeholder="Ingrese nombre del solicitante">
                                <small style="font-size:12.5px" id="orders.requested-error"></small>
                            </div>
                            <div class="mb-3 col-12 col-md-4 col-lg-3">
                                <label class="col-form-label col-form-label-sm" for="orders.order_business">Orden del cliente:</label>
                                <input type="text" class="form-control form-control-sm" name="order_business" id="orders.order_business" placeholder="Ingrese orden del cliente" required>
                                <small style="font-size:12.5px" id="orders.order_business-error"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12 col-md-4 col-lg-2">
                                <label class="col-form-label col-form-label-sm" for="orders.phone">Teléfono:</label>
                                <input type="text" class="form-control form-control-sm" name="phone" id="orders.phone" placeholder="Ingrese su número" required>
                                <small style="font-size:12.5px" id="orders.phone-error"></small>
                            </div>
                            <div class="mb-3 col-12 col-md-4 col-lg-3">
                                <label for="orders.email" class="col-form-label col-form-label-sm">Email:</label>
                                <div class="input-group input-group-sm">
                                    <input type="email" name="email" class="form-control form-control-sm" id="orders.email" placeholder="Ingrese su correo" required>
                                    <span class="input-group-text fw-bold" id="email">@</span>
                                    <small style="font-size:12.5px" id="orders.email-error"></small>
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-md-4 col-lg-4">
                                <label class="col-form-label col-form-label-sm" for="orders.delivery_place">Dirección de entrega:</label>
                                <input type="text" class="form-control form-control-sm" name="delivery_place" id="orders.delivery_place" placeholder="Ingrese su dirección" required>
                                <small style="font-size:12.5px" id="orders.delivery_place-error"></small>
                            </div>
                            <div class="mb-3 col-12 col-md-6 col-lg-2">
                                <label class="col-form-label col-form-label-sm" for="orders.sexpected_date">Fec.entrega solicitada:</label>
                                <input type="date" class="form-control form-control-sm" name="expected_date" id="orders.expected_date" placeholder="Ingrese fecha prevista" required>
                                <small style="font-size:12.5px" id="orders.expected_date-error"></small>
                            </div>
                            <div class="mb-3 col-12 col-md-6 col-lg-1 text-right">
                                <br><a style="border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Nuevo proyecto" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#project-modal"><i class="fas fa-plus" style="color:white"></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-2 col-12">
                                <label class="col-form-label col-form-label-sm" for="note">Nota</label>
                                <textarea class="form-control form-control-sm" name="note" id="note" cols="30" rows="3" placeholder="Por favor ingrese una descripción"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12 table-responsive">
                                <div class="col-form-label col-form-label-sm py-2"><strong>Se agradece atender en lo siguiente:</strong></div>
                                <table class="table table-bordered table-sm table-hover text-center">
                                    <thead style="color:#ffffff; background-color: rgb(33,136,201)">
                                        <tr>
                                            <th class="align-text-top text-sm" scope="col">Item</th>
                                            <th class="align-text-top text-sm" scope="col">Proyecto</th>
                                            <th class="align-text-top text-sm" scope="col">Fecha Inicio</th>
                                            <th class="align-text-top text-sm" scope="col">Fecha Prevista</th>
                                            <th class="align-text-top text-sm" scope="col"><i class="fas fa-trash-alt"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm" id="list-products">
                                        <tr id="nodata">
                                            <td colspan="12">No hay datos ingresados...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="float-right">
                            <a href="{{route('orders.index')}}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-sign-out-alt"></i>
                                Cancelar
                            </a>
                            <button type="button" class="btn btn-sm text-white" style="background-color:#3a3b49" id="btn_create_order" onclick="create_order()"><i class="fas fa-check-circle text-white"></i>Agregar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@stop
@section('css')
@include('layout-admin.base-css')
@stop
@section('js')
@include('layout-admin.base-js')
<script src="{{asset('app/js/project.js')}}"></script>
<script src="{{asset('app/js/order.js')}}"></script>
<script>
    document.getElementById('btn_create_order').disabled = true;

    function create_order() {

        document.getElementById("formContent").addEventListener('submit', (e) => {
            e.preventDefault();
        });

        let dataSend = {};
        dataSend.requested = document.getElementById('orders.requested').value;
        dataSend.phone = document.getElementById('orders.phone').value;
        dataSend.email = document.getElementById('orders.email').value;
        dataSend.order_business = document.getElementById('orders.order_business').value;
        dataSend.delivery_place = document.getElementById('orders.delivery_place').value;
        dataSend.expected_date = document.getElementById('orders.expected_date').value;
        dataSend.note = document.getElementById('note').value;
        dataSend.user_id = document.getElementById('orders.user_id').value;

        console.log(dataSend);

        let projects = JSON.stringify(proyectos);
        console.log(proyectos);
        $.ajax({
            method: 'POST',
            data: {
                'orders': dataSend,
                'projects': projects
            },
            url: '/orden/store',
            beforeSend: function() {
                document.getElementById('btn_create_order').disabled = true;
            },
            statusCode: {
                422: function(response) {
                    console.log(response.responseJSON.errors);
                    let validacion = [
                        'orders.user_id', 'orders.phone', 'orders.email', 'orders.order_business', 'orders.delivery_place', 'orders.expected_date'
                    ];

                    let errors = response.responseJSON.errors;
                    validacion.forEach(function(valor) {
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
                        } else {
                            document.getElementById(valor + '-error').innerText = '';
                            document.getElementById(valor).classList.remove('is-invalid');
                        }

                        document.getElementById('btn_create_order').disabled = false;

                    });
                },
                200: function(response) {
                    console.log(response['message']);

                    Swal.fire(
                        'Bien hecho!',
                        response['message'],
                        'success'
                    ).then(function() {
                        window.location = '/orden';

                    });

                },
                500: function() {
                    console.log('error');
                }
            }
        });

    }
</script>
@stop