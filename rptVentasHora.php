<html>
<head>
  <meta charset="utf-8" />
</head>
<body>
<?php
set_time_limit(0);
require('estilos_reportes_almacencentral.php');
require('function_formatofecha.php');
require('conexionmysqli.inc');
require('funcion_nombres.php');
require('funciones.php');
require('function_weboficial.php');
$fecha_ini=$_GET['fecha_ini'];
$fecha_fin=$_GET['fecha_fin'];
//desde esta parte viene el reporte en si
$fecha_iniconsulta=$fecha_ini;
$fecha_finconsulta=$fecha_fin;


$rpt_territorio=$_GET['codTipoTerritorio'];
$fecha_reporte=date("d/m/Y");
$nombre_territorio=obtenerNombreSucursalAgrupado($rpt_territorio);
$nombre_territorio=str_replace(",",", ", $nombre_territorio);
?><style type="text/css"> 
        thead tr th { 
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #ffffff;
        }
    
        .table-responsive { 
            height:200px;
            overflow:scroll;
        }
    </style>
<table style='margin-top:-90 !important' align='center' class='textotit' width='70%'><tr><td align='center'>Reporte Ventas x Sucursal X Hora
  <br> De: <?=$fecha_ini?> A: <?=$fecha_fin?>
  <br>Fecha Reporte: <?=$fecha_reporte?></tr></table>
  <center><div style='width:70%;text-align:center;'><b>Sucursales:</b><br><small><?=$nombre_territorio?></small></div></center>
<?php

setlocale(LC_ALL, 'es_ES');
$tiempoInicio = strtotime($fecha_iniconsulta);//obtener tiempo de inicio
$tiempoFin = strtotime(date("Y-m-t", strtotime($fecha_finconsulta)).""); //obtener el tiempo final pero al ultimo día, para que muestre todos los meses
?>
<br><center><table align='center' class='texto' width='70%' id='ventasSucursal'>
  <thead>
<tr><th>&nbsp;</th><th width="20%" style="background: #E6E1DF">Hora</th><th align="right" style="background: #E6E1DF">Cantidad Atenciones</th><th align="right" style="background: #E6E1DF">Monto</th><th align="right" style="background: #E6E1DF">% Cantidad</th><th align="right" style="background: #E6E1DF">% Monto</th>
</tr><!--<th style="background: #E6E1DF">Sucursal</th>-->
</thead>
<tbody>
<?php
//$sqlSucursal="select cod_ciudad, descripcion from ciudades where cod_ciudad in ($rpt_territorio) order by descripcion";
//$respSucursal=mysqli_query($enlaceCon,$sqlSucursal);
$index=0;
//while($datosSuc=mysqli_fetch_array($respSucursal)){ 
  //$codigoSuc=$datosSuc[0];
  //$nombreSuc=$datosSuc[1];
  $datosTotal=obtenerMontoVentasHoraTotal($fecha_iniconsulta,$fecha_finconsulta,$rpt_territorio);
  $montoTotal=number_format($datosTotal[1],2,'.','');
  $cantidadTotal=number_format($datosTotal[0],2,'.','');
  $arrPor=[]; 
  $arrPorCant=[];  
  for ($i=0; $i < 24 ; $i++) { 
    $hora=$i.":00 - ".$i.":59";   
    $datos=obtenerMontoVentasHora($fecha_iniconsulta,$fecha_finconsulta,$rpt_territorio,$i);
    $cantHora=$datos[0];
    $montoHora=$datos[1];
    if($montoTotal>0){
      $porc=(number_format($montoHora,2,'.','')*100)/$montoTotal;   
    }else{
      $porc=0; 
    }
    if($cantidadTotal>0){
      $porcCnt=(number_format($cantHora,2,'.','')*100)/$cantidadTotal;   
    }else{
      $porcCnt=0; 
    }
    $arrPor['0_'.$i]=$porc;   
    //$arrPorCant['c_0_'.$i]=$porcCnt;    
    $arrPorCant['0_'.$i]=$porcCnt;    
    ?><tr id="0_<?=$i?>"><td>&nbsp;</td><td><b><?=$hora?></b></td><td align="right"><?=$datos[0]?></td><td align="right"><?=number_format($montoHora,2,'.',',')?></td><td id="c_0_<?=$i?>" align="right"><?=number_format($porcCnt,2,'.','')." %"?></td><td align="right"><?=number_format($porc,2,'.','')." %"?></td></tr>
    <?php       
  }
  $ind = array_search(max($arrPor),$arrPor); 
  $ind2 = array_search(max($arrPorCant),$arrPorCant); 
    ?><script type="text/javascript">$("#<?=$ind?>").attr("style","background:#44C28B;color:white;");</script><script type="text/javascript">$("#<?=$ind2?>").attr("style","background:#FF5733;color:white;");</script><?php
//}
  
?>
</tbody><tfoot><tr></tr></tfoot></table></center></br>
<?php include("imprimirInc.php");
?>
<script type="text/javascript">
  totalesTablaVertical('ventasSucursal',2,1);
</script>
</body></html>