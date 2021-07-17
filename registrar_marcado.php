<body>

<?php
require("conexionmysqli.inc");
require("estilos.inc");
?>
<div class="container">
<?php
echo "<form name='form1' action='guarda_marcado.php' method='post'>";
echo "<h1>Registrar Marcado de Personal</h1>";

echo "<center><table class='table' width='50%'>";
echo "<tr class='bg-primary text-white'><th colspan='2'>Introducir la clave del sistema para realizar el marcado</th></tr>";
echo "<tr><td width='40%'><select name='rpt_personal' id='rpt_personal' class='selectpicker' data-live-search='true' data-size='6' data-style='btn btn-rose'>";
$globalAgencia=$_COOKIE["global_agencia"];
$globalFuncionario=$_COOKIE["global_usuario"];

$fecha_actual = date("d-m-Y");
$fechaMinimaVenta= date("Y-m-d",strtotime($fecha_actual."")); 
$sql="SELECT f.codigo_funcionario,CONCAT(f.paterno,' ',f.materno,' ',f.nombres)personal FROM funcionarios f WHERE f.codigo_funcionario in (select DISTINCT cod_chofer from salida_almacenes where cod_almacen in (SELECT cod_almacen from almacenes where cod_ciudad='$globalAgencia') and fecha>='$fechaMinimaVenta' and cod_chofer!=-1) order by paterno,materno,nombres";	
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
	echo "</select></td>
<td align='center'><input type='password' value='' name='clave_marcado' id='clave_marcado' size='50' required class='form-control col-sm-12' autocomplete='off' style='border:1px solid #505050;background:#DFDBDB;text-align:center;'></td>";
echo "</table></center>";

echo "<div class='float-right'><input type='submit' class='btn btn-warning' value='Guardar Marcado' onClick='validar(this.form)'>
</div><br><br>";
//echo $sql;
$globalCiudad=$_COOKIE["global_agencia"];
/*$sql="select m.fecha_marcado, 
(select concat(f.paterno,' ', f.nombres) from funcionarios f where f.codigo_funcionario=m.cod_funcionario) 
from marcados_personal m order by m.fecha_marcado desc limit 0,10";*/

$sql="select m.fecha_marcado,concat(f.paterno,' ', f.nombres) 
from marcados_personal m JOIN funcionarios f on f.codigo_funcionario=m.cod_funcionario
where f.cod_ciudad='$globalCiudad' or f.codigo_funcionario in (select DISTINCT cod_chofer from salida_almacenes where cod_almacen in (SELECT cod_almacen from almacenes where cod_ciudad='$globalAgencia') and fecha>='$fechaMinimaVenta' and cod_chofer!=-1) or f.codigo_funcionario in (SELECT codigo_funcionario from funcionarios_agencias where cod_ciudad='$globalAgencia')
order by m.fecha_marcado desc limit 0,10";
//echo $sql;
$resp=mysqli_query($enlaceCon,$sql);
echo "<center><table class='table table-bordered'>";
echo "<tr class='bg-principal'><th colspan='2'>Ultimos Marcados del personal</th></tr>";
echo "<tr class='bg-principal'><th>Fecha/Hora Marcado</th><th>Personal</th></tr>";
while($dat=mysqli_fetch_array($resp)){
	$fechaHora=$dat[0];
	$nombresPersonal=$dat[1];
	
	echo "<tr><td><b>$fechaHora</b></td><td>$nombresPersonal</td></tr>";
}
echo "</table></center>";

echo "</form>";
?>

</div>
<script type="text/javascript">
$( document ).ready(function() {
	document.getElementById("clave_marcado").focus();
});
</script>
</body>