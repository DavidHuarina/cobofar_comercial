<?php
require_once '../conexionmysqli.inc';
require_once '../function_web.php';
$user=1017;//14238 //7073
$sqlProd="SELECT codigo_material FROM material_apoyo WHERE codigo_material<7073 ORDER BY 1 LIMIT 5000;";           
$respProd=mysqli_query($enlaceCon,$sqlProd);
echo "Inicio!";
while($detProd=mysqli_fetch_array($respProd)){ 
   $codigo = $detProd[0];
   $precioInsertar=obtenerPrecioVentaMaxProcesoAnteriorSistema($codigo);
   $sqlIns="INSERT INTO precios(codigo_material,cod_precio,precio,cod_ciudad,cod_funcionario) SELECT '$codigo' as codigo_material,1 as cod_precio,'$precioInsertar' as precio,cod_ciudad,'$user'as cod_funcionario FROM ciudades;";
   $insert=mysqli_query($enlaceCon,$sqlIns);
}
echo "Realizado!";

