<?php
require("conexionmysqli2.inc");
$order_by=$_GET["order_by"];
$cod_medico=$_GET["cod_medico"];


$sql="(
SELECT codigo,CONCAT(nombres,' ',apellidos) nombres,matricula from medicos where codigo='$cod_medico'
) UNION (";
$sql.="SELECT codigo,CONCAT(nombres,' ',apellidos) nombres,matricula from medicos where estado=1 ";

if(isset($_GET["nom_medico"])){
   $sql.=" and nombres like '%".$_GET["nom_medico"]."%' ";
}
if(isset($_GET["app_medico"])){
   $sql.=" and apellidos like '%".$_GET["app_medico"]."%' ";
}
/*if($cod_medico>0){
   $sql.=" or codigo='$cod_medico'";
}*/
$sql.=" order by $order_by desc limit 7) ";
//echo $sql;
$resp=mysqli_query($enlaceCon,$sql);
$filaSeleccionado="";
$filas="";

while($dat=mysqli_fetch_array($resp)){
	$codigo = $dat["codigo"];
   	$nombres = $dat["nombres"];
    $matricula = $dat["matricula"];
    if($codigo==$cod_medico){
    	$filaSeleccionado.='<tr class="bg-warning"><td align="left"><b>'.$nombres.'</b></td><td>'.$matricula.'</td><td><a href="#" onclick="asignarMedicoVenta(\'0\')" title="Quitar" class="btn btn-success btn-fab btn-sm"><i class="material-icons">verified</i></a></td></tr>';
    }else{
    	$filas.='<tr><td align="left">'.$nombres.'</td><td>'.$matricula.'</td><td><a href="#" onclick="asignarMedicoVenta(\''.$codigo.'\')" title="Seleccionar" class="btn btn-danger btn-fab btn-sm"><i class="material-icons">check_circle</i></a></td></tr>';
    }
}

echo $filaSeleccionado.$filas;