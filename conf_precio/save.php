<?php
require("../conexionmysqli.inc");
require("../estilos2.inc");
require("configModule.php");

$fecha_ini=$fecha_ini;
$fecha_fin=$fecha_fin;
$hora_ini=$hora_ini;
$hora_fin=$hora_fin;
$fecha_hora_ini=$fecha_ini." ".$hora_ini;
$fecha_hora_fin=$fecha_fin." ".$hora_fin;

$sql="SELECT IFNULL(max(codigo)+1,1) FROM $table";
$resp=mysqli_query($enlaceCon,$sql);
$codigo=mysqli_result($resp,0,0);

$sql="insert into $table (codigo,nombre, abreviatura,desde,hasta, estado) values($codigo,'$nombre','$abreviatura','$fecha_hora_ini','$fecha_hora_fin','1')";
//echo $sql;
$sql_inserta=mysqli_query($enlaceCon,$sql);

echo "<script language='Javascript'>
			alert('Los datos fueron insertados correctamente.');
			location.href='$urlList2';
			</script>";

?>