<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller {

	/**
	 * Control de inicio de sesión
	 */
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Usuarios/Usuario');
		$this->load->model('Unidades/Unidad');
	}
	

	public function index(){
		$this->load->view('Login/index');
	}

	public function validarIngreso(){
		$emailUsuario = $this->security->xss_clean($this->input->post("emailUsuario"));
		$clave = $this->security->xss_clean($this->input->post("clave"));
		//Verfificar si es email o usuario
		if(strrpos($emailUsuario, "@")){
			$usuario = $this->Usuario->verificarUsuarioPorEmail($emailUsuario);
		}
		else{
			$usuario = $this->Usuario->verificarUsuarioPorUsuario($emailUsuario);
		}
		//Verificar si hay registro
		if(is_object($usuario)){
			$claveUsuario = $this->encryption->decrypt($usuario->claveUsuario);
			if($claveUsuario == $clave){
				//Datos de la Unidad
				$unidad = $this->Unidad->buscarRegistroPorID(1);
				//Datos para la sesión
				$datoUsuario = array(
									"idUsuario" => $usuario->idUsuario,
									"idPersonal" => $usuario->idPersonal,
									"apellidoUsuario" => $usuario->apellidoUsuario,
									"nombreUsuario" => $usuario->nombreUsuario,
									"emailUsuario" => $usuario->emailUsuario,
									"esSuperadmin" => $usuario->esSuperadminUsuario,
									"idUnidad" => $unidad->idUnidad,
									"nombreUnidad" => $unidad->nombreUnidad,
									"logoUnidad" => $unidad->logoUnidad,
									"login" => true
								);
				$this->session->set_userdata($datoUsuario);
				redirect("Modulos/escritorio");
			}
			else{
				$data['output']['mensaje'] = array("tipo" => "danger", "valor" => "Clave incorrecta");
				$this->load->view("Login/index", $data);
			}
		}
		else{
			$data['output']['mensaje'] = array("tipo" => "danger", "valor" => "Usuario inactivo o incorrecto");
			$this->load->view("Login/index", $data);
		}

	}

	public function logout(){
		$this->session->sess_destroy();
		redirect("Login/index");
	}
}
