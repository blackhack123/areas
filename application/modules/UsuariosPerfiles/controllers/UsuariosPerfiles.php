<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UsuariosPerfiles extends MX_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Usuarios/Usuario');
		$this->load->model('UsuariosPerfiles/UsuarioPerfil');
	}
	
	public function buscarPerfilDeUsuario(){
		$idUsuario = $this->input->post("idUsuario");
	
		$perfilesDelUsuario = $this->Usuario->buscarPerfilesDelUsuario($idUsuario);
		$dataPerfil = "";
		if($perfilesDelUsuario){
			foreach ($perfilesDelUsuario as $dt) {
				$dataPerfil.=$dt->idPerfil.",";
			}
		}	

		echo json_encode($dataPerfil);	
	}

	public function agregarPerfilAUsuario(){
		$idUsuario = $this->input->post("idUsuario");
		$idPerfil = $this->input->post("idPerfil");
		$data = array(
				"usuario_id" => $idUsuario,
				"perfil_id" => $idPerfil
			);
		echo json_encode($this->UsuarioPerfil->agregarPerfilAUsuario($data));
	}	

	public function eliminarPerfilDeUsuario(){
		$idUsuario = $this->input->post("idUsuario");
		$idPerfil = $this->input->post("idPerfil");
		echo json_encode($this->UsuarioPerfil->eliminarPerfilDeUsuario($idUsuario, $idPerfil));
	}	

}
