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
                  <button type="button" id="btngestionRegistroEstadoCivil" class="btn btn-success bnt-sm" onclick="gestionRegistro(this);" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nuevo Registro</button>
                </div>
              </div>
              <div id="listadoDatos" class="card-body"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

<!-- Modal EstadoCivil-->
<div id="modalFormulario" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloModal"></h4>
      </div>
     <form id="formEstadoCivil"  method="post" class="animate-form" >
      <input name="idEstadoCivil" id="idEstadoCivil" type="hidden" value="">
      <div class="modal-body">
        
      <div class="row">
        <div class="form-group col-sm-12">
          <label class="form-label">Nombre del Estado Civil: </label>
          <input type="text" class="form-control" name="nombreEstadoCivil" id="nombreEstadoCivil" placeholder="" >
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

  listarDatos();

  function listarDatos(){
 
  $("#tituloPagina").text("<?php echo $menuNombre; ?>");

    cargarGif();
    var urlCode = "<?php echo $urlCode; ?>";
      $("#listadoDatos").load("<?php echo site_url('EstadosCiviles/lista'); ?>",{urlCode}, function(responseText, statusText, xhr){
        if(statusText == "success"){
          cerrarGif();
        }
        if(statusText == "error"){
          swal("Información!", "No se pudo cargar listado de Estados Civiles", "info"); 
          cerrarGif();
        }
      });
  }

function gestionRegistro(aObject){
  switch($(aObject).data('accion')){
    case 'insertarRegistro':
        $("#formEstadoCivil")[0].reset();
        $("#idEstadoCivil").val("");
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
                  url  : "<?php echo site_url('EstadosCiviles/eliminarRegistro'); ?>",
                  dataType: 'json',
                  data: {
                        idEstadoCivil   : $(aObject).data('id'),
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

$(document).ready(function() {

 $('#formEstadoCivil').validate({
  rules: {
   nombreEstadoCivil: {
    required: true
   }
  },
  messages: {
   nombreEstadoCivil: {
    required: "Ingrese un nombre del EstadoCivil"
   }
  },
  highlight: function(element) {
   $(element).closest('.row').removeClass('success').addClass('error');
  },
  success: function(element) {
  // element.text('OK!').addClass('valid').closest('.row').removeClass('error').addClass('success');
   element.addClass('valid').closest('.row').removeClass('error').addClass('success');
  },
  submitHandler: function(form) {
   // do other stuff for a valid form
   $.post("<?php echo site_url('EstadosCiviles/gestionRegistro')?>", $("#formEstadoCivil").serialize())
    .done(function(data){
      if(data){
        data = data.replace('"','');
        var row = data.split('|');
        switch(row[0]){
          case 'i':
            $().toastmessage('showSuccessToast', "Registro creado exitosamente");
          break;
          case 'e':
            $().toastmessage('showSuccessToast', "Editado exitosamente");
            $("#formEstadoCivil")[0].reset();
          break;
        }
      }else{
        $().toastmessage('showErrorToast', "No se pudo procesar la información");
      }
     })
     .fail(function(err){
        //swal("Información!", "Error: No se pudo procesar la información", "warning"); 
        $().toastmessage('showErrorToast', "Error: No se pudo procesar la información");
     })
     .always(function(){
      listarDatos();
       $("#modalFormulario").modal('hide');
       $("#formEstadoCivil").find('.error').removeClass("error");
       $("#formEstadoCivil").find('.success').removeClass("success");
       $("#formEstadoCivil").find('.valid').removeClass("valid");
     });
  }
 });
}); // end document.ready

function editarRegistro(aId){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('EstadosCiviles/buscarRegistroPorID'); ?>",
      dataType: 'json',
      data: {
        idEstadoCivil   : aId,
      },
    }).done( function(data) {
      $(data).each(function(i, v){
        $("#idEstadoCivil").val(v.idEstadoCivil);
        $("#nombreEstadoCivil").val(v.nombreEstadoCivil);
      });              
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });
}


</script>