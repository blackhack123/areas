        <div class="my-3 my-md-5">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" id="tituloPagina"><strong>Reporte CAES</strong></h3>
                        <div class="card-options">
                        </div>
                    </div>
                    <div id="listadoDatos" class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <a href="<?php echo base_url('Caes/exportarExcel'); ?>" class="btn btn-primary btn-block">
                                    Listado CAES
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="<?php echo base_url('Caes/excelSecciones'); ?>" class="btn btn-primary btn-block">
                                    Listado Secciones
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="javascript:void(0);" class="btn btn-primary btn-block" type="button" data-toggle="modal" data-target="#modalEstaciones">
                                    Listado Estaciones
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal Estaciones-->
<div class="modal fade" id="modalEstaciones" tabindex="-1" role="dialog" aria-labelledby="modalEstaciones" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form action="<?php echo base_url('Caes/excelEstaciones'); ?>" method="post" id="formEstaciones">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEstaciones">Reporte Estaciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="sector"><strong>Sector:</strong> </label>
            <select class="form-control" id="sector" name="sector" required>
                <option selected disabled>Seleccione</option>
                <?php
                foreach ($listaSectores as $sector) {
                ?>
                    <option value="<?=$sector->idSector?>"><?=$sector->nombreSector?></option>
                <?php
                }
                ?>
            </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="btnEstaciones">Generar Reporte</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      </div>
      </form>
    </div>
  </div>
</div>


<script>
/*
$("#btnEstaciones").click(function(){
    $estacion = $("#modalEstaciones #sector").val();
    if($estacion == '' || $estacion == null){
        alert('Seleccione un Sector..!!');
        return false;
    }
    $('#formEstaciones').submit();
});*/
</script>