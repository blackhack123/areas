        <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="my-3 col-md-12">
                <div class="container">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" id="tituloPagina"><strong>Reporte Personal</strong></h3>
                            <div class="card-options">
                            </div>
                        </div>
                        <div id="listadoDatos" class="card-body">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-4">
                                    <a href="<?php echo base_url('Personales/excelPersonal'); ?>" class="btn btn-primary btn-block" type="button" >
                                        Listado General
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="javascript:void(0);" class="btn btn-primary btn-block" type="button" data-toggle="modal" data-target="#modalPersonal">
                                        Listado por Tipo
                                    </a>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="row" style="margin-top:15px">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <a href="javascript:void(0);" class="btn btn-primary btn-block" type="button" data-toggle="modal" data-target="#modalFichaPersonal">
                                        Generar Ficha Personal
                                    </a>
                                </div>
                                <div class="col-md-2"></div>
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



<!-- Modal Personal-->
<div class="modal fade" id="modalPersonal" tabindex="-1" role="dialog" aria-labelledby="modalPersonal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form action="<?php echo base_url('Personales/excelPersonalPorTipo'); ?>" method="post" id="formPersonal">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPersonal">Reporte Personal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="sector"><strong>Tipo Personal:</strong> </label>
            <select class="form-control" id="tipoFuerza" name="tipoFuerza" required>
                <option selected disabled>Seleccione</option>
                <?php
                foreach ($listaTipoFuerza as $tipoFuerza) {
                ?>
                    <option value="<?=$tipoFuerza->idTipoFuerza?>"><?=$tipoFuerza->nombreTipoFuerza?></option>
                <?php
                }
                ?>
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="btnPersonal">Generar Reporte</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal GenerarFicha-->
<div class="modal fade" id="modalFichaPersonal" tabindex="-1" role="dialog" aria-labelledby="modalFichaPersonal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form action="<?php echo base_url('Personales/excelPersonalPorTipo'); ?>" method="post" id="formFichaPersonal">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPersonal">Generar Ficha Personal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="sector"><strong>Personal:</strong> </label>
            <select class="form-control" id="personal" name="personal" required>
                <option selected disabled>Seleccione</option>
                <?php
                foreach ($listaPersonal as $persona) {
                    $p = $persona->abreviaturaGrado." ".$persona->nombrePersonal." ".$persona->apellidoPersonal;
                ?>
                    <option value="<?=$persona->idPersonal?>"><?=$p?></option>
                <?php
                }
                ?>
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="btnFichaPersonal">Generar Ficha</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      </div>
      </form>
    </div>
  </div>
</div>