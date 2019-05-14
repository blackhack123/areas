<div class="table-responsive">
<?php if($lista){ ?>
  <table id="tablaCronos" class="table table-bordered table-striped tablaCronos">
    <thead>
      <tr>
        <th width="5%">N</th>
        <th width="15%">Fecha Reporte</th>
        <th width="5%">Sector</th>
        <th width="65%">Equipo</th>
        <th width="10%"></th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
    <?php foreach ($lista as $lt) { ?>

          <?php if($lt->esSolucionadoDetalleParte=='SI'){ ?>
            <?php $color = '#ffffff'; $verComision = "hidden"; ?>
          <?php }else{ ?>
            <?php $color = '#f9cdd0'; $verComision = "visible"; ?>
          <?php } ?>          
      
      <tr style="background-color: <?php echo $color; ?>;">
        <td><?php echo $i; $i++; ?></td>
        <td><?php echo $lt->fechaFalloDetalleParte; ?></td>
        <td><?php echo $lt->nombreSector; ?></td>
        <td><?php echo $lt->nombreTipoExistencia; ?></td>
        <td>
         <button type="button" class="btn btn-info btn-sm" onclick="gestionRegistroDetalleParte(this);"  data-accion="editarRegistro" data-id="<?php echo $lt->idDetalleParte;?>" <?php echo $status; ?>><i class="fas fa-pencil-alt"></i></button> 
         <button type="button" class="btn btn-danger btn-sm" onclick="gestionRegistroDetalleParte(this);"  data-accion="eliminarRegistro" data-id="<?php echo $lt->idDetalleParte;?>" <?php echo $status; ?>><i class="fas fa-trash-alt"></i></button> 
        </td>
      </tr>
    <?php } ?>            
    </tbody>
    <tfoot>
      <tr>
        <th>N</th>
        <th>Fecha Reporte</th>
        <th>Sector</th>
        <th>Equipo</th>
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