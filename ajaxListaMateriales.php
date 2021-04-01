<html>
<body>
<table align='center' class="texto">
<tr>
<th>Producto</th><th>Linea</th><th>Ubicacion</th><th>Stock</th><th>Precio</th></tr>
<?php
require("conexionmysqli.inc");
require("funciones.php");

$codTipo=$_GET['codTipo'];
$codForma=$_GET['codForma'];
$codAccion=$_GET['codAccion'];
$codPrincipio=$_GET['codPrincipio'];

$nombreItem=$_GET['nombreItem'];
$globalAlmacen=$_COOKIE['global_almacen'];
$codCiudad=$_COOKIE['global_agencia'];
$itemsNoUtilizar=$_GET['arrayItemsUtilizados'];
$tipoSalida=$_GET['tipoSalida'];

$fechaActual=date("Y-m-d");

//SACAMOS LA CONFIGURACION PARA LA SALIDA POR VENCIMIENTO
$sqlConf="select valor_configuracion from configuraciones where id_configuracion=5";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$tipoSalidaVencimiento=mysqli_result($respConf,0,0);

	$sql="select m.codigo_material, m.descripcion_material,
	(select concat(p.nombre_proveedor,' ',pl.abreviatura_linea_proveedor)
	from proveedores p, proveedores_lineas pl where p.cod_proveedor=pl.cod_proveedor and pl.cod_linea_proveedor=m.cod_linea_proveedor),m.cantidad_presentacion,m.divi from material_apoyo m where estado=1 and m.codigo_material not in ($itemsNoUtilizar)";
	if($nombreItem!=""){
		$sql=$sql. " and descripcion_material like '%$nombreItem%'";
	}

    if((int)$codTipo>0){
        $sql=$sql." and m.cod_linea_proveedor=".$codTipo."";
    }

    if((int)$codForma>0){
        $sql=$sql." and m.cod_forma_far=".$codForma."";
    }

    if((int)$codAccion>0){
        $sql=$sql." and m.codigo_material in (SELECT codigo_material FROM material_accionterapeutica where cod_accionterapeutica=".$codAccion.")";
    }

    if((int)$codPrincipio>0){
        $sql=$sql." and m.codigo_material in (SELECT cod_material FROM principios_activosproductos where cod_principioactivo=".$codPrincipio.")";
    }


	if($tipoSalidaVencimiento==$tipoSalida){
		$sql=$sql. " and m.codigo_material in (select id.cod_material from ingreso_almacenes i, ingreso_detalle_almacenes id 
		where i.cod_ingreso_almacen=id.cod_ingreso_almacen and i.cod_almacen='$globalAlmacen' and i.ingreso_anulado=0 
		and id.fecha_vencimiento<'$fechaActual') ";
	}
	$sql=$sql." order by 2";
	
	//echo $sql;
	
	$resp=mysqli_query($enlaceCon,$sql);

	$numFilas=mysqli_num_rows($resp);
	if($numFilas>0){
		while($dat=mysqli_fetch_array($resp)){
			$codigo=$dat[0];
			$nombre=$dat[1];
			$linea=$dat[2];
			$cantidadPresentacion=$dat[3];
			$divi=$dat[4];
			$nombre=addslashes($nombre);
			
			if($tipoSalida==$tipoSalidaVencimiento){
				$stockProducto=stockProductoVencido($globalAlmacen, $codigo);
			}else{
				$stockProducto=stockProducto($globalAlmacen, $codigo);
			}
			
			$ubicacionProducto=ubicacionProducto($globalAlmacen, $codigo);
			
			$consulta="select p.`precio` from precios p where p.`codigo_material`='$codigo' and p.`cod_precio`='1' and cod_ciudad='$codCiudad'";
			$rs=mysqli_query($enlaceCon,$consulta);
			$registro=mysqli_fetch_array($rs);
			$precioProducto=$registro[0];
			if($precioProducto=="")
			{   $precioProducto=0;
			}
			$precioProducto=redondear2($precioProducto);
			
			echo "<tr><td><div class='textograndenegro'><a href='javascript:setMateriales(form1, $codigo, \"$nombre\",\"$cantidadPresentacion\",\"$divi\")'>$nombre</a></div></td>
			<td>$linea</td>
			<td>$ubicacionProducto</td>
			<td>$stockProducto</td>
			<td>$precioProducto</td>
			</tr>";
		}
	}else{
		echo "<tr><td colspan='5'>Sin Resultados en la busqueda.</td></tr>";
	}
	
?>
</table>

</body>
</html>