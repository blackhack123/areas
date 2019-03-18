<div class="table-responsive">
<?php if($lista){ ?>
  <table id="tablaCronos" class="table table-bordered table-striped tablaCronos">
    <thead>
      <tr>
        <th width="5%">N</th>
        <th width="71%">Nombre</th>
        <th width="5%">Logo</th>
        <th width="10%">Grados</th>
        <th width="9%"></th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
    <?php foreach ($lista as $lt) { ?>
      <tr>
        <td style="vertical-align: middle;"><?php echo $i; $i++; ?></td>
        <td style="vertical-align: middle;"><?php echo $lt->nombreFuerza; ?></td>
        <td>
          <a href="<?php echo base_url().'application/modules/Fuerzas/photos/'.$lt->logoFuerza; ?>">
            <img src="<?php echo base_url().'application/modules/Fuerzas/photos/'.$lt->logoFuerza; ?>" height="50px" width="50px">            
          </a>
        </td>
        <td style="vertical-align: middle;">
          <button type="button" class="btn btn-warning btn-sm" onclick="gestionGrados(this);" data-id="<?php echo $lt->idFuerza; ?>" <?php echo $status; ?>><i class="fe fe-layers"></i> Grados</button>
        </td>
        <td style="vertical-align: middle;">
         <button type="button" class="btn btn-info btn-sm" onclick="gestionRegistro(this);" data-titulo="<b><i class='fa fa-file'></i> Editar Registro</b>" data-accion="editarRegistro" data-id="<?php echo $lt->idFuerza;?>" <?php echo $status; ?>><i class="fas fa-pencil-alt"></i></button> 
         <button type="button" class="btn btn-danger btn-sm" onclick="gestionRegistro(this);" data-toggle="tooltip" data-placement="left" title="Eliminar Registro" data-accion="eliminarRegistro" data-id="<?php echo $lt->idFuerza; ?>" <?php echo $status; ?>><i class="fas fa-trash-alt"></i>
        </button>
        </td>
      </tr>
    <?php } ?>            
    </tbody>
    <tfoot>
      <tr>
        <th>N</th>
        <th>Nombre</th>
        <th>Logo</th>
        <th>Grados</th>
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