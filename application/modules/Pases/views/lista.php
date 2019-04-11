<script type="text/javascript">
	$("#divNombrePersonal").text("<?php echo $tituloPagina; ?>");
    $("#btnGestionRegistroPersonal").hide();
    $("#btnGestionVolverPersonal").show();
    $("#idPersonalPase").val("<?php echo $idPersonal; ?>");
</script>
<div class="row">
	<div class="col-sm-10">
		<h4 id="divNombrePersonal"></h4>
	</div>
	<div class="col-sm-2" align="right">
		<button type="button" id="btnGestionRegistroPersonal" class="btn btn-success bnt-sm" onclick="gestionRegistroPase(this);" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nuevo pase</button>	
	</div>
</div>	

<br>

<div class="table-responsive">
<?php if($lista){ ?>
  <table id="tablaCronos" class="table table-bordered table-striped tablaCronos">
    <thead>
      <tr>
        <th width="5%">N</th>
        <th width="35%">CAE Origen</th>
        <th width="35%">CAE Destino</th>
        <th width="10%">Fecha</th>
        <th width="6%">Estado</th>
        <th width="9%"></th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
    <?php foreach ($lista as $lt) { ?>
      <tr>
        <td><?php echo $i; $i++; ?></td>
        <td><?php echo $lt->caeOrigen; ?></td>
        <td><?php echo $lt->caeDestino; ?></td>
        <td><?php echo $lt->fechaPresentacionPase; ?></td>
        <td align="center">
          <?php if($lt->estadoPase=='A'){ ?>
            <?php $clase = 'success'; ?>
          <?php }else{ ?>
            <?php $clase = 'danger'; ?>
          <?php } ?>        	
        	<span class="badge badge-pill badge-<?php echo $clase; ?>"><?php echo $lt->estadoPase; ?></span>
        </td>
        <td>
         <button type="button" class="btn btn-info btn-sm" onclick="gestionRegistroPase(this);" data-titulo="<b><i class='fa fa-file'></i> Editar Registro</b>" data-accion="editarRegistro" data-id="<?php echo $lt->idPase;?>" <?php echo $status; ?>><i class="fas fa-pencil-alt"></i></button> 
         <button type="button" class="btn btn-danger btn-sm" onclick="gestionRegistroPase(this);" data-toggle="tooltip" data-placement="left" title="Eliminar Registro" data-accion="eliminarRegistro" data-id="<?php echo $lt->idPase; ?>" <?php echo $status; ?>><i class="fas fa-trash-alt"></i>
        </button>
        </td>
      </tr>
    <?php } ?>            
    </tbody>
    <tfoot>
      <tr>
        <th>N</th>
        <th>CAE Origen</th>
        <th>CAE Destino</th>
        <th>Fecha</th>
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