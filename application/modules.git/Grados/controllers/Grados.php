<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Grados extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('Fuerzas/Fuerza');
		$this->load->model('Grados/Grado');

		$this->load->helper('session_helper');	
		$this->load->helper('utilidades_helper');	
		$this->load->helper('notas_helper');
	}

	public function lista(){
		$idFuerza = $this->input->post("idFuerza");
		$data['lista'] = $this->Grado->buscarGradosFuerza($idFuerza);
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$Fuerza = $this->Fuerza->buscarRegistroPorID($idFuerza);
		$data['idFuerza'] = $idFuerza;
		$data['menuNombreFuerza'] = "Grados Fuerza ".$Fuerza->nombreFuerza;
		$data['status'] = $dataSession->status;
		$this->load->view('Grados/lista',$data);		
	}

	public function gestionRegistro(){
		$idGrado = $this->input->post("idGrado");
		$data = array("fuerza_id" => $this->input->post("idFuerzaGrado"),
					 "orden" => textoMayuscula($this->input->post("ordenGrado")),
					 "nombre" => textoMayuscula($this->input->post("nombreGrado")),
					 "abreviatura" => textoMayuscula($this->input->post("abreviaturaGrado"))
					);
		if($idGrado > 0){
			$data = array_merge($data, datosUsuarioEditar());
			echo json_encode("e|".$this->Grado->editarRegistro($idGrado, $data));
		}
		else{
			$data = array_merge($data, datosUsuarioInsertar());
			echo json_encode("i|".$this->Grado->insertarRegistro($data));
		}
	}

	public function buscarRegistroPorID(){
		$idGrado = $this->input->post("idGrado");
		$data = $this->Grado->buscarRegistroPorID($idGrado);
		print_r(json_encode($data));
	}

	public function eliminarRegistro(){
		$idGrado = $this->input->post("idGrado");
		$resultado = $this->Grado->eliminarRegistro($idGrado);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}		
	}

	public function buscarGradosFuerza(){
		$idFuerza = $this->input->post('idFuerza');
		$data = $this->Grado->buscarGradosFuerza($idFuerza);
		print_r(json_encode($data));		
	}	

}