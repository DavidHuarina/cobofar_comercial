<?php
	require("../conexionmysqli.inc");
	require("../estilos2.inc");
	require("configModule.php");

	$vector=explode(",",$datos);
	$n=sizeof($vector);
	for($i=0;$i<$n;$i++)
	{
		$codEliminar=$vector[$i];
		$sql="update $table set estado=2 where codigo=$codEliminar";

		$resp=mysqlI_query($enlaceCon,$sql);
	}
	echo "<script language='Javascript'>
			alert('Los datos fueron eliminados.');
			location.href='$urlList2';
			</script>";

?>