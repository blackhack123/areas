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
		$this->load->model('Personales/Personal');
		$this->load->model('Sectores/Sector');
		$this->load->model('TiposMantenimientos/TipoMantenimiento');
		$this->load->model('OrdenesTrabajo/OrdenTrabajo');


		$this->load->helper('session_helper');	
		$this->load->helper('utilidades_helper');	
		$this->load->helper('notas_helper');

		$this->load->library('Pdf');
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
			$data['partes'] = $this->Parte->consultarPartes();
			
		}
		else{
			$idPersonal 		= $this->session->userdata("idPersonal");
			$cae 				= $this->Cae->buscarCaesPersonal($idPersonal);
			$data['cae'] 		= $cae;
			$data['partes'] 	= $this->Parte->consultarPartes();
			$data['personal'] 	= $this->Personal->buscarPersonal();
			$data['sistemas'] 	= $this->Sistema->buscarSistemasSecciones();
			$data['sectores'] 	= $this->Sector->buscarSectores();
			$data['tiposMantenimientos'] = $this->TipoMantenimiento->buscarTiposMantenimientos();
			$data['estaciones']	= $this->Estacion->buscarEstaciones();
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
			$data = array('tiene_novedad' => 'SI');
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
							  'tiene_novedad' => "SI"
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

	public function buscarParteCaeFecha(){
		$idCae = $this->input->post("idCae");
		$fechaActual = $this->input->post("fechaActual");
		$parte = $this->Parte->buscarParteFechaCae($idCae, $fechaActual);
		echo json_encode($parte);
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
		//$data = array('estado' => 'E');
		$data = array('estado' => 'G');
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

	public function ordenTrabajo($idMenu){
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
		
		$data['view'] = 'Partes/ordenTrabajo';
		$data['output'] = '';
		$this->load->view('Modulos/main',$data);	
	  }
	  else{ 
	  	redirect('Login/Login');
	  }

	}

	public function consultarParteDelDia(){

		$result = $this->Parte->consultarPartesDelDia();
		if($result){
			echo json_encode($result);
		}else{
			echo json_encode(false);
		}


	}// end function consultarParteDelDia

	
	public function grabarParteDiario(){

		$idCae 						= $this->input->post("idCae");
		$fechaParte 				= $this->input->post("fechaParte");
		$idSector					= $this->input->post("idSector");
		$idEstacion 				= $this->input->post("idEstacion");
		$idTipoExistencia 			= $this->input->post("idTipoExistencia");
		$novedadDetalleParte		= $this->input->post("novedadDetalleParte");
		$requerimientoDetalleParte	= $this->input->post("requerimientoDetalleParte");

		$data = array(
			'idCae' => $idCae,
			'fechaParte' => $fechaParte,
			'numero' => generarCodigo(10),
			'idSector' => $idSector,
			'idEstacion' => $idEstacion,
			'idTipoExistencia' => $idTipoExistencia,
			'novedadDetalleParte' => $novedadDetalleParte,
			'requerimientoDetalleParte' => $requerimientoDetalleParte,
			'tiene_novedad' => "SI"
		);
		$data = array_merge($data, datosUsuarioInsertar());
		$idParte = $this->Parte->insertarParteGuardia($data);
		
		if($idParte){
			$result = $this->Parte->consultarPartesDelDia();
			echo json_encode($result);
		}else{
			echo json_encode(false);
		}

	}//end function grabarParteDiario


	public function consultarPartePorId(){
		
		$idParte = $this->input->post('id');
		if($idParte){
			$row = $this->Parte->consultarPartePorId($idParte);
			echo json_encode($row);
		}else{
			echo json_encode(false);
		}

	}//end function consultarPartePorId

	
	public function eliminarParte(){

		$idParte = $this->input->post("idParte");
		$resultado = $this->Parte->eliminarParte($idParte);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}

	}//end function eliminarParte


	public function enviarPendientes(){

		$estadoSupervisor = $this->input->post('supervisor');
		$result = $this->Parte->enviarPendientes($estadoSupervisor);
		if($result){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}

	}//end function enviarPendientes


	public function gestionSupervisor(){

		$idParte 				= $this->input->post('idParte');
		$solucionado 			= $this->input->post('solucionado');
		$fechaSolucion 			= $this->input->post('fechaSolucion');
		$fechaFueraServicio 	= $this->input->post('fechaFueraServicio');
		$solucionSupervisor 	= $this->input->post('solucionSupervisor');
		
		$result = $this->Parte->gestionSupervisor($idParte, $solucionado, $fechaSolucion, $fechaFueraServicio, $solucionSupervisor);
		if($result){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}


	}//end function gestionSupervisor



	public function generarOrdenTrabajo(){

		$idParte 				= $this->input->post('idParte');
		$generar 				= $this->input->post('generar');
		$detalleOrden 			= $this->input->post('detalleOrden');
				
		$result = $this->Parte->generarOrdenTrabajo($idParte, $generar, $detalleOrden);
		if($result){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}


	}//end function generarOrdenTrabajo


	
	public function grabarOrdenTrabajo(){

		$idParte 				= $this->input->post('idParte');
		$idCae 					= $this->input->post('idCae');
		$fechaInicio 			= $this->input->post('fechaInicio');
		$fechaFin 				= $this->input->post('fechaFin');
		$totalDias 				= $this->input->post('totalDias');
		$personal 				= $this->input->post('personal');
		$sistemaPersonal 		= $this->input->post('sistemaPersonal');
		$provincia 				= $this->input->post('provincia');
		$tipoTrabajo 			= $this->input->post('tipoTrabajo');
		$estacion 				= $this->input->post('estacion');
		$sistemaEstacion 		= $this->input->post('sistemaEstacion');
		$situacionPrevia 		= $this->input->post('situacionPrevia');
		$trabajoRealizar 		= $this->input->post('trabajoRealizar');
		$nombreEquipo 			= $this->input->post('nombreEquipo');
		$cantidadEquipo 		= $this->input->post('cantidadEquipo');
		$nombreHerramienta 		= $this->input->post('nombreHerramienta');
		$cantidadHerramienta 	= $this->input->post('cantidadHerramienta');

				
		$result = $this->Parte->grabarOrdenTrabajo($idParte,$idCae,$fechaInicio,$fechaFin,$totalDias,$personal,$sistemaPersonal,$provincia,$tipoTrabajo,$estacion,$sistemaEstacion,$situacionPrevia,$trabajoRealizar,$nombreEquipo,$cantidadEquipo,$nombreHerramienta,$cantidadHerramienta);
		if($result){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}


	}//end function generarOrdenTrabajo


	public function visualizar(){

		$idParte 			= $this->input->get('id');
		$data 				= $this->Parte->consultarPartePorId($idParte);
		$fecha 				= $data[0]->fecha;
		$cae 				= $data[0]->cae;
		$tipo_existencia	= $data[0]->tipo_existencia;
		$propiedad 			= $data[0]->propiedad;
		$novedad 			= $data[0]->novedad;
		$requerimiento 		= $data[0]->requerimiento;

		$this->pdf->AddPage();
		// Logo
		$this->pdf->Image(base_url('assets/img/logo_cc.png'),10,6,15);
		$this->pdf->SetFont('Arial','B',15);
		$this->pdf->Cell(80);
		// TITULO
		$this->pdf->Cell(30,10,'COMANDO CONJUNTO DE LAS FUERZAS ARMADAS',0,0,'C');
		$this->pdf->Ln(5);
		$this->pdf->Cell(80);
		$this->pdf->Cell(30,10,'GRUSICOMGE',0,0,'C');
		// Line break
		$this->pdf->Ln(10);
		
		
		$this->pdf->Cell(80);
		$this->pdf->Cell(30,10,'Parte Diario',0,0,'C');
		$this->pdf->Ln(20);

		//fuente tabla header
		$this->pdf->SetFont('Arial','B',9);

		//tabla titulos
		$this->pdf->setFillColor(190,190,190); 
		$this->pdf->Cell(30,7,'Fecha',1,0,'C',1);
		$this->pdf->Cell(50,7,'CAE',1,0,'C',1);
		$this->pdf->Cell(90,7,'Equipo',1,0,'C',1);
		$this->pdf->Ln();


		// Data
		$this->pdf->SetFont('Arial','',8);
		$this->pdf->Cell(30,6,$fecha,1);
		$this->pdf->Cell(50,6,$cae,1);
		$this->pdf->Cell(90,6,$tipo_existencia,1);
		//salto linea
		$this->pdf->Ln();

		//tabla titulos
		$this->pdf->SetFont('Arial','B',9);
		$this->pdf->Cell(80,7,'Novedad',1,0,'C',1);
		$this->pdf->Cell(90,7,'Requerimiento',1,0,'C',1);
		$this->pdf->Ln();

		// Data
		$this->pdf->SetFont('Arial','',8);
		$this->pdf->Cell(80,6,$novedad,1);
		$this->pdf->Cell(90,6,$requerimiento,1);
		$this->pdf->Ln();

		$this->pdf->Ln(40);

		$this->pdf->SetFont('Arial','B',8);
		$this->pdf->Cell(80,7,'_____________________________',0,0,'C');
		$this->pdf->Cell(90,7,'_____________________________',0,0,'C');
		$this->pdf->Ln();
		
		$this->pdf->Cell(80,7,'Responsable',0,0,'C');
		$this->pdf->Cell(90,7,'Aprueba',0,0,'C');

		$this->pdf->Output('D','parte.pdf');

	}//end function visualizar



	public function visualizarOrdenTrabajo(){

		$idParte 			= $this->input->get('idParte');
		$data 				= $this->OrdenTrabajo->consultarOrdenPorIdParte($idParte);
	
		$fec_inicio 		= $data->fec_inicio;
		$fec_fin 			= $data->fec_fin;
		$total_dias			= $data->total_dias;


		$this->pdf->AddPage();
		// Logo
		$this->pdf->Image(base_url('assets/img/logo_cc.png'),10,6,15);
		$this->pdf->SetFont('Arial','B',15);
		$this->pdf->Cell(80);
		// TITULO
		$this->pdf->Cell(30,10,'COMANDO CONJUNTO DE LAS FUERZAS ARMADAS',0,0,'C');
		$this->pdf->Ln(5);
		$this->pdf->Cell(80);
		$this->pdf->Cell(30,10,'GRUSICOMGE',0,0,'C');
		// Line break
		$this->pdf->Ln(10);
		
		
		$this->pdf->Cell(80);
		$this->pdf->Cell(30,10,'Orden de Trabajo',0,0,'C');
		$this->pdf->Ln(20);

		//fuente tabla header
		$this->pdf->SetFont('Arial','',8);

		//tabla titulos
		$this->pdf->setFillColor(190,190,190); 
		$this->pdf->Cell(15,7,'Fec. Inicio:',1,0,'L',1);
		$this->pdf->Cell(20,7,$fec_inicio,1,0,'L');
		$this->pdf->Cell(25,7,'Fec. Fin:',1,0,'L',1);
		$this->pdf->Cell(30,7,$fec_fin,1,0,'L');
		$this->pdf->Cell(35,7,'Num. de dias:',1,0,'L',1);
		$this->pdf->Cell(40,7,$total_dias." dia(s)",1,0,'L');
		$this->pdf->Ln();

		//tabla titulos
		$this->pdf->SetFont('Arial','B',8);
		$this->pdf->Cell(165,7,'PERSONAL',1,0,'C',1);
		$this->pdf->Ln();
		$this->pdf->SetFont('Arial','',8);
		$this->pdf->Cell(80,7,'Personal',1,0,'C',1);
		$this->pdf->Cell(85,7,'Sistema',1,0,'C',1);
		$this->pdf->Ln();

		// Data
		$nombreCompleto = $data->nombrePersonal." ".$data->apellidoPersonal;
		$this->pdf->Cell(80,6,$nombreCompleto,1);
		$this->pdf->Cell(85,6,$data->sistemaPersonal,1);
		$this->pdf->Ln();

		//tabla titulos
		$this->pdf->Cell(80,7,'Provincia',1,0,'C',1);
		$this->pdf->Cell(85,7,'Tipo Trabajo',1,0,'C',1);
		$this->pdf->Ln();
		// Data
		$this->pdf->Cell(80,6,$data->nombreProvincia,1);
		$this->pdf->Cell(85,6,$data->nombreTipoMantenimiento,1);
		$this->pdf->Ln();

		//tabla titulos
		$this->pdf->SetFont('Arial','B',8);
		$this->pdf->Cell(165,7,'DATOS DE LA COMISION',1,0,'C',1);
		$this->pdf->Ln();
		$this->pdf->SetFont('Arial','',8);
		$this->pdf->Cell(80,7,'Estacion',1,0,'C',1);
		$this->pdf->Cell(85,7,'Sistema',1,0,'C',1);
		$this->pdf->Ln();
		// Data
		$this->pdf->Cell(80,6,$data->nombreEstacion,1);
		$this->pdf->Cell(85,6,$data->nombreSistemaEstacion,1);
		$this->pdf->Ln();

		//tabla titulos
		$this->pdf->Cell(80,7,'SITUACION PREVIA',1,0,'C',1);
		$this->pdf->Cell(85,7,'TRABAJO A REALIZAR',1,0,'C',1);
		$this->pdf->Ln();
		// Data
		$this->pdf->Cell(80,6,$data->situacion_previa,1);
		$this->pdf->Cell(85,6,$data->trabajo_a_realizar,1);
		$this->pdf->Ln();


		//tabla titulos
		$this->pdf->SetFont('Arial','B',8);
		$this->pdf->Cell(165,7,'EQUIPO Y HERRAMIENTAS',1,0,'C',1);
		$this->pdf->Ln();
		$this->pdf->SetFont('Arial','',8);
		$this->pdf->Cell(80,7,'Descripcion',1,0,'C',1);
		$this->pdf->Cell(85,7,'Cantidad',1,0,'C',1);
		$this->pdf->Ln();
		// Data
		$this->pdf->Cell(80,6,$data->equipo,1);
		$this->pdf->Cell(85,6,$data->cantidad_equipo,1);
		$this->pdf->Ln();

		$this->pdf->Cell(80,6,$data->herramienta,1);
		$this->pdf->Cell(85,6,$data->cantidad_herramienta,1);
		$this->pdf->Ln();


		$this->pdf->Ln(25);

		$this->pdf->SetFont('Arial','B',8);
		$this->pdf->Cell(50,7,'_____________________________',0,0,'C');
		$this->pdf->Cell(70,7,'_____________________________',0,0,'C');
		$this->pdf->Cell(90,7,'_____________________________',0,0,'C');
		$this->pdf->Ln();
		
		$this->pdf->Cell(50,7,'TEC. RESPONSABLE',0,0,'C');
		$this->pdf->Cell(70,7,'SUPERVISOR',0,0,'C');
		$this->pdf->Cell(90,7,'JEFE DEL DEPCOM',0,0,'C');

		$this->pdf->Output('D','ordeTrabajo.pdf');

	}//end function visualizarOrdenTrabajo

}