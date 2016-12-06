<?php
include_once("./db_configuration.php");
    $usuario_conectado = [];
    if((isset($_REQUEST['usuario']) && $_REQUEST['usuario'] != '') &&
       (isset($_REQUEST['password']) && $_REQUEST['password'] != '')){
        $usuario = $_REQUEST['usuario'];
        $password = $_REQUEST['password'];
        
        $mysqli = new mysqli($db_host, $db_user, $db_password, "deportes");

        if (mysqli_connect_errno()) {
            printf("Falló la conexión: %s\n", mysqli_connect_error());
            exit();
        }

        $consulta = "SELECT * FROM usuarios WHERE USUARIO = '".$usuario."' AND PASSWORD = '".md5($password)."'";
        if ($resultado = $mysqli->query($consulta)) {
            if($resultado->num_rows > 0){
                    session_start();
                    $usuario_conectado = $resultado->fetch_assoc();//dentro de la variable usuario_conectado guardamos los campos del usuario como un array asociativo 
                    $_SESSION['IDUSUARIO'] = $usuario_conectado['USUARIO'];//le asigno a la variable idusuario que esta dentro de sesion el valor usuario que tenemos dentro de la variable usuario_conectado
                    $_SESSION['IDU'] = $usuario_conectado['IDUSUARIO'];
                    $_SESSION['TEMA'] = $usuario_conectado['TEMA'];
                    $_SESSION['rol'] = $usuario_conectado['ROL'];
                    header('Location: index.php');
            }else{
                header('Location: login.php?e=1');//diregeme al login con codigo error 1
            }
            $resultado->close();
        }

        $mysqli->close();
    }else{
		header('Location: index.php?e=2');
    }
?>
