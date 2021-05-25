<?php
require_once __DIR__.'/../conexion_externa_farma.php';
require_once '../function_web.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
   VENTAS FARBO
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
</head>
<body class="bg-conexion">
  <style type="text/css"> 
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
<br><br>
<?php 
$fechaInicio="01/01/2000";
$fechaFinal="31/05/2021";

?>
<center><h3><b>VENTAS FARBO</b></h3></center>
<center>
<br>
<div class="col-sm-10 div-center">
<table class="table table-condensed table-bordered ">
  <thead>
    <tr>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Sucursal</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Dcto</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Factura</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Fecha</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Glosa</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Monto</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>RUC/NIT</th>
        <th style='background: #5A8A85 !important;font-weight: bold;'>CLIENTE</th>
        <th style='background: #5A8A85 !important;font-weight: bold;'>CI</th>
        <th style='background: #5A8A85 !important;font-weight: bold;'>FECHA_NAC</th>
        <th style='background: #5A8A85 !important;font-weight: bold;'>TELEFONO</th>
    </tr>
    </thead>
<?php
$listAlma=obtenerListadoAlmacenes();//web service
$contador=0;
foreach ($listAlma->lista as $alma) {
    $contador++;
	  $age1=$alma->age1;
	  $nombre=$alma->des;
	  $direccion=$alma->direc;
	  $age=$alma->age;
	  $ip=$alma->ip;
    
    //CONEXION TEST
    $dbh = new ConexionFarma();
    $dbh->setHost($ip);
    $verificarCon=$dbh->start();
    $estadoHtml="";$estiloFondo="";
    if($verificarCon==true){
        $estadoHtml="<small class='text-success'>Exitosa!</small>";
      //BUSCAR
    }else{
        $estadoHtml="<small class='text-danger'>Problemas!</small>";
    }

    if($verificarCon==true){
       $sql="SELECT FF.DCTO,FF.DOCUM,FF.FECHA,FF.GLO,FF.MFACTURA,FF.RUC,F.CI,(SELECT TOP 1 NOMBRE FROM VCLIENTE WHERE CI=F.CI)CLIENTE,(SELECT TOP 1 FECHA_NAC FROM VCLIENTE WHERE CI=F.CI)FECHA_NAC,(SELECT TOP 1 TELEFONO FROM VCLIENTE WHERE CI=F.CI)TELEFONO FROM VFIDELIZA F JOIN VFICHAM FF ON FF.DCTO=F.DCTO ORDER BY FF.FECHA DESC;";
       $stmt = $dbh->prepare($sql);
       //echo $sql;
       $stmt->execute();
       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $DCTO=$row['DCTO'];
        $DOCUM=$row['DOCUM'];
        $MONTOFACTURA=$row['MFACTURA'];
        $FECHA=$row['FECHA'];
        $GLO=$row['GLO'];
        $RUC=$row['RUC'];
        $CI=$row['CI'];
        $CLIENTE=$row['CLIENTE'];
        $FECHA_NAC=$row['FECHA_NAC'];
        $TELEFONO=$row['TELEFONO'];

        $totales+=$MONTOFACTURA;
        ?><tr><td class='font-weight-bold'><?=$nombre?></td><td><?=$DCTO?></td><td><?=$DOCUM?></td><td><?=strftime('%d-%m-%Y',strtotime($FECHA))?></td><td><?=$GLO?></td><td><?=number_format($MONTOFACTURA,2,'.',',')?></td><td><?=$RUC?></td><td><?=$CLIENTE?></td><td><?=$CI?></td><td><?=$FECHA_NAC?></td><td><?=$TELEFONO?></td></tr><?php
       }
    }
}
?>
<tr class='font-weight-bold'><td colspan="5">TOTALES</td><td><?=number_format($totales,2,'.',',')?></td><td></td></tr>
</table>
</div>
<br><br>
 </center>

</body>
</html>
