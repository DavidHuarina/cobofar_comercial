<?php
ob_start();
error_reporting(0);
require('estilos_reportes.php');
require('function_formatofecha.php');
require('conexionmysqli2.inc');
require('funcion_nombres.php');
require('funciones.php');
?>
<style type="text/css">
body{
	font-size:9px !important;
}
.tabla_detalle td, .tabla_detalle th {
    padding-top: 7px;
    padding-bottom: 6px;
    /*border-bottom: 1px solid #f2f2f2; */
   /* border-style: dashed; border-width: 1px;   */
   border-top: 1px dashed black;
   border-bottom: 1px dashed black;
   font-size:8px !important;
}

.tabla_detalle tbody tr:nth-child(even) {
    background: white;
    -webkit-box-shadow: 0 1px 0 rgba(255,255,255,.8) inset; 
    -moz-box-shadow:0 1px 0 rgba(255,255,255,.8) inset;  
    box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;        
}

.tabla_detalle th {
    text-shadow: 0 1px 0 rgba(255,255,255,1); 
    border-top: 1px dashed black;
    border-bottom: 1px dashed black;
    background-color: white;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#f5f5f5), to(#eee));
    background-image: -webkit-linear-gradient(top, #f5f5f5, #eee);
    background-image:    -moz-linear-gradient(top, #f5f5f5, #eee);
    background-image:     -ms-linear-gradient(top, #f5f5f5, #eee);
    background-image:      -o-linear-gradient(top, #f5f5f5, #eee); 
    background-image:         linear-gradient(top, #f5f5f5, #eee);
}

.tabla_detalle th:first-child {
    -moz-border-radius: 6px 0 0 0;
    -webkit-border-radius: 6px 0 0 0;
    border-radius: 6px 0 0 0;  
}

.tabla_detalle th:last-child {
    -moz-border-radius: 0 6px 0 0;
    -webkit-border-radius: 0 6px 0 0;
    border-radius: 0 6px 0 0;
}

.tabla_detalle th:only-child{
    -moz-border-radius: 6px 6px 0 0;
    -webkit-border-radius: 6px 6px 0 0;
    border-radius: 6px 6px 0 0;
}

.tabla_detalle tfoot td {
    border-bottom: 0;
    border-top: 1px solid #fff;
    background-color: #f1f1f1;  
}

.tabla_detalle tfoot td:first-child {
    -moz-border-radius: 0 0 0 6px;
    -webkit-border-radius: 0 0 0 6px;
    border-radius: 0 0 0 6px;
}

.tabla_detalle tfoot td:last-child {
    -moz-border-radius: 0 0 6px 0;
    -webkit-border-radius: 0 0 6px 0;
    border-radius: 0 0 6px 0;
}

.tabla_detalle tfoot td:only-child{
    -moz-border-radius: 0 0 6px 6px;
    -webkit-border-radius: 0 0 6px 6px
    border-radius: 0 0 6px 6px
}
</style>
<?php
$fechaImp=date("d/m/Y");
$horaImp=date("H:i");
	$sqlEmpresa="select nombre, nit, direccion from datos_empresa";
	$respEmpresa=mysqli_query($enlaceCon,$sqlEmpresa);
	$nombreEmpresa=mysqli_result($respEmpresa,0,0);
	$nitEmpresa=mysqli_result($respEmpresa,0,1);
	$direccionEmpresa=mysqli_result($respEmpresa,0,2);
	$codigo_salida=$_GET["codigo_salida"];
	$global_almacen=$_COOKIE["global_almacen"];
	$sql="select s.cod_salida_almacenes, s.fecha, ts.nombre_tiposalida, s.observaciones,
	s.nro_correlativo, s.territorio_destino, s.almacen_destino, (select c.nombre_cliente from clientes c where c.cod_cliente=s.cod_cliente),
	(select c.dir_cliente from clientes c where c.cod_cliente=s.cod_cliente),
	s.monto_total, s.descuento, s.monto_final,(select c.nit_cliente from clientes c where c.cod_cliente=s.cod_cliente),(select c.nombre_almacen from almacenes c where c.cod_almacen=s.cod_almacen)nombre_almacen,(select c.nombre_almacen from almacenes c where c.cod_almacen=s.almacen_destino)nombre_almacen_destino
	FROM salida_almacenes s, tipos_salida ts
	where s.cod_tiposalida=ts.cod_tiposalida and s.cod_almacen='$global_almacen' and s.cod_salida_almacenes='$codigo_salida'";
	//echo $sql;
	$resp=mysqli_query($enlaceCon,$sql);
	$dat=mysqli_fetch_array($resp);
	$codigo=$dat[0];
	$fecha_salida=$dat[1];
	$fecha_salida_mostrar="$fecha_salida[8]$fecha_salida[9]/$fecha_salida[5]$fecha_salida[6]/$fecha_salida[0]$fecha_salida[1]$fecha_salida[2]$fecha_salida[3]";
	$nombre_tiposalida=$dat[2];
	$obs_salida=$dat[3];
	$nro_correlativo=$dat[4];
	$territorio_destino=$dat[5];
	$almacen_destino=$dat[6];
	$nombreCliente=$dat[7];
	$nitCliente=$dat[12];
	$direccionCliente=$dat[8];
	$montoNota=$dat[9];
	$montoNota=redondear2($montoNota);
	$descuentoNota=$dat[10];
	$descuentoNota=redondear2($descuentoNota);
	$montoFinal=$dat[11];
	$montoFinal=redondear2($montoFinal);
	$nombreAlmacen=$dat['nombre_almacen'];
    $nombreAlmacenDestino=$dat['nombre_almacen_destino'];
		
	echo "<table class='' width='100%'>";
	echo "<tr><th align='left' width='30%' valign='top'>$nombreEmpresa</th>
	<th align='center' width='30%'><br>MOVIMIENTO DE STOCK -  ENVIO ENTRE ALMACENES<br>Sucursal:  $nombreAlmacen</th>
	<td align='right' width='30%' valign='top' >Fecha Impresion: $fechaImp <br> Hora Impresion: $horaImp</td>
	</tr>";
	
	echo "<tr><th align='left' class='bordeNegroTdMod'>N°: S - $nro_correlativo</th>
	<td align='center' class='bordeNegroTdMod'><br>Fecha: $fecha_salida_mostrar</td><td align='right'>Almacén : $nombreAlmacenDestino</td></tr>";
			
	echo "</table><br>";

	echo "<table class='tabla_detalle' cellspacing='0' width='100%' align='center'>";
	
	echo "<tr><th align='left'>Código</th><th align='left'>Descripción</th><th align='right'>Cant.</th>
	<th align='right'>Sueltas</th><th align='right'>Precio</th><th align='right'>P. Unita</th>
		<th align='right'>Lote</th><th align='right'>Fec.Venc.</th><th align='right'>Registro</th><th align='right'>Proveedor</th></tr>";
	
	echo "</tr>";
	echo "<form method='post' action=''>";
	
	$sql_detalle="select s.cod_material, m.descripcion_material, s.lote, s.fecha_vencimiento, 
		s.cantidad_unitaria, s.precio_unitario, s.`descuento_unitario`, s.`monto_unitario`,s.cantidad_envase,(SELECT nombre_proveedor FROM proveedores where cod_proveedor=(SELECT cod_proveedor FROM proveedores_lineas where cod_linea_proveedor=m.cod_linea_proveedor))nombre_proveedor 
		from salida_detalle_almacenes s, material_apoyo m
		where s.cod_salida_almacen='$codigo' and s.cod_material=m.codigo_material";
	//echo $sql_detalle;
	$resp_detalle=mysqli_query($enlaceCon,$sql_detalle);
	$indice=0;
	$montoTotal=0;
	$pesoTotal=0;

	while($dat_detalle=mysqli_fetch_array($resp_detalle))
	{	$cod_material=$dat_detalle[0];
		$nombre_material=$dat_detalle[1];
		$loteProducto=$dat_detalle[2];
		$fechaVencimiento=$dat_detalle[3];
		$cantidad_unitaria=$dat_detalle[4];
		$cantidad_envase=$dat_detalle['cantidad_envase'];
		if($cantidad_envase!=""){
			$cantidad_envase=number_format($cantidad_envase,0,'.','');
		}else{
			$cantidad_envase=0;
		}
		if($cantidad_unitaria!=""){
			$cantidad_unitaria=number_format($cantidad_unitaria,0,'.','');
		}else{
			$cantidad_unitaria=0;
		}
		$precioUnitario=$dat_detalle[5];
		$precioUnitario=redondear2($precioUnitario);
		$descuentoUnitario=$dat_detalle[6];
		$descuentoUnitario=redondear2($descuentoUnitario);
		$montoUnitario=$dat_detalle[7];
		$montoUnitario=redondear2($montoUnitario);
		$nombreProveedor=$dat_detalle['nombre_proveedor'];
		echo "<tr class=''>
		<td align='left'>$cod_material</td>
		<td align='left'>$nombre_material</td>
		<td align='right'>$cantidad_envase</td>
		<td align='right'>$cantidad_unitaria</td>
		<td align='right'>$montoUnitario</td>
		<td align='right'>$precioUnitario</td>
			<td align='right' class=''>$loteProducto</td>
			<td align='right' class=''>$fechaVencimiento</td>
			<td align='right'></td>
			<td class='' align='right'>$nombreProveedor</td></tr>";
		$indice++;
		$montoTotal=$montoTotal+$montoUnitario;
		$montoTotal=redondear2($montoTotal);
	
	}
	
	/*for($j=$indice; $j<=15; $j++){
		echo "<tr><td>&nbsp;</td>
			<td align='center'>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td><td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align='center'>-</td></tr>";
	}*/
	
	echo "</table><br><br><br><br><br><br><br><br><br>";
	echo "<div><table width='90%'>
	<tr class='bordeNegroTdMod'><td width='25%' align='center'>-----------------------------------<br>Entregue Conforme<br><br><br><br><br>Nombre Completo</td><td width='25%' align='center'>-----------------------------------<br>Recibi Conforme<br><br><br><br><br>Nombre Completo</td><td width='25%' align='center'>-----------------------------------<br>Autorización<br><br><br><br><br>Nombre Completo</td><td width='25%' align='center'>-----------------------------------<br>Introducido al Sistema<br><br><br><br><br>Nombre Completo</td></tr>
	</table></div>";


$rpt_territorio=$_GET['rpt_territorio'];
$rpt_funcionario=$_GET['rpt_funcionario'];
$fecha_ini=$_GET['fecha_ini'];
$fecha_fin=$_GET['fecha_fin'];
$hora_ini=$_GET['hora_ini'];
$hora_fin=$_GET['hora_fin'];
$variableAdmin=$_GET["variableAdmin"];
if($variableAdmin!=1){
	$variableAdmin=0;
}


$fecha_iniconsulta=$fecha_ini;
$fecha_iniconsultahora=$fecha_iniconsulta." ".$hora_ini.":00";
$fecha_finconsultahora=$fecha_fin." ".$hora_fin.":59";
$fecha_reporte=date("d/m/Y");
$montoCajaChica=0;

$html = ob_get_clean();
descargarPDFControlado("CONTROLADO ",$html);	
?>



