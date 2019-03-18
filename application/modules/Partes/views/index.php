<script type="text/javascript">
  $("#<?php echo $codigoCategoriaMenu; ?>").addClass('active');
  $("#<?php echo $codigoMenu; ?>").addClass('active');
</script>

        <div class="my-3 my-md-5">
          <div class="container">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><?php echo $menuNombre; ?></h3>
                <div class="card-options">
                  <button type="button" id="btngestionRegistro" class="btn btn-success bnt-sm" onclick="gestionRegistro(this);" data-titulo="<b><i class='fa fa-file'></i> Nuevo Registro</b>" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nuevo Parte</button>
                </div>
              </div>
              <div id="listadoDatos" class="card-body"></div>
            </div>
          </div>
        </div>
      </div>
    </div>


<script type="text/javascript">

  listarDatos();

  function listarDatos(){
    cargarGif();
    var urlCode = "<?php echo $urlCode; ?>";
      $("#listadoDatos").load("<?php echo site_url('Partes/lista'); ?>",{urlCode}, function(responseText, statusText, xhr){
        if(statusText == "success"){
          cerrarGif();
        }
        if(statusText == "error"){
          swal("Información!", "No se pudo cargar listado de Partes Diarios", "info"); 
          cerrarGif();
        }
      });
  }

</script>