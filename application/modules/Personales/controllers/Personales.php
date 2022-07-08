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
		$this->load->model('Usuarios/Usuario');
		$this->load->model('Armas/Arma');
		$this->load->model('Pases/Pase');
		$this->load->model('TiposFuerzas/TipoFuerza');

		$this->load->helper('session_helper');	
		$this->load->helper('utilidades_helper');	
		$this->load->helper('notas_helper');
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
		$data['view'] = 'Personales/index';
		$data['output'] = '';
		$this->load->view('Modulos/main',$data);	
	  }
	  else{ 
	  	redirect('Login/Login');
	  }
	}

	public function lista(){
		$idTipoFuerza = $this->input->post("idTipoFuerza");
		$data['lista'] = $this->Personal->buscarPersonalFuerza($idTipoFuerza);
		$urlCode = $this->input->post("urlCode");
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['status'] = $dataSession->status;
		$this->load->view('Personales/lista',$data);		
	}

	public function formulario(){
		$idPersonal = $this->input->post("idPersonal");
		$idTipoFuerza = $this->input->post("idTipoFuerza");
		$urlCode = $this->input->post("urlCode");

		if($idPersonal > 0){
			$personal = $this->Personal->buscarRegistroPorID($idPersonal);
			$data['idFuerza'] = $personal->idFuerza;
			$data['grado'] = $this->Grado->buscarGradosFuerza($personal->idFuerza);
			$data['idGrado'] = $personal->idGrado;
			$data['idEstadoCivil'] = $personal->idEstadoCivil;
			$data['personal'] = $personal;
			$data['idFuncion'] = $personal->idFuncion;
			$data['tituloPagina'] = "Editar Registro";
			//Enviar los datos del usuario
		}
		else{
			$data['personal'] = "";
			$data['tituloPagina'] = "Nuevo Registro";
		}
		$data['arma'] = $this->Arma->buscarArmasTipoFuerza($idTipoFuerza);
		$data['funcion'] = $this->Funcion->buscarFunciones();
		$data['fuerza'] = $this->Fuerza->buscarFuerzasPorTipo($idTipoFuerza);
		$data['estadoCivil'] = $this->EstadoCivil->buscarEstadosCiviles();
		$data['urlCode'] = $urlCode;
		
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
					 "arma_id" => $this->input->post("idArma"),
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
					 "sexo" => $this->input->post("sexoPersonal"),
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

	//*************************************//
	// Gestionar El perfil del personal //
	//*************************************//

	public function perfilPersonal($idMenu){
	  if($this->session->userdata('login')){
		//Vista
		$data['menuNombre'] = 'PERFIL';
		$data['codigoCategoriaMenu'] = 'configuracion';
		$data['codigoMenu'] = 'perfil';
	    $data['status'] = "";
		$data['view'] = 'Personales/indexPerfil';
		$data['urlCode'] = "1";
		$data['output'] = '';
		$this->load->view('Modulos/main',$data);	
	  }
	  else{ 
	  	redirect('Login/Login');
	  }
	}

	//*************************************//
	// Gestionar pases del personal //
	//*************************************//

	public function pasePersonal(){
		$idPersonal = $this->input->post("idPersonal");
		$urlCode = $this->input->post("urlCode");
		$data['lista'] = $this->Pase->buscarPasePersonal($idPersonal);
		$idMenu = desencriptar($urlCode);
		$dataSession = verificarPrivilegios($idMenu);
		$data['status'] = $dataSession->status;
		$data['idPersonal'] = $idPersonal;
		$personal = $this->Personal->buscarRegistroPorID($idPersonal);
		$data['tituloPagina'] = $personal->abreviaturaGrado." ".$personal->apellidoPersonal." ".$personal->nombrePersonal;
		$this->load->view('Pases/lista',$data);		
	}

	public function buscarPersonalCae(){
		$idCae = $this->input->post('idCae');
		$data = $this->Personal->buscarPersonalCae($idCae);
		print_r(json_encode($data));		
	}


	public function opcionesPersonal($idMenu){

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
		  $data['listaTipoFuerza'] = $this->TipoFuerza->buscarTipoFuerza();
		  $data['listaPersonal'] = $this->Personal->buscarPersonal();
		  $data['view'] = 'Personales/reportesPersonal';
		  $data['output'] = '';
		  $this->load->view('Modulos/main',$data);	
		}
		else{ 
			redirect('Login/Login');
		}

	}// end function opcionesPersonal


	public function excelPersonal(){

		//estilo borde alrededor de celda
		$styleArray = array(
		  'borders' => array(
		      'allborders' => array(
		          'style' => PHPExcel_Style_Border::BORDER_THIN
		      )
		  )
		);


	    $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('listadoPersonal');

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
        $this->excel->getActiveSheet()->setCellValue('B4', 'Listado General de Personal');
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
        $this->excel->getActiveSheet()->SetCellValue('C5', 'Nombres');
        $this->excel->getActiveSheet()->getStyle('C5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("C5:G5")->applyFromArray($styleArray);

        $this->excel->getActiveSheet()->SetCellValue('H5', 'Cedula');
        $this->excel->getActiveSheet()->getStyle('H5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('H5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("H5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('I5', 'Fuerza');
        $this->excel->getActiveSheet()->getStyle('I5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('I5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("I5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('J5', 'Grado');
        $this->excel->getActiveSheet()->getStyle('J5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('J5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("J5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);


    	$rowCount 	= 6;
    	$i 			= 1;
    	$personalData 	= $this->Personal->buscarPersonal();

	 	foreach ($personalData as $element) {
	        $this->excel->getActiveSheet()->SetCellValue('B' . $rowCount, $i);
    		$this->excel->getActiveSheet()->getStyle("B".$rowCount)->applyFromArray($styleArray);

			$nombreCompleto = $element->nombrePersonal." ".$element->apellidoPersonal;
	        $this->excel->getActiveSheet()->SetCellValue('C' . $rowCount, $nombreCompleto);
			$this->excel->getActiveSheet()->mergeCells('C' . $rowCount . ':G' . $rowCount);
	        $this->excel->getActiveSheet()->getStyle("C".$rowCount.':G'.$rowCount)->applyFromArray($styleArray);

	        $this->excel->getActiveSheet()->SetCellValue('H' . $rowCount, $element->numeroIdentificacionPersonal);
	        $this->excel->getActiveSheet()->getStyle("H".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("H".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
	        $this->excel->getActiveSheet()->SetCellValue('I' . $rowCount, $element->nombreFuerza);
	        $this->excel->getActiveSheet()->getStyle("I".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("I".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
						
	        $this->excel->getActiveSheet()->SetCellValue('J' . $rowCount, $element->abreviaturaGrado);
	        $this->excel->getActiveSheet()->getStyle("J".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("J".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
			$rowCount++;
	        $i++;
        }


 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="listadoPersonal.xls"');
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');

	}//end function excelPersonal


	public function excelPersonalPorTipo(){

		$idTipoFuerza = $this->input->post("tipoFuerza");

		//estilo borde alrededor de celda
		$styleArray = array(
		  'borders' => array(
		      'allborders' => array(
		          'style' => PHPExcel_Style_Border::BORDER_THIN
		      )
		  )
		);


	    $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('listadoPersonal');

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
        $this->excel->getActiveSheet()->setCellValue('B4', 'Listado Personal');
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
        $this->excel->getActiveSheet()->SetCellValue('C5', 'Nombres');
        $this->excel->getActiveSheet()->getStyle('C5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("C5:G5")->applyFromArray($styleArray);

        $this->excel->getActiveSheet()->SetCellValue('H5', 'Cedula');
        $this->excel->getActiveSheet()->getStyle('H5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('H5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("H5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('I5', 'Fuerza');
        $this->excel->getActiveSheet()->getStyle('I5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('I5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("I5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

        $this->excel->getActiveSheet()->SetCellValue('J5', 'Grado');
        $this->excel->getActiveSheet()->getStyle('J5')->getFont()->setSize(12);
    	$this->excel->getActiveSheet()->getStyle('J5')->getFont()->setBold(true); 
    	$this->excel->getActiveSheet()->getStyle("J5")->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);


    	$rowCount 	= 6;
    	$i 			= 1;
    	$personalData 	= $this->Personal->buscarPersonalFuerza($idTipoFuerza);

	 	foreach ($personalData as $element) {
	        $this->excel->getActiveSheet()->SetCellValue('B' . $rowCount, $i);
    		$this->excel->getActiveSheet()->getStyle("B".$rowCount)->applyFromArray($styleArray);

			$nombreCompleto = $element->nombrePersonal." ".$element->apellidoPersonal;
	        $this->excel->getActiveSheet()->SetCellValue('C' . $rowCount, $nombreCompleto);
			$this->excel->getActiveSheet()->mergeCells('C' . $rowCount . ':G' . $rowCount);
	        $this->excel->getActiveSheet()->getStyle("C".$rowCount.':G'.$rowCount)->applyFromArray($styleArray);

	        $this->excel->getActiveSheet()->SetCellValue('H' . $rowCount, $element->numeroIdentificacionPersonal);
	        $this->excel->getActiveSheet()->getStyle("H".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("H".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
	        $this->excel->getActiveSheet()->SetCellValue('I' . $rowCount, $element->nombreFuerza);
	        $this->excel->getActiveSheet()->getStyle("I".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("I".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
						
	        $this->excel->getActiveSheet()->SetCellValue('J' . $rowCount, $element->abreviaturaGrado);
	        $this->excel->getActiveSheet()->getStyle("J".$rowCount)->applyFromArray($styleArray);
			$this->excel->getActiveSheet()->getStyle("J".$rowCount)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			
			$rowCount++;
	        $i++;
        }


 
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="listadoPorTipo.xls"');
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        // Forzamos a la descarga
        $objWriter->save('php://output');

	}//end function excelPersonalPorTipo


}	