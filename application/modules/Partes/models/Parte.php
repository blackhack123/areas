<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Parte extends CI_Model{
	public function buscarPartesCompleto(){
		$sql = "SELECT parte.id AS idParte, estacion.nombre AS nombreEstacion, sistema.nombre AS nombreSistema, parte.fecha AS fechaParte, parte.novedad AS novedadParte, parte.es_solucionado AS esSolucionadoParte FROM parte INNER JOIN sistema ON parte.sistema_id = sistema.id INNER JOIN seccion ON sistema.seccion_id = seccion.id INNER JOIN estacion ON seccion.estacion_id = estacion.id ORDER BY parte.es_solucionado ASC, nombreEstacion ASC, nombreSistema ASC, fechaParte DESC";
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

	public function editarRegistro($idParte, $data){
		$this->db->where("id", $idParte);
		$this->db->update("parte", $data);
		return $this->db->affected_rows();
	}

	public function buscarRegistroPorID($idParte){
		$sql = "SELECT parte.id AS idParte, estacion.id AS idEstacion, parte.sistema_id AS idSistema, parte.tipo_existencia_id AS idTipoExistencia, parte.fecha AS fechaParte, parte.novedad AS novedadParte, parte.seguimiento AS seguimientoParte, parte.requerimiento_solucion AS requerimientoSolucionParte, parte.es_solucionado AS esSolucionadoParte FROM parte INNER JOIN sistema ON parte.sistema_id = sistema.id INNER JOIN seccion ON sistema.seccion_id = seccion.id INNER JOIN estacion ON seccion.estacion_id = estacion.id WHERE parte.id=".$idParte;
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

}