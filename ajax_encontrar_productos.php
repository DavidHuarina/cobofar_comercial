<?php
$estilosVenta=1;
require("conexionmysqli2.inc");
require("funciones.php");
require("funcion_nombres.php");
$globalAgencia=$_COOKIE['global_agencia'];

$cod_material=$_GET["cod_material"];
$consulta="select p.`precio` from precios p where p.`codigo_material`='$cod_material' and p.cod_precio=1 and cod_ciudad=-1";
$rs=mysqli_query($enlaceCon,$consulta);
$registro=mysqli_fetch_array($rs);
$precioMaterial=$registro[0];
if($precioMaterial>0){
  $precioMaterial=number_format($precioMaterial,2,'.','');
}

  $sql="SELECT a.cod_almacen,c.descripcion,c.direccion from ciudades c join almacenes a on a.cod_ciudad=c.cod_ciudad where c.cod_estadoreferencial=1 and c.cod_ciudad!='$globalAgencia' order by c.descripcion";
  //echo $sql;
  $resp=mysqli_query($enlaceCon,$sql); 

  $index=0;
  while($dat=mysqli_fetch_array($resp))
  {
   
   $codAlmacen=$dat[0];
   $sucursal=$dat[1];
   $direccion=$dat[2];
   $producto=obtenerNombreProductoSimple($cod_material);
   $stock=stockProducto($codAlmacen, $cod_material);
   $stock=stockProducto($codAlmacen, $cod_material);
   $estiloTexto="";
   if($stock>100){
    //$estiloTexto="style='background:#6035B8;color:#fff;'";
   }
    if($stock>0){
      $index++; 
      echo "<tr $estiloTexto>
      <td>$index</td>
      <td>$producto</td>
      <td><i class='material-icons float-left' style='color:#6035B8'>place</i> $sucursal</td>
      <td>$direccion</td>
      <td>$stock</td>
      <td>$precioMaterial</td>
      </tr>";
    }    
  }
