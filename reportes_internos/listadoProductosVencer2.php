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
   PRODUCTOS A VENCER
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
$idProveedor=$_POST["proveedor"];
$fechaI=explode("-",$_POST["desde"]);
$fechaF=explode("-",$_POST["hasta"]);
$fechaInicio=$fechaI[2]."/".$fechaI[1]."/".$fechaI[0];
$fechaFinal=$fechaF[2]."/".$fechaF[1]."/".$fechaF[0];
//echo $idProveedor.":".$fechaInicio."      ".$fechaFinal;
//CONEXION TEST
$dbh = new ConexionFarma();
$sql="SELECT DES FROM PROVEEDORES WHERE IDPROVEEDOR=$idProveedor";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$nombreProveedor="";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
   $nombreProveedor=$row['DES']; 
}
?>
<center><h3><b>PRODUCTOS A VENCER <?=$nombreProveedor?></b></h3></center>
<a href="listadoProductosVencerGenerico.php" class="btn btn-danger">VOLVER</a>
<center>
<br>
<div class="col-sm-10 div-center">
<table class="table table-condensed table-bordered ">
  <thead>
    <tr>
        <th style='background: #EFDCA2 !important;font-weight: bold;' rowspan="3">Sucursal</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;' rowspan="3">Proveedor</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;' rowspan="3">Linea</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;' rowspan="3">Codigo</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;' rowspan="3">Descripcion</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;' rowspan="3">Fecha V.</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;' rowspan="3">Precio<br>Venta</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;' colspan="6" class='csp' align="center">Cantidad</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;' rowspan="3">Precio<br>Compra</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;' rowspan="3">Precio<br>Total<br>Compra</th>
    </tr>
    <tr style='background: #EFDCA2 !important;font-weight: bold;'>
        <th style='background: #EFDCA2 !important;font-weight: bold;' colspan="2" class='csp' align="center">Entrada</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;' colspan="2" class='csp' align="center">Salida</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;' colspan="2" class='csp' align="center">Saldo</th>
    </tr>
    <tr style='background: #EFDCA2 !important;font-weight: bold;'>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Caja</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Suelta</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Caja</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Suelta</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Caja</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Suelta</th>
    </tr>
    </thead>
<?php
$listAlma=obtenerListadoAlmacenes();//web service
$contador=0;$contadorError=0;$totales=0;
foreach ($listAlma->lista as $alma) {
    $contador++;
	$age1=$alma->age1;
	$nombre=$alma->des;
	$direccion=$alma->direc;
	$age=$alma->age;
	$ip=$alma->ip;
	$tipo=1;// TIPO DE CIUDAD
    $estado=1;
    if($alma->tipo=="E"){
    	$estado=2;
    }
    
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
       $sql="SELECT p.IDPROVEEDOR,(SELECT DES FROM PROVEEDORES WHERE IDPROVEEDOR=p.IDPROVEEDOR) AS DES_PROV,p.IDSLINEA,(SELECT DES FROM PROVEESLINEA WHERE IDSLINEA=p.IDSLINEA) AS DES_LINEA,
           s.CPROD,p.DES,s.FECHAVEN,s.PRECIOVENT,s.TIPO,s.INGRESO,s.SALIDA,s.INGRESO-s.SALIDA as SALDO,s.PRECIOCOMP,s.PRECIOCOMP*(s.INGRESO-s.SALIDA) AS TOTAL FROM VSALDOS s,APRODUCTOS p  WHERE s.CPROD=p.CPROD AND s.FECHAVEN BETWEEN '$fechaInicio 00:00:00' AND '$fechaFinal 23:59:59' AND s.FECHAVEN<='$fechaFinal 23:59:59' AND s.INGRESO!=s.SALIDA AND AGE1='$age1' AND p.IDPROVEEDOR in($idProveedor) ORDER BY p.IDSLINEA;";
       $stmt = $dbh->prepare($sql);
       //echo $sql;
       $stmt->execute();
       $codLinea=0;
       $codProv=0;
       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        /*if($codProv!=$row['IDPROVEEDOR']){
            ?><tr style='background: #EFDCA2;font-weight: bold;'><td colspan="12">&nbsp;<?=$row['DES_PROV']?></td></tr><?php
            $codProv=$row['IDPROVEEDOR'];
        }
        if($codLinea!=$row['IDSLINEA']){
            ?><tr style='background: #C4C1C2;font-weight: bold;'><td colspan="12">&nbsp;&nbsp;&nbsp;&nbsp;<?=$row['DES_LINEA']?></td></tr><?php
            $codLinea=$row['IDSLINEA'];
        }*/

        $codProv=$row['IDPROVEEDOR'];
        $codLinea=$row['IDSLINEA'];
        $codigoProd=$row['CPROD'];
        if($row['TIPO']=='C'){
           $icaja=$row['INGRESO'];
           $isuelta=0; 
           $scaja=$row['SALIDA'];
           $ssuelta=0; 
           $saldo=0;
           $saldocaja=$icaja-$scaja;
        }else{
           $icaja=0;
           $isuelta=$row['INGRESO']; 
           $scaja=0;
           $ssuelta=$row['SALIDA']; 
           $saldocaja=0;
           $saldo=$isuelta-$ssuelta;
        }
        $totales+=number_format($row['TOTAL'],2,'.','');
        ?><tr><td class='font-weight-bold'><?=$nombre?></td><td><?=$row['DES_PROV']?></td><td><?=$row['DES_LINEA']?></td><td><?=$row['CPROD']?></td><td><?=$row['DES']?></td><td><?=strftime('%d-%m-%Y',strtotime($row['FECHAVEN']))?></td><td><?=number_format($row['PRECIOVENT'],2,'.',',')?></td><td><?=$icaja?></td><td><?=$isuelta?></td><td><?=$scaja?></td><td><?=$ssuelta?></td><td><b><?=$saldocaja?></b></td><td><b><?=$saldo?></b></td><td><?=number_format($row['PRECIOCOMP'],2,'.',',')?></td><td><?=number_format($row['TOTAL'],2,'.',',')?></td></tr><?php
       }
    }else{
      ?><tr><td colspan="12">NO HAY CONEXION</td></tr><?php
    }
}
?>
<tr class='font-weight-bold'><td colspan="14">TOTALES</td><td><?=number_format($totales,2,'.',',')?></td></tr>
</table>
</div>
<br><br>
 </center>

</body>
</html>
