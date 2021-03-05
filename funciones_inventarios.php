<?php
require("conexionmysqli.inc");

function descontar_inventarios($cod_salida, $cod_almacen, $cod_material, $cantidad, $precio, $descuento, $montoparcial, $banderaVencidos, $orden){
	 require("conexionmysqli.inc");
	$fechaActual=date("Y-m-d");
	//echo $cod_salida." ".$cod_almacen." ".$cod_material." ".$cantidad;
	$cantidadPivote=$cantidad;
	
	$banderaError=1;
	
	$sqlExistencias="select id.cod_material, id.cantidad_restante, id.lote, id.fecha_vencimiento, id.cod_ingreso_almacen 
		from ingreso_almacenes i, ingreso_detalle_almacenes id 
		where i.cod_ingreso_almacen=id.cod_ingreso_almacen and i.cod_almacen='$cod_almacen' and i.ingreso_anulado=0 
		and id.cod_material='$cod_material' and id.cantidad_restante>0";
	if($banderaVencidos==1){
		$sqlExistencias.=" and id.fecha_vencimiento<'$fechaActual' ";
	}
	$sqlExistencias.=" order by id.lote, id.fecha_vencimiento asc";
	
	//AQUI SE DEBE CORREGIR EL DATO DE CANTIDAD RESTANTE >0 OJO
	
	//echo $sqlExistencias."<br>";
	$respExistencias=mysqli_query($enlaceCon,$sqlExistencias);
	while($datExistencias=mysqli_fetch_array($respExistencias)){
		if($cantidadPivote>0){
			$codMaterial=$datExistencias[0];
			$cantidadRestante=$datExistencias[1];
			$loteProducto=$datExistencias[2];
			$fechaVencProducto=$datExistencias[3];
			$codIngreso=$datExistencias[4];
			
			//echo $codMaterial." ".$cantidadRestante." ".$loteProducto." ".$fechaVencProducto."<br>";
			
			if($cantidadPivote<=$cantidadRestante){
				$cantidadInsert=$cantidadPivote;
				$cantidadPivote=0;
			}else{
				$cantidadPivote=$cantidadPivote-$cantidadRestante;
				$cantidadInsert=$cantidadRestante;
			}
			$montoparcial=$cantidadInsert*$precio;
			
			$sqlInsert="insert into salida_detalle_almacenes (cod_salida_almacen, cod_material, cantidad_unitaria, lote, fecha_vencimiento, precio_unitario,
			descuento_unitario, monto_unitario, cod_ingreso_almacen, orden_detalle) values ('$cod_salida', '$codMaterial', '$cantidadInsert', '$loteProducto', '$fechaVencProducto', '$precio','$descuento','$montoparcial','$codIngreso','$orden')";
			//echo $sqlInsert;
			$respInsert=mysqli_query($enlaceCon,$sqlInsert);
			
			if($respInsert!=1){
				$banderaError=2;
			}
			
			$sqlUpd="update ingreso_detalle_almacenes set cantidad_restante=cantidad_restante-$cantidadInsert where 
			cod_ingreso_almacen='$codIngreso' and lote='$loteProducto' and cod_material='$codMaterial'";
			$respUpd=mysqli_query($enlaceCon,$sqlUpd);
			
			if($respUpd!=1){
				$banderaError=3;
			}
		}
	}
	return($banderaError);
}

function insertar_detalle_pedido($cod_salida, $cod_almacen, $cod_material, $cantidad, $precio, $descuento, $montoparcial, $banderaVencidos, $orden){
	 require("conexionmysqli.inc");
	$fechaActual=date("Y-m-d");
	//echo $cod_salida." ".$cod_almacen." ".$cod_material." ".$cantidad;
	$cantidadPivote=$cantidad;
	
	$banderaError=1;
	
	$sqlExistencias="select id.cod_material, id.cantidad_restante, id.lote, id.fecha_vencimiento, id.cod_ingreso_almacen 
		from ingreso_almacenes i, ingreso_detalle_almacenes id 
		where i.cod_ingreso_almacen=id.cod_ingreso_almacen and i.cod_almacen='$cod_almacen' and i.ingreso_anulado=0 
		and id.cod_material='$cod_material' and id.cantidad_restante>0";
	if($banderaVencidos==1){
		$sqlExistencias.=" and id.fecha_vencimiento<'$fechaActual' ";
	}
	$sqlExistencias.=" order by id.lote, id.fecha_vencimiento asc";
	
	//AQUI SE DEBE CORREGIR EL DATO DE CANTIDAD RESTANTE >0 OJO
	
	//echo $sqlExistencias."<br>";
	$respExistencias=mysqli_query($enlaceCon,$sqlExistencias);
	while($datExistencias=mysqli_fetch_array($respExistencias)){
		if($cantidadPivote>0){
			$codMaterial=$datExistencias[0];
			$cantidadRestante=$datExistencias[1];
			$loteProducto=$datExistencias[2];
			$fechaVencProducto=$datExistencias[3];
			$codIngreso=$datExistencias[4];
			
			//echo $codMaterial." ".$cantidadRestante." ".$loteProducto." ".$fechaVencProducto."<br>";
			
			if($cantidadPivote<=$cantidadRestante){
				$cantidadInsert=$cantidadPivote;
				$cantidadPivote=0;
			}else{
				$cantidadPivote=$cantidadPivote-$cantidadRestante;
				$cantidadInsert=$cantidadRestante;
			}
			$montoparcial=$cantidadInsert*$precio;
			
			$sqlInsert="insert into pedido_detalle_almacenes (cod_salida_almacen, cod_material, cantidad_unitaria, lote, fecha_vencimiento, precio_unitario,
			descuento_unitario, monto_unitario, cod_ingreso_almacen, orden_detalle) values ('$cod_salida', '$codMaterial', '$cantidadInsert', '$loteProducto', '$fechaVencProducto', '$precio','$descuento','$montoparcial','$codIngreso','$orden')";
			//echo $sqlInsert;
			$respInsert=mysqli_query($enlaceCon,$sqlInsert);
			
			if($respInsert!=1){
				$banderaError=2;
			}
			
			
			if($respUpd!=1){
				$banderaError=3;
			}
		}
	}
	return($banderaError);
}

?>