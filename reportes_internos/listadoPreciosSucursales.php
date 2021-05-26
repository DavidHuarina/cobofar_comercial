<?php
ini_set('memory_limit','1G');
set_time_limit(0);
error_reporting(0);
header("Pragma: public");
header("Expires: 0");
$filename = "datos_market.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

require_once __DIR__.'/../conexion_externa_farma.php';
require_once '../conexionmysqli2.inc';
require_once '../function_web.php';
$sqlProd="SELECT codigo_material,descripcion_material,cantidad_presentacion FROM material_apoyo WHERE estado=1;";           
$respProd=mysqli_query($enlaceCon,$sqlProd);
$listAlma=obtenerListadoAlmacenes();
?>
<center><h3><b>PRODUCTOS PRECIOS</b></h3></center>
<table class="table table-condensed table-bordered ">
  <thead>
    <tr>
        <th style='background: #EFDCA2;font-weight: bold;'>#</th>
        <th style='background: #EFDCA2;font-weight: bold;'>Codigo</th>
        <th style='background: #EFDCA2;font-weight: bold;'>Descripcion</th>
        <th style='background: #EFDCA2;font-weight: bold;'>Div</th>
        <?php
        foreach ($listAlma->lista as $alma) {
          ?><td style='background: #EFDCA2;font-weight: bold;'><?=$alma->des?></td><?php
        }
        ?>
    </tr>
   </thead>
<?php
$indexMat=1;
while($detProd=mysqli_fetch_array($respProd)){ 
   $codigo = $detProd[0];
   $des_prod = $detProd[1];
   $cant_pre = $detProd[2];
   $totalFila=0;
   $precios_data=[];
   $htmlFila="";
   $htmlFila.="
          <td style='background: #97DAEC'>".$indexMat."</td>
          <td style='background: #97DAEC'>".$codigo."</td>
          <td style='background: #97DAEC'>".$des_prod."</td>
          <td style='background: #97DAEC'>".$cant_pre."</td>";
   $index=0;
   foreach ($listAlma->lista as $alma) {
      $age1=$alma->age1;
      $ip=$alma->ip;         
      $dbh = ConexionFarma($ip,"Gestion");
      $precioUnit=0;
      if($dbh!=false){
         $sql="SELECT TOP 1 P.CPROD,P.DES,S.TIPO,S.FECHAVEN VENCIMIENTO,S.LOTE,S.REGISTRO,S.PRECIOVENT,S.PRECIOCOMP,S.PRECIOCOSTO, S.PRECIOUNIT PRECIO,O.DES PROVEEDOR, P.DIV, P.SICO, P.CANENVASE, O.DESCTO,S.INGRESO- S.SALIDA AS SALDO 
      FROM VSALDOS S
      JOIN APRODUCTOS P ON P.CPROD=S.CPROD AND  P.CPROD='$codigo'
      JOIN PROVEEDORES O ON P.IDPROVEEDOR=O.IDPROVEEDOR
      WHERE AGE1='$age1' AND S.INGRESO<>S.SALIDA
      ORDER BY P.CPROD,S.FECHAVEN;";
         $stmt = $dbh->prepare($sql);
         $stmt->execute();
         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pre=(float)$row['PRECIO'];
            $desc=(float)$row['DESCTO'];            
            $precioUnit=$pre-number_format($pre*($desc/100),2,'.',''); //PROCESO ANTERIOR
         }    
      }
      $precios_data[$index]=$precioUnit;
      $totalFila+=$precioUnit;
      if($precioUnit<=0){
        $htmlFila.="<td style='background: #FCA78D;'>".number_format($precioUnit,2,'.',',')."</td>";
      }else{
        $htmlFila.="<td>".number_format($precioUnit,2,'.',',')."</td>";
      }       
      $dbh = null;
      $index++;
  }
  $htmlFila.="</tr>";

  if($totalFila>0){
    $maximo=max($precios_data);
    $margen=($maximo*7)/100;
    $error=0;
    for ($al=0; $al < count($precios_data); $al++) { 
      if($precios_data[$al]>0&&($precios_data[$al]<($maximo-$margen)||$precios_data[$al]>($maximo+$margen))){
         $error++;
      }
    }
    if($error>0){
      echo "<tr style='background:#96079D !important;color:#fff;'>".$htmlFila;
    }else{
      echo "<tr>".$htmlFila;
    }    
  }
  $indexMat++;
}
?>
  </table>
