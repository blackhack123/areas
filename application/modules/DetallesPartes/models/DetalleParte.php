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
		$sql = "SELECT detalle_parte.id AS idDetalleParte, CONCAT(tipo_existencia.nombre,' - ',tipo_existencia.propiedad) AS nombreTipoExistencia, detalle_parte.es_solucionado AS esSolucionadoDetalleParte, detalle_parte.fecha_fallo AS fechaFalloDetalleParte, sector.nombre AS nombreSector FROM detalle_parte INNER JOIN tipo_existencia ON detalle_parte.tipo_existencia_id = tipo_existencia.id INNER JOIN estacion ON tipo_existencia.estacion_id = estacion.id INNER JOIN sector ON estacion.sector_id = sector.id WHERE detalle_parte.parte_id = $idParte ORDER BY sector.nombre, nombreTipoExistencia ASC";
		
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}		
	}

	public function buscarRegistroPorID($idDetalleParte){
		$sql = "SELECT detalle_parte.id AS idDetalleParte, detalle_parte.parte_id AS idParte, detalle_parte.tipo_existencia_id AS idTipoExistencia, detalle_parte.fecha_fallo AS fechaFalloDetalleParte, detalle_parte.novedad AS novedadDetalleParte, detalle_parte.requerimiento_solucion AS requerimientoSolucionDetalleParte, detalle_parte.es_solucionado AS esSolucionadoParte, CONCAT(tipo_existencia.nombre,' - ',tipo_existencia.propiedad) AS nombreTipoExistencia FROM detalle_parte INNER JOIN tipo_existencia ON detalle_parte.tipo_existencia_id = tipo_existencia.id WHERE detalle_parte.id = $idDetalleParte";

		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}



}