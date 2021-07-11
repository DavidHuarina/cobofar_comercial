<?php
$estilosVenta=1;
require('conexionmysqli2.inc');
$codigo=$_GET['codigo'];
$sqlDolares="UPDATE salida_almacenes SET monto_cancelado_usd=0,monto_cancelado_bs=monto_final,monto_cambio=0,monto_efectivo=monto_final
where cod_salida_almacenes=$codigo;";
mysqli_query($enlaceCon,$sqlDolares);
?>