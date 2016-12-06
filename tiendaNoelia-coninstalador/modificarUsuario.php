<?PHP
include_once("./db_configuration.php");
	session_start();
	if(!isset($_SESSION['rol'])){header('location: login.php');}else{if(intval($_SESSION['rol']) != 2){header('location: index.php');}}
	$producto = 0;
	$edad = 0;
	$sexo = 0;
	if(isset($_REQUEST['p']) && intval($_REQUEST['p']) >= 0 && intval($_REQUEST['p']) <= 4){
		$producto = intval($_REQUEST['p']);
	}else{
		$producto = 0;
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
	
	
	

	if (mysqli_connect_errno()) {
		printf("Falló la conexión: %s\n", mysqli_connect_error());
		exit();
	}
	if(!isset($_REQUEST['i'])){
		header('location: administrarUsuarios.php');
	}
	$consulta = "SELECT * FROM usuarios WHERE IDUSUARIO = '".$_REQUEST['i']."' ORDER BY IDUSUARIO";
	$usuario_elegido = null;
	if ($resultado = $connection->query($consulta)) {
		if($resultado->num_rows > 0){
			$usuario_elegido = $resultado->fetch_assoc();
		}
		$resultado->close();
	}


	$consulta = "SELECT * FROM categorias ORDER BY IDCATEGORIA";
	$categorias = [];
	if ($resultado = $connection->query($consulta)) {
		if($resultado->num_rows > 0){
			while ( $fila = $resultado->fetch_assoc() ) {
				array_push($categorias, $fila);
			}
		}
		$resultado->close();
	}

	
	$connection->close();
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








        <!-- ==================================================
        ================= Additional Navbar ===================
        =================================================== -->

       <nav id="add-navbar">

            <div class="container clearfix">

                 <ul class="pull-right">
					<li><a href="#">Administrar</a>
						<ul>
					
					<?PHP
						if((isset($_SESSION['IDUSUARIO']) && $_SESSION['IDUSUARIO'] != '') && (isset($_SESSION['rol']) && intval($_SESSION['rol']) == 2)){
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
						
						if(!isset($_SESSION['IDUSUARIO'])){
					?>
                    <li><a href="login.php">Login</a></li>
					<?PHP
						}else{
					?>
                    <li><a href="disconnect.php">Logout</a></li>
					<?PHP
						}
					?>
                </ul>

                <ul class="divided">
                    <li><i class="fa fa-phone mr-5"></i> <span>+34 654 742 783</span></li>                    <li><i class="fa fa-user mr-5"></i> <span><?= $_SESSION['IDUSUARIO'] ?></span></li>
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
                            <a href="#" id="shopping-cart-trigger"><i class="fa fa-shopping-cart"></i><?PHP if(isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0){ ?><span class="badge"><?PHP $total_productos = 0; foreach($_SESSION['carrito'] as $producto_carrito){$total_productos+=$producto_carrito['CANTIDAD'];} echo $total_productos; ?></span><?PHP } ?></a>
                            <?PHP if(isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0){ ?>
							<div class="cart-content">
                                <div class="cart-title">
                                    <h4>Carrito</h4>
                                </div>
                                <ul class="cart-items">
                                <?PHP
									foreach($_SESSION['carrito'] as $id => $producto_carrito){
								?>
									<li class="media">
                                        <div class="media-left">
                                            <a href="product-detail.php">
                                                <img class="media-object thumb-w" alt="" src="./imagenes/<?PHP echo $producto_carrito['FOTO']; ?>">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <p class="media-heading"><a href="product-detail.php?i=<?PHP echo $id; ?>"><?PHP echo $producto_carrito['NOMBRE']; ?></a> <span class="quantity">x <?PHP echo $producto_carrito['CANTIDAD']; ?></span></p>
                                            <p class="price"><?PHP echo $producto_carrito['PRECIO']; ?>€</p>
                                        </div>
                                    </li>
								<?PHP
									}
								?>
                                </ul>
                                <div class="cart-actions clearfix">
									<?PHP $total = 0; foreach($_SESSION['carrito'] as $producto_carrito){ $total+=($producto_carrito['PRECIO']*$producto_carrito['CANTIDAD']);} ?>
                                    <span class="price pull-left"><?PHP echo $total; ?>€</span>
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
                <h1>Administrar usuarios</h1>
                

        </section><!-- #breadcrumbs end -->











        <!-- ============================================
        =================== Content =====================
        ============================================= -->

        <section id="content">

            <div class="content-wrap">

                <div class="container clearfix">
                    <div class="row">


                        <!-- SHOPPING CART -->
                        <div class="col-md-12">

                            <div class="checkout">

                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="mt-40">MODIFICAR USUARIO</h4>

                                        <form action="cambiarDatosUsuario.php" method="post">

                                            <div class="row">
												
												<input name="id" type="hidden" class="form-control myInput" id="id" value="<?=$usuario_elegido['IDUSUARIO']//coge de la variable usuario_elegido el valor de la clave idusuario y lo pega en el html para mostrarlo?>" required>
                                                <div class="form-group col-sm-6">
                                                    <label for="nombre">Nombre <span class="text-lightred" style="font-size: 15px">*</span></label>
                                                    <input name="nombre" type="text" class="form-control myInput" id="nombre" value="<?=$usuario_elegido['NOMBRE']?>" required> <!--required = a que es obligatorio-->
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label for="apellido">Apellidos<span class="text-lightred" style="font-size: 15px">*</span></label>
                                                    <input name="apellido" type="text" class="form-control myInput" id="apellido" value="<?=$usuario_elegido['APELLIDO']?>" required>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="form-group col-sm-12">
                                                    <label for="usuario">Usuario</label>
                                                    <input name="usuario" type="text" class="form-control myInput" value="<?=$usuario_elegido['USUARIO']?>" id="usuario">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-sm-12">
                                                    <label for="password">Contraseña</label>
                                                    <input name="password" type="password" class="form-control myInput" id="password">
                                                </div>
                                            </div>

											<div class="row">
											   
												<div class="col-md-12">
													<h4 class="mt-40">Permisos</h4>
														<div class="col-md-6">
															<label class="checkbox checkbox-custom mb-20">
																<input type="radio" name="admin" value="1" <?PHP if($usuario_elegido['ROL'] != '2'){ //si el rol del usuario es distinto de dos selecciona cliente?> checked <?PHP }//seleccionar?>><i></i>
																<h6 class="text-bold text-uppercase m-0 inline">Cliente</h6>
															</label>
														</div>
														<div class="col-md-6">
															<label class="checkbox checkbox-custom mb-20">
																<input type="radio" name="admin" value="2" <?PHP if($usuario_elegido['ROL'] == '2'){ ?> checked <?PHP }?>><i></i>
																<h6 class="text-bold text-uppercase m-0 inline">Administrador</h6>
															</label>
														</div>
												</div>
											</div>
                                            
											 <div class="row">
                                                <div class="form-group col-sm-12">
                                                    <h4 class="mt-40">Tema</h4>
                                                    <input name="tema" type="number" class="form-control myInput" id="tema"
                                                           value="<?=$usuario_elegido['TEMA']?>" min="1" max="3">
                                                </div>
                                            </div>
                                            
											<div class="row">
												<button type="submit" class="myBtn myBtn-success myBtn-rounded" style="width:100%;margin-top:30px;">Confirmar cambios</button>
											</div>

                                        </form>

                                    </div>

                                </div>

                            </div>


                        </div>
                        <!-- END SHOPPING CART -->

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