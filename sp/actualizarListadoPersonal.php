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
    $ci=$per->ci;
    $ciudad=verificarAlmacenCiudadExistente($age1);
	$estado=1;
    $codigo_cargo=1016;
    $cod_existe=verificarPersonalUsuario($codigo);
	if($cod_existe>0){
        $sql="UPDATE funcionarios SET direccion='$dir',ci='$ci' where codigo_funcionario='$codigo'";
        $sqlinserta=mysqli_query($enlaceCon,$sql);
     }else{      
         $sql="INSERT INTO funcionarios (codigo_funcionario,cod_cargo,paterno,materno,nombres,fecha_nac,direccion,telefono,email,cod_ciudad,estado,ci)
        VALUES ('$codigo','$codigo_cargo','$paterno','$materno','$nombre','$fechnac','$dir','$tel','$email','$ciudad','$estado','$ci')";
         $sqlinserta=mysqli_query($enlaceCon,$sql);
      }
   $contador++;
}
echo "Realizado!";

