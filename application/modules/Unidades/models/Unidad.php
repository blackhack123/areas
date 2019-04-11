<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Unidad extends CI_Model{

	public function insertarRegistro($data){
		$this->db->insert('unidad', $data);
		return $this->db->insert_id();			
	}

	public function editarRegistro($idUnidad, $data){
		$this->db->where('id', $idUnidad);
		$this->db->update('unidad', $data);
		return $this->db->affected_rows();			
	}

	public function buscarRegistroPorID($idUnidad){
		$sql = "SELECT unidad.id AS idUnidad, unidad.nombre_comando AS nombreComandoUnidad, unidad.nombre AS nombreUnidad, unidad.abreviatura AS abreviaturaUnidad, unidad.logo AS logoUnidad, unidad.direccion AS direccionUnidad, unidad.telefono_fijo AS telefonoFijoUnidad, unidad.telefono_movil AS telefonoMovilUnidad, unidad.email AS emailUnidad FROM unidad WHERE unidad.id = ".$idUnidad;
		
		$resultado = $this->db->query($sql);
		
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

}