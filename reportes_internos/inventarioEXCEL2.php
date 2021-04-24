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
        <!--<th style='background: #EFDCA2 !important;font-weight: bold;'>Cod<br>Sucursal</th>-->
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Sucursal</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Codigo</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Descripcion</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Cantidad<br>Pres</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Saldo<br>Cajas</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Saldo<br>Unidad</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Lote</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Fecha<br>Vencimiento</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Fecha<br>Documento</th>
    </tr>
   </thead>  
<?php
$listAlma=obtenerListadoAlmacenes();//=obtenerListadoMarkets(utf8_decode($idCiudad));
foreach ($listAlma->lista as $alma) {
      $age1=$alma->age1;
      $nombre=$alma->des;
      $ip=$alma->ip;

     $dbh = ConexionFarma($ip,"Gestion");
     $sql="SELECT S.CPROD,P.DES,S.TIPO,MAX(S.FECHAVEN) AS FECHAVEN,(SELECT TOP 1 SA.LOTE FROM VSALDOS SA WHERE SA.CPROD=S.CPROD ORDER BY SA.FECHAVEN DESC) AS LOTE,P.CANENVASE,sum(S.INGRESO- S.SALIDA) AS SALDO,(SELECT TOP 1 D.FECHA FROM VDETALLE D WHERE D.CPROD=S.CPROD ORDER BY D.FECHA DESC) AS FECHAD
      FROM VSALDOS S
      JOIN APRODUCTOS P ON P.CPROD=S.CPROD
      GROUP BY S.CPROD,P.DES,S.TIPO,P.CANENVASE;";
     $stmt = $dbh->prepare($sql);
     $stmt->execute();
     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $cod_prod=$row['CPROD'];
        $des_prod=$row['DES'];
        $canenv_prod=$row['CANENVASE'];      
        $tipo=$row['TIPO'];  
        $fecha_ven=$row['FECHAVEN'];  
        $lote_prod=$row['LOTE']; 
        $fecha_ingreso=$row['FECHAD']; 
        if($tipo=="C"){
          $saldo_caja=$row['SALDO'];
          $saldo_uni=0;
        }else{
          $saldo_uni=$row['SALDO'];
          $saldo_caja=0;
        }
        if(($saldo_uni+$saldo_uni)>0){
        ?><tr>
          <td class='font-weight-bold'><?=$nombre?></td>
          <td><?=$cod_prod?></td>
          <td><?=$des_prod?></td>
          <td><?=$canenv_prod?></td>
          <td><?=$saldo_caja?></td>
          <td><?=$saldo_uni?></td>
          <td><?=$lote_prod?></td>
          <td><?=$fecha_ven?></td>
          <td><?=$fecha_ingreso?></td>
        </tr><?php
      }     
     }
}

?>
   </table>
