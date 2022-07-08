<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Caes extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('CategoriasMenus/CategoriaMenu');
		$this->load->model('PerfilesMenus/PerfilMenu');
		$this->load->model('Menus/Menu');
		$this->load->model('Caes/Cae');
		$this->load->model('Sectores/Sector');
		$this->load->model('Estaciones/Estacion');

		$this->load->helper('session_helper');	
		$this->load->helper('utilidades_helper');	
		$this->load->helper('notas_helper');
		//agrega libreria excel
		$this->load->library('Excel');
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
		$data['view'] = 'Caes/index';
		$data['output'] = '';
		$this->load->view('Modulos/main',$data);	
	  }
	  else{ 
	  	redirect('Login/Login');
	  }
	}

	public function lista(){
		$data['lista'] = $this->Cae->buscarCaes();
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['status'] = $dataSession->status;
		$this->load->view('Caes/lista',$data);		
	}

	public function gestionRegistro(){
		$idCae = $this->input->post("idCae");
		$data = array("unidad_id" => 1,
					 "nombre" => textoMayuscula($this->input->post("nombreCae"))
					);
		if($idCae > 0){
			$data = array_merge($data, datosUsuarioEditar());
			echo json_encode("e|".$this->Cae->editarRegistro($idCae, $data));
		}
		else{
			$data = array_merge($data, datosUsuarioInsertar());
			echo json_encode("i|".$this->Cae->insertarRegistro($data));
		}
	}

	public function buscarRegistroPorID(){
		$idCae = $this->input->post("idCae");
		$data = $this->Cae->buscarRegistroPorID($idCae);
		print_r(json_encode($data));
	}

	public function eliminarRegistro(){
		$idCae = $this->input->post("idCae");
		$resultado = $this->Cae->eliminarRegistro($idCae);
		if($resultado){
			echo json_encode(true);
		}
		else{
			echo json_encode(false);
		}		
	}

	public function buscarCaes(){
		$data = $this->Cae->buscarCaes();
		print_r(json_encode($data));
	}


	public function opcionCaes($idMenu){

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
		  $data['listaSectores'] = $this->Sector->buscarSectores();
		  $data['view'] = 'Caes/reportesCaes';
		  $data['output'] = '';
		  $this->load->view('Modulos/main',$data);	
		}
		else{ 
			redirect('Login/Login');
		}

	}// end function opcionCaes


	public function exportarExcel(){

		//estilo borde alrededor de celda
		$styleArray = array(
		  'borders' => array(
		      'allborders' => array(
		          'style' => PHPExcel_Style_Border::BORDER_THIN
		      )
		  )
		);


	    $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('listadoCaes');

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
        $this->excel->getActiveSheet()->setCellValue('B4', 'Listado de Centros de Apoyo Electrónico');
        $this->excel->getActiveSheet()->getStyle('B4')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true); 
        $this->excel->getActiveSheet()->getStyle('B4:J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("B4:J4")->applyFromArray($styleArray);

    	//encabezado
        $this->excel->getActiveSheet()->SetCellValue('B5', 'No.');
        $this->excel->getActiveSheet()->getStyle('B5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
    	$this->excel->getActiveSheet()->getStyle("B5")->applyFromArray($styleArray);

    	$this->excel->getActiveSheet()->mergeCells('C5:J5');
        $this->excel->getActiveSheet()->SetCellValue('C5', 'Nombre');
        $this->excel->getActiveSheet()->getStyle('C5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("C5:J5")->applyFromArray($styleArray);

    	$rowCount 	= 6;
    	$i 			= 1;
    	$caesData 	= $this->Cae->listadoCaes();

	 	foreach ($caesData as $element) {
	        $this->excel->getActiveSheet()->SetCellValue('B' . $rowCount, $i);
    		$this->excel->getActiveSheet()->getStyle("B".$rowCount)->applyFromArray($styleArray);

	        $this->excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['nombre']);
			$this->excel->getActiveSheet()->mergeCells('C' . $rowCount . ':J' . $rowCount);
	        $this->excel->getActiveSheet()->getStyle("C".$rowCount.':J'.$rowCount)->applyFromArray($styleArray);

	        $rowCount++;
	        $i++;
        }


 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="listadoCaes.xls"');
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');

	}//end function exportarExcel


	public function excelSecciones(){

		//estilo borde alrededor de celda
		$styleArray = array(
		  'borders' => array(
		      'allborders' => array(
		          'style' => PHPExcel_Style_Border::BORDER_THIN
		      )
		  )
		);


	    $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('listadoSecciones');

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
        $this->excel->getActiveSheet()->setCellValue('B4', 'Listado Secciones');
        $this->excel->getActiveSheet()->getStyle('B4')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true); 
        $this->excel->getActiveSheet()->getStyle('B4:J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("B4:J4")->applyFromArray($styleArray);

    	//encabezado
        $this->excel->getActiveSheet()->SetCellValue('B5', 'No.');
        $this->excel->getActiveSheet()->getStyle('B5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
    	$this->excel->getActiveSheet()->getStyle("B5")->applyFromArray($styleArray);

    	$this->excel->getActiveSheet()->mergeCells('C5:J5');
        $this->excel->getActiveSheet()->SetCellValue('C5', 'Nombre');
        $this->excel->getActiveSheet()->getStyle('C5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("C5:J5")->applyFromArray($styleArray);

    	$rowCount 	= 6;
    	$i 			= 1;
    	$seccionesData 	= $this->Cae->listadoSecciones();

	 	foreach ($seccionesData as $element) {
	        $this->excel->getActiveSheet()->SetCellValue('B' . $rowCount, $i);
    		$this->excel->getActiveSheet()->getStyle("B".$rowCount)->applyFromArray($styleArray);

	        $this->excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['nombre']);
			$this->excel->getActiveSheet()->mergeCells('C' . $rowCount . ':J' . $rowCount);
	        $this->excel->getActiveSheet()->getStyle("C".$rowCount.':J'.$rowCount)->applyFromArray($styleArray);

	        $rowCount++;
	        $i++;
        }


 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="listadoSecciones.xls"');
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');

	}//end function excelSecciones


	public function excelEstaciones(){

		//id sector
		$idSector = $this->input->post("sector");
		//estilo borde alrededor de celda
		$styleArray = array(
		  'borders' => array(
		      'allborders' => array(
		          'style' => PHPExcel_Style_Border::BORDER_THIN
		      )
		  )
		);


	    $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('listadoEstaciones');

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
        $this->excel->getActiveSheet()->setCellValue('B4', 'Listado Estaciones');
        $this->excel->getActiveSheet()->getStyle('B4')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true); 
        $this->excel->getActiveSheet()->getStyle('B4:J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->getStyle("B4:J4")->applyFromArray($styleArray);

    	//encabezado
        $this->excel->getActiveSheet()->SetCellValue('B5', 'No.');
        $this->excel->getActiveSheet()->getStyle('B5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('B5')->getFont()->setBold(true);
    	$this->excel->getActiveSheet()->getStyle("B5")->applyFromArray($styleArray);

    	$this->excel->getActiveSheet()->mergeCells('C5:J5');
        $this->excel->getActiveSheet()->SetCellValue('C5', 'Nombre');
        $this->excel->getActiveSheet()->getStyle('C5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("C5:J5")->applyFromArray($styleArray);

    	$rowCount 	= 6;
    	$i 			= 1;
    	$estacionesData 	= $this->Estacion->buscarEstacionesSector($idSector);

	 	foreach ($estacionesData as $element) {
	        $this->excel->getActiveSheet()->SetCellValue('B' . $rowCount, $i);
    		$this->excel->getActiveSheet()->getStyle("B".$rowCount)->applyFromArray($styleArray);

	        $this->excel->getActiveSheet()->SetCellValue('C' . $rowCount, $element->nombreEstacion);
			$this->excel->getActiveSheet()->mergeCells('C' . $rowCount . ':J' . $rowCount);
	        $this->excel->getActiveSheet()->getStyle("C".$rowCount.':J'.$rowCount)->applyFromArray($styleArray);

	        $rowCount++;
	        $i++;
        }


 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="listadoEstaciones.xls"');
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');

	}//end function excelEstaciones


}//end class	