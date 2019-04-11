<script type="text/javascript">
  $("#tituloPagina").text("<?php echo $menuNombreCae; ?>");
  $("#btngestionRegistroCae").hide();
  $("#btngestionRegistroTipoExistencia").hide();
  $("#btngestionRegistroEstacion").show();
  $("#btngestionVolverCae").show();
  $("#btngestionRegistroSeccion").hide();
  $("#btngestionVolverEstacion").hide();
  $("#btngestionRegistroSistema").hide();
  $("#btngestionVolverSeccion").hide();
  $("#idCaeEstacion").val("<?php echo $idCae; ?>");
</script>

<div class="table-responsive">
<?php if($lista){ ?>
  <table id="tablaCronos" class="table table-bordered table-striped tablaCronos">
    <thead>
      <tr>
        <th width="5%">N</th>
        <th width="10%">Nominativo</th>
        <th width="66%">Nombre</th>
        <th width="10%">Secciones</th>
        <th width="9%"></th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
    <?php foreach ($lista as $lt) { ?>
      <tr>
        <td><?php echo $i; $i++; ?></td>
        <td><?php echo $lt->nominativoEstacion; ?></td>
        <td><?php echo $lt->nombreEstacion; ?></td>
        <td>
        	<button type="button" class="btn btn-warning btn-sm" onclick="gestionSecciones(this);" data-id="<?php echo $lt->idEstacion; ?>" <?php echo $status; ?>><i class="fe fe-aperture"></i> Secciones</button>
        </td>
        <td>
         <button type="button" class="btn btn-info btn-sm" onclick="gestionRegistroEstacion(this);" data-titulo="<b><i class='fa fa-file'></i> Editar Registro</b>" data-accion="editarRegistro" data-id="<?php echo $lt->idEstacion;?>" <?php echo $status; ?>><i class="fas fa-pencil-alt"></i></button> 
         <button type="button" class="btn btn-danger btn-sm" onclick="gestionRegistroEstacion(this);" data-toggle="tooltip" data-placement="left" title="Eliminar Registro" data-accion="eliminarRegistro" data-id="<?php echo $lt->idEstacion; ?>" <?php echo $status; ?>><i class="fas fa-trash-alt"></i>
        </button>
        </td>
      </tr>
    <?php } ?>            
    </tbody>
    <tfoot>
      <tr>
        <th>N</th>
        <th>Nominativo</th>
        <th>Nombre</th>
        <th>Secciones</th>
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