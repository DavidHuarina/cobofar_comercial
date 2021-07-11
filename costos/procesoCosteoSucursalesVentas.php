<?php

require('../estilos_reportes_almacencentral.php');
require('../conexionmysqli.inc');
require('../funcionRecalculoCostosCobofar.php');

$sqlAlmacenes="select cod_almacen, cod_ciudad, nombre_almacen from almacenes a where a.cod_tipoalmacen=1 and a.cod_ciudad>0;";
$respAlmacenes=mysqli_query($enlaceCon, $sqlAlmacenes);
while($datAlmacenes=mysqli_feth_array($respAlmacenes)){
	$codAlmacen=$datAlmacenes[0];
	$nombreAlmacen=$datAlmacenes[1];
	echo $codAlmacen." ".$nombreAlmacen."********<br>"; 
}

//recalculaCostos(50023,1056,$enlaceCon);

echo "fin por fin;";
?>
