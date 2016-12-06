<?php
	session_start();
	$para      = 'noelia-besos-doce@hotmail.com';
	$titulo    = 'Contacto desde la web';
	$mensaje   = $_REQUEST['mensaje']."\n\n\nDe: ".$_REQUEST['nombre']."\n\nTelefono: ".$_REQUEST['telefono'];//En el campor mensaje coge lo que escribes al igual q en nombre y telefono
	$cabeceras = 'From: '.$_REQUEST['email'] . "\r\n" .
		'Reply-To:'.$_REQUEST['email']."\r\n" .
		'X-Mailer: PHP/' . phpversion();//el campo email aparece quien te lo envia y a quien respondes en este caso coge el mio

	mail($para, $titulo, $mensaje, $cabeceras);//coge lo que hay dentro de cada variable
	header('location: contact.php');
?>
