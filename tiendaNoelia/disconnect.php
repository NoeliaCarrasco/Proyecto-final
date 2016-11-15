<?php
	session_start();
	if(!isset($_SESSION['rol'])){header('location: login.php');}
	session_destroy();
	header('location: login.php');
?>
