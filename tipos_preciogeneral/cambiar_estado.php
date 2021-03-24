<?php
require("../conexionmysqli.inc");
require("../estilos2.inc");
require("configModule.php");

$codigo=$_GET['codigo_registro'];
$estado=$_GET['estado'];
$obs=$_GET['obs'];
$sql_upd=mysqli_query($enlaceCon,"UPDATE tipos_preciogeneral SET cod_estadodescuento=$estado,observacion_descuento='$obs' where codigo=$codigo");
if($sql_upd==1){
	echo "<script language='Javascript'>
			alert('Los datos fueron modificados correctamente.');
			location.href='$urlList3';
			</script>";
}else{
    echo "<script language='Javascript'>
			alert('Ocurrio un error al procesar los datos.');
			location.href='$urlList3';
			</script>";
}

?>