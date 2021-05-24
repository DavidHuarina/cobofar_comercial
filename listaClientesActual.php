<?php
//$estilosVenta=1;
require("conexionmysqli2.inc");
$cliente=$_GET["cliente"];
$sql2="select c.`cod_cliente`, c.nombre_cliente,c.paterno from clientes c order by 2";
$resp2=mysqli_query($enlaceCon,$sql2);
?><option value=''>----</option><?php
while($dat2=mysqli_fetch_array($resp2)){
   $codCliente=$dat2[0];
	$nombreCliente=$dat2[1]." ".$dat2[2];
	if($codCliente==$cliente){
      ?><option value='<?php echo $codCliente?>' selected><?php echo $nombreCliente?></option><?php			
	}else{
		?><option value='<?php echo $codCliente?>'><?php echo $nombreCliente?></option><?php			
	}
}
