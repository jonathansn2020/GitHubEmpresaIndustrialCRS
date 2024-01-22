<div class="modal fade" aria-hidden="true" id="project-show-modal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgb(33,136,201);">
                <h5 class="modal-title" style="color:#fff" id="exampleModalLabel">Ver Proyecto de Fabricación</h5>
            </div>
            <div class="modal-body">
                <form action="" id="formContent" action="" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <h1 class="card-title">Datos de la Orden</h1>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-12 col-md-6 col-lg-6">
                                    <label class="col-form-label col-form-label-sm" for="order_business_show">Orden del cliente:</label>
                                    <input type="text" class="form-control form-control-sm bg-white" name="order_business" id="order_business_show" placeholder="Ingrese orden" readonly>
                                </div>
                                <div class="mb-3 col-12 col-md-6 col-lg-6">
                                    <label class="col-form-label col-form-label-sm" for="business_show">Cliente:</label>
                                    <input type="text" class="form-control form-control-sm bg-white" name="business" id="business_show" placeholder="Ingrese orden" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-12 col-md-6 col-lg-6">
                                    <label class="col-form-label col-form-label-sm" for="delivery_place_show">Lugar de entrega:</label>
                                    <input type="text" class="form-control form-control-sm bg-white" name="delivery_place" id="delivery_place_show" placeholder="Ingrese lugar entrega" readonly>
                                </div>
                                <div class="mb-3 col-12 col-md-6 col-lg-6">
                                    <label class="col-form-label col-form-label-sm" for="expected_date_show">Fecha entrega:</label>
                                    <input type="text" class="form-control form-control-sm bg-white" name="expected_date" id="expected_date_show" placeholder="Ingrese fecha entrega" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-12">
                            <label class="col-form-label col-form-label-sm" for="name">Proyecto:</label>
                            <input type="text" class="form-control form-control-sm bg-white" name="name" id="name_p_show" placeholder="Ingrese un nombre" readonly>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="col-form-label col-form-label-sm" for="summary">Resumen:</label>
                            <textarea class="form-control form-control-sm bg-white" name="summary" id="summary_p_show" cols="20" rows="1" maxlength="120" placeholder="Por favor ingrese un resumen del proyecto"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3 col-12 col-md-6 col-lg-2">
                            <label class="col-form-label col-form-label-sm" for="long">Medida Largo "</label>
                            <input type="text" class="form-control form-control-sm bg-white" name="long" id="long_p_show" placeholder="Ingrese su medida" readonly>
                        </div>
                        <div class="col mb-3 col-12 col-md-6 col-lg-2">
                            <label class="col-form-label col-form-label-sm" for="width">Medida Ancho "</label>
                            <input type="text" class="form-control form-control-sm bg-white" name="width" id="width_p_show" placeholder="Ingrese su medida" readonly>
                        </div>
                        <div class="col mb-3 col-12 col-md-6 col-lg-2">
                            <label for="thickness" class="col-form-label col-form-label-sm">Medida Espesor "</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="thickness" class="form-control form-control-sm bg-white" id="thickness_p_show" placeholder="Ingrese su medida" readonly>
                            </div>
                        </div>
                        <div class="col mb-3 col-12 col-md-6 col-lg-2">
                            <label class="col-form-label col-form-label-sm" for="rows">Filas:</label>
                            <input type="number" class="form-control form-control-sm bg-white" name="rows" id="rows_p_show" min="1" pattern="^[0-9]+" placeholder="Ingrese cantidad filas" readonly>
                        </div>
                        <div class="col mb-3 col-12 col-md-6 col-lg-2">
                            <label for="tube" class="col-form-label col-form-label-sm">Tubo:</label>
                            <div class="input-group input-group-sm">
                                <select class="form-control form-control-sm bg-white" id="tube_p_show" name="tube" disabled>
                                    <option value="" selected>Seleccionar...</option>
                                    <option value="3/8">3/8</option>
                                </select>
                                <span class="input-group-text fw-bold">ø</span>
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-md-6 col-lg-2">
                            <label class="col-form-label col-form-label-sm" for="status">Estado:</label>
                            <select class="form-control form-control-sm bg-white" name="status" id="status_p_show" disabled>
                                <option value="">Seleccionar...</option>
                                <option value="1">Registrada</option>
                                <option value="2">En Proceso</option>
                                <option value="3">Completada</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3 col-12 col-md-6 col-lg-3">
                            <label class="col-form-label col-form-label-sm" for="start_date_p">Fecha Inicio Planificado:</label>
                            <input type="date" class="form-control form-control-sm bg-white" name="start_date_p" id="start_date_p_show" placeholder="Ingrese fecha inicio" readonly>
                        </div>
                        <div class="col mb-3 col-12 col-md-6 col-lg-3">
                            <label class="col-form-label col-form-label-sm" for="expected_date_p">Fecha Fin Planificado:</label>
                            <input type="date" class="form-control form-control-sm bg-white" name="expected_date_p" id="expected_date_p_show" placeholder="Ingrese fecha prevista" readonly>
                        </div>
                        <div class="mb-3 col-12 col-md-6 col-lg-3">
                            <label class="col-form-label col-form-label-sm" for="end_date_p">Fecha Fin Real:</label>
                            <input type="date" class="form-control form-control-sm bg-secondary" name="end_date_p" id="end_date_p_show" placeholder="Ingrese fecha finalizacion" readonly>
                        </div>                        
                    </div>
                </form>
                <div id="PageLoadProgresshow" class="mb-2 p-2" style="display:none;margin:0 auto;width:120px;border:#014c8d 1px solid;background-color:#eeeeee"><img src="{{asset('images/gif/Progress-circle.gif')}}" alt="Progress"><span class="ml-1" style="color: #0069A5;font-size:12.5px">Cargando...</span></div>
                <div class="row">
                    <div class="col-form-label col-form-label-sm mb-2"><strong>Se planificó las siguientes actividades:</strong></div>
                    <div class="mb-3 col-12 table-responsive">
                        <table class="table table-bordered table-hover text-center">
                            <thead style="color:#ffffff; background-color: rgb(33,136,201)">
                                <tr>
                                    <th class="align-middle text-sm" scope="col">Item</th>
                                    <th class="align-middle text-sm" scope="col">Actividad</th>
                                    <th class="align-middle text-sm" scope="col">Etapa Fabricación</th>
                                    <th class="align-middle text-sm" scope="col">Prioridad</th>
                                    <th class="align-middle text-sm" scope="col">Inicio Planificado</th>
                                    <th class="align-middle text-sm" scope="col">Fin Planificado</th>
                                    <th class="align-middle text-sm" scope="col">Inicio Real</th>
                                    <th class="align-middle text-sm" scope="col">Fin Real</th>
                                    <th class="align-middle text-sm" scope="col">Operario Asignado</th>
                                    <th class="align-middle text-sm" scope="col">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm" id="list-activities-show">
                                <tr id="nodataActivityshow">
                                    <td colspan="12">No hay datos ingresados...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" onclick="removeDataProjectShow()"><i class="fas fa-sign-out-alt"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>