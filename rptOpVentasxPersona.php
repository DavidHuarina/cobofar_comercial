<script language='JavaScript'>
function envia_formulario(f)
{	var rpt_territorio,fecha_ini, fecha_fin, rpt_ver;
	rpt_territorio=f.rpt_territorio.value;
	fecha_ini=f.exafinicial.value;
	fecha_fin=f.exaffinal.value;
	var codPersonal=new Array();
	var j=0;
	for(var i=0;i<=f.rpt_personal.options.length-1;i++)
	{	if(f.rpt_personal.options[i].selected)
		{	codPersonal[j]=f.rpt_personal.options[i].value;
			j++;
		}
	}
	window.open('rptVentasxVendedor.php?rpt_territorio='+rpt_territorio+'&fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin+'&codPersonal='+codPersonal+'','','scrollbars=yes,status=no,toolbar=no,directories=no,menubar=no,resizable=yes,width=1000,height=800');			
	return(true);
}
</script>
<?php

require("conexionmysqli.inc");
require("estilos_almacenes.inc");
$globalFuncionario=$_COOKIE["global_usuario"];
$fecha_rptdefault=date("Y-m-d");
if($_COOKIE["admin_central"]==1){
	$global_tipoalmacen=1;
}

$globalCiudad=$_COOKIE["global_agencia"];
if(isset($_POST["rpt_territorio"])){
	$rpt_territorio=$_POST["rpt_territorio"];
}else{
	$rpt_territorio=$_COOKIE["global_agencia"];
}
echo "<table align='center' class='textotit'><tr><th>Reporte Ventas x Vendedor</th></tr></table><br>";
echo"<form method='post' action=''>";

	echo"\n<table class='texto' align='center' cellSpacing='0' width='50%'>\n";
	echo "<tr><th align='left'>Sucursal</th><td><select name='rpt_territorio' class='selectpicker' data-live-search='true' data-size='6'>";
	if($global_tipoalmacen==1)
	{	$sql="select cod_ciudad, descripcion from ciudades order by descripcion";
	}
	else
	{	$sql="select cod_ciudad, descripcion from ciudades where cod_ciudad='$global_agencia' order by descripcion";
	}
	$resp=mysqli_query($enlaceCon,$sql);
	echo "<option value=''></option>";
	while($dat=mysqli_fetch_array($resp))
	{	$codigo_ciudad=$dat[0];
		$nombre_ciudad=$dat[1];
		if($globalCiudad==$codigo_ciudad){
		   echo "<option value='$codigo_ciudad' selected>$nombre_ciudad</option>";	
		}else{
		   //if(isset($_GET["admin"])){
			  echo "<option value='$codigo_ciudad'>$nombre_ciudad</option>";	
		   //}			
		}
	}
	echo "</select></td></tr>";
	echo "<tr><th align='left'>Personal</th><td><select name='rpt_personal' multiple class='selectpicker' data-live-search='true' data-size='6' data-actions-box='true' data-style='btn btn-info'>";

	if($global_tipoalmacen==1)
	{	$sql="SELECT codigo_funcionario,CONCAT(paterno,' ',materno,' ',nombres)personal FROM funcionarios order by paterno,materno,nombres";
	}
	else
	{	$sql="SELECT codigo_funcionario,CONCAT(paterno,' ',materno,' ',nombres)personal FROM funcionarios WHERE cod_ciudad='$globalCiudad' order by paterno,materno,nombres";
	}

	
	$resp=mysqli_query($enlaceCon,$sql);
	echo "<option value=''></option>";
	while($dat=mysqli_fetch_array($resp))
	{	$codigo_funcionario=$dat[0];
		$nombre_funcionario=$dat[1];
		if($globalFuncionario==$codigo_funcionario){
		   echo "<option value='$codigo_funcionario' selected>$nombre_funcionario</option>";	
		}else{
		  echo "<option value='$codigo_funcionario'>$nombre_funcionario</option>";				
		}
	}
	echo "</select></td></tr>";
	echo "<tr><th align='left'>Fecha inicio:</th>";
			echo" <TD bgcolor='#ffffff'><INPUT  type='date' class='texto' value='$fecha_rptdefault' id='exafinicial' size='10' name='exafinicial'>";
    		echo"  </TD>";
	echo "</tr>";
	echo "<tr><th align='left'>Fecha final:</th>";
			echo" <TD bgcolor='#ffffff'><INPUT  type='date' class='texto' value='$fecha_rptdefault' id='exaffinal' size='10' name='exaffinal'>";
    		echo"  </TD>";
	echo "</tr>";
	
	echo"\n </table><br>";
	require('home_almacen.php');
	echo "<center><input type='button' name='reporte' value='Ver Reporte' onClick='envia_formulario(this.form)' class='boton'>
	</center><br>";
	echo"</form>";
	echo "</div>";
	echo"<script type='text/javascript' language='javascript'  src='dlcalendar.js'></script>";

?>