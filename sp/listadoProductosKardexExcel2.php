<?php
function conexionSqlServer($ip,$database){
  $serverName = $ip;
  $uid = "sistema";     
  $pwd = "sistema";
  if($ip!="10.10.1.11"){
     $enlaceCon=mysqli_connect("127.0.0.1","root","","farmaciasalmacen");
     $sql = "SELECT ip FROM sucursales_minusculas where ip='$ipCon'";
     $resp = mysqli_query($enlaceCon,$sql);
     $ipSuc=mysqli_result($resp,0,0);
     $pwd="B0L1V14.@1202";
     if($serverName==$ipSuc){
          $pwd="B0l1v14.@1202";
     }
  }  

  $databaseName = $database;  
  $connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database"=>$databaseName);  
  $conn = sqlsrv_connect( $serverName, $connectionInfo);  
  if( $conn ){  
    return $conn;
  }else{  
     return false;
  }  
  //sqlsrv_close( $conn);  
}

ini_set('memory_limit','1G');
set_time_limit(0);
require_once __DIR__.'/../conexion_externa_farma.php';
require '../conexionmysqli.inc';
require_once '../function_web.php';
require_once '../funciones.php';

$ipAlma=$_GET["ip"];
$ag=$_GET["age"];

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
$indexx=1;
$dbh = conexionSqlServer($ipAlma,"Gestion"); 
?><br><br><h4>REPORTE DE KARDEX</h4><br><br>

<table class="table table-bordered table-condensed">
  <tr class='bg-success text-white'>
      <td>N.</td>
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
$listAlma=obtenerListadoAlmacenesEspecifico($age);//web service
$contador=0;
$arrayProductos=[];
foreach ($listAlma->lista as $alma) {

      $age1=$alma->age1;
      $nombre=$alma->des;
      $ip=$alma->ip;
      //echo $ip;

     $dbh = ConexionFarma($ip,"Gestion");
     
      $sql="SELECT P.CPROD,P.DES,
      (SELECT SUM(s.INGRESO-s.SALIDA) FROM VSALDOS s WHERE s.CPROD=P.CPROD AND AGE1='$age1') as VENTAS,
      (SELECT SUM(D.DCAN-D.HCAN) FROM VDETALLE D WHERE D.CPROD=P.CPROD and D.TIPO in ('A','D','S','I') AND AGE1='$age1') as INGRESOS,
      (SELECT SUM(D.DCAN-D.HCAN) FROM VDETALLE D WHERE D.CPROD=P.CPROD and D.TIPO in ('K','F','O') AND AGE1='$age1') as SALIDAS,
      (SELECT SUM(D.DCAN1-D.HCAN1) FROM VDETALLE D WHERE D.CPROD=P.CPROD and D.TIPO in ('A','D','S','I') AND AGE1='$age1') as INGRESOS_UNITARIO,
      (SELECT SUM(D.DCAN1-D.HCAN1) FROM VDETALLE D WHERE D.CPROD=P.CPROD and D.TIPO in ('K','F','O') AND AGE1='$age1') as SALIDAS_UNITARIO
      FROM APRODUCTOS P GROUP BY P.CPROD,P.DES";
     //echo $sql;
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
        
        //if(!($saldo==0&&$saldo_unitario==0)){          
        if(($kardex+$kardex_unitario)!=$ventas){          
        ?><tr>
          <td><?=$indexx?></td>
          <td class='font-weight-bold'><?=$nombre?></td>
          <td><?=$cod_prod?></td>
          <td><?=$des_prod?></td>
          <td><?=$ventas?></td>
          <td><?=$kardex?></td>
          <td><?=$kardex_unitario?></td>
          <td><?=$saldo?></td>
          <td><?=$saldo_unitario?></td>
        </tr><?php
        $indexx++;
       }     
     }
}
?></table></body>
</html>
