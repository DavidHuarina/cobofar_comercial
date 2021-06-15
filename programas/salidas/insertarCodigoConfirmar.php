<?php
require "../../conexionmysqli2.inc";
if($_COOKIE["global_usuario"]==-1){
	$userCod=$_COOKIE["global_usuario"];
  $codigo = $_GET["codigo"];
  $pass = $_GET["pass"];

  $sql = "SELECT f.cod_cargo, f.cod_ciudad,u.codigo_funcionario
    FROM funcionarios f, usuarios_sistema u
    WHERE u.codigo_funcionario=f.codigo_funcionario AND u.codigo_funcionario='$userCod' AND u.contrasena='$pass' ";
$resp = mysqli_query($enlaceCon,$sql);
$num_filas = mysqli_num_rows($resp);
if ($num_filas != 0) {
   $nroDigitos = strlen("".$codigo);
  $nroDigitos--;//total digitos
  //
  $cadAux = strrev($codigo);
  $ultimoCar="".$cadAux[0];//ultimo digito
  //
  $cadAux = "".$codigo;
  $primerCar="".$cadAux[0];//primer digito
  $acumulador=0;
  $cadAux="".$codigo;//echo "_$cadAux<br>";
  for($i=0;$i<=$nroDigitos;$i++)
   {$acumulador+=$cadAux[$i];//echo "_$cadAux[$i]-----$i";
   }
  $acumulador=$acumulador+100;//suma de digitos mas 100
  //
  //clave generada
  $claveGenerada="".$nroDigitos.$ultimoCar.$primerCar.$acumulador;
  echo $claveGenerada;	 
 }else{
 	echo "000000000";
 }
  
}
?>
