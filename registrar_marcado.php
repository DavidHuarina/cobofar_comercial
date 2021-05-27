<script>
function cargaInicio(f){
	f.clave_marcado.focus();
}
</script>
<body onload="cargaInicio(form1);">
<?php
require("conexionmysqli.inc");
require("estilos.inc");
?>
<div class="container">
<?php
echo "<form name='form1' action='guarda_marcado.php' method='post'>";
echo "<h1>Registrar Marcado de Personal</h1>";

echo "<center><table class='table' width='50%'>";
echo "<tr class='bg-primary text-white'><th>Introducir la clave del sistema para realizar el marcado</th></tr>";
echo "<tr><td align='center'><input type='password' value='' name='clave_marcado' id='clave_marcado' size='50' required class='form-control col-sm-4' autocomplete='off' style='border:1px solid #505050;background:#DFDBDB;text-align:center;'></td>";
echo "</table></center>";

echo "<div class='float-right'><input type='submit' class='btn btn-warning' value='Guardar Marcado' onClick='validar(this.form)'>
</div><br><br>";

$globalCiudad=$_COOKIE["global_agencia"];
/*$sql="select m.fecha_marcado, 
(select concat(f.paterno,' ', f.nombres) from funcionarios f where f.codigo_funcionario=m.cod_funcionario) 
from marcados_personal m order by m.fecha_marcado desc limit 0,10";*/

$sql="select m.fecha_marcado,concat(f.paterno,' ', f.nombres) 
from marcados_personal m JOIN funcionarios f on f.codigo_funcionario=m.cod_funcionario
where f.cod_ciudad='$globalCiudad'
order by m.fecha_marcado desc limit 0,10";
//echo $sql;
$resp=mysqli_query($enlaceCon,$sql);
echo "<center><table class='table table-bordered'>";
echo "<tr class='bg-principal'><th colspan='2'>Ultimos Marcados del personal</th></tr>";
echo "<tr class='bg-principal'><th>Fecha/Hora Marcado</th><th>Personal</th></tr>";
while($dat=mysqli_fetch_array($resp)){
	$fechaHora=$dat[0];
	$nombresPersonal=$dat[1];
	
	echo "<tr><td>$fechaHora</td><td>$nombresPersonal</td></tr>";
}
echo "</table></center>";

echo "</form>";
?>

</div>

</body>