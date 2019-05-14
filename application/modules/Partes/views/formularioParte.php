              <div class="row">
                

                <div class="form-group col-sm-5">
                  <label class="form-label">CAE: </label>
                  <select name="idCae" id="idCae" class="form-control" onchange="buscarPersonalCae(this);buscarSectoresCae(this);">
                    <option value="">SELECCIONE...</option>
                    <?php foreach ($cae as $dt){ ?>
                    <option value="<?php echo $dt->idCae; ?>"><?php echo $dt->nombreCae; ?></option>
                    <?php } ?>            
                  </select>
                </div>                  

                <div class="form-group col-sm-5">
                  <label class="form-label">SECTOR: </label>
                  <select name="idSector" id="idSector" class="form-control" onchange="buscarEstacionesSector(this);">
                  </select>
                </div>                  

                <div class="form-group col-sm-2">
                  <label class="form-label">Fecha: </label>
                  <input type="text" name="fechaParte" id="fechaParte" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                </div>  

              
              </div>
              
               <div class="row">

                <div class="form-group col-sm-12">
                  <label class="form-label">ESTACIÓN: </label>
                  <select name="idEstacion" id="idEstacion" class="form-control" onchange="buscarTiposExistenciasEstacion(this);">
                  </select>
                </div>      

              </div>

              <div class="row">

                <div class="form-group col-sm-10">
                  <label class="form-label">Equipos: </label>
                  <select class="form-control" name="idTipoExistencia" id="idTipoExistencia"></select>
                </div>

                <div class="form-group col-sm-2">
                  <label class="form-label">Acción: </label>
                  <button type="button" class="btn btn-success" onclick="gestionRegistroParte();">Crear Parte</button>
                </div>  


              </div>
