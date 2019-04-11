<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class CategoriasMenus extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
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
		$data['view'] = 'CategoriasMenus/index';
		$data['output'] = '';
		$this->load->view('Modulos/main',$data);	
	  }
	  else{ 
	  	redirect('Login/Login');
	  }
	}

	public function lista(){
		$data['lista'] = $this->CategoriaMenu->buscarCategoriaMenu();
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['status'] = $dataSession->status;
		$this->load->view('CategoriasMenus/lista',$data);
	}

	public function gestionRegistro(){
		$idCategoriaMenu = $this->input->post("idCategoriaMenu");
		$nombre = $this->input->post("nombreCategoriaMenu");
		$codigo = normalizaCadena($nombre);
		$codigo = ucwords($codigo);
		$codigo = trim($codigo);
		$codigo = str_replace(' ', '', $codigo);
		$codigo = lcfirst($codigo);

		$data = array(
					"codigo" => $codigo,
					"nombre" => $nombre,
					"icono" => $this->input->post("iconoCategoriaMenu")
				);

		if($idCategoriaMenu > 0){
			echo json_encode('e|'.$this->CategoriaMenu->editarCategoriaMenu($idCategoriaMenu, $data));
		}
		else{
			echo json_encode('i|'.$this->CategoriaMenu->insertarCategoriaMenu($data));
		}
	}

	public function eliminarRegistro(){
		$idCategoriaMenu = $this->input->post("idCategoriaMenu");
		// Primero buscar si no hay registros asociados
		$registroCategoriaMenu = $this->Menu->buscarMenuPorCategoria($idCategoriaMenu);
		// Si existen registros eliminados no se puede eliminar
		if($registroCategoriaMenu){
			echo json_encode(false);
		}// si no hay nada asociado se puede eliminar
		else{
			$resultado = $this->CategoriaMenu->eliminarCategoriaMenu($idCategoriaMenu);
			if($resultado){
				echo json_encode(true);
			}
			else{
				echo json_encode(false);
			}
		}
	}
	public function buscarCategoriaMenuPorID(){
		$idCategoriaMenu = $this->input->post("idCategoriaMenu");
		$data = $this->CategoriaMenu->buscarCategoriaMenuPorID($idCategoriaMenu);
		print_r(json_encode($data));		
	}

}
