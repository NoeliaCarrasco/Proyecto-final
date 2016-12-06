<?PHP
    include_once("./db_configuration.php");
	session_start();
	if(!isset($_SESSION['rol'])){header('location: login.php');}
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


<!-- Graficas -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>




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
        ==================== Slider =====================
        ============================================= -->

        <section id="slider" class="slider-parallax">

            <!--
            #################################
                - THEMEPUNCH BANNER -
            #################################
            -->

            <div class="+tp-banner-container">

                <div class="tp-banner" >

                    <ul>

                        <!-- SLIDE  -->
                        <li data-transition="fade" data-slotamount="1" data-masterspeed="1000" data-thumb="imagenes/primerfo.jpg">

                            <!-- MAIN IMAGE -->
                            <img src="imagenes/primerfo.jpg" alt="" data-bgposition="center center" data-bgrepeat="no-repeat">

                            <!-- LAYERS -->

                            <!-- LAYER NR. 1 -->
                            <div class="tp-caption black_thin_blackbg_30 lft fadeout"
                                data-x="120"
                                data-y="220"
                                data-speed="800"
                                data-start="1000"
                                data-easing="easeOutQuad"
                                data-endspeed="1000"
                                data-endeasing="Power4.easeIn" style="white-space: normal;">
                            </div>

                            <!-- LAYER NR. 2 -->
                            <div class="tp-caption big-text skewfromleft fadeout"
                                data-x="150"
                                data-y="300"
                                data-speed="800"
                                data-start="1000"
                                data-easing="easeOutQuad"
                                data-endspeed="1000"
                                data-endeasing="Power4.easeIn">
                            </div>

                            <!-- LAYER NR. 3 -->
                            
                            <!-- LAYER NR. 4 -->
                            <div class="tp-caption lfb fadeout"
                                data-x="480"
                                data-y="560"
                                data-speed="800"
                                data-start="1000"
                                data-easing="easeOutQuad"
                                data-endspeed="1000"
                                data-endeasing="Power4.easeIn"><a href="#" class="myBtn myBtn-3d myBtn-theme myBtn-rounded text-sm"><span></span> <i class="fa fa-angle-right"></i></a>
                            </div>


                        </li>

                        <!-- SLIDE  -->
                        <li data-transition="slideup" data-slotamount="1" data-masterspeed="1000" data-thumb="imagenes/ropa-deportiva-americana-estilos.jpg">

                            <!-- MAIN IMAGE -->
                            <img src="imagenes/ropa-deportiva-americana-estilos.jpg" alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat">

                            <!-- LAYERS -->

                            <!-- LAYER NR. 1 -->
                            <div class="tp-caption white_heavy_70 tp-fade fadeout"
                                data-x="right" data-hoffset="90"
                                data-y="top" data-voffset="0"
                                data-speed="500"
                                data-start="500"
                                data-easing="Power4.easeOut"
                                data-splitin="chars"
                                data-splitout="chars"
                                data-elementdelay="0.05"
                                data-endelementdelay="0.05"
                                data-endspeed="300"
                                data-endeasing="Power1.easeOut"style="z-index: 6; white-space: nowrap;">
                            </div>

                            <!-- LAYER NR. 2 -->
                            <div class="tp-caption whiteline_long customin fadeout"
                                data-x="right" data-hoffset="245"
                                data-y="top" data-voffset="90"
                                data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                                data-speed="500"
                                data-start="500"
                                data-easing="Power4.easeOut"
                                data-splitin="none"
                                data-splitout="none"
                                data-elementdelay="0.1"
                                data-endelementdelay="0.1"
                                data-endspeed="600"
                                data-endeasing="Power1.easeOut"style="z-index: 7; white-space: nowrap;">
                            </div>

                            <!-- LAYER NR. 3 -->
                            <div class="tp-caption light_medium_20 tp-fade fadeout"
                                data-x="right" data-hoffset="180"
                                data-y="top" data-voffset="120"
                                data-speed="600"
                                data-start="800"
                                data-easing="Power4.easeOut"
                                data-splitin="none"
                                data-splitout="none"
                                data-elementdelay="0.1"
                                data-endelementdelay="0.1"
                                data-endspeed="600"
                                data-endeasing="Power1.easeOut"style="z-index: 8; white-space: nowrap;">
                            </div>


                        </li>

                        <!-- SLIDE  -->
                        <li data-transition="slideup" data-slotamount="1" data-masterspeed="1000"  datathumb="imagenes/decimas_rotativo_rebajas_hombre_esp.jpg" data-delay="15000"  data-saveperformance="off">

                            <!-- MAIN IMAGE -->
                            <img src="imagenes/decimas_rotativo_rebajas_hombre_esp.jpg" alt="" data-bgposition="right center" data-kenburns="on" data-duration="16000" data-ease="Linear.easeNone" data-bgfit="135" data-bgfitend="90" data-bgpositionend="center center">

                            <!-- LAYERS -->

                            <!-- LAYER NR. 1 -->
                            <div class="tp-caption white_heavy_70 tp-fade fadeout"
                                data-x="center" data-hoffset="-80"
                                data-y="center" data-voffset="0"
                                data-speed="500"
                                data-start="500"
                                data-easing="Power4.easeOut"
                                data-splitin="chars"
                                data-splitout="chars"
                                data-elementdelay="0.05"
                                data-endelementdelay="0.05"
                                data-endspeed="300"
                                data-endeasing="Power1.easeOut"style="z-index: 6; white-space: nowrap;">
                            </div>

                            <!-- LAYER NR. 2 -->
                            <div class="tp-caption whiteline_long customin fadeout"
                                data-x="center" data-hoffset="0"
                                data-y="center" data-voffset="50"
                                data-customin="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                                data-speed="500"
                                data-start="500"
                                data-easing="Power4.easeOut"
                                data-splitin="none"
                                data-splitout="none"
                                data-elementdelay="0.1"
                                data-endelementdelay="0.1"
                                data-endspeed="600"
                                data-endeasing="Power1.easeOut"style="z-index: 7; white-space: nowrap;">
                            </div>

                            <!-- LAYER NR. 3 -->
                            <div class="tp-caption light_medium_20 tp-fade fadeout"
                                data-x="center" data-hoffset="-85"
                                data-y="center" data-voffset="120"
                                data-speed="600"
                                data-start="800"
                                data-easing="Power4.easeOut"
                                data-splitin="none"
                                data-splitout="none"
                                data-elementdelay="0.1"
                                data-endelementdelay="0.1"
                                data-endspeed="600"
                                data-endeasing="Power1.easeOut"style="z-index: 8; white-space: nowrap;">
                            </div>



                        </li>


                    </ul>

                </div>

                <script type="text/javascript">

                    $(document).ready(function() {

                        var apiRevoSlider = $('.tp-banner').show().revolution(
                                {
                                    dottedOverlay:"none",
                                    delay:9000,
                                    startwidth:1140,
                                    startheight:700,
                                    hideThumbs:200,

                                    thumbWidth:100,
                                    thumbHeight:50,
                                    thumbAmount:3,

                                    navigationType:"none",
                                    navigationArrows:"solo",
                                    navigationStyle:"preview1",

                                    touchenabled:"on",
                                    onHoverStop:"on",

                                    swipe_velocity: 0.7,
                                    swipe_min_touches: 1,
                                    swipe_max_touches: 1,
                                    drag_block_vertical: false,


                                    parallax:"mouse",
                                    parallaxBgFreeze:"on",
                                    parallaxLevels:[8,7,6,5,4,3,2,1],
                                    parallaxDisableOnMobile:"on",


                                    keyboardNavigation:"on",

                                    navigationHAlign:"center",
                                    navigationVAlign:"bottom",
                                    navigationHOffset:0,
                                    navigationVOffset:20,

                                    soloArrowLeftHalign:"left",
                                    soloArrowLeftValign:"center",
                                    soloArrowLeftHOffset:20,
                                    soloArrowLeftVOffset:0,

                                    soloArrowRightHalign:"right",
                                    soloArrowRightValign:"center",
                                    soloArrowRightHOffset:20,
                                    soloArrowRightVOffset:0,

                                    shadow:0,
                                    fullWidth:"off",
                                    fullScreen:"on",

                                    spinner:"spinner3",

                                    stopLoop:"off",
                                    stopAfterLoops:-1,
                                    stopAtSlide:-1,

                                    shuffle:"off",

                                    forceFullWidth:"off",
                                    fullScreenAlignForce:"off",
                                    minFullScreenHeight:"400",

                                    hideThumbsOnMobile:"off",
                                    hideNavDelayOnMobile:1500,
                                    hideBulletsOnMobile:"off",
                                    hideArrowsOnMobile:"off",
                                    hideThumbsUnderResolution:0,

                                    hideSliderAtLimit:0,
                                    hideCaptionAtLimit:0,
                                    hideAllCaptionAtLilmit:0,
                                    startWithSlide:0,
                                    fullScreenOffsetContainer: ".header"
                                });

                        apiRevoSlider.bind("revolution.slide.onchange",function (e,data) {
                            if( $(window).width() > 992 ) {
                                if( $('#slider ul > li').eq(data.slideIndex-1).hasClass('light') ){
                                    $('#header:not(.sticky-header)').addClass('light');
                                } else {
                                    $('#header:not(.sticky-header)').removeClass('light');
                                }
                                MINOVATE.header.chooseLogo();
                            }
                        });

                    }); //ready

                </script>

            </div>
            <!-- END REVOLUTION SLIDER -->


        </section><!-- #slider end -->

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