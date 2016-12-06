<?php
include_once("./db_configuration.php");
	session_start();
	if(!isset($_SESSION['rol'])){header('location: login.php');}else{if(intval($_SESSION['rol']) != 2){header('location: index.php');}}
	if(isset($_REQUEST['i'])){
		$connection = new mysqli($db_host, $db_user, $db_password, "deportes");
		
		$delete="DELETE FROM productos WHERE IDPRODUCTO = '".$_REQUEST['i']."'";//creamos dentro de la variable delete la consulta que vamos a realizar cogiendo la id que nos viene por la url del producto
		$connection->query($delete);
	}
	header('location: administrarProductos.php');
?>
