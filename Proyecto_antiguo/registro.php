<?php
 include_once("./db_configuration.php");
	session_start();
	if(isset($_REQUEST['nombre'])&&isset($_REQUEST['apellido'])){
		$connection = new mysqli($db_host, $db_user, $db_password, "deportes");
		
		$insert="INSERT INTO usuarios VALUES(NULL, '".$_REQUEST['nombre']."', '".$_REQUEST['apellido']."', '1', 'Cliente', '".$_REQUEST['usuario']."', '".md5($_REQUEST['password'])."')";//inserto un nuevo cliente con las variables nombre, apellido, rol: 1, tipo: cliente, usuario y contraseña con md5 para que este encriptada, que se cogera de un formulario de registro y se guardan en la base de datos
		$connection->query($insert);//iniciamos la query 
	}
	header('location: login.php');
?>
