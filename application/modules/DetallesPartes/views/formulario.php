              <div class="row">

                <div class="form-group col-sm-2">
                  <label class="form-label">SECTOR: </label>
                  <select name="idSector" id="idSector" class="form-control" onchange="buscarEstacionesSector(this);">
                  </select>
                </div>                  

                <div class="form-group col-sm-10">
                  <label class="form-label">ESTACIÓN: </label>
                  <select name="idEstacion" id="idEstacion" class="form-control" onchange="buscarTiposExistenciasEstacion(this);">
                  </select>
                </div>      

              </div>

               <div class="row">

              </div>

              <div class="row">

                <div class="form-group col-sm-10">
                  <label class="form-label">Equipos: </label>
                  <select class="form-control" name="idTipoExistencia" id="idTipoExistencia"></select>
                </div>

                <div class="form-group col-sm-2">
                  <label class="form-label">Acción: </label>
                  <button type="button" class="btn btn-success" onclick="gestionRegistroDetalleParte(this);" data-accion="insertarRegistro">Crear Parte</button>
                </div>  
              </div>              

<script type="text/javascript">
  buscarPersonalCae($("#idCae").val());
  buscarSectoresCae($("#idCae").val());
  $("#idParteDetalleParte").val("<?php echo $idParte; ?>");
</script>              