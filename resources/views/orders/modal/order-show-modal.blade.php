<div class="modal fade" aria-hidden="true" id="order-show-modal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgb(33,136,201);">
                <h5 class="modal-title" style="color:#fff" id="exampleModalLabel">Ver Orden de Fabricación</h5>
            </div>
            <div class="modal-body">
                <form action="" id="formContent" action="" method="post">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-12 col-md-4 col-lg-3">
                            <label class="col-form-label col-form-label-sm" for="cod_document_show">Codigo Orden:</label>
                            <input type="text" class="form-control form-control-sm bg-white bg-white" name="cod_document" id="cod_document_show" readonly>
                        </div>
                        <div class="mb-3 col-12 col-md-4 col-lg-3">
                            <input type="hidden" id="id">
                            <label class="col-form-label col-form-label-sm" for="business_show">Cliente:</label>
                            <input type="text" class="form-control form-control-sm bg-white" name="business" id="business_show" placeholder="Ingrese nombre de la empresa" readonly>
                        </div>
                        <div class="mb-3 col-12 col-md-4 col-lg-3">
                            <label class="col-form-label col-form-label-sm" for="order_business_show">Orden del cliente:</label>
                            <input type="text" class="form-control form-control-sm bg-white" name="order_business" id="order_business_show" placeholder="Ingrese orden del cliente" readonly>
                        </div>
                        <div class="mb-3 col-12 col-md-4 col-lg-3">
                            <label class="col-form-label col-form-label-sm" for="requested_show">Nombre del solicitante:</label>
                            <input type="text" class="form-control form-control-sm bg-white" name="requested" id="requested_show" placeholder="Ingrese nombre del solicitante" readonly>
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="mb-3 col-12 col-md-4 col-lg-3">
                            <label class="col-form-label col-form-label-sm" for="phone_show">Teléfono:</label>
                            <input type="text" class="form-control form-control-sm bg-white" name="phone" id="phone_show" placeholder="Ingrese su número" readonly>
                            <small style="font-size:12.5px" id="phone-error"></small>
                        </div>
                        <div class="mb-3 col-12 col-md-4 col-lg-3">
                            <label for="email_show" class="col-form-label col-form-label-sm">Email:</label>
                            <div class="input-group input-group-sm">
                                <input type="email" name="email" class="form-control form-control-sm bg-white" id="email_show" placeholder="Ingrese su correo" readonly>
                                <span class="input-group-text fw-bold" id="email">@</span>
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-md-4 col-lg-6">
                            <label class="col-form-label col-form-label-sm" for="delivery_place_show">Dirección de entrega:</label>
                            <input type="text" class="form-control form-control-sm bg-white" name="delivery_place" id="delivery_place_show" placeholder="Ingrese su dirección" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-12 col-md-6 col-lg-3">
                            <label class="col-form-label col-form-label-sm" for="expected_date_show">Fecha de entrega solicitada:</label>
                            <input type="date" class="form-control form-control-sm bg-white" name="expected_date" id="expected_date_show" placeholder="Ingrese fecha prevista" readonly>
                        </div>
                        <div class="mb-3 col-12 col-md-6 col-lg-3">
                            <label class="col-form-label col-form-label-sm" for="end_date_show">Fecha de entrega real:</label>
                            <input type="date" class="form-control form-control-sm bg-secondary" name="end_date" id="end_date_show" placeholder="Ingrese fecha finalizacion" readonly>
                        </div>
                        <div class="mb-3 col-12 col-md-6 col-lg-3">
                            <label class="col-form-label col-form-label-sm" for="status_show">Estado:</label>
                            <select class="form-control form-control-sm bg-white" disabled name="status" id="status_show">
                                <option value="">Seleccionar...</option>
                                <option value="1">Por Planificar</option>
                                <option value="2">En Proceso</option>
                                <option value="3">Finalizado</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-2 col-12">
                            <label class="col-form-label col-form-label-sm" for="note_show">Nota <img class="pl-2 img-fluid" style="height: 30px;" src="{{asset('images/iconos/apuntes-de-clase.png')}}" alt="nootebok"></label>
                            <textarea class="form-control form-control-sm bg-white" name="note" id="note_show" cols="30" rows="3" placeholder="Por favor ingrese una descripción" readonly></textarea>
                        </div>
                    </div>
                </form>
                <div id="PageLoadProgressOS" class="p-2" style="display:none;margin:0 auto;width:120px;border:#014c8d 1px solid;background-color:#eeeeee"><img src="{{asset('images/gif/Progress-circle.gif')}}" alt="Progress"><span class="ml-1" style="color: #0069A5;font-size:12.5px">Cargando...</span></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>