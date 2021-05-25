<?php
require("conexionmysqli2.inc");
$order_by=$_GET["order_by"];
$cod_medico=$_GET["cod_medico"];
$sql="SELECT codigo,CONCAT(apellidos,' ',nombres) nombres,matricula from medicos where estado=1 order by $order_by";
$resp=mysqli_query($enlaceCon,$sql);
$filaSeleccionado="";
$filas="";
while($dat=mysqli_fetch_array($resp)){
	$codigo = $dat["codigo"];
   	$nombres = $dat["nombres"];
    $matricula = $dat["matricula"];
    if($codigo==$cod_medico){
    	$filaSeleccionado.='<tr class="bg-warning"><td><b>'.$nombres.'</b></td><td>'.$matricula.'</td><td><a href="#" onclick="asignarMedicoVenta(\'0\')" title="Quitar" class="btn btn-success btn-fab btn-sm"><i class="material-icons">verified</i></a></td></tr>';
    }else{
    	$filas.='<tr><td>'.$nombres.'</td><td>'.$matricula.'</td><td><a href="#" onclick="asignarMedicoVenta(\''.$codigo.'\')" title="Seleccionar" class="btn btn-danger btn-fab btn-sm"><i class="material-icons">check_circle</i></a></td></tr>';
    }
}

echo $filaSeleccionado.$filas;