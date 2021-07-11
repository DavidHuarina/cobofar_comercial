<?php
ini_set('memory_limit','1G');
set_time_limit(0);

require_once __DIR__.'/../conexion_externa_farma.php';
require_once '../function_web.php';
if(file_exists('valoradomayo.csv')){
    unlink('valoradomayo.csv');
}
$fp = fopen('valoradomayo.csv', 'w');
$fechaInicio="01/05/2021";
$fechaFinal="31/05/2021";
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

   fputcsv($fp, array($nombre,$AGE,$AGE1,$PROVEEDOR,$LINEA,$CPROD,$DES,$CAJAS,$SUELTAS,number_format($PRECIO_C,2,'.','')),';');   
      }
}

fclose($fp);
