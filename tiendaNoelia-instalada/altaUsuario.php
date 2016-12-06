<?php
include_once("./db_configuration.php");
	session_start();
	if(!isset($_SESSION['rol'])){header('location: login.php');}else{if(intval($_SESSION['rol']) != 2){header('location: index.php');}}
	if(isset($_REQUEST['nombre'])&&isset($_REQUEST['apellido'])&&isset($_REQUEST['admin'])){
		$connection = new mysqli($db_host, $db_user, $db_password, "deportes");
		$tipo = 'Indefinido';
		switch(intval($_REQUEST['admin'])){
			case 1:
				$tipo = 'Cliente';
				break;
			case 2:
				$tipo = 'Administrador';
				break;
		}//para coger una de las dos opciones, le paso un numero por la condicion del switch y elige dependiendo del numero una opcion u otra y break es para saltar sin tener que pasar por el siguiente paso
		
		$insert="INSERT INTO usuarios VALUES(NULL, '".$_REQUEST['nombre']."', '".$_REQUEST['apellido']."', '".intval($_REQUEST['admin'])."', '".$tipo."', '".$_REQUEST['usuario']."', md5('".$_REQUEST['password']."'),1)";
        
		
        if($connection->query($insert)){
           	header('location: administrarUsuarios.php'); 
        }else{
            echo $insert;
            echo $connection->error;
        }
        
	}

?>
