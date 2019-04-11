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
                  <button type="button" id="btngestionRegistroCae" class="btn btn-success bnt-sm" onclick="gestionRegistro(this);" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nuevo Registro</button>
                  <!-- Tipos Existencias -->
                  <button type="button" id="btngestionRegistroTipoExistencia" class="btn btn-success bnt-sm" onclick="gestionRegistroTipoExistencia(this);" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nuevo Tipo Existencia</button>
                  <!-- Estación -->
                  <button type="button" id="btngestionRegistroEstacion" class="btn btn-success bnt-sm" onclick="gestionRegistroEstacion(this);" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nueva Estación</button>
                  <button type="button" id="btngestionVolverCae" class="btn btn-danger bnt-sm" onclick="listarDatos();" data-accion="volverCae" <?php echo $status; ?>><i class="fe fe-log-out"></i> CAEs</button>
                  <!-- Sección -->
                  <button type="button" id="btngestionRegistroSeccion" class="btn btn-success bnt-sm" onclick="gestionRegistroSeccion(this);" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nueva Sección</button>
                  <button type="button" id="btngestionVolverEstacion" class="btn btn-danger bnt-sm" onclick="listarDatosEstacionCae();" data-accion="volverEstacion" <?php echo $status; ?>><i class="fe fe-log-out"></i> Estaciones</button>
                  <!-- Sistema -->
                  <button type="button" id="btngestionRegistroSistema" class="btn btn-success bnt-sm" onclick="gestionRegistroSistema(this);" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nuevo Sistema</button>
                  <button type="button" id="btngestionVolverSeccion" class="btn btn-danger bnt-sm" onclick="listarDatosSeccionEstacion();" data-accion="volverSeccion" <?php echo $status; ?>><i class="fe fe-log-out"></i> Secciones</button>

                </div>
              </div>
              <div id="listadoDatos" class="card-body"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

<!-- Modal CAE-->
<div id="modalFormulario" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloModal"></h4>
        

      </div>
     <form id="formCae"  method="post" class="animate-form" >
      <input name="idCae" id="idCae" type="hidden" value="">
      <div class="modal-body">
        
      <div class="row">
        <div class="form-group col-sm-12">
          <label class="form-label">Nombre del CAE: </label>
          <input type="text" class="form-control" name="nombreCae" id="nombreCae" placeholder="" >
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

<!-- Modal Tipo de Existencia-->
<div id="modalFormularioTipoExistencia" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloModalTipoExistencia"></h4>
        

      </div>
     <form id="formTipoExistencia"  method="post" class="animate-form" >
      <input name="idTipoExistencia" id="idTipoExistencia" type="hidden" value="">
      <input name="idCaeTipoExistencia" id="idCaeTipoExistencia" type="hidden" value="">
      <div class="modal-body">
        
      <div class="row">
        <div class="form-group col-sm-4">
          <label class="form-label">Nombre: </label>
          <input type="text" class="form-control" name="nombreTipoExistencia" id="nombreTipoExistencia" placeholder="" >
        </div>                  
        <div class="form-group col-sm-8">
          <label class="form-label">Propiedad: </label>
          <input type="text" class="form-control" name="propiedadTipoExistencia" id="propiedadTipoExistencia" placeholder="" >
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


<!-- Modal Estación-->
<div id="modalFormularioEstacion" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloModalEstacion"></h4>
        

      </div>
     <form id="formEstacion"  method="post" class="animate-form" >
      <input name="idEstacion" id="idEstacion" type="hidden" value="">
      <input name="idCaeEstacion" id="idCaeEstacion" type="hidden" value="">
      <div class="modal-body">
        
      <div class="row">
        <div class="form-group col-sm-4">
          <label class="form-label">Nominativo: </label>
          <input type="text" class="form-control" name="nominativoEstacion" id="nominativoEstacion" placeholder="" >
        </div>                  
        <div class="form-group col-sm-8">
          <label class="form-label">Nombre de la Estación: </label>
          <input type="text" class="form-control" name="nombreEstacion" id="nombreEstacion" placeholder="" >
        </div>                  
      </div>

      <div class="row">
        <div class="form-group col-sm-12">
          <label class="form-label">Dirección: </label>
          <input type="text" class="form-control" name="direccionEstacion" id="direccionEstacion" placeholder="" >
        </div>                  
      </div>

      <div class="row">
        <div class="form-group col-sm-6">
          <label class="form-label">Teléfono Fijo: </label>
          <input type="text" class="form-control" name="telefonoFijoEstacion" id="telefonoFijoEstacion" placeholder="" >
        </div>                  
        <div class="form-group col-sm-6">
          <label class="form-label">Teléfono Móvil: </label>
          <input type="text" class="form-control" name="telefonoMovilEstacion" id="telefonoMovilEstacion" placeholder="" >
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
      <input name="idEstacionSeccion" id="idEstacionSeccion" type="hidden" value="">
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

  listarDatos();

  function listarDatos(){
 
  $("#tituloPagina").text("<?php echo $menuNombre; ?>");
  $("#btngestionRegistroCae").show();
  $("#btngestionRegistroTipoExistencia").hide();
  $("#btngestionRegistroEstacion").hide();
  $("#btngestionVolverCae").hide();
  $("#btngestionRegistroSeccion").hide();
  $("#btngestionVolverEstacion").hide();
  $("#btngestionRegistroSistema").hide();
  $("#btngestionVolverSeccion").hide();

    cargarGif();
    var urlCode = "<?php echo $urlCode; ?>";
      $("#listadoDatos").load("<?php echo site_url('Caes/lista'); ?>",{urlCode}, function(responseText, statusText, xhr){
        if(statusText == "success"){
          cerrarGif();
        }
        if(statusText == "error"){
          swal("Información!", "No se pudo cargar listado de Categorías de Menú", "info"); 
          cerrarGif();
        }
      });
  }

function gestionRegistro(aObject){
  switch($(aObject).data('accion')){
    case 'insertarRegistro':
        $("#formCae")[0].reset();
        $("#idCae").val("");
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
                  url  : "<?php echo site_url('Caes/eliminarRegistro'); ?>",
                  dataType: 'json',
                  data: {
                        idCae   : $(aObject).data('id'),
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

 $('#formCae').validate({
  rules: {
   nombreCae: {
    required: true
   }
  },
  messages: {
   nombreCae: {
    required: "Ingrese un nombre del CAE"
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
   $.post("<?php echo site_url('Caes/gestionRegistro')?>", $("#formCae").serialize())
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
            $("#formCae")[0].reset();
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
       $("#formCae").find('.error').removeClass("error");
       $("#formCae").find('.success').removeClass("success");
       $("#formCae").find('.valid').removeClass("valid");
     });
  }
 });
}); // end document.ready

function editarRegistro(aId){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('Caes/buscarRegistroPorID'); ?>",
      dataType: 'json',
      data: {
        idCae   : aId,
      },
    }).done( function(data) {
      $(data).each(function(i, v){
        $("#idCae").val(v.idCae);
        $("#nombreCae").val(v.nombreCae);
      });              
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });
}

//=================== Tipos Existencias ======================//

function gestionTiposExistencias(aObject){
  var idCae = $(aObject).data("id");
  listarDatosTiposExistecias(idCae);
} 

function listarDatosTiposExistenciasCae(){
  var idCae = $("#idCaeTipoExistencia").val();
  //alert(idCae);
  listarDatosTiposExistecias(idCae);  
}

function listarDatosTiposExistecias(idCae){
  cargarGif();
  var urlCode = "<?php echo $urlCode; ?>";
  //alert(idCae);
  $("#listadoDatos").load("<?php echo site_url('TiposExistencias/lista'); ?>",{urlCode, idCae}, function(responseText, statusText, xhr){
      if(statusText == "success"){
        cerrarGif();
      }
      if(statusText == "error"){
        swal("Información!", "No se pudo cargar listado de Existencias", "info"); 
        cerrarGif();
      }
  });  
}


function gestionRegistroTipoExistencia(aObject){
  switch($(aObject).data('accion')){
    case 'insertarRegistro':
        $("#formTipoExistencia")[0].reset();
        $("#idTipoExistencia").val("");
        $("#modalFormularioTipoExistencia").modal('show');
        $("#tituloModalTipoExistencia").text("Nuevo Registro");
    break;
    case 'editarRegistro':
        $("#modalFormularioTipoExistencia").modal('show');
        $("#tituloModalTipoExistencia").text("Editar Registro");
        editarRegistroTipoExistencia($(aObject).data('id'));
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
                  url  : "<?php echo site_url('TiposExistencias/eliminarRegistro'); ?>",
                  dataType: 'json',
                  data: {
                        idTipoExistencia  : $(aObject).data('id'),
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
                  listarDatosTiposExistecias($("#idCaeTipoExistencia").val());
                });

          }
        })

    break;
    default:      
    break;
  }
}

$(document).ready(function() {

 $('#formTipoExistencia').validate({
  rules: {
   nombreTipoExistencia: {
    required: true
   },
   propiedadTipoExistencia: {
    required: true
   }
  },
  messages: {
   nombreTipoExistencia: {
    required: "Ingrese un nombre válido"
   },
   propiedadTipoExistencia: {
    required: "Ingrese una propiedad"
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
   $.post("<?php echo site_url('TiposExistencias/gestionRegistro')?>", $("#formTipoExistencia").serialize())
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
       listarDatosTiposExistecias($("#idCaeTipoExistencia").val());
       $("#modalFormularioTipoExistencia").modal('hide');
       $("#formTipoExistencia").find('.error').removeClass("error");
       $("#formTipoExistencia").find('.success').removeClass("success");
       $("#formTipoExistencia").find('.valid').removeClass("valid");
     });
  }
 });
}); // end document.ready

function editarRegistroTipoExistencia(aId){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('TiposExistencias/buscarRegistroPorID'); ?>",
      dataType: 'json',
      data: {
        idTipoExistencia   : aId,
      },
    }).done( function(data) {
      $(data).each(function(i, v){
        $("#idTipoExistencia").val(v.idTipoExistencia);
        $("#nombreTipoExistencia").val(v.nombreTipoExistencia);
        $("#propiedadTipoExistencia").val(v.propiedadTipoExistencia);
      });              
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });
}


//=================== Estaciones ======================//

function gestionEstaciones(aObject){
  var idCae = $(aObject).data("id");
  listarDatosEstacion(idCae);
} 

function listarDatosEstacionCae(){
  var idCae = $("#idCaeEstacion").val();
  //alert(idCae);
  listarDatosEstacion(idCae);  
}

function listarDatosEstacion(idCae){
  cargarGif();
  var urlCode = "<?php echo $urlCode; ?>";
  //alert(idCae);
  $("#listadoDatos").load("<?php echo site_url('Estaciones/lista'); ?>",{urlCode, idCae}, function(responseText, statusText, xhr){
      if(statusText == "success"){
        cerrarGif();
      }
      if(statusText == "error"){
        swal("Información!", "No se pudo cargar listado de Estaciones", "info"); 
        cerrarGif();
      }
  });  
}


function gestionRegistroEstacion(aObject){
  switch($(aObject).data('accion')){
    case 'insertarRegistro':
        $("#formEstacion")[0].reset();
        $("#idEstacion").val("");
        $("#modalFormularioEstacion").modal('show');
        $("#tituloModalEstacion").text("Nuevo Registro");
    break;
    case 'editarRegistro':
        $("#modalFormularioEstacion").modal('show');
        $("#tituloModalEstacion").text("Editar Registro");
        editarRegistroEstacion($(aObject).data('id'));
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
                  url  : "<?php echo site_url('Estaciones/eliminarRegistro'); ?>",
                  dataType: 'json',
                  data: {
                        idEstacion   : $(aObject).data('id'),
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
                  listarDatosEstacion($("#idCaeEstacion").val());
                });

          }
        })

    break;
    default:      
    break;
  }
}

$(document).ready(function() {

 $('#formEstacion').validate({
  rules: {
   nominativoEstacion: {
    required: true
   },
   nombreEstacion: {
    required: true
   },
   telefonoFijoEstacion: {
    minlength: 9,
    maxlength: 9
   },
   telefonoMovilEstacion: {
    minlength: 10,
    maxlength: 10
   }
  },
  messages: {
   nominativoEstacion: {
    required: "Ingrese un nominativo para la Sección"
   },
   nombreEstacion: {
    required: "Ingrese un nombre para la Sección"
   },
   telefonoFijoEstacion: {
    minlength: "Son 9 dígitos",
    maxlength: "Supera el número de dígitos"
   },
   telefonoMovilEstacion: {
    minlength: "Son 10 dígitos",
    maxlength: "Supera el número de dígitos"
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
   $.post("<?php echo site_url('Estaciones/gestionRegistro')?>", $("#formEstacion").serialize())
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
       listarDatosEstacion($("#idCaeEstacion").val());
       $("#modalFormularioEstacion").modal('hide');
       $("#formEstacion").find('.error').removeClass("error");
       $("#formEstacion").find('.success').removeClass("success");
       $("#formEstacion").find('.valid').removeClass("valid");
     });
  }
 });
}); // end document.ready

function editarRegistroEstacion(aId){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('Estaciones/buscarRegistroPorID'); ?>",
      dataType: 'json',
      data: {
        idEstacion   : aId,
      },
    }).done( function(data) {
      $(data).each(function(i, v){
        $("#idEstacion").val(v.idEstacion);
        $("#nominativoEstacion").val(v.nominativoEstacion);
        $("#nombreEstacion").val(v.nombreEstacion);
        $("#direccionEstacion").val(v.direccionEstacion);
        $("#telefonoFijoEstacion").val(v.telefonoFijoEstacion);
        $("#telefonoMovilEstacion").val(v.telefonoMovilEstacion);
      });              
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });
}

//=================== Secciones ======================//

function gestionSecciones(aObject){
  var idEstacion = $(aObject).data("id");
  listarDatosSeccion(idEstacion);
} 

function listarDatosSeccionEstacion(){
  var idEstacion = $("#idEstacionSeccion").val();
  //alert(idCae);
  listarDatosSeccion(idEstacion);  
}

function listarDatosSeccion(idEstacion){
  cargarGif();
  var urlCode = "<?php echo $urlCode; ?>";
  //alert(idEstacion);
  $("#listadoDatos").load("<?php echo site_url('Secciones/lista'); ?>",{urlCode, idEstacion}, function(responseText, statusText, xhr){
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