<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
	    $data['send'] = $dataSession->send;
	    $data['fix'] = $dataSession->fix;
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
		$idCae = $this->input->post("idCae");
		$idParte = $this->input->post("idParte");
		$fechaParte = $this->input->post("fechaParte");
		if($idParte){
			$data = array('tiene_novedad' => $this->input->post("tieneNovedadParte")
						  );
			$data = array_merge($data, datosUsuarioEditar());
			
			if($this->Parte->editarRegistro($idParte, $data)){
				$parte = $this->Parte->buscarParteFechaCae($idCae, $fechaParte);
				echo json_encode($parte);
			}
			else{
				echo json_encode(false);
			}
		}
		else{
			//Buscar si no hay parte en la fecha seleccionada
			$parte = $this->Parte->buscarParteFechaCae($idCae, $fechaParte);
			if($parte){
				echo json_encode($parte);
			}
			else{
				//Si no hay registros se crea
				$data = array('cae_id' => $idCae,
							  'fecha' => $fechaParte,
							  'tiene_novedad' => $this->input->post("tieneNovedadParte")
							);
				$data = array_merge($data, datosUsuarioInsertar());
				$idParte = $this->Parte->insertarRegistro($data);
				if($idParte){
					$parte = $this->Parte->buscarRegistroPorID($idParte);
					echo json_encode($parte);
				}
				else{
					echo json_encode(false);
				}
				
			}
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

	public function partesPendientes($idMenu){
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
		$idMenu = desencriptar($urlCode);
		$data['status'] = $dataSession->status;
		//Se presentan los partes enviados
		
		$data['view'] = 'Partes/partesPendientes';
		$data['output'] = '';
		$this->load->view('Modulos/main',$data);	
	  }
	  else{ 
	  	redirect('Login/Login');
	  }

	}

	public function listaPartesPendientes(){

		$data['lista'] = $this->Parte->buscarPartesPorEstado("E");
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['auth'] = $dataSession->auth;
		$this->load->view("Partes/listaPartesPendientes",$data);		
	}

	public function enviarParte(){
		$idParte = $this->input->post("idParte");
		$data = array('estado' => 'E');
		$data = array_merge($data, datosUsuarioEditar());
			
		if($this->Parte->editarRegistro($idParte, $data)){
			echo json_encode(true);
		}else{
			echo json_encode(false);
		}
	}

	public function autorizarParte(){
		$idParte = $this->input->post("idParte");
		$data = array('estado' => 'A');
		$data = array_merge($data, datosUsuarioEditar());
			
		if($this->Parte->editarRegistro($idParte, $data)){
			echo json_encode(true);
		}else{
			echo json_encode(false);
		}
	}
}