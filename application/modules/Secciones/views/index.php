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
                  <!-- Sección -->
                  <button type="button" id="btnGestionRegistroSeccion" class="btn btn-success bnt-sm" onclick="gestionRegistroSeccion(this);" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nueva Sección</button>
                  <!-- Sistema -->
                  <button type="button" id="btnGestionRegistroSistema" class="btn btn-success bnt-sm" onclick="gestionRegistroSistema(this);" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nuevo Sistema</button>
                  <button type="button" id="btnGestionVolverSeccion" class="btn btn-danger bnt-sm" onclick="listarDatosSeccion();" data-accion="volverSeccion" <?php echo $status; ?>><i class="fe fe-log-out"></i> Secciones</button>

                </div>
              </div>
              <div id="listadoDatos" class="card-body"></div>
            </div>
          </div>
        </div>
      </div>
    </div>


<!-- Modal Sección-->
<div id="modalFormularioSeccion" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloModalSeccion"></h4>
        

      </div>
     <form id="formSeccion"  method="post" class="animate-form" >
      <input name="idSeccion" id="idSeccion" type="hidden" value="">
      <div class="modal-body">
        
      <div class="row">
        <div class="form-group col-sm-12">
          <label class="form-label">Nombre de la Sección: </label>
          <input type="text" class="form-control" name="nombreSeccion" id="nombreSeccion" placeholder="" >
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


<!-- Modal Sistema -->
<div id="modalFormularioSistema" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloModalSistema"></h4>
        

      </div>
     <form id="formSistema"  method="post" class="animate-form" >
      <input name="idSistema" id="idSistema" type="hidden" value="">
      <input name="idSeccionSistema" id="idSeccionSistema" type="hidden" value="">
      <div class="modal-body">
        
      <div class="row">
        <div class="form-group col-sm-12">
          <label class="form-label">Nombre del Sistema: </label>
          <input type="text" class="form-control" name="nombreSistema" id="nombreSistema" placeholder="" >
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

  listarDatosSeccion();


//=================== Secciones ======================//


function listarDatosSeccion(){
  cargarGif();

  $("#tituloPagina").text("<?php echo $menuNombre; ?>");
  $("#btnGestionRegistroSeccion").show();
  $("#btnGestionRegistroSistema").hide();
  $("#btnGestionVolverSeccion").hide();

  var urlCode = "<?php echo $urlCode; ?>";
  //alert(idEstacion);
  $("#listadoDatos").load("<?php echo site_url('Secciones/lista'); ?>",{urlCode}, function(responseText, statusText, xhr){
      if(statusText == "success"){
        cerrarGif();
      }
      if(statusText == "error"){
        swal("Información!", "No se pudo cargar listado de Secciones", "info"); 
        cerrarGif();
      }
  });  
}


function gestionRegistroSeccion(aObject){
  switch($(aObject).data('accion')){
    case 'insertarRegistro':
        $("#formSeccion")[0].reset();
        $("#idSeccion").val("");
        $("#modalFormularioSeccion").modal('show');
        $("#tituloModalSeccion").text("Nuevo Registro");
    break;
    case 'editarRegistro':
        $("#modalFormularioSeccion").modal('show');
        $("#tituloModalSeccion").text("Editar Registro");
        editarRegistroSeccion($(aObject).data('id'));
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
                  url  : "<?php echo site_url('Secciones/eliminarRegistro'); ?>",
                  dataType: 'json',
                  data: {
                        idSeccion   : $(aObject).data('id'),
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
                  listarDatosSeccion($("#idEstacionSeccion").val());
                });

          }
        })

    break;
    default:      
    break;
  }
}

$(document).ready(function() {

 $('#formSeccion').validate({
  rules: {
   nombreSeccion: {
    required: true
   }
  },
  messages: {
   nombreSeccion: {
    required: "Ingrese un nombre para la Sección"
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
   $.post("<?php echo site_url('Secciones/gestionRegistro')?>", $("#formSeccion").serialize())
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
            $("#formSeccion")[0].reset();
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
       listarDatosSeccion($("#idEstacionSeccion").val());
       $("#modalFormularioSeccion").modal('hide');
       $("#formSeccion").find('.error').removeClass("error");
       $("#formSeccion").find('.success').removeClass("success");
       $("#formSeccion").find('.valid').removeClass("valid");
     });
  }
 });
}); // end document.ready

function editarRegistroSeccion(aId){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('Secciones/buscarRegistroPorID'); ?>",
      dataType: 'json',
      data: {
        idSeccion   : aId,
      },
    }).done( function(data) {
      $(data).each(function(i, v){
        $("#idSeccion").val(v.idSeccion);
        $("#nombreSeccion").val(v.nombreSeccion);
      });              
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });
}


//=================== Sistemas ======================//

function gestionSistemas(aObject){
  var idSeccion = $(aObject).data("id");
  listarDatosSistema(idSeccion);
} 

function listarDatosSistema(idSeccion){
  cargarGif();
  var urlCode = "<?php echo $urlCode; ?>";
  var idCae = $("#idCaeSeccion").val();
  //alert(idCae);
  $("#listadoDatos").load("<?php echo site_url('Sistemas/lista'); ?>",{urlCode, idSeccion, idCae}, function(responseText, statusText, xhr){
      if(statusText == "success"){
        cerrarGif();
      }
      if(statusText == "error"){
        swal("Información!", "No se pudo cargar listado de Secciones", "info"); 
        cerrarGif();
      }
  });  
}


function gestionRegistroSistema(aObject){
  switch($(aObject).data('accion')){
    case 'insertarRegistro':
        $("#formSistema")[0].reset();
        $("#idSistema").val("");
        $("#modalFormularioSistema").modal('show');
        $("#tituloModalSistema").text("Nuevo Registro");
    break;
    case 'editarRegistro':
        $("#modalFormularioSistema").modal('show');
        $("#tituloModalSistema").text("Editar Registro");
        editarRegistroSistema($(aObject).data('id'));
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
                  url  : "<?php echo site_url('Sistemas/eliminarRegistro'); ?>",
                  dataType: 'json',
                  data: {
                        idSistema   : $(aObject).data('id'),
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
                  listarDatosSistema($("#idSeccionSistema").val());
                });

          }
        })

    break;
    default:      
    break;
  }
}

$(document).ready(function() {

 $('#formSistema').validate({
  rules: {
   nombreSistema: {
    required: true
   }
  },
  messages: {
   nombreSistema: {
    required: "Ingrese un nombre para el Sistema"
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
   $.post("<?php echo site_url('Sistemas/gestionRegistro')?>", $("#formSistema").serialize())
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
            $("#formSistema")[0].reset();
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
       listarDatosSistema($("#idSeccionSistema").val());
       $("#modalFormularioSistema").modal('hide');
       $("#formSistema").find('.error').removeClass("error");
       $("#formSistema").find('.success').removeClass("success");
       $("#formSistema").find('.valid').removeClass("valid");
     });
  }
 });
}); // end document.ready

function editarRegistroSistema(aId){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('Sistemas/buscarRegistroPorID'); ?>",
      dataType: 'json',
      data: {
        idSistema   : aId,
      },
    }).done( function(data) {
      $(data).each(function(i, v){
        $("#idSistema").val(v.idSistema);
        $("#nombreSistema").val(v.nombreSistema);
      });              
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });
}

</script>