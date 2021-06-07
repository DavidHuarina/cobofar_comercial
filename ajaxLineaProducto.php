<?php
$estilosVenta=1;
require("conexionmysqli2.inc");
$codigo=$_GET["codigo"];
$sql="select l.nombre_linea_proveedor from material_apoyo m 
join proveedores_lineas l on m.cod_linea_proveedor=l.cod_linea_proveedor
where m.codigo_material='$codigo';";
$resp=mysqli_query($enlaceCon,$sql);
while($dat=mysqli_fetch_array($resp))
{ 
   echo $dat[0];
}
