<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	#login de usuario conectado
	/*
	Aut: Marcelo Quimbita
	Descripción: Verificar Login
	*/
	function verficarAcceso($idMenu){
		$CI = & get_instance();  //get instance, access the CI superobject
		$esSuperadmin = $CI->session->userdata('esSuperadmin');
		$idUsuario = $CI->session->userdata('idUsuario');
		$login = $CI->session->userdata('login');
	  if($login){ // verificar el inicio de sesión
		if($esSuperadmin == "S"){
			return true;
		}
		else{
			$PerfilesMenus =& get_instance();
			$PerfilesMenus->load->model('PerfilesMenus/PerfilMenu');
			$registros = $PerfilesMenus->PerfilMenu->buscarMenuUsuario($idUsuario, $idMenu);
			return $registros;
		}
	  }
	  else{
	  	return false;
	  }	
	}

	/*
	Aut: Marcelo Quimbita
	Descripción: Verificar Login
	*/
	function verificarPrivilegios($idMenu){
		$CI = & get_instance();  //get instance, access the CI superobject
		$esSuperadmin = $CI->session->userdata('esSuperadmin');
		$idUsuario = $CI->session->userdata('idUsuario');
		$PerfilesMenus =& get_instance();
		$PerfilesMenus->load->model('PerfilesMenus/PerfilMenu');
		$Menus =& get_instance();
		$Menus->load->model('Menus/Menu');
		
		//Privilegio de lectura y escritura
		$privilegios = $PerfilesMenus->PerfilMenu->buscarMenuUsuario($idUsuario, $idMenu);
	      if($esSuperadmin == 'S'){
	      	$escritura = "";
	      	$autorizacion = "";
	      	$solucion = "";
	      	$envio = "";
	      }
	      else{
			//Permiso de escritura
			if($privilegios->escritura){
				$escritura = "";
			}
			else{
				$escritura = "disabled";
			}
			//Permiso de autorizacion (hasta el momento del Comandante)
			if($privilegios->autorizacion){
				$autorizacion = "";
			}
			else{
				$autorizacion = "disabled";
			}
			//Permiso de envío
			if($privilegios->envio){
				$envio = "";
			}
			else{
				$envio = "disabled";
			}
			//Permiso de solucion
			if($privilegios->solucion){
				$solucion = "";
			}
			else{
				$solucion = "disabled";
			}

	      }		

		//Menú
		$dataMenu = $Menus->Menu->buscarMenuPorID($idMenu);
		$nombreMenu = $dataMenu->nombreMenu;
		$codigoCategoriaMenu = $dataMenu->codigoCategoriaMenu;
		$codigoMenu = $dataMenu->codigoMenu;

		$data = (object) array(
								"auth" => $autorizacion,
								"status" => $escritura,
								"send" => $envio,
								"fix" => $solucion,
								"nombreMenu"=> $nombreMenu,
								"codigoCategoriaMenu"=> $codigoCategoriaMenu,
								"codigoMenu"=> $codigoMenu
						  	  );

		return $data;
	}

	function usuarioFechaEmision(){
		$CI = & get_instance();  //get instance, access the CI superobject
		$esSuperadmin = $CI->session->userdata('esSuperadmin');
		$idUsuario = $CI->session->userdata('idUsuario');
		//usuario
		$usuarioFecha = "Emitido por ".utf8_decode($CI->session->userdata('nombreUsuario')." ".$CI->session->userdata('apellidoUsuario'))." - ".fechaHoraActualLetras().utf8_decode(" - Sistema: Cerberus Académico");
		return $usuarioFecha;

	}
/* End of file session_helper.php */
/* Location: ./application/helpers/mi_session_helper.php */