<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TiposExistencias extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('Estaciones/Estacion');
		$this->load->model('TiposExistencias/TipoExistencia');

		$this->load->helper('session_helper');	
		$this->load->helper('utilidades_helper');	
		$this->load->helper('notas_helper');
	}

	public function lista(){
		$idEstacion = $this->input->post("idEstacion");
		$data['lista'] = $this->TipoExistencia->buscarTiposExistenciasEstacion($idEstacion);
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$estacion = $this->Estacion->buscarRegistroPorID($idEstacion);
		$data['idEstacion'] = $idEstacion;
		$nombreEstacion = str_replace('"', '\"', $estacion->nombreEstacion);
		$data['tituloPagina'] = "EQUIPOS ESTACIÓN ".$nombreEstacion;
		$data['status'] = $dataSession->status;
		$this->load->view('TiposExistencias/lista',$data);		
	}

	public function gestionRegistro(){
		$idTipoExistencia = $this->input->post("idTipoExistencia");
		$data = array("sistema_id" => $this->input->post("idSistema"),
					  "estacion_id" => $this->input->post("idEstacionTipoExistencia"),
					  "nombre" => textoMayuscula($this->input->post("nombreTipoExistencia")),
					  "propiedad" => textoMayuscula($this->input->post("propiedadTipoExistencia"))
					);
		if($idTipoExistencia > 0){
			$data = array_merge($data, datosUsuarioEditar());
			echo json_encode("e|".$this->TipoExistencia->editarRegistro($idTipoExistencia, $data));
		}
		else{
			$data = array_merge($data, datosUsuarioInsertar());
			echo json_encode("i|".$this->TipoExistencia->insertarRegistro($data));
		}
	}

	public function buscarRegistroPorID(){
		$idTipoExistencia = $this->input->post("idTipoExistencia");
		$data = $this->TipoExistencia->buscarRegistroPorID($idTipoExistencia);
		print_r(json_encode($data));
	}

	public function eliminarRegistro(){
		$idTipoExistencia = $this->input->post("idTipoExistencia");
		$resultado = $this->TipoExistencia->eliminarRegistro($idTipoExistencia);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}		
	}	

	public function buscarTiposExistenciasEstacion(){
		$idEstacion = $this->input->post("idEstacion");
		$data = $this->TipoExistencia->buscarTiposExistenciasEstacion($idEstacion);
		print_r(json_encode($data));		
	}


	public function buscarTiposExistenciasEstacionParte(){
		$idEstacion = $this->input->post("idEstacion");
		$data = $this->TipoExistencia->buscarTiposExistenciasEstacionParte($idEstacion);
		print_r(json_encode($data));
	}

}