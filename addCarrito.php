<?php
	session_start();//si no está creada la sesión, la crea, si la sesión está creada ya, la recupera
	if(!isset($_SESSION['rol'])){header('location: login.php');}//si no esta establecida la clave rol dentro del array session dirigeme al login
    if(!isset($_SESSION['carrito'])){ $_SESSION['carrito'] = [];}//si no existe la clave carrito en el array session creamos la clave carrito en session y le asignamos un array vacio
    if(isset($_SESSION['carrito'][$_REQUEST['IDPRODUCTO']])){//si existe la variable carrito y la variable idproducto
        if(isset($_REQUEST['CANTIDAD']) && $_REQUEST['CANTIDAD'] > 0){ //entonces comprobamos la variable cantidad dentro de request y si cantidad es mayor que 0 entonces
            $_SESSION['carrito'][$_REQUEST['IDPRODUCTO']]['CANTIDAD']+=$_REQUEST['CANTIDAD'];//incrementamos la variable cantidad que esta dentro de idproducto y a su vez de carrito sobre la cantidad ya obtenida
        }else{
            $_SESSION['carrito'][$_REQUEST['IDPRODUCTO']]['CANTIDAD']++;// sino incrementamos en 1 la variable cantidad que esta dentro de idproducto y carrito
        }
	}else{// si eso no se cumple
		$nuevoProducto = [];//declaramos el array nuevoproducto
		$nuevoProducto['NOMBRE'] = $_REQUEST['NOMBRE'];//declaramos la variable nombre dentro de nuevoproducto y le asignamos un valor nombre que esta dentro del array request
		$nuevoProducto['PRECIO'] = $_REQUEST['PRECIO'];
		$nuevoProducto['FOTO'] = $_REQUEST['FOTO'];
		$_SESSION['carrito'][$_REQUEST['IDPRODUCTO']] = $nuevoProducto;//a la variable carrito e idproducto le asignamos el array nuevoproducto
		$_SESSION['carrito'][$_REQUEST['IDPRODUCTO']]['CANTIDAD'] = 0;//a la variable cantidad que esta dentro de idproducto y carrito le asignamos el valor 0
		if(isset($_REQUEST['CANTIDAD']) && $_REQUEST['CANTIDAD'] > 0){ // si existe la variable cantidad y es mayor que 0 entonces
			$_SESSION['carrito'][$_REQUEST['IDPRODUCTO']]['CANTIDAD']+=$_REQUEST['CANTIDAD'];// incrementamos la variable cantidad que esta dentro de isproducto y carrito sobre la cantidad obtenida 
		}else{//sino
			$_SESSION['carrito'][$_REQUEST['IDPRODUCTO']]['CANTIDAD']++;//incrementamos en 1 la variable cantidad que esta dentro de idproducto y carrito
		}
	}
	header('location: '.$_SERVER['HTTP_REFERER']);//una vez añadido el producto al carrito me dirige de nuevo a donde estaba
?>

/*

$_SESSION -> Guarda información en la caché del navegador que perdura aunque se cierre la página, pero no si se cierra el navegador
$_REQUEST -> Guarda información solo en el paso de una página a otra
    $_POST -> ""
    $_GET  -> ""
$_SERVER  -> Mantiene la información previa al haber salido de una página y entrado en otra, como por ejemplo, la última url en la que estuviste


    Declaramos la variable
    $variable;

    Declaramos la variable y le asignamos un valor inicial
    $variable = "";

    Declaramos la variable y le asignamos un array
    Declaramos un array
    $variable = [];

    Cuando creas un objeto de una clase lo que haces es:
    Instanciar la clase
    Crear una instancia de la clase

    Declarar -> variable
    Instanciar -> objetos

    variable | funciones
    atributos o propiedades | métodos

    Producto - 5
    Producto - 'Gorra'
    Producto - 'gorra.jpeg'
    Producto - 15

    $_SESSION{
        carrito: [
            1: {NOMBRE : 'Zapatillas', PRECIO: 5, FOTO: 'zapa.jpeg'},
            5: {NOMBRE : 'Gorra', PRECIO: 15, FOTO: 'gorra.jpeg'}
            ]
    }
$productoSeleccionado [NOMBRE : 'Gorra', PRECIO: 15, FOTO: 'gorra.jpeg']

$productoSeleccionado = $_SESSION['carrito']['5']
    
*/