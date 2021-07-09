
<?php

$codigo = $_GET["codigo"];
$clave = $_GET["clave"];

//comparacion final
if($codigo==$clave)
   {
    echo "OK";
   }
else
   {//echo "ERROR_"."_$clave"."_$claveGenerada"."_";
    echo "ERROR";
   }

?>
