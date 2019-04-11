<script type="text/javascript">
  $("#tituloPagina").text("<?php echo $menuNombreCae; ?>");
  $("#btngestionRegistroTipoExistencia").hide();
  $("#btngestionRegistroCae").hide();
  $("#btngestionRegistroEstacion").hide();
  $("#btngestionVolverCae").hide();
  $("#btngestionRegistroSeccion").hide();
  $("#btngestionVolverEstacion").hide();
  $("#btngestionRegistroSistema").show();
  $("#btngestionVolverSeccion").show();
  $("#idSeccionSistema").val("<?php echo $idSeccion; ?>");
</script>

<div class="table-responsive">
<?php if($lista){ ?>
  <table id="tablaCronos" class="table table-bordered table-striped tablaCronos">
    <thead>
      <tr>
        <th width="5%">N</th>
        <th width="86%">Nombre</th>
        <th width="9%"></th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
    <?php foreach ($lista as $lt) { ?>
      <tr>
        <td><?php echo $i; $i++; ?></td>
        <td><?php echo $lt->nombreSistema; ?></td>
        <td>
         <button type="button" class="btn btn-info btn-sm" onclick="gestionRegistroSistema(this);" data-accion="editarRegistro" data-id="<?php echo $lt->idSistema;?>" <?php echo $status; ?>><i class="fas fa-pencil-alt"></i></button> 
         <button type="button" class="btn btn-danger btn-sm" onclick="gestionRegistroSistema(this);" data-toggle="tooltip" data-placement="left" title="Eliminar Registro" data-accion="eliminarRegistro" data-id="<?php echo $lt->idSistema; ?>" <?php echo $status; ?>><i class="fas fa-trash-alt"></i>
        </button>
        </td>
      </tr>
    <?php } ?>            
    </tbody>
    <tfoot>
      <tr>
        <th>N</th>
        <th>Nombre</th>
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