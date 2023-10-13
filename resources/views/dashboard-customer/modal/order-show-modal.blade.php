<div class="modal fade" aria-hidden="true" id="customer-show-modal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#80c2e4">
                <h5 class="modal-title" style="color:#162056">Resultados Orden <span style="color:#fff" id="order_business"></span></h5>
            </div>
            <div class="modal-body" style="font-size:12px">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6 mb-3">
                        <div class="fw-bold" style="color:#162056">Medidas del radiador:</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12 col-md-6 col-lg-2">
                            <span class="fw-bold" style="color:#162056">Ancho: <span style="color:#4d627b" id="long"></span></span>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2">
                            <span class="fw-bold" style="color:#162056">Largo: <span style="color:#4d627b" id="width"></span></span>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2">
                            <span class="fw-bold" style="color:#162056">Espesor: <span style="color:#4d627b" id="thickness"></span></span>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2">
                            <span class="fw-bold" style="color:#162056">Filas: <span style="color:#4d627b" id="rows"></span></span>
                        </div>
                        <div class="col-12 col-md-6 col-lg-2">
                            <span class="fw-bold" style="color:#162056">Tubo: <span style="color:#4d627b" id="tube"></span></span>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12 col-md-6 col-lg-3">
                        <span class="fw-bold" style="color:#162056">Fecha solicitada: <br><span style="color:#4d627b" id="expected_date"></span></span>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <span class="fw-bold" style="color:#162056">Fecha entrega real: <br><span style="color:#4d627b" id="end_date"></span></span>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <span class="fw-bold" style="color:#162056">Lugar de entrega: <br><span style="color:#4d627b" id="delivery_place"></span></span>
                    </div>
                    <div class="col-12 col-md-6 col-lg-2">
                        <span class="fw-bold" style="color:#162056">Teléfono: <br><span style="color:#4d627b" id="phone"></span></span>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12 col-md-6 col-lg-3">
                        <span class="fw-bold" style="color:#162056">Proyecto: <br><div style="color:#4d627b" id="name"></div></span>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <span class="fw-bold" style="color:#162056">Estado: <br><span style="color:#4d627b" id="status"></span></span>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <span class="fw-bold progress-description" style="color:#162056">Completado: <span style="color:#4d627b"></span></span>
                        <div class="progress mt-2" style="width:100%">
                            <div class="progress-bar progress-bar-striped progress-bar-animated progress-project" id="progress"></div>
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-12 col-md-4" style="font-size:12px">
                        <div class="row mb-3">
                            <div class="fw-bold mt-3" style="color:#162056">Leyenda:</div>
                        </div>
                        <ul id="timeline-3">
                            <li class="fw-bold" id="li-planificar" style="color:#4d627b">
                                <span>Registrado</span>
                                <span class="float-end" id="planificar"></span>
                            </li>
                            <li class="fw-bold" id="li-proceso" style="color:#4d627b">
                                <span>En Proceso</span>
                                <span class="float-end" id="proceso"></span>
                            </li>
                            <li class="fw-bold" id="li-finalizado" style="color:#4d627b">
                                <span>Completado</span>
                                <span class="float-end" id="finalizado"></span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="row mb-3">
                            <div class="fw-bold mt-3 texto text-center" style="color:#162056"></div>
                        </div>
                        <div class="text-center">
                            <img src="" width="35%" class="img-fluid img-thumbnail image-radiador" alt="Radiador culminado">
                        </div>
                    </div>
                </div>
                <div id="PageLoadProgress" class="p-2 mt-2" style="margin:0 auto;width:120px;border:#014c8d 1px solid;background-color:#eeeeee"><img src="{{asset('images/gif/Progress-circle.gif')}}" alt="Progress"><span class="ml-1" style="color: #0069A5;font-size:12.5px">Cargando...</span></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm text-white" style="background-color:#3a3b49" data-bs-dismiss="modal"><i class="fas fa-sign-out-alt"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
<style>
    ul#timeline-3 {
        list-style-type: none;
        position: relative;
    }

    #timeline-3:before {
        content: " ";
        background: #d4d9df;
        display: inline-block;
        position: absolute;
        left: 29px;
        width: 2px;
        height: 100%;
        z-index: 400;
    }

    #timeline-3>li {
        margin: 20px 0;
        padding-left: 20px;
    }

    #timeline-3>#li-planificar:before {
        content: " ";
        background: #6c757d;
        display: inline-block;
        position: absolute;
        border-radius: 50%;
        border: 3px solid #fff;
        left: 20px;
        width: 20px;
        height: 20px;
        z-index: 400;
    }

    #timeline-3>#li-proceso:before {
        content: " ";
        background: #ffc107;
        display: inline-block;
        position: absolute;
        border-radius: 50%;
        border: 3px solid #fff;
        left: 20px;
        width: 20px;
        height: 20px;
        z-index: 400;
    }

    #timeline-3>#li-finalizado:before {
        content: " ";
        background: #28a745;
        display: inline-block;
        position: absolute;
        border-radius: 50%;
        border: 3px solid #fff;
        left: 20px;
        width: 20px;
        height: 20px;
        z-index: 400;
    }
</style>