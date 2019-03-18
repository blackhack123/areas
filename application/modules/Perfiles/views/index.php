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
                  <button type="button" id="btngestionRegistro" class="btn btn-success bnt-sm" onclick="gestionRegistro(this);" data-titulo="<b><i class='fa fa-file'></i> Nuevo Registro</b>" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nuevo Registro</button>
                </div>
              </div>
            </div>
            <div id="listadoDatos" class="box-body">
            </div>
          </div>
        </div>
      </div>
    </div>


  <!-- Modal -->
<div id="modalFormulario" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloModal"></h4>
        

      </div>
     <form id="formPerfil"  method="post" class="animate-form" >
      <input name="idPerfil" id="idPerfil" type="hidden" value="">
      <div class="modal-body">
        
        <div class="row">
          <div class="col-sm-9">
            <label for="nombrePerfil">Nombre: <span class="kv-reqd">*</span></label>
              <input type="text" name="nombrePerfil" id="nombrePerfil" class="form-control">
          </div>
          <div class="col-sm-3">
            <label for="skinPerfil">Color: <span class="kv-reqd">*</span></label>
              <select class="form-control" name="skinPerfil" id="skinPerfil">
                <option value="blue" class="azul"><span class="azul"></span>Azul</option>
                <option value="black" class="negro"><div class="negro"></div>Negro</option>
                <option value="purple" class="purpura"></option>
                <option value="yellow" class="amarillo">amarillo</option>
                <option value="red" class="rojo"></option>
                <option value="green" class="verde"></option>
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
 
 listarDatos();

 function listarDatos(){
    cargarGif();
    var urlCode = "<?php echo $urlCode; ?>";
      $("#listadoDatos").load("<?php echo site_url('Perfiles/lista'); ?>",{urlCode}, function(responseText, statusText, xhr){
        if(statusText == "success"){
          cerrarGif();
        }
        if(statusText == "error"){
          swal("Información!", "No se pudo cargar listado de Perfiles", "info"); 
          cerrarGif();
        }
      });
 }


function gestionRegistro(aObject){
  switch($(aObject).data('accion')){
    case 'insertarRegistro':
        $("#formPerfil")[0].reset();
        $("#idPerfil").val("");
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
                  url  : "<?php echo site_url('Perfiles/eliminarRegistro'); ?>",
                  dataType: 'json',
                  data: {
                        idPerfil   : $(aObject).data('id'),
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
                  //$("#modalFormulario").modal('hide');
                  cerrarGif();
                  listarDatos();
                });

          }
        })

    break;
    case 'cancelarRegistro':
      swal({
        title: "Desea cancelar?",
        text: "Los datos se perderán!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, cancelar!",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false
      },
      function(){
          swal("Cancelado!", "Se ha cancelado la Inscripción.", "success");
          $(aObject).text('Inscribir')
          $(aObject).removeClass("btn-danger").addClass("btn-info");
          $(aObject).data('accion', 'insertarRegistro');
        listarDatos();
      });       
    break;
  }
}

$(document).ready(function() {

 $('#formPerfil').validate({
  rules: {
   nombrePerfil: {
    required: true
   },
   skinPerfil: {
    required: true
   }
  },
  messages: {
   nombrePerfil: {
    required: "Ingrese un nombre del perfil"
   },
   skinPerfil: {
    required: "Ingrse un color"
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
   $.post("<?php echo site_url('Perfiles/gestionRegistro')?>", $("#formPerfil").serialize())
     .done(function(data){
                         if(data){
                                data = data.replace('"','');
                                var row = data.split('|');
                                switch(row[0]){
                                    case 'i':
                                      //$('#idParaleloMateriaProfesor').val(row[1]);   
                                      //swal("Exitoso!", "Registro creado exitosamente", "success"); 
                                      $().toastmessage('showSuccessToast', "Registro creado exitosamente");
                                    break;
                                    case 'e':
                                      //swal("Exitoso!", "Editado exitosamente", "success"); 
                                      $().toastmessage('showSuccessToast', "Editado exitosamente");
                                      $("#formPerfil")[0].reset();
                                    break;
                                }
                           //listarDatos();     
                           }else{
                                //swal("Información!", "No se pudo procesar la información", "info"); 
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
       $("#formCategoriaMenu").find('.error').removeClass("error");
       $("#formCategoriaMenu").find('.success').removeClass("success");
       $("#formCategoriaMenu").find('.valid').removeClass("valid");
     });
  }
 });
}); // end document.ready

function editarRegistro(aId){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('Perfiles/buscarPerfilPorID'); ?>",
      dataType: 'json',
      data: {
        idPerfil   : aId,
      },
    }).done( function(data) {
      $(data).each(function(i, v){
        $("#idPerfil").val(v.idPerfil);
        $("#nombrePerfil").val(v.nombrePerfil);
        $("#skinPerfil").val(v.skinPerfil);
      });              
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });
}

  
</script>


