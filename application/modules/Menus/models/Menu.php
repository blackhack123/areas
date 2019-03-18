<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');

	class Menu extends CI_Model{

		public function insertarMenu($data){
			$this->db->insert('menu', $data);
			return $this->db->insert_id();			
		}

		public function editarMenu($idMenu, $data){
			$this->db->where('id', $idMenu);
			$this->db->update('menu', $data);
			return $this->db->affected_rows();			
		}

		public function eliminarMenu($idMenu){
			$this->db->where('id', $idMenu);
			$this->db->delete('menu');
			return $this->db->affected_rows();			
		}


		public function buscarMenuPorID($idMenu){
			$sql = "SELECT menu.id as idMenu, menu.categoria_menu_id AS idCategoriaMenu, menu.codigo AS codigoMenu, menu.nombre AS nombreMenu, menu.ruta as rutaMenu, menu.icono as iconoMenu, categoria_menu.codigo as codigoCategoriaMenu FROM  menu, categoria_menu WHERE categoria_menu.id = menu.categoria_menu_id AND menu.id = ".$idMenu;
			$result = $this->db->query($sql);
			if($result->num_rows() > 0){
				return $result->row();
			}
			else{
				return false;
			}
		}

		public function buscarMenuPorCategoria($idCategoriaMenu){
			$sql = "SELECT menu.id AS idMenu, menu.codigo AS codigoMenu, menu.nombre AS nombreMenu FROM categoria_menu INNER JOIN menu ON menu.categoria_menu_id = categoria_menu.id WHERE menu.categoria_menu_id = ".$idCategoriaMenu." ORDER BY menu.nombre";
			$result = $this->db->query($sql);
			if($result->num_rows() > 0){
				return $result->result();
			}
			else{
				return false;
			}
		}

		public function buscarMenus(){
			$sql = "SELECT menu.id as idMenu, categoria_menu.nombre as nombreCategoria, menu.nombre as nombreMenu, menu.ruta as rutaMenu, menu.icono as iconoMenu FROM categoria_menu INNER JOIN menu ON menu.categoria_menu_id = categoria_menu.id ORDER BY categoria_menu.nombre, menu.nombre" ;

			$result = $this->db->query($sql);
			if($result->num_rows() > 0){
				return $result->result();
			}
			else{
				return false;
			}
		}

	}
?>