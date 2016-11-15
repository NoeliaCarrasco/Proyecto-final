<?php
    ob_start();
?>

<html>
	<head>
        <title>Instalador de la Tienda</title>
		<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
		<link rel="stylesheet" href="./css/bootstrap.min.css">
		<link rel="stylesheet" href="./css/font-awesome.min.css">
		<link rel="stylesheet" href="./css/style.css">
        <style>
            .panel-heading > h3{
                padding: 0.1em 0.1em 0.1em 0.1em;
                margin: 0.1em 0.1em 0.1em 0.1em;
            }
            
              .divider{
                min-height:1px;
                max-height:1px;
                background-color:#d3d3d3;
                width:100%;
                display:block;
                margin-top: 1.5em;
                margin-bottom: 1.5em;
            }
        </style>
	</head>
	<body>
        <br>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3>Instalar Tienda online</h3>
                        </div>
                        <div class="panel-body">
                            <form action="instalador.php" method="post">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="panel panel-danger">
                                        <div class="panel-heading">
                                            <h3><i class="fa fa-sitemap"></i> Datos de conexión</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="database">Base de datos</label>
                                                        <div class = "input-group">
                                                             <span class="input-group-addon"><i class="fa fa-database"></i></span>
                                                             <input id="database" name="database" type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="dbuser">Usuario</label>
                                                        <div class = "input-group">
                                                             <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                             <input id="dbuser" name="dbuser" type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="dbpass">Contraseña</label>
                                                        <div class = "input-group">
                                                             <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                                             <input id="dbpass" name="dbpass" type="password" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="host">Host</label>
                                                        <div class = "input-group">
                                                             <span class="input-group-addon"><i class="fa fa-exchange"></i></span>
                                                             <input id="host" name="host" type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-3 col-sm-offset-2">
                                    <button class="btn btn-primary col-xs-12"><i class="fa fa-recycle"></i> Limpiar</button>
                                </div>
                                <div class="col-sm-3 col-sm-offset-2">
                                    <button id="btn_crear" class="btn btn-success col-xs-12"><i class="fa fa-download"></i> Instalar</button>
                                </div>
                            </div>
                            <br><br>
                            <div class="row">
                                <div id="feedback" class="col-sm-8 col-sm-offset-2">
                                    
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
          if(isset($_POST["dbuser"])){
              $db_name=$_POST["database"];
              $db_user=$_POST["dbuser"];
              $db_password=$_POST["dbpass"];
              $db_host=$_POST["host"];
              $connection = new mysqli($db_host,$db_user,$db_password,$db_name);
                 //TESTING IF THE CONNECTION WAS RIGHT
              if ($connection->connect_errno) {
                   printf("Connection failed: %s\n", $connection->connect_error);
                   exit();
              }else{
                include("./database.php");
                $file = fopen("../dbconfig.php", "a");
                fwrite($file, "<?php"."\n");
                fwrite($file, "$"."database="."'".$db_name."';"."\n");
                fwrite($file, "$"."user="."'".$db_user."';"."\n");
                fwrite($file, "$"."password="."'".$db_password."';"."\n");
                fwrite($file, "$"."host="."'".$db_host."';"."\n");
                fwrite($file, "?>"."\n");
                fclose($file);
                unlink("../instalador/database.php");
                unlink("../instalador/instalador.php");
                rmdir('../instalador');
                 header("Location: ./../login.php");
               }
              }
        ?>
    
    </body>
</html>