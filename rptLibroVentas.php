<meta charset="utf-8">
<?php
require('estilos_reportes.php');
require('function_formatofecha.php');
require('conexionmysqli.inc');
require('funcion_nombres.php');
?>
<style type="text/css"> 
        thead tr th { 
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #ffffff;
        }
    
        .table-responsive { 
            height:200px;
            overflow:scroll;
        }
    </style>
<?php
$codAnio=$_GET['codAnio'];
$codMes=$_GET['codMes'];
$rpt_territorio=$_GET['codTipoTerritorio'];
$tipo=$_GET['tipo'];
$meses=["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
$fecha_reporte=date("d/m/Y");

echo "<center><h2>Libro de Ventas</h2></center>";

$sqlConf="select id, valor from configuracion_facturas where id=1";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$nombreTxt=mysqli_result($respConf,0,1);

$sqlConf="select id, valor from configuracion_facturas where id=9";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$nitTxt=mysqli_result($respConf,0,1);
$nombreMes=$meses[$codMes-1];
echo "<p><b>Periodo Año: $codAnio  Mes: $nombreMes</b></p>";
echo "<p><b>Nombre o Razon Social: $nombreTxt  NIT: $nitTxt</b></p>";

if($tipo>0){
	if($tipo==1){
		$sqlTipo=" and s.cod_tipo_doc='1' ";
	}else{
		$sqlTipo=" and s.cod_tipo_doc='4' ";
	}	
}

$sql="select f.nro_factura, DATE_FORMAT(f.fecha, '%d/%m/%Y'), f.importe, f.razon_social, f.nit, d.nro_autorizacion, e.abreviatura, f.codigo_control,(SELECT descripcion FROM ciudades where cod_ciudad=f.cod_sucursal)nombre_ciudad,s.cod_tipo_doc
	from facturas_venta f, dosificaciones d, estados_factura e,salida_almacenes s
	where f.cod_dosificacion=d.cod_dosificacion and e.cod_estado=f.cod_estado and s.cod_salida_almacenes=f.cod_venta
	and YEAR(f.fecha)=$codAnio and MONTH(f.fecha)=$codMes and f.cod_sucursal in ($rpt_territorio) 
	$sqlTipo order by f.fecha, f.nro_factura";
//echo $sql;	
$resp=mysqli_query($enlaceCon,$sql);

echo "<br><table align='center' class='table table-condensed' width='70%'>
<thead>
<tr class='bg-info text-white'>
<th class='bg-danger text-white'><small><small>Suc.</small></small></th>
<th class='bg-danger text-white'><small><small>Tipo</small></small></th>
<th class='bg-info text-white'><small><small>ESP.</small></small></th>
<th class='bg-info text-white'><small><small>NRO.</small></small></th>
<th class='bg-info text-white'><small><small>FECHA FACTURA</small></small></th>
<th class='bg-info text-white'><small><small>NRO. FACTURA</small></small></th>
<th class='bg-info text-white'><small><small>NRO. AUTORIZACION</small></small></th>
<th class='bg-info text-white'><small><small>ESTADO</small></small></th>
<th class='bg-info text-white'><small><small>NIT/CI CLIENTE</small></small></th>
<th class='bg-info text-white'><small><small>NOMBRE O RAZON SOCIAL</small></small></th>
<th class='bg-info text-white'><small><small>IMPORTE TOTAL VENTA<br>A</small></small></th>
<th class='bg-info text-white'><small><small>IMPORTE ICE/ IEHD/ IPJ/TASAS/ OTROS NO SUJETOS AL IVA <br>B </small></small></th>
<th class='bg-info text-white'><small><small>EXPORTACIONES Y OPERACIONES EXENTAS <br> C </small></small></th>
<th class='bg-info text-white'><small><small>VENTAS GRAVADAS A TASA CERO <br> D</small></small></th>
<th class='bg-info text-white'><small><small>SUBTOTAL <br> E = A - B - C - D </small></small></th>
<th class='bg-info text-white'><small><small>DESCUENTOS, BONIFICACIONES Y REBAJAS SUJETAS AL IVA <br> F</small></small></th>
<th class='bg-info text-white'><small><small>IMPORTE BASE PARA DEBITO FISCAL <br> G = E - F </small></small></th>
<th class='bg-info text-white'><small><small>DEBITO FISCAL <br> H = G * 13%</small></small></th>
<th class='bg-info text-white'><small><small>CODIGO DE CONTROL</small></small></th>
</tr></thead><tbody>";

$indice=1;
while($datos=mysqli_fetch_array($resp)){	
	$nroFactura=$datos[0];
	$fecha=$datos[1];
	$importe=$datos[2];
	$razonSocial=$datos[3];
	$nit=$datos[4];
	$nroAutorizacion=$datos[5];
	$nombreEstado=$datos[6];
	$codigoControl=$datos[7];
	
	$montoVentaFormat=number_format($importe,2,".",",");
	$montoIVA=$importe*0.13;
	$montoIVAFormat=number_format($montoIVA,2,".",",");
	$nombreCiudad=$datos['nombre_ciudad'];
	$codTipoDoc=$datos['cod_tipo_doc'];
	$nomTipo="";
	if($codTipoDoc==1){
		$nomTipo="A";
	}else{
		if($codTipoDoc==4){
		  $nomTipo="M";	
		}		
	}
	echo "<tr>
	<td class='small' style='background:#E2E1DE;'>$nombreCiudad</td>
    <td class='small' style='background:#E2E1DE;'>$nomTipo</td>
	<td>3</td>
	<td>$indice</td>
	<td>$fecha</td>
	<td>$nroFactura</td>
	<td>$nroAutorizacion</td>
	<td>$nombreEstado</td>
	<td>$nit</td>
	<td>$razonSocial</td>
	<td>$montoVentaFormat</td>
	<td>0</td>
	<td>0</td>
	<td>0</td>
	<td>$montoVentaFormat</td>
	<td>0</td>
	<td>$montoVentaFormat</td>
	<td>$montoIVAFormat</td>
	<td>$codigoControl</td>
	</tr>";
	$indice++;
}
echo "</tbody></table></br>";
?>