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
		$this->load->model('Caes/Cae');
		$this->load->model('Pases/Pase');
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
									"nombreComandoUnidad" => $unidad->nombreComandoUnidad,
									"abreviaturaUnidad" => $unidad->abreviaturaUnidad,
									"nombreUnidad" => $unidad->nombreUnidad,
									"logoUnidad" => $unidad->logoUnidad,
									"login" => true
								);
				//Si no es super usuario ir a ver que Cae tiene pase activo
				if($usuario->esSuperadminUsuario == "N"){
					$pase = $this->Pase->buscarPaseActivoUsuario($usuario->idUsuario);
					$cae = $this->Cae->buscarRegistroPorID($pase->idCae);
					$dataPase = array(
									"idCae" => $pase->idCae,
									"nombreCae" => "CAE: ".$cae->nombreCae
									);
				}
				else{
					$dataPase = array(
									"idCae" => "",
									"nombreCae" => "Administrador CAE's"
									);
				}

				$datoUsuario = array_merge($datoUsuario, $dataPase);

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
