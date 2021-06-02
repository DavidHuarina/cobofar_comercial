<?php
$estilosVenta=0; //para no ejecutar las librerias js css
require("conexionmysqli.inc");
$usuario_adm = $_POST["usuario"];
$contrasena = $_POST["contrasena"];
$contrasena = str_replace("'", "''", $contrasena);

$sql = "
    SELECT f.cod_cargo, f.cod_ciudad,u.codigo_funcionario
    FROM funcionarios f, usuarios_sistema u
    WHERE u.codigo_funcionario=f.codigo_funcionario AND u.usuario='$usuario_adm' AND u.contrasena='$contrasena' ";
$resp = mysqli_query($enlaceCon,$sql);
$num_filas = mysqli_num_rows($resp);
if ($num_filas != 0) {
    $dat = mysqli_fetch_array($resp);
    $cod_cargo = $dat[0];
    $cod_ciudad = $dat[1];
    $usuario = $dat[2];

    setcookie("global_usuario", $usuario,time()+3600*24*30, '/');
    setcookie("global_agencia", $cod_ciudad,time()+3600*24*30, '/');
    setcookie("global_tipo_almacen", 1,time()+3600*24*30, '/');
	
	//sacamos la gestion activa
	$sqlGestion="select cod_gestion, nombre_gestion from gestiones where estado=1";
	$respGestion=mysqli_query($enlaceCon,$sqlGestion);
	$globalGestion=mysqli_result($respGestion,0,0);
	$nombreG=mysqli_result($respGestion, 0, 1);
	
	//almacen
	$sql_almacen="select cod_almacen, nombre_almacen from almacenes where cod_ciudad='$cod_ciudad' and cod_tipoalmacen=1"; //ALMACEN MEDICAMENTOS
	//echo $sql_almacen;
	$resp_almacen=mysqli_query($enlaceCon,$sql_almacen);
	$dat_almacen=mysqli_fetch_array($resp_almacen);
	$global_almacen=$dat_almacen[0];

	setcookie("global_almacen",$global_almacen,time()+3600*24*30, '/');
	setcookie("globalGestion", $nombreG,time()+3600*24*30, '/');
	
    if($usuario==414243){
    	header("location:indexAuxi.php");
    }else{
    	if($cod_cargo==1000||$cod_cargo==1001 || $cod_cargo==1017 || $cod_cargo==1018){
		     header("location:indexGerencia.php");
	    }
	    if($cod_cargo==1002){
		     header("location:indexAlmacenReg.php");
	    }
	    if($cod_cargo==29||$cod_cargo==30||$cod_cargo==31||$cod_cargo==32||$cod_cargo==33||$cod_cargo==34){
		     header("location:indexVentas.php");
	    }    
    } 
} else {
     echo "<link href='stilos.css' rel='stylesheet' type='text/css'>
        <form action='problemas_ingreso.php' method='post' name='formulario'>
        <h1>Sus datos de acceso no son correctos.</h1>
        <a href='index.html' class='boton'>Volver</a>
        </form>";
}
?>
