<?php
	session_start();
	if(!isset($_SESSION['rol'])){header('location: login.php');}
	if(!isset($_SESSION['carrito'])){ $_SESSION['carrito'] = [];}
	if(isset($_SESSION['carrito'][$_REQUEST['i']])){
		unset($_SESSION['carrito'][$_REQUEST['i']]);//destruye el produto con el código que guarda la clave 'i' del array REQUEST almacenada en SESSION
	}
	header('location: shopping-cart.php');
?>
