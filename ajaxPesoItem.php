
<?php
require("funciones.php");

$codMaterial = $_GET["codmat"];
//
require("conexionmysqli.inc");
$cadRespuesta="";
$consulta="
    select peso from material_apoyo where codigo_material='$codMaterial'";
$rs=mysqli_query($enlaceCon,$consulta);
$registro=mysqli_fetch_array($rs);
$cadRespuesta=$registro[0];
if($cadRespuesta=="")
{   $cadRespuesta=0;
}

$cadRespuesta=redondear2($cadRespuesta);
echo "<input type='hidden' id='pesoItem$indice' name='pesoItem$indice' value='$cadRespuesta'>";
echo "<input type='text' id='pesoItemTotal$indice' name='pesoItem$indice' value='$cadRespuesta' size='4'>";
//echo "$cadRespuesta -> ".rand(0, 10);
//

?>