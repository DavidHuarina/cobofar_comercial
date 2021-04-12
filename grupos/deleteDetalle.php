<?php
	require("../conexionmysqli.inc");
	require("../estilos2.inc");
	require("configModule.php");
    $codMaestro=$_GET['cod_maestro'];
	$vector=explode(",",$datos);
	$n=sizeof($vector);
	for($i=0;$i<$n;$i++)
	{
		$codEliminar=$vector[$i];
		$sql="update $tableDetalle set estado=2 where codigo=$codEliminar";

		$resp=mysqlI_query($enlaceCon,$sql);
	}
	echo "<script language='Javascript'>
			alert('Los datos fueron eliminados.');
			location.href='$urlListDetalle2?codigo=$codMaestro';
			</script>";

?>