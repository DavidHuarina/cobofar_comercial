<?php
$estilosVenta=1;
require("funciones.php");

$codMaterial = $_GET["codmat"];
$indice = $_GET["indice"];
$codTipoPrecio=$_GET["tipoPrecio"];
$globalAgencia=$_COOKIE["global_agencia"];
$cantidad_unitaria=$_GET["cantidad_unitaria"];
//
require("conexionmysqli2.inc");
$cadRespuesta="";
$consulta="
    select p.`precio` from precios p where p.`codigo_material`='$codMaterial' and p.cod_precio=1 and cod_ciudad=-1";
    //echo $consulta;
$rs=mysqli_query($enlaceCon,$consulta);
$registro=mysqli_fetch_array($rs);
$cadRespuesta=$registro[0];
if($cadRespuesta=="")
{   $cadRespuesta=0;
}


//no aplicar el descuento si no hay el tipo precio
$fecha=0;
if(isset($_GET["fecha"])){
	$fecha=explode("/",$_GET["fecha"]);
	$fechaCompleta=$fecha[2]."-".$fecha[1]."-".$fecha[0];	        	
}
$ciudad=$_COOKIE['global_agencia'];
$sql1="select t.codigo, t.nombre, t.abreviatura from tipos_precio t where '$fechaCompleta 00:00:00' between t.desde and t.hasta and DAYOFWEEK('$fechaCompleta') in (SELECT cod_dia from tipos_precio_dias where cod_tipoprecio=t.codigo) and estado=1 and cod_estadodescuento=3 and $ciudad in (SELECT cod_ciudad from tipos_precio_ciudad where cod_tipoprecio=t.codigo) and ($codMaterial in (SELECT codigo_material from material_apoyo where cod_linea_proveedor in (SELECT cod_linea_proveedor from tipos_precio_lineas where cod_tipoprecio=t.codigo)) or $codMaterial in (SELECT cod_material from tipos_precio_productos where cod_tipoprecio=t.codigo)) order by 1";
$resp1=mysqli_query($enlaceCon,$sql1);
$contadorAux=0;
while($dat=mysqli_fetch_array($resp1)){
	//$codTipoPrecio=$dat[0];
	$contadorAux++;
}
if($contadorAux>0){
	//$codTipoPrecio=$codTipoPrecioAux;
}else{
	$codTipoPrecio=-9999;
}
// FIN DE APLICACION DE PRECIOS


$sqlTipoPrecio="select abreviatura from tipos_precio where codigo='$codTipoPrecio'";
//echo $sql1."******".$sqlTipoPrecio;
$rsTipoPrecio=mysqli_query($enlaceCon,$sqlTipoPrecio);
$datTipoPrecio=mysqli_fetch_array($rsTipoPrecio);
$descuentoPrecio=$datTipoPrecio[0];

$sqlTipoPrecioNombre="select nombre from tipos_precio where codigo='$codTipoPrecio'";
$rsTipoPrecioNombre=mysqli_query($enlaceCon,$sqlTipoPrecioNombre);
$datTipoPrecioNombre=mysqli_fetch_array($rsTipoPrecioNombre);
$descuentoPrecioNombre=$datTipoPrecioNombre[0];

$indiceConversion=0;
$descuentoPrecioMonto=0;
if($descuentoPrecio>0){
	$indiceConversion=($descuentoPrecio/100);
	if(obtenerValorConfiguracion(13)==1){
      $descuentoPrecioMonto=round($cadRespuesta*($indiceConversion)*$cantidad_unitaria);
	}else if(obtenerValorConfiguracion(13)==2){
      $descuentoPrecioMonto=redondearMitades($cadRespuesta*($indiceConversion)*$cantidad_unitaria);
	}else if(obtenerValorConfiguracion(13)==3){
	  $descuentoPrecioMonto=redondearCentavos($cadRespuesta*($indiceConversion)*$cantidad_unitaria);
	}else{
	  //$descuentoPrecioMonto=$cadRespuesta*($indiceConversion)*$cantidad_unitaria;		
		$descuentoPrecioMonto=(($descuentoPrecio*100)*$cadRespuesta)*$cantidad_unitaria;		
	}
	//$descuentoPrecioMonto=(($descuentoPrecio*100)*$cadRespuesta)*$cantidad_unitaria;		
	
	//$cadRespuesta=$cadRespuesta-($cadRespuesta*($indiceConversion));
}

//$cadRespuesta=redondear2($cadRespuesta);
//redondeamos al entero
$cadRespuesta=number_format($cadRespuesta,2,'.','');

$sql_almacen="select cod_almacen, nombre_almacen from almacenes where cod_ciudad='$global_agencia'";
$resp_almacen=mysqli_query($enlaceCon,$sql_almacen);
$dat_almacen=mysqli_fetch_array($resp_almacen);
$global_almacen=$dat_almacen[0];

$sqlCosto="select id.costo_promedio from ingreso_almacenes i, ingreso_detalle_almacenes id
where i.cod_ingreso_almacen=id.cod_ingreso_almacen and i.ingreso_anulado=0 and 
id.cod_material='$codMaterial' and i.cod_almacen='$global_almacen' ORDER BY i.cod_ingreso_almacen desc limit 0,1";
$respCosto=mysqli_query($enlaceCon,$sqlCosto);
$costoMaterialii=0;
while($datCosto=mysqli_fetch_array($respCosto)){
	$costoMaterialii=$datCosto[0];
	$costoMaterialii=redondear2($costoMaterialii);
}

echo "<input type='number' id='precio_unitario$indice' name='precio_unitario$indice' value='$cadRespuesta' class='inputnumber' onKeyUp='calculaMontoMaterial($indice);' step='any' readonly>";
echo " [$costoMaterialii] <span style='color:red'>D:$descuentoPrecioNombre</span>";
echo "<input type='hidden' id='costoUnit$indice' value='$costoMaterialii' name='costoUnit$indice'>#####".$descuentoPrecioMonto."#####";
			
			//echo $sql1;
?>
