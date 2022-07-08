<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Modlelo para manejo de Usuarios
 */

class Usuario extends CI_Model{
	
	public function verificarUsuarioPorEmail($emailUsuario){
		$sql = "SELECT usuario.id AS idUsuario, personal.id AS idPersonal, personal.apellido AS apellidoUsuario, personal.nombre AS nombreUsuario, personal.email AS emailUsuario, usuario.clave as claveUsuario, usuario.es_superadmin as esSuperadminUsuario FROM usuario INNER JOIN personal ON usuario.personal_id = personal.id WHERE usuario.estado = 'A' AND usuario.email = '".$emailUsuario."'";
		
		$resultado = $this->db->query($sql);

		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function verificarUsuarioPorUsuario($emailUsuario){
		$sql = "SELECT usuario.id AS idUsuario, personal.id AS idPersonal, 
				personal.apellido AS apellidoUsuario, personal.nombre AS nombreUsuario, 
				personal.email AS emailUsuario, usuario.clave as claveUsuario, 
				usuario.es_superadmin as esSuperadminUsuario,
				usuario_perfil.perfil_id
				FROM usuario 
				INNER JOIN personal ON usuario.personal_id = personal.id 
				INNER JOIN usuario_perfil ON usuario.id = usuario_perfil.usuario_id
				WHERE usuario.estado = 'A' AND usuario.usuario = '".$emailUsuario."'";
		
		$resultado = $this->db->query($sql);

		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function buscarUsuarioPorPersonalID($idPersonal){
		$sql = "SELECT usuario.id AS idUsuario, usuario.personal_id AS idPersonal, usuario.es_superadmin AS esSuperadminUsuario, usuario.usuario AS usuarioUsuario, usuario.clave AS claveUsuario, usuario.email AS emailUsuario, usuario.estado AS estadoUsuario FROM usuario WHERE usuario.personal_id = ".$idPersonal." GROUP BY usuario.id";
		
		$resultado = $this->db->query($sql);

		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function insertarRegistro($data){
		$this->db->insert('usuario', $data);
		return $this->db->insert_id();			
	}

	public function editarRegistro($idUsuario, $data){
		$this->db->where('id', $idUsuario);
		$this->db->update('usuario', $data);
		return $this->db->affected_rows();			
	}

	public function eliminarRegistro($idUsuario){
		$this->db->where('id', $idUsuario);
		return $this->db->delete('usuario');
	}

	public function buscarPerfilesDelUsuario($idUsuario){
		$sql = "SELECT perfil_id as idPerfil FROM usuario_perfil WHERE usuario_id=".$idUsuario;
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