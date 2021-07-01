<style>
	.centrarimagen
	{
		position: absolute;
		/*top:50%;
		left:50%;*/
		width:100%;
		/*margin-left:-280px;*/
		height:100vh;
		/*margin-top:-185px;*/
		margin:0px;
	}
</style>
<?php
require "datosUsuario.php";
	echo "<div class='centrarimagen'>
	    <img src='imagenes/farmacias_bolivia1.gif' width='400px' heigth='100px' style='position:fixed;right:40px;bottom:50px;'>
		<img src='imagenes/login.jpg' width='100%' heigth='100vh'>
		<p style='position:fixed;font-size:60px;top:50px;color:white;-webkit-text-stroke: 1px #000;font-weight:bold;left:90px;'>Bienvenido a <b style='color:#000;-webkit-text-stroke: 1px #fff;'>[".$nombreAlmacenSesion."]</b></p>
	</div>";
?>