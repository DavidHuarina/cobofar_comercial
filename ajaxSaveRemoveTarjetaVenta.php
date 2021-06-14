<?php
$estilosVenta=1;
require('conexionmysqli2.inc');
$codigo=$_GET['codigo'];
$sql_tarjeta="DELETE FROM tarjetas_salidas WHERE cod_salida_almacen='$codigo'";
$sql_tarjeta=mysqli_query($enlaceCon,$sql_tarjeta);
$sql_Update="UPDATE salida_almacenes SET cod_tipopago=1 WHERE cod_salida_almacenes='$codigo'";
$resp=mysqli_query($enlaceCon,$sql_Update);
?>