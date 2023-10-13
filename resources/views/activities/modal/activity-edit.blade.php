<div class="modal fade" aria-hidden="true" id="activity-edit-modal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgb(33,136,201);">
                <h5 class="modal-title" style="color:#fff" id="exampleModalLabel">Editar Actividad de Fabricación</h5>
            </div>
            <div class="modal-body">
                <form class="formModal" id="formContentAct" action="" method="post">
                    <div id="alert-validacion-edit" class="alert alert-info d-none">La actividad no pudo ser actualizada, favor de revisar los campos del formulario...</div>
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col mb-3 col-12">
                            <input type="hidden" id="id_edit">
                            <label for="name_edit" class="col-form-label col-form-label-sm">Nombre:</label>
                            <input type="text" name="name_edit" id="name_edit" class="form-control form-control-sm" placeholder="Por favor ingresar una descripción">
                            <small style="font-size:12.5px" id="name_edit-error"></small>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="col-form-label col-form-label-sm" for="stage_id_edit">Etapa:</label>
                            <select class="form-control form-control-sm" name="stage_id_edit" id="stage_id_edit">
                                <option value="">Seleccionar...</option>
                                @foreach($stages as $stage)
                                <option value="{{$stage->id}}">{{$stage->name}}</option>
                                @endforeach
                            </select>
                            <small style="font-size:12.5px" id="stage_id_edit-error"></small>
                        </div>
                    </div>
                </form>
                <div id="PageLoadProgressedit" class="p-2" style="display:none;margin:0 auto;width:120px;border:#014c8d 1px solid;background-color:#eeeeee"><img src="{{asset('images/gif/Progress-circle.gif')}}" alt="Progress"><span class="ml-1" style="color: #0069A5;font-size:12.5px">Cargando...</span></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" onclick="removeDataEditActivity()"><i class="fas fa-sign-out-alt"></i> Cancelar</button>
                <button type="button" class="btn btn-sm text-white" style="background-color:#3a3b49" id="btn-edit-activity" onclick="update_activity()"><i class="fas fa-check-circle text-white"></i> Actualizar</button>
            </div>
        </div>
    </div>
</div>