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
   MEDICOS - RECETAS
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
$fechaInicio="01/01/2021";
$fechaFinal="30/06/2021";

?>
<center><h3><b>VENTAS FARBO</b></h3></center>
<center>
<br>
<div class="col-sm-10 div-center">
<table class="table table-condensed table-bordered ">
  <thead>
    <tr>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Sucursal</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>IDMEDICO</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>NOMBRE</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>MATRICULA</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>DIREC</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>ESPE1</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>ESPE2</th>
        <th style='background: #5A8A85 !important;font-weight: bold;'>CANTIDAD</th>
        <th style='background: #5A8A85 !important;font-weight: bold;'>INSTITUTO</th>
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

       //$sql="SELECT M.IDMEDICO,M.DES AS NOMBRE,M.MATRICULA,M.DIREC,M.ESPE1,M.ESPE2,COUNT(R.DCTO),(SELECT TOP 1 INSTITUTO FROM VRECETA WHERE IDMEDICO=M.IDMEDICO AND INSTITUTO!='' ORDER BY FECHA DESC)INSTITUTO from VMEDICO M  JOIN VRECETA R ON R.IDMEDICO=R.IDMEDICO GROUP BY M.IDMEDICO,M.DES,M.MATRICULA,M.DIREC,M.ESPE1,M.ESPE2";
      $sql="SELECT n.* FROM (select DISTINCT M.IDMEDICO,M.DES AS NOMBRE,M.MATRICULA,M.DIREC,M.ESPE1,M.ESPE2,(SELECT COUNT(*) FROM VRECETA WHERE IDMEDICO=M.IDMEDICO)CANTIDAD,(SELECT TOP 1 INSTITUTO FROM VRECETA WHERE IDMEDICO=M.IDMEDICO AND INSTITUTO!='' ORDER BY FECHA DESC)INSTITUTO FROM VMEDICO M) n WHERE n.cantidad>0;";
       $stmt = $dbh->prepare($sql);
       //echo $sql;
       $stmt->execute();
       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $IDMEDICO=$row['IDMEDICO'];
        $NOMBRE=$row['NOMBRE'];
        $MATRICULA=$row['MATRICULA'];
        $DIREC=$row['DIREC'];
        $ESPE1=$row['ESPE1'];
        $ESPE2=$row['ESPE2'];
        $CANTIDAD=$row['CANTIDAD'];
        $INSTITUTO=$row['INSTITUTO'];
        ?><tr><td class='font-weight-bold'><?=$nombre?></td><td><?=$IDMEDICO?></td><td><?=$NOMBRE?></td><td><?=$MATRICULA?></td><td><?=$DIREC?></td><td><?=$ESPE1?></td><td><?=$ESPE2?></td><td><?=$CANTIDAD?></td><td><?=$INSTITUTO?></td></tr><?php
       }
    }
}
?>
</table>
</div>
<br><br>
 </center>

</body>
</html>
