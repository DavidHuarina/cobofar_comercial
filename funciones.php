<?php

function obtenerValorConfiguracion($id){
	require("conexionmysqli.inc");
	$sql = "SELECT valor_configuracion from configuraciones c where id_configuracion=$id";
	$resp=mysqli_query($enlaceCon,$sql);
	$codigo=0;
	while ($dat = mysqli_fetch_array($resp)) {
	  $codigo=$dat['valor_configuracion'];
	}
	return($codigo);
}

function generarCodigoAprobacion($codigo){
	//
	$nroDigitos = strlen("".$codigo);
	$nroDigitos--;//total digitos
	//
	$cadAux = strrev($codigo);
	$ultimoCar="".$cadAux[0];//ultimo digito
	//
	$cadAux = "".$codigo;
	$primerCar="".$cadAux[0];//primer digito
	//
	$acumulador=0;
	$cadAux="".$codigo;//echo "_$cadAux<br>";
	for($i=0;$i<=$nroDigitos;$i++)
	   {$acumulador+=$cadAux[$i];//echo "_$cadAux[$i]-----$i";
	   }
	$acumulador=$acumulador+100;//suma de digitos mas 100
	//
	//clave generada
	$claveGenerada="".$nroDigitos.$ultimoCar.$primerCar.$acumulador;	
	return $claveGenerada;
}

function formatNumberInt($valor) { 
   $float_redondeado=number_format($valor, 0); 
   return $float_redondeado; 
}

function formatNumberDec($valor) { 
   $float_redondeado=number_format($valor, 2); 
   return $float_redondeado; 
}

function redondear2($valor) { 
   $float_redondeado=round($valor * 100) / 100; 
   return $float_redondeado; 
}

function formateaFechaVista($cadena_fecha)
{	$cadena_formatonuevo=$cadena_fecha[6].$cadena_fecha[7].$cadena_fecha[8].$cadena_fecha[9]."-".$cadena_fecha[3].$cadena_fecha[4]."-".$cadena_fecha[0].$cadena_fecha[1];
	return($cadena_formatonuevo);
}

function formatearFecha2($cadena_fecha)
{	$cadena_formatonuevo=$cadena_fecha[8].$cadena_fecha[9]."/".$cadena_fecha[5].$cadena_fecha[6]."/".$cadena_fecha[0].$cadena_fecha[1].$cadena_fecha[2].$cadena_fecha[3];
	return($cadena_formatonuevo);
}

function UltimoDiaMes($cadena_fecha)
{	
	list($anioX, $mesX, $diaX)=explode("-",$cadena_fecha);
	$fechaNuevaX=$anioX."-".$mesX."-01";
	
	$fechaNuevaX=date('Y-m-d',strtotime($fechaNuevaX.'+1 month'));
	$fechaNuevaX=date('Y-m-d',strtotime($fechaNuevaX.'-1 day'));

	return($fechaNuevaX);
}

function obtenerCodigo($sql)
{	require("conexionmysqli.inc");
	$resp=mysqli_query($enlaceCon,$sql);
	$nro_filas_sql = mysqli_num_rows($resp);
	if($nro_filas_sql==0){
		$codigo=1;
	}else{
		while($dat=mysqli_fetch_array($resp))
		{	$codigo =$dat[0];
		}
			$codigo = $codigo+1;
	}
	return($codigo);
}


function margenLinea($item){
	require("conexionmysqli.inc");
	$fechaActual=date("Y-m-d");

	$sql="select p.margen_precio from material_apoyo m, proveedores_lineas p where 
		p.cod_linea_proveedor=m.cod_linea_proveedor and m.codigo_material=$item;";
	$resp=mysqli_query($enlaceCon,$sql);
	$dat=mysqli_fetch_array($resp);
	$margen=0;
	$margen=$dat[0];
	return($margen);
}


function precioProducto($item){
	require("conexionmysqli.inc");
	$fechaActual=date("Y-m-d");

	$sql="SELECT p.`precio` from precios p where p.`codigo_material`='$item' and p.`cod_precio`='1'";
	$resp=mysqli_query($enlaceCon,$sql);
	$dat=mysqli_fetch_array($resp);
	$precio=0;
	$precio=$dat[0];
	return($precio);
}


function ubicacionProducto($almacen, $item){
	//
	require("conexionmysqli.inc");
	$fechaActual=date("Y-m-d");

	$sql_ingresos="select 
	(select u.nombre from ubicaciones_estantes u where u.codigo=id.cod_ubicacionestante)as estante,
	(select u.nombre from ubicaciones_filas u where u.codigo=id.cod_ubicacionfila)as fila
	from ingreso_almacenes i, ingreso_detalle_almacenes id
			where i.cod_ingreso_almacen=id.cod_ingreso_almacen and i.cod_almacen='$almacen'
			and id.cod_material='$item' and i.ingreso_anulado=0 and id.cantidad_restante>0 limit 0,1";
	//echo $sql_ingresos;
	$resp_ingresos=mysqli_query($enlaceCon,$sql_ingresos);
	$dat_ingresos=mysqli_fetch_array($resp_ingresos);
	$ubicacion=$dat_ingresos[0]."-".$dat_ingresos[1];
	return($ubicacion);
	
}

function stockProducto($almacen, $item){
	//
	require("conexionmysqli.inc");
	$fechaActual=date("Y-m-d");

	$sql_ingresos="select sum(id.cantidad_unitaria) from ingreso_almacenes i, ingreso_detalle_almacenes id
			where i.cod_ingreso_almacen=id.cod_ingreso_almacen and i.fecha<='$fechaActual' and i.cod_almacen='$almacen'
			and id.cod_material='$item' and i.ingreso_anulado=0";
			$resp_ingresos=mysqli_query($enlaceCon,$sql_ingresos);
			$dat_ingresos=mysqli_fetch_array($resp_ingresos);
			$cant_ingresos=$dat_ingresos[0];
			$sql_salidas="select sum(sd.cantidad_unitaria) from salida_almacenes s, salida_detalle_almacenes sd
			where s.cod_salida_almacenes=sd.cod_salida_almacen and s.fecha<='$fechaActual' and s.cod_almacen='$almacen'
			and sd.cod_material='$item' and s.salida_anulada=0";
			$resp_salidas=mysqli_query($enlaceCon,$sql_salidas);
			$dat_salidas=mysqli_fetch_array($resp_salidas);
			$cant_salidas=$dat_salidas[0];
			$stock2=$cant_ingresos-$cant_salidas;
	return($stock2);
}

function stockProductoVencido($almacen, $item){
	//
	require("conexionmysqli.inc");
	$fechaActual=date("Y-m-d");

	$sql_ingresos="select sum(id.cantidad_restante) from ingreso_almacenes i, ingreso_detalle_almacenes id where i.cod_ingreso_almacen=id.cod_ingreso_almacen and i.cod_almacen='$almacen' and i.ingreso_anulado=0 and id.fecha_vencimiento<'$fechaActual' and id.cod_material='$item'";
	$resp_ingresos=mysqli_query($enlaceCon,$sql_ingresos);
	$dat_ingresos=mysqli_fetch_array($resp_ingresos);
	$cant_ingresos=$dat_ingresos[0];
	$stock2=$cant_ingresos;
	return($stock2);
}

function stockMaterialesEdit($almacen, $item, $cantidad){
	//
	require("conexionmysqli.inc");
	$cadRespuesta="";
	$consulta="
	    SELECT SUM(id.cantidad_restante) as total
	    FROM ingreso_detalle_almacenes id, ingreso_almacenes i
	    WHERE id.cod_material='$item' AND i.cod_ingreso_almacen=id.cod_ingreso_almacen AND i.ingreso_anulado=0 AND i.cod_almacen='$almacen'";
	$rs=mysqli_query($enlaceCon,$consulta);
	$registro=mysqli_fetch_array($rs);
	$cadRespuesta=$registro[0];
	if($cadRespuesta=="")
	{   $cadRespuesta=0;
	}
	$cadRespuesta=$cadRespuesta+$cantidad;
	$cadRespuesta=redondear2($cadRespuesta);
	return($cadRespuesta);
}
function restauraCantidades($codigo_registro){
	$sql_detalle="select cod_ingreso_almacen, material, cantidad_unitaria
				from salida_detalle_ingreso
				where cod_salida_almacen='$codigo_registro'";
	$resp_detalle=mysqli_query($enlaceCon,$sql_detalle);
	while($dat_detalle=mysqli_fetch_array($resp_detalle))
	{	$codigo_ingreso=$dat_detalle[0];
		$material=$dat_detalle[1];
		$cantidad=$dat_detalle[2];
		$nro_lote=$dat_detalle[3];
		$sql_ingreso_cantidad="select cantidad_restante from ingreso_detalle_almacenes
								where cod_ingreso_almacen='$codigo_ingreso' and cod_material='$material'";
		$resp_ingreso_cantidad=mysqli_query($enlaceCon,$sql_ingreso_cantidad);
		$dat_ingreso_cantidad=mysqli_fetch_array($resp_ingreso_cantidad);
		$cantidad_restante=$dat_ingreso_cantidad[0];
		$cantidad_restante_actualizada=$cantidad_restante+$cantidad;
		$sql_actualiza="update ingreso_detalle_almacenes set cantidad_restante=$cantidad_restante_actualizada
						where cod_ingreso_almacen='$codigo_ingreso' and cod_material='$material'";
		
		$resp_actualiza=mysqli_query($enlaceCon,$sql_actualiza);			
	}
	return(1);
}
function verificarAlmacenCiudadExistente($age1){
	require("conexionmysqli.inc");
  $sql_detalle="SELECT cod_ciudad,codigo_anterior from ciudades";
  $codigo=0;				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       if($detalle[1]==$age1){
         $codigo=$detalle[0];
       }   		
  }  
  return $codigo;
}
function numeroCorrelativo($tipoDoc){
	require("conexionmysqli.inc");
	$banderaErrorFacturacion=0;
	//SACAMOS LA CONFIGURACION PARA CONOCER SI LA FACTURACION ESTA ACTIVADA
	$sqlConf="select valor_configuracion from configuraciones where id_configuracion=3";
	$respConf=mysqli_query($enlaceCon,$sqlConf);
	$facturacionActivada=mysqli_result($respConf,0,0);

	$fechaActual=date("Y-m-d");
	$globalAgencia=$_COOKIE['global_agencia'];
	
	if($facturacionActivada==1 && $tipoDoc==1){
		//VALIDAMOS QUE LA DOSIFICACION ESTE ACTIVA
		$sqlValidar="select count(*) from dosificaciones d 
		where d.cod_sucursal='$globalAgencia' and d.cod_estado=1 and d.fecha_limite_emision>='$fechaActual'";
		$respValidar=mysqli_query($enlaceCon,$sqlValidar);
		$numFilasValidar=mysqli_result($respValidar,0,0);
		
		if($numFilasValidar==1){
			$sqlCodDosi="select cod_dosificacion from dosificaciones d 
			where d.cod_sucursal='$globalAgencia' and d.cod_estado=1";
			$respCodDosi=mysqli_query($enlaceCon,$sqlCodDosi);
			$codigoDosificacion=mysqli_result($respCodDosi,0,0);
		
			if($tipoDoc==1){//validamos la factura para que trabaje con la dosificacion
				$sql="select IFNULL(max(nro_correlativo)+1,1) from salida_almacenes where cod_tipo_doc='$tipoDoc' 
				and cod_dosificacion='$codigoDosificacion'";	
			}else{
				$sql="select IFNULL(max(nro_correlativo)+1,1) from salida_almacenes where cod_tipo_doc='$tipoDoc'";
			}
			//echo $sql;
			$resp=mysqli_query($enlaceCon,$sql);
			$codigo=mysqli_result($resp,0,0);
			
			$vectorCodigo = array($codigo,$banderaErrorFacturacion,$codigoDosificacion);
			return $vectorCodigo;
		}else{
			$banderaErrorFacturacion=1;
			$vectorCodigo = array("DOSIFICACION INCORRECTA O VENCIDA",$banderaErrorFacturacion,0);
			return $vectorCodigo;
		}
	}
	if(($facturacionActivada==1 && $tipoDoc!=1) || $facturacionActivada!=1){
		$sql="select IFNULL(max(nro_correlativo)+1,1) from salida_almacenes where cod_tipo_doc='$tipoDoc'";
		//echo $sql;
		$resp=mysqli_query($enlaceCon,$sql);
		while($dat=mysqli_fetch_array($resp)){
			$codigo=$dat[0];
			$vectorCodigo = array($codigo,$banderaErrorFacturacion,0);
			return $vectorCodigo;
		}
	}
}
function obtenerCodigoAlmacenPorCiudad($ciudad){
	require("conexionmysqli.inc");
  $sql_detalle="SELECT cod_almacen from almacenes where cod_ciudad='$ciudad'";
  $codigo=0;				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $codigo=$detalle[0];   		
  }  
  return $codigo;
}

function obtenerTotalDias(){
	require("conexionmysqli.inc");
  $sql_detalle="SELECT count(*) cantidad from dias where estado=1";
  $cantidad=0;				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $cantidad=$detalle[0];   		
  }  
  return $cantidad;
}
function obtenerTotalCiudades(){
	require("conexionmysqli.inc");
  $sql_detalle="SELECT count(*) cantidad from ciudades where cod_estadoreferencial=1";
  $cantidad=0;				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $cantidad=$detalle[0];   		
  }  
  return $cantidad;
}
function obtenerNombreDiaCompleto($dia){
	require("conexionmysqli.inc");
  $sql_detalle="SELECT nombre from dias where codigo='$dia'";
  $abrev="";				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $abrev=$detalle[0];   		
  }  
  return $abrev;
}

function obtenerNombreDia($dia){
	require("conexionmysqli.inc");
  $sql_detalle="SELECT abreviatura2 from dias where codigo='$dia'";
  $abrev="";				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $abrev=$detalle[0];   		
  }  
  return $abrev;
}
function obtenerNombreCiudad($ciudad){
	require("conexionmysqli.inc");
  $sql_detalle="SELECT descripcion from ciudades where cod_ciudad='$ciudad'";
  $nombre="";				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $nombre=$detalle[0];   		
  }  
  return $nombre;
}
function obtenerNombreCiudadPorAlmacen($almacen){
	require("conexionmysqli.inc");
  $sql_detalle="SELECT c.descripcion from ciudades c join almacenes a on a.cod_ciudad=c.cod_ciudad where a.cod_almacen='$almacen'";
  $nombre="";				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $nombre=$detalle[0];   		
  }  
  return $nombre;
}
function obtenerNombreDesDiasRegistrados($codigo){
  $cantidad=obtenerTotalDias();
  require("conexionmysqli.inc");
  $sql_detalle="SELECT cod_dia from tipos_precio_dias where cod_tipoprecio='$codigo'";
  $i=0;
  $diasArray=[];				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
  	   $diasArray[$i]=obtenerNombreDia($detalle[0]);
       $i++;  		
  }  
  if(count($diasArray)==$cantidad){
  	return "TODOS";
  }else if(count($diasArray)==0){
  	return "NINGUNO";
  }else{
  	return implode(", ",$diasArray);
  }
}
function obtenerNombreDesCiudadesRegistrados($codigo){
  $cantidad=obtenerTotalCiudades();
  require("conexionmysqli.inc");
  $sql_detalle="SELECT cod_ciudad from tipos_precio_ciudad where cod_tipoprecio='$codigo'";
  $i=0;
  $ciudadArray=[];				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
  	   $ciudadArray[$i]=obtenerNombreCiudad($detalle[0]);
       $i++;  		
  }  
  if(count($ciudadArray)==$cantidad){
  	return "TODOS";
  }else if(count($ciudadArray)==0){
  	return "NINGUNO";
  }else{
  	return implode(", ",$ciudadArray);
  }
}
function obtenerDescripcionMotivo($codigo,$ninguna){
  require("conexionmysqli.inc");
  $sql_detalle="SELECT descripcion from observaciones_clase where codigo='$codigo'";
  $nombre="";
  if($ninguna==1){
  	$nombre="OBSERVACIÓN ESPECÍFICA";
  }
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $nombre=$detalle[0];   		
  }  
  return $nombre;
}
function obtenerNombreProveedor($codigo){
  $estilosVenta=1;
  require("conexionmysqli.inc");
  $sql_detalle="SELECT nombre_proveedor from proveedores where cod_proveedor='$codigo'";
  $proveedor="";				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $proveedor=$detalle[0];   		
  } 
  mysqli_close($enlaceCon); 
  return $proveedor;
}
function obtenerNombreProveedorLinea($codigo){
	$estilosVenta=1;
	require("conexionmysqli.inc");
  $sql_detalle="SELECT nombre_linea_proveedor from proveedores_lineas where cod_linea_proveedor='$codigo'";
  $linea="";				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $linea=$detalle[0];   		
  }  
  mysqli_close($enlaceCon);
  return $linea;
}
function obtenerMontoVentasGeneradas($desde,$hasta,$sucursal,$tipoPago){
	$estilosVenta=1;
	require("conexionmysqli.inc");
	$sql="select sum(s.monto_final) as monto
	from `salida_almacenes` s where s.`cod_tiposalida`=1001 and s.salida_anulada=0 and
	s.`cod_almacen` in (select a.`cod_almacen` from `almacenes` a where a.`cod_ciudad` in ($sucursal))
	and s.`fecha` BETWEEN '$desde' and '$hasta' and 
	s.cod_tipopago in ($tipoPago)";
  //echo $sql;	
  $resp=mysqli_query($enlaceCon,$sql);
  $monto=0;				
  while($detalle=mysqli_fetch_array($resp)){	
       $monto=$detalle[0];   		
  }  
  mysqli_close($enlaceCon);
  return $monto;
}

function obtenerPrecioProductoSucursal($codigo){
	$estilosVenta=1;
	require("conexionmysqli.inc");
	$sql="SELECT MAX(precio) from precios where codigo_material='$codigo' and cod_precio=1 and cod_ciudad is not null";
    $resp=mysqli_query($enlaceCon,$sql);
    $monto=0;				
    while($detalle=mysqli_fetch_array($resp)){	
         $monto=$detalle[0];   		
    }  
    mysqli_close($enlaceCon);
    return $monto;
}
function obtenerCodigoCiudadPorAlmacen($almacen){
	require("conexionmysqli.inc");
  $sql_detalle="SELECT cod_ciudad from almacenes where cod_almacen='$almacen'";
  $codigo=0;				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $codigo=$detalle[0];   		
  }  
  return $codigo;
}

function actualizarPrecioSiEsMayor($cod_material,$precioUnitario,$user){
  require("conexionmysqli.inc");
  $sql_detalle="SELECT MAX(precio) from precios where cod_precio=1 and codigo_material='$cod_material'";
  $precio=0;				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $precio=$detalle[0];   		
  }  

  if($precioUnitario>$precio){
  	$sql_update="UPDATE precios set precio='$precioUnitario',cod_funcionario='$user' where cod_precio=1 and codigo_material='$cod_material'";	
    $resp=mysqli_query($enlaceCon,$sql_update);
  }
}
function obtenerTotalLineas(){
	require("conexionmysqli.inc");
  $sql_detalle="SELECT count(*) cantidad from proveedores_lineas where estado=1";
  $cantidad=0;				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $cantidad=$detalle[0];   		
  }  
  return $cantidad;
}
function obtenerNombreDesLineasRegistrados($codigo){
  $cantidad=obtenerTotalLineas();
  require("conexionmysqli.inc");
  $sql_detalle="SELECT cod_linea_proveedor from tipos_precio_lineas where cod_tipoprecio='$codigo'";
  $i=0;
  $lineaArray=[];				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
  	   $lineaArray[$i]=obtenerNombreProveedorLinea($detalle[0]);
       $i++;  		
  }  
  if(count($lineaArray)==$cantidad){
  	return "TODOS";
  }else if(count($lineaArray)==0){
  	return "NINGUNO";
  }else{
  	return implode(", ",$lineaArray);
  }
}
function redondearMitades($n) {
    $ent = floor($n); // Parte entera
    $dec = $n - $ent; // Parte decimal
    $r = ceil($dec*2) / 2; // Decimal redondeado
    return $ent + $r;
}
?>