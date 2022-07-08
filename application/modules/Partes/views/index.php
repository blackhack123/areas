<script type="text/javascript">
  $("#<?php echo $codigoCategoriaMenu; ?>").addClass('active');
  $("#<?php echo $codigoMenu; ?>").addClass('active');
</script>

    <div class="row" style="margin-top:15px">
      <div class="col-md-1"></div>
      <div class="col-md-10" style="background-color:white">
      
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="myTab" role="tablist" >

          <li class="nav-item">
            <a class="nav-link active" id="listado-tab" data-toggle="tab" href="#listado" role="tab" aria-controls="listado" aria-selected="false">Partes Diarios</a>
          </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active" id="listado" role="tabpanel" aria-labelledby="listado-tab">

          <?php 
            if ($this->session->userdata("idPerfil") == '3'){
          ?>
            <div class="row" style="margin-top:15px;margin-bottom:15px">
              <div class="col-md-2">
                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalParte">
                  Generar Parte 
                </button>
              </div>
              <div class="col-md-2">
                <button type="button" class="btn btn-success btn-block" onclick="enviarPendientes();">
                  Enviar Pendientes
                </button>
              </div>
            </div>
          <?php }?>
          <?php 
            if ($this->session->userdata("idPerfil") == '3' or $this->session->userdata("idPerfil") == '1'){
          ?>
            <div class="row" style="margin-top:15px;margin-bottom:15px">
              <div class="col-md-12">
                <table id="tablaPartesListado" class="table table-bordered table-striped">
                  <thead>
                    <tr style="text-align:center;">
                      <th width="5%">N</th>
                      <th width="5%">Fecha</th>
                      <th width="5%">Cae</th>
                      <th width="5%">Tipo</th>
                      <th width="5%">Caracteristica</th>
                      <th width="5%">Novedad</th>
                      <th width="5%">Requerimiento</th>
                      <th width="5%">Supervisor</th>
                      <th width="5%">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    if(count($partes) > 0){
                      $i=1;
                      foreach($partes as $p){
                        
                        echo "<tr >";
                        echo "<td>".$i++;"</td>";
                        echo "<td>".$p->fecha_fallo."</td>";
                        echo "<td>".$p->cae."</td>";
                        echo "<td>".$p->tipo_existencia."</td>";
                        echo "<td>".$p->propiedad."</td>";
                        echo '<td style="text-align:center;"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#mostrarDetalle" data-whatever="'.$p->novedad.'">Consultar</button></td>';
                        echo '<td style="text-align:center;"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#mostrarDetalle" data-whatever="'.$p->requerimiento.'">Consultar</button></td>';
                        //recibido x supervisor enviado x guardi
                        if($p->supervisor == 1 and $this->session->userdata("idPerfil") == '3'){
                          echo "<td style='text-align:center;'><span class='badge bg-green'>Recibido</span></td>";
                        //pendiente de envio x guardia
                        }elseif($p->supervisor == 0 and $this->session->userdata("idPerfil") == '3'){
                          echo "<td style='text-align:center;'><span class='badge bg-orange'>Pendiente</span></td>";
                        //pendiente gestionar supervisor
                        }elseif($p->supervisor == 1 and $this->session->userdata("idPerfil") == '1' and $p->gestion_supervisor == 0){
                          $var = '"'.$p->id.'"'.','.'"'.$p->fecha_fallo.'"';
                          echo "<td style='text-align:center;'><a href='javascript:void(0);' onclick='gestionSupervisor(".$var.");' class='btn btn-sm btn-warning'>Gestionar</a></td>";
                        }elseif($p->supervisor == 1 and $this->session->userdata("idPerfil") == '1' and $p->gestion_supervisor == 1){
                          echo "<td style='text-align:center;'><span class='badge bg-green'>Resuelto</span></td>";
                        }elseif($p->supervisor == 0 and $this->session->userdata("idPerfil") == '1'){
                          echo "<td style='text-align:center;'><span class='badge bg-purple'>Pendiente</span></td>";
                        }
                        $link=base_url('Partes/visualizar?id='.$p->id);
                        $linkEditar = "eliminarParteDiario(".$p->id.");";
                        $linkOrdenTrabajo = "mostrarOrdenTrabajo(".$p->id.");";
                        $linkReporteOrdenPdf = base_url('Partes/visualizarOrdenTrabajo?idParte='.$p->id);
                        echo "<td style='text-align:center'><a href='".$link."' class='btn btn-danger btn-sm'>Parte PDF</a>";
                        if($p->ordenGenerada == 1){
                          echo "<br><br><a href='".$linkReporteOrdenPdf."' class='btn btn-danger btn-sm'>Orden PDF</a>";
                        }
                        if($p->estado == 'G' AND $p->es_solucionado != 'SI'){
                          echo "</br></br>";
                          if($p->supervisor != 1 and $this->session->userdata("idPerfil") == '3'){
                            echo "<a href='javascript:void(0);' onclick='".$linkEditar."' class='btn btn-warning btn-sm'>Eliminar</a>";
                          }
                        }
                        if($p->ordenTrabajo == 'SI' and $this->session->userdata("idPerfil") == '1' and $p->ordenGenerada == 0){
                          echo "</br></br>";
                          echo "<a href='javascript:void(0);' onclick='".$linkOrdenTrabajo."' class='btn btn-warning btn-sm'>Crear Orden</a>";
                        }
                        echo "</td>";
                        echo "</tr>";
                      }//end foreach
                    }//end if
                  ?>
                  </tbody>
                </table>
                
              </div>
            </div>
          </div><!-- END LISTADO -->
          <?php }else{?>
            <div class="row" style="margin-top:15px;margin-bottom:15px">
              <div class="col-md-12">
                <table id="tablaPartesListado" class="table table-bordered table-striped">
                  <thead>
                    <tr style="text-align:center;">
                      <th width="5%">N</th>
                      <th width="5%">Fecha</th>
                      <th width="5%">Cae</th>
                      <th width="5%">Tipo</th>
                      <th width="5%">Caracteristica</th>
                      <th width="5%">Novedad</th>
                      <th width="5%">Requerimiento</th>
                      <th width="5%">Supervisor</th>
                      <th width="5%">Jefe</th>
                      <th width="5%">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  if(count($partes) > 0){
                    $i=1;
                    foreach($partes as $p){
                      echo "<tr >";
                      echo "<td>".$i++;"</td>";
                      echo "<td>".$p->fecha_fallo."</td>";
                      echo "<td>".$p->cae."</td>";
                      echo "<td>".$p->tipo_existencia."</td>";
                      echo "<td>".$p->propiedad."</td>";
                      echo '<td style="text-align:center;"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#mostrarDetalle" data-whatever="'.$p->novedad.'">Consultar</button></td>';
                      echo '<td style="text-align:center;"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#mostrarDetalle" data-whatever="'.$p->requerimiento.'">Consultar</button></td>';
                      if($p->gestion_supervisor == 1){
                        echo "<td  style='text-align:center;'><span class='badge bg-green'>Gestión Realizada</span></td>";
                      }else{
                        echo "<td  style='text-align:center;'><span class='badge bg-orange'>Pendiente</span></td>";
                      }

                      if($p->gestion_supervisor == 1 and $p->jefe == 1 and $p->ordenTrabajo == null){
                        echo '
                        <td  style="text-align:center;">
                          <a href="javascript:void(0);" class="btn btn-warning btn-sm" onclick="generarOrden('.$p->id.');">
                            Generar Orden
                          </a>
                        </td>';
                      }elseif($p->gestion_supervisor == 1 and $p->jefe == 1 and $p->ordenTrabajo == 'SI'){
                        echo "<td style='text-align:center;'><span class='badge bg-green'>Orden Generada</span></td>";
                      }else{
                        echo "<td style='text-align:center;'><span class='badge bg-orange'>Pendiente</span></td>";
                      }
                      $link=base_url('Partes/visualizar?id='.$p->id);
                      echo "<td style='text-align:center'><a href='".$link."' class='btn btn-danger btn-sm'>Parte PDF</a>";
                      
                      if($p->ordenTrabajo == 'SI' and $p->ordenGenerada == 1){
                        $linkReporteOrdenPdf = base_url('Partes/visualizarOrdenTrabajo?idParte='.$p->id);
                        echo "<br><br><a href='".$linkReporteOrdenPdf."' class='btn btn-danger btn-sm'>Orden PDF</a>";
                      }
                      echo "</tr>";
                    }
                  }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          <?php }?>
        </div>

      </div>
      <div class="col-md-1"></div>
    </div>

  </div>
</div>

<div class="modal fade" id="mostrarDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        <h4 class="modal-title" id="exampleModalLabel">Detalle</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="detalle"><strong>Detalle</strong></label>
              <textarea name="detalle" id="detalle" rows="6" disabled class="form-control"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL CREAR PARTE -->
<div class="modal fade" id="modalParte" tabindex="-1" role="dialog" aria-labelledby="modalParte">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <form id="formParte">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label">Fecha: </label>
              <input type="text" name="fechaFalloDetalleParte" id="fechaFalloDetalleParte" class="form-control required" autocomplete="off" placeholder="Seleccione la Fecha">
            </div>
          </div> 
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label">CAE: </label>
              <select name="idCae" id="idCae" class="form-control" onchange="buscarSectoresCae(this.value);">
                <option value="" selected disabled>Seleccione</option>
                <?php foreach ($cae as $dt){ ?>
                  <option value="<?php echo $dt->idCae; ?>"><?php echo $dt->nombreCae; ?></option>
                <?php } ?>     
              </select>
            </div>   
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label">Sector: </label>
              <select name="idSector" id="idSector" class="form-control" onchange="buscarEstacionesSector(this.value);"> 
              </select>
            </div>   
          </div>
        </div> 
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label class="form-label">Estación: </label>
                <select name="idEstacion" id="idEstacion" class="form-control" onchange="buscarTiposExistenciasEstacion(this.value);">
                </select>
            </div>   
          </div>
          <div class="col-md-8">
            <div class="form-group">
              <label class="form-label">Equipo: </label>
              <select class="form-control" name="idTipoExistencia" id="idTipoExistencia">
              </select>
            </div>                  
          </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-6">
            <label class="form-label">Novedad: </label>
            <textarea name="novedadDetalleParte" id="novedadDetalleParte" class="form-control"></textarea>
          </div>                  

          <div class="form-group col-sm-6">
            <label class="form-label">Requerimiento: </label>
            <textarea name="requerimientoDetalleParte" id="requerimientoDetalleParte" class="form-control"></textarea>
          </div>                  
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="grabarParte"> Grabar Parte Diario</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
      </div>
      </form>
    </div>
  </div>
</div>




<!-- Modal Gestionar Supervisor -->
<div class="modal fade" id="modalGestionSupervisor" tabindex="-1" role="dialog" aria-labelledby="modalGestionSupervisor">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <form id="formGestionSupervisor" autocompĺete="off">
      <input type="hidden" name="idParte" id="idParte">
      <input type="hidden" name="fechaFallo" id="fechaFallo">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="solucionado">Solucionado</label>
              <select name="solucionado" id="solucionado" class="form-control">
                <option selected disabled>Seleccione</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="fechaSolucion">Fecha de Solución</label>
              <input type="text" name="fechaSolucion" id="fechaSolucion" placeholder="Seleccione la fecha" class="form-control">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="fechaFueraServicio">Tiempo fuera de servicio</label>
              <input type="text" name="fechaFueraServicio" id="fechaFueraServicio" placeholder="Tiempo fuera de servicio" class="form-control" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="solucionSupervisor">Solución:</label>
              <textarea name="solucionSupervisor" id="solucionSupervisor" rows="4" class="form-control"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="grabarGestionSupervisor();">Grabar Datos</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
      </div>
      </form>
    </div>
  </div>
</div>



<div class="modal fade" id="generarOrden" tabindex="-1" role="dialog" aria-labelledby="generarOrden">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        <h4 class="modal-title" id="exampleModalLabel">Generar Orden</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idParte" id="idParte">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="generar"><strong>Generar Orden de Trabajo</strong></label>
              <select name="generar" id="generar" class="form-control">
                <option selected disabled>Seleccione</option>
                <option value="SI">SI</option>
                <option value="NO">NO</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="detalle"><strong>Detalle</strong></label>
              <textarea name="detalle" id="detalle" rows="6" class="form-control"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="grabarGenerarOrden();">Generar Orden</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>




<!-- MODAL ORDEN TRABAJO -->
<div class="modal fade" id="modalOrdenTrabajo" tabindex="-1" role="dialog" aria-labelledby="modalOrdenTrabajo">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        <h4 class="modal-title" id="exampleModalLabel">Orden de Trabajo</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idParte" id="idParte">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label>CAE: </label>
              <select name="idCae" id="idCae" class="form-control">
                <option value="" selected disabled>Seleccione</option>
                <?php foreach ($cae as $dt){ ?>
                  <option value="<?php echo $dt->idCae; ?>"><?php echo $dt->nombreCae; ?></option>
                <?php } ?>     
              </select>
            </div>   
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="fechaInicio"><strong>Fecha Inicio</strong></label>
              <input type="text" class="form-control" placeholder="Seleccione la fecha" id="fechaInicio" onchange="calcularTiempoOrden();">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="fechaFin"><strong>Fecha Fin</strong></label>
              <input type="text" class="form-control" placeholder="Seleccione la fecha" id="fechaFin" onchange="calcularTiempoOrden();" >
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="totalDias"><strong>Total Dias</strong></label>
              <input type="text" class="form-control" id="totalDias" readonly>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="personal">Personal</label>
              <select name="personal" id="personal" class="form-control input-sm">
                <option value="" selected disabled>Seleccione</option>
                <?php
                foreach($personal as $p){
                  $n = $p->abreviaturaGrado." ".$p->nombrePersonal." ".$p->apellidoPersonal;
                  echo "<option value='".$p->idPersonal."'>".$n."</option>";
                }
                ?>
              </select>
            </div>
          </div> 
          <div class="col-md-6">
            <div class="form-group">
              <label for="sistemaPersonal">Sistema</label>
              <select name="sistemaPersonal" id="sistemaPersonal" class="form-control input-sm">
                <option value="" selected disabled>Seleccione</option>
                <?php
                foreach($sistemas as $s){
                  echo "<option value='".$s->idSistema."'>".$s->nombreSistema."</option>";
                }
                ?>
              </select>
            </div>
          </div> 
        </div> 
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="provincia">Provincia</label>
              <select name="provincia" id="provincia" class="form-control input-sm">
                <option value="" selected disabled>Seleccione</option>
                <?php
                foreach($sectores as $s){
                  echo "<option value='".$s->idSector."'>".$s->nombreSector."</option>";
                }
                ?>
              </select>
            </div>
          </div> 
          <div class="col-md-6">
            <div class="form-group">
              <label for="tipoTrabajo">Tipo Trabajo</label>
              <select name="tipoTrabajo" id="tipoTrabajo" class="form-control input-sm">
                <option value="" selected disabled>Seleccione</option>
                <?php
                foreach($tiposMantenimientos as $tm){
                  echo "<option value='".$tm->idTipoMantenimiento."'>".$tm->nombreTipoMantenimiento."</option>";
                }
                ?>
              </select>
            </div>
          </div> 
        </div>
        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <label for="estacion">Estacion</label>
              <select name="estacion" id="estacion" class="form-control">
                <option value="" selected disabled>Seleccione</option>
                <?php
                foreach($estaciones as $e){
                  echo "<option value='".$e->idEstacion."'>".$e->nombreEstacion."</option>";
                }
                ?>
              </select>
            </div>
          </div> 
          <div class="col-md-4">
            <div class="form-group">
              <label for="sistemaEstacion">Sistema</label>
              <select name="sistemaEstacion" id="sistemaEstacion" class="form-control">
                <option value="" selected disabled>Seleccione</option>
                <?php
                foreach($sistemas as $s){
                  echo "<option value='".$s->idSistema."'>".$s->nombreSistema."</option>";
                }
                ?>
              </select>
            </div>
          </div> 
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="situacionPrevia">Situacion Previa</label>
              <textarea name="situacionPrevia" id="situacionPrevia" rows="3" class="form-control"></textarea>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="trabajoRealizar">Trabajo a realizar</label>
              <textarea name="trabajoRealizar" id="trabajoRealizar" rows="3" class="form-control"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
            <label for="nombreEquipo">Descripcion</label>
            <input type="text" name="nombreEquipo" id="nombreEquipo" class="form-control" placeholder="Equipo">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
            <label for="cantidadEquipo">Cantidad</label>
            <input type="number" name="cantidadEquipo" id="cantidadEquipo" class="form-control" placeholder="Cantidad">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
            <label for="nombreHerramienta">Descripcion</label>
            <input type="text" name="nombreHerramienta" id="nombreHerramienta" class="form-control" placeholder="Herramienta">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
            <label for="cantidadHerramienta">Cantidad</label>
            <input type="number" name="cantidadHerramienta" id="cantidadHerramienta" class="form-control" placeholder="Cantidad">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="grabarOrdenSupervisor();">Grabar Orden</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript" src="<?php echo site_url('assets/plugins/owner/js/datatables.js'); ?>"></script>

<script>

  //cargar datatable
  $('#tablaPartesListado').DataTable();

  //mostrar detalle modal
  $('#mostrarDetalle').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var recipient = button.data('whatever');
    var modal = $(this)
    $("#mostrarDetalle #detalle").val(recipient)
  })

  d = new Date();
  var fechaHoraActual = d.fechaHoraActual();
  $("#btnEnviarParte").hide();

  $('#modalParte #fechaFalloDetalleParte').datetimepicker({
   format:'Y-m-d H:i:s',
   //value : fechaHoraActual,
   minDate:'-1970/01/01', //fecha minima
   maxDate:'+1970/01/01', //fecha maxima
   step : 10
  });

  $('#modalActualizarParte #fechaFalloDetalleParte').datetimepicker({
    format:'Y-m-d H:i:s',
    //value : fechaHoraActual,
    minDate:'-1970/01/01', //fecha minima
    maxDate:'+1970/01/01', //fecha maxima
    step : 10
  });

  $('#modalGestionSupervisor #fechaSolucion').datetimepicker({
    format:'Y-m-d H:i:s',
    //value : fechaHoraActual,
    minDate:'-1970/01/01', //fecha minima
    maxDate:'+1970/01/01', //fecha maxima
    step : 10
  });

  $('#modalOrdenTrabajo #fechaInicio').datetimepicker({
    format:'Y-m-d',
    timepicker:false,
    minDate:'-1970/01/01', //fecha minima
    //maxDate:'+1970/01/01' //fecha maxima
  });
  
  $('#modalOrdenTrabajo #fechaFin').datetimepicker({
    format:'Y-m-d',
    timepicker:false,
    minDate:'-1970/01/01', //fecha minima
    //maxDate:'+1970/01/01' //fecha maxima
  });

  //LIMPIAR MODAL PARTE
  $('#modalParte').on('show.bs.modal', function (e) {
    
    $("#modalParte #idCae").val($("#modalParte #idCae option:first").val());
    $("#modalParte #idSector").find('option').remove();
    $("#modalParte #idEstacion").find('option').remove();
    $("#modalParte #idTipoExistencia").find('option').remove();
    $("#modalParte #fechaFalloDetalleParte").val('');
    $("#modalParte #novedadDetalleParte").val('');
    $("#modalParte #requerimientoDetalleParte").val('');

  })

  function buscarSectoresCae(idCae){

      $.ajax({
        type : 'post',
        url  : "<?php echo site_url('Sectores/buscarSectoresCae'); ?>",
        dataType: 'json',
        data: {
          idCae   : idCae
        },
      }).done( function(data) {
          $('#modalParte #idSector').find('option').remove();
            $('#modalParte #idSector').append('<option value="" selected disabled>SELECCIONE...</option>');
          $(data).each(function(i, v){
            $('#modalParte #idSector').append('<option value="'+ v.idSector +'">' + v.nombreSector+ '</option>');
          })   
      }).fail( function() {
        swal("Información!", "No se pudierson cargar los sectores", "warning"); 
      }).always( function() {
        //alert( 'Always' );
      });  

  }// end function buscarSectoresCae


  function buscarEstacionesSector(idSector){
  
      $.ajax({
        type : 'post',
        url  : "<?php echo site_url('Estaciones/buscarEstacionesSector'); ?>",
        dataType: 'json',
        data: {
          idSector:idSector,
        },
      }).done( function(data) {
          $('#modalParte #idEstacion').find('option').remove();
            $('#modalParte #idEstacion').append('<option value="">Seleccione</option>');
          $(data).each(function(i, v){
            $('#modalParte #idEstacion').append('<option value="'+ v.idEstacion +'">' + v.nombreEstacion+ '</option>');
          })    
      }).fail( function() {
        swal("Información!", "No se pudierson cargar las estaciones", "warning"); 
      }).always( function() {
        //alert( 'Always' );
      }); 
      gestionSupervisor
  }//end function buscarEstacionesSector


  function buscarTiposExistenciasEstacion(idEstacion){
    
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('TiposExistencias/buscarTiposExistenciasEstacionParte'); ?>",
      dataType: 'json',
      data: {
        idEstacion:idEstacion,
      },
    }).done( function(data) {
        $('#modalParte #idTipoExistencia').find('option').remove();
        $(data).each(function(i, v){
          $('#modalParte #idTipoExistencia').append('<option value="'+ v.idTipoExistencia +'">' + v.nombreTipoExistencia+ '</option>');
        })        
    }).fail( function() {
      swal("Información!", "No se pudieron cargar los equipos", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });  

  }//end function buscarTiposExistenciasEstacion


  //grabar darte
  $("#modalParte #grabarParte").click(function(){
    
    Swal.fire({
      title: '',
      text: "Desea grabar el Parte Diario ?",
      icon: 'warning',
      showCancelButton: true,
      //confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si',
      cancelButtonText: 'No',
    }).then((result) => {
      if (result.value) {

        fechaParte = $('#modalParte #fechaFalloDetalleParte').val();
        if(fechaParte == '' || fechaParte == null ){
          swal('','Seleccione la fecha y hora del parte.','info');
          return false;
        }

        idCae = $('#modalParte #idCae').val();
        if(idCae == '' || idCae == null ){
          swal('','Seleccione el CAE.','info');
          return false;
        }

        idSector = $('#modalParte #idSector').val();
        if(idSector == '' || idSector == null ){
          swal('','Seleccione el Sector.','info');
          return false;
        }

        idEstacion = $('#modalParte #idEstacion').val();
        if(idEstacion == '' || idEstacion == null ){
          swal('','Seleccione la Estación.','info');
          return false;
        }

        idTipoExistencia = $('#modalParte #idTipoExistencia').val();
        if(idTipoExistencia == '' || idTipoExistencia == null ){
          swal('','Seleccione el Equipo.','info');
          return false;
        }
        

        novedadDetalleParte = $('#modalParte #novedadDetalleParte').val();
        if(novedadDetalleParte == '' || novedadDetalleParte == null ){
          swal('','Ingrese la novedad.','info');
          return false;
        }


        requerimientoDetalleParte = $('#modalParte #requerimientoDetalleParte').val();
        if(requerimientoDetalleParte == '' || requerimientoDetalleParte == null ){
          swal('','Ingrese el Requerimiento.','info');
          return false;
        }
        
        //ENVIO DATA
        $.ajax({
          type : 'post',
          url  : "<?php echo site_url('Partes/grabarParteDiario'); ?>",
          dataType: 'json',
          data: {
            fechaParte:fechaParte,
            idCae:idCae,
            idSector:idSector,
            idEstacion:idEstacion,
            idTipoExistencia:idTipoExistencia,
            novedadDetalleParte:novedadDetalleParte,
            requerimientoDetalleParte:requerimientoDetalleParte
          },
        }).done( function(data) {
          //ocultar modal
          $("#modalParte").modal('hide');
          $().toastmessage('showSuccessToast', "Parte Diario grabada con exito.");  
          setTimeout(function () { location.reload(true); }, 3000);
          
        }).fail( function() {
          $().toastmessage('showErrorToast', "Error al grabar el parte.");
        }); 
        personal
      }
    })


  })//end grabar darte


  function eliminarParteDiario(idParte){

    Swal.fire({
      title: 'Desea eliminar el parte ?',
      text: "No podra ser recuperado.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si',
      cancelButtonText: 'No'
    }).then((result) => {
      if (result.value) {
        //eliminar 
        $.ajax({
          type : 'post',
          url  : "<?php echo site_url('Partes/eliminarParte'); ?>",
          dataType: 'json',
          data: {
            idParte:idParte
          },
        }).done( function(data) {
        
          $().toastmessage('showSuccessToast', "Parte Diario eliminado con exito.");  
          setTimeout(function () { location.reload(true); }, 3000);
        }).fail( function() {
          $().toastmessage('showErrorToast', "Error al consultar.");
        }); 

      }
    })


  }//end function editarParteDiario


personal
  function enviarPendientes(){

    Swal.fire({
      title: 'Desea enviar todas las partes diarias pendientes?',
      text: "",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si',
      cancelButtonText: 'No'
    }).then((result) => {
      if (result.value) {

        $.ajax({
          type : 'post',
          url  : "<?php echo site_url('Partes/enviarPendientes'); ?>",
          dataType: 'json',
          data: {
            supervisor:1
          },
        }).done( function(data) {
          $().toastmessage('showSuccessToast', "Partes diarios enviados con exito.");  
          setTimeout(function () { location.reload(true); }, 3000);
        }).fail( function() {
          $().toastmessage('showErrorToast', "Error al consultar.");
        }); 

      }

    })

  }//end function enviarPendientes


  function gestionSupervisor(idParte, fechaFallo){
    console.log('id parte: '+idParte);
    console.log('Fecha fallo: '+fechaFallo);
    $("#modalGestionSupervisor #idParte").val(idParte);
    $("#modalGestionSupervisor #fechaFallo").val(fechaFallo);
    //mostrar modal
    $("#modalGestionSupervisor").modal('show');

  }//end function gestionSupervisor


  $('#modalGestionSupervisor').on('show.bs.modal', function (e) {
    $("#modalGestionSupervisor form#formGestionSupervisor").trigger("reset");
  })

  $('#modalGestionSupervisor #fechaSolucion').on('change', function() {

    var fechaSolucion = $("#modalGestionSupervisor #fechaSolucion").val();
    var fechaFallo    = $("#modalGestionSupervisor #fechaFallo").val();
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('DetallesPartes/calcularHorasFueraServicio'); ?>",
      dataType: 'json',
      data: {
        fechaFalloDetalleParte : fechaFallo,
        fechaSolucionDetalleParte : fechaSolucion,
      },
    }).done( function(data) {
      $("#modalGestionSupervisor #fechaFueraServicio").val(data);             
    }).fail( function() {
      $().toastmessage('showErrorToast', "No se puede calcular las horas");
    }).always( function() {
      //alert( 'Always' );
    });

  })


  function grabarGestionSupervisor(){

    Swal.fire({
      title: 'Desea grabar los datos?',
      text: "",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si',
      cancelButtonText: 'No',
    }).then((result) => {
      if (result.value) {
        var idParte             = $("#modalGestionSupervisor #idParte").val(); 
        var solucionado         = $("#modalGestionSupervisor #solucionado").val();
        if(solucionado == '' || solucionado == null){
          swal('Seleccione una opción.');
          return false;
        } 
        var fechaSolucion       = $("#modalGestionSupervisor #fechaSolucion").val(); 
        if(solucionado == 'SI' && fechaSolucion == '' || fechaSolucion == null){
          swal('Seleccione la fecha de solución.');
          return false;
        }
        var fechaFueraServicio  = $("#modalGestionSupervisor #fechaFueraServicio").val(); 
        var solucionSupervisor  = $("#modalGestionSupervisor #solucionSupervisor").val(); 
        if( solucionado == 'SI'  && solucionSupervisor == "" || solucionSupervisor == null ){
          swal('Ingrese la solución.');
          return false;
        } 
        if(solucionado == 'NO'){
          $("#modalGestionSupervisor #fechaSolucion").val('');
          $("#modalGestionSupervisor #solucionSupervisor").val('');
        }
      }
      $.ajax({
        type : 'post',
        url  : "<?php echo site_url('Partes/gestionSupervisor'); ?>",
        dataType: 'json',
        data: {
          idParte:idParte,
          solucionado:solucionado,
          fechaSolucion:fechaSolucion,
          fechaFueraServicio:fechaFueraServicio,
          solucionSupervisor:solucionSupervisor
        },
      }).done( function(data) {

        $("#modalGestionSupervisor").modal('hide');
        $().toastmessage('showSuccessToast', "Datos grabados con exito."); 
        setTimeout(function () { location.reload(true); }, 3000);
      }).fail( function() {
        $().toastmessage('showErrorToast', "No se puede grabar los datos");
      }).always( function() {
        //alert( 'Always' );
      });

    })


  }//end function grabarGestionSupervisor


  function generarOrden(idParte){

    $("#generarOrden #idParte").val(idParte);
    $("#generarOrden #generar").val($("#generarOrden #generar option:first").val());
    $("#generarOrden #detalle").val('');
    $("#generarOrden").modal('show');
  
  }//end function generarOrden


  function grabarGenerarOrden(){

    Swal.fire({
      title: 'Desea generar la Orden de Trabajo?',
      text: "",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si',
      cancelButtonText: 'Si'
    }).then((result) => {
      if (result.value) {

        $.ajax({
          type : 'post',
          url  : "<?php echo site_url('Partes/generarOrdenTrabajo'); ?>",
          dataType: 'json',
          data: {
            idParte:$("#generarOrden #idParte").val(),
            generar:$("#generarOrden #generar").val(),
            detalleOrden:$("#generarOrden #detalle").val()
          },
        }).done( function(data) {
          $("#generarOrden").modal('hide');
          $().toastmessage('showSuccessToast', "Orden generada con exito.");
          setTimeout(function () { location.reload(true); }, 3000);
        }).fail( function() {
          $().toastmessage('showErrorToast', "No se puede grabar los datos");
        }).always( function() {
          //alert( 'Always' );
        });

      }
    })   

  }//end function grabarGenerarOrden


  function mostrarOrdenTrabajo(idParte){

    $("#modalOrdenTrabajo #idParte").val(idParte);
    $("#modalOrdenTrabajo").modal('show');

  }//end function mostrarOrdenTrabajo


  function calcularTiempoOrden(){
    
    var fecInicio = new Date($("#modalOrdenTrabajo #fechaInicio").val());
    var fecFin    = new Date($("#modalOrdenTrabajo #fechaFin").val());
    

    var dia_milisegundos  = 86400000;
    var diff_milisegundos = fecFin - fecInicio;
    var diff_dias         = diff_milisegundos / dia_milisegundos;
    
    $("#modalOrdenTrabajo #totalDias").val(diff_dias);


  }//end function calcularTiempoOrden


  function grabarOrdenSupervisor(){

    Swal.fire({
      title: 'Desea grabar los datos?',
      text: "",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si',
      cancelButtonText: 'No',
    }).then((result) => {
      if (result.value) {

        var idParte = $("#modalOrdenTrabajo #idParte").val();
        var idCae   = $("#modalOrdenTrabajo #idCae").val();
        var fechaInicio =$("#modalOrdenTrabajo #fechaInicio").val();
        var fechaFin =$("#modalOrdenTrabajo #fechaFin").val();
        var totalDias =$("#modalOrdenTrabajo #totalDias").val();
        var personal =$("#modalOrdenTrabajo #personal").val();
        var sistemaPersonal = $("#modalOrdenTrabajo #sistemaPersonal").val();
        var provincia = $("#modalOrdenTrabajo #provincia").val();
        var tipoTrabajo = $("#modalOrdenTrabajo #tipoTrabajo").val();
        var estacion = $("#modalOrdenTrabajo #estacion").val();
        var sistemaEstacion = $("#modalOrdenTrabajo #sistemaEstacion").val();
        var situacionPrevia = $("#modalOrdenTrabajo #situacionPrevia").val();
        var trabajoRealizar = $("#modalOrdenTrabajo #trabajoRealizar").val();
        var nombreEquipo = $("#modalOrdenTrabajo #nombreEquipo").val();
        var cantidadEquipo = $("#modalOrdenTrabajo #cantidadEquipo").val();
        var nombreHerramienta = $("#modalOrdenTrabajo #nombreHerramienta").val();
        var cantidadHerramienta = $("#modalOrdenTrabajo #cantidadHerramienta").val();
        
        $.ajax({
          type : 'post',
          url  : "<?php echo site_url('Partes/grabarOrdenTrabajo'); ?>",
          dataType: 'json',
          data: {
            idParte:idParte,
            idCae:idCae,
            fechaInicio:fechaInicio,
            fechaFin:fechaFin,
            totalDias:totalDias,
            personal:personal,
            sistemaPersonal:sistemaPersonal,
            provincia:provincia,
            tipoTrabajo:tipoTrabajo,
            estacion:estacion,
            sistemaEstacion:sistemaEstacion,
            situacionPrevia:situacionPrevia,
            trabajoRealizar:trabajoRealizar,
            nombreEquipo:nombreEquipo,
            cantidadEquipo:cantidadEquipo,
            nombreHerramienta:nombreHerramienta,
            cantidadHerramienta:cantidadHerramienta
          },
        }).done( function(data) {
          console.log(data);
          $("#generarOrden").modal('hide');
          $().toastmessage('showSuccessToast', "Orden generada con exito.");
          setTimeout(function () { location.reload(true); }, 3000);
        }).fail( function() {
          $().toastmessage('showErrorToast', "No se puede grabar los datos");
        }).always( function() {
          //alert( 'Always' );
        });

      
      }
    })

  }//end function grabarOrdenSupervisor

</script>