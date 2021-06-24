<?php
	require("conexionmysqli.inc");
	require('estilos.inc');
	
	$global_almacen=$_COOKIE['global_almacen'];
	$codigo_salida=$_GET['codigo_salida'];
	$almacen_origen=$_GET['almacen_origen'];
	
	$sql="select s.cod_ingreso_almacen, s.fecha, ts.nombre_tipoingreso, s.observaciones, s.nro_correlativo,s.nota_entrega
	FROM ingreso_pendientes_almacenes s, tipos_ingreso ts
	where s.cod_tipoingreso=ts.cod_tipoingreso and s.cod_almacen='$global_almacen' and s.cod_ingreso_almacen='$codigo_salida'";
	//echo $sql;
	
	$resp=mysqli_query($enlaceCon,$sql);
	echo "<h1>Detalle de Ingreso por Traspaso Central</h1>";
	
	echo "<center><table class='texto'>";
	echo "<tr><th>Nro</th><th>Nro. Doc K</th><th>Fecha</th><th>Tipo de Salida (Almacen Origen)</th><th>Observaciones</th></tr>";
	$dat=mysqli_fetch_array($resp);
	$codigo=$dat[0];
	$fecha_salida=$dat[1];
	$fecha_salida_mostrar="$fecha_salida[8]$fecha_salida[9]-$fecha_salida[5]$fecha_salida[6]-$fecha_salida[0]$fecha_salida[1]$fecha_salida[2]$fecha_salida[3]";
	$nombre_tiposalida=$dat[2];
	$obs_salida=$dat[3];
	$nro_correlativo=$dat[4];
	$nota_entrega=$dat['nota_entrega'];
	echo "<tr><td align='center'>$nro_correlativo</td><td align='center'>$nota_entrega</td><td align='center'>$fecha_salida_mostrar</td><td>$nombre_tiposalida</td><td>&nbsp;$obs_salida</td></tr>";
	echo "</table><br>";
	
	echo "<table class='table table-striped table-success'>";
	echo "<tr>
	<th>Codigo</th><th>Material</th><th>Cantidad</th><th>Orden</th></tr>";
	echo "<form method='post' action=''>";
	$sql_detalle="select s.cod_material, s.cantidad_unitaria,s.orden from ingreso_pendientes_detalle_almacenes s 
	where s.cod_ingreso_almacen='$codigo_salida' order by s.orden";
	$resp_detalle=mysqli_query($enlaceCon,$sql_detalle);
	while($dat_detalle=mysqli_fetch_array($resp_detalle))
	{	$cod_material=$dat_detalle[0];
		$cantidad_unitaria=$dat_detalle[1];
		$cantidad_unitaria_formato=number_format($dat_detalle[1],0,'.',',');
		$sql_nombre_material="select descripcion_material from material_apoyo where codigo_material='$cod_material'";
        $orden=$dat_detalle["orden"];
		$resp_nombre_material=mysqli_query($enlaceCon,$sql_nombre_material);
		$dat_nombre_material=mysqli_fetch_array($resp_nombre_material);
		$nombre_material=$dat_nombre_material[0];
		echo "<tr>
		<td>$cod_material</td>
		<td>$nombre_material</td><td align='center'>$cantidad_unitaria_formato</td><td class='text-muted'><small>$orden</small></td></tr>";
	}
	echo "</table></center>";

?>