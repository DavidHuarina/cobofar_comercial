<html>
<head>
  <meta charset="utf-8" />
</head>
<body>
<script language='JavaScript'>

function nuevoAjax()
{	var xmlhttp=false;
	try {
			xmlhttp = new ActiveXObject('Msxml2.XMLHTTP');
	} catch (e) {
	try {
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	} catch (E) {
		xmlhttp = false;
	}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
 	xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}	

function cambiaPrecio(f, id, codigo, precio, tipoPrecio){
	var contenedor;
	contenedor = document.getElementById(id);
	ajax=nuevoAjax();
	ajax.open('GET', 'ajaxCambiaPrecio.php?codigo='+codigo+'&precio='+precio+'&id='+id+'&tipoPrecio='+tipoPrecio,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			contenedor.innerHTML = ajax.responseText
		}
	}
	ajax.send(null)
}

function guardaAjaxPrecio(combo, codigo, id, tipoPrecio){
	var contenedor;
	var precio=combo.value;
	contenedor = document.getElementById(id);
	ajax=nuevoAjax();
	ajax.open('GET', 'ajaxGuardaPrecio.php?codigo='+codigo+'&precio='+precio+'&tipoPrecio='+tipoPrecio,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			contenedor.innerHTML = ajax.responseText
		}
	}
	ajax.send(null)
}

function ShowBuscar(){
	document.getElementById('divRecuadroExt').style.visibility='visible';
	document.getElementById('divProfileData').style.visibility='visible';
	document.getElementById('divProfileDetail').style.visibility='visible';
}

function HiddenBuscar(){
	document.getElementById('divRecuadroExt').style.visibility='hidden';
	document.getElementById('divProfileData').style.visibility='hidden';
	document.getElementById('divProfileDetail').style.visibility='hidden';
}		

function ajaxBuscarItems(f){
	var nombreItem, tipoItem;
	nombreItem=document.getElementById("nombreItem").value;
	tipoItem=document.getElementById("tipo_material").value;

	var contenedor;
	contenedor = document.getElementById('divCuerpo');
	ajax=nuevoAjax();

	ajax.open("GET", "ajaxBuscarItems.php?nombreItem="+nombreItem+"&tipoItem="+tipoItem,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			contenedor.innerHTML = ajax.responseText;
			HiddenBuscar();
		}
	}
	ajax.send(null)
}

</script>
<?php
require('estilos.php');
require('../function_formatofecha.php');
require('../conexionmysqli.inc');
require('../funcion_nombres.php');
require('../funciones.php');
    $lineas=implode(",",$_POST["rpt_subcategoria"]);
	$fechaActual=date("Y-m-d");
	
	$nroMeses=3;
	$fechaIni=date("Y-m-d");
	$fechaFin=date('Y-m-d',strtotime($fechaIni.'+'.$nroMeses.' month'));
	
	echo "<form method='POST' action='guardarPrecios.php' name='form1'>";
	
	echo "<table style='margin-top:0 !important' align='center' class='textotit' width='70%'><tr><td align='center'>Reporte de Productos Proximos a Vencer</td></tr></table><br>";
	
	$sql="SELECT p.nombre_proveedor,l.nombre_linea_proveedor,l.cod_linea_proveedor
		FROM proveedores_lineas l 
		join proveedores p on p.cod_proveedor=l.cod_proveedor
		where cod_linea_proveedor in ($lineas) order by 1,2";	
	$resp=mysqli_query($enlaceCon,$sql);
	
	echo "<center><table class='texto'>";
	echo "<tr>
	<th>#</th>
	<th>Proveedor</th>
	<th>Linea</th>
	<th>Productos</th>
	<th>Sin Cod Barras</th>
	</tr>";
	$indice=1;
	$totales1=0;$totales2=0;
	while($dat=mysqli_fetch_array($resp))
	{
		$proveedor=$dat[0];
		$linea=$dat[1];	
		$productos=obtenerProductoCantidadLinea($dat[2],1);
		$sin_barras=obtenerProductoCantidadLinea($dat[2],0);
		$totales1+=$productos;
		$totales2+=$sin_barras;
		$productos=number_format($productos,0,'.',',');
		$sin_barras=number_format($sin_barras,0,'.',',');

		echo "<tr>";
		echo "<td align='center'>$indice</td>";
	    echo "<td align='left'>$proveedor</td>";
	    echo "<td align='left'>$linea</td>";
	    echo "<td align='center'>$productos</td>";
		echo "<td align='center'>$sin_barras</td>";
		echo "</tr>";
		
		$indice++;
	}
	$totales1=number_format($totales1,0,'.',',');
	$totales2=number_format($totales2,0,'.',',');
	echo "<tr><th colspan='3'>TOTALES</th><th align='right'>$totales1</th><th align='right'>$totales2</th></tr></table></center><br>";	
?>
</body></html>
