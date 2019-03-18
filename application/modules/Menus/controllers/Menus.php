<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menus extends MX_Controller {
	public function __construct()
	{
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
		$data['categoriaMenu'] = $this->CategoriaMenu->buscarCategoriaMenu();
		$data['view'] = 'Menus/index';
		$data['output'] = '';
		$this->load->view('Modulos/main',$data);
	  }
	  else{ 
	  	redirect('Login/Login');
	  }
	}

	public function lista(){
		$data['lista'] = $this->Menu->buscarMenus();
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['status'] = $dataSession->status;
		$this->load->view('Menus/lista',$data);
	}

	public function gestionRegistro(){
		$idMenu = $this->input->post("idMenu");
		$idCategoriaMenu = $this->input->post("idCategoriaMenu");
		$nombre = $this->input->post("nombreMenu");
		$ruta = $this->input->post("rutaMenu");
		$codigo = normalizaCadena($nombre);
		$codigo = ucwords($codigo);
		$codigo = trim($codigo);
		$codigo = str_replace(' ', '', $codigo);
		$codigo = lcfirst($codigo);
		$icono = $this->input->post("iconoCategoriaMenu");

		$data = array(
					"categoria_menu_id" => $idCategoriaMenu,
					"codigo" => $codigo,
					"nombre" => $nombre,
					"ruta" => $ruta,
					"icono" => $icono
				);

		if($idMenu > 0){
			echo json_encode('e|'.$this->Menu->editarMenu($idMenu, $data));
		}
		else{
			echo json_encode('i|'.$this->Menu->insertarMenu($data));
		}
	}

	public function eliminarRegistro(){
		$idMenu = $this->input->post("idMenu");
		// Primero buscar si no hay registros asociados
		$registroMenuPerfil = $this->PerfilMenu->buscarPerfilesDeMenu($idMenu);
		// Si existen registros eliminados no se puede eliminar
		if($registroMenuPerfil){
			echo json_encode(false);
		}// si no hay nada asociado se puede eliminar
		else{
			$resultado = $this->Menu->eliminarMenu($idMenu);
			if($resultado){
				echo json_encode(true);
			}
			else{
				echo json_encode(false);
			}
		}
	}
	public function buscarMenuPorID(){
		$idMenu = $this->input->post("idMenu");
		$data = $this->Menu->buscarMenuPorID($idMenu);
		print_r(json_encode($data));		
	}
}
