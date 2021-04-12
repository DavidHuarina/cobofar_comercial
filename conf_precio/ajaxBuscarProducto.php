<?php
$estilosVenta=1;
require("../conexionmysqli.inc");
require("../estilos2.inc");
require("configModule.php");
require("../funciones.php");

$codigo_registro=$_POST["codigo_registro"];
$sqlCodigo="";
if(isset($_POST['codigo'])&&$_POST['codigo']!=""){
  $sqlCodigo="and d.codigo_material in (".$_POST['codigo'].")";
}

$sqlNombre="";
if(isset($_POST['nombre'])&&$_POST['nombre']!=""){
  $sqlNombre="and d.descripcion_material like '%".$_POST['nombre']."%'";
}

$stringLineasX="";
if(isset($_POST['lineas'])&&count($_POST['lineas'])>0){
  $stringLineasX="and d.cod_linea_proveedor in (".implode(",",$_POST['lineas']).") ";
}

$stringFormasX="";
if(isset($_POST['formas'])&&count($_POST['formas'])>0){
  $stringFormasX="and d.cod_forma_far in (".implode(",",$_POST['formas']).") ";
}

$stringAccionesX="";
if(isset($_POST['acciones'])&&count($_POST['acciones'])>0){
  $stringAccionesX="and d.codigo_material in (select codigo_material from material_accionterapeutica where cod_accionterapeutica in (".implode(",",$_POST['acciones'])."))";
}

$sqllimit="";
if($sqlCodigo==""&&$sqlNombre==""&&$stringLineasX==""&&$stringFormasX==""&&$stringAccionesX=="")
{
  $sqllimit="LIMIT 100";
}

$sql="select d.codigo_material,0 as codigo_material,d.descripcion_material,(select cod_proveedor from proveedores_lineas where cod_linea_proveedor=d.cod_linea_proveedor) as cod_proveedor,d.cod_linea_proveedor from material_apoyo d where d.estado=1 $sqlCodigo $stringLineasX $sqlNombre $stringFormasX $stringAccionesX order by 1 $sqllimit";
 //echo $sql;

$resp=mysqli_query($enlaceCon,$sql); 
echo "<table class='table table-sm table-bordered' id='tabla_productos'>";
  echo "<tr class='bg-principal text-white'>
  <th>N.</th>
  <th>Proveedor</th>
  <th>Linea</th>
  <th>Producto</th>
  <th>Precio</th>
  <th>Detalle</th>
  </tr></thead><tbody>";
  $index=0;
  while($dat=mysqli_fetch_array($resp))
  { 
    $index++;
    $codigo=$dat[0];
    $nombre=$dat[2];
    $proveedor=obtenerNombreProveedor($dat[3]);
    $linea=obtenerNombreProveedorLinea($dat[4]);
    $precioProducto=number_format(obtenerPrecioProductoSucursal($codigo),2,'.',' ');
    $enlace="<a class='btn btn-warning btn-sm' style='background:#F5921B !important;' title='Modificar en Sucursales' href='$urlListDetalle?codigo=$codigo' onclick=''><i class='material-icons'>edit</i>&nbsp;<i class='material-icons'>business</i></a>";
    echo "<tr>
    <td>$index</td>
    <td>$proveedor</td>
    <td>$linea</td>
    <td>$nombre</td>
    <td><small>$precioProducto</small></td>
    <td>$enlace</td>
    </tr>";
  }
  echo "</table>";