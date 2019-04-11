<div class="table-responsive">
<?php if($lista){ ?>
  <table id="tablaCronos" class="table table-bordered table-striped tablaCronos">
    <thead>
      <tr>
        <th width="5%">N</th>
        <th width="20%">Fuerza</th>
        <th width="10%">Grado</th>
        <th width="38%">Nómina</th>
        <th width="8%">CI</th>
        <th width="10%">Pases</th>
        <th width="9%"></th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
    <?php foreach ($lista as $lt) { ?>
      <tr>
        <td><?php echo $i; $i++; ?></td>
        <td><?php echo $lt->nombreFuerza; ?></td>
        <td><?php echo $lt->abreviaturaGrado; ?></td>
        <td><?php echo $lt->apellidoPersonal.' '.$lt->nombrePersonal; ?></td>
        <td><?php echo $lt->numeroIdentificacionPersonal; ?></td>
        <td>
          <button type="button" class="btn btn-warning btn-sm" onclick="buscarPasesPersonal(this);" data-id="<?php echo $lt->idPersonal; ?>" <?php echo $status; ?>><i class="fe fe-layers"></i> Pases</button>
        </td>
        <td>
         <button type="button" class="btn btn-info btn-sm" onclick="gestionRegistro(this);" data-titulo="<b><i class='fa fa-file'></i> Editar Registro</b>" data-accion="editarRegistro" data-id="<?php echo $lt->idPersonal;?>" <?php echo $status; ?>><i class="fas fa-pencil-alt"></i></button> 
         <button type="button" class="btn btn-danger btn-sm" onclick="gestionRegistro(this);" data-toggle="tooltip" data-placement="left" title="Eliminar Registro" data-accion="eliminarRegistro" data-id="<?php echo $lt->idPersonal; ?>" <?php echo $status; ?>><i class="fas fa-trash-alt"></i>
        </button>
        </td>
      </tr>
    <?php } ?>            
    </tbody>
    <tfoot>
      <tr>
        <th>N</th>
        <th>Fuerza</th>
        <th>Grado</th>
        <th>Nómina</th>
        <th>CI</th>
        <th>Pases</th>
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