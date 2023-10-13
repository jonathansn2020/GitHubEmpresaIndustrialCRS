<div class="modal fade" aria-hidden="true" id="project-edit-modal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgb(33,136,201);">
                <h5 class="modal-title" style="color:#fff" id="exampleModalLabel">Editar Proyecto de Fabricación</h5>
            </div>
            <div class="modal-body">
                <form action="" id="formContent" action="" method="post">
                    <div id="alert-validacion" class="alert alert-info d-none">El proyecto no pudo ser editado, favor de revisar los campos del formulario...</div>
                    @csrf
                    @method('PUT')
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
                                    <label class="col-form-label col-form-label-sm" for="order_business_edit">Orden del cliente:</label>
                                    <input type="text" class="form-control form-control-sm bg-white" name="order_business" id="order_business_edit" placeholder="Ingrese orden" readonly>
                                </div>
                                <div class="mb-3 col-12 col-md-6 col-lg-6">
                                    <label class="col-form-label col-form-label-sm" for="business_edit">Cliente:</label>
                                    <input type="text" class="form-control form-control-sm bg-white" name="business" id="business_edit" placeholder="Ingrese orden" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-12 col-md-6 col-lg-6">
                                    <label class="col-form-label col-form-label-sm" for="delivery_place_edit">Lugar de entrega:</label>
                                    <input type="text" class="form-control form-control-sm bg-white" name="delivery_place" id="delivery_place_edit" placeholder="Ingrese lugar entrega" readonly>
                                </div>
                                <div class="mb-3 col-12 col-md-6 col-lg-6">
                                    <label class="col-form-label col-form-label-sm" for="expected_date_edit">Fecha entrega:</label>
                                    <input type="text" class="form-control form-control-sm bg-white" name="expected_date" id="expected_date_edit" placeholder="Ingrese fecha entrega" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-12">
                            <input type="hidden" id="id">
                            <label class="col-form-label col-form-label-sm" for="name">Proyecto:</label>
                            <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Ingrese un nombre" required>
                            <small style="font-size:12.5px" id="name-error"></small>
                        </div>
                        <div class="mb-3 col-12">
                            <input type="hidden" id="id">
                            <label class="col-form-label col-form-label-sm" for="summary">Resumen:</label>
                            <textarea class="form-control form-control-sm" name="summary" id="summary" cols="20" rows="1" maxlength="120" placeholder="Por favor ingrese un resumen del proyecto"></textarea>
                            <small style="font-size:12.5px" id="summary-error"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3 col-12 col-md-6 col-lg-2">
                            <label class="col-form-label col-form-label-sm" for="long">Medida Largo "</label>
                            <input type="text" class="form-control form-control-sm" name="long" id="long" placeholder="Ingrese su medida" required>
                            <small style="font-size:12.5px" id="long-error"></small>
                        </div>
                        <div class="col mb-3 col-12 col-md-6 col-lg-2">
                            <label class="col-form-label col-form-label-sm" for="width">Medida Ancho "</label>
                            <input type="text" class="form-control form-control-sm" name="width" id="width" placeholder="Ingrese su medida" required>
                            <small style="font-size:12.5px" id="width-error"></small>
                        </div>
                        <div class="col mb-3 col-12 col-md-6 col-lg-2">
                            <label for="thickness" class="col-form-label col-form-label-sm">Medida Espesor "</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="thickness" class="form-control form-control-sm" id="thickness" placeholder="Ingrese su medida" required>
                                <small style="font-size:12.5px" id="thickness-error"></small>
                            </div>
                        </div>
                        <div class="col mb-3 col-12 col-md-6 col-lg-2">
                            <label class="col-form-label col-form-label-sm" for="rows">Filas:</label>
                            <input type="number" class="form-control form-control-sm" name="rows" id="rows" min="1" pattern="^[0-9]+" placeholder="Ingrese cantidad filas" required>
                            <small style="font-size:12.5px" id="rows-error"></small>
                        </div>
                        <div class="col mb-3 col-12 col-md-6 col-lg-2">
                            <label for="tube" class="col-form-label col-form-label-sm">Tubo:</label>
                            <div class="input-group input-group-sm">
                                <select class="form-control form-control-sm" id="tube" name="tube" required>
                                    <option value="" selected>Seleccionar...</option>
                                    <option value="3/8">3/8</option>
                                </select>
                                <span class="input-group-text fw-bold">ø</span>
                                <small style="font-size:12.5px" id="tube-error"></small>
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-md-6 col-lg-2">
                            <label class="col-form-label col-form-label-sm" for="status">Estado:</label>
                            <select class="form-control form-control-sm" name="status" id="status">
                                <option value="">Seleccionar...</option>
                                <option value="1">Por Planificar</option>
                                <option value="2">En Proceso</option>
                                <option value="3">Finalizado</option>
                            </select>
                            <small style="font-size:12.5px" id="status-error"></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3 col-12 col-md-6 col-lg-3">
                            <label class="col-form-label col-form-label-sm" for="start_date_p">Fecha Inicio Planificado:</label>
                            <input type="date" class="form-control form-control-sm" name="start_date_p" id="start_date_p" placeholder="Ingrese fecha inicio" required>
                            <small style="font-size:12.5px" id="start_date_p-error"></small>
                        </div>
                        <div class="col mb-3 col-12 col-md-6 col-lg-3">
                            <label class="col-form-label col-form-label-sm" for="expected_date_p">Fecha Fin Planificado:</label>
                            <input type="date" class="form-control form-control-sm" name="expected_date_p" id="expected_date_p" placeholder="Ingrese fecha prevista" required>
                            <small style="font-size:12.5px" id="expected_date_p-error"></small>
                        </div>
                        <div class="mb-3 col-12 col-md-6 col-lg-3">
                            <label class="col-form-label col-form-label-sm" for="end_date_p">Fecha Fin Real:</label>
                            <input type="date" class="form-control form-control-sm bg-secondary" name="end_date_p" id="end_date_p" placeholder="Ingrese fecha finalizacion" readonly>
                        </div>
                    </div>
                </form>
                <div id="PageLoadProgress" class="mb-2 p-2" style="display:none;margin:0 auto;width:120px;border:#014c8d 1px solid;background-color:#eeeeee"><img src="{{asset('images/gif/Progress-circle.gif')}}" alt="Progress"><span class="ml-1" style="color: #0069A5;font-size:12.5px">Cargando...</span></div>
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
                            <tbody class="text-sm" id="list-activities-edit">
                                <tr id="nodataActivityedit">
                                    <td colspan="12">No hay datos ingresados...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" onclick="removeDataProjectEdit()"><i class="fas fa-sign-out-alt"></i> Cancelar</button>
                <button type="button" class="btn btn-sm text-white" style="background-color:#3a3b49" id="btn-edit-project" onclick="update_project()"><i class="fas fa-check-circle text-white"></i> Actualizar</button>
            </div>
        </div>
    </div>
</div>