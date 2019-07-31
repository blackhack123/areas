<script type="text/javascript">
    $("#tituloPagina").text("<?php echo $tituloPagina; ?>");
    $("#btnGestionRegistro").hide();
    $("#divGestionMenu").show();
    $("#btnVolverPerfiles").show();  
</script>

<div class="table-responsive">
<?php if($lista){ ?>
  <table id="tablaCronos" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th width="5%">N</th>
        <th width="25%">Categoría</th>
        <th width="45%">Menú</th>
        <th width="10%">Autorización</th>
        <th width="10%">Escritura</th>
        <th width="10%">Envío</th>
        <th width="5%"></th>
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
          <?php if($lt->autorizacion != ""){ ?>
            <?php $checked = "checked"; ?>
          <?php }else{ ?>
            <?php $checked = ""; ?>
          <?php } ?>
          <input class="switch" data-toggle="toggle" type="checkbox" data-on="a" data-off="" data-size="small" data-onstyle="primary" data-offstyle="warning" onchange="editarPrivilegios(this);" <?php echo $checked; ?> data-idperfil="<?php echo $lt->idPerfil; ?>" data-idmenu="<?php echo $lt->idMenu; ?>" data-id="<?php echo $lt->idPerfilMenu; ?>" data-atributo="autorizacion" <?php echo $status; ?>>
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
          <?php if($lt->envio != ""){ ?>
            <?php $checked = "checked"; ?>
          <?php }else{ ?>
            <?php $checked = ""; ?>
          <?php } ?>
          <input class="switch" data-toggle="toggle" type="checkbox" data-on="s" data-off="" data-size="small" data-onstyle="primary" data-offstyle="warning" onchange="editarPrivilegios(this);" <?php echo $checked; ?> data-idperfil="<?php echo $lt->idPerfil; ?>" data-idmenu="<?php echo $lt->idMenu; ?>" data-id="<?php echo $lt->idPerfilMenu; ?>" data-atributo="envio" <?php echo $status; ?>>
        </td>        
        <td>
          <button type="button" class="btn btn-danger btn-sm" onclick="eliminarMenuDePerfil(this);" data-toggle="tooltip" data-placement="left" title="Eliminar Registro" data-accion="eliminarRegistro" data-id="<?php echo $lt->idPerfilMenu; ?>" data-idperfil="<?php echo $idPerfil; ?>" <?php echo $status; ?>><i class="fas fa-trash-alt"></i>
        </td>
      </tr>
    <?php } ?>            
    </tbody>
    <tfoot>
      <tr>
        <th>N</th>
        <th>Categoría</th>
        <th>Menú</th>
        <th>Autorización</th>
        <th>Escritura</th>
        <th>Envío</th>
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

<script type="text/javascript">

buscarMenusDisponibles();
$("#idPerfil").val("<?php echo $idPerfil; ?>");

function buscarMenusDisponibles(){
  cargarGif();
  var idPerfil = "<?php echo $idPerfil; ?>";
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('PerfilesMenus/buscarMenusDisponiblesParaPerfil'); ?>",
      dataType: 'json',
      data: {
        idPerfil   : idPerfil,
      },
    }).done( function(data) {
      $('#idMenu').find('option').remove();
      $(data).each(function(i, v){
        $('#idMenu').append('<option value="'+ v.idMenu +'">' + v.nombreMenu+ '</option');
      });
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      cerrarGif();
    });  
}  

</script>