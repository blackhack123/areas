<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Personal extends CI_Model{
	
	public function buscarPersonal(){
		$sql = "SELECT personal.id AS idPersonal, fuerza.nombre AS nombreFuerza, grado.abreviatura AS abreviaturaGrado, personal.apellido AS apellidoPersonal, personal.nombre as nombrePersonal, personal.numero_identificacion AS numeroIdentificacionPersonal FROM personal INNER JOIN fuerza ON personal.fuerza_id = fuerza.id INNER JOIN grado ON grado.fuerza_id = fuerza.id AND personal.grado_id = grado.id ORDER BY nombreFuerza ASC, grado.orden ASC";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}
	}

	public function buscarPersonalFuerza($idTipoFuerza){
		$sql = "SELECT personal.id AS idPersonal, fuerza.nombre AS nombreFuerza, grado.abreviatura AS abreviaturaGrado, personal.apellido AS apellidoPersonal, personal.nombre AS nombrePersonal, personal.numero_identificacion AS numeroIdentificacionPersonal FROM personal INNER JOIN fuerza ON personal.fuerza_id = fuerza.id INNER JOIN grado ON grado.fuerza_id = fuerza.id AND personal.grado_id = grado.id WHERE fuerza.tipo_fuerza_id = ".$idTipoFuerza." ORDER BY fuerza.orden ASC, grado.orden ASC";
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}
	}

	public function insertarRegistro($data){
		$this->db->insert("personal", $data);
		return $this->db->insert_id();
	}

	public function editarRegistro($idPersonal, $data){
		$this->db->where("id", $idPersonal);
		$this->db->update("personal", $data);
		return $this->db->affected_rows();
	}


	public function eliminarRegistro($idPersonal){
		$this->db->where('id', $idPersonal);
		$this->db->delete('personal');
		return $this->db->affected_rows();
	}

	public function buscarRegistroPorID($idPersonal){
		$sql = "SELECT personal.id AS idPersonal, fuerza.nombre AS nombreFuerza, grado.abreviatura AS abreviaturaGrado, personal.apellido AS apellidoPersonal, personal.nombre AS nombrePersonal, personal.numero_identificacion AS numeroIdentificacionPersonal, personal.fuerza_id AS idFuerza, personal.grado_id AS idGrado, personal.estado_civil_id AS idEstadoCivil, personal.tipo_identificacion AS tipoIdentificacionPersonal, personal.fecha_nacimiento AS fechaNacimientoPersonal, personal.telefono_fijo AS telefonoFijoPersonal, personal.telefono_movil AS telefonoMovilPersonal, personal.email AS emailPersonal, personal.tipo_sangre AS tipoSangrePersonal, personal.foto AS fotoPersonal, personal.direccion as direccionPersonal, personal.funcion_id as idFuncion, personal.sexo as sexoPersonal, personal.arma_id AS idArma FROM personal INNER JOIN fuerza ON personal.fuerza_id = fuerza.id INNER JOIN grado ON grado.fuerza_id = fuerza.id AND personal.grado_id = grado.id WHERE personal.id = ".$idPersonal;
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->row();
		}
		else{
			return false;
		}
	}

	public function buscarPersonalCae($idCae){
		$sql = "SELECT personal.id AS idPersonal, CONCAT(grado.abreviatura,' ',personal.apellido,' ',personal.nombre) AS datoPersonal FROM grado INNER JOIN personal ON personal.grado_id = grado.id INNER JOIN pase ON pase.personal_id = personal.id WHERE pase.cae_id = ".$idCae." AND pase.estado = 'A' ORDER BY grado.orden ASC";
		
		$resultado = $this->db->query($sql);
		if($resultado->num_rows() > 0){
			return $resultado->result();
		}
		else{
			return false;
		}		
	}

}