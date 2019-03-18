<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Partes extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('Partes/Parte');
		$this->load->model('Sistemas/Sistema');
		$this->load->model('Estaciones/Estacion');

		$this->load->helper('session_helper');	
		$this->load->helper('utilidades_helper');	
		$this->load->helper('notas_helper');
	}

	public function index($idMenu){
	  $urlCode = $idMenu;
	  $idMenu = desencriptar($idMenu);
	  if(verficarAcceso($idMenu)){
	    $dataSession = verificarPrivilegios($idMenu);
	    $data['status'] = $dataSession->status;
		$data['menuNombre'] = $dataSession->nombreMenu;
		$data['codigoCategoriaMenu'] = $dataSession->codigoCategoriaMenu;
		$data['codigoMenu'] = $dataSession->codigoMenu;
		$data['urlCode'] = $urlCode;
		//Vista
		if($this->session->userdata("esSuperadmin")){
			$data['estacion'] = $this->Estacion->buscarEstaciones();
		}
		else{
			$idCae = $this->session->userdata("idCae");
			$data['estacion'] = $this->Estacion->buscarEstacionesCae($idCae);
		}

		$data['view'] = 'Partes/index';
		$data['output'] = '';
		$this->load->view('Modulos/main',$data);	
	  }
	  else{ 
	  	redirect('Login/Login');
	  }
	}

	public function lista(){
		//Filtrar pot tipo de usuario
		if($this->session->userdata("esSuperadmin") == "S"){
			$data['lista'] = $this->Parte->buscarPartesCompleto();
			$vista = "Partes/listaCompleta";
		}
		else{
			$data['lista'] = $this->Parte->buscarPartesCae();
			$vista = "Partes/lista";
		}

		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['status'] = $dataSession->status;
		$this->load->view($vista,$data);		
	}

	public function gestionRegistro(){
		$idParte = $this->input->post("idParte");
		$data = array("sistema_id" => $this->input->post("idSistema"),
					  "tipo_existencia_id" => $this->input->post("idTipoExistencia"),
					  "novedad" => textoMayuscula($this->input->post("novedadParte")),
					  "seguimiento" => textoMayuscula($this->input->post("seguimientoParte")),
					  "requerimiento_solucion" => textoMayuscula($this->input->post("requerimientoSolucionParte")),
					  "es_solucionado" => $this->input->post("esSolucionadoParte")
					);
		if($idParte > 0){
			$data = array_merge($data, datosUsuarioEditar());
			echo json_encode("e|".$this->Parte->editarRegistro($idParte, $data));
		}
		else{
			$data = array_merge($data, array("fecha" => date("Y-m-d h:i:s")));
			$data = array_merge($data, datosUsuarioInsertar());
			echo json_encode("i|".$this->Parte->insertarRegistro($data));
		}
	}

	public function buscarRegistroPorID(){
		$idParte = $this->input->post("idParte");
		$data = $this->Parte->buscarRegistroPorID($idParte);
		print_r(json_encode($data));
	}

	public function eliminarRegistro(){
		$idParte = $this->input->post("idParte");
		$resultado = $this->Parte->eliminarRegistro($idParte);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}		
	}

}