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
   VENTAS SALDOS
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
$idProveedor=implode(",",$_POST["proveedor"]);
$fechaI=explode("-",$_POST["desde"]);
$fechaF=explode("-",$_POST["hasta"]);
$fechaInicio=$fechaI[2]."/".$fechaI[1]."/".$fechaI[0];
$fechaFinal=$fechaF[2]."/".$fechaF[1]."/".$fechaF[0];
//CONEXION TEST
/*$dbh = new ConexionFarma();
$sql="SELECT DES FROM PROVEEDORES WHERE IDPROVEEDOR=$idProveedor";
$stmt = $dbh->prepare($sql);
$stmt->execute();*/
$nombreProveedor="";
/*while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
   $nombreProveedor=$row['DES']; 
}*/
?>
<center><h3><b>PRODUCTOS VENTAS Y SALDO</b></h3></center>
<a href="rptOpVentasSaldos.php" class="btn btn-danger">VOLVER</a>
<center>
<br>
<div class="col-sm-10 div-center">
<table class="table table-condensed table-bordered ">
  <thead>
    <tr>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Sucursal</th>
        <!--<th style='background: #EFDCA2 !important;font-weight: bold;'>Proveedor</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Linea</th>-->
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Codigo</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Descripcion</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Cantidad<br>Venta</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Monto<br>Venta</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Saldo</th>
    </tr>
   </thead>
<?php
$listAlma=obtenerListadoAlmacenes(); //obtenerListadoAlmacenes();//web service obtenerListadoAlmacenesEspecifico("Aë");//web service 
$dbh = new ConexionFarma();
$sql="SELECT p.IDPROVEEDOR,(SELECT DES FROM PROVEEDORES WHERE IDPROVEEDOR=p.IDPROVEEDOR) AS DES_PROV,p.IDSLINEA,(SELECT DES FROM PROVEESLINEA WHERE IDSLINEA=p.IDSLINEA) AS DES_LINEA,
  p.CPROD,p.DES
  FROM APRODUCTOS p  
  WHERE p.IDPROVEEDOR in ($idProveedor) ORDER BY p.IDSLINEA;";
$stmt = $dbh->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
   $cod_prov=$row['IDPROVEEDOR'];
   $cod_linea=$row['IDSLINEA'];
   $cod_prod=$row['CPROD'];
   $des_prov=$row['DES_PROV'];
   $des_linea=$row['DES_LINEA'];
   $des_prod=$row['DES'];

   foreach ($listAlma->lista as $alma) {
      $age1=$alma->age1;
      $nombre=$alma->des;
      $ip=$alma->ip;
      $datosVentas=obtenerValoresVentasProducto($cod_prod,$ip,$fechaInicio,$fechaFinal);
      $cant_ven=$datosVentas[0];
      $monto_ven=$datosVentas[1];
      $saldo_prod=$datosVentas[2];
      //if($monto_ven>0){
        ?><tr>
          <td class='font-weight-bold'><?=$nombre?></td>
          <!--<td><?=$des_prov?></td>
          <td><?=$des_linea?></td>-->
          <td><?=$cod_prod?></td>
          <td><?=$des_prod?></td>
          <td><?=$cant_ven?></td>
          <td><?=number_format($monto_ven,2,'.',',')?></td>
          <td><?=$saldo_prod?></td>
        </tr><?php
      //}     
   }
}
?>
  </table>
  </div>
 </center>
</body>
</html>
