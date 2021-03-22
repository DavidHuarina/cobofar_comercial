<html>
<head>
	<meta charset="utf-8" />
	<title>Farmacias Bolivia</title>
</head>
<?php
$estilosVenta=1;
require('estilos_reportes_almacencentral.php');
require('conexionmysqli.inc');
require('function_formatofecha.php');
require('funciones.php');
$rpt_almacen=implode(",",json_decode($rpt_territorio));
$fecha_reporte=date("d/m/Y");
$txt_reporte="Fecha de Reporte <strong>$fecha_reporte</strong>";
$sql_tipo_ingreso="select nombre_tipoingreso from tipos_ingreso where cod_tipoingreso='$tipo_ingreso'";
$resp_tipo_ingreso=mysqli_query($enlaceCon,$sql_tipo_ingreso);
$datos_tipo_ingreso=mysqli_fetch_array($resp_tipo_ingreso);
$nombre_tipoingreso=$datos_tipo_ingreso[0];

if($periodo==1){
	$titulo_perido="24 Hrs.";
}else if($periodo==2){
	$titulo_perido="48 Hrs.";
}else{
	$titulo_perido="> 2 días";
}

if($filtro==1){
	$sqlFiltro="where l.atiempo>0";
}else{
	$sqlFiltro="";
}

	echo "<h1>Verificación de Tiempos en Traspasos $titulo_perido</h1>
	<h1>$nombre_tipoingresomostrar Fecha inicio: <strong>$fecha_ini</strong> Fecha final: <strong>$fecha_fin</strong><br>$txt_reporte</h1>";

	//desde esta parte viene el reporte en si
	$fecha_iniconsulta=$fecha_ini;	
	$fecha_finconsulta=$fecha_fin;

	$sql="SELECT l.* FROM ((select i.cod_ingreso_almacen, CONCAT(i.fecha,' ',i.hora_ingreso) as fecha_ingreso, ti.nombre_tipoingreso, i.observaciones, i.nota_entrega, i.nro_correlativo, i.ingreso_anulado,(SELECT CONCAT(fecha,' ',hora_salida) FROM salida_almacenes where cod_salida_almacenes=i.cod_salida_almacen) as fecha_salida,0 as central,(SELECT IFNULL(cod_almacen,0) FROM salida_almacenes where cod_salida_almacenes=i.cod_salida_almacen and CONCAT(fecha,' ',hora_salida)>DATE_SUB(CONCAT(i.fecha,' ',i.hora_ingreso), INTERVAL $periodo DAY)) as atiempo
		FROM ingreso_almacenes i, tipos_ingreso ti
		where i.cod_tipoingreso=ti.cod_tipoingreso and i.cod_almacen in ($rpt_almacen) and i.fecha>='$fecha_iniconsulta'
		and i.fecha<='$fecha_finconsulta' and i.ingreso_anulado=0 and (i.cod_salida_almacen_central=0 or i.cod_salida_almacen_central is null)
		order by i.nro_correlativo)
		UNION (select i.cod_ingreso_almacen, CONCAT(i.fecha,' ',i.hora_ingreso) as fecha_ingreso, ti.nombre_tipoingreso, i.observaciones, i.nota_entrega, i.nro_correlativo, i.ingreso_anulado,(SELECT CONCAT(fecha,' ',hora_ingreso) FROM ingreso_pendientes_almacenes where cod_ingreso_almacen=i.cod_salida_almacen_central) as fecha_salida,1 as central,(SELECT IFNULL(cod_almacen,0) FROM ingreso_pendientes_almacenes where cod_ingreso_almacen=i.cod_salida_almacen_central and CONCAT(fecha,' ',hora_ingreso)>DATE_SUB(CONCAT(i.fecha,' ',i.hora_ingreso), INTERVAL $periodo DAY)) as atiempo
	FROM ingreso_almacenes i, tipos_ingreso ti
	where i.cod_tipoingreso=ti.cod_tipoingreso and i.cod_almacen in ($rpt_almacen) and i.fecha>='$fecha_iniconsulta' and i.fecha<='$fecha_finconsulta' and i.ingreso_anulado=0 and (i.cod_salida_almacen=0 or i.cod_salida_almacen is null)
	order by i.nro_correlativo)) l $sqlFiltro order by l.fecha_ingreso desc;";
	//echo $sql;
	$resp=mysqli_query($enlaceCon,$sql);
	echo "<p>Los Traspasos Ingresados fuera de las $titulo_perido Están marcados con <b style='color:#FF5733'>color rojo</b><p>";
	echo "<center><br><table class='texto' width='100%'>";
	echo "<tr class='textomini'><th>Nro.</th><th>Nota de Entrega</th><th>Fecha Salida</th><th>Fecha Ingreso</th><th>Tiempo Transcurrido</th><th>Tipo de Ingreso</th><th>Observaciones</th><th>Estado</th><th>Desde</th></tr>";
	$index=0;
	while($dat=mysqli_fetch_array($resp))
	{
		$index++;
		$codigo=$dat[0];
		$fecha_ingreso=$dat[1];
		$fecha_ingreso_mostrar=strftime('%d-%m-%Y %H:%M',strtotime($dat[1]));
		$fecha_salida_mostrar=strftime('%d-%m-%Y %H:%M',strtotime($dat[7]));
		$nombre_tipoingreso=$dat[2];
		$obs_ingreso=$dat[3];
		$nota_entrega=$dat[4];
		$nro_correlativo=$dat[5];
		$anulado=$dat[6];
		echo "<input type='hidden' name='fecha_ingreso$nro_correlativo' value='$fecha_ingreso_mostrar'>";
		$bandera=0;
		$sql_verifica_movimiento="select s.cod_salida_almacenes from salida_almacenes s, salida_detalle_ingreso sdi
		where s.cod_salida_almacenes=sdi.cod_salida_almacen and s.salida_anulada=0 and sdi.cod_ingreso_almacen='$codigo'";
		$resp_verifica_movimiento=mysqli_query($enlaceCon,$sql_verifica_movimiento);
		$num_filas_movimiento=mysqli_num_rows($resp_verifica_movimiento);
		if($num_filas_movimiento!=0)
		{	$estado_ingreso="Con Movimiento";
		}
		if($anulado==1)
		{	$estado_ingreso="Anulado";
		}
		if($num_filas_movimiento==0 and $anulado==0)
		{	$estado_ingreso="Sin Movimiento";
		}
		//desde esta parte sacamos el detalle del ingreso
		$sql_detalle="select i.cod_material, i.cantidad_unitaria from ingreso_detalle_almacenes i
		where i.cod_ingreso_almacen='$codigo'";
		$resp_detalle=mysqli_query($enlaceCon,$sql_detalle);
		$bandera=0;
		
        $detalle_ingreso=obtenerNombreCiudadPorAlmacen($dat[9]);
		/*$detalle_ingreso="";
		$detalle_ingreso.="<table border=1 cellspacing='0' align='center' class='textomini' width='100%'>";
		$detalle_ingreso.="<tr><th width='70%'>Material</th><th width='30%'>Cantidad</th></tr>";
		$numFilas=mysqli_num_rows($resp_detalle);
		if($numFilas>0){
			while($dat_detalle=mysqli_fetch_array($resp_detalle))
			{	$cod_material=$dat_detalle[0];
				$cantidad_unitaria=$dat_detalle[1];
				$cantidad_unitaria=redondear2($cantidad_unitaria);
				if($tipo_item==1)
				{	$sql_nombre_material="select descripcion, presentacion from muestras_medicas where codigo='$cod_material'";
				}
				else
				{	$sql_nombre_material="select descripcion_material from material_apoyo where codigo_material='$cod_material'";
				}
				$resp_nombre_material=mysqli_query($enlaceCon,$sql_nombre_material);
				$dat_nombre_material=mysqli_fetch_array($resp_nombre_material);
				$nombre_material=$dat_nombre_material[0];
				$presentacion=$dat_nombre_material[1];
				$detalle_ingreso.="<tr><td>$nombre_material $presentacion</td><td align='center'>$cantidad_unitaria</td></tr>";
			}
		}*/
		//$detalle_ingreso.="</table>";		
		if($dat[8]==1){
			$detalle_ingreso="ALMACEN CENTRAL";
		}
		$color_fondo="#000";
		if($dat[9]==0){
			$color_fondo="#FF5733";
		}
		$date1 = new DateTime($dat[7]);
        $date2 = new DateTime($dat[1]);
        $diff = $date1->diff($date2);
        // will output 2 days
        $hora_rest=$diff->days;
		if($rpt_linea==0)
		{	echo "<tr style='color:$color_fondo'><td align='center'>$index</td><td align='center'>&nbsp;$nota_entrega</td><td align='center'>$fecha_salida_mostrar</td><td align='center'>$fecha_ingreso_mostrar</td><td align='center'>$hora_rest Días</td><td>$nombre_tipoingreso</td><td>&nbsp;$obs_ingreso</td><td>&nbsp;$estado_ingreso</td><td align='center'>$detalle_ingreso</td></tr>";
		}
		if($rpt_linea!=0 and $bandera==1)
		{	echo "<tr style='color:$color_fondo'><td align='center'>$nro_correlativo</td><td align='center'>&nbsp;$nota_entrega</td><td align='center'>$fecha_salida_mostrar</td><td align='center'>$fecha_ingreso_mostrar</td><td align='center'>$hora_rest Días</td><td>$nombre_tipoingreso</td><td>&nbsp;$obs_ingreso</td><td>&nbsp;$estado_ingreso</td><td align='center'>$detalle_ingreso</td></tr>";
		}
	}
	echo "</table></center><br>";
?>