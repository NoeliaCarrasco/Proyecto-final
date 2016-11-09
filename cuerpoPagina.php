<?PHP
    session_start();
	if(!isset($_SESSION['rol'])){header('location: login.php');}
    $nombre = 'Anonimo';
    if(isset($_SESSION['nombre']) && $_SESSION['nombre'] != ''){
        $nombre = $_SESSION['nombre'];
    }
?>
<html>
    <body>
        <h1>Conectado como <?PHP echo $nombre; ?></h1>
        <?PHP
        if(!isset($_SESSION['nombre'])){
        ?>
            <a href="login.php">Conectar</a>
        <?PHP
        }else{
        ?>
            <a href="disconnect.php">Desconectar</a>
        <?PHP
        }
        ?>
    </body>
</html>
