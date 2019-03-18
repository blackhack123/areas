<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sistemas extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('Secciones/Seccion');
		$this->load->model('Sistemas/Sistema');

		$this->load->helper('session_helper');	
		$this->load->helper('utilidades_helper');	
		$this->load->helper('notas_helper');
	}

	public function lista(){
		$idSeccion = $this->input->post("idSeccion");
		$data['lista'] = $this->Sistema->buscarSistemasSeccion($idSeccion);
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$seccion = $this->Seccion->buscarRegistroPorID($idSeccion);
		$data['idCae'] = $this->input->post("idCae");
		$data['idSeccion'] = $idSeccion;
		$data['menuNombreCae'] = "SISTEMAS SECCIÓN ".$seccion->nombreSeccion;
		$data['status'] = $dataSession->status;
		$this->load->view('Sistemas/lista',$data);		
	}

	public function gestionRegistro(){
		$idSistema = $this->input->post("idSistema");
		$data = array("seccion_id" => $this->input->post("idSeccionSistema"),
					 "nombre" => textoMayuscula($this->input->post("nombreSistema"))
					);
		if($idSistema > 0){
			$data = array_merge($data, datosUsuarioEditar());
			echo json_encode("e|".$this->Sistema->editarRegistro($idSistema, $data));
		}
		else{
			$data = array_merge($data, datosUsuarioInsertar());
			echo json_encode("i|".$this->Sistema->insertarRegistro($data));
		}
	}

	public function buscarRegistroPorID(){
		$idSistema = $this->input->post("idSistema");
		$data = $this->Sistema->buscarRegistroPorID($idSistema);
		print_r(json_encode($data));
	}

	public function eliminarRegistro(){
		$idSistema = $this->input->post("idSistema");
		$resultado = $this->Sistema->eliminarRegistro($idSistema);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}		
	}	

	public function buscarSistemasEstacion(){
		$idEstacion = $this->input->post("idEstacion");
		$data = $this->Sistema->buscarSistemasEstacion($idEstacion);
		print_r(json_encode($data));
	}

}