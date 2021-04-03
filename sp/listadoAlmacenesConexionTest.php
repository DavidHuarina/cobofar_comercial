<?php
require_once __DIR__.'/../conexion_externa_farma.php';
$estilosVenta=1;
require '../conexionmysqli.inc';
require_once '../function_web.php';
?>
<!DOCTYPE html>
<html>

<head>
	<title>CONEXION SUCURSALES</title>
	<meta charset="utf-8">
    <style type="text/css">
        .bg-conexion{
            background-image: url('../imagenes/conexion.jpg'); color:#CBC7C6; width: 100%; height: 100vh; 
        }
    </style>
</head>
<body class="bg-conexion">
<br><br>
<center><h3><b>TEST SUCURSALES</b></h3></center>

<center>
    <p>Hora de inicio de consulta:<?=date("d/m/Y H:i")?></p>
<br>
<div class="col-sm-8 div-center">
<table class="table table-sm table-bordered text-white">
    <tr class="bg-info text-white">
        <td>N.</td>
        <td>AGE1</td>
        <td>NOMBRE</td>
        <td>IP</td>
        <td>ESTADO</td>
    </tr>
<?php
$listAlma=obtenerListadoAlmacenes();//web service
$contador=0;$contadorError=0;
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
        $estadoHtml="<i class='material-icons text-success'>check</i>";
    }else{
        $contadorError++;
        $estadoHtml="<i class='material-icons text-danger'>close</i>";
        $estiloFondo="bg-warning text-dark";
    }
    ?>
    <tr class="<?=$estiloFondo?>">
        <td><?=$contador?></td>
        <td><?=$age1?></td>
        <td><?=$nombre?></td>
        <td><?=$ip?></td>
        <td><?=$estadoHtml?></td>
    </tr>
    <?php
}
?></table>
<table class="table table-sm table-bordered text-white">
    <tr><td class="font-weight-bold bg-info text-white">TOTAL SUCURSALES</td><td><?=$contador?></td></tr>
    <tr><td class="font-weight-bold bg-info text-white">TOTAL CONEXIONES CON ERRORES</td><td><?=$contadorError?></td></tr>
    <tr><td class="font-weight-bold bg-info text-white">TOTAL CONEXIONES EXITOSAS</td><td><?=($contador-$contadorError)?></td></tr>
</table>
</div>
<br><br>
<p>Hora de fin de consulta:<?=date("d/m/Y H:i")?></p>
 </center>

</body>
</html>
