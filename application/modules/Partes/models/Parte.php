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
		$sql = "SELECT parte.id AS idParte, parte.cae_id as idCae, parte.numero AS numeroParte, parte.fecha AS fechaParte, parte.tiene_novedad AS tieneNovedadParte FROM parte WHERE parte.id = $idParte";
		
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