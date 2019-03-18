<div class="table-responsive">
<?php if($lista){ ?>
  <table id="tablaCronos" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th width="5%">N</th>
        <th width="30%">Categoría</th>
        <th width="50%">Menú</th>
        <th width="15%">Escritura</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1; ?>
    <?php foreach ($lista as $lt) { ?>
      <tr>
        <td><?php echo $i; $i++; ?></td>
        <td><?php echo $lt->nombreCategoria; ?></td>
        <td><?php echo $lt->nombreMenu; ?></td>
        <td>
          <?php if($lt->lectura != ""){ ?>
            <?php $checked = "checked"; ?>
          <?php }else{ ?>
            <?php $checked = ""; ?>
          <?php } ?>
          <input class="switch" data-toggle="toggle" type="checkbox" data-on="r" data-off="" data-size="small" data-onstyle="primary" data-offstyle="warning" onchange="editarPrivilegios(this);" <?php echo $checked; ?> data-idperfil="<?php echo $lt->idPerfil; ?>" data-idmenu="<?php echo $lt->idMenu; ?>" data-id="<?php echo $lt->idPerfilMenu; ?>" data-atributo="lectura" <?php echo $status; ?>>
        </td>
        <td>
          <?php if($lt->escritura != ""){ ?>
            <?php $checked = "checked"; ?>
          <?php }else{ ?>
            <?php $checked = ""; ?>
          <?php } ?>
          <input class="switch" data-toggle="toggle" type="checkbox" data-on="w" data-off="" data-size="small" data-onstyle="primary" data-offstyle="warning" onchange="editarPrivilegios(this);" <?php echo $checked; ?> data-idperfil="<?php echo $lt->idPerfil; ?>" data-idmenu="<?php echo $lt->idMenu; ?>" data-id="<?php echo $lt->idPerfilMenu; ?>" data-atributo="escritura" <?php echo $status; ?>>
        </td>
        <td>
          <button type="button" class="btn btn-danger btn-sm" onclick="eliminarRegistro(this);" data-toggle="tooltip" data-placement="left" title="Eliminar Registro" data-accion="eliminarRegistro" data-id="<?php echo $lt->idPerfilMenu; ?>" <?php echo $status; ?>><i class="fa fa-trash-o"></i>
        </td>
      </tr>
    <?php } ?>            
    </tbody>
    <tfoot>
      <tr>
        <th>N</th>
        <th>Categoría</th>
        <th>Menú</th>
        <th>Lectura</th>
        <th>Escritura</th>
      </tr>
    </tfoot>
  </table>
<?php }else{ ?>
  <div class="alert alert-danger">
    <b>No se encontraton datos</b>
  </div>
<?php } ?>

</div>

