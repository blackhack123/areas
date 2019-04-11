<div class="table-responsive">
<?php if($lista){ ?>
  <table id="tablaCronos" class="table table-bordered table-striped tablaCronos">
    <thead>
      <tr>
        <th width="5%">N</th>
        <th width="5%">Fecha</th>
        <th width="5%">Cae</th>
        <th width="5%">Sistema</th>
        <th width="5%">Nominativo</th>
        <th width="11%">Estación</th>
        <th width="5%">Tipo</th>
        <th width="8%">Propiedad</th>
        <th width="14%">Novedad</th>
        <th width="14%">Seguimiento</th>
        <th width="14%">Requerimiento/Solución</th>
        <th width="5%">Solucionado?</th>
        <th width="9%"></th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
    <?php foreach ($lista as $lt) { ?>
      <tr>
        <td><?php echo $i; $i++; ?></td>
        <td><?php echo $lt->fechaParte; ?></td>
        <td><?php echo $lt->nombreCae; ?></td>
        <td><?php echo $lt->nombreSistema; ?></td>
        <td><?php echo $lt->nominativoEstacion; ?></td>
        <td><?php echo $lt->nombreEstacion; ?></td>
        <td><?php echo $lt->nombreTipoExistencia; ?></td>
        <td><?php echo $lt->propiedadTipoExistencia; ?></td>
        <td><?php echo $lt->novedadParte; ?></td>
        <td><?php echo $lt->seguimientoParte; ?></td>
        <td><?php echo $lt->requerimientoSolucionParte; ?></td>
        <td align="center">
          <?php if($lt->esSolucionadoParte=='SI'){ ?>
            <?php $clase = 'success'; ?>
          <?php }else{ ?>
            <?php $clase = 'danger'; ?>
          <?php } ?>          
          <span class="badge badge-pill badge-<?php echo $clase; ?>"><?php echo $lt->esSolucionadoParte; ?></span>
        <td>
         <button type="button" class="btn btn-info btn-sm" onclick="gestionRegistroParte(this);"  data-accion="editarRegistro" data-id="<?php echo $lt->idParte;?>" <?php echo $status; ?>><i class="fas fa-pencil-alt"></i></button> 
        </td>
      </tr>
    <?php } ?>            
    </tbody>
    <tfoot>
      <tr>
        <th>N</th>
        <th>Fecha</th>
        <th>Cae</th>
        <th>Sistema</th>
        <th>Nominativo</th>
        <th>Estación</th>
        <th>Tipo</th>
        <th>Propiedad</th>
        <th>Novedad</th>
        <th>Seguimiento</th>
        <th>Requerimiento/Solución</th>
        <th>Solucionado?</th>
        <th></th>
      </tr>
    </tfoot>
  </table>
<?php }else{ ?>
  <div class="alert alert-danger">
    <b>No se encontraton datos</b>
  </div>
<?php } ?>

</div>

<script type="text/javascript" src="<?php echo site_url('assets/plugins/owner/js/datatables.js'); ?>"></script>