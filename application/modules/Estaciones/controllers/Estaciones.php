<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Estaciones extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('Caes/Cae');
		$this->load->model('Estaciones/Estacion');

		$this->load->helper('session_helper');	
		$this->load->helper('utilidades_helper');	
		$this->load->helper('notas_helper');
	}

	public function lista(){
		$idCae = $this->input->post("idCae");
		$data['lista'] = $this->Estacion->buscarEstacionesCae($idCae);
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$cae = $this->Cae->buscarRegistroPorID($idCae);
		$data['idCae'] = $idCae;
		$nombreCae = str_replace('"', '\"', $cae->nombreCae);
		$data['tituloPagina'] = "ESTACIONES CAE ".$nombreCae;
		$data['status'] = $dataSession->status;
		$this->load->view('Estaciones/lista',$data);		
	}

	public function gestionRegistro(){
		$idEstacion = $this->input->post("idEstacion");
		$data = array("cae_id" => $this->input->post("idCaeEstacion"),
					 "nominativo" => textoMayuscula($this->input->post("nominativoEstacion")),
					 "nombre" => textoMayuscula($this->input->post("nombreEstacion")),
					 "direccion" => textoMayuscula($this->input->post("direccionEstacion")),
					 "telefono_fijo" => $this->input->post("telefonoFijoEstacion"),
					 "telefono_movil" => textoMayuscula($this->input->post("telefonoMovilEstacion"))
					);
		if($idEstacion > 0){
			$data = array_merge($data, datosUsuarioEditar());
			echo json_encode("e|".$this->Estacion->editarRegistro($idEstacion, $data));
		}
		else{
			$data = array_merge($data, datosUsuarioInsertar());
			echo json_encode("i|".$this->Estacion->insertarRegistro($data));
		}
	}

	public function buscarRegistroPorID(){
		$idEstacion = $this->input->post("idEstacion");
		$data = $this->Estacion->buscarRegistroPorID($idEstacion);
		print_r(json_encode($data));
	}

	public function eliminarRegistro(){
		$idEstacion = $this->input->post("idEstacion");
		$resultado = $this->Estacion->eliminarRegistro($idEstacion);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}		
	}	

}