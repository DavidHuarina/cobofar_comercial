<?php

require("conexion.inc");
require("estilos.inc");

$nombre=$_POST["nombre"];
$abrev=$_POST["abreviatura"];
$sql="select max(codigo)+1 from principios_activos";
$resp=mysql_query($sql);
$codigo=mysql_result($resp,0,0);

$sql_inserta=mysql_query("insert into principios_activos values($codigo,'$nombre',1,'$abrev')");

echo "<script language='Javascript'>
			alert('El proceso se completo correctamente.');
			location.href='navegador_principiosact.php';
			</script>";
?>