        <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="my-3 col-md-12">
                <div class="container">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" id="tituloPagina"><strong>Matriz Comisiones</strong></h3>
                            <div class="card-options">
                            </div>
                        </div>
                        <div id="listadoDatos" class="card-body">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-4">
                                    <a href="<?php echo base_url('Comisiones/excelComisionesPlanificadas')?>" class="btn btn-primary btn-block" type="button" >
                                        Comisiones Planificadas
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="<?php echo base_url('Comisiones/excelComisionesCumplidas')?>" class="btn btn-primary btn-block">
                                        Comisiones Cumplidas
                                    </a>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="row" style="margin-top:15px">
                                <div class="col-md-2"></div>
                                <div class="col-md-4">
                                    <a href="<?php echo base_url('assets/reports/consolidadoEquipos.xlsx')?>" class="btn btn-primary btn-block" type="button" download>
                                        Consolidado Equipos
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="<?php echo base_url('assets/reports/consolidadoEstaciones.xlsx')?>" class="btn btn-primary btn-block" download>
                                        Consolidado Estaciones
                                    </a>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="row" style="margin-top:15px">
                                <div class="col-md-3"></div>
                                <div class="col-md-6">
                                    <a href="<?php echo base_url('assets/reports/analisisDatos.xlsx')?>" class="btn btn-primary btn-block" download>
                                        Analisis de Datos
                                    </a>
                                </div>
                                <div class="col-md-3"></div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3"></div>
        </div>
    </div>
</div>
