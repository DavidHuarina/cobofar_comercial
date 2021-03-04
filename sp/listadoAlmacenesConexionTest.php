<?php
require_once __DIR__.'/../conexion_externa_farma.php';
require '../conexionmysqli.inc';
require_once '../function_web.php';
?>
<!DOCTYPE html>
<html>

<head>
	<title></title>
	<meta charset="utf-8">
</head>
<body>


<?php
$listAlma=obtenerListadoAlmacenes();//web service
echo "<br><br>Iniciando....<br><br><br><br>";
$contador=0;
foreach ($listAlma->lista as $alma) {

	$age1=$alma->age1;
	//echo $age1."<br>";
	$nombre=$alma->des;
	$direccion=$alma->direc;
	$age=$alma->age;
	$ip=$alma->ip;
	$tipo=1;// TIPO DE CIUDAD
    $estado=1;
    if($alma->tipo=="E"){
    	$estado=2;
    }
    echo $nombre.": ".$ip."  ";
    $dbh = new ConexionFarma();
    $dbh->setHost($ip);
    $verificarCon=$dbh->start();
    if($verificarCon==true){
    	echo "SUCCESS<br>";
    }else{
    	echo "ERROR<br>";
    }
    $contador++;

}
echo "Realizado! Total Almacenes".$contador;


?></body>
</html>
