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

	public function lista(){
		$idEstacion = $this->input->post("idEstacion");
		$data['lista'] = $this->Seccion->buscarSeccionesEstacion($idEstacion);
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$estacion = $this->Estacion->buscarRegistroPorID($idEstacion);
		$data['idEstacion'] = $idEstacion;
		$data['menuNombreEstacion'] = "SECCIONES ESTACION ".$estacion->nombreEstacion;
		$data['status'] = $dataSession->status;
		$this->load->view('Secciones/lista',$data);		
	}

	public function gestionRegistro(){
		$idSeccion = $this->input->post("idSeccion");
		$data = array("estacion_id" => $this->input->post("idEstacionSeccion"),
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