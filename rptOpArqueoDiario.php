<script language='JavaScript'>
function envia_formulario(f, variableAdmin)
{	var fecha_ini;
	var fecha_fin;
	var hora_ini;
	var hora_fin;
	var rpt_territorio;
	rpt_territorio=f.rpt_territorio.value;
	var rpt_funcionario=$("#rpt_funcionario").val();
	//rpt_funcionario=f.rpt_funcionario.value;

	fecha_ini=f.exafinicial.value;
	fecha_fin=f.exaffinal.value;
	hora_ini=f.exahorainicial.value;
	hora_fin=f.exahorafinal.value;
	window.open('rptArqueoDiarioPDF.php?rpt_territorio='+rpt_territorio+'&fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin+'&hora_ini='+hora_ini+'&hora_fin='+hora_fin+'&variableAdmin='+variableAdmin+'&rpt_funcionario='+rpt_funcionario,'','scrollbars=yes,status=no,toolbar=no,directories=no,menubar=no,resizable=yes,width=1000,height=800');			
	return(true);
}

function envia_formulario2(f, variableAdmin)
{	var fecha_ini;
	var fecha_fin;
	var hora_ini;
	var hora_fin;
	var rpt_territorio;
	rpt_territorio=f.rpt_territorio.value;
	var rpt_funcionario;
	rpt_funcionario=f.rpt_funcionario.value;

	fecha_ini=f.exafinicial.value;
	fecha_fin=f.exaffinal.value;
	hora_ini=f.exahorainicial.value;
	hora_fin=f.exahorafinal.value;
	window.open('rptArqueoDiarioPDFSm.php?rpt_territorio='+rpt_territorio+'&fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin+'&hora_ini='+hora_ini+'&hora_fin='+hora_fin+'&variableAdmin='+variableAdmin+'&rpt_funcionario='+rpt_funcionario,'','scrollbars=yes,status=no,toolbar=no,directories=no,menubar=no,resizable=yes,width=1000,height=800');			
	return(true);
}
</script>
<?php

require("conexionmysqli.inc");
require("estilos_almacenes.inc");

$variableAdmin=$_GET["variableAdmin"];
if($variableAdmin!=1){
	$variableAdmin=0;
}

$fecha_rptinidefault=date("Y")."-".date("m")."-01";
//$hora_rptinidefault=date("H:i");
$hora_rptinidefault="06:00";
$hora_rptfindefault="23:00";
$fecha_rptdefault=date("Y-m-d");
$globalCiudad=$_COOKIE['global_agencia'];
$globalUser=$_COOKIE['global_usuario'];

echo "<h1>Reporte Arqueo Diario de Caja</h1><br>";
echo"<form method='post' action='rptArqueoDiarioPDF.php'>";

	echo"\n<table class='texto' align='center' cellSpacing='0' width='50%'>\n";
	
	echo "<tr><th align='left'>Territorio</th><td><select name='rpt_territorio' class='selectpicker form-control'>";
	
	if(isset($_GET['sw'])){
		$sql_ciudades="select cod_ciudad, descripcion from ciudades  order by descripcion";
		$sql_personal="SELECT codigo_funcionario,CONCAT(paterno,' ',materno,' ',nombres)personal FROM funcionarios  order by paterno,materno,nombres"; 
	}else{
		$sql_ciudades="select cod_ciudad, descripcion from ciudades where cod_ciudad='$globalCiudad' order by descripcion";	
		$sql_personal="SELECT codigo_funcionario,CONCAT(paterno,' ',materno,' ',nombres)personal FROM funcionarios WHERE cod_ciudad='$globalCiudad' order by paterno,materno,nombres"; 
	}
	$resp=mysqli_query($enlaceCon,$sql_ciudades);
	while($dat=mysqli_fetch_array($resp))
	{	$codigo_ciudad=$dat[0];
		$nombre_ciudad=$dat[1];
		if($codigo_ciudad==$globalCiudad){
			echo "<option value='$codigo_ciudad' selected>$nombre_ciudad</option>";			
		}else{
			echo "<option value='$codigo_ciudad'>$nombre_ciudad</option>";
		}
	}
	echo "</select></td></tr>";
	echo "<tr><th align='left'>Personal</th><td><select name='rpt_funcionario' id='rpt_funcionario' class='selectpicker form-control' data-live-search='true' data-size='6'>";
	
	$resp=mysqli_query($enlaceCon,$sql_personal);
	while($dat=mysqli_fetch_array($resp))
	{	$cod_funcionario=$dat[0];
		$nombre_fun=$dat[1];
		if($cod_funcionario==$globalUser){
			echo "<option value='$cod_funcionario' selected>$nombre_fun</option>";			
		}else{
			echo "<option value='$cod_funcionario'>$nombre_fun</option>";
		}
	}
	echo "</select></td></tr>";
	echo "<tr><th align='left'>Fecha Inicio:</th>";
			echo" <TD bgcolor='#ffffff'>
				<INPUT  type='date' class='texto' value='$fecha_rptdefault' id='exafinicial' size='10' name='exafinicial'><INPUT  type='time' class='texto' value='$hora_rptinidefault' id='exahorainicial' size='10' name='exahorainicial'>";
    		echo"  </TD>";
	echo "</tr>";
	echo "<tr><th align='left'>Fecha Fin:</th>";
			echo" <TD bgcolor='#ffffff'>
				<INPUT  type='date' class='texto' value='$fecha_rptdefault' id='exaffinal' size='10' name='exaffinal'><INPUT  type='time' class='texto' value='$hora_rptfindefault' id='exahorafinal' size='10' name='exahorafinal'>";
    		echo"  </TD>";
	echo "</tr>";
	
	echo"\n </table><br>";
	echo "<center><input type='button' name='reporte' value='Ver Reporte' onClick='envia_formulario(this.form,$variableAdmin)' class='btn btn-info'><input type='button' name='reporte2' value='Imprimir' onClick='envia_formulario2(this.form,$variableAdmin)' class='btn btn-default'>
	</center><br>";
	echo"</form>";
	echo "</div>";
	echo"<script type='text/javascript' language='javascript'  src='dlcalendar.js'></script>";

?>