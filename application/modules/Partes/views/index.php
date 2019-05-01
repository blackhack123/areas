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
                  
                </div>
              </div>
      
              <div class="row card-body">
                
                <div class="form-group col-sm-4">
                  <label class="form-label">CAE: </label>
                  <select name="idCae" id="idCae" class="form-control" onchange="buscarPersonalCae(this);">
                    <option value="">SELECCIONE...</option>
                    <?php foreach ($cae as $dt){ ?>
                    <option value="<?php echo $dt->idCae; ?>"><?php echo $dt->nombreCae; ?></option>
                    <?php } ?>            
                  </select>
                </div>                  
                <div class="form-group col-sm-4">
                  <label class="form-label">Fecha: </label>
                  <input type="text" name="fechaParte" id="fechaParte" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                </div>  
                <div class="form-group col-sm-4">
                  <label class="form-label">Acción: </label>
                  <button type="button" class="btn btn-success" onclick="generarParteDiario();">Generar</button>
                </div>  

              </div>

              <div id="listadoDatos" class="card-body"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

<!-- Modal Parte-->
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
        
        <div class="form-group col-sm-2">
          <label class="form-label">Solucionado? </label>
          <select name="esSolucionadoParte" id="esSolucionadoParte" class="form-control">
            <option value="NO">NO</option>
            <option value="SI">SI</option>
          </select>
        </div>   

        <div class="form-group col-sm-4">
          <label class="form-label">N° horas fura de servicio día: </label>
          <input type="text" name="horasFueraServicioDiaParte" id="horasFueraServicioDiaParte" class="form-control">
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


<!-- Modal Comisión-->
<div id="modalFormularioComision" class="modal fade" role="dialog" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloModalComision"></h4>
      </div>
       
       <form id="formComision"  method="post" class="animate-form" >
        <input name="idComision" id="idComision" type="hidden" value="">
        <input name="idParteComision" id="idParteComision" type="hidden" value="">
        
      <div class="modal-body">
          
        <div class="row">
          <div class="form-group col-sm-6">
            <label class="form-label">Fecha Inicio: </label>
            <input type="text" name="fechaInicioComision" id="fechaInicioComision" class="form-control">
          </div>                  
          <div class="form-group col-sm-6">
            <label class="form-label">Fecha Fin: </label>
            <input type="text" name="fechaFinComision" id="fechaFinComision" class="form-control">
          </div>                  
        </div>

        <div class="row">
          <div class="form-group col-sm-12">
            <label class="form-label">Tipo de Mantenimiento: </label>
            <select name="idTipoMantenimiento" id="idTipoMantenimiento" class="form-control"></select>
          </div>                  
        </div>

      <div class="row">
        <div class="form-group col-sm-12">
          <label class="form-label">Situación Previa: </label>
          <textarea name="situacionPreviaComision" id="situacionPreviaComision" class="form-control"></textarea>
        </div>                  
      </div>

      <div class="row">
        <div class="form-group col-sm-12">
          <label class="form-label">Actividad Planificada: </label>
          <textarea name="actividadPlanificadaComision" id="actividadPlanificadaComision" class="form-control"></textarea>
        </div>                  
      </div>

      <div class="row">
        <div class="form-group col-sm-12">
          <label class="form-label">Personal asignado: </label>
          <select multiple class="form-control" name="idPersonal[]" id="idPersonal" data-live-search="true" style="width: 100%;">
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

    $("#idPersonal").select2({
        placeholder: "Seleccione el personal",
        allowClear: true,
        theme: "classic"
    });

$(document).ready(function () {
    $('#fechaParte').datetimepicker({
      timepicker:false,
      format: 'Y-m-d'
    });
    $('#fechaInicioComision').datetimepicker({
      timepicker:false,
      format: 'Y-m-d'
    });
    $('#fechaFinComision').datetimepicker({
      timepicker:false,
      format: 'Y-m-d'
    });



    cargarTipoMantenimiento();
});

  function cargarTipoMantenimiento(){

    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('TiposMantenimientos/buscarTiposMantenimientos');?>",
      dataType: 'json',
    }).done( function(data) {
      $('#idTipoMantenimiento').find('option').remove();
      $(data).each(function(i, v){
        $('#idTipoMantenimiento').append('<option value="'+ v.idTipoMantenimiento +'">' + v.nombreTipoMantenimiento+ '</option');
      })
    }).fail( function() {
      swal("Información!", "No se pudieron cargar los Tipos de Mantenimiento", "warning"); 
    }).always( function() {
      cerrarGif();
    });

  }

  function generarParteDiario(){
    if($("#idCae").val() == ""){
      $().toastmessage('showErrorToast', "Selecione un CAE");
    }
    else{
      cargarGif();
      var urlCode = "<?php echo $urlCode; ?>";
      var fechaParte = $("#fechaParte").val();
      var idCae = $("#idCae").val();
        $("#listadoDatos").load("<?php echo site_url('Partes/lista'); ?>",{urlCode, idCae, fechaParte}, function(responseText, statusText, xhr){
          if(statusText == "success"){
            cerrarGif();
          }
          if(statusText == "error"){
            swal("Información!", "No se pudo cargar listado de Partes Diarios", "info"); 
            cerrarGif();
          }
        });
    }
  }
  //listarDatos();

function gestionRegistroParte(aObject){
    var idParte = $(aObject).data('id');
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('Partes/buscarRegistroPorID'); ?>",
      dataType: 'json',
      data: {
        idParte   : idParte,
      },
    }).done( function(data) {
      $(data).each(function(i, v){
        $("#idParte").val(v.idParte);
        $("#novedadParte").val(v.novedadParte);
        $("#seguimientoParte").val(v.seguimientoParte);
        $("#requerimientoSolucionParte").val(v.requerimientoSolucionParte);
        $("#esSolucionadoParte").val(v.esSolucionadoParte);
        $("#horasFueraServicioDiaParte").val(v.horasFueraServicioDiaParte);
      });  
      $("#modalFormulario").modal('show');            
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      $("#modalFormulario").modal('hide');
    });
}  



$(document).ready(function() {

 $('#formParte').validate({
  rules: {
   novedadParte: {
    required: true
   },
   seguimientoParte: {
    required: true
   }
  },
  messages: {
   novedadParte: {
    required: "Ingrese una novedad (S.N. para ninguna)"
   },
   seguimientoParte: {
    required: "Ingrese una texto (S.N. para ninguna)"
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
       generarParteDiario()
       $("#modalFormulario").modal('hide');
       $("#formParte").find('.error').removeClass("error");
       $("#formParte").find('.success').removeClass("success");
       $("#formParte").find('.valid').removeClass("valid");
     });
  }
 });
}); // end document.ready


function buscarPersonalCae(aObject){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('Personales/buscarPersonalCae'); ?>",
      dataType: 'json',
      data: {
        idCae   : $(aObject).val(),
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

//gestionar la comision
function gestionRegistroParteComision(aObject){
  
  /*Swal.fire({
    title: 'Desea gestionar la(s) Comisión(es) para este Parte?',
    text: 'Se creará un caso pendiente de aprobación.',
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Si, crear Comisión',
    cancelButtonText: 'No'
  }).then((result) => {
    if (result.value) {
        
      var idParte = $(aObject).data("id");
      listarDatosComision(idParte);

    // For more information about handling dismissals please visit
    // https://sweetalert2.github.io/#handling-dismissals
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      Swal.fire(
        'Cancelado',
        'El parte queda pendiente de solución :(',
        'error'
      )
    }
  })*/

      var idParte = $(aObject).data("id");
      listarDatosComision(idParte);

}

function listarDatosComision(idParte){
  
  var urlCode = "<?php echo $urlCode; ?>";
  $("#listadoDatos").load("<?php echo site_url('Comisiones/listaComisionParte'); ?>",{urlCode, idParte}, function(responseText, statusText, xhr){
    if(statusText == "success"){
      cerrarGif();
    }
    if(statusText == "error"){
      swal("Información!", "No se pudo cargar listado de Comisiones", "info"); 
      cerrarGif();
    }
  });
}

function gestionRegistroComision(aObject){
  switch($(aObject).data('accion')){
    case 'insertarRegistro':
        $("#formComision")[0].reset();
        $("#idComision").val("");
        $("#modalFormularioComision").modal('show');
        $("#tituloModalComision").text("Nuevo Registro");
    break;
    case 'editarRegistro':
        $("#modalFormularioComision").modal('show');
        $("#tituloModalComision").text("Editar Registro");
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
                  url  : "<?php echo site_url('Comisiones/eliminarRegistro'); ?>",
                  dataType: 'json',
                  data: {
                        idComision   : $(aObject).data('id'),
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
                  listarDatosComision($("#idParteComision").val());
                });

          }
        })

    break;
    default:      
    break;
  }
}

$(document).ready(function() {

 $('#formComision').validate({
  rules: {
   fechaInicioComision: {
    required: true,
    date: true
   },
   fechaFinComision: {
    required: true,
    date: true
   },
   situacionPreviaComision: {
    required: true
   },
   actividadPlanificadaComision: {
    required: true
   }
  },
  messages: {
   fechaInicioComision: {
    required: "Ingrese una fecha inicial"
   },
   fechaFinComision: {
    required: "Ingrese una fecha final"
   },
   situacionPreviaComision: {
    required: "Ingrese la situación previa"
   },
   actividadPlanificadaComision: {
    required: "Ingrese la actividad planificada"
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
   $.post("<?php echo site_url('Comisiones/gestionRegistro')?>", $("#formComision").serialize())
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
            $("#formComision")[0].reset();
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
      listarDatosComision($("#idParteComision").val());
       $("#modalFormularioComision").modal('hide');
       $("#formComision").find('.error').removeClass("error");
       $("#formComision").find('.success').removeClass("success");
       $("#formComision").find('.valid').removeClass("valid");
     });
  }
 });
}); // end document.ready

function editarRegistro(aId){
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('Comisiones/buscarRegistroPorID'); ?>",
      dataType: 'json',
      data: {
        idComision   : aId,
      },
    }).done( function(data) {
      $(data).each(function(i, v){
        $("#idComision").val(v.idComision);
        buscarPersonalComision(v.idComision);
        $("#fechaInicioComision").val(v.fechaInicioComision);
        $("#fechaFinComision").val(v.fechaFinComision);
        $("#idTipoMantenimiento").val(v.idTipoMantenimiento);
        $("#situacionPreviaComision").val(v.situacionPreviaComision);
        $("#actividadPlanificadaComision").val(v.actividadPlanificadaComision);
      });              
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });
}

function buscarPersonalComision(idComision){
    var array = [];
    var i = 0;
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('ComisionesPersonales/buscarPersonalComision'); ?>",
      dataType: 'json',
      data: {
        idComision   : idComision,
      },
    }).done( function(data) {
      $(data).each(function(i, v){   
        array[i] = v.idPersonal; i++;
      });
      $('#idPersonal').val(array).trigger("change"); 
    }).fail( function() {
      swal("Información!", "No se pudo cargar el personal de la comisión", "warning"); 
    }).always( function() {
      //alert( 'Always' );
    });
}


$("#idPersonal").on("select2:select", function (e) {

  if($("#idComision").val() > 0){
    $.ajax({
      url  : "<?php echo site_url('ComisionesPersonales/agregarPersonalAComision'); ?>",
      type : "POST",
      dataType : "JSON",
      data  : {
          idComision : $("#idComision").val(),
          idPersonal : e.params.data.id
      },
      success: function(data){
        $().toastmessage('showSuccessToast', "Personal correctamente asignado");
      },
      complete: function(){
        //cerrarGif();
      },
      error: function(){
        $().toastmessage('showErrorToast', "No de pudo asignar el Personal");
      }    
    });  
  }

});


$("#idPersonal").on("select2:unselect", function (e) {

  if($("#idComision").val() > 0){
    $.ajax({
      url  : "<?php echo site_url('ComisionesPersonales/eliminarPersonalDeComision'); ?>",
      type : "POST",
      dataType : "JSON",
      data  : {
          idComision : $("#idComision").val(),
          idPersonal : e.params.data.id
      },
      success: function(data){
        $().toastmessage('showNoticeToast', "Personal eliminado");
      },
      complete: function(){
        //cerrarGif();
      },
      error: function(){
        $().toastmessage('showErrorToast', "No de pudo eliminar el Personal de la comisión");
      }    
    });  
  }

});

</script>