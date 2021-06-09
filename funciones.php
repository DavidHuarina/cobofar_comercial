<?php
$estilosVenta=1;
function obtenerValorConfiguracion($id){
	$estilosVenta=1;
	require("conexionmysqli2.inc");
	$sql = "SELECT valor_configuracion from configuraciones c where id_configuracion=$id";
	$resp=mysqli_query($enlaceCon,$sql);
	$codigo=0;
	while ($dat = mysqli_fetch_array($resp)) {
	  $codigo=$dat['valor_configuracion'];
	}
	return($codigo);
}

function obtenerInicioActividadesSucursal($id){
	$estilosVenta=1;
	require("conexionmysqli2.inc");
	$sql = "SELECT fecha_inicio from configuraciones_inicio_sucursales c where cod_ciudad=$id";
	$resp=mysqli_query($enlaceCon,$sql);
	$codigo="1983-01-01";
	while ($dat = mysqli_fetch_array($resp)) {
	  $codigo=$dat['fecha_inicio'];
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
{	require("conexionmysqli2.inc");
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
	require("conexionmysqli2.inc");
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
	require("conexionmysqli2.inc");
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
	require("conexionmysqli2.inc");
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
function obtenerCantidadPresentacionProducto($codigo){
  $estilosVenta=1;
  require("conexionmysqli2.inc");
  $sql_detalle="SELECT cantidad_presentacion FROM material_apoyo where codigo_material='$codigo'";
  $valor=0;				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $valor=$detalle[0];   		
  }  
  mysqli_close($enlaceCon);
  return $valor;
}



function stockProducto($almacen, $item){	
	$fechaActual=date("Y-m-d");
	$stock2=stockProductoFechas($almacen, $item,$fechaActual);
	return($stock2);
}

function stockProductoFechas($almacen, $item,$fechaActual){
	$estilosVenta=1;
	$codSucursal=obtenerSucursalporAlmacen($almacen);
	$fechaInicioSucursal=obtenerInicioActividadesSucursal($codSucursal);
	require("conexionmysqli2.inc");

    $sql_ingresos="select IFNULL(sum(id.cantidad_unitaria),0) from ingreso_almacenes i, ingreso_detalle_almacenes id
			where i.cod_ingreso_almacen=id.cod_ingreso_almacen and i.fecha BETWEEN '$fechaInicioSucursal' and '$fechaActual' and i.cod_almacen='$almacen'
			and id.cod_material='$item' and i.ingreso_anulado=0";
	$resp_ingresos=mysqli_query($enlaceCon,$sql_ingresos);
	$dat_ingresos=mysqli_fetch_array($resp_ingresos);
	$cant_ingresos=$dat_ingresos[0];
	$sql_salidas="select IFNULL(sum(sd.cantidad_unitaria),0) from salida_almacenes s, salida_detalle_almacenes sd
			where s.cod_salida_almacenes=sd.cod_salida_almacen and s.fecha BETWEEN '$fechaInicioSucursal' and '$fechaActual' and s.cod_almacen='$almacen'
			and sd.cod_material='$item' and s.salida_anulada=0";
	$resp_salidas=mysqli_query($enlaceCon,$sql_salidas);
	$dat_salidas=mysqli_fetch_array($resp_salidas);
	$cant_salidas=$dat_salidas[0];
	$stock2=$cant_ingresos-$cant_salidas;

	$sql_ingresos="select IFNULL(sum(id.cantidad_envase),0) from ingreso_almacenes i, ingreso_detalle_almacenes id
			where i.cod_ingreso_almacen=id.cod_ingreso_almacen and i.fecha BETWEEN '$fechaInicioSucursal' and '$fechaActual' and i.cod_almacen='$almacen'
			and id.cod_material='$item' and i.ingreso_anulado=0";
	$resp_ingresos=mysqli_query($enlaceCon,$sql_ingresos);
	$dat_ingresos=mysqli_fetch_array($resp_ingresos);
	$cant_ingresos2=$dat_ingresos[0];
	$sql_salidas="select IFNULL(sum(sd.cantidad_envase),0) from salida_almacenes s, salida_detalle_almacenes sd
			where s.cod_salida_almacenes=sd.cod_salida_almacen and s.fecha BETWEEN '$fechaInicioSucursal' and '$fechaActual' and s.cod_almacen='$almacen'
			and sd.cod_material='$item' and s.salida_anulada=0";
	$resp_salidas=mysqli_query($enlaceCon,$sql_salidas);
	$dat_salidas=mysqli_fetch_array($resp_salidas);
	$cant_salidas2=$dat_salidas[0];
	$stock2Caja=$cant_ingresos2-$cant_salidas2;
	//echo $sql_ingresos;
    $cantPres=obtenerCantidadPresentacionProducto($item);
    

	return $stock2+($stock2Caja/$cantPres);
}

function precioProductoAlmacen($ciudad, $item){
	require("conexionmysqli2.inc");
	$sqlPrecio="SELECT p.`precio` from `precios` p where p.`cod_precio`=1 and p.`cod_ciudad`=$ciudad and p.`codigo_material`=$item";
	$resp_precio=mysqli_query($enlaceCon,$sqlPrecio);
	$precio=0;
	while($dat_detalle=mysqli_fetch_array($resp_precio))
	{
       $precio=$dat_detalle[0];
	}
	return($precio);
}

function stockProductoVencido($almacen, $item){
	$estilosVenta=1;
	require("conexionmysqli2.inc");
	$fechaActual=date("Y-m-d");

	$sql_ingresos="select sum(id.cantidad_restante) from ingreso_almacenes i, ingreso_detalle_almacenes id where i.cod_ingreso_almacen=id.cod_ingreso_almacen and i.cod_almacen='$almacen' and i.ingreso_anulado=0 and id.fecha_vencimiento<'$fechaActual' and id.cod_material='$item'";
	$resp_ingresos=mysqli_query($enlaceCon,$sql_ingresos);
	$dat_ingresos=mysqli_fetch_array($resp_ingresos);
	$cant_ingresos=$dat_ingresos[0];
	$stock2=$cant_ingresos;

	$sql_ingresos="select sum(id.cantidad_restante_envase) from ingreso_almacenes i, ingreso_detalle_almacenes id where i.cod_ingreso_almacen=id.cod_ingreso_almacen and i.cod_almacen='$almacen' and i.ingreso_anulado=0 and id.fecha_vencimiento<'$fechaActual' and id.cod_material='$item'";

	$resp_ingresos=mysqli_query($enlaceCon,$sql_ingresos);
	$dat_ingresos=mysqli_fetch_array($resp_ingresos);
	$cant_ingresosCaja=$dat_ingresos[0];
	$stock2Caja=$cant_ingresosCaja;

    $cantPres=obtenerCantidadPresentacionProducto($item);
    
	return $stock2+($stock2Caja/$cantPres);
}

function stockMaterialesEdit($almacen, $item, $cantidad){
	//
	require("conexionmysqli2.inc");
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
	require("conexionmysqli2.inc");
  $sql_detalle="SELECT cod_ciudad,codigo_anterior from ciudades";
  $codigo=0;				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       if($detalle[1]==$age1){  //aui se está validando OJO no en el where porque no reconoce algunos simbolos
         $codigo=$detalle[0];
       }   		
  }  
  return $codigo;
}

function verificarPersonalUsuario($codigo){
	require("conexionmysqli2.inc");
  $sql_detalle="SELECT codigo_funcionario from funcionarios where codigo_funcionario='$codigo'";
  $codigo=0;				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
      $codigo=$detalle[0];		
  }  
  return $codigo;
}

function verificarProductoExistente($codigo){
	require("conexionmysqli2.inc");
  $sql_detalle="SELECT count(*) from material_apoyo where codigo_material='$codigo'";
  $codigo=0;				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
    $codigo=$detalle[0];   		
  }  
  return $codigo;
}

function obtenerProductoCantidadLinea($codigo,$cb){
  $queryCb="";
  if($cb==0){
  	$queryCb=" and (codigo_barras='' or codigo_barras is null)";
  }	
	require("conexionmysqli2.inc");
  $sql_detalle="SELECT count(*) from material_apoyo where cod_linea_proveedor='$codigo' $queryCb";
  $codigo=0;				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
    $codigo=$detalle[0];   		
  }  
  return $codigo;
}

function numeroCorrelativo($tipoDoc){
	$estilosVenta=1;
	require("conexionmysqli2.inc");
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
		where d.cod_sucursal='$globalAgencia' and d.cod_estado=1 and d.fecha_limite_emision>='$fechaActual' and d.tipo_dosificacion=1";
		$respValidar=mysqli_query($enlaceCon,$sqlValidar);
		$numFilasValidar=mysqli_result($respValidar,0,0);
		
		if($numFilasValidar==1){
			$sqlCodDosi="select cod_dosificacion from dosificaciones d 
			where d.cod_sucursal='$globalAgencia' and d.cod_estado=1 and d.tipo_dosificacion=1";
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
	if($facturacionActivada==1 && $tipoDoc==4){
		//VALIDAMOS QUE LA DOSIFICACION ESTE ACTIVA
		$sqlValidar="select count(*) from dosificaciones d 
		where d.cod_sucursal='$globalAgencia' and d.cod_estado=1 and d.fecha_limite_emision>='$fechaActual' and d.tipo_dosificacion=2";
		$respValidar=mysqli_query($enlaceCon,$sqlValidar);
		$numFilasValidar=mysqli_result($respValidar,0,0);
		
		if($numFilasValidar==1){
			$sqlCodDosi="select cod_dosificacion from dosificaciones d 
			where d.cod_sucursal='$globalAgencia' and d.cod_estado=1 and d.tipo_dosificacion=2";
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
	$estilosVenta=1;
	require("conexionmysqli2.inc");
	//$global_tipo_almacen=$_COOKIE["global_tipo_almacen"];
	$global_tipo_almacen=1;
  $sql_detalle="SELECT cod_almacen from almacenes where cod_ciudad='$ciudad' and cod_tipoalmacen='$global_tipo_almacen'";
  $codigo=0;				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $codigo=$detalle[0];   		
  }  
  return $codigo;
}

function obtenerTotalDias(){
	require("conexionmysqli2.inc");
  $sql_detalle="SELECT count(*) cantidad from dias where estado=1";
  $cantidad=0;				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $cantidad=$detalle[0];   		
  }  
  return $cantidad;
}
function obtenerTotalCiudades(){
	require("conexionmysqli2.inc");
  $sql_detalle="SELECT count(*) cantidad from ciudades where cod_estadoreferencial=1";
  $cantidad=0;				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $cantidad=$detalle[0];   		
  }  
  return $cantidad;
}
function obtenerNombreDiaCompleto($dia){
	require("conexionmysqli2.inc");
  $sql_detalle="SELECT nombre from dias where codigo='$dia'";
  $abrev="";				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $abrev=$detalle[0];   		
  }  
  return $abrev;
}

function obtenerNombreDia($dia){
	require("conexionmysqli2.inc");
  $sql_detalle="SELECT abreviatura2 from dias where codigo='$dia'";
  $abrev="";				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $abrev=$detalle[0];   		
  }  
  return $abrev;
}
function obtenerNombreCiudad($ciudad){
	require("conexionmysqli2.inc");
  $sql_detalle="SELECT descripcion from ciudades where cod_ciudad='$ciudad'";
  $nombre="";				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $nombre=$detalle[0];   		
  }  
  return $nombre;
}

function obtenerNombreCiudadPorAlmacen($almacen){
	require("conexionmysqli2.inc");
  $sql_detalle="SELECT c.descripcion from ciudades c join almacenes a on a.cod_ciudad=c.cod_ciudad where a.cod_almacen='$almacen'";
  $nombre="";				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $nombre=$detalle[0];   		
  }  
  return $nombre;
}

function obtenerSucursalporAlmacen($almacen){
	require("conexionmysqli2.inc");
  $sql_detalle="SELECT a.cod_ciudad from almacenes a where a.cod_almacen='$almacen'";
  $codigo="";				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $codigo=$detalle[0];   		
  }  
  return $codigo;
}

function obtenerNombreDesDiasRegistrados($codigo){
  $cantidad=obtenerTotalDias();
  require("conexionmysqli2.inc");
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
  require("conexionmysqli2.inc");
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

function obtenerNombreDesCiudadesRegistradosGeneral($codigo){
  $cantidad=obtenerTotalCiudades();
  require("conexionmysqli2.inc");
  $sql_detalle="SELECT cod_ciudad from tipos_preciogeneral_ciudad where cod_tipoprecio='$codigo'";
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
  require("conexionmysqli2.inc");
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
function obtenerNombreProveedorDeLinea($codigo){
  $estilosVenta=1;
  require("conexionmysqli2.inc");
  $sql_detalle="SELECT p.nombre_proveedor from proveedores p join proveedores_lineas l where l.cod_linea_proveedor='$codigo'";
  $proveedor="";				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $proveedor=$detalle[0];   		
  } 
  mysqli_close($enlaceCon); 
  return $proveedor;
}
function obtenerNombreProveedor($codigo){
  $estilosVenta=1;
  require("conexionmysqli2.inc");
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
	require("conexionmysqli2.inc");
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
	require("conexionmysqli2.inc");
	$sql="select sum(s.monto_final) as monto
	from `salida_almacenes` s where s.`cod_tiposalida`=1001 and s.salida_anulada=0 and
	s.`cod_almacen` in (select a.`cod_almacen` from `almacenes` a where a.`cod_ciudad` in ($sucursal))
	and s.`fecha` BETWEEN '$desde' and '$hasta' and 
	s.cod_tipopago in ($tipoPago)";
  //echo $sql;	
  $resp=mysqli_query($enlaceCon,$sql);
  $monto=0;				
  while($detalle=mysqli_fetch_array($resp)){	
       $monto+=$detalle[0];   		
  }  
  mysqli_close($enlaceCon);
  return $monto;
}

function obtenerMontoVentasPerdido($desde,$hasta,$sucursal){
	$estilosVenta=1;
	require("conexionmysqli2.inc");
	$sql="select sum(s.monto_final) as monto
	from `pedido_almacenes` s where s.salida_anulada=0 and
	s.`cod_almacen` in (select a.`cod_almacen` from `almacenes` a where a.`cod_ciudad` in ($sucursal))
	and s.`fecha` BETWEEN '$desde' and '$hasta'";
  //echo $sql;	
  $resp=mysqli_query($enlaceCon,$sql);
  $monto=0;				
  while($detalle=mysqli_fetch_array($resp)){	
       $monto+=$detalle[0];   		
  }  
  mysqli_close($enlaceCon);
  return $monto;
}

function obtenerAlmacenesStringDeSubGrupo($ciudades){
	$estilosVenta=1;
	require("conexionmysqli2.inc");
	$sql="SELECT GROUP_CONCAT(cod_almacen) from almacenes where cod_ciudad in ($ciudades) GROUP BY cod_ciudad;";
    $resp=mysqli_query($enlaceCon,$sql);
    $datos=[];$index=0;				
    while($detalle=mysqli_fetch_array($resp)){
       $datos[$index]=$detalle[0];
       $index++;		 		
    }  
    return implode(",", $datos);
}

function obtenerMaterialesStringDeSubGrupo($subGrupo){
	$estilosVenta=1;
	require("conexionmysqli2.inc");
	$sql="SELECT GROUP_CONCAT(cod_material) from subgrupos_material where cod_subgrupo in ($subGrupo) GROUP BY cod_subgrupo;";
    $resp=mysqli_query($enlaceCon,$sql);
    $datos=[];$index=0;				
    while($detalle=mysqli_fetch_array($resp)){
       $datos[$index]=$detalle[0];
       $index++;		 		
    }  
    return implode(",", $datos);
}
function obtenerMaterialesStringDeLinea($subGrupo){
	$estilosVenta=1;
	require("conexionmysqli2.inc");
	$sql="SELECT GROUP_CONCAT(codigo_material) from material_apoyo where cod_linea_proveedor in ($subGrupo) GROUP BY cod_linea_proveedor;";
    $resp=mysqli_query($enlaceCon,$sql);
    $datos=[];$index=0;				
    while($detalle=mysqli_fetch_array($resp)){
       $datos[$index]=$detalle[0];
       $index++;		 		
    }  
    return implode(",", $datos);
}

function obtenerAlmacenesDeCiudadString($subGrupo){
	$estilosVenta=1;
	require("conexionmysqli2.inc");
	$sql="SELECT GROUP_CONCAT(cod_almacen) from almacenes where cod_ciudad in ($subGrupo) GROUP BY cod_ciudad;";
    $resp=mysqli_query($enlaceCon,$sql);
    $datos=[];$index=0;				
    while($detalle=mysqli_fetch_array($resp)){
       $datos[$index]=$detalle[0];
       $index++;		 		
    }  
    return implode(",", $datos);
}

function obtenerMontoVentasGeneradasCategoria($desde,$hasta,$sucursal,$tipoPago,$subGrupo){
	$estilosVenta=1;
	require("conexionmysqli2.inc");
	$sql="select SUM((SELECT sum(sd.monto_unitario*sd.cantidad_unitaria) FROM salida_detalle_almacenes sd where sd.cod_salida_almacen=s.cod_salida_almacenes and sd.cod_material in (SELECT cod_material from subgrupos_material where cod_subgrupo in ($subGrupo)))) as monto
	from salida_almacenes s where s.`cod_tiposalida`=1001 and s.salida_anulada=0 and
	s.`cod_almacen` in (select a.`cod_almacen` from `almacenes` a where a.`cod_ciudad` in ($sucursal))
	and s.`fecha` BETWEEN '$desde' and '$hasta' and 
	s.cod_tipopago in ($tipoPago)";
  echo $sql;	
  $resp=mysqli_query($enlaceCon,$sql);
  $monto=0;				
  while($detalle=mysqli_fetch_array($resp)){	
       $monto+=$detalle[0];   		
  }  
  mysqli_close($enlaceCon);
  return $monto;
}
function obtenerMontoVentasGeneradasCategoriaMaterial($desde,$hasta,$sucursal,$tipoPago,$materiales){
	$estilosVenta=1;
	require("conexionmysqli2.inc");
	$sql="SELECT sum(sd.monto_unitario*sd.cantidad_unitaria) FROM salida_detalle_almacenes sd 
	join salida_almacenes s on s.cod_salida_almacenes=sd.cod_salida_almacen
	where sd.cod_salida_almacen=s.cod_salida_almacenes and sd.cod_material in ($materiales) and 
	s.`cod_tiposalida`=1001 and s.`cod_almacen` in ($sucursal) and s.salida_anulada=0 and 
	s.cod_tipopago in ($tipoPago) and s.`fecha` BETWEEN '$desde' and '$hasta'";
  //echo $sql;	
  $resp=mysqli_query($enlaceCon,$sql);
  $monto=0;				
  while($detalle=mysqli_fetch_array($resp)){	
       $monto+=$detalle[0];   		
  }  
  mysqli_close($enlaceCon);
  return $monto;
}
function obtenerPrecioProductoSucursal($codigo){
	$estilosVenta=1;
	require("conexionmysqli2.inc");
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
	require("conexionmysqli2.inc");
  $sql_detalle="SELECT cod_ciudad from almacenes where cod_almacen='$almacen'";
  $codigo=0;				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $codigo=$detalle[0];   		
  }  
  return $codigo;
}

function actualizarPrecioSiEsMayor($cod_material,$precioUnitario,$user){
  require("conexionmysqli2.inc");
  $sql_detalle="SELECT MAX(precio) from precios where cod_precio=1 and codigo_material='$cod_material'";
  $precio=0;				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $precio=(float)$detalle[0];   		
  }  

  if($precioUnitario>$precio){
  	insertarPrecioTodasSucursales($cod_material,$user,$precioUnitario);
  }
}
function insertarPrecioTodasSucursales($cod_material,$user,$precioUnitario){
  require("conexionmysqli2.inc");
  $sql_delete="DELETE FROM precios where cod_precio=1 and codigo_material='$cod_material'";	
  $resp=mysqli_query($enlaceCon,$sql_delete);
  $sql_ciudades="SELECT cod_ciudad FROM ciudades where cod_estadoreferencial=1";	
  $resp_ciudad=mysqli_query($enlaceCon,$sql_ciudades);
  while($ciudad=mysqli_fetch_array($resp_ciudad)){	
       $cod_ciudad=$ciudad[0];  
       $sql_update="INSERT precios VALUES('$cod_material',1,'$precioUnitario','$cod_ciudad','$user')";	
       $resp=mysqli_query($enlaceCon,$sql_update); 		
  } 
}
function obtenerTotalLineas(){
	require("conexionmysqli2.inc");
  $sql_detalle="SELECT count(*) cantidad from proveedores_lineas where estado=1";
  $cantidad=0;				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $cantidad=$detalle[0];   		
  }  
  return $cantidad;
}
function obtenerTotalProd(){
	require("conexionmysqli2.inc");
  $sql_detalle="SELECT count(*) cantidad from material_apoyo where estado=1";
  $cantidad=0;				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $cantidad=$detalle[0];   		
  }  
  return $cantidad;
}
function obtenerNombreDesLineasRegistrados($codigo){
  $cantidad=obtenerTotalLineas();
  require("conexionmysqli2.inc");
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

function obtenerNombreProductoLinea($codigo){
	$estilosVenta=1;
	require("conexionmysqli2.inc");
  $sql_detalle="SELECT descripcion_material from material_apoyo where codigo_material='$codigo'";
  $linea="";				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $linea=$detalle[0];   		
  }  
  mysqli_close($enlaceCon);
  return $linea;
}

function obtenerNombreDesProdRegistrados($codigo){
  $cantidad=obtenerTotalProd();
  require("conexionmysqli2.inc");
  $sql_detalle="SELECT cod_material from tipos_precio_productos where cod_tipoprecio='$codigo'";
  $i=0;
  $lineaArray=[];				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
  	   $lineaArray[$i]=obtenerNombreProductoLinea($detalle[0]);
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
function redondearCentavos($n) {
	return number_format($n,1,'.','');
}

function obtenerMontoVentasGeneradasLineaProducto($desde,$hasta,$almacenes,$tipoPago,$subGrupo,$formato){
	$estilosVenta=1;
	require("conexionmysqli2.inc");
      $sql="select s.cod_salida_almacenes
	from salida_almacenes s where s.`cod_tiposalida`=1001 and s.salida_anulada=0 and
	s.`cod_almacen` in ($almacenes)
	and s.`fecha` BETWEEN '$desde' and '$hasta' and 
	s.cod_tipopago in ($tipoPago)";
  $resp=mysqli_query($enlaceCon,$sql);
  $datos=[];$index=0;			
  while($detalle=mysqli_fetch_array($resp)){
  	   $datos[$index]=$detalle[0];
       $index++;
  } 
  $codigoSalida=implode(",", $datos);
  $sqlDetalle="SELECT sum(cantidad_unitaria*monto_unitario) FROM salida_detalle_almacenes where cod_salida_almacen in ($codigoSalida) and cod_material in ($subGrupo)";
  $respDetalle=mysqli_query($enlaceCon,$sqlDetalle);
  $monto=0;		
  while($detalleLinea=mysqli_fetch_array($respDetalle)){	
     $monto+=$detalleLinea[0];   		
  } 
  mysqli_close($enlaceCon);
  return $monto;
}
function obtenerMontoVentasGeneradasLineaProductoPerdido($desde,$hasta,$sucursal,$subGrupo,$formato){
	$estilosVenta=1;
	require("conexionmysqli2.inc");
	if($formato=="2"){//REPORTE DETALLADO
      $sql="select (SELECT sum(sd.monto_unitario * sd.cantidad_unitaria) FROM pedido_detalle_almacenes sd where sd.cod_salida_almacen=s.cod_salida_almacenes and sd.cod_material in ($subGrupo)) as monto
	from pedido_almacenes s where s.salida_anulada=0 and
	s.`cod_almacen` in (select a.`cod_almacen` from `almacenes` a where a.`cod_ciudad` in ($sucursal))
	and s.`fecha` BETWEEN '$desde' and '$hasta'";
	}else{
      $sql="select (SELECT sum(sd.monto_unitario * sd.cantidad_unitaria) FROM pedido_detalle_almacenes sd where sd.cod_salida_almacen=s.cod_salida_almacenes and sd.cod_material in (SELECT codigo_material from material_apoyo where cod_linea_proveedor in ($subGrupo))) as monto
	from pedido_almacenes s where s.salida_anulada=0 and
	s.`cod_almacen` in (select a.`cod_almacen` from `almacenes` a where a.`cod_ciudad` in ($sucursal))
	and s.`fecha` BETWEEN '$desde' and '$hasta'";
	}
	
  //echo $sql;	
  $resp=mysqli_query($enlaceCon,$sql);
  $monto=0;		
  while($detalle=mysqli_fetch_array($resp)){	
       $monto+=$detalle[0];   		
  }  
  mysqli_close($enlaceCon);
  return $monto;
}
function obtenerStockVentasGeneradasLineaProductoPerdido($desde,$hasta,$sucursal,$subGrupo,$formato){
	$estilosVenta=1;
	require("conexionmysqli2.inc");
	if($formato=="2"){//REPORTE DETALLADO
      $sql="select (SELECT sum(sd.stock) FROM pedido_detalle_almacenes sd where sd.cod_salida_almacen=s.cod_salida_almacenes and sd.cod_material in ($subGrupo)) as monto
	from pedido_almacenes s where s.salida_anulada=0 and
	s.`cod_almacen` in (select a.`cod_almacen` from `almacenes` a where a.`cod_ciudad` in ($sucursal))
	and s.`fecha` BETWEEN '$desde' and '$hasta'";
	}else{
      $sql="select (SELECT sum(sd.stock) FROM pedido_detalle_almacenes sd where sd.cod_salida_almacen=s.cod_salida_almacenes and sd.cod_material in (SELECT codigo_material from material_apoyo where cod_linea_proveedor in ($subGrupo))) as monto
	from pedido_almacenes s where s.salida_anulada=0 and
	s.`cod_almacen` in (select a.`cod_almacen` from `almacenes` a where a.`cod_ciudad` in ($sucursal))
	and s.`fecha` BETWEEN '$desde' and '$hasta'";
	}
	
  //echo $sql;	
  $resp=mysqli_query($enlaceCon,$sql);
  $stock=0;		
  while($detalle=mysqli_fetch_array($resp)){	
       $stock+=$detalle[0];   		
  }  
  mysqli_close($enlaceCon);
  return $stock;
}

function porcentajeAvanceInventario($codigo){
   $estilosVenta=1;
	require("conexionmysqli2.inc");
	$sqlConf="SELECT count(*) from inventarios_sucursal_detalle where cod_inventariosucursal='$codigo' and revisado=1";
    $respConf=mysqli_query($enlaceCon,$sqlConf);
    $revisados=mysqli_result($respConf,0,0);

    $sqlConf="SELECT count(*) from inventarios_sucursal_detalle where cod_inventariosucursal='$codigo'";
    $respConf=mysqli_query($enlaceCon,$sqlConf);
    $totales=mysqli_result($respConf,0,0);
    mysqli_close($enlaceCon);
    if((int)$totales>0){
       return "<b class='text-success'>(".number_format(((int)$revisados*100)/(int)$totales,0,'.','')." %)</b>";
    }else{
    	return "0 %";
    }
}

function obtenerDescripcionArchivoDeposito($codigo){
	$estilosVenta=1;
	require("conexionmysqli2.inc");
  $sql_detalle="SELECT glosa from registro_depositos where codigo='$codigo'";
  $valor="";				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $valor=$detalle[0];   		
  }  
  mysqli_close($enlaceCon);
  return $valor;
}
function obtenerUrlArchivoDeposito($codigo){
	$estilosVenta=1;
	require("conexionmysqli2.inc");
  $sql_detalle="SELECT ubicacion_archivo from registro_depositos where codigo='$codigo'";
  $valor="";				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $valor=$detalle[0];   		
  }  
  mysqli_close($enlaceCon);
  return $valor;
}

function obtenerUltimoPrecioModificado($codigo){
  $estilosVenta=1;
  require("conexionmysqli2.inc");
  $sql_detalle="SELECT valor_anterior,valor_modificado,modificacion FROM log_cambios where detalle='PRECIOS' and codigo_material='$codigo' order by fecha desc limit 1;";
  $valor_ant=0;
  $valor_nuevo=0;
  $tipo="";				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
       $valor_ant=$detalle[0];   		
       $valor_nuevo=$detalle[1];   		
       $tipo=$detalle[2];   		
  }  
  mysqli_close($enlaceCon);
  return array($valor_ant,$valor_nuevo,$tipo);
}

function verificarAlmacenDestinoVencidos($codigo){
     $codigosAdmin=obtenerValorConfiguracion(19);
     $estilosVenta=1;
     require("conexionmysqli2.inc");
     $sql="select cod_almacen from almacenes where cod_almacen in ($codigosAdmin)";
     $valor=0;$existe=0;
     $resp=mysqli_query($enlaceCon,$sql);
     while($row=mysqli_fetch_array($resp)){
        $valor=$row['cod_almacen'];
        if($valor==$codigo){
          $existe=1;
        }
     }
     return($existe);
  } 
function verificarTarjetaVenta($codigo){
     $estilosVenta=1;
     require("conexionmysqli2.inc");
     $sql="SELECT codigo from tarjetas_salidas where cod_salida_almacen='$codigo';";
     $valor=0;
     $resp=mysqli_query($enlaceCon,$sql);
     while($row=mysqli_fetch_array($resp)){
        $valor=$row['codigo'];
     }
     return($valor);
}

function descargarPDFArqueoCaja($nom,$html){
    //aumentamos la memoria  
    ini_set("memory_limit", "128M");
    // Cargamos DOMPDF
    require_once 'assets/libraries/dompdf/dompdf_config.inc.php';
    $mydompdf = new DOMPDF();
    $mydompdf->set_paper('legal', 'landscape');
    ob_clean();
    $mydompdf->load_html($html);
    $mydompdf->render();
    $canvas = $mydompdf->get_canvas();
    $canvas->page_text(450, 763, "Página:  {PAGE_NUM} de {PAGE_COUNT}", Font_Metrics::get_font("sans-serif"), 9, array(0,0,0)); 
    $mydompdf->set_base_path('assets/libraries/plantillaPDFArqueo.css');
    $mydompdf->stream($nom.".pdf", array("Attachment" => false));
  }


  function guardarPDFArqueoCaja($nom,$html,$rutaGuardado){
    //aumentamos la memoria  
    ini_set("memory_limit", "128M");
    // Cargamos DOMPDF
    require_once 'assets/libraries/dompdf/dompdf_config.inc.php';
    $mydompdf = new DOMPDF();
    $mydompdf->set_paper('legal', 'landscape');
    ob_clean();
    $mydompdf->load_html($html);
    $mydompdf->render();

    $output = $mydompdf->output();
    $directorio=explode("/Cierre",$rutaGuardado)[0];
    if(!file_exists($directorio)){
         mkdir($directorio, 0777,true) or die("No se puede crear el directorio de extracci&oacute;n");    
    }
    //echo $rutaGuardado;
    file_put_contents($rutaGuardado, $output);
  }


function obtenerCargoPersonal($codigo){
	require("conexionmysqli2.inc");
  $sql_detalle="SELECT cod_cargo from funcionarios where codigo_funcionario='$codigo'";
  $codigo=0;				
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
      $codigo=$detalle[0];		
  }  
  return $codigo;
}

function ceil_dec($number,$precision,$separator)
{
    $numberpart=explode($separator,$number); 
$numberpart[1]=substr_replace($numberpart[1],$separator,$precision,0);
    if($numberpart[0]>=0)
    {$numberpart[1]=ceil($numberpart[1]);}
    else
    {$numberpart[1]=floor($numberpart[1]);}

    $ceil_number= array($numberpart[0],$numberpart[1]);
    return implode($separator,$ceil_number);
}

function obtenerProveedorLineaInventario($codigo){
  require("conexionmysqli2.inc");
  $sql_detalle="SELECT DISTINCT p.nombre_proveedor 
	FROM inventarios_sucursal_detalle d 
	JOIN material_apoyo m on m.codigo_material=d.cod_material
	JOIN proveedores_lineas l on l.cod_linea_proveedor=m.cod_linea_proveedor
	JOIN proveedores p on p.cod_proveedor=l.cod_proveedor
	where d.cod_inventariosucursal=$codigo";
  $proveedor="";			
  $resp=mysqli_query($enlaceCon,$sql_detalle);
  while($detalle=mysqli_fetch_array($resp)){	
  	   $proveedor=$detalle[0];	
  } 
  return $proveedor; 
}

?>