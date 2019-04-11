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
                  <select name="idCae" id="idCae" class="form-control" onchange="">
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

</script>