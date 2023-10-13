<div class="modal fade" aria-hidden="true" id="activity-comment-modal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgb(204,204,204);">
                <h5 class="modal-title text-dark" id="exampleModalLabel">Detalles de trabajo</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-9">
                        <form action="" id="" action="" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-12 card-body table-responsive col-form-label col-form-label-sm">
                                    <table id="" class="table table-bordered table-hover text-center" width="100%">
                                        <thead style="background-color: rgb(33,136,201);">
                                            <tr style="font-size:11px" class="text-white">
                                                <th>Notas</th>
                                                <th>Archivos</th>
                                                <th>Fecha de envio</th>
                                                <th>Remitente</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-sm" id="list-comments">
                                            <tr id="nodataComent">
                                                <td colspan="11">No hay comentarios ingresados...</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <span class="col-form-label col-form-label-sm" id="info">Agregar información de trabajo:</span>
                                <div class="col-12">
                                    <input type="hidden" id="task-id">
                                    <input type="hidden" id="comment-id">
                                    <label class="col-form-label col-form-label-sm" for="comentario">Notas:</label>
                                    <textarea class="form-control form-control-sm" name="comentario" id="comentario" cols="20" rows="4" placeholder="Ingrese un comentario"></textarea>
                                    <small style="font-size:12.5px" id="comentario-error"></small>
                                </div>
                                <div class="col-12">
                                    <label class="col-form-label col-form-label-sm" for="adjunto">Adjunto <img src="{{asset('images/iconos/Folder.png')}}"></label>
                                    <input type="file" name="adjunto" class="form-control form-control-sm mb-2" id="adjunto">                                    
                                    <a href="" class="fw-bold text-success text-sm download" style="text-decoration:none;" download></a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                        <div class="mb-3 col-12">
                                <label style="font-size:12px" class="col-form-label col-form-label-sm" for="name-a">Actividad:</label>
                                <br><span style="font-size:12px" id="name-a"></span>
                            </div>
                            <div class="mb-3 col-12">
                                <label style="font-size:12px" class="col-form-label col-form-label-sm" for="stage_id-a">Etapa:</label>
                                <br><span style="font-size:12px" id="stage_id-a"></span>
                            </div>
                            <div class="mb-3 col-12">
                                <label style="font-size:12px" class="col-form-label col-form-label-sm" for="start-date-a">Fecha de inicio:</label>
                                <br><span style="font-size:12px" id="start-date-a"></span>
                            </div>
                            <div class="mb-3 col-12">
                                <label style="font-size:12px" class="col-form-label col-form-label-sm" for="expected_date-a">Fecha fin previsto:</label>
                                <br><span style="font-size:12px" id="expected_date-a"></span>
                            </div>
                            <div class="mb-3 col-12">
                                <label style="font-size:12px" class="col-form-label col-form-label-sm" for="true_start-a">Fecha inio real:</label>
                                <br><span style="font-size:12px" id="true_start-a"></span>
                            </div>
                            <div class="mb-3 col-12">
                                <label style="font-size:12px" class="col-form-label col-form-label-sm" for="end_date-a">Fecha fin real:</label>
                                <br><span style="font-size:12px" id="end_date-a"></span>
                            </div>
                            <div class="mb-3 col-12">
                                <label style="font-size:12px" class="col-form-label col-form-label-sm" for="status-a">Estado:</label>
                                <br><span style="font-size:12px" id="status-a"></span>
                            </div>                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" onclick="btn_limpiar_comment()"><i class="fas fa-sign-out-alt"></i> Cancelar</button>
                <button type="button" class="btn btn-sm text-white" style="background-color:#3a3b49" id="btn-comment-create" onclick="add_comentario()"><i class="fas fa-check-circle text-white"></i> Guardar</button>
                <button type="button" style="display:none" style="background-color:#3a3b49" class="btn btn-sm text-white" style="background-color:#3a3b49" id="btn-comment-update" onclick="update_comment()"><i class="fas fa-check-circle text-white"></i> Actualizar</button>
            </div>
        </div>
    </div>
</div>