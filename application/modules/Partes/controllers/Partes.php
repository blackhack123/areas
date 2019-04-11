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
		$this->load->model('Caes/Cae');
		$this->load->model('Estaciones/Estacion');
		$this->load->model('Actividades/Actividad');
		$this->load->model('TiposExistencias/TipoExistencia');

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
		if($this->session->userdata("esSuperadmin") == 'S'){
			//$data['estacion'] = $this->Estacion->buscarEstaciones();
			$data['cae'] = $this->Cae->buscarCaes();
		}
		else{
			//$idCae = $this->session->userdata("idCae");
			//$data['estacion'] = $this->Estacion->buscarEstacionesCae($idCae);
			$idPersonal = $this->session->userdata("idPersonal");
			$data['cae'] = $this->Cae->buscarCaesPersonal($idPersonal);
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
		$idCae = $this->input->post("idCae");		
		$fechaParte = $this->input->post("fechaParte");		
		//buscar Tipo Existencia de un CAE
		$tipoExistencia = $this->TipoExistencia->buscarTipoExistenciaCae($idCae);
		//Recorrer las existencias
		if($tipoExistencia){
			foreach ($tipoExistencia as $dt) {
				$idTipoExistencia = $dt->idTipoExistencia;
				$existencia = $this->Parte->buscarExistenciaFechaParte($idTipoExistencia, $fechaParte);
				if($existencia == false){
					$data = array("tipo_existencia_id" => $idTipoExistencia,
								  "fecha" => $fechaParte,
								  "novedad" => "S.N.",
								  "seguimiento" => "S.N.",
								  "requerimiento_solucion" => "S.N."
								);
					$insertar = $this->Parte->insertarRegistro($data);
				}
			}
		$parte = $this->Parte->buscarParteDiario($idCae, $fechaParte);
		}
		else{
			$parte = "";
		}	

		$data['lista'] = $parte;
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['status'] = $dataSession->status;
		$this->load->view("Partes/lista",$data);		
	}

	public function gestionRegistro(){
		$idParte = $this->input->post("idParte");
		$data = array(
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

	public function validarFechaParte(){
		date_default_timezone_set('America/Guayaquil');
		$fechaHoraActual = date("Y-m-d H:i:s");


		$actividad = $this->Actividad->buscarParametrosParte();
		//Crear fecha - hora inicial
		$fechaActualHoraDesde = date("Y-m-d ".$actividad->horaDesdeActividad);
		//$horaInicio = explode(":", $actividad->horaDesdeActividad);
		//crear fecha - hora final
		$ms = $actividad->duracionActividad*3600;
		$horas = floor($ms/3600);
		$minutos = floor(($ms-($horas*3600))/60);
		$segundos = $ms-($horas*3600)-($minutos*60);

		$nuevafecha = strtotime ( '+'.$horas.' hour' , strtotime ( $fechaActualHoraDesde ) ) ;
		$nuevafecha = strtotime ( '+'.$minutos.' minute' , strtotime ( $fechaActualHoraDesde ) ) ;
		$nuevafecha = strtotime ( '+'.$segundos.' second' , strtotime ( $fechaActualHoraDesde ) ) ;
		$nuevafecha = date ( 'Y-m-d H:i:s' , $nuevafecha );


		//$fechaActualHoraHasta = date("Y-m-d ".$horas.":".$minutos.":".$segundos);

		echo json_encode($nuevafecha);
	}

}