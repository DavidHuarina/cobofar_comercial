<?php
function saca_nombre_muestra($codigo)
{	require("conexionmysqli.inc");
	$sql="select descripcion from muestras_medicas where codigo='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$dat=mysqli_fetch_array($resp);
	$nombre_muestra=$dat[0];
	return($nombre_muestra);
}
function nombreProducto($codigo)
{	require("conexionmysqli.inc");
$sql="select concat(descripcion, ' ',presentacion) from muestras_medicas where codigo='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$dat=mysqli_fetch_array($resp);
	$nombre_muestra=$dat[0];
	return($nombre_muestra);
}

function nombreGestion($codigo)
{	require("conexionmysqli.inc");
$sql="select g.`nombre_gestion` from `gestiones` g where g.`codigo_gestion`='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre=mysql_result($resp,0,0);
	return($nombre);
}

function nombreLinea($codigo)
{	require("conexionmysqli.inc");
$sql="select nombre_linea from lineas where codigo_linea='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre=mysql_result($resp,0,0);
	return($nombre);
}

function nombreVisitador($codigo)
{	require("conexionmysqli.inc");
$sql="select concat(paterno,' ',nombres) from funcionarios where codigo_funcionario='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre=mysql_result($resp,0,0);
	return($nombre);
}

function nombreTerritorio($codigo)
{	require("conexionmysqli.inc");
$sql="select descripcion from ciudades where cod_ciudad='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre=mysql_result($resp,0,0);
	return($nombre);
}

function nombreMedico($codigo)
{	require("conexionmysqli.inc");
$sql="select concat(ap_pat_med,' ', nom_med) from Clientes where cod_med='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre=mysql_result($resp,0,0);
	return($nombre);
}

function nombreDia($codigo)
{	require("conexionmysqli.inc");
$sql="select dia_contacto from orden_dias where id='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre=mysql_result($resp,0,0);
	return($nombre);
}


function nombreRutero($codigo)
{	require("conexionmysqli.inc");
$sql="select nombre_rutero from rutero_maestro_cab where cod_rutero='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre=mysql_result($resp,0,0);
	return($nombre);
}

function nombreZona($codigo)
{	require("conexionmysqli.inc");
$sql="select zona from zonas where cod_zona='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre=mysql_result($resp,0,0);
	return($nombre);
}

function nombreCategoria($codigo, $link)
{	require("conexionmysqli.inc");
$sql="select nombre_categoria from categorias_producto where cod_categoria='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql, $link);
	$nombre=mysql_result($resp,0,0);
	return($nombre);
}

function nombreCliente($codigo)
{	require("conexionmysqli.inc");
$sql="select nombre_cliente from clientes where cod_cliente='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre=mysql_result($resp,0,0);
	return($nombre);
}

function nombreProveedor($codigo){	
	require("conexionmysqli.inc");
	$sql="select nombre_proveedor from proveedores where cod_proveedor='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre=mysqli_result($resp,0,0);
	return($nombre);
}



?>