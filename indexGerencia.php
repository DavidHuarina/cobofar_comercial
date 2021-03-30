<?php $indexGerencia=1; //para no cargar en la pagina principal ?>
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
     <link rel="stylesheet" href="dist/demo.css" />	
</head>
<body>
<?php
include("datosUsuario.php");
?>
<div id="page">
	<div class="" style='position: absolute;top:0px;left:0;width: 100%;background: #30CA99;z-index:999999;'>
		<img style="position:absolute;z-index:99999;" src="imagenes/farmacias_bolivia1.gif" height="40px"></img>
		<div style="position:relative; width:95%; height:50px; text-align:right; top:0px; font-size: 14px; font-weight: bold; color: #fff;z-index:99999;">
			[<?php echo $nombreUsuarioSesion?>][<?php echo $nombreAlmacenSesion;?>]&nbsp;&nbsp;&nbsp;[<?php echo $fechaSistemaSesion?>][<?php echo $horaSistemaSesion;?>]
			<button onclick="location.href='salir.php'" style="position:relative;right:-30 !important;z-index:99999;background:#EF6A09 !important;" class="btn btn-success btn-fab btn-sm"><i class="fa fa-close"></i></button>			
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
					<li><a href="programas/proveedores/inicioProveedores.php" target="contenedorPrincipal">Distribuidores</a></li>
					<li><a href="grupos/list.php" target="contenedorPrincipal">Clasificadores</a></li>
					<li><a href="navegador_material.php" target="contenedorPrincipal">Productos</a></li>
					
					<li><span>Descuentos</span>
					<ul>
						<li><a href="tipos_precio/list.php" target="contenedorPrincipal">Gestión de Descuentos</a></li>
					   <?php if($global_usuario==2019){
                         ?>
                        <li><a href="tipos_precio/listAdmin.php" target="contenedorPrincipal">Autorización de Descuentos</a></li>
                       <?php
					      }?>	
					    <li><a href="tipos_preciogeneral/list.php" target="contenedorPrincipal">Gestión Desc. Precio Final</a></li>
					    <?php if($global_usuario==2019){
                         ?>
                        <li><a href="tipos_preciogeneral/listAdmin.php" target="contenedorPrincipal">Autorización de Desc. Precio Final</a></li>
                       <?php
					      }?>	
						</ul>	
					</li>				
						<li><a href="conf_precio/list.php" target="contenedorPrincipal">Gestión de Precios</a></li>
					<!--li><a href="navegador_funcionarios1.php" target="contenedorPrincipal">Funcionarios</a></li-->					
					<li><a href="programas/clientes/inicioClientes.php" target="contenedorPrincipal">Clientes</a></li>
					<!--li><a href="navegador_vehiculos.php" target="contenedorPrincipal">Vehiculos</a></li-->
					<li><span>Gestion de Almacenes</span>
					<ul>
						<li><a href="navegador_almacenes.php" target="contenedorPrincipal">Almacenes</a></li>
						<li><a href="navegador_sucursales.php" target="contenedorPrincipal">Sucursales</a></li>
						<li><a href="navegador_tiposingreso.php" target="contenedorPrincipal">Tipos de Ingreso</a></li>
						<li><a href="navegador_tipossalida.php" target="contenedorPrincipal">Tipos de Salida</a></li>
						</ul>	
					</li>

					<li><span>Adicionales Producto</span>
					<ul>
						<li><a href="navegador_empaques.php" target="contenedorPrincipal">Empaques</a></li>
						<li><a href="navegador_formasfar.php" target="contenedorPrincipal">Formas Farmaceuticas</a></li>
						<li><a href="navegador_accionester.php" target="contenedorPrincipal">Acciones Terapeuticas</a></li>
						<li><a href="navegador_principiosact.php" target="contenedorPrincipal">Principios Activos</a></li>
						<!--li><a href="navegador_precios.php?orden=1" target="contenedorPrincipal">Precios (Orden Alfabetico)</a></li>
						<li><a href="navegador_precios.php?orden=2" target="contenedorPrincipal">Precios (Por Linea Proveedor)</a></li>		
						<li><a href="navegadorUbicaciones.php" target="contenedorPrincipal">Ubicaciones</a></li-->						
					</ul>
				</li>
					<li><a href="navegador_dosificaciones.php" target="contenedorPrincipal">Dosificaciones de Facturas</a></li>
					
				</ul>	
			</li>
			<!--li><span>Ordenes de Compra</span>
				<ul>
					<li><a href="navegador_ordenCompra.php" target="contenedorPrincipal">Registro de O.C.</a></li>
					<li><a href="registrarOCTerceros.php" target="contenedorPrincipal">Registro de O.C. de Terceros</a></li-->
					<!--li><a href="navegadorIngresosOC.php" target="contenedorPrincipal">Generar OC a traves de Ingreso</a></li>
					<li><a href="navegador_pagos.php" target="contenedorPrincipal">Registro de Pagos</a></li>
				</ul>	
			</li-->
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
			<!--li><span>Marcados de Personal</span>
				<ul>
					<li><a href="registrar_marcado.php" target="contenedorPrincipal">Registro de Marcados</a></li>
					<li><a href="rptOpMarcados.php" target="contenedorPrincipal">Reporte de Marcados</a></li>
				</ul>	
			</li-->
			<!--li><span>Listado de Cobranzas</span>
				<ul>
					<li><a href="navegadorCobranzas.php" target="contenedorPrincipal">Listado de Cobranzas</a></li>
				</ul>	
			</li-->
			<!--li><span>Configuracion</span>
				<ul>
					<li><a href="navegadorDolar.php" target="contenedorPrincipal">Cambiar Cotizacion de Dolar</a></li>
				</ul>	
			</li-->
			<li><a href="registrar_ingresomateriales.php" target="contenedorPrincipal">Registrar Ingreso **</a></li>
			<li><a href="registrar_salidaventas.php" target="_blank">Vender / Facturar **</a></li>			
			<li><a href="listadoProductosStock.php" target="_blank">Listado de Productos **</a></li>

			<li><span>Reportes</span>
				<ul>
					<li><span>Movimiento de Almacen</span>
						<ul>
							<li><a href="rpt_op_inv_kardex.php" target="contenedorPrincipal">Kardex de Movimiento</a></li>
							<li><a href="rpt_op_inv_existencias.php" target="contenedorPrincipal">Existencias</a></li>
							<li><a href="rpt_op_inv_ingresos.php" target="contenedorPrincipal">Ingresos</a></li>
							<li><a href="rpt_op_inv_salidas.php" target="contenedorPrincipal">Salidas</a></li>
							<li><a href="rptPrecios.php" target="contenedorPrincipal">Precios</a></li>
							<li><a href="rptOpProductosVencer.php" target="contenedorPrincipal">Productos proximos a Vencer</a></li>
							<li><a href="rptIngresoFueraPeriodo.php?variableAdmin=1" target="contenedorPrincipal" >Verificación Tiempos Traspasos</a></li>
							<!--li><a href="rptOCPagar.php" target="contenedorPrincipal">OC por Pagar</a></li-->
						</ul>
					</li>	
					<!--li><span>Costos</span>
						<ul>
							<li><a href="rptOpKardexCostos.php" target="contenedorPrincipal">Kardex de Movimiento Precio Promedio</a></li>
							<li><a href="rptOpKardexCostosPEPS.php" target="contenedorPrincipal">Kardex de Movimiento PEPS</a></li>
							<li><a href="rptOpKardexCostosUEPS.php" target="contenedorPrincipal">Kardex de Movimiento UEPS</a></li>							
							<li><a href="rptOpExistenciasCostos.php" target="contenedorPrincipal">Existencias</a></li>							
						</ul>
					</li-->
					<li><span>Ventas</span>
						<ul>
							<li><a href="rptOpVentasSucursal.php" target="contenedorPrincipal">Ventas x Sucursal</a></li>
							<li><a href="rptOpVentasCategoria.php" target="contenedorPrincipal">Ventas x Clasificador</a></li>
							<li><a href="rptOpVentasLineasProveedor.php" target="contenedorPrincipal">Ventas x Linea y Proveedor</a></li>
							<li><a href="rptOpVentasDocumento.php" target="contenedorPrincipal">Ventas x Documento</a></li>
							<li><a href="rptOpVentasxItem.php" target="contenedorPrincipal">Ventas x Item</a></li>
							<li><a href="rptOpVentasGeneral.php" target="contenedorPrincipal">Ventas x Documento e Item</a></li>
							<li><a href="rptOpVentasxPersona.php" target="contenedorPrincipal">Ventas x Vendedor</a></li>
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
							<li><a href="" target="contenedorPrincipal">Libro de Compras</a></li>
							<!--li><a href="rptOpKardexCliente.php" target="contenedorPrincipal">Kardex x Cliente</a></li-->
						</ul>	
					</li>
					<li><a href="rptOpArqueoDiario.php?variableAdmin=1" target="contenedorPrincipal" >Arqueo de Caja</a></li>
					<li><a href="control_inventario/list.php" target="contenedorPrincipal">Control de Inventario</a></li>	
					<li><span>Reportes Logs</span>
						<ul>
							<li><a href="reportes_logs/rptOpLogPrecios.php" target="contenedorPrincipal">Log de Precios</a></li>
							<li><a href="reportes_logs/rptOpLogDescuentos.php" target="contenedorPrincipal">Log de Descuentos</a></li>
							<li><a href="reportes_logs/rptOpLogDescuentosFinal.php" target="contenedorPrincipal">Log de Desc. Precio Final</a></li>
						</ul>	
					</li>				
					<!--li><span>Utilidades</span>
						<ul>
							<li><a href="rptOpUtilidadesDocumento.php" target="contenedorPrincipal">Utilidades x Documento</a></li>
							<li><a href="rptOpUtilidadesxItem.php" target="contenedorPrincipal">Utilidades x Item</a></li>
						</ul>	
					</li>
					<li><span>Cobranzas</span>
						<ul>
							<li><a href="rptOpCobranzas.php" target="contenedorPrincipal">Cobranzas</a></li>
							<li><a href="rptOpCuentasCobrar.php" target="contenedorPrincipal">Cuentas por Cobrar</a></li>
						</ul>	
					</li-->
				</ul>
			</li>
		</ul>
	 </div>				
	</nav>
</div>
<script src="dist/mmenu.polyfills.js"></script>
<script src="dist/mmenu.js"></script>
<script src="dist/demo.js"></script>
	</body>
</html>