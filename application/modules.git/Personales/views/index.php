
<script type="text/javascript">
  $("#<?php echo $codigoCategoriaMenu; ?>").addClass('active');
  $("#<?php echo $codigoMenu; ?>").addClass('active');
</script>

        <div class="my-3 my-md-5">
          <div class="container">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title" id="tituloPagina"></h3>
                <div class="card-options">
                  <button type="button" id="btnGestionRegistroPersonal" class="btn btn-success bnt-sm" onclick="gestionRegistro(this);" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nuevo Registro</button>
                  <!-- Formulario -->
                  <button type="button" id="btnGestionVolverPersonal" class="btn btn-danger bnt-sm" onclick="listarDatos();" data-accion="volverPersonal" <?php echo $status; ?>><i class="fe fe-log-out"></i> Personal</button>
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
    $("#tituloPagina").text("<?php echo $menuNombre; ?>");
    $("#btnGestionRegistroPersonal").show();
    $("#btnGestionVolverPersonal").hide();
    cargarGif();
    var urlCode = "<?php echo $urlCode; ?>";
      $("#listadoDatos").load("<?php echo site_url('Personales/lista'); ?>",{urlCode}, function(responseText, statusText, xhr){
        if(statusText == "success"){
          cerrarGif();
        }
        if(statusText == "error"){
          swal("Información!", "No se pudo cargar listado de Personales", "info"); 
          cerrarGif();
        }
      });
  }

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

function gestionRegistro(aObject){
  
  switch($(aObject).data('accion')){
    case 'insertarRegistro':
        formularioPersonal($(aObject).data('id'));
    break;
    case 'editarRegistro':
        formularioPersonal($(aObject).data('id'));
    break;
    case 'eliminarRegistro':
       
        swal({
          title: 'Desea eliminar?',
          text: "Los datos se perderán!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
          if (result.value) {
            
                $.ajax({
                  type : 'post',
                  url  : "<?php echo site_url('Personales/eliminarRegistro'); ?>",
                  dataType: 'json',
                  data: {
                        idPersonal   : $(aObject).data('id'),
                      }
                })  
                .done(function(data){
                  if(data){
                    $().toastmessage('showSuccessToast', "Registro eliminado");
                  }else{
                    $().toastmessage('showErrorToast', "No se pudo eliminar la información (registros enlazados)");
                  }
                })
                .fail(function(){
                  $().toastmessage('showErrorToast', "Error: No se pudo eliminar la información");
                })   
                .always(function(){
                  cerrarGif();
                  listarDatos();
                });

          }
        })

    break;
    default:      
    break;
  }
}


</script>