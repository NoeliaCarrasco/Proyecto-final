<?php

$connection->query("CREATE TABLE `categorias` (
  `IDCATEGORIA` int(11) NOT NULL,
  `NOMBRE` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");


$connection->query("INSERT INTO `categorias` (`IDCATEGORIA`, `NOMBRE`) VALUES
(3, 'CHANDAL'),
(4, 'BOTAS FUTBOL'),
(5, 'BOTINES'),
(7, 'CARTERAS'),
(8, 'MOCHILAS'),
(9, 'SUDADERAS');");


$connection->query("CREATE TABLE `detallespedido` (
  `IDPRODUCTO` int(11) DEFAULT NULL,
  `IDPEDIDO` int(11) DEFAULT NULL,
  `CANTIDAD` int(11) NOT NULL,
  `IMPORTE` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");


$connection->query("CREATE TABLE `facturas` (
  `IDFACTURA` int(11) NOT NULL,
  `FECHA` date NOT NULL,
  `TOTAL` float NOT NULL,
  `IDPEDIDO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");


$connection->query("CREATE TABLE `pedidos` (
  `IDPEDIDO` int(11) NOT NULL,
  `FECHA_ALTA` date NOT NULL,
  `IDUSUARIO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");


$connection->query("CREATE TABLE `productos` (
  `IDPRODUCTO` int(11) NOT NULL,
  `NOMBRE` varchar(25) NOT NULL,
  `PRECIO` decimal(6,2) NOT NULL,
  `STOCK` int(11) NOT NULL,
  `FOTO` varchar(25) NOT NULL,
  `IDCATEGORIA` int(11) DEFAULT NULL,
  `DESCRIPCION` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");


$connection->query("INSERT INTO `productos` (`IDPRODUCTO`, `NOMBRE`, `PRECIO`, `STOCK`, `FOTO`, `IDCATEGORIA`, `DESCRIPCION`) VALUES
(25, 'gris', '30.00', 50, '01_27_35.jpg', 2, ''),
(26, 'verde', '35.00', 49, '01_27_63.jpg', 2, ''),
(27, 'adidas', '35.00', 50, '01_27_64.jpg', 2, ''),
(29, 'nike', '40.00', 50, '01_27_66.jpg', 3, ''),
(30, 'azul', '40.00', 50, '01_27_65.jpg', 3, ''),
(31, 'nike', '60.00', 50, '01_27_72.jpg', 4, ''),
(32, 'adidas', '55.00', 49, '01_27_71.jpg', 4, ''),
(33, 'verde limon', '50.00', 50, '01_27_73.jpg', 4, ''),
(34, 'airmax', '70.00', 50, '01_27_355.jpg', 5, ''),
(35, 'rosa', '40.00', 50, '01_27_353.jpg', 5, ''),
(36, 'negro', '40.00', 50, '01_27_357.jpg', 5, ''),
(37, 'negra', '10.00', 50, '01_27_77.jpg', 7, ''),
(38, 'nike', '10.00', 50, '01_27_78.jpg', 7, ''),
(39, 'funda', '10.00', 50, '01_27_79.jpg', 7, ''),
(40, 'fucsia', '25.00', 50, '01_27_80.jpg', 8, ''),
(41, 'roxy', '35.00', 50, '01_27_82.jpg', 8, ''),
(42, 'teent', '25.00', 50, '01_27_81.jpg', 8, ''),
(43, 'gris', '30.00', 50, '01_27_35.jpg', 9, ''),
(44, 'adida', '35.00', 50, '01_27_64.jpg', 9, ''),
(45, 'verde', '30.00', 50, '01_27_63.jpg', 9, ''),
(46, 'blanco', '45.00', 50, '01_27_67.jpg', 3, '');");


$connection->query("CREATE TABLE `usuarios` (
  `IDUSUARIO` int(11) NOT NULL,
  `NOMBRE` varchar(25) NOT NULL,
  `APELLIDO` varchar(25) NOT NULL,
  `ROL` int(11) NOT NULL,
  `TIPO` varchar(20) NOT NULL,
  `USUARIO` varchar(25) NOT NULL,
  `PASSWORD` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");


$connection->query("INSERT INTO `usuarios` (`IDUSUARIO`, `NOMBRE`, `APELLIDO`, `ROL`, `TIPO`, `USUARIO`, `PASSWORD`) VALUES
(17, 'noelia', 'carrasco', 2, 'Administrador', 'noelia', '81dc9bdb52d04dc20036dbd8313ed055'),
(18, 'jose', 'jose', 1, 'Cliente', 'jose', '202cb962ac59075b964b07152d234b70'),
(19, 'manuel', 'manuel', 1, 'Cliente', 'manuel', '202cb962ac59075b964b07152d234b70');");


$connection->query("ALTER TABLE `categorias`
  ADD PRIMARY KEY (`IDCATEGORIA`);");


$connection->query("ALTER TABLE `detallespedido`
  ADD KEY `DETALLES1` (`IDPRODUCTO`),
  ADD KEY `DETALLES2` (`IDPEDIDO`);");


$connection->query("ALTER TABLE `facturas`
  ADD PRIMARY KEY (`IDFACTURA`),
  ADD KEY `facturas_ibfk_1` (`IDPEDIDO`);");


$connection->query("ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`IDPEDIDO`),
  ADD KEY `IDUSUARIO` (`IDUSUARIO`);");


$connection->query("ALTER TABLE `productos`
  ADD PRIMARY KEY (`IDPRODUCTO`),
  ADD KEY `productos_ibfk_1` (`IDCATEGORIA`);");


$connection->query("ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`IDUSUARIO`);");


$connection->query("ALTER TABLE `categorias`
  MODIFY `IDCATEGORIA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;");

$connection->query("ALTER TABLE `pedidos`
  MODIFY `IDPEDIDO` int(11) NOT NULL AUTO_INCREMENT;");

$connection->query("ALTER TABLE `productos`
  MODIFY `IDPRODUCTO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;");

$connection->query("ALTER TABLE `usuarios`
  MODIFY `IDUSUARIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;");

$connection->query("ALTER TABLE `detallespedido`
  ADD CONSTRAINT `DETALLES1` FOREIGN KEY (`IDPRODUCTO`) REFERENCES `productos` (`IDPRODUCTO`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `DETALLES2` FOREIGN KEY (`IDPEDIDO`) REFERENCES `pedidos` (`IDPEDIDO`) ON DELETE SET NULL ON UPDATE CASCADE;");

$connection->query("ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`IDUSUARIO`) REFERENCES `usuarios` (`IDUSUARIO`) ON DELETE SET NULL ON UPDATE CASCADE;");

 ?>