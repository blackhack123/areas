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

                </div>
              </div>
      
              <div id="listadoDatos" class="card-body">


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


<script type="text/javascript">
 
 listarDatos();

 function listarDatos(){
    cargarGif();
    $("#tituloPagina").text("<?php echo $menuNombre; ?>");
    var urlCode = "<?php echo $urlCode; ?>";
      $("#listadoDatos").load("<?php echo site_url('Partes/listaPartesPendientes'); ?>",{urlCode}, function(responseText, statusText, xhr){
        if(statusText == "success"){
          cerrarGif();
        }
        if(statusText == "error"){
          swal("Información!", "No se pudo cargar listado de Partes Pendientes", "info"); 
          cerrarGif();
        }
      });
 }


  function autorizarParte(aObject){
    var idParte = $(aObject).data("idparte");
    if(idParte){
       Swal({
          title: 'Autorizar parte?',
          text: 'Se enviará el Parte para su ejecución',
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Si',
          cancelButtonText: 'No'
        }).then((result) => {
          if (result.value) {
              $.ajax({
                  type : 'post',
                  url  : "<?php echo site_url('Partes/autorizarParte'); ?>",
                  dataType: 'json',
                  data: {
                        idParte   : idParte
                      }
                })  
                .done(function(data){
                  if(data){
                    $().toastmessage('showSuccessToast', "Se ha autorizado el Parte correctamente");
                  }else{
                    $().toastmessage('showErrorToast', "Error al autorizar el Parte");
                  }
                })
                .fail(function(){
                  $().toastmessage('showErrorToast', "No se pudo procesar la información del Parte");
                })   
                .always(function(){
                	listarDatos();
                });       
          // For more information about handling dismissals please visit
          // https://sweetalert2.github.io/#handling-dismissals
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal(
              'Cancelado',
              'Envío cancelado :)',
              'error'
            )
          }
        })
    }else{
      swal("Información!", "Debe haber un Parte seleccionado", "error"); 
    } 
  }


</script>