<?php

ini_set('register_globals', 'On');
require("../conexionmysqli.inc");
//$usuario=$_POST['usuario'];
//$contrasena=$_POST['contrasena'];
$sql = "select * from usuarios_sistema where codigo_funcionario='$usuario' and contrasena='$contrasena'";
$resp = mysqli_query($enlaceCon,$sql);
$num_filas = mysqli_num_rows($resp);
if ($num_filas != 0) {
    header("location:index_administracion.html");
} else {
    echo "Usuario no registrado";
}

?>