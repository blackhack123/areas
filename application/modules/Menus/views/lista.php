<script type="text/javascript">
  $("#btnGestionRegistro").hide();
  $("#btnGestionRegistroMenu").show();
  $("#btnGestionVolverCategoriamenu").show();
  $("#tituloPagina").text("<?php echo $menuNombre; ?>");
  $("#idMenuCategoriaMenu").val("<?php echo $idCategoriaMenu; ?>");
</script>

<div class="table-responsive">
<?php if($lista){ ?>
  <table id="tablaCronos" class="table table-bordered table-striped tablaCronos">
    <thead>
      <tr>
        <th width="5%">N</th>
        <th width="60%">Menú</th>
        <th width="26%">Icono</th>
        <th width="9%"></th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
    <?php foreach ($lista as $lt) { ?>
      <tr>
        <td><?php echo $i; $i++; ?></td>
        <td><?php echo $lt->nombreMenu; ?></td>
        <td><?php echo $lt->iconoMenu; ?></td>
        <td>
         <button type="button" class="btn btn-info btn-sm" onclick="gestionRegistroMenu(this);" title="Editar Registro" data-accion="editarRegistro" data-id="<?php echo $lt->idMenu;?>" <?php echo $status; ?>><i class="fas fa-pencil-alt" ></i></button> 
         <button type="button" class="btn btn-danger btn-sm" onclick="gestionRegistroMenu(this);" data-toggle="tooltip" data-placement="left" title="Eliminar Registro" data-accion="eliminarRegistro" data-id="<?php echo $lt->idMenu; ?>"  <?php echo $status; ?>><i class="fas fa-trash-alt"></i>
        </button>
        </td>
      </tr>
    <?php } ?>            
    </tbody>
    <tfoot>
      <tr>
        <th>N</th>
        <th>Menú</th>
        <th>Icono</th>
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