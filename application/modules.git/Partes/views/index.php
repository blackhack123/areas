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
                  <button type="button" id="btngestionRegistro" class="btn btn-success bnt-sm" onclick="gestionRegistro(this);" data-titulo="<b><i class='fa fa-file'></i> Nuevo Registro</b>" data-accion="insertarRegistro" <?php echo $status; ?>><i class="fa fa-file"></i> Nuevo Parte</button>
                </div>
              </div>
              <div id="listadoDatos" class="card-body"></div>
            </div>
          </div>
        </div>
      </div>
    </div>


<!-- Modal Partes-->
<div id="modalFormulario" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloModal"></h4>
        

      </div>
     <form id="formParte"  method="post" class="animate-form" >
      <input name="idParte" id="idParte" type="hidden" value="">
      <div class="modal-body">

      <div class="row">
        <div class="form-group col-sm-12">
          <label class="form-label">Estación: </label>
          <select name="idEstacion" id="idEstacion" class="form-control" onchange="cargarSistemasEstacion(this); cargarExistenciasCae(this);">
            <option value="">SELECCIONE...</option>
            <?php foreach ($estacion as $dt){ ?>
            <option value="<?php echo $dt->idEstacion; ?>"><?php echo $dt->nombreEstacion; ?></option>
            <?php } ?>            
          </select>
        </div>                  
      </div>
        
      <div class="row">
        <div class="form-group col-sm-12">
          <label class="form-label">Sistema: </label>
          <select name="idSistema" id="idSistema" class="form-control">
          </select>
        </div>                  
      </div>

      <div class="row">
        <div class="form-group col-sm-12">
          <label class="form-label">Tipo Existencia: </label>
          <select name="idTipoExistencia" id="idTipoExistencia" class="form-control">
          </select>
        </div>                  
      </div>

      <div class="row">
        <div class="form-group col-sm-12">
          <label class="form-label">Novedad: </label>
          <textarea name="novedadParte" id="novedadParte" class="form-control"></textarea>
        </div>                  
      </div>

      <div class="row">
        <div class="form-group col-sm-12">
          <label class="form-label">Seguimiento: </label>
          <textarea name="seguimientoParte" id="seguimientoParte" class="form-control"></textarea>
        </div>                  
      </div>

      <div class="row">
        <div class="form-group col-sm-12">
          <label class="form-label">Requerimiento/Solución: </label>
          <textarea name="requerimientoSolucionParte" id="requerimientoSolucionParte" class="form-control"></textarea>
        </div>                  
      </div>

      <div class="row">
        <div class="form-group col-sm-4">
          <label class="form-label">Fecha: </label>
          <input type="text" name="fechaParte" id="fechaParte" class="form-control" value="" disabled="disabled">
        </div>                  
        <div class="form-group col-sm-4">
          <label class="form-label">Está Solucionado?: </label>
          <select name="esSolucionadoParte" id="esSolucionadoParte" class="form-control">
            <option value="NO">NO</option>
            <option value="SI">SI</option>
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
      $("#listadoDatos").load("<?php echo site_url('Partes/lista'); ?>",{urlCode}, function(responseText, statusText, xhr){
        if(statusText == "success"){
          cerrarGif();
        }
        if(statusText == "error"){
          swal("Información!", "No se pudo cargar listado de Partes Diarios", "info"); 
          cerrarGif();
        }
      });
  }


function gestionRegistro(aObject){
  switch($(aObject).data('accion')){
    case 'insertarRegistro':
        $("#formParte")[0].reset();
        $("#idParte").val("");
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
                  url  : "<?php echo site_url('Partes/eliminarRegistro'); ?>",
                  dataType: 'json',
                  data: {
                        idParte   : $(aObject).data('id'),
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

 $('#formParte').validate({
  rules: {
   idEstacion: {
    required: true
   },
   idSistema: {
    required: true
   }
  },
  messages: {
   idEstacion: {
    required: "Seleccione una estación"
   },
   idSistema: {
    required: "Seleccione un Sistema"
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
   $.post("<?php echo site_url('Partes/gestionRegistro')?>", $("#formParte").serialize())
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
            $("#formParte")[0].reset();
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
       $("#formParte").find('.error').removeClass("error");
       $("#formParte").find('.success').removeClass("success");
       $("#formParte").find('.valid').removeClass("valid");
     });
  }
 });
}); // end document.ready

function editarRegistro(aId){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('Partes/buscarRegistroPorID'); ?>",
      dataType: 'json',
      data: {
        idParte   : aId,
      },
    }).done( function(data) {
      $(data).each(function(i, v){
        $("#idParte").val(v.idParte);
        $("#idEstacion").val(v.idEstacion);
        $("#idEstacion").trigger('change');
        alert(v.idSistema);
        $("#idSistema").val(v.idSistema);
        $("#novedadParte").val(v.novedadParte);
        $("#seguimientoParte").val(v.seguimientoParte);
        $("#requerimientoSolucionParte").val(v.requerimientoSolucionParte);
        $("#fechaParte").val(v.fechaParte);
        $("#esSolucionadoParte").val(v.esSolucionadoParte);
      });              
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });
}

function cargarSistemasEstacion(aObject){
  cargarGif();
  $.ajax({
    url      : "<?php echo site_url('Sistemas/buscarSistemasEstacion');?>",
    type     : 'post',
    dataType : 'json',
    data     :{
                idEstacion : aObject.value
             },
    success: function(data){
      $('#idSistema').find('option').remove();
      $('#idSistema').find('option').remove();
      $(data).each(function(i, v){
        $('#idSistema').append('<option value="'+ v.idSistema +'">' + v.nombreSistema + '</option');
      })
    },
    complete: function(){
      cerrarGif();
    },
    error: function(){
      swal("Información!", "No se pudieron cargar los Sistemas", "info");
    }
  });
}

function cargarExistenciasCae(aObject){
  cargarGif();
  $.ajax({
    url      : "<?php echo site_url('TiposExistencias/buscarTiposExistenciasCaeEstacion');?>",
    type     : 'post',
    dataType : 'json',
    data     :{
                idEstacion : aObject.value
             },
    success: function(data){
      $('#idTipoExistencia').find('option').remove();
      $('#idTipoExistencia').find('option').remove();
      $(data).each(function(i, v){
        $('#idTipoExistencia').append('<option value="'+ v.idTipoExistencia +'">' + v.nombreTipoExistencia + '</option');
      })
    },
    complete: function(){
      cerrarGif();
    },
    error: function(){
      swal("Información!", "No se pudieron cargar los Tipos de Existencias", "info");
    }
  });
}

</script>