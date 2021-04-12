<?php
ini_set('memory_limit','1G');
set_time_limit(0);
require_once __DIR__.'/../conexion_externa_farma.php';
require_once '../function_web.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
   PRODUCTOS INVENTARIO
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
$idCiudad=implode(" ",$_POST["sucursales"]);
$fechaF=explode("-",$_POST["hasta"]);
$fechaFinal=$fechaF[2]."/".$fechaF[1]."/".$fechaF[0];
?>
<center><h3><b>PRODUCTOS INVENTARIO</b></h3></center>
<a href="rptOpInventario.php" class="btn btn-danger">VOLVER</a>
<center>
<br>
<div class="col-sm-10 div-center">
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
$dbh = new ConexionFarma();
$sql="SELECT p.IDPROVEEDOR,(SELECT DES FROM PROVEEDORES WHERE IDPROVEEDOR=p.IDPROVEEDOR) AS DES_PROV,p.IDSLINEA,(SELECT DES FROM PROVEESLINEA WHERE IDSLINEA=p.IDSLINEA) AS DES_LINEA,
  p.CPROD,p.DES,p.CANENVASE,p.DIV
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
   $canenv_prod=$row['CANENVASE'];

   foreach ($listAlma->lista as $alma) {
      $age1=$alma->age1;
      $nombre=$alma->des;
      $ip=$alma->ip;
      $datosVentas=obtenerValoresSaldosProducto($cod_prod,$ip,$fechaFinal);
      $saldo_caja=$datosVentas[0];
      $saldo_uni=$datosVentas[1];
      $fecha_ven=$datosVentas[2];
      $lote_prod=$datosVentas[3];
      $saldo_insertar=($saldo_caja*$canenv_prod)+$saldo_uni;
      //if($monto_ven>0){
        ?><tr>
          <td><?=utf8_decode($age1)?></td>
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
  </div>
 </center>
</body>
</html>
