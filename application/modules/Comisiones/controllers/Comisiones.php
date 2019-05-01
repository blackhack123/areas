<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comisiones extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('Comisiones/Comision');
		$this->load->model('Partes/Parte');
		$this->load->model('ComisionesPersonales/ComisionPersonal');

		$this->load->helper('session_helper');	
		$this->load->helper('utilidades_helper');	
		$this->load->helper('notas_helper');
	}

	public function listaComisionParte(){
		$idParte = $this->input->post("idParte");
		$parte = $this->Parte->buscarCabeceraParte($idParte);
		$data['datoParte'] = "ESTACIÓN: ".$parte->nombreEstacion." | SISTEMA:".$parte->nombreSistema." | EXISTENCIA:".$parte->nombreTipoExistencia;
		$data['lista'] = $this->Comision->buscarComisionesParte($idParte);
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['status'] = $dataSession->status;
		$data['idParte'] = $idParte;
		$data['urlCode'] = $urlCode;
		$this->load->view('Comisiones/listaComisionParte',$data);	
	}

	public function gestionRegistro(){
		
		$idComision = $this->input->post("idComision");

		$data = array("parte_id" => $this->input->post("idParteComision"),
					  "tipo_mantenimiento_id" => $this->input->post("idTipoMantenimiento"),
					  "fecha_inicio" => $this->input->post("fechaInicioComision"),
					  "fecha_fin" => $this->input->post("fechaFinComision"),
					  "estado" => "P",
					  "situacion_previa" => textoMayuscula($this->input->post("situacionPreviaComision")),
					  "actividad_planificada" => textoMayuscula($this->input->post("actividadPlanificadaComision"))
					);


		if($idComision > 0){
			$data = array_merge($data, datosUsuarioEditar());
			echo json_encode("e|".$this->Comision->editarRegistro($idComision, $data));
		}
		else{
			$dataFecha = array('fecha_creacion' => fechaHoraActual());
			$data = array_merge($data, $dataFecha);
			$data = array_merge($data, datosUsuarioInsertar());
			$idComision = $this->Comision->insertarRegistro($data);
			if($idComision){
				$idPersonal = $this->input->post("idPersonal");
				for($i=0; $i<sizeof($idPersonal); $i++) {
					$data = array('comision_id' => $idComision, 'personal_id' => $idPersonal[$i]);
					$res = $this->ComisionPersonal->insertarRegistro($data);
				}
				echo json_encode("i|".$idComision);
			}
			else{
				echo json_encode(false);
			}
			
		}
		//echo $idPersonal;
		//echo json_encode($idPersonal);
	}

	public function buscarRegistroPorID(){
		$idComision = $this->input->post("idComision");
		$data = $this->Comision->buscarRegistroPorID($idComision);
		print_r(json_encode($data));
	}

	public function eliminarRegistro(){
		$idComision = $this->input->post("idComision");
		$resultado = $this->Comision->eliminarRegistro($idComision);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}		
	}

	// Autorizar comisiones
	public function autorizacionComisiones($idMenu){
	  $urlCode = $idMenu;
	  $idMenu = desencriptar($idMenu);
	  if(verficarAcceso($idMenu)){
	    $dataSession = verificarPrivilegios($idMenu);
	    $data['status'] = $dataSession->status;
	    $data['statusAuth'] = $dataSession->status;
		$data['menuNombre'] = $dataSession->nombreMenu;
		$data['codigoCategoriaMenu'] = $dataSession->codigoCategoriaMenu;
		$data['codigoMenu'] = $dataSession->codigoMenu;
		$data['urlCode'] = $urlCode;
		//Vista
		$data['view'] = 'Comisiones/autorizacionComisiones';
		$data['output'] = '';
		$this->load->view('Modulos/main',$data);	
	  }
	  else{ 
	  	redirect('Login/Login');
	  }		
	}


	public function listaAutorizacionComisiones(){
		$data['lista'] = $this->Comision->buscarComisionesPendientes();
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['status'] = $dataSession->status;
		$data['auth'] = $dataSession->auth;
		$this->load->view('Comisiones/listaAutorizacionComisiones',$data);		
	}

}