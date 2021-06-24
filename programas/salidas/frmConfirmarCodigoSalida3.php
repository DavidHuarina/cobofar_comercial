<?php
$estilosVenta=1;
require("../../conexionmysqli2.inc");
require("../../funciones.php");

$codigo=$_GET["codigo"];
//
//echo "ddd:$codigo<br>";
$sqlFecha="select DAY(s.fecha), MONTH(s.fecha), YEAR(s.fecha), HOUR(s.hora_salida), MINUTE(s.hora_salida) 
from salida_almacenes s where s.cod_salida_almacenes='$codigo'";
$respFecha=mysqli_query($enlaceCon,$sqlFecha);
$dia=mysqli_result($respFecha,0,0);
$mes=mysqli_result($respFecha,0,1);
$ano=mysqli_result($respFecha,0,2);
$hh=mysqli_result($respFecha,0,3);
$mm=mysqli_result($respFecha,0,4);

//generamos el codigo de confirmacion
$codigoGenerado=$codigo+$dia+$mes+$ano+$hh+$mm.$codigo.$dia.$anio;
//

//SACAMOS LA VARIABLE PARA ENVIAR EL CORREO O NO SI ES 2 ENVIAMOS CORREO PARA APROBACION
$banderaCorreo=obtenerValorConfiguracion(8);

if($banderaCorreo==2){
	$codigoSalida=$codigo;
	$codigoGeneradoX=$codigoGenerado;
	include("../../sendEmailAprobAnulacionSalida.php");
}
$fechaAnulacion=date("Y-m-d");

$user=$_COOKIE["global_usuario"];        
$cargoUser=obtenerCargoPersonal($user);
$cantidadAnulacion=0;
if($cargoUser==31){
  $fechaActual=date("Y-m-d");  
  $cantidadAnulacion=0;
}
if($cantidadAnulacion>0){
?>
<div>
<center>
  <table class="table table-sm table-condensed" cellspacing="0" >
            <tr><th colspan="2">Introduzca el codigo de confirmacion</th></tr>
            <tr><td class="bg-danger text-white">Codigo:</td><td><input type="text" id="idtxtcodigo" value="<?php echo "$codigoGenerado";?>" readonly class="form-control"></td></tr>
            <tr><td class="bg-danger text-white">Repita el Codigo:</td><td><input type="text" id="idtxtclave" value="" class="form-control" style="background: #A5F9EA;" autocomplete="off"></td></tr>
            <tr><td class="bg-danger text-white">Fecha:</td><td><input type="date" id="idtxtfecha" value="<?=$fechaAnulacion?>" class="form-control" readonly></td></tr>
            <tr><td class="bg-danger text-white">Anulaciones Restantes:</td><td><input type="number" id="idtxtcantidad" value="<?=$cantidadAnulacion?>" class="form-control" readonly></td></tr>
  </table>  
  </center>  
</div>
<?php  
}else{
 ?>
<div>
<center>
  <b class="text-danger">EXEDIO EL LIMITE DE ANULACIONES DIARIAS!</b>
  <hr> 
  </center>  
</div>
<?php 
}

?>
