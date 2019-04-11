<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Dynmic_menu.php
 */
class Dynamic_menu {
 
    private $ci;            // para CodeIgniter Super Global Referencias o variables globales
    private $id_menu        = 'id="menu"';
    private $class_menu        = 'class="menu"';
    private $class_parent    = 'class="parent"';
    private $class_last        = 'class="last"';
    // --------------------------------------------------------------------
    /**
     * PHP5        Constructor
     *
     */
    function __construct()
    {
        $this->ci =& get_instance();    // get a reference to CodeIgniter.
    }
    // --------------------------------------------------------------------
     /**
     * build_menu($table, $type)
     *
     * Description:
     *
     * builds the Dynaminc dropdown menu
     * $table allows for passing in a MySQL table name for different menu tables.
     * $type is for the type of menu to display ie; topmenu, mainmenu, sidebar menu
     * or a footer menu.
     *
     * @param    string    the MySQL database table name.
     * @param    string    the type of menu to display.
     * @return    string    $html_out using CodeIgniter achor tags.
     */
 
    function build_menu($idUsuario, $esSuperadmin){
    
     //$menu = array();

     if($esSuperadmin == "S"){
       $query = $this->ci->db->query("select * from categoria_menu order by nombre");
     }
     else{
       $sql = "SELECT categoria_menu.id, categoria_menu.codigo, categoria_menu.nombre, categoria_menu.icono FROM categoria_menu INNER JOIN menu ON menu.categoria_menu_id = categoria_menu.id INNER JOIN perfil_menu ON perfil_menu.menu_id = menu.id INNER JOIN perfil ON perfil_menu.perfil_id = perfil.id INNER JOIN usuario_perfil ON usuario_perfil.perfil_id = perfil.id WHERE usuario_perfil.usuario_id = ".$idUsuario." GROUP BY categoria_menu.id ORDER BY categoria_menu.nombre ASC";
       $query = $this->ci->db->query($sql);
       //echo $sql;
       //print_r($query);
     }

     $base_url = base_url();
 
        // now we will build the dynamic menus.

      $html_out  = '<div class="col-lg order-lg-first">';
      $html_out .= '<ul class="nav nav-tabs border-0 flex-column flex-lg-row">';
      $html_out .= '<li class="nav-item">';
      $html_out .= '<a href="'.base_url('Modulos/escritorio').'" class="nav-link" id="escritorio">';
      $html_out .= '<i class="fas fa-home"></i> Inicio</a>';
      $html_out .= '</li>';


    foreach ($query->result() as $data){

      $id = $data->id;
      $codigo = $data->codigo;
      $nombre = $data->nombre;
      $icono = $data->icono;

      $html_out .= '<li class="nav-item dropdown">';
      $html_out .= '<a href="javascript:void(0)" class="nav-link" data-toggle="dropdown" id="'.$codigo.'">'.$icono.' '.$nombre.'</a>';
      $html_out .= '<div class="dropdown-menu dropdown-menu-arrow">';

      //$id = 1;
      $html_out .= $this->get_childs($id, $idUsuario, $esSuperadmin);
      
      $html_out .= '</div>';
      $html_out .= '</li>';  
    }

      $html_out.='<li class="nav-item">';
      $html_out.='<a href="'.base_url('Login/logout').'" class="nav-link"><i class="fe fe-log-out"></i>Salir</a>';
      $html_out.='</li>';
      $html_out.='</ul>';
      $html_out.='</div>';
      $html_out.='</div>';
      $html_out.='</div>';
      $html_out.='</div>';


        return $html_out;
    }
     /**
     * get_childs($menu, $parent_id) - SEE Above Method.
     *
     * Description:
     *
     * Builds all child submenus using a recurse method call.
     *
     * @param    mixed    $id
     * @param    string    $id usuario
     * @return    mixed    $html_out if has subcats else FALSE
     */
    function get_childs($id, $idUsuario, $esSuperadmin){

      if($esSuperadmin == "S"){
        $query = $this->ci->db->query("select * from menu where categoria_menu_id=".$id." order by nombre");
      }
      else{
        $sql = "SELECT menu.id, menu.categoria_menu_id, menu.codigo, menu.nombre, menu.ruta, menu.icono FROM menu INNER JOIN perfil_menu ON perfil_menu.menu_id = menu.id INNER JOIN perfil ON perfil_menu.perfil_id = perfil.id INNER JOIN usuario_perfil ON usuario_perfil.perfil_id = perfil.id WHERE usuario_perfil.usuario_id = ".$idUsuario." AND categoria_menu_id=".$id." GROUP BY menu.id ORDER BY menu.nombre ASC";
          $query = $this->ci->db->query($sql);
      }

      $html_out = "";

    foreach ($query->result() as $data){

      $codigo = $data->codigo;
      $nombre = $data->nombre;
      $ruta = $data->ruta.'/'.encriptar($data->id);
      $icono = $data->icono;

      $html_out .= '<a href="'.base_url($ruta).'" class="dropdown-item " id="'.$codigo.'">'.$icono.' '.$nombre.'</a>';

     }

     return $html_out;
    }
}
 
  function encriptar($string){
    $key = "MICLAVE_123456789";
                              $result = '';
                               for($i=0; $i<strlen($string); $i++) {
                                      $char = substr($string, $i, 1);
                                      $keychar = substr($key, ($i % strlen($key))-1, 1);
                                      $char = chr(ord($char)+ord($keychar));
                                      $result.=$char;
                               }
 
                               $result=base64_encode($result);
                               $result = str_replace(array('+','/','='),array('-','_','.'),$result);
                               return $result;
   
  }
   
  function desencriptar($string){
    $key = "MICLAVE_123456789"; 
                                      $string = str_replace(array('-','_','.'),array('+','/','='),$string);
                                       $result = '';
                                       $string = base64_decode($string);
                                       for($i=0; $i<strlen($string); $i++) {
                                              $char = substr($string, $i, 1);
                                              $keychar = substr($key, ($i % strlen($key))-1, 1);
                                              $char = chr(ord($char)-ord($keychar));
                                              $result.=$char;
                                       }
                                       return $result;
  }

// ------------------------------------------------------------------------
// End of Dynamic_menu Library Class.
// ------------------------------------------------------------------------
/* End of file Dynamic_menu.php */
/* Location: ../application/libraries/Dynamic_menu.php */

?>