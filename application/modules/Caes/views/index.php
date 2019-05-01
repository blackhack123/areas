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
                  <button type="button" id="btnGestionRegistroCae" class="btn btn-success bnt-sm" onclick="gestionRegistro(this);" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nuevo CAE</button>
                  <!-- Sector -->
                  <button type="button" id="btnGestionRegistroSector" class="btn btn-success bnt-sm" onclick="gestionRegistroSector(this);" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nuevo Sector</button>
                  <button type="button" id="btnGestionVolverCae" class="btn btn-danger bnt-sm" onclick="listarDatos();" data-accion="volverCae" <?php echo $status; ?>><i class="fe fe-log-out"></i> CAEs</button>
                  <!-- Estación -->
                  <button type="button" id="btnGestionRegistroEstacion" class="btn btn-success bnt-sm" onclick="gestionRegistroEstacion(this);" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nueva Estación</button>
                  <button type="button" id="btnGestionVolverSector" class="btn btn-danger bnt-sm" onclick="listarDatosSectorCae();" data-accion="volverSector" <?php echo $status; ?>><i class="fe fe-log-out"></i> Sectores</button>
                  <!-- Tipos Existencias -->
                  <button type="button" id="btnGestionRegistroTipoExistencia" class="btn btn-success bnt-sm" onclick="gestionRegistroTipoExistencia(this);" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nuevo Equipo</button>
                  <button type="button" id="btnGestionVolverEstacion" class="btn btn-danger bnt-sm" onclick="listarDatosEstacionSector();" data-accion="volverEstacion" <?php echo $status; ?>><i class="fe fe-log-out"></i> Estaciones</button>

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

<!-- Modal Sector-->
<div id="modalFormularioSector" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloModalSector"></h4>
        

      </div>
     <form id="formSector"  method="post" class="animate-form" >
      <input name="idSector" id="idSector" type="hidden" value="">
      <input name="idCaeSector" id="idCaeSector" type="hidden" value="">
      <div class="modal-body">
        
      <div class="row">
        <div class="form-group col-sm-12">
          <label class="form-label">Nombre del Sector: </label>
          <input type="text" class="form-control" name="nombreSector" id="nombreSector" placeholder="" >
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
      <input name="idSectorEstacion" id="idSectorEstacion" type="hidden" value="">
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
        <div class="form-group col-sm-4">
          <label class="form-label">Teléfono Fijo: </label>
          <input type="text" class="form-control" name="telefonoFijoEstacion" id="telefonoFijoEstacion" placeholder="" >
        </div>                  
        <div class="form-group col-sm-4">
          <label class="form-label">Teléfono Móvil: </label>
          <input type="text" class="form-control" name="telefonoMovilEstacion" id="telefonoMovilEstacion" placeholder="" >
        </div>                  
        <div class="form-group col-sm-4">
          <label class="form-label">Coordenadas: </label>
          <input type="text" class="form-control" name="coordenadaEstacion" id="coordenadaEstacion" placeholder="" >
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
      <input name="idEstacionTipoExistencia" id="idEstacionTipoExistencia" type="hidden" value="">
      <div class="modal-body">
        

      <div class="row">
        <div class="form-group col-sm-12">
          <label class="form-label">Sistema/Sección: </label>
          <select name="idSistema" id="idSistema" class="form-control"></select>
        </div>                  
      </div>

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




<script type="text/javascript">

  listarDatos();

  function listarDatos(){
 
  $("#tituloPagina").text("<?php echo $menuNombre; ?>");
 
  $("#btnGestionRegistroCae").show();
  $("#btnGestionRegistroSector").hide();
  $("#btnGestionRegistroEstacion").hide();
  $("#btnGestionRegistroTipoExistencia").hide();
  
  $("#btnGestionVolverCae").hide();
  $("#btnGestionVolverSector").hide();
  $("#btnGestionVolverEstacion").hide();

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


//=================== Sectores ======================//

function gestionSectores(aObject){
  var idCae = $(aObject).data("id");
  listarDatosSector(idCae);
} 

function listarDatosSectorCae(){
  var idCae = $("#idCaeSector").val();
  //alert(idCae);
  listarDatosSector(idCae);  
}

function listarDatosSector(idCae){
  //alert("cae "+idCae);
  cargarGif();
  var urlCode = "<?php echo $urlCode; ?>";
  //alert(idCae);
  $("#listadoDatos").load("<?php echo site_url('Sectores/lista'); ?>",{urlCode, idCae}, function(responseText, statusText, xhr){
      if(statusText == "success"){
        cerrarGif();
      }
      if(statusText == "error"){
        swal("Información!", "No se pudo cargar listado de Sectores", "info"); 
        cerrarGif();
      }
  });  
}


function gestionRegistroSector(aObject){
  switch($(aObject).data('accion')){
    case 'insertarRegistro':
        $("#formSector")[0].reset();
        $("#idSector").val("");
        $("#modalFormularioSector").modal('show');
        $("#tituloModalSector").text("Nuevo Registro");
    break;
    case 'editarRegistro':
        $("#modalFormularioSector").modal('show');
        $("#tituloModalSector").text("Editar Registro");
        editarRegistroSector($(aObject).data('id'));
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
                  url  : "<?php echo site_url('Sectores/eliminarRegistro'); ?>",
                  dataType: 'json',
                  data: {
                        idSector   : $(aObject).data('id'),
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
                  listarDatosSector($("#idCaeSector").val());
                });

          }
        })

    break;
    default:      
    break;
  }
}

$(document).ready(function() {

 $('#formSector').validate({
  rules: {
   nombreSector: {
    required: true
   }
  },
  messages: {
   nombreSector: {
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
   $.post("<?php echo site_url('Sectores/gestionRegistro')?>", $("#formSector").serialize())
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
            $("#formSector")[0].reset();
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
       listarDatosSector($("#idCaeSector").val());
       $("#modalFormularioSector").modal('hide');
       $("#formSector").find('.error').removeClass("error");
       $("#formSector").find('.success').removeClass("success");
       $("#formSector").find('.valid').removeClass("valid");
     });
  }
 });
}); // end document.ready

function editarRegistroSector(aId){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('Sectores/buscarRegistroPorID'); ?>",
      dataType: 'json',
      data: {
        idSector   : aId,
      },
    }).done( function(data) {
      $(data).each(function(i, v){
        $("#idSector").val(v.idSector);
        $("#nombreSector").val(v.nombreSector);
      });              
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });
}

//=================== Estaciones ======================//

function gestionEstaciones(aObject){
  var idSector = $(aObject).data("id");
  listarDatosEstacion(idSector);
} 

function listarDatosEstacionSector(){
  var idSector = $("#idSectorEstacion").val();
  //alert(idCae);
  listarDatosEstacion(idSector);  
}

function listarDatosEstacion(idSector){
  //alert("cae "+idSector);
  cargarGif();
  var urlCode = "<?php echo $urlCode; ?>";
  //alert(idSector);
  $("#listadoDatos").load("<?php echo site_url('Estaciones/lista'); ?>",{urlCode, idSector}, function(responseText, statusText, xhr){
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
                  listarDatosEstacion($("#idSectorEstacion").val());
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
   coordenadaEstacion: {
    required: true
   }
  },
  messages: {
   nominativoEstacion: {
    required: "Ingrese un nominativo para la Sección"
   },
   nombreEstacion: {
    required: "Ingrese un nombre para la Sección"
   },
   coordenadaEstacion: {
    required: "Ingrese la coordenada"
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
            $("#formEstacion")[0].reset();
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
       listarDatosEstacion($("#idSectorEstacion").val());
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
        $("#coordenadaEstacion").val(v.coordenadaEstacion);
      });              
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });
}

//=================== Tipos Existencias ======================//

function gestionTiposExistencias(aObject){
  var idEstacion = $(aObject).data("id");
  //alert(idEstacion);
  listarDatosTiposExistecias(idEstacion);
} 

function listarDatosTiposExistenciasEstacion(){
  alert("npne");
  // var idEstacion = $("#idEstacionTipoExistencia").val();
  // alert(idEstacion);
  // listarDatosTiposExistecias(idEstacion);  
}

function listarDatosTiposExistecias(idEstacion){
  cargarGif();
  cargarSistemas();
  var urlCode = "<?php echo $urlCode; ?>";
  //alert(idCae);
  $("#listadoDatos").load("<?php echo site_url('TiposExistencias/lista'); ?>",{urlCode, idEstacion}, function(responseText, statusText, xhr){
      if(statusText == "success"){
        cerrarGif();
      }
      if(statusText == "error"){
        swal("Información!", "No se pudo cargar listado de Existencias", "info"); 
        cerrarGif();
      }
  });  
}

function cargarSistemas(){
  //cargarGif();
  $.ajax({
    url      : "<?php echo site_url('Sistemas/buscarSistemasSecciones');?>",
    type     : 'post',
    dataType : 'json',
    success: function(data){
      $('#idSistema').find('option').remove();
      $(data).each(function(i, v){
        $('#idSistema').append('<option value="'+ v.idSistema +'">' + v.nombreSistema + '</option');
      })
    },
    complete: function(){
      //cerrarGif();
    },
    error: function(){
      swal("Información!", "No se pudieron cargar los Sistemas", "info");
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
                  listarDatosTiposExistecias($("#idEstacionTipoExistencia").val());
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
            $("#formTipoExistencia")[0].reset();
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
       listarDatosTiposExistecias($("#idEstacionTipoExistencia").val());
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
      //listarDatosTiposExistecias();
    });
}






</script>