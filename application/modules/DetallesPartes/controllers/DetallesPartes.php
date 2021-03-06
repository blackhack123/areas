<?php defined('BASEPATH') OR exit('No direct script access allowed');

class DetallesPartes extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('Partes/Parte');
		$this->load->model('DetallesPartes/DetalleParte');

		$this->load->helper('session_helper');	
		$this->load->helper('utilidades_helper');	
		$this->load->helper('notas_helper');
	}

	public function formulario(){
	 $idParte = $this->input->post("idParte");
	  if($idParte){
		$parte = $this->Parte->buscarRegistroPorID($idParte);
		if($parte->tieneNovedadParte == "SI"){
			$data['idCae'] = $parte->idCae;
			$data['idParte'] = $parte->idParte;
			$this->load->view("DetallesPartes/formulario", $data);
		}
	  }	
	}

	public function gestionRegistro(){
	    $idDetalleParte = $this->input->post("idDetalleParte");
	    $data = array(
	            "parte_id" => $this->input->post("idParteDetalleParte"),
	            "tipo_existencia_id" => $this->input->post("idTipoExistenciaDetalleParte"),
	            "novedad" => textoMayuscula($this->input->post("novedadDetalleParte")),
	            "requerimiento" => textoMayuscula($this->input->post("requerimientoDetalleParte")),
	            "es_solucionado" => $this->input->post("esSolucionadoDetalleParte"),
	            "fecha_fallo" => $this->input->post("fechaFalloDetalleParte")
	          );
	    if($this->input->post("esSolucionadoDetalleParte") == "SI"){
	    	$solucion = array('fecha_solucion' => $this->input->post("fechaSolucionDetalleParte"),
	    					  'solucion' => textoMayuscula($this->input->post("solucionDetalleParte")),
	    					  'horas_fuera_servicio' => $this->input->post("horasFueraServicioDetalleParte")
	    		            );
	    	$data = array_merge($data, $solucion);
	    }

	    if($idDetalleParte > 0){
	      $data = array_merge($data, datosUsuarioEditar());
	      echo json_encode("e|".$this->DetalleParte->editarRegistro($idDetalleParte, $data));
	    }
	    else{
	      $data = array_merge($data, datosUsuarioInsertar());
	      echo json_encode("i|".$this->DetalleParte->insertarRegistro($data));
	    }
	}

	public function lista(){
		$idParte = $this->input->post("idParte");
		$parte = $this->Parte->buscarRegistroPorID($idParte);
		$data['lista'] = $this->DetalleParte->buscarDetalleParte($idParte);
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		//Verificar los permisos del usuario para enviar
		$data['send'] = $dataSession->send;
		
		$data['status'] = $dataSession->status;
		$data['estadoParte'] = $parte->estadoParte;
		$this->load->view('DetallesPartes/lista',$data);		
	}

	public function eliminarRegistro(){
		$idDetalleParte = $this->input->post("idDetalleParte");
		$resultado = $this->DetalleParte->eliminarRegistro($idDetalleParte);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}	
	}

	public function buscarRegistroPorID(){
		$idDetalleParte = $this->input->post("idDetalleParte");
		$data = $this->DetalleParte->buscarRegistroPorID($idDetalleParte);
		print_r(json_encode($data));
	}

	public function calcularHorasFueraServicio(){
		$fechaFalloDetalleParte = $this->input->post("fechaFalloDetalleParte");
		$fechaSolucionDetalleParte = $this->input->post("fechaSolucionDetalleParte");

		$datetime1 = new DateTime($fechaFalloDetalleParte);
		$datetime2 = new DateTime($fechaSolucionDetalleParte);
		$interval = $datetime1->diff($datetime2);

		//echo json_encode($interval->format('%a d??as %H:%I:%S'));
		echo json_encode($interval->format('%a d??as %H:%I:%S'));
	}
}