<div class="table-responsive">
<?php if($lista){ ?>
  <table id="tablaCronos" class="table table-bordered table-striped tablaCronos">
    <thead>
      <tr>
        <th width="5%">N</th>
        <th width="15%">Estación</th>
        <th width="15%">Sistema</th>
        <th width="8%">Fecha</th>
        <th width="43%">Novedad</th>
        <th width="5%">Estado</th>
        <th width="9%"></th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
    <?php foreach ($lista as $lt) { ?>
      <tr>
        <td><?php echo $i; $i++; ?></td>
        <td><?php echo $lt->nombreEstacion; ?></td>
        <td><?php echo $lt->nombreSistema; ?></td>
        <td><?php echo $lt->fechaParte; ?></td>
        <td><?php echo $lt->novedadParte; ?></td>
        <td><?php echo $lt->esSolucionadoParte; ?></td>
        <td>
         <button type="button" class="btn btn-info btn-sm" onclick="gestionRegistro(this);" data-titulo="<b><i class='fa fa-file'></i> Editar Registro</b>" data-accion="editarRegistro" data-id="<?php echo $lt->idParte;?>" <?php echo $status; ?>><i class="fas fa-pencil-alt"></i></button> 
         <button type="button" class="btn btn-danger btn-sm" onclick="gestionRegistro(this);" data-toggle="tooltip" data-placement="left" title="Eliminar Registro" data-accion="eliminarRegistro" data-id="<?php echo $lt->idParte; ?>" <?php echo $status; ?>><i class="fas fa-trash-alt"></i>
        </button>
        </td>
      </tr>
    <?php } ?>            
    </tbody>
    <tfoot>
      <tr>
        <th>N</th>
        <th>Estación</th>
        <th>Sistema</th>
        <th>Fecha</th>
        <th>Novedad</th>
        <th>Estado</th>
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