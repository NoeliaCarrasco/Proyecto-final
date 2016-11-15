<?php
include_once("./db_configuration.php");
	session_start();//iniciar sesion y si no esta iniciada recuperar la ultima sesion
	if(!isset($_SESSION['rol'])){header('location: login.php');}else{if(intval($_SESSION['rol']) != 2){header('location: index.php');}}
//si no está establecido el campo rol en la sesion dirigeme a login.php; si no, si el valor entero del campo rol en la sesion es distinto de dos dirigeme a index.php
	if(isset($_REQUEST['i'])){
		$connection = new mysqli($db_host, $db_user, $db_password, "deportes");
		$deletes="DELETE FROM detallespedido WHERE IDPEDIDO = '".$_REQUEST['i']."'";
		$connection->query($deletes);
		$delete="DELETE FROM pedidos WHERE IDPEDIDO = '".$_REQUEST['i']."'";
		$connection->query($delete);
	}
	header('location: '.$_SERVER['HTTP_REFERER']);
?>