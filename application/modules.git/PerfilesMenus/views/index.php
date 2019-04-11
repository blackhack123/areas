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

              <div class="row">
                <div class="col-sm-1">
                  <label for="idperfil">Perfil:</label>
                </div>
                <div class="col-sm-3">
                  <select class="form-control" name="idPerfil" id="idPerfil" onchange="buscarMenuAsociadoPerfil(); buscarMenusDisponibles();" >
                    <option value="">Seleccione...</option>   
                    <?php if($perfil){ ?>
                      <?php foreach ($perfil as $data): ?>
                        <option value="<?php echo $data->idPerfil; ?>"><?php echo $data->nombrePerfil;?></option>
                      <?php endforeach ?>
                    <?php } ?>     
                  </select>
                </div>
                <div class="col-sm-1">
                  <label for="idMenu">Menú:</label>
                </div>
                <div class="col-sm-5">
                  <div class="input-group"> 
                    <select class="form-control" name="idMenu" id="idMenu">
                    </select>
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-default" onclick="agregarRegistro();" <?php echo $status; ?>>Agregar</button>
                    </span>  
                  </div>
                </div>
              </div>
              

            
            </div>
            <div id="listadoDatos" class="box-body">
            </div>
          </div>
        </div>
      </div>
    </div>

<script type="text/javascript">

function buscarMenuAsociadoPerfil(){
  var idPerfil = $("#idPerfil").val();
  var urlCode = "<?php echo $urlCode; ?>";
  //cargarGif();
  $("#listadoDatos").load("<?php echo site_url('PerfilesMenus/lista'); ?>",{idPerfil, urlCode}, function(responseText, statusText, xhr){
    if(statusText == "success"){
      cerrarGif();
    }
    if(statusText == "error"){
    swal("Información!", "No se pudo cargar la información", "info"); 
      //cerrarGif();
    }
  });
}

function buscarMenusDisponibles(){
  cargarGif();
  var idPerfil = $("#idPerfil").val();
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('PerfilesMenus/buscarMenusDisponiblesParaPerfil'); ?>",
      dataType: 'json',
      data: {
        idPerfil   : idPerfil,
      },
    }).done( function(data) {
      $('#idMenu').find('option').remove();
      $(data).each(function(i, v){
        $('#idMenu').append('<option value="'+ v.idMenu +'">' + v.nombreMenu+ '</option');
      });
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      cerrarGif();
    });  
}

function agregarRegistro(){
  var idMenu = $("#idMenu").val();
  if(idMenu){
    cargarGif();
    var idPerfil = $("#idPerfil").val();
    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('PerfilesMenus/agregarRegistro'); ?>",
      dataType: 'json',
      data: {
        idPerfil : idPerfil,
        idMenu   : idMenu,
      },
    }).done( function(data) {
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
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      cargarGif();
      buscarMenuAsociadoPerfil();
      buscarMenusDisponibles();
      cerrarGif();
    });  
  }
}

function editarPrivilegios(aObject){
  var idPerfilMenu = $(aObject).data("id");
  var idPerfil = $(aObject).data("idperfil");
  var idMenu = $(aObject).data("idmenu");
  var estadoPrivilegio = $(aObject).prop("checked") ? $(aObject).data("on") : $(aObject).data("off");
  var atributo = $(aObject).data("atributo");

    $.ajax({
      type : 'post',
      url  : "<?php echo site_url('PerfilesMenus/editarPrivilegios'); ?>",
      dataType: 'json',
      data: {
        idPerfilMenu : idPerfilMenu,
        idPerfil : idPerfil,
        idMenu : idMenu,
        estadoPrivilegio : estadoPrivilegio,
        atributo : atributo
      },
    }).done( function(data) {
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
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      buscarMenuAsociadoPerfil();
      cerrarGif();
    }); 

}

function eliminarRegistro(aObject){
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
        url  : "<?php echo site_url('PerfilesMenus/eliminarRegistro'); ?>",
        dataType: 'json',
        data: {
          idPerfilMenu : $(aObject).data("id"),
        },
      }).done( function(data) {
        if(data){
          $().toastmessage('showSuccessToast', "Registro eliminado");
        }else{
          $().toastmessage('showErrorToast', "No se pudo eliminar la información (registros enlazados)");
        }
    }).fail( function() {
      swal("Información!", "No se pudo cargar la información", "warning"); 
    }).always( function() {
      buscarMenuAsociadoPerfil();
      buscarMenusDisponibles();
      cerrarGif();
    }); 
    }
  }) 
}
</script>