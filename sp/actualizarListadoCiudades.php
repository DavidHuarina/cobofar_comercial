<?php
require '../conexionmysqli.inc';
require_once '../function_web.php';
?>
<!DOCTYPE html>
<html>

<head>
	<title></title>
	<meta charset="utf-8">
</head>
<body>


<?php
$listAlma=obtenerListadoAlmacenes();//web service
echo "<br><br>Iniciando....<br><br><br><br>";
$contador=0;
foreach ($listAlma->lista as $alma) {

	$age1=$alma->age1;
	//echo $age1."<br>";
	$nombre=$alma->des;
	$direccion=$alma->direc;
	$age=$alma->age;
	$tipo=1;// TIPO DE CIUDAD
    $estado=1;
    $codAlma=$alma->codalma;
    if($alma->tipo=="E"){
    	$estado=2;
    }
    
    $cod_existe=verificarAlmacenCiudadExistente($age1);
    $age1=str_replace("\\", "\\\\", $age1); //CODIGO PARA QUE INSERTE CARACTER DE \ BACKSLASH
	if($cod_existe>0){
		$contador++;
		//update
		$sql="UPDATE ciudades SET descripcion='$nombre',tipo='$tipo',direccion='$direccion',codigo_anterior='$age1',cod_estadoreferencial=$estado,codalma='$codAlma' where cod_ciudad='$cod_existe'";
        $sqlinserta=mysqli_query($enlaceCon,$sql);
        //echo $age1."  ".$cod_existe."<br>";
	}else{		
        //insert
		$sql="INSERT INTO ciudades (descripcion,tipo,direccion,codigo_anterior,cod_estadoreferencial,codalma)
        VALUES ('$nombre','$tipo','$direccion','$age1','$estado','$codalma')";
        $sqlinserta=mysqli_query($enlaceCon,$sql);
	}

}
echo "Realizado!";
/*
INSERTAR ALMACENES 
$sql="INSERT INTO almacenes (cod_ciudad,nombre_almacen,responsable_almacen)
SELECT cod_ciudad,descripcion,0 FROM ciudades where cod_ciudad not in (SELECT c.cod_ciudad FROM ciudades c WHERE c.cod_ciudad in (SELECT cod_ciudad FROM almacenes where cod_ciudad=c.cod_ciudad));";
        $sqlinserta=mysqli_query($enlaceCon,$sql);
*/
?></body>
</html>
