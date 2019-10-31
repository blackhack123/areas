<?php defined('BASEPATH') OR exit('No direct script access allowed');

class DetalleParte extends CI_Model{
	public function insertarRegistro($data){
		$this->db->insert("detalle_parte", $data);
		return $this->db->insert_id();
	}

	public function editarRegistro($idDetalleParte, $data){
		$this->db->where("id", $idDetalleParte);
		$this->db->update("detalle_parte", $data);
		return $this->db->affected_rows();
	}

	public function eliminarRegistro($idDetalleParte){
		$this->db->where('id', $idDetalleParte);
		$this->db->delete('detalle_parte');
		return $this->db->affected_rows();
	}

	public function buscarDetalleParte($idParte){
		$sql = "SELECT detalle_parte.id AS idDetalleParte, sector.nombre AS nombreSector, estacion.nombre AS nombreEstacion, seccion.nombre AS nombreSeccion, sistema.nombre AS nombreSistema, CONCAT(tipo_existencia.nombre,' - ',tipo_existencia.propiedad) AS nombreTipoExistencia, detalle_parte.es_solucionado AS esSolucionadoDetalleParte, detalle_parte.fecha_fallo AS fechaFalloDetalleParte FROM detalle_parte INNER JOIN tipo_existencia ON detalle_parte.tipo_existencia_id = tipo_existencia.id INNER JOIN estacion ON tipo_existencia.estacion_id = estacion.id INNER JOIN sector ON estacion.sector_id = sector.id INNER JOIN sistema ON tipo_existencia.sistema_id = sistema.id INNER JOIN seccion ON sistema.seccion_id = seccion.id WHERE detalle_parte.parte_id = $idParte ORDER BY nombreSector ASC, nombreTipoExistencia ASC";
		
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}		
	}

	public function buscarRegistroPorID($idDetalleParte){
		$sql = "SELECT detalle_parte.id AS idDetalleParte, detalle_parte.parte_id AS idParte, detalle_parte.tipo_existencia_id AS idTipoExistencia, detalle_parte.fecha_fallo AS fechaFalloDetalleParte, detalle_parte.novedad AS novedadDetalleParte, detalle_parte.requerimiento AS requerimientoDetalleParte, detalle_parte.solucion AS solucionDetalleParte, detalle_parte.es_solucionado AS esSolucionadoDetalleParte, detalle_parte.fecha_solucion AS fechaSolucionDetalleParte, detalle_parte.horas_fuera_servicio AS horasFueraServicioDetalleParte, CONCAT(tipo_existencia.nombre,' - ',tipo_existencia.propiedad) AS nombreTipoExistencia FROM detalle_parte INNER JOIN tipo_existencia ON detalle_parte.tipo_existencia_id = tipo_existencia.id WHERE detalle_parte.id = $idDetalleParte";

		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}



}