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
$listAlma=obtenerListadoAlmacenesEspecifico("AS");//web service
$contador=0;
$arrayProductos=[];
foreach ($listAlma->lista as $alma) {
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
