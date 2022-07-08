<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sectores extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('Caes/Cae');
		$this->load->model('Sectores/Sector');

		$this->load->helper('session_helper');	
		$this->load->helper('utilidades_helper');	
		$this->load->helper('notas_helper');
	}

	public function lista(){
		$idCae = $this->input->post("idCae");
		$data['lista'] = $this->Sector->buscarSectoresCae($idCae);
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$cae = $this->Cae->buscarRegistroPorID($idCae);
		$data['idCae'] = $idCae;
		$nombreCae = str_replace('"', '\"', $cae->nombreCae);
		$data['tituloPagina'] = "Sectores CAE ".$nombreCae;
		$data['status'] = $dataSession->status;
		$this->load->view('Sectores/lista',$data);		
	}

	public function gestionRegistro(){
		$idSector = $this->input->post("idSector");
		$data = array("cae_id" => $this->input->post("idCaeSector"),
					 "nombre" => textoMayuscula($this->input->post("nombreSector"))
					);
		if($idSector > 0){
			$data = array_merge($data, datosUsuarioEditar());
			echo json_encode("e|".$this->Sector->editarRegistro($idSector, $data));
		}
		else{
			$data = array_merge($data, datosUsuarioInsertar());
			echo json_encode("i|".$this->Sector->insertarRegistro($data));
		}
	}

	public function buscarRegistroPorID(){
		$idSector = $this->input->post("idSector");
		$data = $this->Sector->buscarRegistroPorID($idSector);
		print_r(json_encode($data));
	}

	public function eliminarRegistro(){
		$idSector = $this->input->post("idSector");
		$resultado = $this->Sector->eliminarRegistro($idSector);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}		
	}	

	public function buscarSectoresCae(){
		$idCae = $this->input->post("idCae");
		$data = $this->Sector->buscarSectoresCae($idCae);
		print_r(json_encode($data));
	}


	public function listaSectores(){

		$this->db->select(array('sector.id', 'sector.nombre'));
		$this->db->from('sector');
		$query = $this->db->get();
		return $query->result_array();

	}//end function listaSectores
	
}//end class