<?php
include_once("./db_configuration.php");
	session_start();
	if(!isset($_SESSION['rol'])){header('location: login.php');}else{if(intval($_SESSION['rol']) != 2){header('location: index.php');}}
	if(isset($_REQUEST['nombre'])){
		$connection = new mysqli($db_host, $db_user, $db_password, "deportes");
		$insert="INSERT INTO categorias VALUES(NULL, '".$_REQUEST['nombre']."')";
		$connection->query($insert);
	}
	header('location: administrarCategorias.php');
?>
