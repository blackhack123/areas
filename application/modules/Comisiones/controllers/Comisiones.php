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
		$this->load->model('OrdenesTrabajo/OrdenTrabajo');

		$this->load->helper('session_helper');	
		$this->load->helper('utilidades_helper');	
		$this->load->helper('notas_helper');
		$this->load->library('Excel');
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

	
	public function reportesMatriz($idMenu){

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
		  $data['view'] = 'Comisiones/reportesComision';
		  $data['output'] = '';
		  $this->load->view('Modulos/main',$data);	
		}
		else{ 
			redirect('Login/Login');
		}

	}// end function opcionesPersonal


	public function excelComisionesPlanificadas(){

		//estilo borde alrededor de celda
		$styleArray = array(
		  'borders' => array(
		      'allborders' => array(
		          'style' => PHPExcel_Style_Border::BORDER_THIN
		      )
		  )
		);


	    $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('ComisionesPlanificadas');

		//objecto dibujo
		$objDrawing = new PHPExcel_Worksheet_Drawing();

		//agregando imagen
		$objDrawing->setName('logo');
		$objDrawing->setPath('./assets/img/logo_cc.png');
		$objDrawing->setCoordinates('A1');  
		//setOffsetX works properly
		$objDrawing->setOffsetX(5); 
		$objDrawing->setOffsetY(5);                
		//set width, height
		$objDrawing->setWidth(85); 
		$objDrawing->setHeight(90); 
		$objDrawing->setWorksheet($this->excel->getActiveSheet());

		//titulo
		$this->excel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
        $this->excel->getActiveSheet()->mergeCells('B2:J2');
        $this->excel->getActiveSheet()->setCellValue('B2', 'COMANDO CONJUNTO DE LAS FUERZAS ARMADAS');
        $this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(14);
    	$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true); 
        $this->excel->getActiveSheet()->getStyle('B2:J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("B2:J2")->applyFromArray($styleArray);
		
        $this->excel->getActiveSheet()->mergeCells('B3:J3');
        $this->excel->getActiveSheet()->setCellValue('B3', 'GRUPO DE SISTEMAS INFORMÀTICOS, COMUNICACIONES Y GUERRA ELECTRÒNICA CONJUNTO');
        $this->excel->getActiveSheet()->getStyle('B3')->getFont()->setSize(10);
    	$this->excel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true); 
        $this->excel->getActiveSheet()->getStyle('B3:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("B3:J3")->applyFromArray($styleArray);
		
        $this->excel->getActiveSheet()->mergeCells('B4:J4');
        $this->excel->getActiveSheet()->setCellValue('B4', 'COMISIONES PLANIFICADAS');
        $this->excel->getActiveSheet()->getStyle('B4')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true); 
        $this->excel->getActiveSheet()->getStyle('B4:J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("B4:J4")->applyFromArray($styleArray);

    	//encabezado
        $this->excel->getActiveSheet()->SetCellValue('B5', 'No.');
        $this->excel->getActiveSheet()->getStyle('B5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
    	$this->excel->getActiveSheet()->getStyle("B5")->applyFromArray($styleArray);

    	$this->excel->getActiveSheet()->mergeCells('C5:G5');
        $this->excel->getActiveSheet()->SetCellValue('C5', 'Fec. Inicio');
        $this->excel->getActiveSheet()->getStyle('C5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("C5:G5")->applyFromArray($styleArray);

        $this->excel->getActiveSheet()->SetCellValue('H5', 'Fec. Final');
        $this->excel->getActiveSheet()->getStyle('H5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('H5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("H5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('I5', 'Total dias');
        $this->excel->getActiveSheet()->getStyle('I5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('I5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("I5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('J5', 'CAE');
        $this->excel->getActiveSheet()->getStyle('J5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('J5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("J5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('K5', 'Estacion');
        $this->excel->getActiveSheet()->getStyle('K5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('K5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("K5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('L5', 'Sistema');
        $this->excel->getActiveSheet()->getStyle('L5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('L5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("L5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('M5', 'Tipo Mtto.');
        $this->excel->getActiveSheet()->getStyle('M5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('M5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("M5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('N5', 'Sit. Previa');
        $this->excel->getActiveSheet()->getStyle('N5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('N5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("N5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('O5', 'Act. Planificada');
        $this->excel->getActiveSheet()->getStyle('O5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('O5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("O5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('P5', 'Personal');
        $this->excel->getActiveSheet()->getStyle('P5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('P5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("P5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('Q5', 'Observaciones');
        $this->excel->getActiveSheet()->getStyle('Q5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('Q5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("Q5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);


    	$rowCount 	= 6;
    	$i 			= 1;
    	$ordenesData 	= $this->OrdenTrabajo->consultarOrdenesTrabajo();

	 	foreach ($ordenesData as $element) {
	        $this->excel->getActiveSheet()->SetCellValue('B' . $rowCount, $i);
    		$this->excel->getActiveSheet()->getStyle("B".$rowCount)->applyFromArray($styleArray);

	        $this->excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element->fec_inicio);
			$this->excel->getActiveSheet()->mergeCells('C' . $rowCount . ':G' . $rowCount);
	        $this->excel->getActiveSheet()->getStyle("C".$rowCount.':G'.$rowCount)->applyFromArray($styleArray);

	        $this->excel->getActiveSheet()->SetCellValue('H' . $rowCount, $element->fec_fin);
	        $this->excel->getActiveSheet()->getStyle("H".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("H".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
	        $this->excel->getActiveSheet()->SetCellValue('I' . $rowCount, $element->total_dias);
	        $this->excel->getActiveSheet()->getStyle("I".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("I".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
			
	        $this->excel->getActiveSheet()->SetCellValue('J' . $rowCount, $element->nombreCae);
	        $this->excel->getActiveSheet()->getStyle("J".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("J".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
			
	        $this->excel->getActiveSheet()->SetCellValue('K' . $rowCount, $element->nombreEstacion);
	        $this->excel->getActiveSheet()->getStyle("K".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("K".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
						
	        $this->excel->getActiveSheet()->SetCellValue('L' . $rowCount, $element->nombreSistemaEstacion);
	        $this->excel->getActiveSheet()->getStyle("L".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("L".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									
	        $this->excel->getActiveSheet()->SetCellValue('M' . $rowCount, $element->nombreTipoMantenimiento);
	        $this->excel->getActiveSheet()->getStyle("M".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("M".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
									
	        $this->excel->getActiveSheet()->SetCellValue('N' . $rowCount, $element->situacion_previa);
	        $this->excel->getActiveSheet()->getStyle("N".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("N".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
												
	        $this->excel->getActiveSheet()->SetCellValue('O' . $rowCount, $element->trabajo_a_realizar);
	        $this->excel->getActiveSheet()->getStyle("O".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("O".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
														
			$nombreCompleto = $element->nombrePersonal." ".$element->apellidoPersonal;
	        $this->excel->getActiveSheet()->SetCellValue('P' . $rowCount, $nombreCompleto);
	        $this->excel->getActiveSheet()->getStyle("P".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("P".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
																	
			
	        $this->excel->getActiveSheet()->SetCellValue('Q' . $rowCount, 'NINGUNA');
	        $this->excel->getActiveSheet()->getStyle("Q".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("Q".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
			$rowCount++;
	        $i++;
        }

 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="comisionesPlanificadas.xls"');
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');

	}//end function excelComisionesPlanificadas

	

	public function excelComisionesCumplidas(){

		//estilo borde alrededor de celda
		$styleArray = array(
		  'borders' => array(
		      'allborders' => array(
		          'style' => PHPExcel_Style_Border::BORDER_THIN
		      )
		  )
		);


	    $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('ComisionesPlanificadas');

		//objecto dibujo
		$objDrawing = new PHPExcel_Worksheet_Drawing();

		//agregando imagen
		$objDrawing->setName('logo');
		$objDrawing->setPath('./assets/img/logo_cc.png');
		$objDrawing->setCoordinates('A1');  
		//setOffsetX works properly
		$objDrawing->setOffsetX(5); 
		$objDrawing->setOffsetY(5);                
		//set width, height
		$objDrawing->setWidth(85); 
		$objDrawing->setHeight(90); 
		$objDrawing->setWorksheet($this->excel->getActiveSheet());

		//titulo
		$this->excel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
        $this->excel->getActiveSheet()->mergeCells('B2:S2');
        $this->excel->getActiveSheet()->setCellValue('B2', 'COMANDO CONJUNTO DE LAS FUERZAS ARMADAS');
        $this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(14);
    	$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true); 
        $this->excel->getActiveSheet()->getStyle('B2:S2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("B2:S2")->applyFromArray($styleArray);
		
        $this->excel->getActiveSheet()->mergeCells('B3:S3');
        $this->excel->getActiveSheet()->setCellValue('B3', 'GRUPO DE SISTEMAS INFORMÀTICOS, COMUNICACIONES Y GUERRA ELECTRÒNICA CONJUNTO');
        $this->excel->getActiveSheet()->getStyle('B3')->getFont()->setSize(10);
    	$this->excel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true); 
        $this->excel->getActiveSheet()->getStyle('B3:S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("B3:S3")->applyFromArray($styleArray);
		
        $this->excel->getActiveSheet()->mergeCells('B4:S4');
        $this->excel->getActiveSheet()->setCellValue('B4', 'COMISIONES CUMPLIDAS');
        $this->excel->getActiveSheet()->getStyle('B4')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true); 
        $this->excel->getActiveSheet()->getStyle('B4:S4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("B4:S4")->applyFromArray($styleArray);

    	//encabezado
        $this->excel->getActiveSheet()->SetCellValue('B5', 'No.');
        $this->excel->getActiveSheet()->getStyle('B5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
    	$this->excel->getActiveSheet()->getStyle("B5")->applyFromArray($styleArray);

    	$this->excel->getActiveSheet()->mergeCells('C5:G5');
        $this->excel->getActiveSheet()->SetCellValue('C5', 'Fec. Inicio');
        $this->excel->getActiveSheet()->getStyle('C5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("C5:G5")->applyFromArray($styleArray);

        $this->excel->getActiveSheet()->SetCellValue('H5', 'Fec. Final');
        $this->excel->getActiveSheet()->getStyle('H5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('H5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("H5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('I5', 'Total dias');
        $this->excel->getActiveSheet()->getStyle('I5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('I5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("I5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('J5', 'CAE');
        $this->excel->getActiveSheet()->getStyle('J5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('J5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("J5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('K5', 'Estacion');
        $this->excel->getActiveSheet()->getStyle('K5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('K5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("K5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('L5', 'Sistema');
        $this->excel->getActiveSheet()->getStyle('L5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('L5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("L5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('M5', 'Tipo Mtto.');
        $this->excel->getActiveSheet()->getStyle('M5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('M5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("M5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('N5', 'Sit. Previa');
        $this->excel->getActiveSheet()->getStyle('N5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('N5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("N5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('O5', 'Act. Planificada');
        $this->excel->getActiveSheet()->getStyle('O5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('O5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("O5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('P5', 'Personal');
        $this->excel->getActiveSheet()->getStyle('P5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('P5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("P5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('Q5', 'Cump. Comision');
        $this->excel->getActiveSheet()->getStyle('Q5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('Q5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("Q5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('R5', 'Ord. Trabajo');
        $this->excel->getActiveSheet()->getStyle('R5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('R5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("R5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('S5', 'Inf. Comision');
        $this->excel->getActiveSheet()->getStyle('S5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('S5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("S5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);


    	$rowCount 	= 6;
    	$i 			= 1;
    	$ordenesData 	= $this->OrdenTrabajo->consultarOrdenesTrabajo();

	 	foreach ($ordenesData as $element) {
	        $this->excel->getActiveSheet()->SetCellValue('B' . $rowCount, $i);
    		$this->excel->getActiveSheet()->getStyle("B".$rowCount)->applyFromArray($styleArray);

	        $this->excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element->fec_inicio);
			$this->excel->getActiveSheet()->mergeCells('C' . $rowCount . ':G' . $rowCount);
	        $this->excel->getActiveSheet()->getStyle("C".$rowCount.':G'.$rowCount)->applyFromArray($styleArray);

	        $this->excel->getActiveSheet()->SetCellValue('H' . $rowCount, $element->fec_fin);
	        $this->excel->getActiveSheet()->getStyle("H".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("H".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
	        $this->excel->getActiveSheet()->SetCellValue('I' . $rowCount, $element->total_dias);
	        $this->excel->getActiveSheet()->getStyle("I".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("I".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
			
	        $this->excel->getActiveSheet()->SetCellValue('J' . $rowCount, $element->nombreCae);
	        $this->excel->getActiveSheet()->getStyle("J".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("J".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
			
	        $this->excel->getActiveSheet()->SetCellValue('K' . $rowCount, $element->nombreEstacion);
	        $this->excel->getActiveSheet()->getStyle("K".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("K".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
						
	        $this->excel->getActiveSheet()->SetCellValue('L' . $rowCount, $element->nombreSistemaEstacion);
	        $this->excel->getActiveSheet()->getStyle("L".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("L".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
									
	        $this->excel->getActiveSheet()->SetCellValue('M' . $rowCount, $element->nombreTipoMantenimiento);
	        $this->excel->getActiveSheet()->getStyle("M".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("M".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
									
	        $this->excel->getActiveSheet()->SetCellValue('N' . $rowCount, $element->situacion_previa);
	        $this->excel->getActiveSheet()->getStyle("N".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("N".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
												
	        $this->excel->getActiveSheet()->SetCellValue('O' . $rowCount, $element->trabajo_a_realizar);
	        $this->excel->getActiveSheet()->getStyle("O".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("O".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
														
			$nombreCompleto = $element->nombrePersonal." ".$element->apellidoPersonal;
	        $this->excel->getActiveSheet()->SetCellValue('P' . $rowCount, $nombreCompleto);
	        $this->excel->getActiveSheet()->getStyle("P".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("P".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
																	
			
	        $this->excel->getActiveSheet()->SetCellValue('Q' . $rowCount, 'SI');
	        $this->excel->getActiveSheet()->getStyle("Q".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("Q".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
						
	        $this->excel->getActiveSheet()->SetCellValue('R' . $rowCount, 'SI');
	        $this->excel->getActiveSheet()->getStyle("R".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("R".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
			$this->excel->getActiveSheet()->SetCellValue('S' . $rowCount, '');
	        $this->excel->getActiveSheet()->getStyle("S".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("S".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
			$rowCount++;
	        $i++;
        }

 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="comisionesCumplidas.xls"');
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');

	}//end function excelComisionesCumplidas

}