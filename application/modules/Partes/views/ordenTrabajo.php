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
                  <button type="button" id="btnGestionRegistroPersonal" class="btn btn-success bnt-sm" onclick="gestionRegistro(this);" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nueva Orden</button>
                  <!-- Formulario -->
                </div>
              </div>
      
              <div id="listadoDatos" class="card-body btn-parte"></div>
              <div id="listadoDatosDetalle" class="card-body"></div>
            </div>
          </div>
        </div>
      </div>
    </div>


<!-- Modal Pase-->
<div id="modalFormulario" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloModalPase"></h4>
        

      </div>
     <form id="formOrden"  method="post" class="animate-form" >
      <input name="idOrden" id="idOrden" type="hidden" value="">
      <div class="modal-body">
        
      <div class="row">
        <div class="form-group col-sm-6">
          <label class="form-label"> Origen: </label>
          <select name="origenParte" id="origenParte" class="form-control">
            <option value="">NA</option>
            <option value="parte">PARTE</option>
          </select>
        </div>                  
      </div>

      </div><!-- Fin modal body -->
      <div class="modal-footer">
        <button type="submit" id="botonGuardar" class="btn btn-success">Guardar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
       </form>

    </div>

  </div>
</div>


<script type="text/javascript">
  
  listarOrdenTrabajo();
  
  function listarOrdenTrabajo(){
      cargarGif();
      var urlCode = "<?php echo $urlCode; ?>";
      $("#listadoDatos").load("<?php echo site_url('Partes/listaOrdenTrabajo'); ?>",{urlCode, idPersonal}, function(responseText, statusText, xhr){
        if(statusText == "success"){
          cerrarGif();
        }
        if(statusText == "error"){
          swal("Información!", "No se pudo cargar el historial de Ordenes", "info"); 
          cerrarGif();
        }
      });
  }

function gestionRegistro(aObject){
  
  switch($(aObject).data('accion')){
    case 'insertarRegistro':
        $("#formOrden")[0].reset();
        $("#idOrden").val("");
        $("#modalFormulario").modal('show');
        $("#tituloModal").text("Nuevo Registro");
    break;
    case 'editarRegistro':
        $("#modalFormulario").modal('show');
        $("#tituloModal").text("Editar Registro");
        editarRegistro($(aObject).data('id'));
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
                  url  : "<?php echo site_url('Pases/eliminarOrdenTrabajo'); ?>",
                  dataType: 'json',
                  data: {
                        idOrden   : $(aObject).data('id'),
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
                  listaPasePersonal($("#idPersonalPase").val());
                });

          }
        })

    break;
    default:      
    break;
  }
}

</script>    