<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TiposMantenimientos extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('TiposMantenimientos/TipoMantenimiento');

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
		$data['view'] = 'TiposMantenimientos/index';
		$data['output'] = '';
		$this->load->view('Modulos/main',$data);	
	  }
	  else{ 
	  	redirect('Login/Login');
	  }
	}

	public function lista(){
		$data['lista'] = $this->TipoMantenimiento->buscarTiposMantenimientos();
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['status'] = $dataSession->status;
		$this->load->view('TiposMantenimientos/lista',$data);		
	}

	public function gestionRegistro(){
		$idTipoMantenimiento = $this->input->post("idTipoMantenimiento");
		$data = array(
					 "nombre" => textoMayuscula($this->input->post("nombreTipoMantenimiento"))
					);
		if($idTipoMantenimiento > 0){
			$data = array_merge($data, datosUsuarioEditar());
			echo json_encode("e|".$this->TipoMantenimiento->editarRegistro($idTipoMantenimiento, $data));
		}
		else{
			$data = array_merge($data, datosUsuarioInsertar());
			echo json_encode("i|".$this->TipoMantenimiento->insertarRegistro($data));
		}
	}

	public function buscarRegistroPorID(){
		$idTipoMantenimiento = $this->input->post("idTipoMantenimiento");
		$data = $this->TipoMantenimiento->buscarRegistroPorID($idTipoMantenimiento);
		print_r(json_encode($data));
	}

	public function eliminarRegistro(){
		$idTipoMantenimiento = $this->input->post("idTipoMantenimiento");
		$resultado = $this->TipoMantenimiento->eliminarRegistro($idTipoMantenimiento);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}		
	}
	
	public function buscarTiposMantenimientos(){
		$data = $this->TipoMantenimiento->buscarTiposMantenimientos();
		print_r(json_encode($data));
	}
}