<?php
require("funciones.php");

$codMaterial = $_GET["codmat"];
$codAlmacen = $_GET["codalm"];
$indice = $_GET["indice"];

//
$estilosVenta=1;
require("conexionmysqli2.inc");

$stockProducto=stockProducto($codAlmacen, $codMaterial);

echo "<input type='text' id='stock$indice' name='stock$indice' value='$stockProducto' readonly size='4' style='font-size:15px;background: #F9917C;'>";
//echo "$cadRespuesta -> ".rand(0, 10);
//

?>
