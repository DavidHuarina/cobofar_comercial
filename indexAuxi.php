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
			<li><span>Reportes</span>
				<ul>
					<li><span>Ventas</span>
						<ul>
							<li><a href="rptOpVentasSucursal.php" target="contenedorPrincipal">Ventas x Sucursal</a></li>							
						</ul>	
					</li>				
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