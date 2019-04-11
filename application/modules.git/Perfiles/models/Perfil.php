<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Perfil extends CI_Model{

		public function insertarPerfil($data){
			$this->db->insert('perfil', $data);
			return $this->db->insert_id();	
		}

		public function editarPerfil($idPerfil, $data){
			$this->db->where('id', $idPerfil);
			$this->db->update('perfil', $data);
			return $this->db->affected_rows();	
		}

		public function eliminarPerfil($idPerfil){
			$this->db->where('id', $idPerfil);
			$this->db->delete('perfil');
			return $this->db->affected_rows();			
		}

		public function buscarPerfilPorID($idPerfil){
			$this->db->select('id AS idPerfil');
			$this->db->select('nombre AS nombrePerfil');
			$this->db->select('skin AS skinPerfil');
			$this->db->where('id', $idPerfil);
			
			$result = $this->db->get('perfil');

			if($result->num_rows() > 0){
				return $result->row();
			}
			else{
				return false;
			}			
		}

		public function buscarPerfiles(){
			$sql = "SELECT id as idPerfil, nombre as nombrePerfil, skin as skinPerfil FROM perfil ORDER BY nombre";
			
			$result = $this->db->query($sql);
			
			if($result->num_rows()>0){
				return $result->result();
			}
			else{
				return false;
			}
		}


	}
?>