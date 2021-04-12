<?php

require("conexion.inc");
require("estilos.inc");

$codigo=$_POST["codigo"];
$nombre=$_POST["nombre"];
$abrev=$_POST["abreviatura"];

$sql="update principios_activos set nombre='$nombre',abreviatura='$abrev' where codigo='$codigo'";
$resp=mysql_query($sql);

echo "<script language='Javascript'>
			alert('El proceso se completo correctamente.');
			location.href='navegador_principiosact.php';
			</script>";
			
?>