<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <!-- Mobile Specific Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <!-- Font-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/login30/css/opensans-font.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/login30/fonts/line-awesome/css/line-awesome.min.css'); ?>">
  <!-- Jquery -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/login30/css/site-demos.css'); ?>">
  <!-- Main Style Css -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/login30/css/style.css'); ?>"/>
  
  <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>">


</head>
<body class="form-v4">
  <div class="page-content">
    <div class="form-v4-content">
      <div class="form-left">
        <h2>Consejos de seguridad</h2>
        
      <div class="text-element content-element circles-list">
      <ol>
        <li>Cuide que nadie observe mientras escribe su clave.</li>
        <li>No comparta su clave con otra persona.</li>
        <li>No habilite la opción de "recordar claves" en los programas que utilice.</li>
        <li>No envíe su clave por correo electrónico, mensajes de celular, mensajería instantánea, ni la divulgues en una conversación.</li>
        <li>Cambie su clave regularmente o con frecuencia establecida por la Unidad de Tecnología Información Digital.</li>
        
      </ol>
      </div>

      </div>
      <form class="form-detail" action="<?php echo base_url('Login/validarIngreso'); ?>" method="post" id="formLogin">
              
              <div class="form-row">
                <center>
                <img src="<?php echo base_url('assets/img/logo_cc.png'); ?>" style="height: 130px; width: 130px;";>
                </center>
              </div>

        <h2><center><?php echo $this->config->item('app-title'); ?></center></h2>
        
        <div class="form-group">
          <div class="form-row">
            <label for="first_name">Usuario / email:</label>
            <input type="text" class="input-text" name="emailUsuario" id="emailUsuario" aria-describedby="emailHelp" placeholder="Usuario / Email">
          </div>
        </div>
        
        <div class="form-group">
          <div class="form-row">
            <label for="your_email">Clave: </label>
            <input type="password" class="input-text" name="clave" id="clave" placeholder="Contraseña">
          </div>
        </div>

                  <div class="form-row ">
                            <?php if( isset($output['mensaje']) ){ ?>
                                <div class="alert alert-<?php echo $output['mensaje']['tipo'] ?> col-sm-12">
                                    <?php echo $output['mensaje']['valor']; ?>
                                </div>
                            <?php }else{ ?>
                                <div class="alert col-sm-12">
                                </div>
                            <?php  } ?>
                  </div>

        <div class="form-row-last">
          <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
        </div>

      </form>
    </div>
  </div>
  <script src="<?php echo base_url('assets/plugins/login30/js/jquery-1.11.1.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/plugins/login30/js/jquery.validate.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/plugins/login30/js/additional-methods.min.js'); ?>"></script>
  <script>
    // just for the demos, avoids form submit

    
    $( "#formLogin" ).validate({
        rules: {
          emailUsuario: {
            required: true
          },
          clave: {
            required: true
          }
        },
        messages: {
          emailUsuario: {
            required: "Ingrese usuario o email"
          },
          clave: {
            required: "Ingrese la clave"
          }
        }
    });
  </script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>