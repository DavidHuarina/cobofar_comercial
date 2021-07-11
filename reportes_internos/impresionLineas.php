<?php
ob_start();
error_reporting(0);
require_once('../function_formatofecha.php');
require_once('../conexionmysqli2.inc');
require_once('../funcion_nombres.php');
require_once('../funciones.php');

require_once __DIR__.'/../conexion_externa_farma.php';
require_once '../function_web.php';
?>
<style type="text/css">
body{
  font-size:9px !important;
}
.tabla_detalle td, .tabla_detalle th {
    padding-top: 7px;
    padding-bottom: 6px;
    /*border-bottom: 1px solid #f2f2f2; */
   /* border-style: dashed; border-width: 1px;   */
   border-top: 1px dashed black;
   border-bottom: 1px dashed black;
   font-size:8px !important;
}

.tabla_detalle tbody tr:nth-child(even) {
    background: white;
    -webkit-box-shadow: 0 1px 0 rgba(255,255,255,.8) inset; 
    -moz-box-shadow:0 1px 0 rgba(255,255,255,.8) inset;  
    box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;        
}

.tabla_detalle th {
    text-shadow: 0 1px 0 rgba(255,255,255,1); 
    border-top: 1px dashed black;
    border-bottom: 1px dashed black;
    background-color: white;
    background-image: -webkit-gradient(linear, left top, left bottom, from(#f5f5f5), to(#eee));
    background-image: -webkit-linear-gradient(top, #f5f5f5, #eee);
    background-image:    -moz-linear-gradient(top, #f5f5f5, #eee);
    background-image:     -ms-linear-gradient(top, #f5f5f5, #eee);
    background-image:      -o-linear-gradient(top, #f5f5f5, #eee); 
    background-image:         linear-gradient(top, #f5f5f5, #eee);
}

.tabla_detalle th:first-child {
    -moz-border-radius: 6px 0 0 0;
    -webkit-border-radius: 6px 0 0 0;
    border-radius: 6px 0 0 0;  
}

.tabla_detalle th:last-child {
    -moz-border-radius: 0 6px 0 0;
    -webkit-border-radius: 0 6px 0 0;
    border-radius: 0 6px 0 0;
}

.tabla_detalle th:only-child{
    -moz-border-radius: 6px 6px 0 0;
    -webkit-border-radius: 6px 6px 0 0;
    border-radius: 6px 6px 0 0;
}

.tabla_detalle tfoot td {
    border-bottom: 0;
    border-top: 1px solid #fff;
    background-color: #f1f1f1;  
}

.tabla_detalle tfoot td:first-child {
    -moz-border-radius: 0 0 0 6px;
    -webkit-border-radius: 0 0 0 6px;
    border-radius: 0 0 0 6px;
}

.tabla_detalle tfoot td:last-child {
    -moz-border-radius: 0 0 6px 0;
    -webkit-border-radius: 0 0 6px 0;
    border-radius: 0 0 6px 0;
}

.tabla_detalle tfoot td:only-child{
    -moz-border-radius: 0 0 6px 6px;
    -webkit-border-radius: 0 0 6px 6px
    border-radius: 0 0 6px 6px
}
</style>
<?php 
$fechaFinal="07/07/2021";
?>
<center><h3><b>STOCK DE EXISTENCIA EN ALMACENES AL <?=$fechaFinal?></b></h3></center>
<center><h3><b>SUCURSAL : SOPOCACHI </b></h3></center>
<table class="table table-condensed table-bordered " border="1">
  <thead>
    <tr>
        <th style='background: #FFF !important;font-weight: bold;'>CODIGO</th>
        <th style='background: #FFF !important;font-weight: bold;'>PRODUCTO</th>
        <th style='background: #FFF !important;font-weight: bold;'>DIVISIBLE</th>
        <th style='background: #FFF !important;font-weight: bold;'>PROVEEDOR</th>
        <th style='background: #FFF !important;font-weight: bold;'>LINEA</th>
        <th style='background: #FFF !important;font-weight: bold;'>CAJAS</th>
        <th style='background: #FFF !important;font-weight: bold;'>SUELTAS</th>
        <th style='background: #FFF !important;font-weight: bold;'>EXISTENCIA<BR>CAJAS</th>
        <th style='background: #FFF !important;font-weight: bold;'>EXISTENCIA<BR>SUELTAS</th>
    </tr>
   </thead>  
<?php
$listAlma=obtenerListadoAlmacenesAlgunos("A;");
foreach ($listAlma->lista as $alma) {
      $age1=$alma->age1;
      $nombre=$alma->des;
      $ip=$alma->ip;
      
      $ageAlma=utf8_decode($age1);
      $dbh = conexionSqlServer($ip,"Gestion"); 
      $ingresos=[];
      $ingresos_unidad=[];
      $salida=[];
      $salida_unidad=[];
      if($dbh!=false){
       //INGRESOS
       $sqlIngreso="SELECT MA.CPROD,MA.DES,MA.CANENVASE,P.DES AS PROVEEDOR,PL.DES AS LINEA,I.INGRESO,I.INGRESO_UNIDAD,E.SALIDA,E.SALIDA_UNIDAD FROM APRODUCTOS MA,(SELECT D.CPROD,ISNULL(SUM(D.DCAN-D.HCAN),0)INGRESO,ISNULL(SUM(D.DCAN1-D.HCAN1),0)INGRESO_UNIDAD FROM VDETALLE D WHERE D.TIPO in ('A','D','S','I') AND AGE1='$ageAlma' and D.FECHA<='$fechaFinal' GROUP BY D.CPROD) I,(SELECT D.CPROD,ISNULL(SUM(D.DCAN-D.HCAN),0)SALIDA,ISNULL(SUM(D.DCAN1-D.HCAN1),0)SALIDA_UNIDAD FROM VDETALLE D WHERE D.TIPO in ('K','F','O') AND AGE1='$ageAlma' and D.FECHA<='$fechaFinal' GROUP BY D.CPROD)E,
        PROVEESLINEA PL,
        PROVEEDORES P
       WHERE MA.CPROD=I.CPROD AND MA.CPROD=E.CPROD AND PL.IDSLINEA=MA.IDSLINEA AND P.IDPROVEEDOR=MA.IDPROVEEDOR AND (I.INGRESO>0 OR I.INGRESO_UNIDAD>0 OR E.SALIDA>0 OR E.SALIDA_UNIDAD>0) ORDER BY P.DES";
        $stmt=sqlsrv_query($dbh,$sqlIngreso);
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
           $CPROD=$row['CPROD'];
           $DES=$row['DES'];
           $CANENVASE=$row['CANENVASE'];
           $PROVEEDOR=$row['PROVEEDOR'];
           $LINEA=$row['LINEA'];
           $INGRESO=$row['INGRESO'];
           $INGRESO_UNIDAD=$row['INGRESO_UNIDAD'];
           $SALIDA=$row['SALIDA'];
           $SALIDA_UNIDAD=$row['SALIDA_UNIDAD'];


           $totalIngresosUnidad=$INGRESO+($INGRESO_UNIDAD/$CANENVASE);
           $totalIngresosCajas=$INGRESO+($INGRESO_UNIDAD/$CANENVASE);
           $totalSalidas=abs($SALIDA)+(abs($SALIDA_UNIDAD)/$CANENVASE); 

           $SALDO_UNIDAD=$INGRESO_UNIDAD-abs($SALIDA_UNIDAD);
           $SALDO=$INGRESO-abs($SALIDA);
           
        if(($SALDO_UNIDAD+$SALDO)>0){
           ?><tr>
               <td><?=$CPROD?></td>
               <td><?=$DES?></td>
               <td><?=$CANENVASE?></td>
               <td><?=$PROVEEDOR?></td>
               <td><?=$LINEA?></td>
               <td><?=$SALDO?></td>
               <td><?=$SALDO_UNIDAD?></td>
               <td></td>
               <td></td>
             </tr><?php
           }
        }      
          //echo $sqlSalida;
      }  
}
?>
   </table>

<?php
$html = ob_get_clean();
descargarPDFControlado("LINEAS DE INVENTARIO",$html);  



function conexionSqlServer($ip,$database){
  $serverName = $ip;
  $uid = "sistema";     
  $pwd = "sistema";
  if($ip!="10.10.1.11"){
     $pwd="B0l1v14.@1202";
  }   
  $databaseName = $database;  
  $connectionInfo = array("UID" => $uid, "PWD" => $pwd, "Database"=>$databaseName);  
  $conn = sqlsrv_connect( $serverName, $connectionInfo);  
  if( $conn ){  
    return $conn;
  }else{  
     return false;
  }  

}