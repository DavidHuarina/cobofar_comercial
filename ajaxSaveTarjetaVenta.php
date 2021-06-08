<?php
$estilosVenta=1;
require('conexionmysqli2.inc');
$codigo=$_GET['codigo'];
$nro_tarjeta=$_GET['nro_tarjeta'];
$monto_tarjeta=$_GET['monto_tarjeta'];
$banco_tarjeta=$_GET['banco_tarjeta'];
$sql_tarjeta="INSERT INTO tarjetas_salidas (nro_tarjeta,monto,cod_banco,cod_salida_almacen,estado) VALUES('$nro_tarjeta','$monto_tarjeta','$banco_tarjeta','$codigo',1)";
$sql_tarjeta=mysqli_query($enlaceCon,$sql_tarjeta);
$sql_Update="UPDATE salida_almacenes SET cod_tipopago=2 WHERE cod_salida_almacenes='$codigo'";
$resp=mysqli_query($enlaceCon,$sql_Update);
?>