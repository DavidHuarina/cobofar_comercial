<?php
header('Content-Type: text/html; charset=UTF-8'); 
date_default_timezone_set('America/La_Paz');

if(!function_exists('register_globals')){
	include('register_globals.php');
	register_globals();
}else{
}

$enlaceCon=mysqli_connect("p:10.10.1.221:8888","root","","farmacias");

if (mysqli_connect_errno())
{
	echo "Error en la conexión: " . mysqli_connect_error();
}
mysqli_set_charset($enlaceCon,"utf8");
?>