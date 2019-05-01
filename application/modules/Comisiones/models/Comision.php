<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comision extends CI_Model{

	public function insertarRegistro($data){
		$this->db->insert("comision", $data);
		return $this->db->insert_id();
	}

	public function editarRegistro($idComision, $data){
		$this->db->where("id", $idComision);
		$this->db->update("comision", $data);
		return $this->db->affected_rows();
	}

	public function buscarRegistroPorID($idComision){
		$sql = "SELECT comision.id AS idComision, comision.fecha_inicio AS fechaInicioComision, comision.fecha_fin AS fechaFinComision, comision.tipo_mantenimiento_id AS idTipoMantenimiento, comision.situacion_previa AS situacionPreviaComision, comision.actividad_planificada AS actividadPlanificadaComision, comision.estado AS estadoComision FROM comision WHERE comision.id = ".$idComision;
		
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function eliminarRegistro($idComision){
		$this->db->where('id', $idComision);
		$this->db->delete('comision');
		return $this->db->affected_rows();
	}

	public function buscarComisionesParte($idParte){
		$sql = "SELECT comision.id AS idComision, comision.fecha_inicio AS fechaInicioComision, comision.fecha_fin AS fechaFinComision, (SELECT tipo_mantenimiento.nombre FROM tipo_mantenimiento WHERE tipo_mantenimiento.id=comision.tipo_mantenimiento_id) AS tipoMantenimiento, comision.situacion_previa AS situacionPreviaComision, comision.actividad_planificada AS actividadPlanificadaComision, (SELECT Count(*) FROM comision_personal WHERE comision_personal.comision_id = comision.id) AS totalPersonal FROM comision WHERE comision.parte_id = ".$idParte." ORDER BY fechaInicioComision ASC";
		
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}
	}

	public function buscarComisionesPendientes(){
		$sql = "SELECT comision.id AS idComision, cae.nombre AS nombreCae, estacion.nombre AS nombreEstacion, tipo_existencia.nombre AS nombreTipoExistencia, comision.fecha_creacion as fechaCreacionComision, comision.fecha_inicio AS fechaInicioComision, comision.fecha_fin AS fechaFinComision FROM cae INNER JOIN estacion ON estacion.cae_id = cae.id INNER JOIN tipo_existencia ON tipo_existencia.estacion_id = estacion.id INNER JOIN parte ON parte.tipo_existencia_id = tipo_existencia.id INNER JOIN comision ON comision.parte_id = parte.id WHERE comision.estado = 'P' ORDER BY nombreCae ASC, nombreEstacion ASC, nombreTipoExistencia ASC, fechaInicioComision DESC";
		
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}		
	}
}	