
<!-- some CSS styling changes and overrides -->
<style>
.kv-avatar .krajee-default.file-preview-frame,.kv-avatar .krajee-default.file-preview-frame:hover {
    margin: 0;
    padding: 0;
    border: none;
    box-shadow: none;
    text-align: center;
}
.kv-avatar .file-input {
    display: table-cell;
    max-width: 100% !important;
}
.kv-reqd {
    color: red;
    font-family: monospace;
    font-weight: normal;
}
</style>

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
                  <button type="button" id="btnGestionRegistroFuerza" class="btn btn-success bnt-sm" onclick="gestionRegistro(this);" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nueva Fuerza</button>
                  <!-- Grados -->
                  <button type="button" id="btnGestionRegistroGrado" class="btn btn-success bnt-sm" onclick="gestionRegistroGrado(this);" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nuevo Grado</button>
                  <!-- Armas -->
                  <button type="button" id="btnGestionRegistroArma" class="btn btn-success bnt-sm" onclick="gestionRegistroArma(this);" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nueva Arma</button>
                  <button type="button" id="btnGestionVolverFuerza" class="btn btn-danger bnt-sm" onclick="listarDatos();" data-accion="volverFuerza" <?php echo $status; ?>><i class="fe fe-log-out"></i> Fuerzas</button>
                </div>
              </div>
              <div id="listadoDatos" class="card-body"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

<!-- Modal Fuerza-->
<div id="modalFormulario" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloModal"></h4>
        
      </div>
     <form id="formFuerza"  method="post" class="animate-form" >
      <input name="idFuerza" id="idFuerza" type="hidden" value="">
      <input name="logoFuerzaAuxiliar" id="logoFuerzaAuxiliar" type="hidden" value="">
      <div class="modal-body">
        
      <div class="row">

      <div class="col-sm-4">
                  <div class="kv-avatar center-block text-center form-control">
                      <center>
                      <input id="logoFuerza" name="logoFuerza" type="file" class="file-loading form-control" value="">
                      </center>
                  </div>
      </div>

        <div class="col-sm-8">
          <div class="row">
            <div class="form-group col-sm-2">
              <label class="form-label">Orden: </label>
              <input type="text" class="form-control" name="ordenFuerza" id="ordenFuerza" placeholder="" >
            </div>
            <div class="form-group col-sm-10">
              <label class="form-label">Tipo: </label>
              <select name="idTipoFuerza" id="idTipoFuerza" class="form-control">
                <?php foreach ($tipoFuerza as $dt){ ?>
                    <option value="<?php echo $dt->idTipoFuerza; ?>"><?php echo $dt->nombreTipoFuerza; ?></option>
                  <?php } ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-sm-12">
              <label class="form-label">Nombre de la fuerza: </label>
              <input type="text" class="form-control" name="nombreFuerza" id="nombreFuerza" placeholder="" >
            </div>
          </div>
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


<!-- Modal Grado-->
<div id="modalFormularioGrado" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloModalSeccion"></h4>

      </div>
     <form id="formGrado"  method="post" class="animate-form" >
      <input name="idGrado" id="idGrado" type="hidden" value="">
      <input name="idFuerzaGrado" id="idFuerzaGrado" type="hidden" value="">
      <div class="modal-body">
        
      <div class="row">
        <div class="form-group col-sm-1">
          <label class="form-label">Ord: </label>
          <input type="text" class="form-control" name="ordenGrado" id="ordenGrado" placeholder="" >
        </div>                  
        <div class="form-group col-sm-8">
          <label class="form-label">Nombre del Grado: </label>
          <input type="text" class="form-control" name="nombreGrado" id="nombreGrado" placeholder="" >
        </div>                  
        <div class="form-group col-sm-3">
          <label class="form-label">Abreviatura: </label>
          <input type="text" class="form-control" name="abreviaturaGrado" id="abreviaturaGrado" placeholder="" >
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



<!-- Modal Arma-->
<div id="modalFormularioArma" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloModalArma"></h4>

      </div>
     <form id="formArma"  method="post" class="animate-form" >
      <input name="idArma" id="idArma" type="hidden" value="">
      <input name="idFuerzaArma" id="idFuerzaArma" type="hidden" value="">
      <div class="modal-body">
        
      <div class="row">
        <div class="form-group col-sm-8">
          <label class="form-label">Nombre del Arma: </label>
          <input type="text" class="form-control" name="nombreArma" id="nombreArma" placeholder="" >
        </div>                  
        <div class="form-group col-sm-4">
          <label class="form-label">Abreviatura: </label>
          <input type="text" class="form-control" name="abreviaturaArma" id="abreviaturaArma" placeholder="" >
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

function cargarLogo(image){

  $('#logoFuerza').fileinput('destroy');
  var imageDefault = image ? image : "default_avatar.jpg";
  var btnCust ='';
  var defaultImage = "<?php echo base_url();?>application/modules/Fuerzas/photos/"+imageDefault;

  $("#logoFuerza").fileinput({
      overwriteInitial: true,
      maxFileSize: 1500,
      showClose: false,
      showCaption: false,
      showBrowse: false,
      browseOnZoneClick: true,
      removeLabel: '',
      removeIcon: '<i class="fa fa-times"></i>',
      removeTitle: 'Cancelar o eliminar cambios',
      elErrorContainer: '#kv-avatar-errors-2',
      msgErrorClass: 'alert alert-block alert-danger',

      defaultPreviewContent: '<img src="'+defaultImage+'"  alt="Su foto" style="width:160px"><h6 class="text-muted">Click para seleccionar</h6>',

      layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
      allowedFileExtensions: ["jpg", "jpeg", "png"]
  });  
}

  listarDatos();

  function listarDatos(){
 
  $("#tituloPagina").text("<?php echo $menuNombre; ?>");
  $("#btnGestionRegistroFuerza").show();
  $("#btnGestionRegistroGrado").hide();
  $("#btnGestionRegistroArma").hide();
  $("#btnGestionVolverFuerza").hide();

    cargarGif();
    var urlCode = "<?php echo $urlCode; ?>";
      $("#listadoDatos").load("<?php echo site_url('Fuerzas/lista'); ?>",{urlCode}, function(responseText, statusText, xhr){
        if(statusText == "success"){
          cerrarGif();
        }
        if(statusText == "error"){
          swal("Informaci??n!", "No se pudo cargar listado de Fuerzas", "info"); 
          cerrarGif();
        }
      });
  }

function gestionRegistro(aObject){
  
  switch($(aObject).data('accion')){
    case 'insertarRegistro':
        $("#formFuerza")[0].reset();
        $("#idFuerza").val("");
        $("#logoFuerzaAuxiliar").val("");
        $("#modalFormulario").modal('show');
        $("#tituloModal").text("Nuevo Registro");
        cargarLogo("");
    break;
    case 'editarRegistro':
        $("#modalFormulario").modal('show');
        $("#tituloModal").text("Editar Registro");
        editarRegistro($(aObject).data('id'));
    break;
    case 'eliminarRegistro':
       
        swal({
          title: 'Desea eliminar?',
          text: "Los datos se perder??n!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
          if (result.value) {
            
                $.ajax({
                  type : 'post',
                  url  : "<?php echo site_url('Fuerzas/eliminarRegistro'); ?>",
                  dataType: 'json',
                  data: {
                        idFuerza   : $(aObject).data('id'),
                      }
                })  
                .done(function(data){
                  if(data){
                    $().toastmessage('showSuccessToast', "Registro eliminado");
                  }else{
                    $().toastmessage('showErrorToast', "No se pudo eliminar la informaci??n (registros enlazados)");
                  }
                })
                .fail(function(){
                  $().toastmessage('showErrorToast', "Error: No se pudo eliminar la informaci??n");
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

 $('#formFuerza').validate({
  rules: {
   nombreFuerza: {
    required: true
   }
  },
  messages: {
   nombreFuerza: {
    required: "Ingrese un nombre del Fuerza"
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

      cargarGif();
      var formData = new FormData($('#formFuerza')[0]);
      $.ajax({
        type : 'post',
        url  : "<?php echo site_url('Fuerzas/gestionRegistro'); ?>",
        data : formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        enctype: 'multipart/form-data',
        success:function(data){
          if(data){
            data = data.replace('"','');
            var row = data.split('|');
            switch(row[0]){
              case 'i':
                $('#idFuerza').val(row[1].replace('"',''));   
                $().toastmessage('showSuccessToast', "Registro creado correctamente");
              break;
              case 'e':
                $().toastmessage('showSuccessToast', "Editado exitosamente");
              break;
            }
          }else{
            $().toastmessage('showErrorToast', "No se pudo procesar la informaci??n");
          }
        },
        complete:function(){
          cerrarGif();
          listarDatos();
          $("#modalFormulario").modal('hide');
          $("#formFuerza").find('.error').removeClass("error");
          $("#formFuerza").find('.success').removeClass("success");
          $("#formFuerza").find('.valid').removeClass("valid");          
        },     
        error:function(err){
          $().toastmessage('showErrorToast', "Error: No se pudo procesar la informaci??n "+err); 
        }   
      });                                          


  }
 });
}); // end document.ready

function editarRegistro(aId){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('Fuerzas/buscarRegistroPorID'); ?>",
      dataType: 'json',
      data: {
        idFuerza   : aId,
      },
    }).done( function(data) {
      $(data).each(function(i, v){
        $("#idTipoFuerza").val(v.idTipoFuerza);
        $("#idFuerza").val(v.idFuerza);
        $("#ordenFuerza").val(v.ordenFuerza);
        $("#nombreFuerza").val(v.nombreFuerza);
        $("#logoFuerzaAuxiliar").val(v.logoFuerza);
        cargarLogo(v.logoFuerza);
      });              
    }).fail( function() {
      swal("Informaci??n!", "No se pudo cargar la informaci??n", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });
}

//=========== Grados ===============//

function gestionGrados(aObject){
  var idFuerza = $(aObject).data("id");
  listarDatosGrado(idFuerza);
} 

function listarDatosGradoFuerza(){
  var idFuerza = $("#idFuerzaGrado").val();
  //alert(idFuerza);
  listarDatosGrado(idFuerza);  
}

function listarDatosGrado(idFuerza){
  cargarGif();
  var urlCode = "<?php echo $urlCode; ?>";
  //alert(idFuerza);
  $("#listadoDatos").load("<?php echo site_url('Grados/lista'); ?>",{urlCode, idFuerza}, function(responseText, statusText, xhr){
      if(statusText == "success"){
        cerrarGif();
      }
      if(statusText == "error"){
        swal("Informaci??n!", "No se pudo cargar listado de Grados", "info"); 
        cerrarGif();
      }
  });  
}


function gestionRegistroGrado(aObject){
  switch($(aObject).data('accion')){
    case 'insertarRegistro':
        $("#formGrado")[0].reset();
        $("#idGrado").val("");
        $("#modalFormularioGrado").modal('show');
        $("#tituloModalGrado").text("Nuevo Registro");
    break;
    case 'editarRegistro':
        $("#modalFormularioGrado").modal('show');
        $("#tituloModalGrado").text("Editar Registro");
        editarRegistroGrado($(aObject).data('id'));
    break;
    case 'eliminarRegistro':
       
        swal({
          title: 'Desea eliminar?',
          text: "Los datos se perder??n!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
          if (result.value) {
            
                $.ajax({
                  type : 'post',
                  url  : "<?php echo site_url('Grados/eliminarRegistro'); ?>",
                  dataType: 'json',
                  data: {
                        idGrado   : $(aObject).data('id'),
                      }
                })  
                .done(function(data){
                  if(data){
                    $().toastmessage('showSuccessToast', "Registro eliminado");
                  }else{
                    $().toastmessage('showErrorToast', "No se pudo eliminar la informaci??n (registros enlazados)");
                  }
                })
                .fail(function(){
                  $().toastmessage('showErrorToast', "Error: No se pudo eliminar la informaci??n");
                })   
                .always(function(){
                  cerrarGif();
                  listarDatosGrado($("#idFuerzaGrado").val());
                });

          }
        })

    break;
    default:      
    break;
  }
}

$(document).ready(function() {

 $('#formGrado').validate({
  rules: {
   nombreGrado: {
    required: true
   }
  },
  messages: {
   nombreGrado: {
    required: "Ingrese un nombre para la Secci??n"
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
   $.post("<?php echo site_url('Grados/gestionRegistro')?>", $("#formGrado").serialize())
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
            $("#formGrado")[0].reset();
          break;
        }
      }else{
        $().toastmessage('showErrorToast', "No se pudo procesar la informaci??n");
      }
     })
     .fail(function(err){
        //swal("Informaci??n!", "Error: No se pudo procesar la informaci??n", "warning"); 
        $().toastmessage('showErrorToast', "Error: No se pudo procesar la informaci??n");
     })
     .always(function(){
       listarDatosGrado($("#idFuerzaGrado").val());
       $("#modalFormularioGrado").modal('hide');
       $("#formGrado").find('.error').removeClass("error");
       $("#formGrado").find('.success').removeClass("success");
       $("#formGrado").find('.valid').removeClass("valid");
     });
  }
 });
}); // end document.ready

function editarRegistroGrado(aId){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('Grados/buscarRegistroPorID'); ?>",
      dataType: 'json',
      data: {
        idGrado   : aId,
      },
    }).done( function(data) {
      $(data).each(function(i, v){
        $("#idGrado").val(v.idGrado);
        $("#ordenGrado").val(v.ordenGrado);
        $("#nombreGrado").val(v.nombreGrado);
        $("#abreviaturaGrado").val(v.abreviaturaGrado);
      });              
    }).fail( function() {
      swal("Informaci??n!", "No se pudo cargar la informaci??n", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });
}


//=========== Armas ===============//

function gestionArmas(aObject){
  var idFuerza = $(aObject).data("id");
  listarDatosArma(idFuerza);
} 

function listarDatosArmaFuerza(){
  var idFuerza = $("#idFuerzaArma").val();
  //alert(idFuerza);
  listarDatosArma(idFuerza);  
}

function listarDatosArma(idFuerza){
  cargarGif();
  var urlCode = "<?php echo $urlCode; ?>";
  //alert(idFuerza);
  $("#listadoDatos").load("<?php echo site_url('Armas/lista'); ?>",{urlCode, idFuerza}, function(responseText, statusText, xhr){
      if(statusText == "success"){
        cerrarGif();
      }
      if(statusText == "error"){
        swal("Informaci??n!", "No se pudo cargar listado de Armas", "info"); 
        cerrarGif();
      }
  });  
}


function gestionRegistroArma(aObject){
  switch($(aObject).data('accion')){
    case 'insertarRegistro':
        $("#formArma")[0].reset();
        $("#idArma").val("");
        $("#modalFormularioArma").modal('show');
        $("#tituloModalArma").text("Nuevo Registro");
    break;
    case 'editarRegistro':
        $("#modalFormularioArma").modal('show');
        $("#tituloModalArma").text("Editar Registro");
        editarRegistroArma($(aObject).data('id'));
    break;
    case 'eliminarRegistro':
       
        swal({
          title: 'Desea eliminar?',
          text: "Los datos se perder??n!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
          if (result.value) {
            
                $.ajax({
                  type : 'post',
                  url  : "<?php echo site_url('Armas/eliminarRegistro'); ?>",
                  dataType: 'json',
                  data: {
                        idArma   : $(aObject).data('id'),
                      }
                })  
                .done(function(data){
                  if(data){
                    $().toastmessage('showSuccessToast', "Registro eliminado");
                  }else{
                    $().toastmessage('showErrorToast', "No se pudo eliminar la informaci??n (registros enlazados)");
                  }
                })
                .fail(function(){
                  $().toastmessage('showErrorToast', "Error: No se pudo eliminar la informaci??n");
                })   
                .always(function(){
                  cerrarGif();
                  listarDatosArma($("#idFuerzaArma").val());
                });

          }
        })

    break;
    default:      
    break;
  }
}

$(document).ready(function() {

 $('#formArma').validate({
  rules: {
   nombreArma: {
    required: true
   }
  },
  messages: {
   nombreArma: {
    required: "Ingrese un nombre para la Secci??n"
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
   $.post("<?php echo site_url('Armas/gestionRegistro')?>", $("#formArma").serialize())
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
            $("#formArma")[0].reset();
          break;
        }
      }else{
        $().toastmessage('showErrorToast', "No se pudo procesar la informaci??n");
      }
     })
     .fail(function(err){
        //swal("Informaci??n!", "Error: No se pudo procesar la informaci??n", "warning"); 
        $().toastmessage('showErrorToast', "Error: No se pudo procesar la informaci??n");
     })
     .always(function(){
       listarDatosArma($("#idFuerzaArma").val());
       $("#modalFormularioArma").modal('hide');
       $("#formArma").find('.error').removeClass("error");
       $("#formArma").find('.success').removeClass("success");
       $("#formArma").find('.valid').removeClass("valid");
     });
  }
 });
}); // end document.ready

function editarRegistroArma(aId){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('Armas/buscarRegistroPorID'); ?>",
      dataType: 'json',
      data: {
        idArma   : aId,
      },
    }).done( function(data) {
      $(data).each(function(i, v){
        $("#idArma").val(v.idArma);
        $("#idFuerzaArma").val(v.idFuerzaArma);
        $("#nombreArma").val(v.nombreArma);
        $("#abreviaturaArma").val(v.abreviaturaArma);
      });              
    }).fail( function() {
      swal("Informaci??n!", "No se pudo cargar la informaci??n", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });
}




</script>