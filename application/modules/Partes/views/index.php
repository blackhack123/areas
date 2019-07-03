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
                  <form name="formParte" id="formParte">
                    <input type="hidden" name="idParte" id="idParte">
                      <div class="input-group">
                  
                        <select name="idCae" id="idCae" class="form-control">
                          <?php foreach ($cae as $dt){ ?>
                          <option value="<?php echo $dt->idCae; ?>">CAE <?php echo $dt->nombreCae; ?></option>
                          <?php } ?>            
                        </select>

                        <span class="input-group-append">
                          <div class="input-group">
                            <input type="text" name="fechaParte" id="fechaParte" class="form-control" value="<?php echo date("Y-m-d"); ?>" style="width: 100px;">
                            <span class="input-group-append">
                              <div class="input-group">
                                <select class="form-control" name="tieneNovedadParte" id="tieneNovedadParte">
                                  <option value="NO">NO hay novedades que reportar</option>
                                  <option value="SI">SI hay daños, generar parte</option>
                                </select>
                                <span class="input-group-append">
                                 <button class="btn btn-primary" type="button"  id="btnTieneNovedadParte" <?php echo $status; ?>><i class="fas fa-check-circle"></i> Reportar</button>
                                 <button class="btn btn-success" type="button"  id="btnEnviarParte" <?php echo $send; ?>><i class="fas fa-share-square"></i> Enviar</button>
                                </span>
                              </div>
                            </span>
                          </div>    
                        </span>
                      </div>
                          
                  </form>
                </div>
              </div>
      
              <div id="listadoDatos" class="card-body"></div>
              <div id="listadoDatosDetalle" class="card-body"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

<!-- Modal Detalle Parte-->
<div id="modalFormularioDetalleParte" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloModal"></h4>
        

      </div>
     <form id="formDetalleParte"  method="post" class="animate-form" >
      <input name="idParteDetalleParte" id="idParteDetalleParte" type="hidden" value="">
      <input name="idDetalleParte" id="idDetalleParte" type="hidden" value="">
      <div class="modal-body">
        

      <div class="row">
        <div class="form-group col-sm-12">
          <label class="form-label">Equipo: </label>
          <select class="form-control" name="idTipoExistenciaDetalleParte" id="idTipoExistenciaDetalleParte"></select>
        </div>                  
      </div>

      <div class="row">
        <div class="form-group col-sm-12">
          <label class="form-label">Novedad: </label>
          <textarea name="novedadDetalleParte" id="novedadDetalleParte" class="form-control"></textarea>
        </div>                  
      </div>

      <div class="row">
        <div class="form-group col-sm-12">
          <label class="form-label">Requerimiento/Solución: </label>
          <textarea name="requerimientoSolucionDetalleParte" id="requerimientoSolucionDetalleParte" class="form-control"></textarea>
        </div>                  
      </div>

      <div class="row">
        


        <div class="form-group col-sm-4">
          <label class="form-label">Fecha/hora reporte del daño: </label>
          <input type="text" name="fechaFalloDetalleParte" id="fechaFalloDetalleParte" class="form-control required">
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

  d = new Date();
  var fechaHoraActual = d.fechaHoraActual();
  $("#btnEnviarParte").css("display", "none");

  $('#fechaFalloDetalleParte').datetimepicker({
   format:'Y-m-d H:i:s',
   value : fechaHoraActual,
   step : 10
  });

  $('#fechaParte').datetimepicker({
    timepicker:false,
    format: 'Y-m-d'
  });

  $("#idCae").on("change", function(){
    $("#listadoDatos").empty();
  });

  $("#btnEnviarParte").on("click", function(){
      if($("#idParte").val()){
      }
      else{
        swal("Información!", "No hay parte reportado", "warning"); 
      }
  });
    
  $("#btnTieneNovedadParte").on("click", function(){
    if($("#idCae").val()){
       Swal({
          title: 'Generar parte?',
          text: 'Se creará el registro!',
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Si',
          cancelButtonText: 'No'
        }).then((result) => {
          if (result.value) {
              var formData = $("#formParte").serialize();
              $.ajax({
                type : 'post',
                url  : "<?php echo site_url('Partes/gestionRegistro'); ?>",
                dataType: 'json',
                data: formData
              })  
              .done(function(data){
                  $(data).each(function(i, v){
                    $("#idParte").val(v.idParte);
                  });              
                  cargarFormularioDetallePadre($("#idParte").val());
                  listarDetalleParte($("#idParte").val());
                  $().toastmessage('showSuccessToast', "Parte procesado correctamente");
                  $("#btnEnviarParte").css("display", "block");
              })
              .fail(function(){
                  $().toastmessage('showErrorToast', "Error: No se pudo procesar el parte");
              })   
              .always(function(){
                  //listarDatos();

              });
          // For more information about handling dismissals please visit
          // https://sweetalert2.github.io/#handling-dismissals
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal(
              'Cancelado',
              'No se ha registrado :)',
              'error'
            )
          }
        })
    }else{
      swal("Información!", "Debe elegir un CAE", "error"); 
    }    
  });

function cargarFormularioDetallePadre(idParte){
    var urlCode = "<?php echo $urlCode; ?>";
      $("#listadoDatos").load("<?php echo site_url('DetallesPartes/formulario'); ?>",{urlCode, idParte}, function(responseText, statusText, xhr){
        if(statusText == "success"){
          cerrarGif();
        }
        if(statusText == "error"){
          swal("Información!", "No se pudo cargar el formulario para ingreso de Partes", "info"); 
          cerrarGif();
        }
      });
}


function buscarSectoresCae(idCae){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('Sectores/buscarSectoresCae'); ?>",
      dataType: 'json',
      data: {
        idCae   : idCae
      },
    }).done( function(data) {
      $('#idSector').find('option').remove();
        $('#idSector').append('<option value="">SELECCIONE...</option');
      $(data).each(function(i, v){
        $('#idSector').append('<option value="'+ v.idSector +'">' + v.nombreSector+ '</option');
      })              
    }).fail( function() {
      swal("Información!", "No se pudierson cargar los sectores", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });  
}


function buscarPersonalCae(idCae){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('Personales/buscarPersonalCae'); ?>",
      dataType: 'json',
      data: {
        idCae   : idCae
      },
    }).done( function(data) {
      $('#idPersonal').find('option').remove();
      $(data).each(function(i, v){
        $('#idPersonal').append('<option value="'+ v.idPersonal +'">' + v.datoPersonal+ '</option');
      })              
    }).fail( function() {
      swal("Información!", "No se pudo cargar el Personal", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });  
}

function buscarEstacionesSector(aObject){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('Estaciones/buscarEstacionesSector'); ?>",
      dataType: 'json',
      data: {
        idSector   : $(aObject).val(),
      },
    }).done( function(data) {
      $('#idEstacion').find('option').remove();
        $('#idEstacion').append('<option value="">SELECCIONE...</option');
      $(data).each(function(i, v){
        $('#idEstacion').append('<option value="'+ v.idEstacion +'">' + v.nombreEstacion+ '</option');
      })              
    }).fail( function() {
      swal("Información!", "No se pudierson cargar las estaciones", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    }); 
}

function buscarTiposExistenciasEstacion(aObject){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('TiposExistencias/buscarTiposExistenciasEstacionParte'); ?>",
      dataType: 'json',
      data: {
        idEstacion   : $(aObject).val(),
      },
    }).done( function(data) {
      $('#idTipoExistencia').find('option').remove();
      $(data).each(function(i, v){
        $('#idTipoExistencia').append('<option value="'+ v.idTipoExistencia +'">' + v.nombreTipoExistencia+ '</option');
      })              
    }).fail( function() {
      swal("Información!", "No se pudieron cargar los equipos", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });  
}

/*------ Detalle Parte -----*/

function gestionRegistroDetalleParte(aObject){
  if($("#idTipoExistencia").val() > 0){

    $("#idTipoExistenciaDetalleParte").find('option').remove();
    $('#idTipoExistencia option:selected').clone().appendTo("#idTipoExistenciaDetalleParte");

    switch($(aObject).data('accion')){
      case 'insertarRegistro':
          $("#formDetalleParte")[0].reset();
          $("#idDetalleParte").val("");
          $("#modalFormularioDetalleParte").modal('show'); 
          $("#tituloModal").text("Nuevo Registro");
      break;
      case 'editarRegistro':
          $("#modalFormularioDetalleParte").modal('show'); 
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
                    url  : "<?php echo site_url('DetallesPartes/eliminarRegistro'); ?>",
                    dataType: 'json',
                    data: {
                          idDetalleParte : $(aObject).data('id'),
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
                    listarDetalleParte($("#idParte").val());
                  });

            }
          })

      break;
      default:      
      break;
    }
  }
  else{
    swal("Información!", "Debe seleccionar un Equipo de la lista", "warning"); 
  }
}

$(document).ready(function() {

 $('#formDetalleParte').validate({
  rules: {
   novedadDetalleParte: {
    required: true
   },
   requerimientoSolucionDetalleParte: {
    required: true
   },
   fechaFalloDetalleParte: {
    required: true
   }
  },
  messages: {
   novedadDetalleParte: {
    required: "Ingrese una novedad"
   },
   requerimientoSolucionDetalleParte: {
    required: "Ingrese una texto"
   },
   fechaFalloDetalleParte: {
    required: "Ingrese fecha y hora"
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
   $.post("<?php echo site_url('DetallesPartes/gestionRegistro')?>", $("#formDetalleParte").serialize())
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
       listarDetalleParte($("#idParte").val());
       $("#modalFormularioDetalleParte").modal('hide');
       $("#formDetalleParte").find('.error').removeClass("error");
       $("#formDetalleParte").find('.success').removeClass("success");
       $("#formDetalleParte").find('.valid').removeClass("valid");
     });
  }
 });
}); // end document.ready


function editarRegistro(aId){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('DetallesPartes/buscarRegistroPorID'); ?>",
      dataType: 'json',
      data: {
        idDetalleParte : aId,
      },
    }).done( function(data) {
      $(data).each(function(i, v){
        $("#idDetalleParte").val(v.idDetalleParte);
        $("#novedadDetalleParte").val(v.novedadDetalleParte);
        $("#requerimientoSolucionDetalleParte").val(v.requerimientoSolucionDetalleParte);
        $("#fechaFalloDetalleParte").val(v.fechaFalloDetalleParte);
        $('#idTipoExistenciaDetalleParte').find('option').remove();
        $('#idTipoExistenciaDetalleParte').append('<option value="'+v.idTipoExistencia+'">'+v.nombreTipoExistencia+'</option>');
      });              
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });
}

function listarDetalleParte(idParte){
    var urlCode = "<?php echo $urlCode; ?>";
      $("#listadoDatosDetalle").load("<?php echo site_url('DetallesPartes/lista'); ?>",{urlCode, idParte}, function(responseText, statusText, xhr){
        if(statusText == "success"){
          cerrarGif();
        }
        if(statusText == "error"){
          swal("Información!", "No se pudo cargar el detalle del Parte", "info"); 
          cerrarGif();
        }
      });
}

</script>