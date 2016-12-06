<?PHP
include_once("./db_configuration.php");
	session_start();
	if(!isset($_SESSION['rol'])){header('location: login.php');}
	$categoria = 0;
	$edad = 0;
	$sexo = 0;
	$id_producto = '';
	if(isset($_REQUEST['p']) && intval($_REQUEST['p']) >= 0){
		$categoria = intval($_REQUEST['p']);
	}else{
		$categoria = 0;
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
	if(isset($_REQUEST['i'])){
		$id_producto = $_REQUEST['i'];
	}
	
	$mysqli = new mysqli($db_host, $db_user, $db_password, "deportes");

	/* comprobar la conexión */
	if (mysqli_connect_errno()) {
		printf("Falló la conexión: %s\n", mysqli_connect_error());
		exit();
	}

	$consulta = "SELECT productos.*, categorias.NOMBRE AS 'NOMBRE_CATEGORIA' FROM productos, categorias WHERE productos.IDCATEGORIA = categorias.IDCATEGORIA AND productos.IDPRODUCTO ='".$id_producto."';";

	$producto = '';
	if ($resultado = $mysqli->query($consulta)) {
		if($resultado->num_rows > 0){
		/* liberar el conjunto de resultados */
			$producto = $resultado->fetch_assoc();
		}
		$resultado->close();
	}

	$mysqli = new mysqli($db_host, $db_user, $db_password, "deportes");

	
	if (mysqli_connect_errno()) {
		printf("Falló la conexión: %s\n", mysqli_connect_error());
		exit();
	}

	$consulta = "SELECT * FROM categorias ORDER BY IDCATEGORIA";
	$categorias = [];
	if ($resultado = $mysqli->query($consulta)) {
		if($resultado->num_rows > 0){
			while ( $fila = $resultado->fetch_assoc() ) {//mientras fila no sea nulo guardo en ella los campos que me de la consulta como un array asociativo que luego guardare en el array categorias
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
                                    foreach($categorias as $c){//recorro con el foreach la variable categoriass y guardo las lineas en la variable c
                                ?>
                                        <li><a href="product-list.php?p=<?PHP echo $c['IDCATEGORIA'];//p= al idcategoria que se genere ?>&s=0&e=0"><?PHP echo $c['NOMBRE'];//con ese idcategoria y la variable s y e muestrame el nombre de esa categoria ?></a></li>
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

           

        </section><!-- #breadcrumbs end -->











        <!-- ============================================
        =================== Content =====================
        ============================================= -->

        <section id="content">

            <div class="content-wrap">

                <div class="container clearfix">
                    <div class="row">

                        <!-- SHOP SIDEBAR -->
                        <div class="col-md-3 col-sm-4 sidebar">

                            <ul class="sidebar-navigation" id="sidebar-menu">
                                <li <?PHP if($sexo==1 && $edad==0){echo 'class="active open"';}//que me resalte esa parte del menu ?>><a href="./product-list.php?p=0&s=1&e=0">Mujer</a>
                                    <ul>
                                        <?PHP
                                            foreach($categorias as $c){//recorro con el foreach la variable categoria y guardo las lineas dentro de la variable c
                                        ?>
                                        <li <?PHP if($categoria == $c['IDCATEGORIA']){echo 'class="active"';}//si la variable categoria es igual al idcategoria que esta dentro de la variable c resaltame esa parte del menu ?>><a href="./product-list.php?p=<?PHP echo $c['IDCATEGORIA'];//p= al idcategoria que me genere ?>&s=1"><?PHP echo $c['NOMBRE'];//cn esa id y la variable sexo y edad muestrame el nombre de la categoria ?></a></li>
                                        <?PHP } ?>
                                    </ul>
                                </li>
                                <li <?PHP if($sexo==0 && $edad==0){echo 'class="active open"';} ?>><a href="./product-list.php?p=0&s=0&e=0">Hombre</a>
                                    <ul>
                                        <?PHP
                                            foreach($categorias as $c){
                                        ?>
                                        <li <?PHP if($categoria == $c['IDCATEGORIA']){echo 'class="active"';} ?>><a href="./product-list.php?p=<?PHP echo $c['IDCATEGORIA']; ?>&s=0&e=0"><?PHP echo $c['NOMBRE']; ?></a></li>
                                        <?PHP } ?>
                                    </ul>
                                </li>
                                <li <?PHP if($sexo==0 && $edad==1){echo 'class="active open"';} ?>><a href="product-list.php?p=0&s=0&e=1">Niño</a>
                                    <ul>
                                        <?PHP
                                            foreach($categorias as $c){
                                        ?>
                                        <li <?PHP if($categoria == $c['IDCATEGORIA']){echo 'class="active"';} ?>><a href="./product-list.php?p=<?PHP echo $c['IDCATEGORIA']; ?>&s=1&e=0"><?PHP echo $c['NOMBRE']; ?></a></li>
                                        <?PHP } ?>
                                    </ul>
                                </li>
								<li <?PHP if($sexo==1 && $edad==1){echo 'class="active open"';} ?>><a href="product-list.php?p=0&s=1&e=1">Niña</a>
                                    <ul>
                                        <?PHP
                                            foreach($categorias as $c){
                                        ?>
                                        <li <?PHP if($categoria == $c['IDCATEGORIA']){echo 'class="active"';} ?>><a href="./product-list.php?p=<?PHP echo $c['IDCATEGORIA']; ?>&s=1&e=1"><?PHP echo $c['NOMBRE']; ?></a></li>
                                        <?PHP } ?>
                                    </ul>
								</li>
                                
                            </ul>

                        </div>
                        <!-- END SHOP SIDEBAR -->

	
                        <!-- PRODUCT DETAIL -->
                        <div class="col-md-9 col-sm-8">

                            <!-- row -->
                            <div class="row">
                                <!-- col -->
                                <div class="col-md-12">

                                    <article class="product-view">
									<?PHP
										if($producto != ''){
									?>
                                        <!-- row -->
                                        <div class="row">

                                            <!-- product gallery -->
                                            <div class="col-md-5">
                                                <div class="product-image">
                                                    <img id="zoom" src="imagenes/<?PHP echo $producto['FOTO']; ?>" data-zoom-image="imagenes/<?PHP echo $producto['FOTO']; ?>" alt="" class="img-responsive">
                                                    
                                                </div>
                                                <script type="text/javascript">

                                                    $(document).ready(function() {

                                                        $("#zoom").elevateZoom({
                                                            zoomType: "inner"
                                                        });

                                                    }); //cada vez que ponemos el raton encima de la imagen la aumenta 

                                                </script>
                                            </div>
                                            <!-- /product gallery -->

                                            <!-- product details -->
                                            <div class="col-md-7 product-details">

                                                <h4><?PHP echo $producto['NOMBRE']; ?> <span class="product-offer hot-offer"></span></h4>

                                                <div class="price-block">
                                                    <p class="price"> <?PHP echo $producto['PRECIO']; ?>€</p>
                                                    <p class="availability">Disponibilidad:  <?PHP if($producto['STOCK'] > 0){ ?><span class="in-stock">Disponible</span><?PHP }else{?><span class="in-stock" style="color:red;">Agotado</span><?PHP } ?></p>
                                                </div>
												
												<form action="addCarrito.php" method="POST">

													<div class="add-to-cart">
														<input type="hidden" name="IDPRODUCTO" value="<?PHP echo $producto['IDPRODUCTO']; ?>">
														<input type="hidden" name="FOTO" value="<?PHP echo $producto['FOTO']; ?>">
														<input type="hidden" name="NOMBRE" value="<?PHP echo $producto['NOMBRE']; ?>">
														<input type="hidden" name="PRECIO" value="<?PHP echo $producto['PRECIO']; ?>">
														<input type="text" name="CANTIDAD" value="1" max="<?PHP echo $producto['STOCK'];//son los campos del producto que coge. Estan ocultos menos la cantidad que si podemos seleccionarla  ?>" class="myInput quantity touchspin"> 
														<input type="submit" class="myBtn myBtn-border myBtn-rounded myBtn-sm myBtn-midlight pull-right" value="Añadir al carrito">
													</div>
												
												</form>

                                                <div class="well review">
                                                    <div class="well-header">
                                                        <span class="rating">
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        </span>
                                                        
                                                    </div>
                                                    <ul class="list-unstyled">
                                                        <li><span>Codigo:</span> <?PHP echo $producto['IDPRODUCTO']; ?></li>
                                                        <li><span>Categoria:</span> <?PHP echo $producto['NOMBRE_CATEGORIA']; ?></li> 
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- /product details -->

                                        </div>
                                        <!-- /row -->

                                        <!-- row -->
                                        <div class="row">
                                            <!-- tab -->
                                            <div class="col-md-12">

                                                <div role="tabpanel" class="info-section">

                                                    <!-- Nav tabs -->
                                                    <ul class="nav nav-tabs myTabs" role="tablist">
                                                        <li role="presentation" class="active"><a href="#desc" aria-controls="desc" role="tab" data-toggle="tab">Descripcion</a></li>
                                                    </ul>

                                                    <!-- Tab panes -->
                                                    <div class="tab-content">

                                                        <div role="tabpanel" class="tab-pane fade in active" id="desc">
                                                            <p><?PHP echo $producto['DESCRIPCION']; ?></p>
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                            <!-- /tab -->
                                        </div>
                                        <!-- /row -->
                                        <?PHP
										}
										?>
                                    </article>

                                </div>
                                <!-- /col -->
                            </div>
                            <!-- /row -->

                        </div>
                        <!-- END PRODUCT DETAIL -->

                    </div>
                    <!-- /row -->


                </div>
                <!-- /container -->

            </div>
        </section>










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
                                <h4><strong>Contactenos</h4>
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
    <script type="text/javascript" src="assets/js/vendor/starrr/starrr.min.js"></script>
    <script type="text/javascript" src="assets/js/vendor/elevatezoom/jquery.elevateZoom-3.0.8.min.js"></script>

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