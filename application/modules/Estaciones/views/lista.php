<script type="text/javascript">
  $("#tituloPagina").text("<?php echo $tituloPagina; ?>");

  $("#btnGestionRegistroCae").hide();
  $("#btnGestionRegistroSector").hide();
  $("#btnGestionRegistroEstacion").show();
  $("#btnGestionRegistroTipoExistencia").hide();
  
  $("#btnGestionVolverCae").hide();
  $("#btnGestionVolverSector").show();
  $("#btnGestionVolverEstacion").hide();

  $("#idSectorEstacion").val("<?php echo $idSector; ?>");
</script>

<div class="table-responsive">
<?php if($lista){ ?>
  <table id="tablaCronos" class="table table-bordered table-striped tablaCronos">
    <thead>
      <tr>
        <th width="5%">N</th>
        <th width="10%">Nominativo</th>
        <th width="56%">Nombre</th>
        <th width="10%">Mover a</th>
        <th width="10%">Equipos</th>
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
        <td align="center"> 
          <a href="#" onclick="cambiarSector(this);" data-id="<?php echo $lt->idEstacion; ?>"><i class="fe fe-refresh-cw"></i></a>
        </td>        
        <td>
          <button type="button" class="btn btn-warning btn-sm" onclick="gestionTiposExistencias(this);" data-id="<?php echo $lt->idEstacion; ?>" <?php echo $status; ?>><i class="fe fe-speaker"></i> Equipos</button>
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
        <th>Mover a</th>
        <th>Equipos</th>
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