<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Unidades extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('Unidades/Unidad');

		$this->load->helper('session_helper');	
		$this->load->helper('utilidades_helper');	
		$this->load->helper('notas_helper');
	}
	
	public function formulario($idMenu){
	  $urlCode = $idMenu;
	  $idMenu = desencriptar($idMenu);
	  if(verficarAcceso($idMenu)){
	    $dataSession = verificarPrivilegios($idMenu);
	    $data['status'] = $dataSession->status;
		$data['menuNombre'] = $dataSession->nombreMenu;
		$data['codigoCategoriaMenu'] = $dataSession->codigoCategoriaMenu;
		$data['codigoMenu'] = $dataSession->codigoMenu;
		$data['urlCode'] = $urlCode;
		//Buscar datos de la institucion única id=1
		$data['unidad'] = $this->Unidad->buscarRegistroPorID(1);
		//Vista
		$data['view'] = 'Unidades/formulario';
		$data['output'] = '';
		$this->load->view('Modulos/main',$data);	
	  }
	  else{ 
	  	redirect('Login/Login');
	  }
	}

	function gestionRegistro(){

	   $idUnidad = $this->input->post("idUnidad");
      
       $config = [
        "upload_path" => "./application/modules/Unidades/photos",
        "allowed_types" => "jpg|jpeg",
        "file_name" => $this->input->post('idUnidad')
       ];

       $this->load->library("upload", $config);

    
        if($this->upload->do_upload('logoUnidad')){
        	$dataFoto = array("upload_data" => $this->upload->data());
       		$logoUnidad = $dataFoto['upload_data']['file_name'];
        }
        else{
            $logoUnidad = $this->input->post('logoUnidadAuxiliar');
        }

		$data = array("nombre" => textoMayuscula($this->input->post("nombreUnidad")),
					  "abreviatura" => textoMayuscula($this->input->post("abreviaturaUnidad")),
					  "direccion" => textoMayuscula($this->input->post("direccionUnidad")),
					  "telefono_fijo" => textoMayuscula($this->input->post("telefonoFijoUnidad")),
					  "telefono_movil" => textoMayuscula($this->input->post("telefonoMovilUnidad")),
					  "email" => $this->input->post("emailUnidad"),
					  "logo" => $logoUnidad
				);
		
		if($idUnidad > 0){
			$data = array_merge($data, datosUsuarioEditar());
			echo json_encode("e|".$this->Unidad->editarRegistro($idUnidad, $data));
		}
		else{
			$data = array_merge($data, datosUsuarioInsertar());
			echo json_encode("i|".$this->Unidad->insertarRegistro($data));
		}
	}

}	