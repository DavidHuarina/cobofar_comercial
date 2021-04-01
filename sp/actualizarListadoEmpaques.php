<?php
set_time_limit(0);
require_once '../conexionmysqli.inc';
require_once '../function_web.php';
$listPer=obtenerListadoEnvases();//web service
$contador=0;
echo "<br><br>Iniciando....<br><br><br><br>";
foreach ($listPer->lista as $per) {
	$codigo=$per->idenvase;
	$descripcion=$per->des;
	if($contador==0){
		$sql="DELETE FROM empaques";
		$sqlDelete=mysqli_query($enlaceCon,$sql);
	}

	$sql="INSERT INTO empaques (cod_empaque,nombre_empaque,estado) VALUES ('$codigo','$descripcion','1')";
    $sqlinserta=mysqli_query($enlaceCon,$sql);

   $contador++;
}
echo "Realizado!";

