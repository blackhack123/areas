<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EstadosCiviles extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('EstadosCiviles/EstadoCivil');

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
		$data['view'] = 'EstadosCiviles/index';
		$data['output'] = '';
		$this->load->view('Modulos/main',$data);	
	  }
	  else{ 
	  	redirect('Login/Login');
	  }
	}

	public function lista(){
		$data['lista'] = $this->EstadoCivil->buscarEstadosCiviles();
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['status'] = $dataSession->status;
		$this->load->view('EstadosCiviles/lista',$data);		
	}

	public function gestionRegistro(){
		$idEstadoCivil = $this->input->post("idEstadoCivil");
		$data = array(
					 "nombre" => textoMayuscula($this->input->post("nombreEstadoCivil"))
					);
		if($idEstadoCivil > 0){
			$data = array_merge($data, datosUsuarioEditar());
			echo json_encode("e|".$this->EstadoCivil->editarRegistro($idEstadoCivil, $data));
		}
		else{
			$data = array_merge($data, datosUsuarioInsertar());
			echo json_encode("i|".$this->EstadoCivil->insertarRegistro($data));
		}
	}

	public function buscarRegistroPorID(){
		$idEstadoCivil = $this->input->post("idEstadoCivil");
		$data = $this->EstadoCivil->buscarRegistroPorID($idEstadoCivil);
		print_r(json_encode($data));
	}

	public function eliminarRegistro(){
		$idEstadoCivil = $this->input->post("idEstadoCivil");
		$resultado = $this->EstadoCivil->eliminarRegistro($idEstadoCivil);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}		
	}


}	