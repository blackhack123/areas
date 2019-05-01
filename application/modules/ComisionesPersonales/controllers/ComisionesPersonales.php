<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ComisionesPersonales extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('ComisionesPersonales/ComisionPersonal');

		$this->load->helper('session_helper');	
		$this->load->helper('utilidades_helper');	
		$this->load->helper('notas_helper');
	}

	public function buscarPersonalComision(){
		$idComision = $this->input->post('idComision');
		$data = $this->ComisionPersonal->buscarPersonalComision($idComision);
		print_r(json_encode($data));		
	}	


	public function agregarPersonalAComision(){
		$idComision = $this->input->post("idComision");
		$idPersonal = $this->input->post("idPersonal");
		$data = array(
				"comision_id" => $idComision,
				"personal_id" => $idPersonal
			);
		echo json_encode($this->ComisionPersonal->agregarPersonalAComision($data));
	}	

	public function eliminarPersonalDeComision(){
		$idComision = $this->input->post("idComision");
		$idPersonal = $this->input->post("idPersonal");
		echo json_encode($this->ComisionPersonal->eliminarPersonalDeComision($idComision, $idPersonal));
	}	

}	