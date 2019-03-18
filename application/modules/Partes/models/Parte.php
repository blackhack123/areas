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
}