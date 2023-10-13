<div class="modal fade" aria-hidden="true" id="user-password-modal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgb(33,136,201);">
                <h5 class="modal-title" style="color:#fff" id="exampleModalLabel">Actualizar password de usuario</h5>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <input type="hidden" id="user_id_pass">
                        <div class="col mb-3 col-12">
                            <label for="email" class="col-form-label col-form-label-sm">Email:</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <div class="input-group-text style-icon-fas">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                                <input type="email" name="email" id="user_email_pass" class="form-control style-input form-control-sm bg-white" placeholder="Ingresar su email" readonly>
                            </div>                            
                        </div>
                        <div class="col mb-3 col-12">
                            <label for="user_password" class="col-form-label col-form-label-sm">Password:</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <div class="input-group-text style-icon-fas">
                                        <i class="fas fa-key"></i>
                                    </div>
                                </div>
                                <input type="password" name="user_password" id="user_password" class="form-control style-input form-control-sm bg" placeholder="Ingrese el nuevo password" required>
                            </div>
                            <small style="font-size:12.5px" id="user_password-error"></small>
                        </div>
                    </div>
                </form>
                <div id="PageLoadProgressPass" class="p-2" style="display:none;margin:0 auto;width:120px;border:#014c8d 1px solid;background-color:#eeeeee"><img src="{{asset('images/gif/Progress-circle.gif')}}" alt="Progress"><span class="ml-1" style="color: #0069A5;font-size:12.5px">Cargando...</span></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" onclick="user_password_clear()"><i class="fas fa-sign-out-alt"></i> Cancelar</button>
                <button type="button" class="btn btn-sm text-white" style="background-color:#3a3b49" id="btn-pass-user" onclick="update_password_user()"><i class="fas fa-check-circle text-white"></i> Actualizar</button>
            </div>
        </div>
    </div>
</div>