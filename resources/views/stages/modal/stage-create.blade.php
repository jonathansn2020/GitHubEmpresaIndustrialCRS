<div class="modal fade" aria-hidden="true" id="stage-create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgb(33,136,201);">
                <h5 class="modal-title" style="color:#fff" id="exampleModalLabel">Nueva Etapa de Fabricación</h5>
            </div>
            <div class="modal-body">
                <form class="formModal" id="formContentAct" action="" method="post">
                    <div id="alert-validacion" class="alert alert-info d-none">La etapa no pudo ser registrada, favor de revisar los campos del formulario...</div>
                    @csrf
                    <div class="row">
                        <div class="col mb-3 col-12">
                            <label for="name" class="col-form-label col-form-label-sm">Nombre:</label>
                            <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Por favor ingresar una descripción">
                            <small style="font-size:12.5px" id="name-error"></small>
                        </div>                        
                    </div>
                </form>
                <div id="PageLoadProgress" class="p-2" style="display:none;margin:0 auto;width:120px;border:#014c8d 1px solid;background-color:#eeeeee"><img src="{{asset('images/gif/Progress-circle.gif')}}" alt="Progress"><span class="ml-1" style="color: #0069A5;font-size:12.5px">Cargando...</span></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" onclick="removeDataStage()"><i class="fas fa-sign-out-alt"></i> Cancelar</button>
                <button type="button" class="btn btn-sm text-white" style="background-color:#3a3b49" id="btn-add-stage" onclick="add_stage()"><i class="fas fa-check-circle text-white"></i> Agregar</button>
            </div>
        </div>
    </div>
</div>