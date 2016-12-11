<?php
include_once("./db_configuration.php");
	session_start();
	if(!isset($_SESSION['rol'])){header('location: login.php');}else{if(intval($_SESSION['rol']) != 2){header('location: index.php');}}
	if(isset($_REQUEST['id'])){
		$connection = new mysqli($db_host, $db_user, $db_password, $database);
		
		if($_FILES['fileToUpload']['name'] != ''){$fichero = ", FOTO='".$_FILES['fileToUpload']['name']."'";}else{ $fichero = "";}//si el nombre del fichero es distinto de vacio entonces dentro de la variable fichero guardamos el campo foto siendo igual al nombre del fichero subido sino la variable fichero esta vacia y no mostrara nada
		$update="UPDATE productos SET NOMBRE = '".$_REQUEST['nombre']."', PRECIO='".floatval($_REQUEST['precio'])."'".$fichero.", STOCK='".intval($_REQUEST['stock'])."', IDCATEGORIA='".$_REQUEST['categoria']."', DESCRIPCION='".$_REQUEST['descripcion']."' WHERE IDPRODUCTO = '".$_REQUEST['id']."'";//creamos dentro de la variable update la consulta para actualizar un producto insertando cada campo de la tabla producto y su valor, nombre = valor, precio = valor cnvertido en un valor float 'decimal', la variable fichero concatena o nada o foto igual a una ruta ( foto = yjdsyf.jpeg), stock = valor convertido en entero, idcategoria = valor, descripcion = valor cuando el idproducto es igual a la clave id de la variable request
		$connection->query($update);
        
			
		if($_FILES['fileToUpload']['name'] != ''){// si el nombre del fichero es distinto de vacio
			$target_dir = getcwd()."\\imagenes\\";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
				$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				if($check !== false) {
					//echo "File is an image - " . $check["mime"] . ".";
					$uploadOk = 1;
				} else {
					//echo "File is not an image.";
					$uploadOk = 0;
				}
			}
			// Check if file already exists
			if (file_exists($target_file)) {
			//	echo "Sorry, file already exists.";
				$uploadOk = 0;
			}
			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 500000) {
				//echo "Sorry, your file is too large.";
				$uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				//echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				//echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				//	echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				} else {
					//echo "Sorry, there was an error uploading your file.";
				}
			}		
		}					
	}
		
	header('location: administrarProductos.php');
?>
