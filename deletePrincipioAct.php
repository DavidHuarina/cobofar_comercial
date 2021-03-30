<?php
	require("conexionmysqli.inc");
	require("estilos.inc");
	
	$datos=$_GET["datos"];
	
	$vector=explode(",",$datos);
	$n=sizeof($vector);
	for($i=0;$i<$n;$i++)
	{
		$sql="UPDATE principios_activos set estado=0 where codigo=$vector[$i]";
		$resp=mysqli_query($enlaceCon,$sql);
	}
	echo "<script language='Javascript'>
			alert('Los datos se procesaron correctamente.');
			location.href='navegador_principiosact.php';
			</script>";


?>