<?php
error_reporting(0);
require("conexionmysqli.inc");
require("estilos_almacenes.inc");
require("funcionRecalculoCostos.php");
require("funciones.php");

//HABILITAMOS LA BANDERA DE VENCIDOS PARA ACTUALIZAR EL PRECIO
$banderaPrecioUpd=0;
$sqlConf="select valor_configuracion from configuraciones where id_configuracion=7";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$banderaPrecioUpd=mysqli_result($respConf,0,0);


$sql = "select IFNULL(MAX(cod_ingreso_almacen)+1,1) from ingreso_almacenes order by cod_ingreso_almacen desc";
$resp = mysqli_query($enlaceCon,$sql);
$codigo=mysqli_result($resp,0,0);

$sql = "select IFNULL(MAX(nro_correlativo)+1,1) from ingreso_almacenes where cod_almacen='$global_almacen' order by cod_ingreso_almacen desc";
$resp = mysqli_query($enlaceCon,$sql);
$nro_correlativo=mysqli_result($resp,0,0);

$hora_sistema = date("H:i:s");

$codSalidaAlmacen=0;
if(isset($_POST["cod_salida"])){
  $codSalidaAlmacen=$_POST["cod_salida"];
}

$tipo_ingreso=$_POST['tipo_ingreso'];
$nota_entrega=0;
$nro_factura=$_POST['nro_factura'];
$observaciones=$_POST['observaciones'];
$proveedor=$_POST['proveedor'];
$cod_ingreso_almacen=$_POST['cod_ingreso_almacen'];

$createdBy=$_COOKIE['global_usuario'];
$createdDate=date("Y-m-d H:i:s");

$fecha_real=date("Y-m-d");


$consulta="INSERT INTO ingreso_almacenes (cod_ingreso_almacen,cod_almacen,cod_tipoingreso,fecha,hora_ingreso,observaciones,cod_salida_almacen,cod_salida_almacen_central,
nota_entrega,nro_correlativo,ingreso_anulado,cod_tipo_compra,cod_orden_compra,nro_factura_proveedor,factura_proveedor,estado_liquidacion,
cod_proveedor,created_by,modified_by,created_date,modified_date) 
values($codigo,$global_almacen,$tipo_ingreso,'$fecha_real','$hora_sistema','$observaciones',0,'$codSalidaAlmacen','$nota_entrega','$nro_correlativo',0,0,0,$nro_factura,0,0,'$proveedor','$createdBy','0','$createdDate','')";

$sql_inserta = mysqli_query($enlaceCon,$consulta);
//echo "aaaa:$consulta";
$cod_ciudad=obtenerCodigoCiudadPorAlmacen($global_almacen);
if($sql_inserta==1){
	$sqlUpdateEstado="update ingreso_pendientes_almacenes set estado_ingreso=1 where cod_ingreso_almacen=$cod_ingreso_almacen";
	$respEstado=mysqli_query($enlaceCon,$sqlUpdateEstado);
	for ($i = 1; $i <= $cantidad_material; $i++) {
		$cod_material = $_POST["material$i"];
		
		if($cod_material!=0){
			$cantidad=$_POST["cantidad_unitaria$i"];
			$precioBruto=$_POST["precio$i"];
			$lote=$_POST["lote$i"];
			if(!isset($_POST["ubicacion_estante$i"])){
              $ubicacionEstante=0;
			}else{
              $ubicacionEstante=$_POST["ubicacion_estante$i"];
			}
			if(!isset($_POST["ubicacion_fila$i"])){
              $ubicacionFila=0;
			}else{
              $ubicacionFila=$_POST["ubicacion_fila$i"];
			}
			
			if($lote==""){
				$lote=0;
			}
			$fechaVencimiento=$_POST["fechaVenc$i"];

			$fechaVencimiento=UltimoDiaMes($fechaVencimiento);

			$precioUnitario=$precioBruto;//$precioBruto/$cantidad;
			

			$costo=$precioUnitario;
						
			if(obtenerValorConfiguracion(12)==1){//VERIFICAR SI ESTA ACTIVA LA FUNCION DE ACTUALIZAR PRECIOS
				$user=0;//USUARIO PARA EL LOG
                if(isset($_COOKIE['global_usuario'])){
                  $user=$_COOKIE['global_usuario'];             
                }
               actualizarPrecioSiEsMayor($cod_material,$precioUnitario,$user);
			}
			$consulta="insert into ingreso_detalle_almacenes(cod_ingreso_almacen, cod_material, cantidad_unitaria, cantidad_restante, lote, fecha_vencimiento, 
			precio_bruto, costo_almacen, costo_actualizado, costo_actualizado_final, costo_promedio, precio_neto, cod_ubicacionestante, cod_ubicacionfila) 
			values($codigo,'$cod_material',$cantidad,$cantidad,'$lote','$fechaVencimiento',$precioUnitario,$precioUnitario,$costo,$costo,$costo,$costo,$ubicacionEstante,$ubicacionFila)";
			//echo "bbb:$consulta";
			$sql_inserta2 = mysqli_query($enlaceCon,$consulta);
			
			
			
			/*$sqlMargen="select p.margen_precio from material_apoyo m, proveedores_lineas p
				where m.cod_linea_proveedor=p.cod_linea_proveedor and m.codigo_material='$cod_material'";
			$respMargen=mysqli_query($enlaceCon,$sqlMargen);
			$numFilasMargen=mysqli_num_rows($respMargen);
			$porcentajeMargen=0;
			if($numFilasMargen>0){
				$porcentajeMargen=mysqli_result($respMargen,0,0);			
			}		
			$precioItem=$costo+($costo*($porcentajeMargen/100));
			*/

			
			$aa=recalculaCostos($cod_material, $global_almacen);
			
		}
		

	}
	
	echo "<script language='Javascript'>
		alert('Los datos fueron insertados correctamente.');
		location.href='navegador_ingresomateriales.php';
		</script>";		
}else{
	echo "<script language='Javascript'>
		alert('EXISTIO UN ERROR EN LA TRANSACCION, POR FAVOR CONTACTE CON EL ADMINISTRADOR.');
		location.href='navegador_ingresomateriales.php';
		</script>";	
}

?>