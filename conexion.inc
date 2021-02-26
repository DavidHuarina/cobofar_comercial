<?php

//header('Content-Type: text/html; charset=UTF-8'); 
if(!function_exists('register_globals')){
	include('register_globals.php');
	register_globals();
}else{
}
$conexion=mysql_connect("127.0.0.1:8888","root","");
$bd=mysql_select_db("farmacias");

$sqlX="SET NAMES 'utf8'";
mysql_query($sqlX);
?>
