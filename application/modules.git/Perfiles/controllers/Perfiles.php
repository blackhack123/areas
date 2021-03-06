<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Perfiles extends MX_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Perfiles/Perfil');
		$this->load->model('Menus/Menu');

		$this->load->helper('session_helper');	
		$this->load->helper('utilidades_helper');	
		$this->load->helper('notas_helper');
	}
	
	public function index($idMenu){
	  $urlCode = $idMenu;
	  $idMenu = desencriptar($idMenu);
	  if(verficarAcceso($idMenu)){
	    $dataSession = verificarPrivilegios($idMenu);
	    $data['status'] = $dataSession->status;
		$data['menuNombre'] = $dataSession->nombreMenu;
		$data['codigoCategoriaMenu'] = $dataSession->codigoCategoriaMenu;
		$data['codigoMenu'] = $dataSession->codigoMenu;
		$data['urlCode'] = $urlCode;
		//Vista
		$data['view'] = 'Perfiles/index';
		$data['output'] = '';
		$this->load->view('Modulos/main',$data);	
	  }
	  else{ 
	  	redirect('Login/Login');
	  }
	}

	public function lista(){
		$data['lista'] = $this->Perfil->buscarPerfiles();
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['status'] = $dataSession->status;
		$this->load->view('Perfiles/lista',$data);
	}

	public function gestionRegistro(){
		$idPerfil = $this->input->post("idPerfil");
		$nombrePerfil = textoMayuscula($this->input->post("nombrePerfil"));// Convertir a mayúscula
		$skinPerfil = $this->input->post("skinPerfil");
		
		$data = array('nombre' => $nombrePerfil,
					'skin'=>$skinPerfil
					);

		if ($idPerfil > 0) {
			echo json_encode('e|'.$this->Perfil->editarPerfil($idPerfil, $data));
		}
		else{
			echo json_encode('i|'.$this->Perfil->insertarPerfil($data));
		}
	}

	public function buscarPerfilPorID(){
		$idPerfil = $this->input->post("idPerfil");
		$data = $this->Perfil->buscarPerfilPorID($idPerfil);
		print_r(json_encode($data));		
	}

	public function eliminarRegistro(){
		$idPerfil = $this->input->post("idPerfil");
		$resultado = $this->Perfil->eliminarPerfil($idPerfil);
			if($resultado){
				echo json_encode(true);
			}
			else{
				echo json_encode(false);
			}		
	}










	public function buscarPerfiles(){
		$data = $this->Perfil->buscarPerfiles();
		print_r(json_encode($data));
	}

}
