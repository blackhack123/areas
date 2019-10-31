<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');

	class PerfilMenu extends CI_Model{

		public function insertarPerfilMenu($data){
			$this->db->insert('perfil_menu', $data);
			return $this->db->insert_id();			
		}

		public function editarPerfilMenu($idPerfilMenu, $data){
			$this->db->where('id', $idPerfilMenu);
			$this->db->update('perfil_menu', $data);
			return $this->db->affected_rows();			
		}

		public function eliminarPerfilMenu($idPerfilMenu){
			$this->db->where('id', $idPerfilMenu);
			$this->db->delete('perfil_menu');
			return $this->db->affected_rows();			
		}


		public function buscarPerfilMenuPorID($id){
			$sql = "SELECT menu.id as idMenu, menu.categoria_menu_id AS idCategoriaMenu, menu.codigo AS codigoMenu, menu.nombre AS nombreMenu, menu.ruta as rutaMenu, menu.icono as iconoMenu FROM  menu WHERE menu.id = ".$id;
			$result = $this->db->query($sql);
			if($result->num_rows() > 0){
				return $result->row();
			}
			else{
				return false;
			}
		}

		public function buscarPerfilesDeMenu($idMenu){
			$sql = "SELECT menu.id AS idMenu, menu.nombre AS nombreMenu, perfil.id AS idPerfil, perfil.nombre AS nombrePerfil FROM perfil INNER JOIN perfil_menu ON perfil_menu.perfil_id = perfil.id INNER JOIN menu ON perfil_menu.menu_id = menu.id WHERE menu.id = ".$idMenu;
			
			$result = $this->db->query($sql);
			if($result->num_rows() > 0){
				return $result->result();
			}
			else{
				return false;
			}
		}

		public function buscarMenusDePerfil($idPerfil){
			$sql = "SELECT perfil_menu.id as idPerfilMenu, menu.id AS idMenu, categoria_menu.id AS idCategoriaMenu, perfil_menu.perfil_id AS idPerfil, categoria_menu.nombre AS nombreCategoria, menu.nombre AS nombreMenu, perfil_menu.autorizacion, perfil_menu.escritura, perfil_menu.envio, perfil_menu.solucion FROM categoria_menu INNER JOIN menu ON menu.categoria_menu_id = categoria_menu.id INNER JOIN perfil_menu ON perfil_menu.menu_id = menu.id WHERE perfil_menu.perfil_id = ".$idPerfil." ORDER BY categoria_menu.nombre, menu.nombre";

			$result = $this->db->query($sql);
			if($result->num_rows() > 0){
				return $result->result();
			}
			else{
				return false;
			}
		}

		public function buscarMenusDisponiblesParaPerfil($idPerfil){
			$sql = "SELECT menu.id as idMenu, concat(categoria_menu.nombre,' - ', menu.nombre) as nombreMenu FROM menu, categoria_menu WHERE menu.id NOT IN (SELECT perfil_menu.menu_id FROM perfil_menu WHERE perfil_menu.perfil_id = ".$idPerfil." ) AND categoria_menu.id=menu.categoria_menu_id GROUP BY menu.id ORDER BY categoria_menu.nombre, menu.nombre";

			$result = $this->db->query($sql);
			if($result->num_rows() > 0){
				return $result->result();
			}
			else{
				return false;
			}

		}

		public function buscarMenuUsuario($idUsuario, $idMenu){
			$sql = "SELECT perfil_menu.id, perfil_menu.autorizacion, perfil_menu.escritura, perfil_menu.envio, perfil_menu.solucion FROM perfil_menu INNER JOIN perfil ON perfil_menu.perfil_id = perfil.id INNER JOIN usuario_perfil ON usuario_perfil.perfil_id = perfil.id WHERE usuario_perfil.usuario_id = ".$idUsuario." AND perfil_menu.menu_id = ".$idMenu;
			//echo $sql;
			$result = $this->db->query($sql);
			
			if($result->num_rows() > 0){
				return $result->row();
			}
			else{
				return false;
			}
		}

	}
?>