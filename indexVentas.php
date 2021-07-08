<?php $indexGerencia=1; //para no cargar en la pagina principal
if(!isset($_COOKIE["global_usuario"])){
   ?><script type="text/javascript">window.location.href='index.html';</script><?php
}

 ?>
<html>
<head>
	<meta charset="utf-8" />
	<title>Farmacias Bolivia</title>
    <link rel="shortcut icon" href="imagenes/icon_farma.ico" type="image/x-icon">
	<link type="text/css" rel="stylesheet" href="menuLibs/css/demo.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
	<style>  .boton-rojo
{
    text-decoration: none !important;
    padding: 10px !important;
    font-weight: 600 !important;
    font-size: 12px !important;
    color: #ffffff !important;
    background-color: #E73024 !important;
    border-radius: 3px !important;
    border: 2px solid #E73024 !important;
}
.boton-rojo:hover{
    color: #000000 !important;
    background-color: #ffffff !important;
  }
</style>
     <link rel="stylesheet" href="dist/css/demo.css" />     
     <link rel="stylesheet" href="dist/mmenu.css" />
     <?php 
   if($_COOKIE["global_tipo_almacen"]==1){
     ?><link rel="stylesheet" href="dist/demo.css" /><?php
   }else{
   	?><link rel="stylesheet" href="dist/demo2.css" /><?php
   }
     ?>
</head>
<body>
<?php
include("datosUsuario.php");
?>
<div id="page">
	<div class="" style='position: absolute;top:0px;left:0;width: 100%;background: #30CA99;z-index:999999;'>
		<img style="position:absolute;z-index:99999;" src="imagenes/farmacias_bolivia1.gif" height="40px"></img>
		<div style="position:relative; width:95%; height:50px; text-align:right; top:0px; font-size: 14px; font-weight: bold; color: #fff;z-index:99999;">			

			<!--<img src="imagenes/personal.png" class="rounded" width="35" height="35">--><?php echo " ".$nombreUsuarioSesion?> [<?php echo $nombreAlmacenSesion;?>]&nbsp;&nbsp;&nbsp;[<?php echo $fechaSistemaSesion?>  <?php echo $horaSistemaSesion;?>]
			<a title="Cambiar Tipo de Agencia" style="color:#5A8A85; " href='cambiarAlmacenTipoSesion.php' target="contenedorPrincipal">[ <?=$nombreTipoAlmacen;?> ]</a>
			<a  style="position:relative;right:-30 !important;z-index:99999;" class="dropdown-toggle simple-text logo-mini" data-toggle="dropdown"><img src="<?=$imagenLogin?>" width="40" height="40" class="rounded-circle"/></a>
				<ul class="dropdown-menu" style="width:200px;margin-top: 15px;">
					<li><a href="editImagen.php" target="contenedorPrincipal">Cambiar Foto de Perfil</a></li>
    				<li><a href="editPerfil.php" target="contenedorPrincipal">Cambiar Contraseña</a></li>
    				<!--<li><a href="cambiarAlmacenTipoSesion.php">Ir a Suministros</a></li>-->
    				<li><hr class="dropdown-divider"></li>
    				<li><a href="salir.php"><i class="material-icons" style="font-size: 16px">logout</i> Salir</a></li>
  				</ul>	          
		</div>
	</div>
	
	<div class="content">
		<iframe src="inicio_almacenes.php" name="contenedorPrincipal" id="mainFrame" style="top:50px;" border="1"></iframe>
	</div>
	<nav id="menu">
		<div id="panel-menu">
		 <ul>
			<li><span>Datos Generales</span>
				<ul>
					<?php 
                    if($_COOKIE["admin_central"]==1){
                      ?><li><a href="asignarSucursalPersonal.php" target="contenedorPrincipal">Asignar Personal Sucursal</a></li><?php
                    }
					?>					
					<li><a href="programas/clientes/inicioClientes.php" target="contenedorPrincipal">Clientes</a></li>			
					<!--<li><a href="navegador_dosificaciones.php" target="contenedorPrincipal">Dosificaciones de Facturas</a></li>-->
					<li><a href="productos_estrella/list.php" target="contenedorPrincipal"><i class='material-icons'>star</i> Productos Estrella</a></li>
					<li><a href="productos_clavo/list.php" target="contenedorPrincipal"><i class='material-icons'>push_pin</i> Productos Sin Rotación</a></li>
					
				</ul>	
			</li>
			<li><span>Ingresos</span>
				<ul>
					<li><a href="navegador_ingresomateriales.php" target="contenedorPrincipal">Ingreso de Productos</a></li>
					<li><a href="navegador_ingresotransito.php" target="contenedorPrincipal">Ingreso de Productos en Transito</a></li>
					<li><a href="navegador_ingresotransitoalmacen.php" target="contenedorPrincipal">Ingresos por Traspaso Central</a></li>
					<!--li><a href="navegadorLiquidacionIngresos.php" target="contenedorPrincipal">Liquidacion de Ingresos</a></li-->
				</ul>	
			</li>
			<li><span>Salidas</span>
				<ul>
					<li><a href="navegador_salidamateriales.php" target="contenedorPrincipal">Listado de Traspasos</a></li>
					<li><a href="navegadorVentas.php" target="contenedorPrincipal">Listado de Ventas</a></li>					
					<li><a href="navegadorPedidos.php" target="contenedorPrincipal">Ventas Perdidas</a></li>	
					<li><a href="registrar_salidaventas_manual.php" target="_blank">Registrar Factura Manual</a></li>				
				</ul>	
			</li>
			<li><span>Marcados de Personal</span>
				<ul>
					<li><a href="registrar_marcado.php" target="contenedorPrincipal">Registro de Marcados</a></li>
					<li><a href="rptOpMarcados.php" target="contenedorPrincipal">Reporte de Marcados</a></li>
				</ul>	
			</li>
			<li><a href="registrar_salidaventas.php" target="_blank"><i class="material-icons">shopping_cart</i> Vender / Facturar</a></li>			
			<!--<li><a href="listadoProductosStock.php" target="_blank">Listado de Productos **</a></li>-->

			<li><span>Reportes</span>
				<ul>	
                    <li><span>Movimiento de Sucursal</span>
						<ul>
							<li><a href="rpt_op_inv_kardex.php" target="contenedorPrincipal">Kardex de Movimiento</a></li>
							<li><a href="rpt_op_inv_existencias.php" target="contenedorPrincipal">Existencias</a></li>
							<li><a href="rpt_op_saldos_sucursales.php" target="contenedorPrincipal">Saldos x Sucursal</a></li>
							<!--<li><a href="rpt_op_inv_existencias_saldos.php" target="contenedorPrincipal">Existencias vs Saldos</a></li>
							<li><a href="rpt_op_inv_ingresos.php" target="contenedorPrincipal">Ingresos</a></li>
							<li><a href="rpt_op_inv_salidas.php" target="contenedorPrincipal">Salidas</a></li>
							<li><a href="rptPrecios.php" target="contenedorPrincipal">Precios</a></li>
							<li><a href="rptOpProductosVencer.php" target="contenedorPrincipal">Productos proximos a Vencer</a></li>
							<li><a href="rptIngresoFueraPeriodo.php?variableAdmin=1" target="contenedorPrincipal" >Verificación Tiempos Traspasos</a></li>
							<li><a href="rptSaldoProductosLineas.php?variableAdmin=1" target="contenedorPrincipal" >Existencias Productos - Sucursales</a></li>-->
						</ul>
					</li>
					<li><span>Ventas</span>
						<ul>
							<li><a href="rptOpVentasSucursal.php" target="contenedorPrincipal">Ventas x Sucursal</a></li>
							<li><a href="rptOpVentasHora.php" target="contenedorPrincipal">Ventas x Hora</a></li><!--
							<li><a href="rptOpVentasCategoria.php" target="contenedorPrincipal">Ventas x Clasificador</a></li>
							<li><a href="rptOpVentasLineasProveedor.php" target="contenedorPrincipal">Ventas x Linea y Proveedor</a></li>-->
							<li><a href="rptOpVentasDocumento.php" target="contenedorPrincipal">Ventas x Documento</a></li>
							<li><a href="rptOpVentasxItem.php" target="contenedorPrincipal">Ventas x Item</a></li>
							<li><a href="rptOpVentasGeneral.php" target="contenedorPrincipal">Ventas x Documento e Item</a></li>
							<li><a href="rptOpVentasxPersona.php" target="contenedorPrincipal">Ventas x Dispensador</a></li>
							<!--li><a href="rptOpKardexCliente.php" target="contenedorPrincipal">Kardex x Cliente</a></li-->
						</ul>	
					</li>
					<li><span>Ventas Perdidas</span>
						<ul>
							<li><a href="rptOpVentasSucursalPerdido.php" target="contenedorPrincipal">Ventas x Sucursal</a></li>
							<li><a href="rptOpVentasLineasProveedorPerdido.php" target="contenedorPrincipal">Ventas x Linea y Proveedor</a></li>
							<li><a href="rptOpVentasxItemPerdido.php" target="contenedorPrincipal">Ventas x Item</a></li>							
						</ul>	
					</li>
					<li><span>Reportes Contables</span>
						<ul>
							<li><a href="rptOpLibroVentas.php" target="contenedorPrincipal">Libro de Ventas</a></li>
						</ul>	
					</li>
					<li><a href="rptOpArqueoDiario.php?variableAdmin=1" target="contenedorPrincipal" >Cierre de Caja</a></li>	
					
				</ul>
			</li>
			<li><a href="depositos/list.php" target="contenedorPrincipal">Registrar Depósitos</a></li>
			<li><a href="control_inventario/list.php" target="contenedorPrincipal">Control de Inventario</a></li>	
		</ul>
	 </div>				
	</nav>
</div>
<script src="dist/mmenu.polyfills.js"></script>
<script src="dist/mmenu.js"></script>
<script src="dist/demo.js"></script>
	</body>
</html>