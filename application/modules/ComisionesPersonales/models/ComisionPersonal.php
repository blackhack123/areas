<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ComisionPersonal extends CI_Model{

	public function insertarRegistro($data){
		return $this->db->insert("comision_personal", $data);
	}

	public function buscarPersonalComision($idComision){
		$sql = "SELECT comision_personal.personal_id as idPersonal FROM comision_personal WHERE comision_personal.comision_id = ".$idComision;
		
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}
	}

	public function agregarPersonalAComision($data){
		return $this->db->insert("comision_personal", $data);
	}

	public function eliminarPersonalDeComision($idComision, $idPersonal){
		$this->db->where("comision_id", $idComision);
		$this->db->where("personal_id", $idPersonal);
		return $this->db->delete("comision_personal");
	}

}