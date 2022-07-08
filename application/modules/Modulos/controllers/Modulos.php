<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Modulos extends MX_Controller {
	/**
	 * Módulos
	 */
	public function __construct(){
		parent:: __construct();

		$this->load->model('Personales/Personal');
		$this->load->model('Usuarios/Usuario');
	}

	public function escritorio(){
		$data['titulo'] = "Escritorio";
		$data['view'] = "Modulos/escritorio";
		$data['codigoCategoriaMenu'] = "escritorio";
		$data['output'] = "";
		$this->load->view('Modulos/main', $data);
	}

}	