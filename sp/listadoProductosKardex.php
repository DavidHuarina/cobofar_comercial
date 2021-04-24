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
      <td>CODIGO</td>
      <td>VENTAS</td>
      <td>KARDEX</td>
      <td>DIFERENCIA</td>
  </tr>


<?php
$listAlma=obtenerListadoAlmacenesEspecifico("A:");//web service
$contador=0;
$arrayProductos=[];
foreach ($listAlma->lista as $alma) {

  $age1=$alma->age1;
      $nombre=$alma->des;
      $ip=$alma->ip;

     $dbh = ConexionFarma($ip,"Gestion");
     
      $sql="SELECT P.CPROD,P.DES,P.CANENVASE,
      (SELECT SUM(s.INGRESO-s.SALIDA) FROM VSALDOS s WHERE s.CPROD=P.CPROD) as VENTAS,
      (SELECT SUM(D.DCAN-D.HCAN) FROM VDETALLE D WHERE D.CPROD=P.CPROD) as CANT_CAJAS,
      (SELECT SUM(D.DCAN1-D.HCAN1) FROM VDETALLE D WHERE D.CPROD=P.CPROD) as CANT_UNIDAD
      FROM PRODUCTOS P GROUP BY P.CPROD,P.DES,P.CANENVASE";



     $sql="SELECT D.CPROD,P.DES,P.CANENVASE,SUM(D.DCAN-D.HCAN) as CANT_CAJAS,SUM(D.DCAN1-D.HCAN1) as CANT_UNIDAD,(SELECT TOP 1 FECHAVEN FROM VSALDOS WHERE CPROD=D.CPROD ORDER BY FECHAVEN DESC) AS FECHAVEN,(SELECT TOP 1 LOTE FROM VSALDOS WHERE CPROD=D.CPROD ORDER BY FECHAVEN DESC) AS LOTE FROM VDETALLE D, APRODUCTOS P WHERE  D.CPROD = P.CPROD AND D.FECHA <= '$fechaFinal' GROUP BY D.CPROD,P.DES,P.CANENVASE;";
     $stmt = $dbh->prepare($sql);
     $stmt->execute();
     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $cod_prod=$row['CPROD'];
        $des_prod=$row['DES'];
        $canenv_prod=$row['CANENVASE'];      
        $saldo_caja=$row['CANT_CAJAS'];  
        $saldo_uni=$row['CANT_UNIDAD'];  
        $fecha_ven=$row['FECHAVEN'];  
        $lote_prod=$row['LOTE'];  
        $saldo_insertar=($saldo_caja*$canenv_prod)+$saldo_uni;
        //if($monto_ven>0){
        ?><tr>
          <td class='font-weight-bold'><?=$nombre?></td>
          <td><?=$cod_prod?></td>
          <td><?=$des_prod?></td>
          <td><?=$canenv_prod?></td>
          <td><?=$saldo_caja?></td>
          <td><?=$saldo_uni?></td>
          <td><?=$saldo_insertar?></td>
          <td><?=$lote_prod?></td>
          <td><?=$fecha_ven?></td>
        </tr><?php
      //}     
     }



  $salidas=0;
  //QUERY PRODUCTOS
  $sql="SELECT s.CPROD FROM APRODUCTOS s WHERE s.STA='A' ORDER BY s.CPROD"; // 
  $verificarConexion=true;
  if($verificarConexion==true){
   $stmt = $dbh->prepare($sql);
   $stmt->execute();$ind=0;
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
     $arrayProductos[$ind]=$row['CPROD'];
     $ind++;
   }  //fin de WHILE 
  }

  $contador++;
  $age1=$alma->age1;
  $cod_existe=verificarAlmacenCiudadExistente($age1);
  $cod_almacen=obtenerCodigoAlmacenPorCiudad($cod_existe);

  for ($i=0; $i <count($arrayProductos); $i++) { 
    $codProducto=$arrayProductos[$i];
    $ventas=0;
    $ingresos=0;
    $salidas=0;
    //QUERY VENTAS
    $sql="SELECT s.CPROD,SUM(s.INGRESO-s.SALIDA) as VENTAS FROM VSALDOS s WHERE s.CPROD=$codProducto GROUP BY s.CPROD"; // 
    $verificarConexion=true;
    if($verificarConexion==true){
     $stmt = $dbh->prepare($sql);
     $stmt->execute();
     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       $ventas+=$row['VENTAS'];
     }  //fin de WHILE 
    }
    //QUERY INGRESOS
    $sql="SELECT vd.CPROD,vd.DIV,SUM(vd.DCAN+vd.DCAN1+vd.HCAN+vd.HCAN1) as INGRESOS FROM VDETALLE vd WHERE DCTO IN (SELECT DCTO FROM VMAESTRO WHERE TIPO in('A','D') AND STA='A') AND vd.CPROD=$codProducto GROUP BY vd.CPROD,vd.DIV"; // 
    $verificarConexion=true;
    if($verificarConexion==true){
     $stmt = $dbh->prepare($sql);
     $stmt->execute();
     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       $ingresos+=$row['INGRESOS'];
     }  //fin de WHILE 
    }
    //QUERY SALIDAS
    $sql="SELECT vd.CPROD,vd.DIV,SUM(vd.DCAN+vd.DCAN1+vd.HCAN+vd.HCAN1) as EGRESOS FROM VDETALLE vd WHERE DCTO IN (SELECT DCTO FROM VMAESTRO WHERE TIPO in('K','F') AND STA IN ('P','A')) AND vd.CPROD=$codProducto GROUP BY vd.CPROD,vd.DIV"; // 
    $verificarConexion=true;
    if($verificarConexion==true){
     $stmt = $dbh->prepare($sql);
     $stmt->execute();
     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       $salidas+=$row['EGRESOS'];
     }  //fin de WHILE 
    }
    
    $kardex=$ingresos-$salidas;
   ?>
    <tr>
      <td><?=$codProducto?></td>
      <td><?=$ventas?></td>
      <td><?=$kardex?></td>
      <td><?=$kardex-$ventas?></td>
  </tr>
   <?php
  }
}
?></table></body>
</html>
