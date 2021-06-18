<?php

	require("conexionmysqli.inc");
	require('estilos_almacenes_central_sincab.php');
	require("funciones.php");
	require('funcion_nombres.php');

	$sqlEmpresa="select nombre, nit, direccion from datos_empresa";
	$respEmpresa=mysqli_query($enlaceCon,$sqlEmpresa);
	$nombreEmpresa=mysqli_result($respEmpresa,0,0);
	$nitEmpresa=mysqli_result($respEmpresa,0,1);
	$direccionEmpresa=mysqli_result($respEmpresa,0,2);
	
	
	$sql="select s.cod_salida_almacenes, s.fecha, ts.nombre_tiposalida, s.observaciones,
	s.nro_correlativo, s.territorio_destino, s.almacen_destino, (select c.nombre_cliente from clientes c where c.cod_cliente=s.cod_cliente),
	(select c.dir_cliente from clientes c where c.cod_cliente=s.cod_cliente),
	s.monto_total, s.descuento, s.monto_final,(select c.nit_cliente from clientes c where c.cod_cliente=s.cod_cliente),s.cod_chofer
	FROM salida_almacenes s, tipos_salida ts
	where s.cod_tiposalida=ts.cod_tiposalida and s.cod_almacen='$global_almacen' and s.cod_salida_almacenes='$codigo_salida'";
	$resp=mysqli_query($enlaceCon,$sql);
	$dat=mysqli_fetch_array($resp);
	$codigo=$dat[0];
	$fecha_salida=$dat[1];
	$fecha_salida_mostrar="$fecha_salida[8]$fecha_salida[9]-$fecha_salida[5]$fecha_salida[6]-$fecha_salida[0]$fecha_salida[1]$fecha_salida[2]$fecha_salida[3]";
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
    $cod_funcionario=$dat['cod_chofer'];


$nombreFuncionario=nombreVisitador($cod_funcionario);

$sqlDatosFactura="select d.nro_autorizacion, DATE_FORMAT(d.fecha_limite_emision, '%d/%m/%Y'), f.codigo_control, f.nit, f.razon_social, DATE_FORMAT(f.fecha, '%d/%m/%Y') from facturas_venta f, dosificaciones d
	where f.cod_dosificacion=d.cod_dosificacion and f.cod_venta=$codigo_salida";
//echo $sqlDatosFactura;
$respDatosFactura=mysqli_query($enlaceCon,$sqlDatosFactura);
$nroAutorizacion=mysqli_result($respDatosFactura,0,0);
$fechaLimiteEmision=mysqli_result($respDatosFactura,0,1);
$codigoControl=mysqli_result($respDatosFactura,0,2);
$nitCliente=mysqli_result($respDatosFactura,0,3);
$razonSocialCliente=mysqli_result($respDatosFactura,0,4);
$razonSocialCliente=strtoupper($razonSocialCliente);
$fechaFactura=mysqli_result($respDatosFactura,0,5);



	echo "<center><div class='col-sm-10'><table class='table' align='center'>";
	echo "<tr class='bg-primary text-white'><th align='left' width='30%'>$nombreEmpresa</th>
	<th align='center' width='30%'>FACTURA<br>Nro. $nro_correlativo</th>
	<th align='right' width='30%'>Fecha: $fecha_salida_mostrar</th>
	</tr>";
	
	echo "<tr class='font-weight-bold'><td align='left' class='bordeNegroTdMod'>Cliente: $nombreCliente<br>Razon Social: $razonSocialCliente</td>
	<td align='center' class='bordeNegroTdMod'>NIT: $nitCliente</td><td align='right'>Observaciones: $obs_salida</td></tr>";
		echo "<tr class='font-weight-bold'><td align='left' class='bordeNegroTdMod' colspan='3'>Cajero(a): $nombreFuncionario</td></tr>";
			
	echo "</table><br>";

	echo "<table border='0' class='table table-bordered col-sm-7' cellspacing='0' align='center'>";
	
	echo "<tr class='bg-principal'><th>Producto</th><th>Lote</th><th>Vencimiento</th>
	<th>Cantidad</th><th>Precio</th>
		<th>Desc. U.</th><th>Importe</th></tr>";
	
	echo "<form method='post' action=''>";
	
	$sql_detalle="select s.cod_material, m.descripcion_material, s.lote, s.fecha_vencimiento, 
		s.cantidad_unitaria, s.precio_unitario, s.`descuento_unitario`, s.`monto_unitario` 
		from salida_detalle_almacenes s, material_apoyo m
		where s.cod_salida_almacen='$codigo' and s.cod_material=m.codigo_material";
	
	$resp_detalle=mysqli_query($enlaceCon,$sql_detalle);
	$indice=0;
	$montoTotal=0;
	$pesoTotal=0;

	while($dat_detalle=mysqli_fetch_array($resp_detalle))
	{	$cod_material=$dat_detalle[0];
		$nombre_material=$dat_detalle[1];
		$loteProducto=$dat_detalle[2];
		$fechaVencimiento=$dat_detalle[3];
		$cantidad_unitaria=number_format($dat_detalle[4],0,'.','');
		$precioUnitario=$dat_detalle[5];
		$precioUnitario=redondear2($precioUnitario);
		$descuentoUnitario=$dat_detalle[6];
		$descuentoUnitario=redondear2($descuentoUnitario);
		$montoUnitario=$dat_detalle[7];
		$montoUnitario=redondear2($montoUnitario);
		
		echo "<tr><td class='bordeNegroTdMod'>($cod_material) $nombre_material</td>
			<td align='center' class='bordeNegroTdMod'>$loteProducto</td>
			<td align='center' class='bordeNegroTdMod'>$fechaVencimiento</td>
			<td class='bordeNegroTdMod'>$cantidad_unitaria</td>
			<td class='bordeNegroTdMod'>$precioUnitario</td>
			<td class='bordeNegroTdMod'>$descuentoUnitario</td>
			<td class='bordeNegroTdMod' align='center'>$montoUnitario</td></tr>";
		$indice++;
		$montoTotal=$montoTotal+$montoUnitario;
		$montoTotal=redondear2($montoTotal);
	
	}
	

$montoFinal=$montoTotal-$descuentoNota;
$montoTotal=number_format($montoTotal,1,'.','')."0";
$montoFinal=number_format($montoFinal,1,'.','')."0";

	/*for($j=$indice; $j<=15; $j++){
		echo "<tr><td>&nbsp;</td>
			<td align='center'>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td><td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align='center'>-</td></tr>";
	}*/
	
	echo "<tr class='bg-principal'><th></th><th></th><th></th><th></th><th></th><th>Total Venta</th><th>$montoFinal</th></tr>";
	echo "<tr class='bg-principal'><th></th><th></th><th></th><th></th><th></th><th>Descuento</th><th>$descuentoNota</th></tr>";
	echo "<tr class='bg-principal'><th></th><th></th><th></th><th></th><th></th><th>Total Final</th><th>$montoFinal</th></tr>";
	echo "</table><br><br><br></div></center>";
	echo "<div></div>";
?>