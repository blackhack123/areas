<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	
date_default_timezone_set('America/Guayaquil');	

	#login de usuario conectado
	function fechaActualLetras(){
		$monthDay=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

		$weekDay=array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sabado");

		$fecha =  utf8_decode($weekDay[date("w")])." ".date("d")." de ".$monthDay[date("n")]." de ".date("Y"); 
		
		return $fecha;
	}

	function fechaActualCarnet(){
		$monthDay=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

		$weekDay=array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sabado");

		$fecha =  utf8_decode(date("d")."-".$monthDay[date("n")]."-".date("Y")); 
		
		return $fecha;
	}


	function fechaHoraActualLetras(){
		$monthDay=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

		$weekDay=array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sabado");

		$fecha =  utf8_decode($weekDay[date("w")])." ".date("d")." de ".$monthDay[date("n")]." de ".date("Y"); 
		
		$hora = strftime("a las %H:%M");

		return $fecha." ".$hora;
	}

	function fechaLetras($fecha){
		$fecha = explode("-", $fecha);
		$monthDay=array("","ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$de = $fecha[0] < 2000 ? " de " : " del ";
		$fecha =  utf8_decode($fecha[2]." de ".$monthDay[intval($fecha[1])].$de.$fecha[0]); 
	
		return $fecha;
	}

	function fechaHoraActual(){
	    $fechaHoraActual = date("Y-m-d h:i:s");	
	    return $fechaHoraActual;
	}

	function fechaActual(){
	    $fechaActual = date("Y-m-d");	
	    return $fechaActual;
	}

	function contarDiasFechas($fechaInicio, $fechaFin){
		$fecha1= new DateTime($fechaInicio);
		$fecha2= new DateTime($fechaFin);
		$diff = $fecha1->diff($fecha2);
		return $diff->days . ' dias';
	}

	function textoMatricula($numeroMatricula){
		switch($numeroMatricula){
			case '1':
				$textoMatricula = "1RA MATRÍCULA"; 
			break;
			case '2':
				$textoMatricula = "2DA MATRÍCULA"; 
			break;
			case '3':
				$textoMatricula = "3RA MATRÍCULA"; 
			break;
			default:
				$textoMatricula = ""; 
			break;
		}

		return utf8_decode($textoMatricula);		
	}

	function datosUsuarioInsertar(){
		$idUsuario = sessionUserData()['idUsuario'];
		$arrayUsuario = array(
						"cci" => $idUsuario,
						"ccd" => date("Y-m-d H:i:s")
						);
		return $arrayUsuario;
	}	

	function datosUsuarioEditar(){
		$idUsuario = sessionUserData()['idUsuario'];
		$arrayUsuario = array(
						"cwi" => $idUsuario,
						"cwd" => date("Y-m-d H:i:s")
						);
		return $arrayUsuario;
	}

	function sessionUserData(){
      $ci = &get_instance();
      //load the session library
      $ci->load->library('session');
      $session = $ci->session->all_userdata(); //this line throws errow
	  return $session;		
	}


	function normalizaCadena($cadena){
	    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
	ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
	    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
	bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
	    $cadena = utf8_decode($cadena);
	    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
	    $cadena = strtolower($cadena);
	    return utf8_encode($cadena);
	}

	function convertirTextoMinusculas($cadena){
		$search = array("Á", "É", "Í", "Ó", "Ú", "á", "é", "í", "ó", "ú", "Ñ", "ñ");
		$replace = array("A[a]", "E[a]", "I[a]", "O[a]", "U[a]", "a[a]", "e[a]", "i[a]", "o[a]", "u[a]", "N[a]", "n[a]");

		$texto_salida = str_replace($search, $replace, $cadena);
		$tipo_titulo = ucwords(strtolower($texto_salida));

		return str_replace($replace, $search, $tipo_titulo); // Salida: Áéíóú Áéíóú Mayúsculas Ábaco Ñ
	}

	function nombreNivelLetras($nombreNivel){
		switch ($nombreNivel) {
			case 'PRIMERO':
				$nombreNivel = "PRIMER";
				break;
			case 'TERCERO':
				$nombreNivel = "TERCER";
				break;
			
			default:
				$nombreNivel = $nombreNivel;
				break;
		}		
		return $nombreNivel;
	}


    function calcularEdad($fecha){
		$fecha_nac = new DateTime(date('Y/m/d',strtotime($fecha))); // Creo un objeto DateTime de la fecha ingresada
		$fecha_hoy =  new DateTime(date('Y/m/d',time())); // Creo un objeto DateTime de la fecha de hoy
		$edad = date_diff($fecha_hoy,$fecha_nac); // La funcion ayuda a calcular la diferencia, esto seria un objeto
		return $edad;
	}

	function textoMayuscula($texto){
		$texto = strtr(strtoupper($texto),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
		return $texto;
	}

	function textoMinuscula($texto){
		$texto = strtr(strtolower($texto),"ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ","àèìòùáéíóúçñäëïöü");
		return $texto;
	}

	function alumnoTextoSexo($sexoAlumno){
		switch ($sexoAlumno) {
			case '1':
				$texto = " el señor ";
			break;
			case '2':
				$texto = " la señorita ";
			break;
			
			default:
				$texto = " ";
			break;
		}
		return $texto;
	}

/* End of file fecha_helper.php */
/* Location: ./application/helpers/fecha_helper.php */

?>