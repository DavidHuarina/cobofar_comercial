<?php
require("conexionmysqli.inc");
require("estilos_almacenes.inc");

$fecha_rptdefault=date("Y-m-d");
echo "<h1>Reporte de Marcados de Asistencia</h1>";
echo"<form method='post' action='rptMarcados.php'>";

	echo"\n<table class='table table-bordered' align='center' cellSpacing='0' width='50%'>\n";
    echo "<tr><th align='left' class='bg-principal'>Sucursal</th><td><select name='rpt_territorio' data-live-search='true'  id='rpt_territorio' data-size='10' class='selectpicker form-control' required>";
$globalAgencia=$_COOKIE["global_agencia"];
	if($_COOKIE["admin_central"]==1){
       $sql="select cod_ciudad, descripcion from ciudades where cod_ciudad>0 order by descripcion";    
	}else{
	   
       $sql="select cod_ciudad, descripcion from ciudades where cod_ciudad>0 and cod_ciudad='$globalAgencia' order by descripcion";
	}
	
	$resp=mysqli_query($enlaceCon,$sql);
	while($dat=mysqli_fetch_array($resp))
	{	$codigo_ciudad=$dat[0];
		$nombre_ciudad=$dat[1];
		if($codigo_ciudad==$globalAgencia){
           echo "<option value='$codigo_ciudad' selected>$nombre_ciudad</option>";
		}else{
		   echo "<option value='$codigo_ciudad'>$nombre_ciudad</option>";	
		}		
	}
	echo "</select></td></tr>";
	echo "<tr><th align='left' class='bg-principal'>Fecha inicio:</th>";
			echo" <TD><INPUT  type='date' class='texto' value='$fecha_rptdefault' id='exafinicial' name='exafinicial' required>";
    		echo"  </TD>";
	echo "</tr>";
	echo "<tr><th align='left' class='bg-principal'>Fecha final:</th>";
			echo" <TD><INPUT  type='date' class='texto' value='$fecha_rptdefault' id='exaffinal' name='exaffinal' required>";
    		echo"  </TD>";
	echo "</tr>";
	
	echo"\n </table><br>";

	echo "<center><input type='submit' name='reporte' value='Ver Reporte' class='btn btn-warning'>
	</center><br>";
	echo"</form>";
	echo "</div>";
	
?>