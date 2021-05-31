<?php
function saca_nombre_muestra($codigo)
{	require("conexionmysqli2.inc");
	$sql="select descripcion from muestras_medicas where codigo='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$dat=mysqli_fetch_array($resp);
	$nombre_muestra=$dat[0];
	return($nombre_muestra);
}
function nombreProducto($codigo)
{	require("conexionmysqli2.inc");
$sql="select concat(descripcion, ' ',presentacion) from muestras_medicas where codigo='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$dat=mysqli_fetch_array($resp);
	$nombre_muestra=$dat[0];
	return($nombre_muestra);
}

function nombreBanco($codigo)
{	require("conexionmysqli2.inc");
$sql="select nombre from bancos where codigo='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$dat=mysqli_fetch_array($resp);
	$nombre_muestra=$dat[0];
	return($nombre_muestra);
}

function nombreBancoCuenta($codigo)
{	require("conexionmysqli2.inc");
$sql="select nombre from cuentas_bancarias where codigo='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$dat=mysqli_fetch_array($resp);
	$nombre_muestra=$dat[0];
	return($nombre_muestra);
}


function nombreGestion($codigo)
{	require("conexionmysqli2.inc");
$sql="select g.`nombre_gestion` from `gestiones` g where g.`codigo_gestion`='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre=mysqli_result($resp,0,0);
	return($nombre);
}

function nombreLinea($codigo)
{	require("conexionmysqli2.inc");
$sql="select nombre_linea from lineas where codigo_linea='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre=mysqli_result($resp,0,0);
	return($nombre);
}

function nombreVisitador($codigo)
{	require("conexionmysqli2.inc");
$sql="select concat(paterno,' ',nombres) from funcionarios where codigo_funcionario='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre=mysqli_result($resp,0,0);
	return($nombre);
}

function nombreTerritorio($codigo)
{	require("conexionmysqli2.inc");
$sql="select descripcion from ciudades where cod_ciudad='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre=mysqli_result($resp,0,0);
	return($nombre);
}

function nombreMedico($codigo)
{	require("conexionmysqli2.inc");
$sql="select concat(ap_pat_med,' ', nom_med) from Clientes where cod_med='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre=mysqli_result($resp,0,0);
	return($nombre);
}

function nombreDia($codigo)
{	require("conexionmysqli2.inc");
$sql="select dia_contacto from orden_dias where id='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre=mysqli_result($resp,0,0);
	return($nombre);
}


function nombreRutero($codigo)
{	require("conexionmysqli2.inc");
$sql="select nombre_rutero from rutero_maestro_cab where cod_rutero='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre=mysqli_result($resp,0,0);
	return($nombre);
}

function nombreZona($codigo)
{	require("conexionmysqli2.inc");
$sql="select zona from zonas where cod_zona='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre=mysqli_result($resp,0,0);
	return($nombre);
}

function nombreCategoria($codigo, $link)
{	require("conexionmysqli2.inc");
$sql="select nombre_categoria from categorias_producto where cod_categoria='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql, $link);
	$nombre=mysqli_result($resp,0,0);
	return($nombre);
}

function nombreCliente($codigo)
{	require("conexionmysqli2.inc");
$sql="select nombre_cliente from clientes where cod_cliente='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre=mysqli_result($resp,0,0);
	return($nombre);
}

function nombreProveedor($codigo){	
	require("conexionmysqli2.inc");
	$sql="select nombre_proveedor from proveedores where cod_proveedor='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre=mysqli_result($resp,0,0);
	return($nombre);
}


function obtenerNombreMaestro($tabla, $codigo){
	require("conexionmysqli2.inc");
	$sql="select nombre from $tabla where codigo='$codigo'";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre="";
	while($dat=mysqli_fetch_array($resp)){
	$nombre.=$dat[0]."-";
	}
	return($nombre);
}
function obtenerNombreSucursalAgrupado($sucursales){
	require("conexionmysqli2.inc");
	$sql="select GROUP_CONCAT(descripcion) AS descripcion from ciudades where cod_ciudad in ($sucursales)";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre="";
	while($dat=mysqli_fetch_array($resp)){
	$nombre.=$dat[0];
	}
	return($nombre);
}

function obtenerNombreProductoSimple($codigo){
	require("conexionmysqli2.inc");
	$sql="select descripcion_material from material_apoyo where codigo_material=$codigo";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre="";
	while($dat=mysqli_fetch_array($resp)){
	$nombre=$dat[0];
	}
	return($nombre);
}
function obtenerNombreProductoCompleto($codigo){
	require("conexionmysqli2.inc");
	$sql="SELECT m.descripcion_material,(select p.nombre_proveedor from proveedores_lineas l join proveedores p on p.cod_proveedor=l.cod_proveedor where l.cod_linea_proveedor=m.cod_linea_proveedor) as nombre_proveedor,(select l.nombre_linea_proveedor from proveedores_lineas l where l.cod_linea_proveedor=m.cod_linea_proveedor) as linea_proveedor
from material_apoyo m 
where m.codigo_material=$codigo";
	$resp=mysqli_query($enlaceCon,$sql);
	$nombre="";
	while($dat=mysqli_fetch_array($resp)){
	$nombre=$dat[0]." (".$dat[2]." - ".$dat[1].")";
	}
	return($nombre);
}

?>