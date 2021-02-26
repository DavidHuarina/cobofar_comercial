<html>
<head>
	<meta charset="utf-8" />
	<title>Farmacias Bolivia</title>
    <link rel="icon" type="image/png" href="imagenes/icon_farma.png" />
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
  }</style>
     <link rel="stylesheet" href="dist/css/demo.css" />
     <link rel="stylesheet" href="dist/mmenu.css" />
     <link rel="stylesheet" href="dist/demo.css" />	
</head>
<body>
<?php
include("datosUsuario.php");
?>
<div id="page">
	<div class="header">
		<a href="#menu"><span></span></a>
		<img src="imagenes/farmacias_bolivia1.gif" height="40px"></img><!--TuFarma - <?=$nombreEmpresa;?>-->
		<div style="position:absolute; width:95%; height:50px; text-align:right; top:0px; font-size: 9px; font-weight: bold; color: #fff;">
			[<?php echo $fechaSistemaSesion?>][<?php echo $horaSistemaSesion;?>]
			<button onclick="location.href='salir.php'" style="position:relative;z-index:99999;right:0px;" class="boton boton-rojo"><i class="fa fa-close"></i></button>			
		</div>
		<div style="position:absolute; width:95%; height:50px; text-align:left; top:0px; font-size: 9px; font-weight: bold; color: #fff;">
			[<?php echo $nombreUsuarioSesion?>][<?php echo $nombreAlmacenSesion;?>]
		</div>
	</div>
	
	
	<div class="content">
		<iframe src="inicio_almacenes.php" name="contenedorPrincipal" id="mainFrame" border="1"></iframe>
	</div>
	<nav id="menu">
		<div id="panel-menu">
		 <ul>
			<li><span>Datos Generales</span>
				<ul>
					<li><a href="programas/proveedores/inicioProveedores.php" target="contenedorPrincipal">Distribuidores</a></li>
					<li><a href="navegador_material.php" target="contenedorPrincipal">Productos</a></li>
					<li><a href="navegador_funcionarios1.php" target="contenedorPrincipal">Funcionarios</a></li>
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

					<li><span>Materiales y Precios</span>
					<ul>
						<li><a href="navegador_empaques.php" target="contenedorPrincipal">Empaques</a></li>
						<li><a href="navegador_formasfar.php" target="contenedorPrincipal">Formas Farmaceuticas</a></li>
						<li><a href="navegador_accionester.php" target="contenedorPrincipal">Acciones Terapeuticas</a></li>
						<li><a href="navegador_precios.php?orden=1" target="contenedorPrincipal">Precios (Orden Alfabetico)</a></li>
						<li><a href="navegador_precios.php?orden=2" target="contenedorPrincipal">Precios (Por Linea Proveedor)</a></li>		
						<li><a href="navegadorUbicaciones.php" target="contenedorPrincipal">Ubicaciones</a></li>						
					</ul>
				</li>
					<li><a href="navegador_dosificaciones.php" target="contenedorPrincipal">Dosificaciones de Facturas</a></li>
					
				</ul>	
			</li>
			<li><span>Ordenes de Compra</span>
				<ul>
					<li><a href="navegador_ordenCompra.php" target="contenedorPrincipal">Registro de O.C.</a></li>
					<!--li><a href="registrarOCTerceros.php" target="contenedorPrincipal">Registro de O.C. de Terceros</a></li-->
					<!--li><a href="navegadorIngresosOC.php" target="contenedorPrincipal">Generar OC a traves de Ingreso</a></li-->
					<li><a href="navegador_pagos.php" target="contenedorPrincipal">Registro de Pagos</a></li>
				</ul>	
			</li>
			<li><span>Ingresos</span>
				<ul>
					<li><a href="navegador_ingresomateriales.php" target="contenedorPrincipal">Ingreso de Materiales</a></li>
					<!--li><a href="navegadorLiquidacionIngresos.php" target="contenedorPrincipal">Liquidacion de Ingresos</a></li-->
				</ul>	
			</li>
			<li><span>Salidas</span>
				<ul>
					<li><a href="navegador_salidamateriales.php" target="contenedorPrincipal">Listado de Traspasos</a></li>
					<li><a href="navegadorVentas.php" target="contenedorPrincipal">Listado de Ventas</a></li>
				</ul>	
			</li>
			<li><span>Marcados de Personal</span>
				<ul>
					<li><a href="registrar_marcado.php" target="contenedorPrincipal">Registro de Marcados</a></li>
					<li><a href="rptOpMarcados.php" target="contenedorPrincipal">Reporte de Marcados</a></li>
				</ul>	
			</li>
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
							<li><a href="rptProductosVencer.php" target="contenedorPrincipal">Productos proximos a Vencer</a></li>
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
							<li><a href="rptOpVentasDocumento.php" target="contenedorPrincipal">Ventas x Documento</a></li>
							<li><a href="rptOpVentasxItem.php" target="contenedorPrincipal">Ventas x Item</a></li>
							<li><a href="rptOpVentasGeneral.php" target="contenedorPrincipal">Ventas x Documento e Item</a></li>
							<li><a href="rptOpVentasxPersona.php" target="contenedorPrincipal">Ventas x Vendedor</a></li>
							<!--li><a href="rptOpKardexCliente.php" target="contenedorPrincipal">Kardex x Cliente</a></li-->
						</ul>	
					</li>
					<li><span>Reportes Contables</span>
						<ul>
							<li><a href="rptOpLibroVentas.php" target="contenedorPrincipal">Libro de Ventas</a></li>
							<li><a href="" target="contenedorPrincipal">Libro de Compras</a></li>
							<!--li><a href="rptOpKardexCliente.php" target="contenedorPrincipal">Kardex x Cliente</a></li-->
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