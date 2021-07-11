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
require_once __DIR__.'/../conexion_externa_farma.php';
require_once '../function_web.php';
$fechaInicio="01/06/2021";
$fechaFinal="30/06/2021";
?>
<center><h3><b>VALORADOS </b></h3></center>
<table class="table table-condensed table-bordered ">
  <thead>
    <tr>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>SUCURSAL</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>AGE</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>AGE1</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>PROVEEDOR</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>SUBLINEA</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>CPROD</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>DESCRIPCION</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>FECHA_VEN</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>U_FECHA_COMPRA</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>CAJA</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>SUELTAS</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>PRECIO_C</th>
    </tr>
   </thead>
<?php
$idprov=12;
$listAlma=obtenerListadoAlmacenes();
foreach ($listAlma->lista as $alma) {
      $age1=$alma->age1;
      $nombre=$alma->des;
      $ip=$alma->ip;
      $dbh = ConexionFarma($ip,"Gestion");
$sql="SELECT D.AGE,D.AGE1,P.DES AS PROVEEDOR,L.DES AS LINEA,D.CPROD,M.DES,SUM(HCAN)CAJAS,SUM(HCAN1)SUELTAS,SUM((HCAN1+HCAN)*PRECOSTO)PRECIO_C 
FROM VDETALLE D
JOIN VMAESTRO V ON V.DCTO=D.DCTO
JOIN APRODUCTOS M ON M.CPROD=D.CPROD
join PROVEEDORES P ON P.IDPROVEEDOR=M.IDPROVEEDOR
JOIN PROVEESLINEA L ON L.IDSLINEA=M.IDSLINEA
WHERE D.TIPO='F' AND V.STA='V' AND D.FECHA>='$fechaInicio' AND D.FECHA<='$fechaFinal'
GROUP BY D.AGE,D.AGE1,P.DES,L.DES,D.CPROD,M.DES;";
//echo $sql;
$stmt = $dbh->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
   $AGE=$row['AGE'];
   $AGE1=$row['AGE1'];
   $PROVEEDOR=$row['PROVEEDOR'];
   $LINEA=$row['LINEA'];
   $CPROD=$row['CPROD'];
   $DES=$row['DES'];
   $CAJAS=$row['CAJAS'];
   $SUELTAS=$row['SUELTAS'];
   $PRECIO_C=$row['PRECIO_C'];
       ?><tr>
          <td class='font-weight-bold'><?=$nombre?></td>
          <td><?=$AGE?></td>
          <td><?=$AGE1?></td>
          <td><?=$PROVEEDOR?></td>
          <td><?=$LINEA?></td>
          <td><?=$CPROD?></td>
          <td><?=$DES?></td>
          <td><?=$CAJAS?></td>
          <td><?=$SUELTAS?></td>
          <td><?=number_format($PRECIO_C,2,'.',',')?></td>
        </tr><?php
      }
}

?>
  </table>
