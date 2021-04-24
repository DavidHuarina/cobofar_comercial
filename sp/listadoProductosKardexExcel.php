<?php
ini_set('memory_limit','1G');
set_time_limit(0);
require_once __DIR__.'/../conexion_externa_farma.php';
require '../conexionmysqli.inc';
require_once '../function_web.php';
require_once '../funciones.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta charset="utf-8">
</head>
<body>

<?php
//DATOS PARA LISTAR DOCUMENTOS
$fechaDesde="01/01/2020";
$fechaHasta="31/12/2020";

$dbh = new ConexionFarmaSucursal(); 
?><br><br><h4>REPORTE DE KARDEX</h4><br><br>

<table class="table table-bordered table-condensed">
  <tr class='bg-success text-white'>
      <td>SUCURSAL</td>
      <td>CODIGO</td>
      <td>DESCRIPCION</td>
      <td>VENTAS</td>
      <td>KARDEX CAJA</td>
      <td>KARDEX SUELTA</td>
      <td>DIFERENCIA CAJA</td>
      <td>DIFERENCIA SUELTA</td>
  </tr>


<?php
$listAlma=obtenerListadoAlmacenesEspecifico("A:");//web service
$contador=0;
$arrayProductos=[];
foreach ($listAlma->lista as $alma) {

      $age1=utf8_decode($alma->age1);
      $nombre=$alma->des;
      $ip=$alma->ip;

     $dbh = ConexionFarma($ip,"Gestion");
     
      $sql="SELECT P.CPROD,P.DES,
      (SELECT SUM(s.INGRESO-s.SALIDA) FROM VSALDOS s WHERE s.CPROD=P.CPROD AND AGE1='$age1') as VENTAS,
      (SELECT SUM(D.DCAN-D.HCAN) FROM VDETALLE D WHERE D.CPROD=P.CPROD and D.TIPO in ('A','D') AND AGE1='$age1') as INGRESOS,
      (SELECT SUM(D.DCAN-D.HCAN) FROM VDETALLE D WHERE D.CPROD=P.CPROD and D.TIPO in ('K','F') AND AGE1='$age1') as SALIDAS,
      (SELECT SUM(D.DCAN1-D.HCAN1) FROM VDETALLE D WHERE D.CPROD=P.CPROD and D.TIPO in ('A','D') AND AGE1='$age1') as INGRESOS_UNITARIO,
      (SELECT SUM(D.DCAN1-D.HCAN1) FROM VDETALLE D WHERE D.CPROD=P.CPROD and D.TIPO in ('K','F') AND AGE1='$age1') as SALIDAS_UNITARIO
      FROM APRODUCTOS P GROUP BY P.CPROD,P.DES";

     $stmt = $dbh->prepare($sql);
     $stmt->execute();
     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $cod_prod=$row['CPROD'];
        $des_prod=$row['DES'];
        $ventas=$row['VENTAS'];
        $ingresos=$row['INGRESOS'];  
        $salidas=$row['SALIDAS']; 
        $ingresos_unitario=$row['INGRESOS_UNITARIO'];  
        $salidas_unitario=$row['SALIDAS_UNITARIO'];  

        $kardex=$ingresos+$salidas;
        $kardex_unitario=$ingresos_unitario+$salidas_unitario;
        $saldo=$kardex-$ventas;
        $saldo_unitario=$kardex_unitario-$ventas;
        
        if($kardex==0){
            $saldo=0;
        }
        if($kardex_unitario==0){
            $saldo_unitario=0;
        }

        if($saldo>0||$saldo_unitario>0){          
        ?><tr>
          <td class='font-weight-bold'><?=$nombre?></td>
          <td><?=$cod_prod?></td>
          <td><?=$des_prod?></td>
          <td><?=$ventas?></td>
          <td><?=$kardex?></td>
          <td><?=$kardex_unitario?></td>
          <td><?=$saldo?></td>
          <td><?=$saldo_unitario?></td>
        </tr><?php
       }     
     }
}
?></table></body>
</html>
