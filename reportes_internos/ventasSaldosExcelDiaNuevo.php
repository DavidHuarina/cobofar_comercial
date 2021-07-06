<?php
ini_set('memory_limit','1G');
set_time_limit(0);

header("Pragma: public");
header("Expires: 0");
$filename = "datos_market.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

error_reporting(0);
$estilosVenta=1;
require_once '../conexionmysqli2.inc';

$fechaInicio="2021-05-31";
$fechaFinal="2021-07-03";

?>
<table border="1">
  <thead>
    <tr>
        <th style='background: #EFDCA2 !important;font-weight: bold;' colspan="6">PRODUCTOS VENTAS Y SALDO</th>
    </tr>
    <tr>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Sucursal</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Fecha</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Codigo</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Descripcion</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Cantidad</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Ventas</th> 
</tr>
   </thead>
<?php
$sqlSucursal="select cod_almacen,nombre_almacen from almacenes where cod_tipoalmacen=1 and estado_pedidos=1 order by 1 desc";
$respSucursal=mysqli_query($enlaceCon,$sqlSucursal);
while($datosSuc=mysqli_fetch_array($respSucursal)){ 
  $codAlmacen=$datosSuc["cod_almacen"];
  $nomAlmacen=$datosSuc["nombre_almacen"];
   $sql="SELECT YEAR(m.fecha) as anio,MONTH(m.fecha) as mes,DAY(m.fecha) as dia,d.cod_material,P.descripcion_material,SUM(d.cantidad_unitaria) AS CANTIDAD,sum(d.monto_unitario) AS MONTO_V
FROM salida_detalle_almacenes d LEFT JOIN material_apoyo P ON P.codigo_material=d.cod_material
JOIN salida_almacenes m on m.cod_salida_almacenes=d.cod_salida_almacen
WHERE m.cod_tiposalida='1001' and m.salida_anulada!=-1
AND m.fecha>='$fechaInicio' AND m.fecha<='$fechaFinal' and m.cod_almacen='$codAlmacen'
GROUP BY d.cod_material,P.descripcion_material,YEAR(m.fecha),MONTH(m.fecha),DAY(m.fecha);";
   
   $respVentas=mysqli_query($enlaceCon,$sql);
   while($datVen=mysqli_fetch_array($respVentas)){ 
     $cod_prod=$datVen['cod_material'];
     $des_prod=$datVen['descripcion_material'];
     $anio_prod=$datVen['anio'];
     $mes_prod=$datVen['mes'];
     $dia_prod=$datVen['dia'];
     $cant_ven=$datVen['CANTIDAD'];
     $monto_ven=$datVen['MONTO_V']; 
       ?><tr>
          <td class='font-weight-bold'><?=$nomAlmacen?></td>
          <td><b><?=$dia_prod."/".$mes_prod."/".$anio_prod?></b></td>
          <td><?=$cod_prod?></td>
          <td><?=$des_prod?></td>
          <td><?=$cant_ven?></td>
          <td><?=number_format($monto_ven,2,'.',',')?></td>
        </tr><?php
   }

}
?>
  </table>
