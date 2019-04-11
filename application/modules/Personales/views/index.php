
<script type="text/javascript">
  $("#<?php echo $codigoCategoriaMenu; ?>").addClass('active');
  $("#<?php echo $codigoMenu; ?>").addClass('active');
</script>

        <div class="my-3 my-md-5">
          <div class="container">
            <div class="card">
              <div class="card-header">
                
                <h3 class="card-title col-sm-1" id="tituloPagina"></h3>
                <select name="idTipoFuerza" id="idTipoFuerza" class="form-control col-sm-2" onchange="listarDatos(this);"></select>
                
                <div class="card-options">
                  <button type="button" id="btnGestionRegistroPersonal" class="btn btn-success bnt-sm" onclick="gestionRegistro(this);" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nuevo Registro</button>
                  <!-- Formulario -->
                  <button type="button" id="btnGestionVolverPersonal" class="btn btn-danger bnt-sm" onclick="quitarFormulario();" data-accion="volverPersonal" <?php echo $status; ?>><i class="fe fe-log-out"></i> Personal</button>
                </div>
              </div>
              <div id="listadoDatos" class="card-body"></div>
            </div>
          </div>
        </div>
      </div>
    </div>


<!-- Modal Pase-->
<div id="modalFormularioPase" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloModalPase"></h4>
        

      </div>
     <form id="formPase"  method="post" class="animate-form" >
      <input name="idPase" id="idPase" type="hidden" value="">
      <input name="idPersonalPase" id="idPersonalPase" type="hidden" value="">
      <div class="modal-body">
        
      <div class="row">
        <div class="form-group col-sm-6">
          <label class="form-label">CAE Origen: </label>
          <select name="idCaeOrigen" id="idCaeOrigen" class="form-control"></select>
        </div>                  
        <div class="form-group col-sm-6">
          <label class="form-label">CAE Destino: </label>
          <select name="idCaeDestino" id="idCaeDestino" class="form-control"></select>
        </div>                  
      </div>

      <div class="row">
        <div class="form-group col-sm-6">
          <label class="form-label">Fecha de Presentación: </label>
          <input type="text" name="fechaPresentacionPase" id="fechaPresentacionPase" class="form-control">
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

  listarTipoFuerza();
  $("#tituloPagina").text("<?php echo $menuNombre; ?>");
  $("#idTipoFuerza").show();

$(document).ready(function () {
    $('#fechaPresentacionPase').datetimepicker({
      timepicker:false,
      format: 'Y-m-d'
    });
});
  

function listarTipoFuerza(){
    $("#btnGestionRegistroPersonal").hide();
    $("#btnGestionVolverPersonal").hide();

  cargarGif();

    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('TiposFuerzas/buscarTipoFuerza');?>",
      dataType: 'json',
    }).done( function(data) {
      $('#idTipoFuerza').find('option').remove();
      $('#idTipoFuerza').append('<option value="">SELECCIONE... </option>');
      $(data).each(function(i, v){
        $('#idTipoFuerza').append('<option value="'+ v.idTipoFuerza +'">' + v.nombreTipoFuerza+ '</option');
      })
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      cerrarGif();
    });
}

 function listarDatos(aObject){
    var idTipoFuerza = $(aObject).val();
    listarDatosPersonal(idTipoFuerza);
 }
    
  function listarDatosPersonal(idTipoFuerza){
    $("#btnGestionRegistroPersonal").show();
    $("#btnGestionVolverPersonal").hide();
    cargarGif();
    var urlCode = "<?php echo $urlCode; ?>";
      $("#listadoDatos").load("<?php echo site_url('Personales/lista'); ?>",{urlCode, idTipoFuerza}, function(responseText, statusText, xhr){
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
    var idTipoFuerza = $("#idTipoFuerza").val();
    var urlCode = "<?php echo $urlCode; ?>";
      $("#listadoDatos").load("<?php echo site_url('Personales/formulario'); ?>",{urlCode, idPersonal, idTipoFuerza}, function(responseText, statusText, xhr){
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

function quitarFormulario(){
  var idTipoFuerza = $("#idTipoFuerza").val();
  listarDatosPersonal(idTipoFuerza);
  $("#btnGestionRegistroPersonal").hide();
  $("#btnGestionVolverPersonal").hide();  
  $("#listadoDatos").html("");
}

//================= Pases =====================//

function buscarPasesPersonal(aObject){
  var idPersonal = $(aObject).data("id");
  listaPasePersonal(idPersonal);
}

function listaPasePersonal(idPersonal){
    cargarGif();
    cargarCaes();
    var urlCode = "<?php echo $urlCode; ?>";
      $("#listadoDatos").load("<?php echo site_url('Personales/pasePersonal'); ?>",{urlCode, idPersonal}, function(responseText, statusText, xhr){
        if(statusText == "success"){
          cerrarGif();
        }
        if(statusText == "error"){
          swal("Información!", "No se pudo cargar el historial de pases", "info"); 
          cerrarGif();
        }
      });  
}

function cargarCaes(){
  $.ajax({
    url      : "<?php echo site_url('Caes/buscarCaes');?>",
    type     : 'post',
    dataType : 'json',
    success: function(data){
      $('#idCaeOrigen').find('option').remove();
      $('#idCaeDestino').find('option').remove();
      $(data).each(function(i, v){
        $('#idCaeOrigen').append('<option value="'+ v.idCae +'">' + v.nombreCae + '</option');
        $('#idCaeDestino').append('<option value="'+ v.idCae +'">' + v.nombreCae + '</option');
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

function gestionRegistroPase(aObject){
  

  switch($(aObject).data('accion')){
    case 'insertarRegistro':
        $("#formPase")[0].reset();
        $("#idPase").val("");
        $("#modalFormularioPase").modal('show');
        $("#tituloModalPase").text("Nuevo Registro");
    break;
    case 'editarRegistro':
        $("#modalFormularioPase").modal('show');
        $("#tituloModalPase").text("Editar Registro");
        editarRegistroPase($(aObject).data('id'));
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
                  url  : "<?php echo site_url('Pases/eliminarRegistro'); ?>",
                  dataType: 'json',
                  data: {
                        idPase   : $(aObject).data('id'),
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

$(document).ready(function() {

 $('#formPase').validate({
  rules: {
   fechaPresentacionPase: {
    required: true,
    date: true
   }
  },
  messages: {
   fechaPresentacionPase: {
    required: "Ingrese una fecha",
    date: "Fecha incorrecta"
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
   $.post("<?php echo site_url('Pases/gestionRegistro')?>", $("#formPase").serialize())
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
            $("#formPase")[0].reset();
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
      listaPasePersonal($("#idPersonalPase").val());
       $("#modalFormularioPase").modal('hide');
       $("#formPase").find('.error').removeClass("error");
       $("#formPase").find('.success').removeClass("success");
       $("#formPase").find('.valid').removeClass("valid");
     });
  }
 });
}); // end document.ready

function editarRegistroPase(aId){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('Pases/buscarRegistroPorID'); ?>",
      dataType: 'json',
      data: {
        idPase   : aId,
      },
    }).done( function(data) {
      $(data).each(function(i, v){
        $("#idPase").val(v.idPase);
        $("#idPersonalPase").val(v.idPersonalPase);
        $("#idCaeOrigen").val(v.idCaeOrigen);
        $("#idCaeDestino").val(v.idCaeDestino);
        $("#fechaPresentacionPase").val(v.fechaPresentacionPase);
      });              
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });
}


</script>