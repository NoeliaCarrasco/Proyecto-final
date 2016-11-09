<?php
include_once("./db_configuration.php");
	session_start();
	if(!isset($_SESSION['rol'])){header('location: login.php');}
    if((isset($_REQUEST['usuario']) && $_REQUEST['usuario'] != '') &&
       (isset($_REQUEST['password']) && $_REQUEST['password'] != '')){
        $usuario = $_REQUEST['usuario'];
        $password = $_REQUEST['password'];
        
       $mysqli = new mysqli($db_host, $db_user, $db_password, "deportes");

        /* comprobar la conexión */
        if (mysqli_connect_errno()) {
            printf("Falló la conexión: %s\n", mysqli_connect_error());
            exit();
        }

        $consulta = "SELECT * FROM usuarios WHERE USUARIO = '".$usuario."' AND PASSWORD = '".$password."'";
		
        if ($resultado = $mysqli->query($consulta)) {//si creamos la query y el resultado de la query y lo guardamos en resultado
            if($resultado->num_rows > 0){//si la variable resultado tiene un numero de filas mayor que 0 entonces
            
                session_start();//inicia sesion
                $usuario_conectado = $resultado->fetch_assoc();//dentro de la variable usuario_conectado guardamos los campos del usuario como un array asociativo 
                $_SESSION['IDUSUARIO'] = $usuario_conectado['USUARIO'];//le asigno a la variable idusuario que esta dentro de session el valor usuario que tenemos dentro de la variable usuario_conectado
                header('Location: index.php');//me dirige al index
            }else{//sino
                echo 'LOS DATOS DE CONEXION NO COINCIDEN<br>';//muestrame los datos...
            }
            $resultado->close();//libera el conjunto de resultados
        }

        $mysqli->close();//cerrar la conexión
    }else{//sino muestrame no se ...
        echo 'No se han introducido datos de conexion<br>';
    }
?>
