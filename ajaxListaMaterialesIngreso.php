<html>
<body>
<table align='center' class="texto">
<tr>
<th>Linea</th><th>Producto</th><th>Stock</th></tr>
<?php
require("conexionmysqli.inc");
require("funciones.php");
$codTipo=$_GET['codTipo'];
$nombreItem=$_GET['nombreItem'];
if(isset($_COOKIE['global_almacen'])){
	$globalAlmacen=$_COOKIE['global_almacen'];
}else{
	$globalAlmacen=1;
}

//$itemsNoUtilizar=$_GET['arrayItemsUtilizados'];
$itemsNoUtilizar="0";

	$sql="select m.codigo_material, m.descripcion_material, m.cantidad_presentacion, 
	(select concat(p.nombre_proveedor)
	from proveedores p, proveedores_lineas pl where p.cod_proveedor=pl.cod_proveedor and pl.cod_linea_proveedor=m.cod_linea_proveedor)	
	from material_apoyo m where estado=1 
		and m.codigo_material not in ($itemsNoUtilizar)";
	if($nombreItem!=""){
		$sql=$sql. " and descripcion_material like '%$nombreItem%'";
	}
	if($codTipo!=0){
		$sql=$sql. " and cod_linea_proveedor = '$codTipo' ";
	}
	$sql=$sql." order by 2";
	$resp=mysqli_query($enlaceCon,$sql);

	$numFilas=mysqli_num_rows($resp);
	if($numFilas>0){
		while($dat=mysqli_fetch_array($resp)){
			$codigo=$dat[0];
			$nombre=$dat[1];
			$nombre=addslashes($nombre);
			$cantidadPresentacion=$dat[2];
			$linea=$dat[3];
			
			$stockProducto=stockProducto($globalAlmacen, $codigo);

			$precioProducto=precioProducto($codigo);
			$margenLinea=margenLinea($codigo);
			if($precioProducto==""){
				$precioProducto=0;
			}
			if($margenLinea==""){
				$margenLinea=0;
			}
			
			echo "<tr><td>$linea</td><td><div class='textograndenegro'><a href='javascript:setMateriales(form1, $codigo, \"$nombre\", $cantidadPresentacion, $precioProducto, $margenLinea)'>$nombre</a></div></td><td><div class='textograndenegro'>$stockProducto</div></td></tr>";
		}
	}else{
		echo "<tr><td colspan='3'>Sin Resultados en la busqueda.</td></tr>";
	}

?>
</table>

</body>
</html>