<?php
echo "TEST ";
require("../function_web.php");
$listProv=obtenerListadoAlmacenes();
header('Content-type: application/json');   
print_r($listProv);