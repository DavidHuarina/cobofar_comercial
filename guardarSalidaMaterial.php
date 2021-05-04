<?php
error_reporting(0);
require("conexionmysqli.inc");
require("estilos_almacenes.inc");
require("funciones.php");
require("funciones_inventarios.php");


$usuarioVendedor=$_COOKIE['global_usuario'];
$globalSucursal=$_COOKIE['global_agencia'];


$tipoSalida=$_POST['tipoSalida'];
$tipoDoc=$_POST['tipoDoc'];
if(!isset($_POST['no_venta'])){
   $almacenDestino=2;
   $almacenOrigen=$global_almacen;
}else{
   $almacenDestino=$_POST['almacen'];
   $almacenOrigen=$global_almacen;
}

$cod_tipopreciogeneral=0;
if(isset($_POST['codigoDescuentoGeneral'])){
   $cod_tipopreciogeneral=$_POST['codigoDescuentoGeneral'];
}
$cod_tipoVenta2=1;
if(isset($_POST['tipo_venta2'])){
   $cod_tipoVenta2=$_POST['tipo_venta2'];
}

$codCliente=$_POST['cliente'];

$tipoPrecio=$_POST['tipoPrecio'];
$razonSocial=$_POST['razonSocial'];
$nitCliente=$_POST['nitCliente'];
$tipoVenta=$_POST['tipoVenta'];

$observaciones=$_POST["observaciones"];


$totalVenta=$_POST["totalVenta"];
$descuentoVenta=$_POST["descuentoVenta"];
$totalFinal=$_POST["totalFinal"];

$totalEfectivo=$_POST["efectivoRecibido"];
$totalCambio=$_POST["cambioEfectivo"];

$totalFinalRedondeado=round($totalFinal);

//VALIDAMOS QUE NO SEA CERO EL VALOR DEL REDONDEADO PARA EL CODIGO DE ControlCode
if($totalFinalRedondeado==0){
	$totalFinalRedondeado=1;
}

$fecha=$_POST["fecha"];
$cantidad_material=$_POST["cantidad_material"];

if($descuentoVenta=="" || $descuentoVenta==0){
	$descuentoVenta=0;
}

$vehiculo="";

$fecha=formateaFechaVista($fecha);
//$fecha=date("Y-m-d");
$hora=date("H:i:s");

//SACAMOS LA CONFIGURACION PARA EL DOCUMENTO POR DEFECTO
$sqlConf="select valor_configuracion from configuraciones where id_configuracion=1";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$tipoDocDefault=mysqli_result($respConf,0,0);

//SACAMOS LA CONFIGURACION PARA EL CLIENTE POR DEFECTO
$sqlConf="select valor_configuracion from configuraciones where id_configuracion=2";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$clienteDefault=mysqli_result($respConf,0,0);

//SACAMOS LA CONFIGURACION PARA CONOCER SI LA FACTURACION ESTA ACTIVADA
$sqlConf="select valor_configuracion from configuraciones where id_configuracion=3";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$facturacionActivada=mysqli_result($respConf,0,0);

//SACAMOS LA CONFIGURACION PARA LA SALIDA POR VENCIMIENTO
$sqlConf="select valor_configuracion from configuraciones where id_configuracion=5";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$tipoSalidaVencimiento=mysqli_result($respConf,0,0);

//HABILITAMOS LA BANDERA DE VENCIDOS PARA SACAR SOLO VENCIDOS
$banderaVencidos=0;
if($tipoSalida==$tipoSalidaVencimiento){
	$banderaVencidos=1;
}


$sql="SELECT IFNULL(max(cod_salida_almacenes)+1,1) FROM salida_almacenes";
$resp=mysqli_query($enlaceCon,$sql);
$codigo=mysqli_result($resp,0,0);

$vectorNroCorrelativo=numeroCorrelativo($tipoDoc);
if(!isset($_POST["nro_correlativo"])){
  $nro_correlativo=$vectorNroCorrelativo[0];
}else{
  $nro_correlativo=$_POST["nro_correlativo"];
}
$cod_dosificacion=$vectorNroCorrelativo[2];

if($facturacionActivada==1 && $tipoDoc==1){
		//SACAMOS DATOS DE LA DOSIFICACION PARA INSERTAR EN LAS FACTURAS EMITIDAS
	$sqlDatosDosif="select d.nro_autorizacion, d.llave_dosificacion 
		from dosificaciones d where d.cod_dosificacion='$cod_dosificacion'";
	$respDatosDosif=mysqli_query($enlaceCon,$sqlDatosDosif);
	$nroAutorizacion=mysqli_result($respDatosDosif,0,0);
	$llaveDosificacion=mysqli_result($respDatosDosif,0,1);
	include 'controlcode/sin/ControlCode.php';
	$controlCode = new ControlCode();
	$code = $controlCode->generate($nroAutorizacion,//Numero de autorizacion
								   $nro_correlativo,//Numero de factura
								   $nitCliente,//Número de Identificación Tributaria o Carnet de Identidad
								   str_replace('-','',$fecha),//fecha de transaccion de la forma AAAAMMDD
								   $totalFinalRedondeado,//Monto de la transacción
								   $llaveDosificacion//Llave de dosificación
								   );
	//FIN DATOS FACTURA
}

$created_by=$usuarioVendedor;
$created_at=date("Y-m-d H:i:s");
$sql_inserta="INSERT INTO `salida_almacenes`(`cod_salida_almacenes`, `cod_almacen`,`cod_tiposalida`, 
		`cod_tipo_doc`, `fecha`, `hora_salida`, `territorio_destino`, 
		`almacen_destino`, `observaciones`, `estado_salida`, `nro_correlativo`, `salida_anulada`, 
		`cod_cliente`, `monto_total`, `descuento`, `monto_final`, razon_social, nit, cod_chofer, cod_vehiculo, monto_cancelado, cod_dosificacion, monto_efectivo, monto_cambio,cod_tipopago,created_by,created_at,cod_tipopreciogeneral,cod_tipoventa2)
		values ('$codigo', '$almacenOrigen', '$tipoSalida', '$tipoDoc', '$fecha', '$hora', '0', '$almacenDestino', 
		'$observaciones', '1', '$nro_correlativo', 0, '$codCliente', '$totalVenta', '$descuentoVenta', '$totalFinal', '$razonSocial', 
		'$nitCliente', '$usuarioVendedor', '$vehiculo',0,'$cod_dosificacion','$totalEfectivo','$totalCambio','$tipoVenta','$created_by','$created_at','$cod_tipopreciogeneral','$cod_tipoVenta2')";
		//echo $sql_inserta;
$sql_inserta=mysqli_query($enlaceCon,$sql_inserta);

if($sql_inserta==1){
	
	if($facturacionActivada==1){
		//insertamos la factura
		$sqlInsertFactura="insert into facturas_venta (cod_dosificacion, cod_sucursal, nro_factura, cod_estado, razon_social, nit, fecha, importe, 
		codigo_control, cod_venta) values ('$cod_dosificacion','$globalSucursal','$nro_correlativo','1','$razonSocial','$nitCliente','$fecha','$totalFinal',
		'$code','$codigo')";
		$respInsertFactura=mysqli_query($enlaceCon,$sqlInsertFactura);	
	}

	$montoTotalVentaDetalle=0;
	for($i=1;$i<=$cantidad_material;$i++)
	{   	
		$codMaterial=$_POST["materiales$i"];

		if(!isset($_POST["stock$i"])){
          $stock=1;
		}else{
		  $stock=$_POST["stock$i"];	
		}		
		//echo "MATERIAL: ".$codMaterial.", STOCK: ".$stock;
		if($codMaterial!=0&&$stock>0){
			$vencidosAlmacen=verificarAlmacenDestinoVencidos($almacenDestino);
			//echo $vencidosAlmacen;

			$cantidadUnitaria=$_POST["cantidad_unitaria$i"];
			$precioUnitario=$_POST["precio_unitario$i"];
			$descuentoProducto=$_POST["descuentoProducto$i"];
			$montoMaterial=$_POST["montoMaterial$i"];
			
			$montoTotalVentaDetalle=$montoTotalVentaDetalle+$montoMaterial;			
			$respuesta=descontar_inventarios($codigo, $almacenOrigen,$codMaterial,$cantidadUnitaria,$precioUnitario,$descuentoProducto,$montoMaterial,$banderaVencidos,$i,$vencidosAlmacen);
			
			if($respuesta!=1){
				echo "<script>
					alert('Existio un error en el detalle. Contacte con el administrador del sistema.');
				</script>";
			}
		}			
	}
	
	$montoTotalConDescuento=$montoTotalVentaDetalle-$descuentoVenta;
	//ACTUALIZAMOS EL PRECIO CON EL DETALLE
	$sqlUpdMonto="update salida_almacenes set monto_total='$montoTotalVentaDetalle', monto_final='$montoTotalConDescuento' 
				where cod_salida_almacenes='$codigo'";
	$respUpdMonto=mysqli_query($enlaceCon,$sqlUpdMonto);
	if($facturacionActivada==1){
		$sqlUpdMonto="update facturas_venta set importe='$montoTotalConDescuento' 
					where cod_venta='$codigo'";
		$respUpdMonto=mysqli_query($enlaceCon,$sqlUpdMonto);
	}
	
	
	if($tipoDoc==1){
		echo "<script type='text/javascript' language='javascript'>	
		location.href='formatoFactura.php?codVenta=$codigo';
		</script>";	
		//window.open('formatoFactura.php?codVenta=$codigo','','scrollbars=yes,width=1000,height=800');	
	}else if($tipoDoc==2){
		//SACAMOS LA VARIABLE PARA ENVIAR EL CORREO O NO SI ES 1 ENVIAMOS CORREO DESPUES DE LA TRANSACCION
		$banderaCorreo=obtenerValorConfiguracion(10);
		if($banderaCorreo==1 || $banderaCorreo==2){
			header("location:sendEmailVenta.php?codigo=$codigo&evento=1&tipodoc=$tipoDoc");
		}else{
			echo "<script type='text/javascript' language='javascript'>
			location.href='formatoNotaRemisionOficial.php?codVenta=$codigo';
			</script>";		
		}
	}else{
          echo "<script type='text/javascript' language='javascript'>
			location.href='navegador_salidamateriales.php';
			</script>";
	}
	
}else{
		echo "<script type='text/javascript' language='javascript'>
		alert('Ocurrio un error en la transaccion. Contacte con el administrador del sistema.');
		location.href='navegador_salidamateriales.php';
		</script>";
}

?>



