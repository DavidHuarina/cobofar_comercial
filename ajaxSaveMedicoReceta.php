<?php
$estilosVenta=1;
require('conexionmysqli2.inc');
$codigo=$_GET['codigo'];
$cod_medico=$_GET['cod_medico'];
$sql_medico="DELETE FROM recetas_salidas where cod_salida_almacen='$codigo'";
mysqli_query($enlaceCon,$sql_medico);

$sql_medico="INSERT INTO recetas_salidas (cod_salida_almacen,cod_medico) VALUES('$codigo','$cod_medico')";
$sql_medico=mysqli_query($enlaceCon,$sql_medico);
?>