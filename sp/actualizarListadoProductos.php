<?php
require_once '../conexionmysqli.inc';
require_once '../function_web.php';
$listProd=obtenerListadoProductosWeb("A");//web service
$contador=0;
echo "<br><br>Iniciando....<br><br><br><br>";
foreach ($listProd->lista as $prod) {
	//echo $prod->idproveedor."<br>";
	$codigo=$prod->cprod;
	$nombre=$prod->des;
	$estado=1;
	$cod_linea=$prod->idslinea;
	$cod_forma_far=1;
	$cod_empaque=1;
	$cantidad_presentacion=1;
	$principio_activo=1;
	$cod_tipoventa=1; //RECETA MEDICA
	$codigo_barras=$prod->cod_bar;

	if($contador==0){
		$sql="DELETE FROM material_apoyo";
		$sqlDelete=mysqli_query($enlaceCon,$sql);
	}


	$sql="INSERT INTO material_apoyo (codigo_material,descripcion_material,estado,cod_linea_proveedor,cod_forma_far,cod_empaque,cantidad_presentacion,principio_activo,cod_tipoventa,codigo_barras)
        VALUES ('$codigo','$nombre','$estado','$cod_linea','$cod_forma_far','$cod_empaque','$cantidad_presentacion','$principio_activo','$cod_tipoventa','$codigo_barras')";
    $sqlinserta=mysqli_query($enlaceCon,$sql);

   $contador++;
}
echo "Realizado!";

