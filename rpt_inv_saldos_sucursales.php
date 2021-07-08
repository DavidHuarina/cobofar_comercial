<html>
<head>
  <meta charset="utf-8" />
  <?php

require('estilos_reportes_almacencentral.php');
require('function_formatofecha.php');
$estilosVenta=1;
require('conexionmysqli.inc');
require("funciones.php");
require("funcion_nombres.php");
$rpt_almacen=$_GET['rpt_almacen'];
$rpt_fecha=cambia_formatofecha($rpt_fecha);
$fecha_saldo=$rpt_fecha;
$fecha_reporte=date("d/m/Y");
$txt_reporte="Fecha de Reporte <strong>$fecha_reporte</strong>";
$globalAgencia=$_COOKIE['global_agencia'];

  $cod_material=$_GET["rpt_item"];
  $tipoItem=$_GET['rpt_ver'];
  $sql="SELECT a.cod_almacen,c.descripcion,c.direccion from ciudades c join almacenes a on a.cod_ciudad=c.cod_ciudad where c.cod_estadoreferencial=1 and a.cod_almacen in ($rpt_almacen) order by c.descripcion";
  //echo $sql;
  $resp=mysqli_query($enlaceCon,$sql); 
  ?>
<center><table class="texto" id='tablaBuscar'>
                    <thead>
                      <tr style='background: #ADADAD;color:#000;'>
                      <th>#</th>
                      <th>Producto</th>
                      <th>Sucursal</th>
                      <th>Stock</th>
                      </tr>
                    </thead>
                    <tbody id="tabla_datos">                                        
  <?php
  $index=0;

  while($dat=mysqli_fetch_array($resp))
  {   
   $codAlmacen=$dat[0];
   $sucursal=$dat[1];
   $direccion=$dat[2];
   $producto=obtenerNombreProductoSimple($cod_material);
   $stock=stockProductoFechas($codAlmacen, $cod_material,$fecha_saldo);
   $estiloTexto="";
   if($stock>100){
    //$estiloTexto="style='background:#6035B8;color:#fff;'";
   }
$mostrarFila=0;
if($tipoItem==2){
   if($stock>0){
    $mostrarFila=1;
   }
}else if($tipoItem==3){
     if($stock<=0){
      $mostrarFila=1;
     }
}else{
  $mostrarFila=1;
}
    if($mostrarFila==1){
      $index++; 
      echo "<tr $estiloTexto>
      <td>$index</td>
      <td>$producto</td>
      <td>$sucursal</td>
      <td>$stock</td>
      </tr>";
    }    
  }
  ?></tbody>
                  </table></center><?php



