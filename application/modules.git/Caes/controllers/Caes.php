<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Caes extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('Caes/Cae');

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
		$data['view'] = 'Caes/index';
		$data['output'] = '';
		$this->load->view('Modulos/main',$data);	
	  }
	  else{ 
	  	redirect('Login/Login');
	  }
	}

	public function lista(){
		$data['lista'] = $this->Cae->buscarCaes();
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['status'] = $dataSession->status;
		$this->load->view('Caes/lista',$data);		
	}

	public function gestionRegistro(){
		$idCae = $this->input->post("idCae");
		$data = array("unidad_id" => 1,
					 "nombre" => textoMayuscula($this->input->post("nombreCae"))
					);
		if($idCae > 0){
			$data = array_merge($data, datosUsuarioEditar());
			echo json_encode("e|".$this->Cae->editarRegistro($idCae, $data));
		}
		else{
			$data = array_merge($data, datosUsuarioInsertar());
			echo json_encode("i|".$this->Cae->insertarRegistro($data));
		}
	}

	public function buscarRegistroPorID(){
		$idCae = $this->input->post("idCae");
		$data = $this->Cae->buscarRegistroPorID($idCae);
		print_r(json_encode($data));
	}

	public function eliminarRegistro(){
		$idCae = $this->input->post("idCae");
		$resultado = $this->Cae->eliminarRegistro($idCae);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}		
	}


}	