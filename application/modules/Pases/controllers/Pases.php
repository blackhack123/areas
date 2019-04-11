<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pases extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('Pases/Pase');

		$this->load->helper('session_helper');	
		$this->load->helper('utilidades_helper');	
		$this->load->helper('notas_helper');
	}

	public function lista(){
		$data['lista'] = $this->Pase->buscarPases();
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['status'] = $dataSession->status;
		$this->load->view('Pases/lista',$data);		
	}

	public function gestionRegistro(){
		$idPase = $this->input->post("idPase");
		$idPersonal = $this->input->post("idPersonalPase");
       
		$data = array(
					 "personal_id" => $idPersonal,
					 "cae_origen_id" => $this->input->post("idCaeOrigen"),
					 "cae_id" => $this->input->post("idCaeDestino"),
					 "fecha_presentacion" => $this->input->post("fechaPresentacionPase"),
					 "fecha_salida" => fechaActual()
					);
		if($idPase > 0){
			$data = array_merge($data, datosUsuarioEditar());
			echo json_encode("e|".$this->Pase->editarRegistro($idPase, $data));
		}
		else{
			$data = array_merge($data, datosUsuarioInsertar());
			$idPase = $this->Pase->insertarRegistro($data);

			if($idPase > 0){
				//Inativar todos los pases anteriores
				$dataUpdate = array("estado" => "I");
				$resultado = $this->Pase->editarEstadoPasePersonal($idPersonal, $dataUpdate);
				//Activar pase insercado
				$dataUpdate = array("estado" => "A");
				$resultado = $this->Pase->editarRegistro($idPase, $dataUpdate);
			}
			echo json_encode("i|".$idPase);
		}
	}

	public function buscarRegistroPorID(){
		$idPase = $this->input->post("idPase");
		$data = $this->Pase->buscarRegistroPorID($idPase);
		print_r(json_encode($data));
	}

	public function eliminarRegistro(){
		$idPase = $this->input->post("idPase");
		$resultado = $this->Pase->eliminarRegistro($idPase);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}		
	}


}	