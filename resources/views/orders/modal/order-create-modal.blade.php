<div class="modal fade" aria-hidden="true" id="project-modal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header" style="background-color: rgb(33,136,201);">
        <h5 class="modal-title" style="color:#fff" id="exampleModalLabel">Proyecto de Fabricación</h5>
      </div>
      <div class="modal-body">
        <form class="formModal" id="formContent" action="" method="post">
          <div id="alert-validacion" class="alert alert-info d-none">El proyecto no pudo ser registrado, favor de revisar los campos del formulario...</div>
          @csrf
          <div class="row">
            <div class="col mb-3 col-12">
              <label for="name" class="col-form-label col-form-label-sm">Proyecto:</label>
              <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Por favor ingresar una descripción">
              <small style="font-size:12.5px" id="name-error"></small>
            </div>
            <div class="mb-3 col-12">
              <label class="col-form-label col-form-label-sm" for="note">Resumen:</label>
              <textarea class="form-control form-control-sm" name="summary" id="summary" cols="20" rows="1" maxlength="120" placeholder="Por favor ingrese un resumen del proyecto"></textarea>
              <small style="font-size:12.5px" id="summary-error"></small>
            </div>
            <div class="col mb-3 col-12 col-md-6 col-lg-2">
              <label for="long" class="col-form-label col-form-label-sm">Medida Largo "</label>
              <input type="text" name="long" id="long" class="form-control form-control-sm" placeholder="Ingrese su medida" value="">
              <small style="font-size:12.5px" id="long-error"></small>
            </div>
            <div class="col mb-3 col-12 col-md-6 col-lg-2">
              <label for="width" class="col-form-label col-form-label-sm">Medida Ancho "</label>
              <input type="text" name="width" id="width" class="form-control form-control-sm" placeholder="Ingrese su medida" value="">
              <small style="font-size:12.5px" id="width-error"></small>
            </div>
            <div class="col mb-3 col-12 col-md-6 col-lg-2">
              <label for="thickness" class="col-form-label col-form-label-sm">Medida Espesor "</label>
              <input type="text" name="thickness" id="thickness" class="form-control form-control-sm" placeholder="Ingrese su medida" value="">
              <small style="font-size:12.5px" id="thickness-error"></small>
            </div>
            <div class="col mb-3 col-12 col-md-6 col-lg-2">
              <label for="rows" class="col-form-label col-form-label-sm">Filas:</label>
              <input type="number" name="rows" id="rows" min="1" pattern="^[0-9]+" class="form-control form-control-sm text-right" placeholder="0" value="">
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
            <div class="col mb-3 col-12 col-md-6 col-lg-2">
              <br><button type="button" class="btn btn-sm" onclick="removeDataProject()"><img class="img-fluid" style="height: 32px;" src="{{asset('images/iconos/borrador.png')}}" alt="clear"></button>
            </div>           
            <div class="col mb-3 col-12 col-md-6 col-lg-3">
              <label class="col-form-label col-form-label-sm" for="start_date_p">Fecha Inicio Planificada:</label>
              <input type="date" class="form-control form-control-sm" name="start_date_p" id="start_date_p" placeholder="Ingrese fecha inicio" required>
              <small style="font-size:12.5px" id="start_date_p-error"></small>
            </div>
            <div class="col mb-3 col-12 col-md-6 col-lg-3">
              <label class="col-form-label col-form-label-sm" for="expected_date_p">Fecha Fin Planificada:</label>
              <input type="date" class="form-control form-control-sm" name="expected_date_p" id="expected_date_p" placeholder="Ingrese fecha prevista" required>
              <small style="font-size:12.5px" id="expected_date_p-error"></small>
            </div>            
                     
          </div>          
        </form>
        <div id="PageLoadProgress" class="p-2" style="display:none;margin:0 auto;width:120px;border:#014c8d 1px solid;background-color:#eeeeee"><img src="{{asset('images/gif/Progress-circle.gif')}}" alt="Progress"><span class="ml-1" style="color: #0069A5;font-size:12.5px">Cargando...</span></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" onclick="removeDataProject()"><i class="fas fa-sign-out-alt"></i> Cancelar</button>
        <button type="button" class="btn btn-sm text-white" style="background-color:#3a3b49" id="btn-add-product" onclick="add_product_order()"><i class="fas fa-check-circle text-white"></i> Agregar</button>
      </div>
    </div>
  </div>
</div>