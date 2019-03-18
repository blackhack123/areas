<div class="table-responsive">
<?php if($lista){ ?>
	
  <table id="tablaCronos" class="table table-bordered table-striped tablaCronos">
    <thead>
	  <tr>
		<th width="5%">N</th>
		<th width="70%">Nombres</th>
		<th width="15%">Color</th>
		<th width="10%"></th>
	  </tr>
	</thead>
	<tbody>
	<?php $orden = 1; ?>
	<?php foreach ($lista as $lt){ ?>
	  <tr>
		<td><?php echo $orden; $orden++; ?></td>
		<td><?php echo $lt->nombrePerfil; ?></td>
		<td><?php echo $lt->skinPerfil; ?></td>

		<td>
         <button type="button" class="btn btn-info btn-sm" onclick="gestionRegistro(this);" data-titulo="<b><i class='fa fa-file'></i> Editar Registro</b>" data-accion="editarRegistro" data-id="<?php echo $lt->idPerfil;?>" <?php echo $status; ?>><i class="fas fa-pencil-alt"></i></button> 
         <button type="button" class="btn btn-danger btn-sm" onclick="gestionRegistro(this);" data-toggle="tooltip" data-placement="left" title="Eliminar Registro" data-accion="eliminarRegistro" data-id="<?php echo $lt->idPerfil; ?>" <?php echo $status; ?>><i class="fas fa-trash-alt"></i>
        </button>
        </td>
	<?php } ?>
	</tbody>
    <tfoot>
      <tr>
        <th>N</th>
        <th>Nombres</th>
        <th>Color</th>
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