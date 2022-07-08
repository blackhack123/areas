<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Parte extends CI_Model{
	
	public function buscarParteFechaCae($idCae, $fechaParte){
		$sql = "SELECT parte.id AS idParte, parte.numero AS numeroParte, parte.fecha AS fechaParte, parte.tiene_novedad AS tieneNovedadParte FROM parte WHERE parte.cae_id = $idCae AND parte.fecha = '$fechaParte'";
		
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}
	}

	public function insertarRegistro($data){
		$this->db->insert("parte", $data);
		return $this->db->insert_id();
	}

	public function buscarRegistroPorID($idParte){
		$sql = "SELECT parte.id AS idParte, parte.cae_id as idCae, parte.numero AS numeroParte, parte.fecha AS fechaParte, parte.tiene_novedad AS tieneNovedadParte, parte.estado AS estadoParte FROM parte WHERE parte.id = $idParte";
		
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function editarRegistro($idParte, $data){
		$this->db->where("id", $idParte);
		$this->db->update("parte", $data);
		return $this->db->affected_rows();
	}

	public function buscarPartesPorEstado($estado){
		$sql = "SELECT parte.id AS idParte, cae.nombre AS nombreCae, parte.fecha AS fechaParte, parte.tiene_novedad AS tieneNovedadParte, detalle_parte.es_solucionado AS esSolucionadoDetalleParte, sector.nombre AS nombreSector, estacion.nombre AS nombreEstacion, sistema.nombre AS nombreSistema, parte.estado AS estadoParte FROM parte INNER JOIN detalle_parte ON detalle_parte.parte_id = parte.id INNER JOIN cae ON parte.cae_id = cae.id INNER JOIN tipo_existencia ON detalle_parte. tipo_existencia_id = tipo_existencia.id INNER JOIN sistema ON tipo_existencia.sistema_id = sistema.id INNER JOIN estacion ON tipo_existencia.estacion_id = estacion.id INNER JOIN sector ON sector.cae_id = cae.id AND estacion.sector_id = sector.id WHERE parte.estado ='$estado' GROUP BY parte.id ORDER BY fechaParte ASC";
		
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}		
	}
	

	public function insertarParteGuardia($data){

		//data Parte
		$dataParte['cae_id'] 		= $data['idCae'];
		$dataParte['sector_id'] 	= $data['idSector'];
		$dataParte['estacion_id'] 	= $data['idEstacion'];
		$dataParte['numero']  		= $data['numero'];
		$dataParte['fecha']			= $data['fechaParte'];
		$dataParte['tiene_novedad']	= 'SI';
		$dataParte['estado']		= 'G';

		//insert parte
		$this->db->insert("parte", $dataParte);
		$idParte = $this->db->insert_id();

		// data detalle parte
		$dataDetalleParte['parte_id'] 				= $idParte;
		$dataDetalleParte['tipo_existencia_id']  	= $data['idTipoExistencia'];
		$dataDetalleParte['fecha_fallo']			= $data['fechaParte'];
		$dataDetalleParte['novedad']				= $data['novedadDetalleParte'];
		$dataDetalleParte['requerimiento']			= $data['requerimientoDetalleParte'];

		//insert detalle parte
		$this->db->insert("detalle_parte", $dataDetalleParte);

		return $idParte;

	}// end function insertarParteGuardia


	public function consultarPartes(){

		$sql = " SELECT parte.id, parte.numero, parte.fecha, parte.estado, parte.supervisor, parte.gestion_supervisor, 
				parte.jefe, parte.gestion_jefe, parte.ordenTrabajo, parte.detalleOrden, parte.ordenGenerada, 
				cae.nombre AS cae, detalle_parte.novedad,
				 detalle_parte.requerimiento, detalle_parte.solucion, 
				detalle_parte.es_solucionado, tipo_existencia.nombre AS tipo_existencia, detalle_parte.fecha_fallo,
				tipo_existencia.propiedad
				FROM parte
					LEFT JOIN cae ON cae.id = parte.cae_id
					LEFT JOIN detalle_parte ON detalle_parte.parte_id = parte.id 
					LEFT JOIN tipo_existencia ON tipo_existencia.id = detalle_parte.tipo_existencia_id
				ORDER BY parte.id DESC ";
		$result = $this->db->query($sql);
		if($result->num_rows() > 0){
			return $result->result();
		}
		else{
			return false;
		}		


	}// end fuction consultarPartes


	public function consultarPartesDelDia(){

		$sql = " SELECT parte.id, parte.numero, parte.fecha,
				parte.estado, cae.nombre AS cae, detalle_parte.novedad, detalle_parte.requerimiento,
				detalle_parte.es_solucionado, tipo_existencia.nombre AS tipo_existencia, tipo_existencia.propiedad
				FROM parte
					LEFT JOIN cae ON cae.id = parte.cae_id
					LEFT JOIN detalle_parte ON detalle_parte.parte_id = parte.id 
					LEFT JOIN tipo_existencia ON tipo_existencia.id = detalle_parte.tipo_existencia_id
				WHERE  parte.fecha = DATE(NOW()) ";
		$result = $this->db->query($sql);
		if($result->num_rows() > 0){
			return $result->result();
		}
		else{
			return false;
		}		

	}// end fuction consultarPartesDelDia


	public function consultarPartePorId($idParte){

		$sql = " SELECT parte.id, parte.numero, parte.fecha ,parte.estado, parte.cae_id, parte.sector_id, parte.estacion_id, 
				cae.nombre AS cae, detalle_parte.novedad, detalle_parte.requerimiento, 
				detalle_parte.es_solucionado, detalle_parte.tipo_existencia_id, detalle_parte.fecha_fallo, 
				tipo_existencia.nombre AS tipo_existencia, tipo_existencia.propiedad
				FROM parte
					LEFT JOIN cae ON cae.id = parte.cae_id
					LEFT JOIN detalle_parte ON detalle_parte.parte_id = parte.id 
					LEFT JOIN tipo_existencia ON tipo_existencia.id = detalle_parte.tipo_existencia_id
				WHERE  parte.id = ".$idParte;
		$row = $this->db->query($sql);
		if($row->num_rows() > 0){
			return $row->result();
		}
		else{
			return false;
		}		

	}// end fuction consultarPartePorId


	public function eliminarParte($idParte){
		$this->db->where('parte_id', $idParte);
		$this->db->delete('detalle_parte');

		
		$this->db->where('id', $idParte);
		$this->db->delete('parte');
		return $this->db->affected_rows();
		
	}//end function eliminarParte


	public function enviarPendientes($estadoSupervisor){
		
		$data = array(
			'supervisor' => 1,
		);
	
		$this->db->where('supervisor', '=0');
		$this->db->update('parte', $data);
		return $this->db->affected_rows();

	}//end function enviarPendientes


	public function gestionSupervisor($idParte, $solucionado, $fechaSolucion, $fechaFueraServicio, $solucionSupervisor){
		
		//update detalle parte
		$data = array(
			'es_solucionado' => $solucionado,
			'fecha_solucion' => $fechaSolucion,
			'solucion' => $solucionSupervisor,
			'horas_fuera_servicio' => $fechaFueraServicio
		);
	
		$this->db->where('parte_id', $idParte);
		$this->db->update('detalle_parte', $data);

		//gestion supervisor ok
		$data = array(
			'gestion_supervisor' => 1,
			'jefe' => 1
		);
	
		$this->db->where('id', $idParte);
		$this->db->update('parte', $data);

		return $this->db->affected_rows();

	}//end function gestionSupervisor


	public function generarOrdenTrabajo($idParte, $generar, $detalleOrden){

		$data = array(
			'ordenTrabajo' => $generar,
			'detalleOrden' => $detalleOrden
		);
		$this->db->where('id', $idParte);
		$this->db->update('parte', $data);
		return $this->db->affected_rows();

	}//end function generarOrdenTrabajo


	public function grabarOrdenTrabajo($idParte,$idCae,$fechaInicio,$fechaFin,$totalDias,$personal,$sistemaPersonal,$provincia,$tipoTrabajo,$estacion,$sistemaEstacion,$situacionPrevia,$trabajoRealizar,$nombreEquipo,$cantidadEquipo,$nombreHerramienta,$cantidadHerramienta){

		
		$data['parte_id '] 				= $idParte;
		$data['cae_id'] 				= $idCae;
		$data['fec_inicio'] 			= $fechaInicio;
		$data['fec_fin'] 				= $fechaFin;
		$data['total_dias'] 			= $totalDias;
		$data['personal_id'] 			= $personal;
		$data['sistema_id'] 			= $sistemaPersonal;
		$data['provincia_id'] 			= $provincia;
		$data['tipo_trabajo_id'] 		= $tipoTrabajo;
		$data['estacion_id'] 			= $estacion;
		$data['sistema_estacion_id'] 	= $sistemaEstacion;
		$data['situacion_previa'] 		= $situacionPrevia;
		$data['trabajo_a_realizar'] 	= $trabajoRealizar;
		$data['equipo'] 				= $nombreEquipo;
		$data['cantidad_equipo'] 		= $cantidadEquipo;
		$data['herramienta'] 			= $nombreHerramienta;
		$data['cantidad_herramienta'] 	= $cantidadHerramienta;


		$this->db->insert("orden_trabajo", $data);
		$idOrden = $this->db->insert_id();

		//actualizar parte
		$dataParte = array(
			'ordenGenerada' => 1
		);
		$this->db->where('id', $idParte);
		$this->db->update('parte', $dataParte);

	}//edn function grabarOrdenTrabajo


	/*public function buscarPartesCompleto(){
		$sql = "SELECT parte.id AS idParte, estacion.nombre AS nombreEstacion, sistema.nombre AS nombreSistema, parte.fecha AS fechaParte, parte.novedad AS novedadParte, parte.es_solucionado AS esSolucionadoParte FROM parte INNER JOIN sistema ON parte.sistema_id = sistema.id INNER JOIN seccion ON sistema.seccion_id = seccion.id ORDER BY parte.es_solucionado ASC, nombreEstacion ASC, nombreSistema ASC, fechaParte DESC";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}		
	}


	public function buscarPartesCae($idCae){
		$sql = "SELECT parte.id AS idParte, estacion.nombre AS nombreEstacion, sistema.nombre AS nombreSistema, parte.fecha AS fechaParte, parte.novedad AS novedadParte, parte.es_solucionado AS esSolucionadoParte FROM parte INNER JOIN sistema ON parte.sistema_id = sistema.id INNER JOIN seccion ON sistema.seccion_id = seccion.id INNER JOIN estacion ON seccion.estacion_id = estacion.id WHERE estacion.cae_id= ".$idCae." ORDER BY parte.es_solucionado ASC, nombreEstacion ASC, nombreSistema ASC, fechaParte DESC";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}		
	}





	public function buscarRegistroPorID($idParte){
		$sql = "SELECT parte.id AS idParte, parte.novedad AS novedadParte, parte.seguimiento AS seguimientoParte, parte.requerimiento_solucion AS requerimientoSolucionParte, parte.es_solucionado AS esSolucionadoParte, parte.horas_fuera_servicio_dia AS horasFueraServicioDiaParte FROM parte WHERE parte.id=".$idParte;
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function eliminarRegistro($idParte){
		$this->db->where('id', $idParte);
		$this->db->delete('parte');
		return $this->db->affected_rows();
	}

	public function buscarExistenciaFechaParte($idTipoExistencia, $fechaParte){
		$sql = "SELECT parte.id AS idParte FROM parte WHERE parte.tipo_existencia_id = ".$idTipoExistencia." AND parte.fecha = '".$fechaParte."' GROUP BY parte.id";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function buscarParteDiario($idCae, $fechaParte){
		$sql = "SELECT parte.id AS idParte, parte.fecha AS fechaParte, cae.nombre AS nombreCae, sistema.nombre AS nombreSistema, estacion.nominativo AS nominativoEstacion, estacion.nombre AS nombreEstacion, tipo_existencia.nombre AS nombreTipoExistencia, tipo_existencia.propiedad AS propiedadTipoExistencia, parte.novedad AS novedadParte, parte.seguimiento AS seguimientoParte, parte.requerimiento_solucion AS requerimientoSolucionParte, parte.es_solucionado AS esSolucionadoParte FROM parte INNER JOIN tipo_existencia ON parte.tipo_existencia_id = tipo_existencia.id INNER JOIN estacion ON tipo_existencia.estacion_id = estacion.id INNER JOIN cae ON estacion.cae_id = cae.id INNER JOIN sistema ON tipo_existencia.sistema_id = sistema.id INNER JOIN seccion ON sistema.seccion_id = seccion.id WHERE cae.id = ".$idCae." AND parte.fecha = '".$fechaParte."' ORDER BY nombreCae ASC, nombreSistema ASC, nombreEstacion ASC, nombreTipoExistencia ASC";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}
	}

	public function buscarCabeceraParte($idParte){
		$sql = "SELECT cae.nombre AS nombreCae, estacion.nombre AS nombreEstacion, sistema.nombre AS nombreSistema, tipo_existencia.nombre AS nombreTipoExistencia FROM cae INNER JOIN estacion ON estacion.cae_id = cae.id INNER JOIN tipo_existencia ON tipo_existencia.estacion_id = estacion.id INNER JOIN sistema ON tipo_existencia.sistema_id = sistema.id INNER JOIN parte ON parte.tipo_existencia_id = tipo_existencia.id WHERE parte.id = ".$idParte;
		
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}
*/
}