<?php $esSuperadmin = $this->session->userdata("esSuperadmin"); ?>
<?php $idUsuario = $this->session->userdata("idUsuario"); ?>
<?php echo $this->dynamic_menu->build_menu($idUsuario, $esSuperadmin); ?>