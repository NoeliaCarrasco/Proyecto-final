<?php
include_once("./db_configuration.php");
	session_start();
	if(!isset($_SESSION['rol'])){header('location: login.php');}else{if(intval($_SESSION['rol']) != 2){header('location: index.php');}}
	if(isset($_REQUEST['id'])){
		$connection = new mysqli($db_host, $db_user, $db_password, "deportes");
		$tipo = 'Indefinido';
		switch(intval($_REQUEST['admin'])){
			case 1:
				$tipo = 'Cliente';
				break;
			case 2:
				$tipo = 'Administrador';
				break;
		}
		
		$update="UPDATE usuarios SET NOMBRE = '".$_REQUEST['nombre']."', APELLIDO='".$_REQUEST['apellido']."', PASSWORD=md5('".$_REQUEST['password']."'), USUARIO='".$_REQUEST['usuario']."', ROL='".intval($_REQUEST['admin'])."', TIPO='".$tipo."' WHERE IDUSUARIO = '".$_REQUEST['id']."'";
		$connection->query($update);
	}
	header('location: administrarUsuarios.php');
?>
