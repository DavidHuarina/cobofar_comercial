<?php
error_reporting(0);
//header('Content-Type: text/html; charset=UTF-8'); 
if(!function_exists('register_globals')){
	include('register_globals.php');
	register_globals();
}else{
}
$conexion=mysql_connect("localhost","root","");
$bd=mysql_select_db("farmaciascomercial");

$sqlX="SET NAMES 'utf8'";
mysql_query($sqlX);
?>
