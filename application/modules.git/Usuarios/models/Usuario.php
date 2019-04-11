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
		$sql = "SELECT usuario.id AS idUsuario, personal.id AS idPersonal, personal.apellido AS apellidoUsuario, personal.nombre AS nombreUsuario, personal.email AS emailUsuario, usuario.clave as claveUsuario, usuario.es_superadmin as esSuperadminUsuario FROM usuario INNER JOIN personal ON usuario.personal_id = personal.id WHERE usuario.estado = 'A' AND usuario.usuario = '".$emailUsuario."'";
		
		$resultado = $this->db->query($sql);

		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

}

?>