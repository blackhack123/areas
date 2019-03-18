<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />
    <!-- Generated: 2018-04-16 09:29:05 +0200 -->
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <!-- JS -->
    <script src="<?php echo base_url('assets/plugins/tabler-template/js/vendors/jquery-3.2.1.min.js'); ?>"></script>
    <!-- Dashboard Core -->
    <link href="<?php echo base_url('assets/plugins/tabler-template/css/dashboard.css'); ?>" rel="stylesheet" />

  </head>
  <body class="">
    <div class="page">
      <div class="page-single">
        <div class="container">
          <div class="row">
            <div class="col col-login mx-auto">
              <div class="text-center mb-6">
                <img src="<?php echo base_url('assets/img/logo.gif'); ?>" class="h-6" alt="">
              </div>
              
              <form name="formLogin" id="formLogin" class="card" action="<?php echo base_url('Login/validarIngreso'); ?>" method="post">
                <div class="card-body p-6">
                  <div class="card-title">
                    <center>
                      Iniciar sesión
                    </center>
                  </div>
                

                  <div class="form-group">
                    <label class="form-label">Usuario / Email</label>
                    <input type="text" class="form-control" name="emailUsuario" id="emailUsuario" aria-describedby="emailHelp" placeholder="Usuario / Email">
                  </div>
                  <div class="form-group">
                    <label class="form-label">
                      Contraseña
                    </label>
                    <input type="password" class="form-control" name="clave" id="clave" placeholder="Contraseña">
                  </div>
                  <div class="form-group">
                    <label class="custom-control custom-checkbox col-sm-12">
                            <?php if( isset($output['mensaje']) ){ ?>
                                <div class="alert alert-<?php echo $output['mensaje']['tipo'] ?>">
                                    <?php echo $output['mensaje']['valor']; ?>
                                </div>
                            <?php } ?>  
                    </label>
                  </div>
                  <div class="form-footer">
                    <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                  </div>

                </div>

              </form>

              <div class="text-center text-muted">
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>