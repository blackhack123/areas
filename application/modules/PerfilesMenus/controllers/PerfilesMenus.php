<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PerfilesMenus extends MX_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('PeriodosAcademicos/PeriodoAcademico');
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('Perfiles/Perfil');
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
		$data['periodosAcademicos'] = $this->PeriodoAcademico->buscarPeriodosAcademicos();
	    $data['status'] = $dataSession->status;
		$data['menuNombre'] = $dataSession->nombreMenu;
		$data['codigoCategoriaMenu'] = $dataSession->codigoCategoriaMenu;
		$data['codigoMenu'] = $dataSession->codigoMenu;
		$data['periodoLectivoActivo'] = $dataSession->idPeriodoLectivoActivo;
		$data['urlCode'] = $urlCode;
		//Vista
		$idPeriodoAcademicoActivo = $this->session->userdata('idPeriodoAcademicoActivo');
		$idUsuario = $this->session->userdata('idUsuario');
		$data['perfil'] = $this->Perfil->buscarPerfiles();
		$data['view'] = 'PerfilesMenus/index';
		$data['output'] = '';
		$this->load->view('Modulos/main_administrativo',$data);
	  }
	  else{ 
	  	redirect('Login/Login');
	  }
	}

	public function lista(){
		$idPerfil = $this->input->post("idPerfil");
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['status'] = $dataSession->status;
		$data['lista'] = $this->PerfilMenu->buscarMenusDePerfil($idPerfil);
		$this->load->view('PerfilesMenus/lista',$data);
	}

	public function buscarMenusDisponiblesParaPerfil(){
		$idPerfil = $this->input->post("idPerfil");
		$data = $this->PerfilMenu->buscarMenusDisponiblesParaPerfil($idPerfil);
		print_r(json_encode($data));			
	}

	public function agregarRegistro(){
		$idPerfil = $this->input->post("idPerfil");
		$idMenu = $this->input->post("idMenu");
		$data  = array('menu_id' => $idMenu,
					   'perfil_id' => $idPerfil
					  );
		echo json_encode('i|'.$this->PerfilMenu->insertarPerfilMenu($data));
	}

	public function editarPrivilegios(){
		$idPerfilMenu = $this->input->post("idPerfilMenu");
		$idPerfil = $this->input->post("idPerfil");
		$idMenu = $this->input->post("idMenu");
		$estadoPrivilegio = $this->input->post("estadoPrivilegio");
		$atributo = $this->input->post("atributo");

		$data = array($atributo => $estadoPrivilegio);

		echo json_encode('e|'.$this->PerfilMenu->editarPerfilMenu($idPerfilMenu, $data));
	}

	public function eliminarRegistro(){
		$idPerfilMenu = $this->input->post("idPerfilMenu");
		$resultado = $this->PerfilMenu->eliminarPerfilMenu($idPerfilMenu);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}		
	}
/*
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
		$registroMenuPerfil = $this->PerfilMenu->buscarMenuPerfil($idMenu);
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
	*/
}
