<?php
require('estilos_reportes_almacencentral.php');
require('conexionmysqli.inc');
require('funcionRecalculoCostosCobofar.php');


echo "ahi vamos; ";

recalculaCostos(50023,1056,$enlaceCon);

echo "fin por fin;";
?>