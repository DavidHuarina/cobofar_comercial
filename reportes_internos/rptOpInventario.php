<?php
//$estilosVenta=1;
require_once __DIR__.'/../conexion_externa_farma.php';
require_once '../conexionmysqli.inc';
require_once '../function_web.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
   REPORTE VENTAS VS SALDOS
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  
</head>
<body class="bg-conexion">
<br><br>
<?php
$fechaFinal=obtenerValorConfiguracion(15);
$fech=explode("/",$fechaFinal);
$fecha_hasta=$fech[2]."-".$fech[1]."-".$fech[0];
?>
<center><h3><b>REPORTE INVENTARIOS</b></h3></center>
<center>
<br>
<div class="col-sm-10 div-center">
  <form method="POST" action="inventario.php">
    <table class="table table-condensed table-bordered ">
    <tr class="">
        <td>PROVEEDOR:</td>
        <td><select name='proveedor[]' class='selectpicker form-control' data-live-search="true" data-style='btn btn-primary' multiple data-search="true" data-actions-box='true'><?php 
        $dbh = new ConexionFarma();
        $sql="SELECT IDPROVEEDOR,DES FROM PROVEEDORES order by des";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
           $codProveedor=$row['IDPROVEEDOR'];
           $desProveedor=$row['DES']; 
           ?><option value='<?=$codProveedor?>'><?=$desProveedor?></option><?php
        }
        ?></select></td>
    </tr>
    <tr class="">
        <td>SUCURSALES:</td>
        <td><select name='sucursales[]' class='selectpicker form-control' data-live-search="true" data-style='btn btn-primary' multiple data-search="true" data-actions-box='true'><?php 
        $dbh = new ConexionFarma();
        $sql="SELECT AGE1,DES FROM ALMACEN where TIPO='X' OR CODIGO IN (122,130,7,126,134) order by des";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
           $codCiudad=$row['AGE1'];
           $desCiudad=$row['DES']; 
           ?><option value='<?=utf8_decode($codCiudad)?>'><?=utf8_decode($codCiudad);?>  <?=utf8_decode($desCiudad)?></option><?php
        }
        ?></select></td>
    </tr>
    <tr class="">
        <td>HASTA:</td>
        <td><input type="date" name="hasta" class='form-control' value='<?=$fecha_hasta?>'></td>
    </tr>
   </table>
   <button type="submit" class="btn btn-success">VER REPORTE</button>
  </form> 
</div>
<br><br>
 </center>

</body>
</html>
