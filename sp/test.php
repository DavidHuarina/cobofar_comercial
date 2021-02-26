<?php
require("../function_web.php");
$listProv=obtenerListadoProveedoresWeb();
header('Content-type: application/json');   
print_r($listProv);