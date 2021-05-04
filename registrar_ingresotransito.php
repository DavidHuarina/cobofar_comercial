<?php
require("conexionmysqli.inc");
require("estilos.inc");
require("funciones.php");
$fecha=date("Y-m-d");
$hora=date("H:i");

$sql_datos_salidaorigen="select s.nro_correlativo, s.cod_tiposalida, a.nombre_almacen from salida_almacenes s, almacenes a
where a.cod_almacen=s.cod_almacen and s.cod_salida_almacenes='$codigo_registro'";
$resp_datos_salidaorigen=mysqli_query($enlaceCon, $sql_datos_salidaorigen);
$datos_salidaorigen=mysqli_fetch_array($resp_datos_salidaorigen);
$correlativo_salidaorigen=$datos_salidaorigen[0];
$tipo_salidaorigen=$datos_salidaorigen[1];
$nombre_almacen_origen=$datos_salidaorigen[2];
$observaciones="";
echo "<form action='guarda_ingresomateriales.php' method='post'>";
echo "<h1>Registrar Ingreso en Transito</h1>";
echo "<center>
	<table class='texto'>";
echo "<tr><th>Fecha</th><th>Nota de Ingreso</th><th>Tipo de Ingreso</th><th>Observaciones</th></tr>";
echo "<tr><td>";
	echo"<INPUT type='date' class='texto' value='$fecha' id='fecha' size='10' name='fecha' readonly>";
echo "<td><input type='text' disabled='true' size='40' name='' value='Salida:$correlativo_salidaorigen $nombre_almacen_origen' class='texto'></td>";
echo "<input type='hidden' name='nota_ingreso' value='Salida:$correlativo_salidaorigen $nombre_almacen_origen'>";

echo "<td align='center'><input type='text' class='texto' name='nombre_tipoingreso' value='TRASPASO SUCURSAL' size='30' readonly></td>";
echo "<input type='hidden' name='tipo_ingreso' value='1003'>";

echo "<input type='hidden' name='nro_factura' value='0'>";
echo "<input type='hidden' name='proveedor' value='0'>";

echo "<td align='center'><input type='text' class='texto' name='observaciones' value='$observaciones' size='60'></td></tr>";
echo "</table><br>";

echo "<table class='texto'>";

$sql_detalle_salida="select cod_salida_almacen, cod_material, sum(cantidad_unitaria), costo_almacen,lote,fecha_vencimiento,sum(cantidad_envase)
from salida_detalle_almacenes where cod_salida_almacen='$codigo_registro' and (cantidad_unitaria>0 or cantidad_envase>0) 
group by cod_salida_almacen, cod_material";
$resp_detalle_salida=mysqli_query($enlaceCon,$sql_detalle_salida);
$cantidad_materiales=mysqli_num_rows($resp_detalle_salida);

echo "<input type='hidden' name='codigo_salida' value='$codigo_registro'>";
echo "<input type='hidden' name='cantidad_material' value='$cantidad_materiales'>";
echo "<tr><th width='5%'>&nbsp;</th><th width='45%'>Material</th><th>Lote</th><th>Fecha Vencimiento</th><th width='15%'>Cantidad de Origen</th><th>Cantidad Recibida</th></tr>";

$indice_detalle=1;

while($dat_detalle_salida=mysqli_fetch_array($resp_detalle_salida))
{	$cod_material=$dat_detalle_salida[1];
	$cantidad_unitaria=$dat_detalle_salida[2];
	$costo_almacen=$dat_detalle_salida[3];
	$lote=$dat_detalle_salida[4];
	$fecha_ven=$dat_detalle_salida[5];

	$cantidad_envase=$dat_detalle_salida[6];
	$cantidad_presentacion=obtenerCantidadPresentacionProducto($cod_material);
	$cantidadRecibido=($cantidad_presentacion*$cantidad_envase)+$cantidad_unitaria;

	$cantidad_unitaria_formato=number_format($cantidadRecibido,0,'.','');
    $costo_almacen_formato=number_format($costo_almacen,2,'.',',');

	echo "<tr><td align='center'>$indice_detalle</td>";
	$sql_materiales="select codigo_material, descripcion_material from material_apoyo where 
	codigo_material='$cod_material' and codigo_material<>0 order by descripcion_material";
	$resp_materiales=mysqli_query($enlaceCon, $sql_materiales);
	$dat_materiales=mysqli_fetch_array($resp_materiales);
	$nombre_material="$dat_materiales[1]";

	echo "<td>$nombre_material</td>";
	echo "<input type='hidden' value='$cod_material' name='material$indice_detalle'>";
	echo "<input type='hidden' value='$cantidad_unitaria' name='cantidad_origen$indice_detalle'>";
	echo "<input type='hidden' value='$costo_almacen' name='precio$indice_detalle'>";
	
	echo "<td align='center'>$lote</td><td align='center'>$fecha_ven</td><td align='center'>$cantidad_unitaria_formato</td>";
	echo "<td><input type='number' name='cantidad_unitaria$indice_detalle' step='0.1' value='$cantidad_unitaria_formato' class='form-control' readonly required></td>
	</tr>";
	$indice_detalle++;
}
echo "</table></center>";
$indice_detalle--;

echo "<input type='hidden' name='cantidad_material' value='$indice_detalle'>";
echo "<input type='hidden' name='cod_salida' value='$codigo_registro'>";

echo "<div class='divBotones'>
<input type='submit' class='boton' value='Guardar'>
<input type='button' class='boton2' value='Cancelar' onClick='location.href=\"navegador_ingresotransito.php\"'>
</div>";
echo "</form>";
echo "</div></body>";
echo "<script type='text/javascript' language='javascript'  src='dlcalendar.js'></script>";
?>