<?PHP
include_once("./db_configuration.php");
	session_start();//si no está creada la sesión, la crea, si la sesión está creada ya, la recupera
	$producto = 0;//declarar la variable producto con valor 0 
	$edad = 0;//declarar la variable edad con valor 0
	$sexo = 0;//declarar la variable sexo con valor 0
	
    /*
    
        Utilizamos la variable $producto para marcar la categoria
        
        Utilizamos la variable $sexo para indicar si es la subcategoria de mujer u hombre
            0 -> Hombre
            1 -> Mujer
            
        Utilizamos la variable $edad para indicar si es la parte de niños o la de adultos
            0 -> Adultos
            1 -> Niños
            
        Con lo cual:
            $producto -> 0
            $sexo     -> 1
            $edad     -> 1
            
            Indicaría que vamos a la categoria de sudaderas para niñas
    
    */

    if(isset($_REQUEST['p']) && intval($_REQUEST['p']) >= 0 && intval($_REQUEST['p']) <= 4){
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

    if(isset($_REQUEST['i'])){//si existe la variable i
        $idpedido = intval($_REQUEST['i']);//le asignamos a idpedido el valor entero de i
    }else{//sino
        $idpedido = -1;//idpedido es igual a -1
    }
        
	
		$connection = new mysqli($db_host, $db_user, $db_password, "deportes");//creamos una instancia de la clase mysqli en la variable connection con los parametros $db_host, db_user, db_password, deportes
        $query = "SELECT pr.IDPRODUCTO AS Producto, p.IDPEDIDO AS Pedido, p.FECHA_ALTA AS Enviado, c.NOMBRE AS Articulo, pr.NOMBRE AS Tipo, dp.CANTIDAD AS Cantidad, dp.IMPORTE AS PRECIO, (dp.CANTIDAD * dp.IMPORTE) AS Total FROM detallespedido dp, categorias c, pedidos p, productos pr WHERE c.IDCATEGORIA =                   pr.IDCATEGORIA AND p.IDPEDIDO = ".$idpedido." AND p.IDPEDIDO = dp.IDPEDIDO AND dp.IDPRODUCTO = pr.IDPRODUCTO";// la variable query va a almacenar la consulta que vamos a realizar
		$detallespedidos=$connection->query($query);//iniciamos la query dentro de la varriable detallespedidos
        $detallepedido=null;//la variable detallespedido se inicia como nula
        $lista_detalles=[];//lista_detalles se inicia como array

        do{//iniciamos el bucle do
            if($detallepedido != null){//si detallepedido no es nulo entonces
                
                array_push($lista_detalles, $detallepedido);//insertamos en el array el detallepedido, se le genera una id numérica automáticamente
            }
          /*
          detallepedido -> linea de datos que hemos obtenido al ejecutar la consulta
          lista_detalles -> conjunto de resultados que voy insertando en el bucle
          detallespedidos -> resultado de la query, estan todas las lineas sin tratar
          */
        }while($detallepedido=$detallespedidos->fetch_object());//cuando no quedan mas lineas de datos que coger se cierra el bucle asignandole a la variable detallepedido un objecto de la variable detallespedidos

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
					<?PHP
						if((isset($_SESSION['IDUSUARIO']) && $_SESSION['IDUSUARIO'] != '') && (isset($_SESSION['rol']) && intval($_SESSION['rol']) == 2)){//si esta establecida la variable idusuario e idusuario es distinta de vacio y esta establecida la variable rol y el valor entero es igual a dos entonces puede administrar usuarios y productos
					?>
					<li><a href="#">Administrar</a>
						<ul>
							<li><a href="administrarUsuarios.php">Usuarios</a></li>
							<li><a href="administrarProductos.php">Productos</a></li>
                            <li><a href="administrarCategorias.php">Categorias</a></li>
                            <li><a href="estadisticas.php">Estadisticas</a></li>
						</ul>
					</li>
					<?PHP
						}
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
									<?PHP $total = 0; foreach($_SESSION['carrito'] as $producto_carrito){ $total+=($producto_carrito['PRECIO']*$producto_carrito['CANTIDAD']);}//declarar la variable total con valor inicial 0; recorro con el foreach la variable carrito guardando los productos en la variable producto_carrito sin mostrarme la id; el total aumenta multiplicando el precio del producto con la cantidad seleccionada  ?>
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
                <h1>Detalles pedidos</h1>
                

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
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h4 class="mt-40">PEDIDO    : <?PHP echo $idpedido;// mostrame la id del pedido ?> </h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table myTable">
                                                        <thead>
                                                            <tr>
                                                                <th>IDPRODUCTO</th>
                                                                <th>FECHA</th>
                                                                <th>ARTICULO</th>
                                                                <th>TIPO</th>
                                                                <th>CANTIDAD</th>
                                                                <th>PRECIO</th>
                                                                <th>TOTAL</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        <?PHP
                                                            foreach($lista_detalles as $detallespedidos){//recorro con el foreach la variable lista_detalles guardando los detallespedidos en la variable detallespedidos 
                                                        ?>
                                                            <tr>
                                                                <td class="product">
                                                                    <?=$detallespedidos->Producto?>
                                                                </td>
                                                                <td class="product">
                                                                     <?=$detallespedidos->Enviado?>
                                                                </td>
                                                                <td class="product">
                                                                     <?=$detallespedidos->Articulo?>
                                                                </td>
                                                                <td class="product">
                                                                    <?=$detallespedidos->Tipo?>
                                                                </td>
                                                                <td class="product">
                                                                    <?=$detallespedidos->Cantidad?>
                                                                </td>
                                                                <td class="product">
                                                                    <?=$detallespedidos->PRECIO?>
                                                                </td>
                                                                <td class="product">
                                                                    <?=$detallespedidos->Total?>
                                                                </td>
                                                                
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

                        </div>

                    </div>
                    <!-- /row -->


                </div>
                <!-- /container -->




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

    </div><!-- #wrapper end -->











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


</body>
</html>