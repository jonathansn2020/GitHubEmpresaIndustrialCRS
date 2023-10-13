<div class="modal fade" aria-hidden="true" id="user-create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgb(33,136,201);">
                <h5 class="modal-title" style="color:#fff" id="exampleModalLabel">Crear nuevo usuario</h5>
            </div>
            <div class="modal-body">
                <form action="" method="post">                    
                    @csrf
                    <div class="row">
                        <div class="col mb-3 col-12">
                            <label for="name" class="col-form-label col-form-label-sm">Nombre:</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <div class="input-group-text style-icon-fas">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <input type="text" name="name" id="name" class="form-control style-input form-control-sm bg" placeholder="Ingresar su nombre" required>
                            </div>
                            <small style="font-size:12.5px" id="name-error"></small>
                        </div>                        
                        <div class="col mb-3 col-12">
                            <label for="email" class="col-form-label col-form-label-sm">Email:</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <div class="input-group-text style-icon-fas">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                </div>
                                <input type="email" name="email" id="email" class="form-control style-input form-control-sm bg" placeholder="Ingresar su email" required>
                            </div>
                            <small style="font-size:12.5px" id="email-error"></small>
                        </div>
                        <div class="col mb-3 col-12">
                            <label for="password" class="col-form-label col-form-label-sm">Password:</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <div class="input-group-text style-icon-fas">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                </div>
                                <input type="password" name="password" id="password" class="form-control style-input form-control-sm bg" placeholder="Ingresar su password" required>
                            </div>
                            <small style="font-size:12.5px" id="password-error"></small>
                        </div>
                        <div class="col mb-3 col-12">
                            <label for="password_confirmation" class="col-form-label col-form-label-sm">Confirmar Password:</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <div class="input-group-text style-icon-fas">
                                        <i class="fas fa-key"></i>
                                    </div>
                                </div>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control style-input form-control-sm bg" placeholder="Confirmar el password" required>
                            </div>
                        </div>   
                        <div class="col mb-3 col-12">
                            <label for="profile_photo_path" class="col-form-label col-form-label-sm">Subir imagen:</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <div class="input-group-text style-icon-fas">
                                        <i class="fas fa-image"></i>
                                    </div>
                                </div>
                                <input type="file" name="profile_photo_path" id="profile_photo_path" class="form-control form-control-sm" accept="image/*">
                            </div>
                            <small style="font-size:12.5px" id="profile_photo_path-error"></small>
                            
                        </div>                     
                    </div>
                </form>
                <div id="PageLoadProgress" class="p-2" style="display:none;margin:0 auto;width:120px;border:#014c8d 1px solid;background-color:#eeeeee"><img src="{{asset('images/gif/Progress-circle.gif')}}" alt="Progress"><span class="ml-1" style="color: #0069A5;font-size:12.5px">Cargando...</span></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" onclick="user_create_clear()"><i class="fas fa-sign-out-alt"></i> Cancelar</button>
                <button type="button" class="btn btn-sm text-white" style="background-color:#3a3b49" id="btn-add-user" onclick="add_user()"><i class="fas fa-check-circle text-white"></i> Agregar</button>
            </div>
        </div>
    </div>
</div>