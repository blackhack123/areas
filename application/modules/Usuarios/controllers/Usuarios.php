<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('Usuarios/Usuario');
		$this->load->model('Perfiles/Perfil');

		$this->load->helper('session_helper');	
		$this->load->helper('utilidades_helper');	
		$this->load->helper('notas_helper');
	}

	public function formularioAdministrativo(){
		$idPersonal = $this->input->post("idPersonal");
		$data['usuario'] = $this->Usuario->buscarUsuarioPorPersonalID($idPersonal);
		$data['perfil'] = $this->Perfil->buscarPerfiles();
		$data['idPersonal'] = $idPersonal;
		if($this->session->userdata("esSuperadmin") == "S"){
			$this->load->view('Usuarios/formularioAdministrativo',$data);
		}
		else{
			$this->load->view('Usuarios/formularioUsuario',$data);
		}
	}

	public function gestionRegistro(){
		$idUsuario = $this->input->post('idUsuario');

		$data = array(
			'personal_id' => $this->input->post('idPersonalUsuario'),
			'email' => $this->input->post('emailUsuario'),
			'usuario' => $this->input->post('usuarioUsuario')
		);

		if($this->session->userdata("esSuperadmin") == "S"){
			$dataUsuario = array(
				'clave' =>  $this->encryption->encrypt($this->input->post('claveUsuario')),
				'es_superadmin' => $this->input->post('esSuperadminUsuario'),
				'estado' => $this->input->post('estadoUsuario')
			);
			$data = array_merge($data, $dataUsuario);
		}
		
				
		if($idUsuario > 0){
			$dataUser = datosUsuarioEditar($this->session->userdata());
			$data = array_merge($data, $dataUser);
			echo json_encode('e|'.$this->Usuario->editarRegistro($idUsuario,$data));
		}
		else{
			$dataUser = datosUsuarioInsertar($this->session->userdata());
			$data = array_merge($data, $dataUser);
			echo json_encode('i|'.$this->Usuario->insertarRegistro($data));
		}			
	}
}