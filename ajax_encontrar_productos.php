<?php
$estilosVenta=1;
require("conexionmysqli.inc");
require("funciones.php");
require("funcion_nombres.php");

  $cod_material=$_GET["cod_material"];
  $sql="SELECT a.cod_almacen,c.descripcion,c.direccion from ciudades c join almacenes a on a.cod_ciudad=c.cod_ciudad where c.cod_estadoreferencial=1 order by c.descripcion";
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
      </tr>";
    }    
  }
