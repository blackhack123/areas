<script type="text/javascript">
    $("#btnGestionRegistroPersonal").hide();
    $("#btnGestionVolverPersonal").show();	
</script>


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
  $("#tituloPagina").text("<?php echo $tituloPagina; ?>");
</script>

<form name="formPersonal" id="formPersonal">
    <input type="hidden" name="idPersonal" id="idPersonal" value="<?php echo isset($personal->idPersonal) ? $personal->idPersonal : ''; ?>">
    <input type="hidden" name="fotoPersonalAuxiliar" id="fotoPersonalAuxiliar" value="<?php echo isset($personal->fotoPersonal) ? $personal->fotoPersonal : ''; ?>">

    <div class="row">
        <div class="col-sm-4">
            <div class="kv-avatar center-block text-center form-control">
            <center>
            <input id="fotoPersonal" name="fotoPersonal" type="file" class="file-loading form-control" value="<?php echo isset($personal->fotoPersonal) ? $personal->fotoPersonal : ''; ?>">
            </center>
        </div>
    </div>
    <div class="col-sm-8">


        <div class="row">
            <div class="form-group col-sm-8">
                <label class="form-label">Fuerza: </label>
                <select name="idFuerza" id="idFuerza" class="form-control" onchange="cargarGradosFuerza(this);">
                	<option value="">SELECCIONE...</option>
                	<?php foreach ($fuerza as $dt){ ?>
                		<?php $seleccion = $idFuerza == $dt->idFuerza ? "selected=selected" : ""; ?>
                		<option value="<?php echo $dt->idFuerza; ?>" <?php echo $seleccion; ?>><?php echo $dt->nombreFuerza; ?></option>
                	<?php } ?>
                </select>
            </div>                  
            <div class="form-group col-sm-4">
                <label class="form-label">Nombres: </label>
                <select name="idGrado" id="idGrado" class="form-control">
                	<?php foreach ($grado as $dt){ ?>
                		<?php $seleccion = $idGrado == $dt->idGrado ? "selected=selected" : ""; ?>
                		<option value="<?php echo $dt->idGrado; ?>" <?php echo $seleccion; ?>><?php echo $dt->nombreGrado; ?></option>
                	<?php } ?>
                </select>
            </div>                  
        </div>

        <div class="row">
            <div class="form-group col-sm-12">
                <label class="form-label">Funci??n: </label>
                <select name="idFuncion" id="idFuncion" class="form-control">
                  <?php foreach ($funcion as $dt){ ?>
                    <?php $seleccion = $idFuncion == $dt->idFuncion ? "selected=selected" : ""; ?>
                    <option value="<?php echo $dt->idFuncion; ?>" <?php echo $seleccion; ?>><?php echo $dt->nombreFuncion; ?></option>
                  <?php } ?>
                </select>
            </div>                  
        </div>

        <div class="row">
            <div class="form-group col-sm-6">
                <label class="form-label">Apellidos: </label>
                <input type="text" class="form-control" name="apellidoPersonal" id="apellidoPersonal" placeholder="" value="<?php echo isset($personal->apellidoPersonal) ? $personal->apellidoPersonal : ''; ?>">
            </div>                  
            <div class="form-group col-sm-6">
                <label class="form-label">Nombres: </label>
                <input type="text" class="form-control" name="nombrePersonal" id="nombrePersonal" placeholder="" value="<?php echo isset($personal->nombrePersonal) ? $personal->nombrePersonal : ''; ?>">
            </div>                  
        </div>

        <div class="row">
            <div class="form-group col-sm-4">
                <label class="form-label">Fecha de Nacimiento: </label>
                <input type="text" class="form-control" name="fechaNacimientoPersonal" id="fechaNacimientoPersonal" placeholder="AAAA-MM-DD" value="<?php echo isset($personal->fechaNacimientoPersonal) ? $personal->fechaNacimientoPersonal : ''; ?>">
            </div>                  
            <div class="form-group col-sm-6">
                <label class="form-label">Estado Civil: </label>
                <select name="idEstadoCivil" id="idEstadoCivil" class="form-control">
                	<?php foreach ($estadoCivil as $dt){ ?>
                		<?php $seleccion = $idEstadoCivil == $dt->idEstadoCivil ? "selected=selected" : ""; ?>
                		<option value="<?php echo $dt->idEstadoCivil; ?>" <?php echo $seleccion; ?>><?php echo $dt->nombreEstadoCivil; ?></option>
                	<?php } ?>
                </select>
            </div>                  
            <div class="form-group col-sm-2">
                <label class="form-label">Tipo Sangre: </label>
				<select class="form-control" id="tipoSangrePersonal" name="tipoSangrePersonal" required>
                      <?php $seleccion = $personal->tipoSangrePersonal=='A+'?'selected=selected' :''; ?>
                      <option <?php echo $seleccion; ?> value="A+">A+</option>
                      <?php $seleccion = $personal->tipoSangrePersonal=='A-'?'selected=selected' :''; ?>
                      <option <?php echo $seleccion; ?> value="A-">A-</option>
                      <?php $seleccion = $personal->tipoSangrePersonal=='B+'?'selected=selected' :''; ?>
                      <option <?php echo $seleccion; ?> value="B+">B+</option>
                      <?php $seleccion = $personal->tipoSangrePersonal=='B-'?'selected=selected' :''; ?>
                      <option <?php echo $seleccion; ?> value="B-">B-</option>
                      <?php $seleccion = $personal->tipoSangrePersonal=='AB+'?'selected=selected' :''; ?>
                      <option <?php echo $seleccion; ?> value="AB+">AB+</option>
                      <?php $seleccion = $personal->tipoSangrePersonal=='AB-'?'selected=selected' :''; ?>
                      <option <?php echo $seleccion; ?> value="AB-">AB-</option>
                      <?php $seleccion = $personal->tipoSangrePersonal=='O+'?'selected=selected' :''; ?>
                      <option <?php echo $seleccion; ?> value="O+">O+</option>
                      <?php $seleccion = $personal->tipoSangrePersonal=='O-'?'selected=selected' :''; ?>
                      <option <?php echo $seleccion; ?> value="O-">O-</option>                  
                </select>
            </div>                  
        </div>

        <div class="row">
            <div class="form-group col-sm-6">
                <label class="form-label">Tipo Identificaci??n: </label>
                <select name="tipoIdentificacionPersonal" id="tipoIdentificacionPersonal" class="form-control">
                	<option value="C">C??DULA</option>
                </select>
            </div>                  
            <div class="form-group col-sm-6">
                <label class="form-label">N??mero de Identificaci??n: </label>
                <input type="text" class="form-control" name="numeroIdentificacionPersonal" id="numeroIdentificacionPersonal" placeholder="10 d??gitos" value="<?php echo isset($personal->numeroIdentificacionPersonal) ? $personal->numeroIdentificacionPersonal : ''; ?>">
            </div>                  
        </div>

        <div class="row">
            <div class="form-group col-sm-12">
                <label class="form-label">Direcci??n: </label>
                <input type="text" class="form-control" name="direccionPersonal" id="direccionPersonal" placeholder="" value="<?php echo isset($personal->direccionPersonal) ? $personal->direccionPersonal : ''; ?>">
            </div>                  
        </div>

        <div class="row">
            <div class="form-group col-sm-6">
                <label class="form-label">Tel??fono Fijo: </label>
                <input type="text" class="form-control" name="telefonoFijoPersonal" id="telefonoFijoPersonal" placeholder="" value="<?php echo isset($personal->telefonoFijoPersonal) ? $personal->telefonoFijoPersonal : ''; ?>">
            </div>                  
            <div class="form-group col-sm-6">
                <label class="form-label">Tel??fono Movil: </label>
                <input type="text" class="form-control" name="telefonoMovilPersonal" id="telefonoMovilPersonal" placeholder="" value="<?php echo isset($personal->telefonoMovilPersonal) ? $personal->telefonoMovilPersonal : ''; ?>">
            </div>                  
        </div>

        <div class="row">
            <div class="form-group col-sm-12">
                <label class="form-label">Email: </label>
                <input type="text" class="form-control" name="emailPersonal" id="emailPersonal" placeholder="" value="<?php echo isset($personal->emailPersonal) ? $personal->emailPersonal : ''; ?>">
            </div>                  
        </div>

         <button type="submit" class="btn btn-success btn-block"><i class="fa fa-save"></i> Grabar</button>

    </div>
                    
       
 </div>
</form>



<script type="text/javascript">

var btnCust ='';
var direcion = "<?php echo isset($personal->fotoPersonal) ?  $personal->fotoPersonal : 'default_avatar.jpg'; ?>"
var defaultImage = "<?php echo base_url();?>application/modules/Personales/photos/"+direcion;

//alert(defaultImage);

$("#fotoPersonal").fileinput({
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
    allowedFileExtensions: ["jpg", "jpeg"]
});  

$(document).ready(function() {
  $('#formPersonal').validate({
    rules: {
     idFuerza: {
      required: true
     },    
     idGrado: {
      required: true
     },    
     nombrePersonal: {
      required: true
     },    
     apellidoPersonal: {
      required: true
     },
     fechaNacimientoPersonal: {
      required: true,
      date: true
     },
     numeroIdentificacionPersonal: {
      required: true,
      maxlength: 10,
      minlength: 10
     },
     direccionPersonal: {
      required: true
     },
     emailPersonal: {
      required: true,
      email: true
     }
    },
    messages: {
      idFuerza: {
        required: "Seleccione una Fuerza"
      },
      idGrado: {
        required: "Seleccione un Grado"
      },
      nombrePersonal: {
        required: "Ingrese los nombres"
      },
      apellidoPersonal: {
        required: "Ingrese los apellidos"
      }, 
     fechaNacimientoPersonal: {
      required: "Ingrese una fecha AAAA-MM-DD",
      date: "Fecha incorrecta, es AAAA-MM-DD"
     },
     numeroIdentificacionPersonal: {
      required: "Ingrese un n??mero de Identificaci??n",
      maxlength: "M??ximo 10 d??gitos",
      minlength: "M??nimo 10 d??gitos"
     },
     direccionPersonal: {
      required: "Ingrese una direcci??n"
     },
     emailPersonal: {
      required: "Ingrese un correo",
      email: "El correo es incorrecto"
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
      var formData = new FormData($('#formPersonal')[0]);
      $.ajax({
        type : 'post',
        url  : "<?php echo site_url('Personales/gestionRegistro'); ?>",
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
                $('#idPersonal').val(row[1].replace('"',''));   
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
          listarDatos();
          cerrarGif();
        },     
        error:function(err){
          $().toastmessage('showErrorToast', "Error: No se pudo procesar la informaci??n "+err); 
        }   
      });                                          
    }
  });
});

function cargarGradosFuerza(aObject){
  var idFuerza = $(aObject).val();
  cargarGif();
  $.ajax({
    url      : "<?php echo site_url('Grados/buscarGradosFuerza');?>",
    type     : 'post',
    dataType : 'json',
    data     :{
                idFuerza : idFuerza,
             },
    success: function(data){
      $('#idGrado').find('option').remove();
      $(data).each(function(i, v){
        $('#idGrado').append('<option value="'+ v.idGrado +'">' + v.nombreGrado + '</option');
      })
    },
    complete: function(){
      cerrarGif();
    },
    error: function(){
      swal("Informaci??n!", "No se pudieron cargar los Grados", "info");
    }
  }); 
}

</script>