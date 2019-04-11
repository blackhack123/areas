<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');

	class UsuarioPerfil extends CI_Model{

		public function agregarPerfilAUsuario($data){
			return $this->db->insert("usuario_perfil", $data);
		}

		public function eliminarPerfilDeUsuario($idUsuario, $idPerfil){
			$this->db->where("usuario_id", $idUsuario);
			$this->db->where("perfil_id", $idPerfil);
			return $this->db->delete("usuario_perfil");
		}
	}
?>