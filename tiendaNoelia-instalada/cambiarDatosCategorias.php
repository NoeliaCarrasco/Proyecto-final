<?php
include_once("./db_configuration.php");
	session_start();
	if(!isset($_SESSION['rol'])){header('location: login.php');}else{if(intval($_SESSION['rol']) != 2){header('location: index.php');}}
	if(isset($_REQUEST['id'])){
		$connection = new mysqli($db_host, $db_user, $db_password, $database);
		
		$update="UPDATE categorias SET NOMBRE = '".$_REQUEST['nombre']."' WHERE IDCATEGORIA = '".$_REQUEST['id']."'";
		$connection->query($update);
	}
	header('location: administrarCategorias.php');
?>
