
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
                <h3 class="card-title"><?php echo $menuNombre; ?></h3>
                <div class="card-options">
                </div>
              </div>

            <div id="listadoDatos" class="card-body">

              <form name="formUnidad" id="formUnidad">
                <input type="hidden" name="idUnidad" id="idUnidad" value="<?php echo isset($unidad->idUnidad) ? $unidad->idUnidad : ''; ?>">
                <input type="hidden" name="logoUnidadAuxiliar" id="logoUnidadAuxiliar" value="<?php echo isset($unidad->logoUnidad) ? $unidad->logoUnidad : ''; ?>">
                <div class="row">
                  
                  <div class="col-sm-4">
                    <div class="kv-avatar center-block text-center form-control">
                      <center>
                      <input id="logoUnidad" name="logoUnidad" type="file" class="file-loading form-control" value="<?php echo isset($unidad->logoUnidad) ? $unidad->logoUnidad : ''; ?>">
                      </center>
                    </div>
                  </div>
                  <div class="col-sm-8">

                    <div class="row">
                        <div class="form-group col-sm-12">
                          <label class="form-label">Nombre del Comando: </label>
                          <input type="text" class="form-control" name="nombreComandoUnidad" id="nombreComandoUnidad" placeholder="" value="<?php echo isset($unidad->nombreComandoUnidad) ? $unidad->nombreComandoUnidad : ''; ?>">
                        </div>                  
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-sm-12">
                          <label class="form-label">Nombre de la Unidad: </label>
                          <input type="text" class="form-control" name="nombreUnidad" id="nombreUnidad" placeholder="" value="<?php echo isset($unidad->nombreUnidad) ? $unidad->nombreUnidad : ''; ?>">
                        </div>                  
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                          <label class="form-label">Abreviatura: </label>
                          <input type="text" class="form-control" name="abreviaturaUnidad" id="abreviaturaUnidad" placeholder="" value="<?php echo isset($unidad->abreviaturaUnidad) ? $unidad->abreviaturaUnidad : ''; ?>">
                        </div>                  
                        <div class="form-group col-sm-6">
                          <label class="form-label">Correo: </label>
                          <input type="text" class="form-control" name="emailUnidad" id="emailUnidad" placeholder="" value="<?php echo isset($unidad->emailUnidad) ? $unidad->emailUnidad : ''; ?>">
                        </div>                  
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                          <label class="form-label">Teléfono Fijo: </label>
                          <input type="text" class="form-control" name="telefonoFijoUnidad" id="telefonoFijoUnidad" placeholder="" value="<?php echo isset($unidad->telefonoFijoUnidad) ? $unidad->telefonoFijoUnidad : ''; ?>">
                        </div>                  
                        <div class="form-group col-sm-6">
                          <label class="form-label">Teléfono Móvil: </label>
                          <input type="text" class="form-control" name="telefonoMovilUnidad" id="telefonoMovilUnidad" placeholder="" value="<?php echo isset($unidad->telefonoMovilUnidad) ? $unidad->telefonoMovilUnidad : ''; ?>">
                        </div>                  
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                          <label class="form-label">Dirección: </label>
                          <input type="text" class="form-control" name="direccionUnidad" id="direccionUnidad" placeholder="" value="<?php echo isset($unidad->direccionUnidad) ? $unidad->direccionUnidad : ''; ?>">
                        </div>                  
                    </div>
                    
                    <button type="submit" class="btn btn-success btn-block"><i class="fa fa-save"></i> Grabar</button>

                  </div>

                </div>
              </form>

            </div>

            </div>

          </div>
        </div>
      </div>
    </div>


<script type="text/javascript">

var btnCust ='';
var direcion = "<?php echo isset($unidad->logoUnidad) ?  $unidad->logoUnidad : 'default_avatar.jpg'; ?>"
var defaultImage = "<?php echo base_url();?>application/modules/Unidades/photos/"+direcion;

//alert(defaultImage);

$("#logoUnidad").fileinput({
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

$(document).ready(function() {
  $('#formUnidad').validate({
    rules: {
     nombreUnidad: {
      required: true
     },    
     abreviaturaUnidad: {
      required: true
     },
     direccionUnidad: {
      required: true
     },
     correoUnidad: {
      required: true,
      email: true
     } 
    },
    messages: {
      nombreUnidad: {
        required: "Ingrese un nombre"
      },
      abreviaturaUnidad: {
        required: "Ingrese la abreviatura"
      },
      direccionUnidad: {
        required: "Ingrese una dirección"
      },
      correoUnidad: {
        required: "Ingrese un correo",
        email : "El correo es incorrecto"
      }  
    },
    highlight: function(element) {
      $(element).closest('.row').removeClass('success').addClass('error');
    },
    success: function(element) {
      element.addClass('valid').closest('.row').removeClass('error').addClass('success');
    },
    submitHandler: function(form) {
      cargarGif();
      var formData = new FormData($('#formUnidad')[0]);
      $.ajax({
        type : 'post',
        url  : "<?php echo site_url('Unidades/gestionRegistro'); ?>",
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
                $('#idUnidad').val(row[1].replace('"',''));   
                $().toastmessage('showSuccessToast', "Registro creado correctamente");
              break;
              case 'e':
                $().toastmessage('showSuccessToast', "Editado exitosamente");
              break;
            }
          }else{
            $().toastmessage('showErrorToast', "No se pudo procesar la información");
          }
        },
        complete:function(){
          cerrarGif();
        },     
        error:function(err){
          $().toastmessage('showErrorToast', "Error: No se pudo procesar la información "+err); 
        }   
      });                                          
    }
  });
});


</script>