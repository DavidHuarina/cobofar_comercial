<meta charset="utf-8">
<?php

require("conexionmysqli.inc");
require("estilos.inc");
require("funcion_nombres.php");

$claveMarcado=$_POST["clave_marcado"];
$user=$_POST["rpt_personal"];
$fechaActual=date("Y-m-d H:i:s");

$sql="select codigo_funcionario from usuarios_sistema where contrasena= BINARY '$claveMarcado' and codigo_funcionario='$user' ";
$resp=mysqli_query($enlaceCon,$sql);
$numFilas=mysqli_num_rows($resp);

if($numFilas>0){
	while($dat=mysqli_fetch_array($resp)){
		$codUsuario=$dat[0];
		$nombreUsuario=nombreVisitador($codUsuario);
		$sqlInsert="insert into marcados_personal (cod_funcionario, fecha_marcado, estado) values 
		($codUsuario, '$fechaActual', 1)";
		$respInsert=mysqli_query($enlaceCon,$sqlInsert);
		
		echo "<script language='Javascript'>
		swal({
    title: 'Correcto!',
    text: 'Usuario: $nombreUsuario',
    type: 'success'
}).then(function() {
    window.location = 'registrar_marcado.php';
});
			</script>";
	}
}else{
	echo "<script language='Javascript'>
	swal({
    title: 'ERROR!!!!.',
    text: 'No se guardó el Marcado.',
    type: 'error'
}).then(function() {
    window.location = 'registrar_marcado.php';
});
			</script>";	
}
?>