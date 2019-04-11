<?php 
	$this->load->view("Modulos/_partials/_header");
	$this->load->view("Modulos/_partials/_menu");
	$this->load->view($view, $output);
	$this->load->view("Modulos/_partials/_footer");
?>