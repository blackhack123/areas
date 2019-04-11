<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fuerzas extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('Fuerzas/Fuerza');
		$this->load->model('TiposFuerzas/TipoFuerza');

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
		$data['tipoFuerza'] = $this->TipoFuerza->buscarTipoFuerza();
		//Vista
		$data['view'] = 'Fuerzas/index';
		$data['output'] = '';
		$this->load->view('Modulos/main',$data);	
	  }
	  else{ 
	  	redirect('Login/Login');
	  }
	}

	public function lista(){
		$data['lista'] = $this->Fuerza->buscarFuerzas();
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['status'] = $dataSession->status;
		$this->load->view('Fuerzas/lista',$data);		
	}

	public function gestionRegistro(){
		$idFuerza = $this->input->post("idFuerza");
       
       $config = [
        "upload_path" => "./application/modules/Fuerzas/photos",
        "allowed_types" => "jpg|jpeg|png",
        "file_name" => $idFuerza
       ];

       $this->load->library("upload", $config);

    
        if($this->upload->do_upload('logoFuerza')){
        	$dataFoto = array("upload_data" => $this->upload->data());
       		$logoFuerza = $dataFoto['upload_data']['file_name'];
        }
        else{
            $logoFuerza = $this->input->post('logoFuerzaAuxiliar');
        }

		$data = array(
					 "tipo_fuerza_id" => $this->input->post("idTipoFuerza"),
					 "orden" => $this->input->post("ordenFuerza"),
					 "nombre" => textoMayuscula($this->input->post("nombreFuerza")),
					 "logo" => $logoFuerza
					);
		if($idFuerza > 0){
			$data = array_merge($data, datosUsuarioEditar());
			echo json_encode("e|".$this->Fuerza->editarRegistro($idFuerza, $data));
		}
		else{
			$data = array_merge($data, datosUsuarioInsertar());
			echo json_encode("i|".$this->Fuerza->insertarRegistro($data));
		}
	}

	public function buscarRegistroPorID(){
		$idFuerza = $this->input->post("idFuerza");
		$data = $this->Fuerza->buscarRegistroPorID($idFuerza);
		print_r(json_encode($data));
	}

	public function eliminarRegistro(){
		$idFuerza = $this->input->post("idFuerza");
		$resultado = $this->Fuerza->eliminarRegistro($idFuerza);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}		
	}


}	