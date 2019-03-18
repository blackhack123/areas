<script type="text/javascript">
  $("#tituloPagina").text("<?php echo $menuNombreFuerza; ?>");
  $("#btnGestionRegistroFuerza").hide();
  $("#btngestionRegistroGrado").show();
  $("#btnGestionVolverFuerza").show();
  $("#idFuerzaGrado").val("<?php echo $idFuerza; ?>");
</script>

<div class="table-responsive">
<?php if($lista){ ?>
  <table id="tablaCronos" class="table table-bordered table-striped tablaCronos">
    <thead>
      <tr>
        <th width="5%">N</th>
        <th width="76%">Nombre</th>
        <th width="10%">Abreviatura</th>
        <th width="9%"></th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($lista as $lt) { ?>
      <tr>
        <td><?php echo $lt->ordenGrado; ?></td>
        <td><?php echo $lt->nombreGrado; ?></td>
        <td><?php echo $lt->abreviaturaGrado; ?></td>
        <td>
         <button type="button" class="btn btn-info btn-sm" onclick="gestionRegistroGrado(this);" data-titulo="<b><i class='fa fa-file'></i> Editar Registro</b>" data-accion="editarRegistro" data-id="<?php echo $lt->idGrado;?>" <?php echo $status; ?>><i class="fas fa-pencil-alt"></i></button> 
         <button type="button" class="btn btn-danger btn-sm" onclick="gestionRegistroGrado(this);" data-toggle="tooltip" data-placement="left" title="Eliminar Registro" data-accion="eliminarRegistro" data-id="<?php echo $lt->idGrado; ?>" <?php echo $status; ?>><i class="fas fa-trash-alt"></i>
        </button>
        </td>
      </tr>
    <?php } ?>            
    </tbody>
    <tfoot>
      <tr>
        <th>N</th>
        <th>Nombre</th>
        <th>Abreviatura</th>
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