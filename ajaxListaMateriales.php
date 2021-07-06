<br>
<table align='center' class="table table-bordered table-sm" id="listaMaterialesTabla">
<tr class='bg-primary text-white'>
<th>Producto</th><th>Linea</th><th>Principio Activo</th><th>Stock</th><th>Precio</th></tr>
<?php
$estilosVenta=1;
require("conexionmysqli2.inc");
require("funciones.php");

$codTipo=$_GET['codTipo'];
$codForma=$_GET['codForma'];
$codAccion=$_GET['codAccion'];
$codPrincipio=$_GET['codPrincipio'];

$nombreItem=$_GET['nombreItem'];
//echo $nombreItem."<br>";
$globalAlmacen=$_COOKIE['global_almacen'];
$codCiudad=$_COOKIE['global_agencia'];
$itemsNoUtilizar=$_GET['arrayItemsUtilizados'];
$tipoSalida=$_GET['tipoSalida'];
$codigoMat=$_GET['codigoMat'];
$fechaActual=date("Y-m-d");

//SACAMOS LA CONFIGURACION PARA LA SALIDA POR VENCIMIENTO
$sqlConf="select valor_configuracion from configuraciones where id_configuracion=5";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$tipoSalidaVencimiento=mysqli_result($respConf,0,0);

	$sql="select m.codigo_material, m.descripcion_material,
	(select concat(p.nombre_proveedor,' ',pl.abreviatura_linea_proveedor)	
	from proveedores p, proveedores_lineas pl where p.cod_proveedor=pl.cod_proveedor and pl.cod_linea_proveedor=m.cod_linea_proveedor),m.cantidad_presentacion,m.divi,(SELECT GROUP_CONCAT(p.nombre) from principios_activos p where p.codigo in (SELECT cod_principioactivo from principios_activosproductos where cod_material=m.codigo_material)) from material_apoyo m where estado=1 and m.codigo_material not in ($itemsNoUtilizar)";


  if((int)$codigoMat!=0){
        $sql=$sql." and m.codigo_material in (".$codigoMat.")";
  }else{
	if($nombreItem!=""){
		$sql=$sql. " and descripcion_material like '%$nombreItem%'";
	}	

    if((int)$codTipo>0){
    	if(isset($_GET["codProv"])){
          $sql=$sql." and m.cod_linea_proveedor in (SELECT cod_linea_proveedor from proveedores_lineas where cod_proveedor=".$_GET["codProv"].")";
    	}else{
    	  $sql=$sql." and m.cod_linea_proveedor=".$codTipo."";	
    	}        
    }

    if((int)$codForma>0){
        $sql=$sql." and m.cod_forma_far=".$codForma."";
    }

    if((int)$codAccion>0){
        $sql=$sql." and m.codigo_material in (SELECT codigo_material FROM material_accionterapeutica where cod_accionterapeutica=".$codAccion.")";
    }else{    	
       if(isset($_GET['nomAccion'])&&$_GET['nomAccion']!=""){
          $sql=$sql." and m.codigo_material in (SELECT a.codigo_material FROM material_accionterapeutica a JOIN acciones_terapeuticas at on at.cod_accionterapeutica=a.cod_accionterapeutica where at.nombre_accionterapeutica like '%".$_GET['nomAccion']."%' )";
        }
    }

    if((int)$codPrincipio>0){
        $sql=$sql." and m.codigo_material in (SELECT cod_material FROM principios_activosproductos where cod_principioactivo=".$codPrincipio.")";
    }else{
    	if(isset($_GET['nomPrincipio'])&&$_GET['nomPrincipio']!=""){
          $sql=$sql." and m.codigo_material in (SELECT a.cod_material FROM principios_activosproductos a JOIN principios_activos at on at.codigo=a.cod_principioactivo where at.nombre like '%".$_GET['nomPrincipio']."%' )";
        }
    }    


	if($tipoSalidaVencimiento==$tipoSalida){
		$sql=$sql. " and m.codigo_material in (select id.cod_material from ingreso_almacenes i, ingreso_detalle_almacenes id 
		where i.cod_ingreso_almacen=id.cod_ingreso_almacen and i.cod_almacen='$globalAlmacen' and i.ingreso_anulado=0 
		and id.fecha_vencimiento<'$fechaActual') ";
	}
  }

	$sql=$sql." order by 2";
	
	//echo $sql;
	
	$resp=mysqli_query($enlaceCon,$sql);

	$numFilas=mysqli_num_rows($resp);
	if($numFilas>0){
		$indexFila=0;
		while($dat=mysqli_fetch_array($resp)){
			$codigo=$dat[0];
			$nombre=$dat[1];
			$linea=$dat[2];
			$cantidadPresentacion=$dat[3];
			$divi=$dat[4];
			$nombre=addslashes($nombre);
			$principiostring=$dat[5];
			if($tipoSalida==$tipoSalidaVencimiento){
				$stockProducto=stockProductoVencido($globalAlmacen, $codigo);
			}else{
				$stockProducto=stockProducto($globalAlmacen, $codigo);
			}
			
			$ubicacionProducto=ubicacionProducto($globalAlmacen, $codigo);
			
			$consulta="select p.`precio` from precios p where p.`codigo_material`='$codigo' and p.`cod_precio`='1' and cod_ciudad='-1'";
			$rs=mysqli_query($enlaceCon,$consulta);
			$registro=mysqli_fetch_array($rs);
			$precioProducto=$registro[0];
			if($precioProducto=="")
			{   $precioProducto=0;
			}
			$precioProducto=redondear2($precioProducto);
			
			$mostrarFila=1;
			if(isset($_GET["stock"])){
				 if($_GET["stock"]==1&&$stockProducto<=0){
                    $mostrarFila=0;
				 }  	              
			}
			if($mostrarFila==1){
				$indexFila++;

			if($stockProducto>0){
				$stockProducto="<b class='textograndenegro' style='color:#C70039'>".$stockProducto."</b>";
			}	
			 echo "<tr><td><div class='textograndenegro'><a class='enlace_ref' href='javascript:setMateriales(form1, $codigo, \"$nombre\",\"$cantidadPresentacion\",\"$divi\")' style='color:#C70039'>($codigo) $nombre</a></div></td>
			<td>$linea</td>
			<td>$principiostring</td>
			<td>$stockProducto</td>
			<td>$precioProducto</td>
			 </tr>";				
			}
		}
		if($indexFila==0){
		  echo "<tr><td colspan='5'>Sin Resultados en la busqueda.</td></tr>";	
		}		
	}else{
		echo "<tr><td colspan='5'>Sin Resultados en la busqueda.</td></tr>";
	}
	
?>
</table>
<?php
if($numFilas==1){
			//$nombre=str_replace(,"",$nombre);

}
