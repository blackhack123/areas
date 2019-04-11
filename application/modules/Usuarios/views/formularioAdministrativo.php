<hr>
<h3>Datos del usuario</h3>
<form name="formUsuario" id="formUsuario">
	<input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo isset($usuario->idUsuario) ? $usuario->idUsuario : ''; ?>">
	
  <input type="hidden" name="idPersonalUsuario" id="idPersonalUsuario" >
	
	<div class="row">
		<div class="form-group col-sm-4">
			<label class="form-label">Usuario: </label>
			<input type="text" class="form-control" name="usuarioUsuario" id="usuarioUsuario" placeholder="" value="<?php echo isset($usuario->usuarioUsuario) ? $usuario->usuarioUsuario : ''; ?>">
		</div>
		<div class="form-group col-sm-4">
			<label class="form-label">Email: </label>
			<input type="text" class="form-control" name="emailUsuario" id="emailUsuario" placeholder="" value="<?php echo isset($usuario->emailUsuario) ? $usuario->emailUsuario : ''; ?>">
		</div>
		<div class="form-group col-sm-4">
			<label class="form-label">Estado: </label>
			<select class="form-control" id="estadoUsuario" name="estadoUsuario" required>
                <?php $seleccion = $usuario->estadoUsuario=='I'?'selected=selected' :''; ?>
                <option <?php echo $seleccion; ?> value="I">INACTIVO</option>
                <?php $seleccion = $usuario->estadoUsuario=='A'?'selected=selected' :''; ?>
                <option <?php echo $seleccion; ?> value="A">ACTIVO</option>
            </select>          
		</div>
	</div>

	<div class="row">
		<div class="form-group col-sm-4">
			<label class="form-label">Clave: </label>
			<input type="text" class="form-control" name="claveUsuario" id="claveUsuario" placeholder="" value="<?php echo isset($usuario->claveUsuario) ? $usuario->claveUsuario : ''; ?>">
		</div>
		<div class="form-group col-sm-4">
			<label class="form-label">Es Superadmin?: </label>
			<select class="form-control" id="esSuperadminUsuario" name="esSuperadminUsuario" required>
                <?php $seleccion = $usuario->esSuperadminUsuario=='N'?'selected=selected' :''; ?>
                <option <?php echo $seleccion; ?> value="N">NO</option>
                <?php $seleccion = $usuario->esSuperadminUsuario=='S'?'selected=selected' :''; ?>
                <option <?php echo $seleccion; ?> value="S">SI</option>
            </select>          
		</div>
	</div>

  <div class="row">
    <div class="col-sm-12">
      <label for="idPerfil">Perfil: <span class="kv-reqd">*</span></label>
      <select multiple class="form-control select2" name="perfilUsuario[]" id="idPerfil" data-live-search="true">
        <?php foreach($perfil as $dp){ ?>
        <option value="<?php echo $dp->idPerfil;?>"><?php echo $dp->nombrePerfil; ?></option>
        <?php } ?>        
      </select>
    </div>
  </div>
  
  <br>
    <div class="row">
        <div class="form-group col-sm-4">
        </div>
        <div class="form-group col-sm-4">
            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-save"></i> Grabar Usuario</button>
        </div>
    </div>

</form>

<script type="text/javascript">

cargarPerfilesUsuario();

// Para los Perfiles

$("#idPerfil").select2({
    placeholder: "Seleccione uno o varios Perfiles",
    allowClear: true,
    theme: "classic"
});

$("#idPersonalUsuario").val("<?php echo $idPersonal; ?>");

$("#idPerfil").on("select2:select", function (e) {

  $.ajax({
    url  : "<?php echo site_url('UsuariosPerfiles/agregarPerfilAUsuario'); ?>",
    type : "POST",
    dataType : "JSON",
    data  : {
        idUsuario : $("#idUsuario").val(),
        idPerfil : e.params.data.id
    },
    success: function(data){
      $().toastmessage('showSuccessToast', "Perfil correctamente asignado");
    },
    complete: function(){
      //cerrarGif();
    },
    error: function(){
      $().toastmessage('showErrorToast', "No de pudo asignar el Perfil");
    }    
  });  

});


$("#idPerfil").on("select2:unselect", function (e) {

  $.ajax({
    url  : "<?php echo site_url('UsuariosPerfiles/eliminarPerfilDeUsuario'); ?>",
    type : "POST",
    dataType : "JSON",
    data  : {
        idUsuario : $("#idUsuario").val(),
        idPerfil : e.params.data.id
    },
    success: function(data){
      $().toastmessage('showNoticeToast', "Perfil eliminado");
    },
    complete: function(){
      //cerrarGif();
    },
    error: function(){
      $().toastmessage('showErrorToast', "No de pudo eliminar el Perfil");
    }    
  });  
});
// Fin de los Perfiles


$(document).ready(function() {
  $('#formUsuario').validate({
    rules: {
     usuarioUsuario: {
      required: true
     },    
     emailUsuario: {
      required: true,
      email: true
     },    
     claveUsuario: {
      required: true
     }
    },
    messages: {
      usuarioUsuario: {
        required: "Ingrese un nombre de Usuario"
      },
      emailUsuario: {
        required: "Ingrese un correo para el inicio de sesión",
        email: "Ingrese un correo válido"
      },
      claveUsuario: {
        required: "Ingrese una clave"
      }
    },
    highlight: function(element) {
      $(element).closest('.row').removeClass('success').addClass('error');
    },
    success: function(element) {
      element.addClass('valid').closest('.row').removeClass('error').addClass('success');
    },
    submitHandler: function(form) {
      //$("#idPersonalUsuario").val($("#idUsuario").val());
      cargarGif();
      var formData = new FormData($('#formUsuario')[0]);
      $.ajax({
        type : 'post',
        url  : "<?php echo site_url('Usuarios/gestionRegistro'); ?>",
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
                $('#idUsuario').val(row[1].replace('"',''));   
                $().toastmessage('showSuccessToast', "Registro creado correctamente");
                $("#idPerfil").prop("disabled", false);
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
          //listarDatos();
          cerrarGif();
        },     
        error:function(err){
          $().toastmessage('showErrorToast', "Error: No se pudo procesar la información "+err); 
        }   
      });                                          
    }
  });
});	

function cargarPerfilesUsuario(){
  var idUsuario = $("#idUsuario").val();
  
  if(idUsuario > 0){

    $("#idPerfil").prop("disabled", false);
    
    $.ajax({
      url  : "<?php echo site_url('UsuariosPerfiles/buscarPerfilDeUsuario'); ?>",
      type : "POST",
      dataType : "JSON",
      data  : {
          idUsuario : $("#idUsuario").val()
      },
      success: function(data){
        $().toastmessage('showSuccessToast', "Perfiles de Usuario encontrados");
        var usuarioPerfil = data;
        var location_array= usuarioPerfil.split(',');                
        $('#idPerfil').val(location_array).trigger("change");
      },
      complete: function(){
        //cerrarGif();
      },
      error: function(){
        $().toastmessage('showErrorToast', "No se pudieron cargar los perfiles");
      }    
    }); 

  }else{
    $("#idPerfil").prop("disabled", true);
  }
}

</script>