<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Funciones extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('Funciones/Funcion');

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
		$data['view'] = 'Funciones/index';
		$data['output'] = '';
		$this->load->view('Modulos/main',$data);	
	  }
	  else{ 
	  	redirect('Login/Login');
	  }
	}

	public function lista(){
		$data['lista'] = $this->Funcion->buscarFunciones();
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['status'] = $dataSession->status;
		$this->load->view('Funciones/lista',$data);		
	}

	public function gestionRegistro(){
		$idFuncion = $this->input->post("idFuncion");
		$data = array(
					 "nombre" => textoMayuscula($this->input->post("nombreFuncion"))
					);
		if($idFuncion > 0){
			$data = array_merge($data, datosUsuarioEditar());
			echo json_encode("e|".$this->Funcion->editarRegistro($idFuncion, $data));
		}
		else{
			$data = array_merge($data, datosUsuarioInsertar());
			echo json_encode("i|".$this->Funcion->insertarRegistro($data));
		}
	}

	public function buscarRegistroPorID(){
		$idFuncion = $this->input->post("idFuncion");
		$data = $this->Funcion->buscarRegistroPorID($idFuncion);
		print_r(json_encode($data));
	}

	public function eliminarRegistro(){
		$idFuncion = $this->input->post("idFuncion");
		$resultado = $this->Funcion->eliminarRegistro($idFuncion);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}		
	}


}	