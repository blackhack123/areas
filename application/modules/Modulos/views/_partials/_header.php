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
    <title><?php echo $this->config->item('app-title'); ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/font-awesome/css/all.min.css'); ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">
    <!-- Dashboard Core -->
    <link href="<?php echo base_url('assets/plugins/tabler-template/css/dashboard.css'); ?>" rel="stylesheet" />
    <link rel="stylesheet" color:white;href="<?php echo base_url('assets/plugins/datatables/css/buttons.dataTables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/date-time-picker/css/jquery.datetimepicker.min.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/select2.min.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/themes/select2-bootstrap.min.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.css'); ?>" type="text/css">
    <link href="<?php echo base_url('assets/plugins/toastmessages/css/jquery.toastmessage.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/plugins/bootstrap-toogle/css/bootstrap-toggle.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/plugins/owner/css/style.css'); ?>" rel="stylesheet" type="text/css" />

    <!-- JS -->
    <script src="<?php echo base_url('assets/plugins/tabler-template/js/vendors/jquery-3.2.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/tabler-template/js/vendors/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/tabler-template/js/vendors/jquery.sparkline.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/tabler-template/js/vendors/selectize.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/tabler-template/js/vendors/jquery.tablesorter.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/tabler-template/js/vendors/jquery-jvectormap-2.0.3.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/tabler-template/js/vendors/jquery-jvectormap-de-merc.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/tabler-template/js/vendors/jquery-jvectormap-world-mill.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/tabler-template/js/vendors/circle-progress.min.js'); ?>"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/DataTables/datatables.min.css'); ?>">
    <script src="<?php echo base_url('assets/plugins/DataTables/datatables.min.js'); ?>"></script>
    
    <!-- fileinput -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/fileinput/css/fileinput.css'); ?>">
    <script src="<?php echo base_url('assets/plugins/fileinput/js/fileinput.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/fileinput/js/es.js'); ?>"></script>
    
    <script src="<?php echo base_url('assets/plugins/sweetalert2/sweetalert2.all.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/date-time-picker/js/jquery.datetimepicker.full.min.js'); ?>"></script>
    
    <script src="<?php echo base_url('assets/plugins/select2/select2.full.min.js'); ?>"></script>
    
    <script src="<?php echo base_url('assets/plugins/overlay/js/loadingoverlay.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/overlay/js/loadingoverlay_progress.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-validation/jquery.validate.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-validation/additional-methods.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/toastmessages/js/jquery.toastmessage.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap-toogle/js/bootstrap-toggle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/loading-bar/loading-bar.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/owner/js/utils.js'); ?>"></script>
    <!-- input - mask -->
    <script src="<?php echo base_url('assets/plugins/input-mask/jquery.inputmask.bundle.js'); ?>"></script>
  </head>

  <body class="">
    <div class="page">
      <div class="page-main">
        <div class="header py-4" style="background-color:rgb(51, 51, 51); color:white">
          <div class="container">
            <div class="d-flex">
              <a class="header-brand" href="<?php echo site_url('Modulos/escritorio'); ?>">
                <img src="<?php echo base_url('application/modules/Unidades/photos/').$this->session->userdata('logoUnidad'); ?>" class="header-brand-img" alt="Logo">
              </a>
              <div class="row" style="line-height: 1em;">
                <?php echo $this->session->userdata('nombreComandoUnidad'); ?><br>
                <?php echo $this->session->userdata('abreviaturaUnidad'); ?><br>
                <?php echo $this->session->userdata('nombreCae'); ?>
              </div>
              <div class="d-flex order-lg-2 ml-auto">                
                <div class="nav-item d-none d-md-flex" >
                </div>
                <div class="dropdown d-none d-md-flex">
                  <a class="nav-link icon" data-toggle="dropdown">
                    <i class="fe fe-bell"></i>
                    <span class="nav-unread"></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a href="javascript:void(0);" class="dropdown-item d-flex">
                      <span class="avatar mr-3 align-self-center bg-teal"></span>
                      <div>
                        <strong>3</strong> Parte(s) Diario(s) pendientes !
                      </div>
                    </a>
                  </div>
                </div>
                <div class="dropdown">
                  <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                    <span class="avatar" style="background-image: url(<?php echo base_url('assets/img/avatar.png'); ?>)"></span>
                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default" >
                        <div align="center" style="color:white"><?php echo $this->session->userdata('apellidoUsuario').' '.$this->session->userdata('nombreUsuario'); ?>
                        </div>
                      </span>
                      <small class="text-muted d-block mt-1"><?php echo $this->session->userdata('emailUsuario'); ?></small>
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <!--<a class="dropdown-item" href="javascript:void(0);">
                      <i class="dropdown-icon fe fe-user"></i> Perfil
                    </a>-->
                    <a class="dropdown-item" href="<?php echo base_url('Login/logout'); ?>">
                      <i class="dropdown-icon fe fe-log-out"></i> Salir
                    </a>
                  </div>
                </div>
              </div>
              <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
              </a>
            </div>
          </div>
        </div>
        <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse" style="background-color:rgb(51, 51, 51);color:white;">
          <div class="container" >
            <div class="row align-items-center">
              <div class="col-lg-3 ml-auto">
                <form class="input-icon my-3 my-lg-0">
                </form>
              </div>
              

