<?php
	require("conexionmysqli.inc");
	require('estilos.inc');
	require('funciones.php');
	
	$global_almacen=$_COOKIE['global_almacen'];
	$codigo_salida=$_GET['codigo_salida'];
	$almacen_origen=$_GET['almacen_origen'];
	
	$sql="select s.cod_salida_almacenes, s.fecha, ts.nombre_tiposalida, s.observaciones, s.nro_correlativo
	FROM salida_almacenes s, tipos_salida ts
	where s.cod_tiposalida=ts.cod_tiposalida and s.almacen_destino='$global_almacen' and s.cod_salida_almacenes='$codigo_salida'";
	//echo $sql;
	
	$resp=mysqli_query($enlaceCon,$sql);
	echo "<h1>Detalle de Ingreso en Transito</h1>";
	
	echo "<center><table class='texto'>";
	echo "<tr><th>Nro. Salida (Origen)</th><th>Fecha</th><th>Tipo de Salida (Almacen Origen)</th><th>Observaciones</th></tr>";
	$dat=mysqli_fetch_array($resp);
	$codigo=$dat[0];
	$fecha_salida=$dat[1];
	$fecha_salida_mostrar="$fecha_salida[8]$fecha_salida[9]-$fecha_salida[5]$fecha_salida[6]-$fecha_salida[0]$fecha_salida[1]$fecha_salida[2]$fecha_salida[3]";
	$nombre_tiposalida=$dat[2];
	$obs_salida=$dat[3];
	$nro_correlativo=$dat[4];
	echo "<tr><td align='center'>$nro_correlativo</td><td align='center'>$fecha_salida_mostrar</td><td>$nombre_tiposalida</td><td>&nbsp;$obs_salida</td></tr>";
	echo "</table><br>";
	
	echo "<table class='texto'>";
	echo "<tr><th>Codigo</th><th>Producto</th><th>Cantidad</th></tr>";
	echo "<form method='post' action=''>";
	$sql_detalle="select s.cod_material, sum(s.cantidad_unitaria),sum(s.cantidad_envase) from salida_detalle_almacenes s 
	where s.cod_salida_almacen='$codigo_salida' group by s.cod_material";
	$resp_detalle=mysqli_query($enlaceCon,$sql_detalle);
	while($dat_detalle=mysqli_fetch_array($resp_detalle))
	{	$cod_material=$dat_detalle[0];
		$cantidad_unitaria=$dat_detalle[1];
		$cantidad_envase=$dat_detalle[2];
		$cantidad_presentacion=obtenerCantidadPresentacionProducto($cod_material);
		$cantidadRecibido=($cantidad_presentacion*$cantidad_envase)+$cantidad_unitaria;
		$cantidad_unitaria_formato=number_format($cantidadRecibido,0,'.',',');
		$sql_nombre_material="select descripcion_material from material_apoyo where codigo_material='$cod_material'";

		$resp_nombre_material=mysqli_query($enlaceCon,$sql_nombre_material);
		$dat_nombre_material=mysqli_fetch_array($resp_nombre_material);
		$nombre_material=$dat_nombre_material[0];
		echo "<tr>
		<td>$codigo</td>
		<td>$nombre_material</td>
		<td align='center'>$cantidad_unitaria_formato</td></tr>";
	}
	echo "</table></center>";

?>