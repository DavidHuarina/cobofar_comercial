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
			[<?php echo $nombreUsuarioSesion?>][<?php echo $nombreAlmacenSesion;?>]&nbsp;&nbsp;&nbsp;[<?php echo $fechaSistemaSesion?>][<?php echo $horaSistemaSesion;?>]
			<a title="Cambiar Tipo de Agencia" style="color:#5A8A85; " href='cambiarAlmacenTipoSesion.php' target="contenedorPrincipal">[ <?=$nombreTipoAlmacen;?> ]</a>
			<button onclick="location.href='salir.php'" style="position:relative;right:-30 !important;z-index:99999;background:#EF6A09 !important;" class="btn btn-success btn-fab btn-sm"><i class="fa fa-close"></i></button>			
		</div>
	</div>
	
	<div class="content">
		<iframe src="inicio_almacenes.php" name="contenedorPrincipal" id="mainFrame" style="top:50px;" border="1"></iframe>
	</div>
	<nav id="menu">
		<div id="panel-menu">
		 <ul>
			<li><span>Reportes</span>
				<ul>
					<li><span>Movimiento de Almacen</span>
						<ul>
							<li><a href="rpt_op_inv_kardex.php" target="contenedorPrincipal">Kardex de Movimiento</a></li>
							<li><a href="rpt_op_inv_existencias.php" target="contenedorPrincipal">Existencias</a></li>
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
							<li><a href="rptOpVentasHora.php" target="contenedorPrincipal">Ventas x Hora</a></li>
							<!--<li><a href="rptOpVentasCategoria.php" target="contenedorPrincipal">Ventas x Clasificador</a></li>-->
							<!--<li><a href="rptOpVentasLineasProveedor.php" target="contenedorPrincipal">Ventas x Linea y Proveedor</a></li>-->
							<li><a href="rptOpVentasDocumento.php" target="contenedorPrincipal">Ventas x Documento</a></li>
							<li><a href="rptOpVentasxItem.php" target="contenedorPrincipal">Ventas x Item</a></li>
							<li><a href="rptOpVentasGeneral.php" target="contenedorPrincipal">Ventas x Documento e Item</a></li>
							<li><a href="rptOpVentasxPersona.php" target="contenedorPrincipal">Ventas x Vendedor</a></li>
							<!--li><a href="rptOpKardexCliente.php" target="contenedorPrincipal">Kardex x Cliente</a></li-->
						</ul>	
					</li>
					<li><a href="rptOpArqueo_sucursales.php?variableAdmin=1" target="contenedorPrincipal" >Arqueo de Caja</a></li>	
					<!--<li><span>Ventas Perdidas</span>
						<ul>
							<li><a href="rptOpVentasSucursalPerdido.php" target="contenedorPrincipal">Ventas x Sucursal</a></li>
							<li><a href="rptOpVentasLineasProveedorPerdido.php" target="contenedorPrincipal">Ventas x Linea y Proveedor</a></li>
							<li><a href="rptOpVentasxItemPerdido.php" target="contenedorPrincipal">Ventas x Item</a></li>	
						</ul>	
					</li>-->
					<!--<li><span>Reportes Contables</span>
						<ul>
							<li><a href="rptOpLibroVentas.php" target="contenedorPrincipal">Libro de Ventas</a></li>
							<li><a href="" target="contenedorPrincipal">Libro de Compras</a></li>-->
							<!--li><a href="rptOpKardexCliente.php" target="contenedorPrincipal">Kardex x Cliente</a></li-->
						<!--</ul>	
					</li>-->
					<!--<li><a href="rptOpArqueoDiario.php?variableAdmin=1" target="contenedorPrincipal" >Arqueo de Caja</a></li>
					<li><a href="control_inventario/list.php" target="contenedorPrincipal">Control de Inventario</a></li>	
					<li><span>Reportes Logs</span>
						<ul>
							<li><a href="reportes_logs/rptOpLogPrecios.php" target="contenedorPrincipal">Log de Precios</a></li>-->
							<!--<li><a href="reportes_logs/rptOpLogDescuentos.php" target="contenedorPrincipal">Log de Descuentos</a></li>
							<li><a href="reportes_logs/rptOpLogDescuentosFinal.php" target="contenedorPrincipal">Log de Desc. Precio Final</a></li>-->
						<!--</ul>	
					</li>-->				

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