<?php
$estilosVenta=1;
$codMaterial = $_GET["codigo"];
require("conexionmysqli2.inc");
$consulta="SELECT count(*) as existe from material_apoyo where codigo_material='$codMaterial' and cod_tipoventa=1";
$rs=mysqli_query($enlaceCon,$consulta);
$registro=mysqli_fetch_array($rs);
echo "#####".$registro;
