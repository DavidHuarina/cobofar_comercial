<?php
set_time_limit(0);
require_once '../conexionmysqli.inc';
require_once '../function_web.php';
$listPer=obtenerListadoPersonal("A");//web service
$contador=0;
echo "<br><br>Iniciando....<br><br><br><br>";
foreach ($listPer->lista as $per) {
	$codigo=$per->idper;
	$paterno=$per->paterno;
	$materno=$per->materno;
	$nombre=$per->nombre;
	$fechnac=$per->fechnac;
	$dir=$per->dir;
	$tel=$per->tel;
	$email=$per->email;
    $age1=$per->age1;
    $ciudad=verificarAlmacenCiudadExistente($age1);
	$estado=1;
    $codigo_cargo=1016;
	if($contador==0){
		$sql="DELETE FROM funcionarios";
		$sqlDelete=mysqli_query($enlaceCon,$sql);
	}

	$sql="INSERT INTO funcionarios (codigo_funcionario,cod_cargo,paterno,materno,nombres,fecha_nac,direccion,telefono,email,cod_ciudad,estado)
        VALUES ('$codigo','$codigo_cargo','$paterno','$materno','$nombre','$fechnac','$dir','$tel','$email','$ciudad','$estado')";
    $sqlinserta=mysqli_query($enlaceCon,$sql);

   $contador++;
}
echo "Realizado!";

