<div class="modal fade" aria-hidden="true" id="project-activities-modal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgb(33,136,201);">
                <h5 class="modal-title" style="color:#fff" id="exampleModalLabel">Planificar Proyecto de Fabricación</h5>
            </div>
            <div class="modal-body">
                <form action="" id="formContent" action="" method="post">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-12 col-md-4 col-lg-6">
                            <input type="hidden" id="project_id">
                            <label class="col-form-label col-form-label-sm" for="name_project">Proyecto:</label>
                            <input type="text" class="form-control form-control-sm bg-white" name="name_project" id="name_project" readonly placeholder="Nombre de producto">
                        </div>
                        <div class="mb-3 col-12 col-md-4 col-lg-3">
                            <input type="hidden" id="project_id">
                            <label class="col-form-label col-form-label-sm" for="start_date_p">Fecha Inicio Planificado:</label>
                            <input type="text" class="form-control form-control-sm bg-white" name="start_date_p" id="start_date_pp" readonly placeholder="Fecha inicio">
                        </div>
                        <div class="mb-3 col-12 col-md-4 col-lg-3">
                            <input type="hidden" id="project_id">
                            <label class="col-form-label col-form-label-sm" for="expected_date_p">Fecha Fin Planificado:</label>
                            <input type="text" class="form-control form-control-sm bg-white" name="expected_date_p" id="expected_date_pp" readonly placeholder="Fin previsto">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-secondary">
                                    <h1 class="card-title">Añadir actividad</h1>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-12 col-md-6 col-lg-6">
                                            <label class="col-form-label col-form-label-sm" for="name_activity">Nombre:</label>
                                            <input type="text" class="form-control form-control-sm bg-white" name="name_activity" id="name_activity" placeholder="Ingrese descripción" required>
                                            <small style="font-size:12.5px" id="name_activity-error"></small>
                                        </div>
                                        <div class="mb-3 col-12 col-md-6 col-lg-2">
                                            <label class="col-form-label col-form-label-sm" for="priority">Prioridad:</label>
                                            <select class="form-control form-control-sm" name="priority" id="priority">
                                                <option value="">Seleccionar...</option>
                                                <option value="Alta">Alta</option>
                                                <option value="Media">Media</option>
                                                <option value="Baja">Baja</option>
                                            </select>
                                            <small style="font-size:12.5px" id="priority-error"></small>
                                        </div>
                                        <div class="mb-3 col-12 col-md-6 col-lg-2">
                                            <label class="col-form-label col-form-label-sm" for="start_date">Inicio Planificado:</label>
                                            <input type="date" class="form-control form-control-sm" name="start_date" id="start_date" required>
                                            <small style="font-size:12.5px" id="start_date-error"></small>
                                        </div>
                                        <div class="mb-3 col-12 col-md-6 col-lg-2">
                                            <label class="col-form-label col-form-label-sm" for="expected_date">Fin Planificado:</label>
                                            <input type="date" class="form-control form-control-sm" name="expected_date" id="expected_date" required>
                                            <small style="font-size:12.5px" id="expected_date-error"></small>
                                        </div>
                                    </div>                                    
                                    <div class="row">
                                        <div class="mb-3 col-12 col-md-6 col-lg-6">
                                            <label class="col-form-label col-form-label-sm" for="stage-id">Etapa Fabricación:</label>
                                            <select class="form-control form-control-sm" name="stage_id" id="stage_id">
                                                <option value="">Seleccionar...</option>
                                                @foreach($stages as $stage)
                                                <option value="{{$stage->id}}">{{$stage->name}}</option>
                                                @endforeach
                                            </select>
                                            <small style="font-size:12.5px" id="stage_id-error"></small>
                                        </div>
                                        <div class="mb-3 col-12 col-md-6 col-lg-3">
                                            <label class="col-form-label col-form-label-sm" for="operator_id">Operario:</label>
                                            <select class="form-control form-control-sm bg-white" name="operator_id" id="operator_id">
                                            <option value="">Seleccionar...</option>
                                                @foreach($operators as $operator)
                                                <option value="{{$operator->id}}">{{$operator->name}}</option>
                                                @endforeach
                                            </select>
                                            <small style="font-size:12.5px" id="operator_id-error"></small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm btn-tool" data-card-widget="collapse" onclick="removeDataActivity()"><i class="fas fa-sign-out-alt"></i> Cancelar</button>
                                            <button type="button" class="btn btn-sm text-white" style="background-color:#3a3b49" id="btn-add-activity" onclick="add_one_activity()"><i class="fas fa-check-circle text-white"></i> Agregar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="PageLoadProgresAct" class="p-2 mb-2" style="display:none;margin:0 auto;width:120px;border:#014c8d 1px solid;background-color:#eeeeee"><img src="{{asset('images/gif/Progress-circle.gif')}}" alt="Progress"><span class="ml-1" style="color: #0069A5;font-size:12.5px">Cargando...</span></div>
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
                                        <th class="align-middle text-sm" scope="col">Operario</th>
                                        <th class="align-middle text-sm bg-danger" scope="col"><i class="fas fa-trash-alt"></th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm" id="list-activities">
                                    <tr id="nodataActivity">
                                        <td colspan="12">No hay datos ingresados...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" onclick="limpiar()"><i class="fas fa-sign-out-alt"></i> Cancelar</button>
                <button type="button" class="btn btn-sm text-white" style="background-color:#3a3b49" id="btn-add-activity" onclick="store_activities()"><i class="fas fa-check-circle text-white"></i> Agregar</button>
            </div>
        </div>
    </div>
</div>