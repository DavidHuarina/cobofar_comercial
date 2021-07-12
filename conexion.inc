<?php
//error_reporting(0);
//header('Content-Type: text/html; charset=UTF-8'); 
if(!function_exists('register_globals')){
	include('register_globals.php');
	register_globals();
}else{
}
$conexion=mysqli_connect("p:127.0.0.1","root","");
//$conexion=mysql_connect("p:10.10.1.11","lunita@10.10.1.155","4868422Marco$");
$bd=mysql_select_db("farmaciascomercial");

$sqlX="SET NAMES 'utf8'";
mysql_query($sqlX);
?>
