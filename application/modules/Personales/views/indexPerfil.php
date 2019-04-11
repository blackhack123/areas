
<script type="text/javascript">
  $("#<?php echo $codigoCategoriaMenu; ?>").addClass('active');
  $("#<?php echo $codigoMenu; ?>").addClass('active');
</script>

        <div class="my-3 my-md-5">
          <div class="container">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title" id="tituloPagina"></h3>
              </div>
              <div id="listadoDatos" class="card-body"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

<script type="text/javascript">

  $("#tituloPagina").text("<?php echo $menuNombre; ?>");

  //formularioPersonal();
  var idPersonal = "<?php echo $this->session->userdata("idPersonal"); ?>";
  formularioPersonal(idPersonal);

  function formularioPersonal(idPersonal){
    cargarGif();
    
    var urlCode = "<?php echo $urlCode; ?>";
      $("#listadoDatos").load("<?php echo site_url('Personales/formulario'); ?>",{urlCode, idPersonal}, function(responseText, statusText, xhr){
        if(statusText == "success"){
          cerrarGif();
        }
        if(statusText == "error"){
          swal("Información!", "No se pudo cargar el formulario", "info"); 
          cerrarGif();
        }
      });
  }

</script>