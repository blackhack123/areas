<div class="table-responsive">
<?php if($lista){ ?>
  <table id="tablaCronos" class="table table-bordered table-striped tablaCronos">
    <thead>
      <tr>
        <th width="5%">N</th>
        <th width="25%">CAE</th>
        <th width="15%">Estacion</th>
        <th width="20%">Equipo</th>
        <th width="15%">Fecha</th>
        <th width="5%">Dias</th>
        <th width="5%">
          <center><input type="checkbox" id="selectAll"></center>
        </th>
        <th width="10%">
          <button type="button" class="btn btn-success btn-sm" onclick="autorizarComisionLote();" <?php echo $auth; ?>><i class="fe fe-check-square"></i> Autorizar</button>
        </th>
      </tr>
    </thead>
    <tbody>
    <form name="formTablaComision">
      <?php $i=1; ?>
      <?php foreach ($lista as $lt) { ?>
        <tr>
          <td><?php echo $i; $i++; ?></td>
          <td><?php echo $lt->nombreCae; ?></td>
          <td><?php echo $lt->nombreEstacion; ?></td>
          <td><?php echo $lt->nombreTipoExistencia; ?></td>
          <td><?php echo $lt->fechaCreacionComision; ?></td>
          <td><?php echo contarDiasFechas($lt->fechaInicioComision, $lt->fechaFinComision); ?></td>
          <td>
            <center><input type="checkbox" class="case" name="case[]" value="<?php echo $lt->idComision; ?>"></center>
          </td>
          <td>
            <button type="button" class="btn btn-warning btn-sm" onclick="autorizarCominIndividual(this);" data-id="<?php echo $lt->idComision; ?>" <?php echo $auth; ?>><i class="fe fe-check"></i> Autorizar</button>
          </td>
        </tr>
      <?php } ?>            
    </form>
    </tbody>
    <tfoot>
      <tr>
        <th>N</th>
        <th>CAE</th>
        <th>Estacion</th>
        <th>Existencia</th>
        <th>Fecha</th>
        <th>Dias</th>
        <th></th>
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

<script type="text/javascript">

$("#selectAll").on("click", function() {
    $(".case").attr("checked", this.checked);
});


function autorizarComisionLote(){

}

</script>