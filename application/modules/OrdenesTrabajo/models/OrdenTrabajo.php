<?php defined('BASEPATH') OR exit('No direct script access allowed');

class OrdenTrabajo extends CI_Model{

    public function consultarOrdenPorIdParte($idParte){
        
        $sql = "SELECT
					orden_trabajo.fec_inicio, orden_trabajo.fec_fin, orden_trabajo.total_dias,
					cae.nombre AS nombreCae, personal.nombre AS nombrePersonal, personal.apellido AS apellidoPersonal,
					sistema.nombre AS sistemaPersonal, sector.nombre AS nombreProvincia, tipo_mantenimiento.nombre AS nombreTipoMantenimiento,
					estacion.nombre AS nombreEstacion, se.nombre AS nombreSistemaEstacion,  orden_trabajo.situacion_previa,
					orden_trabajo.trabajo_a_realizar, orden_trabajo.equipo,orden_trabajo.cantidad_equipo,
					orden_trabajo.herramienta, orden_trabajo.cantidad_herramienta
				FROM orden_trabajo
					INNER JOIN cae ON orden_trabajo.cae_id = cae.id
					INNER JOIN personal ON orden_trabajo.personal_id = personal.id
					INNER JOIN sistema ON orden_trabajo.sistema_id = sistema.id
					INNER JOIN sector ON orden_trabajo.provincia_id = sector.id
					INNER JOIN tipo_mantenimiento ON orden_trabajo.tipo_trabajo_id = tipo_mantenimiento.id
					INNER JOIN estacion ON orden_trabajo.estacion_id = estacion.id
					INNER JOIN sistema se ON orden_trabajo.sistema_estacion_id = se.id
				WHERE orden_trabajo.parte_id = $idParte ";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}else{
			return false;
		}
	}
	
	public function consultarOrdenesTrabajo(){
        
        $sql = "SELECT
					orden_trabajo.fec_inicio, orden_trabajo.fec_fin, orden_trabajo.total_dias,
					cae.nombre AS nombreCae, personal.nombre AS nombrePersonal, personal.apellido AS apellidoPersonal,
					sistema.nombre AS sistemaPersonal, sector.nombre AS nombreProvincia, tipo_mantenimiento.nombre AS nombreTipoMantenimiento,
					estacion.nombre AS nombreEstacion, se.nombre AS nombreSistemaEstacion,  orden_trabajo.situacion_previa,
					orden_trabajo.trabajo_a_realizar, orden_trabajo.equipo,orden_trabajo.cantidad_equipo,
					orden_trabajo.herramienta, orden_trabajo.cantidad_herramienta
				FROM orden_trabajo
					INNER JOIN cae ON orden_trabajo.cae_id = cae.id
					INNER JOIN personal ON orden_trabajo.personal_id = personal.id
					INNER JOIN sistema ON orden_trabajo.sistema_id = sistema.id
					INNER JOIN sector ON orden_trabajo.provincia_id = sector.id
					INNER JOIN tipo_mantenimiento ON orden_trabajo.tipo_trabajo_id = tipo_mantenimiento.id
					INNER JOIN estacion ON orden_trabajo.estacion_id = estacion.id
					INNER JOIN sistema se ON orden_trabajo.sistema_estacion_id = se.id ";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}else{
			return false;
		}
    }

}