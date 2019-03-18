<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Personales extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('Personales/Personal');
		$this->load->model('Fuerzas/Fuerza');
		$this->load->model('Grados/Grado');
		$this->load->model('EstadosCiviles/EstadoCivil');
		$this->load->model('Funciones/Funcion');

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
		$data['view'] = 'Personales/index';
		$data['output'] = '';
		$this->load->view('Modulos/main',$data);	
	  }
	  else{ 
	  	redirect('Login/Login');
	  }
	}

	public function lista(){
		$data['lista'] = $this->Personal->buscarPersonal();
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['status'] = $dataSession->status;
		$this->load->view('Personales/lista',$data);		
	}

	public function formulario(){
		$idPersonal = $this->input->post("idPersonal");

		if($idPersonal > 0){
			$personal = $this->Personal->buscarRegistroPorID($idPersonal);
			$data['idFuerza'] = $personal->idFuerza;
			$data['grado'] = $this->Grado->buscarGradosFuerza($personal->idFuerza);
			$data['idGrado'] = $personal->idGrado;
			$data['idEstadoCivil'] = $personal->idEstadoCivil;
			$data['personal'] = $personal;
			$data['idFuncion'] = $personal->idFuncion;
			$data['tituloPagina'] = "Editar Registro";
		}
		else{
			$data['personal'] = "";
			$data['tituloPagina'] = "Nuevo Registro";
		}
		$data['funcion'] = $this->Funcion->buscarFunciones();
		$data['fuerza'] = $this->Fuerza->buscarFuerzas();
		$data['estadoCivil'] = $this->EstadoCivil->buscarEstadosCiviles();
		
		$this->load->view('Personales/formulario',$data);
	}


	public function gestionRegistro(){
		$idPersonal = $this->input->post("idPersonal");
		$idUsuario = $this->session->userdata("idUsuario");

       $config = [
        "upload_path" => "./application/modules/Personales/photos",
        "allowed_types" => "jpg|jpeg",
        "file_name" => $this->input->post('numeroIdentificacionPersonal')
       ];

       $this->load->library("upload", $config);

    
        if($this->upload->do_upload('fotoPersonal')){
        	$dataFoto = array("upload_data" => $this->upload->data());
       		$fotoPersonal = $dataFoto['upload_data']['file_name'];
        }
        else{
            $fotoPersonal = $this->input->post('fotoPersonalAuxiliar');
        }

		$data = array("fuerza_id" => $this->input->post("idFuerza"),
					 "grado_id" => $this->input->post("idGrado"),
					 "funcion_id" => $this->input->post("idFuncion"),
					 "estado_civil_id" => $this->input->post("idEstadoCivil"),
					 "apellido" => textoMayuscula($this->input->post("apellidoPersonal")),
					 "nombre" => textoMayuscula($this->input->post("nombrePersonal")),
					 "tipo_identificacion" => $this->input->post("tipoIdentificacionPersonal"),
					 "numero_identificacion" => $this->input->post("numeroIdentificacionPersonal"),
					 "fecha_nacimiento" => $this->input->post("fechaNacimientoPersonal"),
					 "telefono_fijo" => $this->input->post("telefonoFijoPersonal"),
					 "telefono_movil" => $this->input->post("telefonoMovilPersonal"),
					 "direccion" => textoMayuscula($this->input->post("direccionPersonal")),
					 "email" => $this->input->post("emailPersonal"),
					 "tipo_sangre" => $this->input->post("tipoSangrePersonal"),
					 "foto" => $fotoPersonal
					);
		if($idPersonal > 0){
			$data = array_merge($data, datosUsuarioEditar());
			echo json_encode("e|".$this->Personal->editarRegistro($idPersonal, $data));
		}
		else{
			$data = array_merge($data, datosUsuarioInsertar());
			echo json_encode("i|".$this->Personal->insertarRegistro($data));
		}
	}

	public function eliminarRegistro(){
		$idPersonal = $this->input->post("idPersonal");
		$resultado = $this->Personal->eliminarRegistro($idPersonal);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}		
	}

}	