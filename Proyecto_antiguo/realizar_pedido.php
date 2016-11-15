<?php
include_once("./db_configuration.php");
	session_start();
	if(!isset($_SESSION['rol'])){header('location: login.php');}
	$id_usuario = '';
	if(isset($_SESSION['carrito'])){
		$connection = new mysqli($db_host, $db_user, $db_password, "deportes");
		$fechaPedido = getdate();//con getdate obtenemos la informacion de la fecha y hora
		$fechaPedido = $fechaPedido['year']."-".$fechaPedido['mon']."-".$fechaPedido['mday'];//la variable fechapedido contiene la fecha en ese formato
		if (isset($_SESSION['IDUSUARIO']) && $_SESSION['IDUSUARIO'] != '') {
			$result = $connection->query("SELECT IDUSUARIO FROM usuarios WHERE USUARIO='".$_SESSION['IDUSUARIO']."'");//guardamos el resultado de la consulta dentro de la variable result
			$fila = $result->fetch_assoc();//dentro de la variable fila guardamos los campos del usuario como un array asociativo 
			$id_usuario = $fila['IDUSUARIO'];//dentro de la variable fila guardamos el array fila que contiene la variable idusuario
			$insert="INSERT INTO pedidos VALUES (NULL, '".$fechaPedido."', '".$id_usuario."')"; //la variable insert va a almacenar la consulta que vamos a realizar cogiendo de la variable fechapedido e idusuario lo que se le pase
            $connection->query($insert);//realizamos la inserción guardada en el insert
		}
		
		
		
		$result=$connection->query("SELECT MAX(IDPEDIDO) AS ID FROM pedidos WHERE IDUSUARIO = '".$id_usuario."' AND FECHA_ALTA = '".$fechaPedido."'");//guardamos el resultado de la consulta dentro de la variable result
        $pedido=$result->fetch_object();//le  asignamos a la variable pedido un objeto de la variable result
		foreach($_SESSION['carrito'] as $codigo => $producto){//recorro con el foreach la variable carrito guardando los datos de los detallespedidos en la variable producto con su codigo
			$insert="INSERT INTO detallespedido VALUES (".$codigo.", ".$pedido->ID.", ".$producto['CANTIDAD'].", ".$producto['PRECIO'].")";//la variable insert va a almacenar la consulta que vamos a realizar cogiendo el codigo, la id del pedido y del producto la cantidad y el precio
            $connection->query($insert);//realizamos la inserción guardada en el insert
			$update="UPDATE productos SET stock = (stock - ".$producto['CANTIDAD'].") WHERE IDPRODUCTO = '".$codigo."'";//la variable update va a almacenar la consulta que vamos a realizar cogiendo el stock que sera el stock del producto menos la cantidad que hemos seleccionado y me dara el stock actual cuando el idproducto es igual al codigo de ese producto que hemos pasado
            $connection->query($update);//realizamos la actualización guardada en el update, actualizar
		}
		unset($_SESSION['carrito']);
	}
	header('location: index.php');
?>

/*

fetch_object : nos devuelve un objeto que tiene una serie de propiedades que se llaman igual que el nombre de las columnas de la tabla

objeto : es cuando a una variable se le da una propiedad, esa propiedad es una colmna de la tabla

fetch_assoc : obtiene una fila como array asociativo

*/

