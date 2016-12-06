<?PHP
ob_start();
include_once("./db_configuration.php");
	session_start();//si no está creada la sesión, la crea, si la sesión está creada ya, la recupera
	$producto = 0;//declarar la variable producto con valor 0 
	$edad = 0;//declarar la variable edad con valor 0
	$sexo = 0;//declarar la variable sexo con valor 0
	if(isset($_REQUEST['p']) && intval($_REQUEST['p']) >= 0 && intval($_REQUEST['p']) <= 4){//si esta establecida la variable p y su valor entero es mayor o igual que 0 y menor o igua que 4 entonces
		$producto = intval($_REQUEST['p']);//le asignamos a la variable producto el valor entero de p
	}else{//sino 
		$producto = 0;//la variable producto es igual a 0
	}
	if(isset($_REQUEST['s']) && intval($_REQUEST['s']) > 0 && intval($_REQUEST['s']) <= 4){
		$sexo = intval($_REQUEST['s']);
	}else{
		$sexo = 0;
	}
	if(isset($_REQUEST['e']) && intval($_REQUEST['e']) > 0 && intval($_REQUEST['e']) <= 4){
		$edad = intval($_REQUEST['e']);
	}else{
		$edad = 0;
	}
	
	
	
    $connection = new mysqli($db_host, $db_user, $db_password, "deportes");//creamos una instancia de la clase mysqli en la variable connection con los parametros $db_host, db_user, db_password, deportes
    $query = "";//declaramos la variable query con valor vacio
    if(isset($_SESSION['rol']) && intval($_SESSION['rol']) == 2){//si existe la variable rol y tiene valor entero igual 2 'administrador' entonces
        $query = "SELECT p.idpedido as Pedido, u.usuario as Usuario, p.fecha_alta as Fecha, sum(dp.CANTIDAD*dp.IMPORTE) as Total FROM pedidos p,             detallespedido dp, usuarios u WHERE p.IDUSUARIO = u.IDUSUARIO AND dp.IDPEDIDO = p.IDPEDIDO GROUP BY p.IDPEDIDO ORDER BY u.USUARIO,                   p.FECHA_ALTA DESC;";//almacenamos en la variable query la consulta que coge todos los pedidos 
    }else{//sino
        $query = "SELECT p.idpedido as Pedido, u.usuario as Usuario, p.fecha_alta as Fecha, sum(dp.CANTIDAD*dp.IMPORTE) as Total FROM pedidos p,             detallespedido dp, usuarios u WHERE p.IDUSUARIO = ".$_SESSION['IDU']." AND p.IDUSUARIO = u.IDUSUARIO AND dp.IDPEDIDO = p.IDPEDIDO GROUP BY p.IDPEDIDO ORDER BY u.USUARIO,p.FECHA_ALTA DESC;";//almacenamos en la variable query la consulta que unicamente coge los pedidos de una id usuario concreta
    }
    $pedidos=$connection->query($query);////iniciamos la query dentro de la varriable pedidos
    $pedido=null;//la variable pedido se inicia como nula
    $lista_pedidos = [];//lista_pedidos se inicia como array
    do{//iniciamos el bucle do
        if($pedido != null){//si pedido no es nulo entonces
            array_push($lista_pedidos, $pedido);//insertamos en el array pedido que se le genera una id numérica automáticamente
        }
    }while($pedido=$pedidos->fetch_object());//cuando no quedan mas lineas de datos que coger se cierra el bucle asignandole a la variable pedido un objecto de la variable pedidos



$mysqli = new mysqli($db_host, $db_user, $db_password, "deportes");

	
	if (mysqli_connect_errno()) {
		printf("Falló la conexión: %s\n", mysqli_connect_error());
		exit();
	}

	$consulta = "SELECT * FROM categorias ORDER BY IDCATEGORIA";
	$categorias = [];
	if ($resultado = $mysqli->query($consulta)) {
		if($resultado->num_rows > 0){
			while ( $fila = $resultado->fetch_assoc() ) {
				array_push($categorias, $fila);
			}
		}
		$resultado->close();
	}

	
	$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />





    <!-- ============================================
    ================= Stylesheets ===================
    ============================================= -->
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,700,700italic|Raleway:300,400,500,600,700|Open+Sans+Condensed:700" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="assets/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="assets/css/animate.css" type="text/css" />
    <link rel="stylesheet" href="assets/js/vendor/flexslider/flexslider.css" type="text/css" />
    <link rel="stylesheet" href="assets/js/vendor/magnific/magnific-popup.css" type="text/css" />
    <link rel="stylesheet" href="assets/js/vendor/owl/assets/owl.carousel.css" type="text/css" />
    <link rel="stylesheet" href="assets/js/vendor/bootstrap-select/css/bootstrap-select.min.css" type="text/css" />
    <link rel="stylesheet" href="assets/js/vendor/range-slider/css/styles.css" type="text/css" />
    <link rel="stylesheet" href="assets/js/vendor/touchspin/jquery.bootstrap-touchspin.css" type="text/css" />
    <link rel="stylesheet" href="assets/js/vendor/starrr/starrr.css" type="text/css" />

    <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="assets/js/vendor/rs-plugin/css/settings.css" media="screen" />

    <!-- animsition CSS -->
    <link rel="stylesheet" href="assets/js/vendor/animsition/css/animsition.min.css">



    <!-- jQuery -->
    <script type="text/javascript" src="assets/js/vendor/jquery-1.11.2.min.js"></script>






    <!-- ============================================
    ============= Main App Stylesheet ===============
    ============================================= -->

    <?php

          if($_SESSION["TEMA"]==1){
            echo '<link rel="stylesheet" href="assets/css/style.css">';
          }elseif($_SESSION["TEMA"]==2){
            echo '<link rel="stylesheet" href="assets/css/style1.css">';
          }elseif($_SESSION["TEMA"]==3){
            echo '<link rel="stylesheet" href="assets/css/style2.css">';
          }
      ?>





    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!--[if lt IE 9]>
    	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->









    <!-- ============================================
    ================== Page Title ===================
    ============================================= -->

    <title>Web Noelia | Tienda de deportes </title>







</head>

<body>








    <!-- ============================================
    ================= Page Wrapper ==================
    ============================================= -->

    <div id="wrapper" class="clearfix animsition">







        <!-- ================================================
        ================= Search Container ==================
        ================================================= -->

        <div id="search-container" class="search-box-wrapper">
            <div class="container">
                <i class="fa fa-search"></i>
                <div class="search-box">
                    <form action="http://example.com/" class="search-form" role="search" >
                        <input type="search" name="s" value="" title="Press Enter to submit your search" placeholder="Search…" class="search-field">
                        <input type="submit" value="Search" class="search-submit">
                    </form>
                </div>
            </div>
        </div><!--/ #search-container -->








        <!-- ==================================================
        ================= Additional Navbar ===================
        =================================================== -->

       <nav id="add-navbar">

            <div class="container clearfix">

                 <ul class="pull-right">
					<li><a href="#">Administrar</a>
						<ul>
					
					<?PHP
						if((isset($_SESSION['IDUSUARIO']) && $_SESSION['IDUSUARIO'] != '') && (isset($_SESSION['rol']) && intval($_SESSION['rol']) == 2)){//si esta establecida la variable idusuario e idusuario es distinta de vacio y esta establecida la variable rol y el valor entero es igual a dos entonces puede administrar usuarios y productos
					?>
							<li><a href="administrarUsuarios.php">Usuarios</a></li>
							<li><a href="administrarProductos.php">Productos</a></li>
                            <li><a href="administrarCategorias.php">Categorias</a></li>
                            <li><a href="estadisticas.php">Estadisticas</a></li>
					<?PHP
						}
?>
                            <li><a href="administrarpedidos.php">Pedidos</a></li>
						</ul>
					</li>
                    <?PHP
					?>
                     
					<?PHP
						if(!isset($_SESSION['IDUSUARIO'])){//si esta establecida la variable idusuario entonces inicia sesion 'login'
					?>
                    <li><a href="login.php">Login</a></li>
					<?PHP
						}else{//sino desconectar
					?>
                    <li><a href="disconnect.php">Logout</a></li>
					<?PHP
						}
					?>
                </ul>

                <ul class="divided">
                    <li><i class="fa fa-phone mr-5"></i> <span>+34 654 742 783</span></li>                    <li><i class="fa fa-user mr-5"></i> <span><?= $_SESSION['IDUSUARIO']// ?></span></li>
                </ul>

            </div>

        </nav><!-- #add-navbar end -->








        <!-- ============================================
        ==================== Header =====================
        ============================================= -->

        <header id="header" class="dark"><!-- class .sticky-mobile makes header sticky on small devices -->

            <div id="header-wrap">

                <div class="container clearfix">

                    <div id="main-navbar-toggle"><i class="fa fa-bars"></i></div>







                    <!-- ============================================
                    =================== Branding ====================
                    ============================================= -->

                    <div id="branding">
                        <a href="index.php" class="brand-normal"><img src="assets/images/logo-dark.png" alt="Minovate"></a>
                        <a href="index.php" class="brand-retina"><img src="assets/images/logo@2x-dark.png" alt="Minovate"></a>
                    </div><!-- #branding end -->










                    <!-- ============================================
                    ================= Main Navbar ===================
                    ============================================= -->
					<nav id="main-navbar">

                       <ul>
                            <li><a href="index.php">Inicio</a></li>
                            <li><a href="#">Hombre</a>
                                <ul>
												
                                <?PHP
                                    foreach($categorias as $c){
                                ?>
                                        <li><a href="product-list.php?p=<?PHP echo $c['IDCATEGORIA']; ?>&s=0&e=0"><?PHP echo $c['NOMBRE']; ?></a></li>
                                <?PHP
                                    }
                                ?>
                                </ul>
                            </li>
                            <li><a href="#">Mujer</a>
                                <ul>
												
                                <?PHP
                                    foreach($categorias as $c){
                                ?>
                                        <li><a href="product-list.php?p=<?PHP echo $c['IDCATEGORIA']; ?>&s=1&e=0"><?PHP echo $c['NOMBRE']; ?></a></li>
                                <?PHP
                                    }
                                ?>
                                </ul>
                            </li>
                            <li><a href="#">Niño</a>
                                <ul>
												
                                <?PHP
                                    foreach($categorias as $c){
                                ?>
                                        <li><a href="product-list.php?p=<?PHP echo $c['IDCATEGORIA']; ?>&s=0&e=1"><?PHP echo $c['NOMBRE']; ?></a></li>
                                <?PHP
                                    }
                                ?>
                                </ul>
                            </li>
                            <li><a href="#">Niña</a>
                                <ul>
												
                                <?PHP
                                    foreach($categorias as $c){
                                ?>
                                        <li><a href="product-list.php?p=<?PHP echo $c['IDCATEGORIA']; ?>&s=1&e=1"><?PHP echo $c['NOMBRE']; ?></a></li>
                                <?PHP
                                    }
                                ?>
                                </ul>
                            </li>
                            <li><a href="contact.php">Contacto</a>
                            </li>
                        </ul>







                        <!-- ==============================================
                        ================= Shopping Cart ===================
                        =============================================== -->
                       <div id="shopping-cart">
                            <a href="#" id="shopping-cart-trigger"><i class="fa fa-shopping-cart"></i><?PHP if(isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0){//si esta establecida la variable carrito y tiene una cantidad de productos en el carrito mayor que 0 entonces ?><span class="badge"><?PHP $total_productos = 0; foreach($_SESSION['carrito'] as $producto_carrito){$total_productos+=$producto_carrito['CANTIDAD'];} echo $total_productos; ?></span><?PHP }//el valor inicial de la variable totalproductos es cero y se repite el foreach para ir aumentando la cantidad en base al total de los productos que hay en el carrito,luego muestra el total ?></a>
                            <?PHP if(isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0){//si esta establecida la variable carrito y tiene una cantidad de productos en el carrito mayor que 0 entonces ?>
							<div class="cart-content">
                                <div class="cart-title">
                                    <h4>Carrito</h4>
                                </div>
                                <ul class="cart-items">
                                <?PHP
									foreach($_SESSION['carrito'] as $id => $producto_carrito){//recorro con el foreach la variable carrito guardando los productos en la variable producto_carrito mostrandome la id
								?>
									<li class="media">
                                        <div class="media-left">
                                            <a href="product-detail.php">
                                                <img class="media-object thumb-w" alt="" src="./imagenes/<?PHP echo $producto_carrito['FOTO'];//muestrame el contenido de la variable foto ?>">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <p class="media-heading"><a href="product-detail.php?i=<?PHP echo $id;//muestrame la id ?>"><?PHP echo $producto_carrito['NOMBRE']; ?></a> <span class="quantity">x <?PHP echo $producto_carrito['CANTIDAD']; ?></span></p>
                                            <p class="price"><?PHP echo $producto_carrito['PRECIO']; ?>€</p>
                                        </div>
                                    </li>
								<?PHP
									}
								?>
                                </ul>
                                <div class="cart-actions clearfix">
									<?PHP $total = 0; foreach($_SESSION['carrito'] as $producto_carrito){ $total+=($producto_carrito['PRECIO']*$producto_carrito['CANTIDAD']);}//declarar la variable total con valor inicial 0; recorro con el foreach la variable carrito guardando los productos en la variable producto_carrito sin mostrarme la id ?>
                                    <span class="price pull-left"><?PHP echo $total;//mostrar contenido de la variable total ?>€</span>
                                    <a href="shopping-cart.php" class="myBtn myBtn-3d myBtn-sm pull-right">Ver carrito</a>
                                </div>
                            </div>
							<?PHP
							}
							?>
                        </div><!-- #shopping-cart end -->









                        <!-- ==============================================
                        ================= Search Toggle ===================
                        =============================================== -->

                        <div id="search-toggle"> <span class="divider">|</span></div>







                    </nav><!-- #main-navbar end -->

                </div>

            </div>

        </header><!-- #header end -->










        <!-- ============================================
        =================== Breadcrumbs =================
        ============================================= -->
         <section id="breadcrumbs" class="breadcrumbs">

            <div class="container clearfix">
                <h1>Administrar Pedidos</h1>
                
             </div>
        </section><!-- #breadcrumbs end -->











        <!-- ============================================
        =================== Content =====================
        ============================================= -->

        <section id="content">

            <div class="content-wrap">

                <div class="container clearfix">
                    <div class="row">


                        <div class="col-md-12">

                            <div class="checkout">

                                <div class="row">

                                    <div class="col-md-12">
                                        <h4 class="mt-40">LISTA DE PEDIDOS</h4>

										<div class="table-responsive">
											<table class="table myTable">
												<thead>
													<tr>
														<th>IDPEDIDO</th>
														<th>USUARIO</th>
														<th>FECHA</th>
														<th>IMPORTE</th>
                                                        
                                                        
                                                        <th></th>
                                                        <?PHP
												            if(isset($_SESSION['rol']) && intval($_SESSION['rol']) == 2){//si esta establecida la variable rol y su valor entero es igual a 2 entonces; es para las cabeceras vacias
												        ?>
                                                        <th></th>
														<th></th>
                                                        <?php
                                                            }
                                                        ?>
													</tr>
												</thead>
												<tbody>
												
												<?PHP
													foreach($lista_pedidos as $pedido){//recorro con el foreach la variable lista_pedidos guardando los datos de los pedidos en la variable pedido
												?>
													<tr>
														<td class="product">
															<?=$pedido->Pedido?>
														</td>
														<td class="product">
															<?=$pedido->Usuario?>
														</td>
														<td class="product">
															<?=$pedido->Fecha?>
														</td>
														<td class="product">
															<?=$pedido->Total?>
														</td>
														<td><a href="Administrardetallespedidos.php?i=<?=$pedido->Pedido?>"><i class="fa fa-eye text-primary"></i></a></td>
                                                        <td><a href='./pdfpedidos.php?idpedido=<?=$pedido->Pedido?>' style="position:relative;top:-30"><button type='button' class='btn btn-danger'>Generar PDF</button></a></td>
                                                        <?PHP
												            if(isset($_SESSION['rol']) && intval($_SESSION['rol']) == 2){//si existe la variable rol y el valor entero es igual 2 entonces borropedidos.
												        ?>
														<td><a href="borrarPedidos.php?i=<?=$pedido->Pedido?>"><i class="fa fa-times-circle"></i></a></td>
                                                        <?PHP
                                                            }
                                                        ?>
													</tr>
												<?PHP
                                                    }
												?>
											   
												</tbody>
											</table>
										</div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                    <!-- /row -->


                </div>
                <!-- /container -->
                
                
        <div id="tabla" class="container">       
            </div>
                </div>
            
            


        <!-- ============================================
        ==================== Footer =====================
        ============================================= -->

        <footer id="footer">

            <div class="footer-main">
                <div class="container">
                    <div class="row">

                        <div class="col-md-3 col-md-offset-1">

                            <div class="widget widget-menu mb-0">

                                <h4><strong>Informacion</strong></h4>
                                <ul class="list-unstyled">
                                    <li><a href="#"><i class="fa fa-angle-right"></i> Terminos y condiciones</a></li>
                                    <li><a href="#"><i class="fa fa-angle-right"></i> Pago</a></li>
                                    <li><a href="#"><i class="fa fa-angle-right"></i> Envio</a></li>
                                    <li><a href="#"><i class="fa fa-angle-right"></i> Devoluciones</a></li>
                                    <li><a href="#"><i class="fa fa-angle-right"></i> Tarjeta Regalo</a></li>
                                </ul>

                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="widget widget-contact mt-20-md">
                                <h4><strong>Contactenos</strong> </h4>
                                <address>
                                    <strong>Sevilla</strong><br>
                                    Avenida de la constitucion s/n<br>
                                    España<br/><br/>
                                    <strong>Telefono:</strong> +34 654 742 783<br>
                                    <strong>Email:</strong> <a href="noeliacarrasco@hotmail.com">noeliacarrasco@hotmail.com</a><br>
                                    <strong>Skype:</strong> <a href="#">noelia</a>
                                </address>
                            </div>
                        </div>

                    </div>

                    <div class="line"></div>

                    <!-- row -->
                    <div class="row">

                    </div>
                    <!-- /row -->

                </div>
            </div>

            <div class="footer-bottom">
                
            </div>

        </footer><!-- #footer end -->











    <!-- ============================================
    =================== Go to Top ===================
    ============================================= -->

    <div id="gotoTop" class="fa fa-angle-up hidden-md"></div>










    <!-- ============================================
    ============== Vendor JavaScripts ===============
    ============================================= -->

    <script type="text/javascript" src="assets/js/vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/vendor/superfish/js/superfish.min.js"></script>
    <script type="text/javascript" src="assets/js/vendor/jRespond/jRespond.min.js"></script>
    <script type="text/javascript" src="assets/js/vendor/smoothscroll/SmoothScroll.js"></script>
    <script type="text/javascript" src="assets/js/vendor/appear/jquery.appear.js"></script>
    <script type="text/javascript" src="assets/js/vendor/stellar/jquery.stellar.min.js"></script>
    <script type="text/javascript" src="assets/js/vendor/flexslider/jquery.flexslider-min.js"></script>
    <script type="text/javascript" src="assets/js/vendor/magnific/jquery.magnific-popup.min.js"></script>
    <script type="text/javascript" src="assets/js/vendor/owl/owl.carousel.min.js"></script>
    <script type="text/javascript" src="assets/js/vendor/jflickrfeed/jflickrfeed.min.js"></script>
    <script type="text/javascript" src="assets/js/vendor/tweet-js/jquery.tweet.min.js"></script>
    <script type="text/javascript" src="assets/js/vendor/countTo/jquery.countTo.js"></script>
    <script type="text/javascript" src="assets/js/vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="assets/js/vendor/range-slider/js/plugin.js"></script>
    <script type="text/javascript" src="assets/js/vendor/touchspin/jquery.bootstrap-touchspin.js"></script>

    <!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
    <script type="text/javascript" src="assets/js/vendor/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="assets/js/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

    <!-- animsition js -->
    <script src="assets/js/vendor/animsition/js/jquery.animsition.min.js"></script>







    <!-- ============================================
    ============== Custom JavaScripts ===============
    ============================================= -->


    <script type="text/javascript" src="assets/js/global.js"></script>

            </div>
        </section>
    </div>
</body>
</html>