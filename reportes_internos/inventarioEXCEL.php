<?php
header("Pragma: public");
header("Expires: 0");
$filename = "datos_market.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

require_once __DIR__.'/../conexion_externa_farma.php';
require_once '../function_web.php';
?>
<?php 
$idProveedor=implode(",",$_POST["proveedor"]);
$idCiudad=implode(" ",$_POST["sucursales"]);
$fechaF=explode("-",$_POST["hasta"]);
$fechaFinal=$fechaF[2]."/".$fechaF[1]."/".$fechaF[0];
?>
<center><h3><b>PRODUCTOS INVENTARIO</b></h3></center>
<table class="table table-condensed table-bordered ">
  <thead>
    <tr>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Cod<br>Sucursal</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Sucursal</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Codigo</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Descripcion</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Cantidad<br>Pres</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Saldo<br>Cajas</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Saldo<br>Unidad</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Saldo<br>Insertar</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Lote</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Fecha<br>Vencimiento</th>
    </tr>
   </thead>  
<?php
$listAlma=obtenerListadoAlmacenesAlgunos(utf8_decode($idCiudad));
foreach ($listAlma->lista as $alma) {
      $age1=$alma->age1;
      $nombre=$alma->des;
      $ip=$alma->ip;

     $dbh = ConexionFarma($ip,"Gestion");
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
}

?>
   </table>
