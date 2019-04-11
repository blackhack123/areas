<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Secciones extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('Estaciones/Estacion');
		$this->load->model('Secciones/Seccion');

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
		$data['view'] = 'Secciones/index';
		$data['output'] = '';
		$this->load->view('Modulos/main',$data);	
	  }
	  else{ 
	  	redirect('Login/Login');
	  }
	}	

	public function lista(){
		$data['lista'] = $this->Seccion->buscarSecciones();
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['status'] = $dataSession->status;
		$this->load->view('Secciones/lista',$data);		
	}

	public function gestionRegistro(){
		$idSeccion = $this->input->post("idSeccion");
		$data = array(
					 "nombre" => textoMayuscula($this->input->post("nombreSeccion"))
					);
		if($idSeccion > 0){
			$data = array_merge($data, datosUsuarioEditar());
			echo json_encode("e|".$this->Seccion->editarRegistro($idSeccion, $data));
		}
		else{
			$data = array_merge($data, datosUsuarioInsertar());
			echo json_encode("i|".$this->Seccion->insertarRegistro($data));
		}
	}

	public function buscarRegistroPorID(){
		$idSeccion = $this->input->post("idSeccion");
		$data = $this->Seccion->buscarRegistroPorID($idSeccion);
		print_r(json_encode($data));
	}

	public function eliminarRegistro(){
		$idSeccion = $this->input->post("idSeccion");
		$resultado = $this->Seccion->eliminarRegistro($idSeccion);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}		
	}	

}