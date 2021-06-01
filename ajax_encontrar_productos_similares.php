<?php
$estilosVenta=1;
require("conexionmysqli2.inc");
require("funciones.php");
require("funcion_nombres.php");
  $codCiudad=$_COOKIE['global_agencia'];
  $codAlmacen=$_COOKIE['global_almacen'];
  $cod_material=$_GET["cod_material"];
  $dataPrin=[];$ii=0;
  $sql="SELECT cod_principioactivo FROM principios_activosproductos WHERE cod_material='$cod_material'";
  $resp=mysqli_query($enlaceCon,$sql); 
  while($dat=mysqli_fetch_array($resp))
  {
    $dataPrin[$ii]=$dat[0];
    $ii++;
  }

  $stringPrincipios=implode(",",$dataPrin);

  $sql="SELECT m.codigo_material,m.descripcion_material,(SELECT nombre_linea_proveedor from proveedores_lineas where cod_linea_proveedor=m.cod_linea_proveedor),(SELECT cod_proveedor from proveedores_lineas where cod_linea_proveedor=m.cod_linea_proveedor),(SELECT MIN(orden) from principios_activosproductos where cod_principioactivo in ($stringPrincipios)) as orden,
    (SELECT GROUP_CONCAT(p.nombre) from principios_activos p where p.codigo in (SELECT cod_principioactivo from principios_activosproductos where cod_material=m.codigo_material)),m.cantidad_presentacion
   FROM material_apoyo m where m.codigo_material in (SELECT cod_material from principios_activosproductos where cod_principioactivo in ($stringPrincipios)) and m.estado=1 and m.codigo_material!='$cod_material' ORDER BY 5 desc";
  //echo $sql;
  $resp=mysqli_query($enlaceCon,$sql); 

  $index=0;
  while($dat=mysqli_fetch_array($resp))
  {
    $codMat=$dat[0]; 
    $proveedor=nombreProveedor($dat[3]);
    $linea=$dat[2];
    $producto=$dat[1];
    $stock=stockProducto($codAlmacen, $codMat);
    $precio=number_format(precioProductoAlmacen($codCiudad, $codMat),2,'.',',');
    $principiostring=$dat[5];
    $cantidadPres=$dat[6];
    $estiloTexto="";
   $cambio="<a href='javascript:setMaterialesSimilar(form1, $codMat, \"$producto\",\"$cantidadPres\")' class='btn btn-warning btn-fab' title='Cambiar Producto'><i class='material-icons'>compare_arrows</i></a>";
   // if($stock>0){
      $index++; 
      echo "<tr $estiloTexto>
      <td>$index</td>
      <td>$proveedor</td>
      <td>$linea</td>
      <td>$producto</td>
      <td>$principiostring</td>
      <td>$stock</td>
      <td>$precio</td>
      <td>$cambio</td>
      </tr>";
    //}
  }
