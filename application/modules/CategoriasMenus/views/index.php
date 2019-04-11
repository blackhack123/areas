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
                  <button type="button" id="btnGestionRegistro" class="btn btn-success bnt-sm" onclick="gestionRegistro(this);" data-titulo="<b><i class='fa fa-file'></i> Nuevo Registro</b>" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nuevo Menú</button>
                  <!-- Submenú -->
                  <button type="button" id="btnGestionRegistroMenu" class="btn btn-success bnt-sm" onclick="gestionRegistroMenu(this);" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nuevo Submenú</button>
                  <button type="button" id="btnGestionVolverCategoriamenu" class="btn btn-danger bnt-sm" onclick="listarDatos();" data-accion="volverCae" <?php echo $status; ?>><i class="fe fe-log-out"></i> Menús</button>

                </div>
              </div>
              <div id="listadoDatos" class="card-body"></div>
            </div>
          </div>
        </div>
      </div>
    </div>


      <!-- Modal -->
<div id="modalFormulario" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloModal"></h4>
        

      </div>
     <form id="formCategoriaMenu"  method="post" class="animate-form" >
      <input name="idCategoriaMenu" id="idCategoriaMenu" type="hidden" value="">
      <div class="modal-body">
        
        <div class="row">
          <div class="col-sm-6">
            <label for="idCurso">Nombre: <span class="kv-reqd">*</span></label>
              <input type="text" name="nombreCategoriaMenu" id="nombreCategoriaMenu" class="form-control">
          </div>
          <div class="col-sm-6">
            <label for="idCurso">Icono: <span class="kv-reqd">*</span></label>
            <input type="text" name="iconoCategoriaMenu" id="iconoCategoriaMenu" class="form-control">
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


  <!-- Modal Submenu o menu-->
<div id="modalFormularioMenu" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloModal"></h4>
        

      </div>
     <form id="formMenu"  method="post" class="animate-form" >
      <input name="idMenu" id="idMenu" type="hidden" value="">
      <input name="idMenuCategoriaMenu" id="idMenuCategoriaMenu" type="hidden" value="">
      <div class="modal-body">
        
        <div class="row">
          <div class="col-sm-9">
            <label for="idCurso">Nombre: <span class="kv-reqd">*</span></label>
              <input type="text" name="nombreMenu" id="nombreMenu" class="form-control">
          </div>
          <div class="col-sm-3">
            <label for="iconoCategoriaMenu">Ícono: <span class="kv-reqd">*</span></label>
            <style type="text/css">
              select {
              font-family: 'FontAwesome', 'sans-serif';
            }
            </style>            

            <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" />            
              <select name="iconoCategoriaMenu" id="iconoCategoriaMenu" class="form-control selectpicker">
                <option value='<i class="fas fa-circle-notch"></i>'>fas fa-circle-notch</option>
              </select>
          </div>
        </div>  

        <div class="row">
          <div class="col-sm-9">
            <label for="rutaMenu">Ruta: <span class="kv-reqd">*</span></label>
              <input type="text" name="rutaMenu" id="rutaMenu" class="form-control">
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
    $("#btnGestionRegistro").show();
    $("#btnGestionRegistroMenu").hide();
    $("#btnGestionVolverCategoriamenu").hide();
    $("#tituloPagina").text("<?php echo $menuNombre; ?>");

    cargarGif();
    var urlCode = "<?php echo $urlCode; ?>";
      $("#listadoDatos").load("<?php echo site_url('CategoriasMenus/lista'); ?>",{urlCode}, function(responseText, statusText, xhr){
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
        $("#formCategoriaMenu")[0].reset();
        $("#idCategoriaMenu").val("");
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
                  url  : "<?php echo site_url('CategoriasMenus/eliminarRegistro'); ?>",
                  dataType: 'json',
                  data: {
                        idCategoriaMenu   : $(aObject).data('id'),
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

 $('#formCategoriaMenu').validate({
  rules: {
   nombreCategoriaMenu: {
    required: true
   },
   iconoCategoriaMenu: {
    required: true
   }
  },
  messages: {
   nombreCategoriaMenu: {
    required: "Ingrese un nombre de la categoría"
   },
   iconoCategoriaMenu: {
    required: "Seleccione un ícono"
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
   $.post("<?php echo site_url('CategoriasMenus/gestionRegistro')?>", $("#formCategoriaMenu").serialize())
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
                                      $("#formCategoriaMenu")[0].reset();
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
      url  : "<?php echo site_url('CategoriasMenus/buscarCategoriaMenuPorID'); ?>",
      dataType: 'json',
      data: {
        idCategoriaMenu   : aId,
      },
    }).done( function(data) {
      $(data).each(function(i, v){
        $("#idCategoriaMenu").val(v.idCategoriaMenu);
        $("#nombreCategoriaMenu").val(v.nombreCategoriaMenu);
        $("#iconoCategoriaMenu").val(v.iconoCategoriaMenu);
      });              
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });
}

// gestion de menus


function gestionMenu(aObject){
  var idCategoriaMenu = $(aObject).data("id");
  listarDatosMenu(idCategoriaMenu);
} 

function listarDatosMenuCategoriaMenu(){
  var idCategoriaMenu = $("#idMenuCategoriaMenu").val();
  //alert(idCae);
  listarDatosMenu(idCategoriaMenu);  
}

function listarDatosMenu(idCategoriaMenu){


  cargarGif();
  var urlCode = "<?php echo $urlCode; ?>";
  //alert(idCae);
  $("#listadoDatos").load("<?php echo site_url('Menus/lista'); ?>",{urlCode, idCategoriaMenu}, function(responseText, statusText, xhr){
      if(statusText == "success"){
        cerrarGif();
      }
      if(statusText == "error"){
        swal("Información!", "No se pudo cargar listado de Submenús", "info"); 
        cerrarGif();
      }
  });  
}

function gestionRegistroMenu(aObject){
  switch($(aObject).data('accion')){
    case 'insertarRegistro':
        $("#formMenu")[0].reset();
        $("#idMenu").val("");
        $("#modalFormularioMenu").modal('show');
        $("#tituloModalMenu").text("Nuevo Submenú");
    break;
    case 'editarRegistro':
        $("#modalFormularioMenu").modal('show');
        $("#tituloModalMenu").text("Editar Submenú");
        editarRegistroMenu($(aObject).data('id'));
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
                  url  : "<?php echo site_url('Menus/eliminarRegistro'); ?>",
                  dataType: 'json',
                  data: {
                        idMenu   : $(aObject).data('id'),
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
                  listarDatosMenuCategoriaMenu($("#idMenuCategoriaMenu").val());
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
          listarDatosMenuCategoriaMenu($("#idMenuCategoriaMenu").val());
      });       
    break;
  }
}

$(document).ready(function() {

 $('#formMenu').validate({
  rules: {
   nombreMenu: {
    required: true
   },
   iconoMenu: {
    required: true
   },
   rutaMenu: {
    required: true
   }
  },
  messages: {
   nombreMenu: {
    required: "Ingrese un nombre para el menú"
   },
   iconoMenu: {
    required: "Seleccione un ícono"
   },
   rutaMenu: {
    required: "Escriba una ruta válida"
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
   $.post("<?php echo site_url('Menus/gestionRegistro')?>", $("#formMenu").serialize())
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
                                      $("#formMenu")[0].reset();
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
       listarDatosMenuCategoriaMenu($("#idMenuCategoriaMenu").val());
       $("#modalFormularioMenu").modal('hide');
       $("#formMenu").find('.error').removeClass("error");
       $("#formMenu").find('.success').removeClass("success");
       $("#formMenu").find('.valid').removeClass("valid");
     });
  }
 });
}); // end document.ready

function editarRegistroMenu(aId){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('Menus/buscarMenuPorID'); ?>",
      dataType: 'json',
      data: {
        idMenu   : aId,
      },
    }).done( function(data) {
      $(data).each(function(i, v){
        $("#idMenu").val(v.idMenu);
        $("#idCategoriaMenu").val(v.idCategoriaMenu);
        $("#nombreMenu").val(v.nombreMenu);
        $("#rutaMenu").val(v.rutaMenu);
        $("#iconoMenu").val(v.iconoMenu);
      });              
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });
}


</script>