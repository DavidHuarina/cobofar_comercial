<body>

<?php
require("conexionmysqli.inc");
require("estilos.inc");
?>

<script type="text/javascript">
function cargarAsignaciones(){
	var personal=$("#rpt_personal").val();
	var parametros={"personal":personal};
	$.ajax({
        type: "GET",
        dataType: 'html',
        url: "ajaxMostrarTablaAsignaciones.php",
        data: parametros,
        success:  function (resp) { 
           $("#data_sucursal").html(resp);      	   
        }
    });	
}

</script>
<div class="container">
<?php
echo "<form name='form1' action='guarda_asignar_stock.php' method='post'>";
echo "<h1>Asignar Sucursal Personal</h1>";

echo "<center><table class='table' width='50%'>";
echo "<tr><td width='40%'><select name='rpt_personal' id='rpt_personal' class='selectpicker' data-live-search='true' data-size='6' data-style='btn btn-rose' onchange='cargarAsignaciones()'>";
$globalAgencia=$_COOKIE["global_agencia"];
$globalFuncionario=$_COOKIE["global_usuario"];

if(isset($_GET["p"])){
	$globalFuncionario=$_GET["p"];
}
if(isset($_GET["c"])){
	$globalAgencia=$_GET["c"];
}
$sql="SELECT f.codigo_funcionario,CONCAT(f.nombres,' ',f.paterno,' ',f.materno)personal,f.ci FROM funcionarios f WHERE f.cod_ciudad!=-1 order by nombres,paterno,materno";	
	$resp=mysqli_query($enlaceCon,$sql);
	echo "<option value='' selected>--SELECCIONE PERSONAL--</option>";
	while($dat=mysqli_fetch_array($resp))
	{	$codigo_funcionario=$dat[0];
		$nombre_funcionario=$dat[1];
		$ci=$dat[2];
		if($globalFuncionario==$codigo_funcionario){
		   echo "<option value='$codigo_funcionario' selected>$nombre_funcionario ($ci)</option>";	
		}else{
		  echo "<option value='$codigo_funcionario'>$nombre_funcionario ($ci)</option>";				
		}
	}
	echo "</select></td>
	<td>Asignar Sucursal -></td>
<td align='center'><select name='rpt_ciudad' id='rpt_ciudad' class='selectpicker' data-live-search='true' data-size='6' data-style='btn btn-warning'>";
$sql="SELECT cod_ciudad,descripcion FROM ciudades where cod_estadoreferencial=1";	
	$resp=mysqli_query($enlaceCon,$sql);
	echo "<option value='' selected>--SELECCIONE SUCURSAL--</option>";
	while($dat=mysqli_fetch_array($resp))
	{	$codigo_ciudad=$dat[0];
		$nombre_ciudad=$dat[1];
		if($globalAgencia==$codigo_ciudad){
		  echo "<option value='$codigo_ciudad' selected>$nombre_ciudad</option>";		
		}else{
		  echo "<option value='$codigo_ciudad'>$nombre_ciudad</option>";				
		}
		
	}
	echo "</select></td>";
echo "</table></center>";

echo "<div class='float-right'><input type='submit' class='btn btn-primary' value='Asignar Sucursal'>
</div><br><br><br><br>";


echo "<center><table class='table table-bordered table-sm' id='data_sucursal'>";
echo "</table></center>";

echo "</form>";
?>

</div>
<script type="text/javascript">
$( document ).ready(function() {
	cargarAsignaciones();
});
</script>
</body>