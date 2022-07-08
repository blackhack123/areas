<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once BASEPATH . '/helpers/url_helper.php';
?>
<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/bootstrap-4.4.1/css/bootstrap.min.css">

    <title></title>
  </head>
  <body background="<?php echo base_url() ?>assets/img/fondo.png" style="background-size: 100%;">
    
<div class="row">
	<div class="col-md-12">
	<!-- NAVBAR -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<img src="<?php echo base_url() ?>assets/img/logo_cc.png" alt="Logo" height="80">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<a class="nav-link" href="javascript:void(0);">
					Sistema de Gestión y Control GRUSICOMGE 
						<span class="sr-only">Inicio</span>
					</a>
				</li>
			</ul>
			<a href="<?php echo site_url('Login') ?>" class="btn btn-outline-success my-2 my-sm-0">Iniciar Sesion</a>
		</div>
	</nav>
	<!-- NAVBAR -->
	</div>
</div>

<div class="container" >
	<div class="row" style="margin-top:15px">
		<div class="col-md-12">

			<!-- JUMBOTRON -->
			<div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
				<div class="col-md-12 px-0">
					<h1 class="display-12 font-italic">
					Grupo de Sistemas Informáticos, Comunicaciones y Guerra Electrónica
					</h1>
					<p class="lead my-3" style="text-align:justify;">
					<strong>Misión.- </strong>
					Instalar, explotar y mantener los Sistemas de comunicaciones, informáticos y de guerra electrónica del 
					Comando Conjunto de las Fuerzas Armadas, mediante el empleo de las redes de comunicaciones, plataforma 
					informática y control de las emisiones radio eléctrica, para proveer al mando militar, los medios y servicios 
					tecnológicos para contribuir a la defensa de la soberanía, integridad territorial y desarrollo nacional. 
					</p>
				</div>
  		</div>

			<div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
				<div class="col-md-12 px-0">
					<h1 class="display-12 font-italic">
					Gestión Comunicaciones
					</h1>
					<p class="lead my-3" style="text-align:justify;">
					<strong>Propósito.- </strong>
					 Asesorar, planificar, implementar, gestionar y mantener los sistemas y servicios de telecomunicaciones
					 de la red estratégica de Fuerzas Armadas con estándares internacionales, en forma permanente y a nivel nacional, 
					 a fin de apoyar al cumplimiento de la misión de la Dirección. 
					</p>
				</div>
  		</div>


			<!-- END JUMBOTRON -->
		</div>
	</div>
</div>

<footer class="footer mt-auto py-3">
  <div class="container">
    <span class="text-muted">Copyright © 2020. Todos los derechos reservados. </span>
  </div>
</footer>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?=base_url() ?>assets/bootstrap-4.4.1/js/jquery-3.4.1.slim.min.js"></script>
    <script src="<?=base_url() ?>assets/bootstrap-4.4.1/js/popper.min.js"></script>
    <script src="<?=base_url() ?>assets/bootstrap-4.4.1/js/bootstrap.min.js"></script>
  </body>
</html>