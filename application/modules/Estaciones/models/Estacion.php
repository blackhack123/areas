<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Estacion extends CI_Model{
	public function buscarEstacionesCae($idCae){
		$sql = "SELECT estacion.id AS idEstacion, estacion.nominativo AS nominativoEstacion, estacion.nombre AS nombreEstacion, estacion.direccion AS direccionEstacion, estacion.telefono_fijo AS telefonoFijoEstacion, estacion.telefono_movil AS telefonoMovilEstacion FROM estacion WHERE estacion.cae_id = ".$idCae." ORDER BY nombreEstacion ASC";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}		
	}

	public function insertarRegistro($data){
		$this->db->insert("estacion", $data);
		return $this->db->insert_id();
	}

	public function editarRegistro($idEstacion, $data){
		$this->db->where("id", $idEstacion);
		$this->db->update("estacion", $data);
		return $this->db->affected_rows();
	}

	public function buscarRegistroPorID($idEstacion){
		$sql = "SELECT estacion.id AS idEstacion, estacion.cae_id, estacion.nominativo AS nominativoEstacion, estacion.nombre AS nombreEstacion, estacion.direccion AS direccionEstacion, estacion.telefono_fijo AS telefonoFijoEstacion, estacion.telefono_movil AS telefonoMovilEstacion FROM estacion WHERE estacion.id = ".$idEstacion;
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function eliminarRegistro($idEstacion){
		$this->db->where('id', $idEstacion);
		$this->db->delete('estacion');
		return $this->db->affected_rows();
	}

}	