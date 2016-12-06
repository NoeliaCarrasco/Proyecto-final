<?php
include_once("./db_configuration.php");
	session_start();
	if(!isset($_SESSION['rol'])){header('location: login.php');}else{if(intval($_SESSION['rol']) != 2){header('location: index.php');}}
	if(isset($_REQUEST['nombre'])&&isset($_REQUEST['categoria'])){
		$connection = new mysqli($db_host, $db_user, $db_password, "deportes");
		
		$insert="INSERT INTO productos VALUES(NULL, '".$_REQUEST['nombre']."', '".$_REQUEST['precio']."', '".intval($_REQUEST['stock'])."', '".$_FILES['fileToUpload']['name']."', '".$_REQUEST['categoria']."', '".$_REQUEST['descripcion']."')";//creamos dentro de la variable insert la consulta para insertar nuevos productos insertandome como parametros el nombre, precio, stock convertido a entero, el nombre del fichero que acabo de subir, categoria y descripcion
		
		$connection->query($insert);
					
	$target_dir = getcwd()."\\imagenes\\";//getcwd nos devuelve el directorio donde está alojada la aplicación web y luego cogemos el fichero imagenes
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);//en la variable target_file mostramos todo lo guardado en la variable target_dir y luego cogemos el nombre basico del fichero subido
	$uploadOk = 1;//si la subida es correcta es igual a 1
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);//cogemos la ruta del fichero que estemos subiendo
	
	if(isset($_REQUEST["submit"])) {//si esta establecida la clave submit dentro del array request entonces
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);//coge el nombre temporal del fichero y muestra el tamaño de este
		if($check !== false) {//si la variable check es distinta de false entonces
			
			$uploadOk = 1;// la subida es igual a 1, por lo que es correcta
		} else {//sino
			
			$uploadOk = 0;//la subida es igual a 0, por lo que no se ha realizado
		}
	}
	
	if (file_exists($target_file)) {//si existe el fichero con la ruta almacenada en target_file entonces
		$uploadOk = 0;//la subida es igual a 0
	}
	
	if ($_FILES["fileToUpload"]["size"] > 500000) {//si el tamaño del fichero es mayor de 500000
		$uploadOk = 0;//la subida es igual a 0
	}
	
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {//si el tipo de imagen es distinto de jpg, png, jpeg, gif
		$uploadOk = 0;//la subida es cero
	}
	
	if ($uploadOk == 0) {//si la subida es igual a 0 
        //redirige a esa parte del if
	} else {//sino
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file));//mueve el fichero que esta en la ruta con nombre temporal a  la ruta de la variable target_file
	}
				
	}
	header('location: administrarProductos.php');
?>
