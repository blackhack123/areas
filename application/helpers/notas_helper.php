<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	
date_default_timezone_set('America/Guayaquil');	

	#login de usuario conectado
	
	function buscarNotaPorAlumnoMateriaPadre($idAlumno, $idPeriodoAcademico, $idMateriaPMP, $aportesBloque){
		$Materias =& get_instance();
		$Materias->load->model('Materias/Materia');
		$Notas =& get_instance();
		$Notas->load->model('Notas/Nota');

					//Buscar notas hijo
					$materiasHijo = $Materias->Materia->buscarMateriasHijo($idMateriaPMP);
					
					$sumaBloque1Hijo = 0;
					$sumaBloque2Hijo = 0;
					$sumaBloque3Hijo = 0;
					$sumaExamenQ1Hijo = 0;
					$sumaBloque4Hijo = 0;
					$sumaBloque5Hijo = 0;
					$sumaBloque6Hijo = 0;
					$sumaExamenQ2Hijo = 0;

					$totalMateriasHijo = 0;
					
					$indicadorPendientes1 = 0;
					$indicadorPendientes2 = 0;
					$indicadorPendientes3 = 0;
					$indicadorPendientes4 = 0;
					$indicadorPendientes5 = 0;
					$indicadorPendientes6 = 0;
					$indicadorPendientes7 = 0;
					$indicadorPendientes8 = 0;
					$indBloque1 = 0;
					$indBloque2 = 0;
					$indBloque3 = 0;
					$indBloque4 = 0;
					$indBloque5 = 0;
					$indBloque6 = 0;
					$indExamen1 = 0;
					$indExamen2 = 0;

					foreach ($materiasHijo as $dataMateriasHijo) {
						$idMateriaPMP = $dataMateriasHijo->id;
						$notasAlumno = $Notas->Nota->buscarNotaPorAlumnoMateria($idAlumno, $idPeriodoAcademico, $idMateriaPMP);
						$promediosAlumno = calcularPromediosAlumno($notasAlumno, $aportesBloque);
						
						$bloque1 = $promediosAlumno->bloque1;
						$bloque2 = $promediosAlumno->bloque2;
						$bloque3 = $promediosAlumno->bloque3;
						$examenQ1 = $promediosAlumno->examenQ1;
						$bloque4 = $promediosAlumno->bloque4;
						$bloque5 = $promediosAlumno->bloque5;
						$bloque6 = $promediosAlumno->bloque6;
						$examenQ2 = $promediosAlumno->examenQ2;

						if(is_numeric($bloque1)){
							$sumaBloque1Hijo += $bloque1;
						}
						else{
							$sumaBloque1Hijo = 0;
							$indBloque1++;
						}
						
						if(is_numeric($bloque2)){
							$sumaBloque2Hijo += $bloque2;
						}
						else{
							$sumaBloque2Hijo = 0;
							$indBloque2++;
						}

						if(is_numeric($bloque3)){
							$sumaBloque3Hijo += $bloque3;
						}
						else{
							$sumaBloque3Hijo = 0;
							$indBloque3++;
						}

						if(is_numeric($bloque4)){
							$sumaBloque4Hijo += $bloque4;
						}
						else{
							$sumaBloque4Hijo = 0;
							$indBloque4++;
						}

						if(is_numeric($bloque5)){
							$sumaBloque5Hijo += $bloque5;
						}
						else{
							$sumaBloque5Hijo = 0;
							$indBloque5++;
						}

						if(is_numeric($bloque6)){
							$sumaBloque6Hijo += $bloque6;
						}
						else{
							$sumaBloque6Hijo = 0;
							$indBloque6++;
						}

						if(is_numeric($examenQ1)){
							$sumaExamenQ1Hijo += $examenQ1;
						}
						else{
							$sumaExamenQ1Hijo = 0;
							$indExamen1++;
						}

						if(is_numeric($examenQ2)){
							$sumaExamenQ2Hijo += $examenQ2;
						}
						else{
							$sumaExamenQ2Hijo = 0;
							$indExamen2++;
						}

						//$sumaBloque2Hijo += is_numeric($bloque2) ? $bloque2 : 0;
						//$sumaBloque3Hijo += is_numeric($bloque3) ? $bloque3 : 0;
						//$sumaExamenQ1Hijo += is_numeric($examenQ1) ? $examenQ1 : 0;
						
						//$sumaBloque4Hijo += is_numeric($bloque4) ? $bloque4 : 0;
						//$sumaBloque5Hijo += is_numeric($bloque5) ? $bloque5 : 0;
						//$sumaBloque6Hijo += is_numeric($bloque6) ? $bloque6 : 0;
						//$sumaExamenQ2Hijo += is_numeric($examenQ2) ? $examenQ2 : 0;

						$totalMateriasHijo ++;
					}
					
					$bloque1 = $indBloque1 == 0 ? number_format($sumaBloque1Hijo/$totalMateriasHijo,2) : 0;
					$bloque1 = $bloque1 > 0 ? $bloque1 : "";
					$bloque2 = $indBloque2 == 0 ? number_format($sumaBloque2Hijo/$totalMateriasHijo,2) : 0;
					$bloque2 = $bloque2 > 0 ? $bloque2 : "";
					$bloque3 = $indBloque3 == 0 ? number_format($sumaBloque3Hijo/$totalMateriasHijo,2) : 0;
					$bloque3 = $bloque3 > 0 ? $bloque3 : "";
				
				if(floatval($bloque1)>0 && floatval($bloque2)>0 && floatval($bloque3)>0){
					$promedioBloqueQ1 = number_format((floatval($bloque1)+floatval($bloque2)+floatval($bloque3))/3,2);
					$promedioBloqueQ1 = $promedioBloqueQ1 > 0 ? $promedioBloqueQ1 : ""; 
					$porcentaje80Q1 = $promedioBloqueQ1 > 0? number_format($promedioBloqueQ1*0.8, 2) : "";
				}
				else{
					$promedioBloqueQ1 = "";
					$porcentaje80Q1 = "";
				}
				
				$examenQ1 = $sumaExamenQ1Hijo>0? number_format($sumaExamenQ1Hijo/$totalMateriasHijo,2) : "";
				$porcentaje20Q1 = $examenQ1 >0 ? number_format($examenQ1*0.2, 2) : "";
				

				if(floatval($porcentaje80Q1)>0 && floatval($porcentaje20Q1)){
					$promedioQ1 = number_format((floatval($porcentaje80Q1)+floatval($porcentaje20Q1)), 2);
				}
				else{
					$promedioQ1 = "";
				}

					$bloque4 = $indBloque4 == 0 ? number_format($sumaBloque4Hijo/$totalMateriasHijo,2) : "";
					$bloque4 = $bloque4 > 0 ? $bloque4 : "";
					$bloque5 = $indBloque5 == 0 ? number_format($sumaBloque5Hijo/$totalMateriasHijo,2) : "";
					$bloque5 = $bloque5 > 0 ? $bloque5 : "";
					$bloque6 = $indBloque6 == 0 ? number_format($sumaBloque6Hijo/$totalMateriasHijo,2) : "";
					$bloque6 = $bloque6 > 0 ? $bloque6 : "";

				if(floatval($bloque4)>0 && floatval($bloque5)>0 && floatval($bloque6)>0){
					$promedioBloqueQ2 = number_format((floatval($bloque4)+floatval($bloque5)+floatval($bloque6))/3,2);
					$promedioBloqueQ2 = $promedioBloqueQ2 > 0 ? $promedioBloqueQ2 : ""; 
					$porcentaje80Q2 = $promedioBloqueQ2 > 0? number_format($promedioBloqueQ2*0.8, 2) : "";
				}
				else{
					$promedioBloqueQ2 = "";
					$porcentaje80Q2 = "";
				}
					$examenQ2 = $sumaExamenQ2Hijo>0? number_format($sumaExamenQ2Hijo/$totalMateriasHijo,2) : "";
					$porcentaje20Q2 = $examenQ2 >0 ? number_format($examenQ2*0.2, 2) : "";
					
				if(floatval($porcentaje80Q2)>0 && floatval($porcentaje20Q2)){
					$promedioQ2 = number_format((floatval($porcentaje80Q2)+floatval($porcentaje20Q2)), 2);
				}
				else{
					$promedioQ2 = "";
				}


				if(floatval($promedioQ1)>0 && floatval($promedioQ2)){
					$promedioQ1Q2 = number_truncate((floatval($promedioQ1)+floatval($promedioQ2))/2, 2);
				}
				else{
					$promedioQ1Q2 = "";
				}


				$examenMejora = "";
				$examenSupletorio = "";
				$examenRemedial = "";
				$examenGracia = "";
				$promedioAnual = "";

				$sumaBloque1 = "";
				$sumaBloque2 = "";
				$sumaBloque3 = "";

				$sumaBloque4 = "";
				$sumaBloque5 = "";
				$sumaBloque6 = "";

		$data = (object) array(
					"sumaBloque1" => $sumaBloque1,
					"bloque1" => $bloque1,
					"sumaBloque2" => $sumaBloque2,
					"bloque2" => $bloque2,
					"sumaBloque3" => $sumaBloque3,
					"bloque3" => $bloque3,
					"promedioBloqueQ1" => $promedioBloqueQ1,
					"porcentaje80Q1" => $porcentaje80Q1,
					"examenQ1" => $examenQ1,
					"porcentaje20Q1" => $porcentaje20Q1,
					"promedioQ1" => $promedioQ1,
					
					"sumaBloque4" => $sumaBloque4,
					"bloque4" => $bloque4,
					"sumaBloque5" => $sumaBloque5,
					"bloque5" => $bloque5,
					"sumaBloque6" => $sumaBloque6,
					"bloque6" => $bloque6,
					"promedioBloqueQ2" => $promedioBloqueQ2,
					"porcentaje80Q2" => $porcentaje80Q2,
					"examenQ2" => $examenQ2,
					"porcentaje20Q2" => $porcentaje20Q2,
					"promedioQ2" => $promedioQ2,
					"promedioQ1Q2" => $promedioQ1Q2,

					"examenMejora" => "m",
					"examenSupletorio" => "s",
					"examenRemedial" => "r",
					"examenGracia" => "g",

					"promedioAnual" => ""
				);

		return $data;
	}

	function buscarNotasAcademicoAlumno($idAlumno, $idPeriodoAcademico){

		$Matriculas =& get_instance();
		$Matriculas->load->model('Matriculas/Matricula');
		$Materias =& get_instance();
		$Materias->load->model('Materias/Materia');

		$matricula = $Matriculas->Matricula->buscarMatriculaPorAlumno($idAlumno, $idPeriodoAcademico);
		$idParalelo = $matricula->idParaleloMatricula;


		$materia = $Materias->Materia->buscarMateriasParalelo($idParalelo, $idPeriodoAcademico);
		// Armar el array para enviar las notas //XXX
		foreach ($materia as $dataMateria) {
			$idMateriaPMP = $dataMateria->idMateriaPMP;
            $notasMateria = buscarNotasAcademicoAlumnoMateria($idAlumno, $idPeriodoAcademico, $idMateriaPMP);
            //print_r($dataMateria);
            //print_r($notasMateria);

			foreach($notasMateria AS $var=>$value){
			    $dataMateria->$var = $value;
			}

            //$result = (object) array_merge( (array) $dataMateria, (array) $notasMateria);
            //var_dump($result);
		}


		//print_r($materia);

		return $materia;
	}

	function buscarNotasAcademicoAlumnoMateria($idAlumno, $idPeriodoAcademico, $idMateriaPMP){
		// Calculo completo por materia
		$PeriodosAcademicos =& get_instance();
		$PeriodosAcademicos->load->model('PeriodosAcademicos/PeriodoAcademico');
		$Notas =& get_instance();
		$Notas->load->model('Notas/Nota');
		$Materias =& get_instance();
		$Materias->load->model('Materias/Materia');

		$periodoAcademico = $PeriodosAcademicos->PeriodoAcademico->buscarPeriodoAcademicoPorId($idPeriodoAcademico);
		$aportesBloque = $periodoAcademico->aportesBloque;

		$materia = $Materias->Materia->buscarMateriaPorIdPMP($idMateriaPMP);
		$claseMateria = $materia->clasePMP;
        $tipoMateria = $materia->tipoMateria;

		$dataMateria = (object) array(
					"datoAlumno" => ""
				);

            if($tipoMateria == "CT"){
				if($claseMateria == "PADRE"){
					$promediosAlumno = buscarNotaPorAlumnoMateriaPadre($idAlumno, $idPeriodoAcademico, $idMateriaPMP, $aportesBloque);

				}
				else{
					$notasAlumno = $Notas->Nota->buscarNotaPorAlumnoMateria($idAlumno, $idPeriodoAcademico, $idMateriaPMP);
					$promediosAlumno = calcularPromediosAlumno($notasAlumno, $aportesBloque);
				}
					//asignar el promedio
					$bloque1 = $promediosAlumno->bloque1;
					$bloque2 = $promediosAlumno->bloque2;
					$bloque3 = $promediosAlumno->bloque3;
					$promedioBloqueQ1 = $promediosAlumno->promedioBloqueQ1;
					$porcentaje80Q1 = $promediosAlumno->porcentaje80Q1;
					$examenQ1 = floatval($promediosAlumno->examenQ1)>0? number_format(floatval($promediosAlumno->examenQ1),2):"";
					$porcentaje20Q1 = $promediosAlumno->porcentaje20Q1;
					$promedioQ1 = $promediosAlumno->promedioQ1;
					
					$bloque4 = $promediosAlumno->bloque4;
					$bloque5 = $promediosAlumno->bloque5;
					$bloque6 = $promediosAlumno->bloque6;
					$promedioBloqueQ2 = $promediosAlumno->promedioBloqueQ2;
					$porcentaje80Q2 = $promediosAlumno->porcentaje80Q2;
					$examenQ2 = $promediosAlumno->examenQ2;
					$porcentaje20Q2 = $promediosAlumno->porcentaje20Q2;
					$promedioQ2 = $promediosAlumno->promedioQ2;

					$examenMejora = "";
					$examenSupletorio = "";
					$examenRemedial = "";
					$examenGracia = "";
					$promedioQ1Q2 = $promediosAlumno->promedioQ1Q2;
					$promedioAnual = $promediosAlumno->promedioAnual;
				
			}//fin if CT
			else{
				//para materias cuantitativas se manejasuna nota por cada bloque
				$notasAlumno = $Notas->Nota->buscarNotaPorAlumnoMateria($idAlumno, $idPeriodoAcademico, $idMateriaPMP);
				//asignar el promedio
				if($notasAlumno){
					$bloque1 = $notasAlumno->nota1;
					$bloque2 = $notasAlumno->nota2;
					$bloque3 = $notasAlumno->nota3;
					$promedioBloqueQ1 = "";
					$porcentaje80Q1 = "";
					$examenQ1 = "";
					$porcentaje20Q1 = "";
					$promedioQ1 = $notasAlumno->nota3;
					
					$bloque4 = $notasAlumno->nota4;
					$bloque5 = $notasAlumno->nota5;
					$bloque6 = $notasAlumno->nota6;
					$promedioBloqueQ2 = "";
					$porcentaje80Q2 = "";
					$examenQ2 = "";
					$porcentaje20Q2 = "";
					$promedioQ2 = $notasAlumno->nota6;

					$examenMejora = "";
					$examenSupletorio = "";
					$examenRemedial = "";
					$examenGracia = "";
					$promedioQ1Q2 = $promedioQ2;
					$promedioAnual = $promedioQ2;
				}
				else{
					$bloque1 = "";
					$bloque2 = "";
					$bloque3 = "";
					$promedioBloqueQ1 = "";
					$porcentaje80Q1 = "";
					$examenQ1 = "";
					$porcentaje20Q1 = "";
					$promedioQ1 = "";
					
					$bloque4 = "";
					$bloque5 = "";
					$bloque6 = "";
					$promedioBloqueQ2 = "";
					$porcentaje80Q2 = "";
					$examenQ2 = "";
					$porcentaje20Q2 = "";
					$promedioQ2 = "";

					$examenMejora = "";
					$examenSupletorio = "";
					$examenRemedial = "";
					$examenGracia = "";
					$promedioQ1Q2 = "";
					$promedioAnual = "";
				}
			}
			
			$dataMateria->bloque1 = $bloque1;
			$dataMateria->bloque2 = $bloque2;
			$dataMateria->bloque3 = $bloque3;
			$dataMateria->promedioBloqueQ1 = $promedioBloqueQ1;
			$dataMateria->porcentaje80Q1 = $porcentaje80Q1;
			$dataMateria->examenQ1 = $examenQ1;
			$dataMateria->porcentaje20Q1 = $porcentaje20Q1;
			$dataMateria->promedioQ1 = $promedioQ1;

			$dataMateria->bloque4 = $bloque4;
			$dataMateria->bloque5 = $bloque5;
			$dataMateria->bloque6 = $bloque6;
			$dataMateria->promedioBloqueQ2 = $promedioBloqueQ2;
			$dataMateria->porcentaje80Q2 = $porcentaje80Q2;
			$dataMateria->examenQ2 = $examenQ2;
			$dataMateria->porcentaje20Q2 = $porcentaje20Q2;
			$dataMateria->promedioQ2 = $promedioQ2;
			$dataMateria->promedioQ1Q2 = $promedioQ1Q2;

			$dataMateria->examenMejora = $examenMejora;
			$dataMateria->examenSupletorio = $examenSupletorio;
			$dataMateria->examenRemedial = $examenRemedial;
			$dataMateria->examenGracia = $examenGracia;

			$dataMateria->promedioAnual = $promedioAnual;

			//print_r($dataMateria);

			return $dataMateria;

	}

	function calcularPromediosAlumno($notasAlumno, $aportesBloque){
 	    if($notasAlumno){
		  /*
		   * PRIMER QUIMESTRE
		  */ 	
		  	$insumo1 = $notasAlumno->nota1 ? $notasAlumno->nota1 : 0; 
			$insumo2 = $notasAlumno->nota2 ? $notasAlumno->nota2 : 0; 
			$insumo3 = $notasAlumno->nota3 ? $notasAlumno->nota3 : 0; 
			$insumo4 = $notasAlumno->nota4 ? $notasAlumno->nota4 : 0; 
			$insumo5 = $notasAlumno->nota5 ? $notasAlumno->nota5 : 0; 
			$bloque1 = calcularPromedioBloque($insumo1, $insumo2, $insumo3, $insumo4, $insumo5, $aportesBloque);
			$sumaBloque1 =  $bloque1->sumaBloque;
			$bloque1 =  $bloque1->promedioBloque;

		  	$insumo1 = $notasAlumno->nota6 ? $notasAlumno->nota6 : 0; 
			$insumo2 = $notasAlumno->nota7 ? $notasAlumno->nota7 : 0; 
			$insumo3 = $notasAlumno->nota8 ? $notasAlumno->nota8 : 0; 
			$insumo4 = $notasAlumno->nota9 ? $notasAlumno->nota9 : 0; 
			$insumo5 = $notasAlumno->nota10 ? $notasAlumno->nota10 : 0; 
			$bloque2 = calcularPromedioBloque($insumo1, $insumo2, $insumo3, $insumo4, $insumo5, $aportesBloque);
			$sumaBloque2 =  $bloque2->sumaBloque;
			$bloque2 =  $bloque2->promedioBloque;

		  	$insumo1 = $notasAlumno->nota11 ? $notasAlumno->nota11 : 0; 
			$insumo2 = $notasAlumno->nota12 ? $notasAlumno->nota12 : 0; 
			$insumo3 = $notasAlumno->nota13 ? $notasAlumno->nota13 : 0; 
			$insumo4 = $notasAlumno->nota14 ? $notasAlumno->nota14 : 0; 
			$insumo5 = $notasAlumno->nota15 ? $notasAlumno->nota15 : 0; 
			$bloque3 = calcularPromedioBloque($insumo1, $insumo2, $insumo3, $insumo4, $insumo5, $aportesBloque);
			$sumaBloque3 =  $bloque3->sumaBloque;
			$bloque3 =  $bloque3->promedioBloque;

			if($bloque1>0 && $bloque2>0 && $bloque3>0){
				$promedioBloqueQ1 = number_format(($bloque1+$bloque2+$bloque3)/3,2);
				$porcentaje80Q1 = number_format($promedioBloqueQ1*0.8,2);
			}
			else{
				$promedioBloqueQ1 = "";
				$porcentaje80Q1 = "";
			}

			$examen_q1 = $notasAlumno->examen_q1 ? $notasAlumno->examen_q1 : ""; 
			if($examen_q1>0){
				$porcentaje20Q1 = number_format($examen_q1*0.2,2);
			}
			else{
				$porcentaje20Q1 = "";	
			}
		    /// Promedio Quimestral
			if($porcentaje80Q1 >0 && $porcentaje20Q1>0){
				$promedioQ1 = number_format(($porcentaje80Q1+$porcentaje20Q1),2);
			}
			else{
				$promedioQ1 = "";
			}
		  /*
		   * PRIMER QUIMESTRE
		  */ 	
		  	$insumo1 = $notasAlumno->nota16 ? $notasAlumno->nota16 : 0; 
			$insumo2 = $notasAlumno->nota17 ? $notasAlumno->nota17 : 0; 
			$insumo3 = $notasAlumno->nota18 ? $notasAlumno->nota18 : 0; 
			$insumo4 = $notasAlumno->nota19 ? $notasAlumno->nota19 : 0; 
			$insumo5 = $notasAlumno->nota20 ? $notasAlumno->nota20 : 0; 
			$bloque4 = calcularPromedioBloque($insumo1, $insumo2, $insumo3, $insumo4, $insumo5, $aportesBloque);
			$sumaBloque4 =  $bloque4->sumaBloque;
			$bloque4 =  $bloque4->promedioBloque;

		  	$insumo1 = $notasAlumno->nota21 ? $notasAlumno->nota21 : 0; 
			$insumo2 = $notasAlumno->nota22 ? $notasAlumno->nota22 : 0; 
			$insumo3 = $notasAlumno->nota23 ? $notasAlumno->nota23 : 0; 
			$insumo4 = $notasAlumno->nota24 ? $notasAlumno->nota24 : 0; 
			$insumo5 = $notasAlumno->nota25 ? $notasAlumno->nota25 : 0; 
			$bloque5 = calcularPromedioBloque($insumo1, $insumo2, $insumo3, $insumo4, $insumo5, $aportesBloque);
			$sumaBloque5 =  $bloque5->sumaBloque;
			$bloque5 =  $bloque5->promedioBloque;

		  	$insumo1 = $notasAlumno->nota26 ? $notasAlumno->nota26 : 0; 
			$insumo2 = $notasAlumno->nota27 ? $notasAlumno->nota27 : 0; 
			$insumo3 = $notasAlumno->nota28 ? $notasAlumno->nota28 : 0; 
			$insumo4 = $notasAlumno->nota29 ? $notasAlumno->nota29 : 0; 
			$insumo5 = $notasAlumno->nota30 ? $notasAlumno->nota30 : 0; 
			$bloque6 = calcularPromedioBloque($insumo1, $insumo2, $insumo3, $insumo4, $insumo5, $aportesBloque);
			$sumaBloque6 =  $bloque6->sumaBloque;
			$bloque6 =  $bloque6->promedioBloque;

			if($bloque4>0 && $bloque5>0 && $bloque6>0){
				$promedioBloqueQ2 = number_format(($bloque4+$bloque5+$bloque6)/3,2);
				$porcentaje80Q2 = number_format($promedioBloqueQ2*0.8,2);
			}
			else{
				$promedioBloqueQ2 = "";
				$porcentaje80Q2 = "";
			}

			$examen_q2 = $notasAlumno->examen_q2 ? $notasAlumno->examen_q2 : ""; 
			if($examen_q2>0){
				$porcentaje20Q2 = number_format($examen_q2*0.2,2);
			}
			else{
				$porcentaje20Q2 = "";	
			}
		    /// Promedio Quimestral
			if($porcentaje80Q2 >0 && $porcentaje20Q2>0){
				$promedioQ2 = number_format(($porcentaje80Q2+$porcentaje20Q2),2);
			}
			else{
				$promedioQ2 = "";
			}

			//PROMEDIO ANUAL
			if($promedioQ1>0 && $promedioQ2>0){
				$promedioQ1Q2 = number_truncate(($promedioQ1+$promedioQ2)/2,2);
				//$promedioQ1Q2 = number_format($promedioQ1Q2,2);
			}
			else{
				$promedioQ1Q2 = "";
				//echo "string";
			}

			$examenMejora = $notasAlumno->examen_mejora ? $notasAlumno->examen_mejora : ""; 
			$examenSupletorio = $notasAlumno->examen_supletorio ? $notasAlumno->examen_supletorio : ""; 
			$examenRemedial = $notasAlumno->examen_remedial ? $notasAlumno->examen_remedial : ""; 
			$examenGracia = $notasAlumno->examen_gracia ? $notasAlumno->examen_gracia : ""; 

	    }
		else{
		  	$sumaBloque1 = "";
		  	$bloque1 = "";
		  	$sumaBloque2 = "";
		  	$bloque2 = "";
		  	$sumaBloque3 = "";
		  	$bloque3 = "";
		  	$promedioBloqueQ1 = "";
		  	$porcentaje80Q1 = "";
		  	$examen_q1 = "";
		  	$porcentaje20Q1 = "";
		  	$promedioQ1 = "";

		  	$sumaBloque4 = "";
		  	$bloque4 = "";
		  	$sumaBloque5 = "";
		  	$bloque5 = "";
		  	$sumaBloque6 = "";
		  	$bloque6 = "";
		  	$promedioBloqueQ2 = "";
		  	$porcentaje80Q2 = "";
		  	$examen_q2 = "";
		  	$porcentaje20Q2 = "";
		  	$promedioQ2 = "";
		  	$promedioQ1Q2 = "";
		  	$examenMejora ="";
		  	$examenSupletorio ="";
		  	$examenRemedial ="";
		  	$examenGracia ="";
		  	$promedioAnual = "";
		}
		
		$data = (object) array(
					"sumaBloque1" => $sumaBloque1,
					"bloque1" => $bloque1,
					"sumaBloque2" => $sumaBloque2,
					"bloque2" => $bloque2,
					"sumaBloque3" => $sumaBloque3,
					"bloque3" => $bloque3,
					"promedioBloqueQ1" => $promedioBloqueQ1,
					"porcentaje80Q1" => $porcentaje80Q1,
					"examenQ1" => $examen_q1,
					"porcentaje20Q1" => $porcentaje20Q1,
					"promedioQ1" => $promedioQ1,
					
					"sumaBloque4" => $sumaBloque4,
					"bloque4" => $bloque4,
					"sumaBloque5" => $sumaBloque5,
					"bloque5" => $bloque5,
					"sumaBloque6" => $sumaBloque6,
					"bloque6" => $bloque6,
					"promedioBloqueQ2" => $promedioBloqueQ2,
					"porcentaje80Q2" => $porcentaje80Q2,
					"examenQ2" => $examen_q2,
					"porcentaje20Q2" => $porcentaje20Q2,
					"promedioQ2" => $promedioQ2,
					"promedioQ1Q2" => $promedioQ1Q2,

					"examenMejora" => $examenMejora,
					"examenSupletorio" => $examenSupletorio,
					"examenRemedial" => $examenRemedial,
					"examenGracia" => $examenGracia,

					"promedioAnual" => ""
				);

		return $data;
	}

	function number_truncate($cantidad, $decimales){
		$dividir = explode(".", $cantidad);
		if($dividir[1] == 0) {
		  return number_format($cantidad, $decimales);
		}else{
		  $monto = number_format($dividir[0]);
		  $decimaltruncado=substr($dividir[1], 0, $decimales);
		  return $monto.".".$decimaltruncado;
		}
	}

	function calcularPromedioBloque($insumo1, $insumo2, $insumo3, $insumo4, $insumo5, $aportesBloque){
		if($aportesBloque == "N"){
			$divisor = 0;
			$sumaBloque = 0;
			if($insumo1 > 0){
				$n1 = number_format($insumo1,2);
				$sumaBloque += $n1; 
				$divisor++;
			}
			if($insumo2 > 0){
				$n2 = number_format($insumo2,2);
				$sumaBloque += $n2; 
				$divisor++;
			}
			if($insumo3 > 0){
				$n3 = number_format($insumo3,2);
				$sumaBloque += $n3; 
				$divisor++;
			}
			if($insumo4 > 0){
				$n4 = number_format($insumo4,2);
				$sumaBloque += $n4; 
				$divisor++;
			}
			if($insumo5 > 0){
				$n5 = number_format($insumo5,2);
				$sumaBloque += $n5; 
				$divisor++;
			}

		$sumaBloque = number_format($sumaBloque, 2);
		$promedioBloque = $divisor >0 ? number_format($sumaBloque/$divisor, 2) : 0;

		}
		else{
			$validarPendientes = 0;
			$validarPendientes += $insumo1 > 0 ? 0 : 1;
			$validarPendientes += $insumo2 > 0 ? 0 : 1;
			$validarPendientes += $insumo3 > 0 ? 0 : 1;
			$validarPendientes += $insumo4 > 0 ? 0 : 1;
			$validarPendientes += $insumo5 > 0 ? 0 : 1;
			
			if($validarPendientes){
				$sumaBloque = "";
				$promedioBloque = "";
			}
			else{
				$divisor = $aportesBloque > 0 ? $aportesBloque : 1;
				$sumaBloque = number_format($insumo1,2)+number_format($insumo2,2)+number_format($insumo3,2)+number_format($insumo4,2)+number_format($insumo5,2);
				$sumaBloque = number_format($sumaBloque, 2);
				$promedioBloque = number_format($sumaBloque/$divisor, 2);
			}
		}


		$data = (object) array(
					"sumaBloque" => $sumaBloque,
					"promedioBloque" => $promedioBloque
				);
		return $data;
	}

	function notasBloqueParalelo($notasAlumnos, $aportesBloque){
				foreach ($notasAlumnos as $dataNotas){
					$insumo1 = $dataNotas->nota1 ? $dataNotas->nota1 : 0;
					$insumo2 = $dataNotas->nota2 ? $dataNotas->nota2 : 0;
					$insumo3 = $dataNotas->nota3 ? $dataNotas->nota3 : 0;
					$insumo4 = $dataNotas->nota4 ? $dataNotas->nota4 : 0;
					$insumo5 = $dataNotas->nota5 ? $dataNotas->nota5 : 0;

					$calculosBloque = calcularPromedioBloque($insumo1, $insumo2, $insumo3, $insumo4, $insumo5, $aportesBloque);

					$dataNotas->sumaBloque = $calculosBloque->sumaBloque;
					$dataNotas->promedioBloque = $calculosBloque->promedioBloque;
				}	
				
				return 	$notasAlumnos;
	}

	function notasExamenParalelo($notasAlumnos){
		// se debe validar parea materias padre
		foreach ($notasAlumnos as $dataNotas){
			$dataNotas->examen = $dataNotas->examen ? $dataNotas->examen : "";
		}	
		return 	$notasAlumnos;
	}

	function escalaNota($promedioBloque){
	    if($promedioBloque>=9 && $promedioBloque<=10){
		   $escala = utf8_decode("DOMINA");
		}
		else{
		    if($promedioBloque>=7 && $promedioBloque<9){
			   $escala = utf8_decode("ALCANZA");
			}
			else{
			    if($promedioBloque>4 && $promedioBloque<7){
				    $escala = utf8_decode("PRÓXIMO");
				}
				else{
				    $escala = utf8_decode("NO ALCANZA");
				}
			}
		}//	
		return $escala;	
	}

	function escalaNotaProyectos($notaBloque){
	    switch ($notaBloque) {
	    		case 'EX':
	    			$escala = "EXCELENTE";
	    	    break;
	    		case 'MB':
	    			$escala = "MUY BUENO";
	    	    break;
	    		case 'B':
	    			$escala = "BUENO";
	    	    break;
	    		case 'R':
	    			$escala = "REGULAR";
	    	    break;
	    		
	    		default:
	    			$escala = "";
	    		break;
	    	}	
		return $escala;	
	}

	function buscarNotasComportamientoAlumno($idAlumno, $idPeriodoAcademico){
		$Comportamientos =& get_instance();
		$Comportamientos->load->model('Comportamientos/Comportamiento');

		$comportamiento = $Comportamientos->Comportamiento->buscarComportamientoPorAlumno($idAlumno, $idPeriodoAcademico);
		
		if(!$comportamiento){
			$comportamiento = (object) array(
						"nota1" => "",
						"nota2" => "",
						"nota3" => "",
						"nota4" => "",
						"nota5" => "",
						"nota6" => ""
					);

		}
		
		return $comportamiento;
	}
/* End of file fecha_helper.php */
/* Location: ./application/helpers/fecha_helper.php */

?>