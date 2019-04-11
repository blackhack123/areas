<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Arma extends CI_Model{
	public function buscarArmasFuerza($idFuerza){
		$sql = "SELECT arma.id AS idArma, arma.nombre AS nombreArma, arma.abreviatura AS abreviaturaArma FROM arma WHERE arma.fuerza_id = ".$idFuerza." ORDER BY arma.nombre ASC";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}		
	}

	public function buscarArmasTipoFuerza($idTipoFuerza){
		$sql = "SELECT arma.id AS idArma, arma.nombre AS nombreArma, arma.abreviatura AS abreviaturaArma FROM arma INNER JOIN fuerza ON arma.fuerza_id = fuerza.id WHERE fuerza.tipo_fuerza_id = ".$idTipoFuerza." ORDER BY nombreArma ASC";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}			
	}

	public function insertarRegistro($data){
		$this->db->insert("arma", $data);
		return $this->db->insert_id();
	}

	public function editarRegistro($idArma, $data){
		$this->db->where("id", $idArma);
		$this->db->update("arma", $data);
		return $this->db->affected_rows();
	}

	public function buscarRegistroPorID($idArma){
		$sql = "SELECT arma.id AS idArma, arma.fuerza_id as idFuerzaArma, arma.nombre AS nombreArma, arma.abreviatura AS abreviaturaArma FROM arma WHERE arma.id = ".$idArma;
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function eliminarRegistro($idArma){
		$this->db->where('id', $idArma);
		$this->db->delete('arma');
		return $this->db->affected_rows();
	}

}	