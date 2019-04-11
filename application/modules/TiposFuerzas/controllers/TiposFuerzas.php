<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TiposFuerzas extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('TiposFuerzas/TipoFuerza');

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
		$data['view'] = 'TiposFuerzas/index';
		$data['output'] = '';
		$this->load->view('Modulos/main',$data);	
	  }
	  else{ 
	  	redirect('Login/Login');
	  }
	}

	public function lista(){
		$data['lista'] = $this->TipoFuerza->buscarCaes();
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['status'] = $dataSession->status;
		$this->load->view('TiposFuerzas/lista',$data);		
	}

	public function gestionRegistro(){
		$idTipoFuerza = $this->input->post("idTipoFuerza");
		$data = array(
					 "nombre" => textoMayuscula($this->input->post("nombreTipoFuera"))
					);
		if($idTipoFuerza > 0){
			$data = array_merge($data, datosUsuarioEditar());
			echo json_encode("e|".$this->TipoFuerza->editarRegistro($idTipoFuerza, $data));
		}
		else{
			$data = array_merge($data, datosUsuarioInsertar());
			echo json_encode("i|".$this->TipoFuerza->insertarRegistro($data));
		}
	}

	public function buscarRegistroPorID(){
		$idTipoFuerza = $this->input->post("idTipoFuerza");
		$data = $this->TipoFuerza->buscarRegistroPorID($idTipoFuerza);
		print_r(json_encode($data));
	}

	public function eliminarRegistro(){
		$idTipoFuerza = $this->input->post("idTipoFuerza");
		$resultado = $this->TipoFuerza->eliminarRegistro($idTipoFuerza);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}		
	}

	public function buscarTipoFuerza(){
		$data = $this->TipoFuerza->buscarTipoFuerza();
		print_r(json_encode($data));		
	}

}	