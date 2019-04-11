<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');

	class CategoriaMenu extends CI_Model{


		public function buscarCategoriaMenu(){
			$sql = "SELECT categoria_menu.id AS idCategoriaMenu, categoria_menu.codigo, categoria_menu.nombre, categoria_menu.icono FROM categoria_menu ORDER BY categoria_menu.nombre";
			$result = $this->db->query($sql);

			if($result->num_rows()>0){
				return $result->result();
			}
			else{
				return false;
			}
		}

		public function insertarCategoriaMenu($data){
			$this->db->insert('categoria_menu', $data);
			return $this->db->insert_id();			
		}

		public function editarCategoriaMenu($idCategoriaMenu, $data){
			$this->db->where('id', $idCategoriaMenu);
			$this->db->update('categoria_menu', $data);
			return $this->db->affected_rows();			
		}

		public function eliminarCategoriaMenu($idCategoriaMenu){
			$this->db->where('id', $idCategoriaMenu);
			$this->db->delete('categoria_menu');
			return $this->db->affected_rows();			
		}

		public function buscarCategoriaMenuPorID($idCategoriaMenu){
			$sql = "SELECT categoria_menu.id AS idCategoriaMenu, categoria_menu.codigo AS codigoCategoriaMenu, categoria_menu.nombre AS nombreCategoriaMenu, categoria_menu.icono AS iconoCategoriaMenu FROM categoria_menu WHERE id=".$idCategoriaMenu;
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