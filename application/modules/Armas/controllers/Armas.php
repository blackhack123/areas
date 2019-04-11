<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Armas extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('Fuerzas/Fuerza');
		$this->load->model('Armas/Arma');

		$this->load->helper('session_helper');	
		$this->load->helper('utilidades_helper');	
		$this->load->helper('notas_helper');
	}

	public function lista(){
		$idFuerza = $this->input->post("idFuerza");
		$data['lista'] = $this->Arma->buscarArmasFuerza($idFuerza);
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$Fuerza = $this->Fuerza->buscarRegistroPorID($idFuerza);
		$data['idFuerza'] = $idFuerza;
		$data['menuNombreFuerza'] = "Armas Fuerza ".$Fuerza->nombreFuerza;
		$data['status'] = $dataSession->status;
		$this->load->view('Armas/lista',$data);		
	}

	public function gestionRegistro(){
		$idArma = $this->input->post("idArma");
		$data = array("fuerza_id" => $this->input->post("idFuerzaArma"),
					 "nombre" => textoMayuscula($this->input->post("nombreArma")),
					 "abreviatura" => textoMayuscula($this->input->post("abreviaturaArma"))
					);
		if($idArma > 0){
			$data = array_merge($data, datosUsuarioEditar());
			echo json_encode("e|".$this->Arma->editarRegistro($idArma, $data));
		}
		else{
			$data = array_merge($data, datosUsuarioInsertar());
			echo json_encode("i|".$this->Arma->insertarRegistro($data));
		}
	}

	public function buscarRegistroPorID(){
		$idArma = $this->input->post("idArma");
		$data = $this->Arma->buscarRegistroPorID($idArma);
		print_r(json_encode($data));
	}

	public function eliminarRegistro(){
		$idArma = $this->input->post("idArma");
		$resultado = $this->Arma->eliminarRegistro($idArma);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}		
	}

	public function buscarArmasFuerza(){
		$idFuerza = $this->input->post('idFuerza');
		$data = $this->Arma->buscarArmasFuerza($idFuerza);
		print_r(json_encode($data));		
	}	

}