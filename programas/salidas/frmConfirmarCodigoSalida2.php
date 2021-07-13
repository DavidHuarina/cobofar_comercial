<?php
$estilosVenta=1;
require("../../conexionmysqli2.inc");
require("../../funciones.php");
require("../../funcion_nombres.php");

$codigo=$_GET["codigo"];
//
//echo "ddd:$codigo<br>";
$sqlFecha="select DAY(s.fecha), MONTH(s.fecha), YEAR(s.fecha), HOUR(s.hora_salida), MINUTE(s.hora_salida),s.cod_chofer 
from salida_almacenes s where s.cod_salida_almacenes='$codigo'";
$respFecha=mysqli_query($enlaceCon,$sqlFecha);
$dia=mysqli_result($respFecha,0,0);
$mes=mysqli_result($respFecha,0,1);
$ano=mysqli_result($respFecha,0,2);
$hh=mysqli_result($respFecha,0,3);
$mm=mysqli_result($respFecha,0,4);

$chofer=mysqli_result($respFecha,0,5);
$nombreCajero=nombreFuncionarioReal($chofer);
//generamos el codigo de confirmacion
$codigoGenerado=$codigo+$dia+$mes+$ano+$hh+$mm;
//

//SACAMOS LA VARIABLE PARA ENVIAR EL CORREO O NO SI ES 2 ENVIAMOS CORREO PARA APROBACION
$banderaCorreo=obtenerValorConfiguracion(8);

if($banderaCorreo==2){
	$codigoSalida=$codigo;
	$codigoGeneradoX=$codigoGenerado;
	include("../../sendEmailAprobAnulacionSalida.php");
}
$fechaAnulacion=date("Y-m-d");
?>
<div>
<center>
  <table class="table table-sm table-condensed" cellspacing="0" >
            <tr><th colspan="2">Introduzca el codigo de confirmacion</th></tr>
            <tr><td class="bg-danger text-white">Cajero (a):</td><td><input type="text" id="cajero" value="<?=$nombreCajero?>" readonly class="form-control"></td></tr>
            <tr><td class="bg-danger text-white">Codigo:</td><td><input type="text" id="idtxtcodigo" value="<?php echo "$codigoGenerado";?>" readonly class="form-control"></td></tr>
            <tr><td class="bg-danger text-white">Clave:</td><td><input type="password" id="idtxtclave" value="" class="form-control" style="background: #A5F9EA;" autocomplete="off"></td></tr>
            <tr><td class="bg-danger text-white">Fecha:</td><td><input type="date" id="idtxtfecha" value="<?=$fechaAnulacion?>" class="form-control" readonly></td></tr>
            <tr><td class="bg-danger text-white">Caja Destino:</td><td>
              <?php
              echo "<select name='rpt_personal' id='rpt_personal' class='selectpicker' data-live-search='true' data-size='6' data-style='btn btn-rose'>"; 
$globalFuncionario=$_COOKIE["global_usuario"];
$globalCiudad=$_COOKIE["global_agencia"];
$sql="SELECT codigo_funcionario,CONCAT(nombres,' ',materno,' ',paterno)personal FROM funcionarios WHERE codigo_funcionario in (SELECT codigo_funcionario from funcionarios_agencias where cod_ciudad='$globalCiudad') and codigo_funcionario!='-1' order by nombres,materno,paterno";  
  $resp=mysqli_query($enlaceCon,$sql);
  echo "<option value='' selected>--SELECCIONE PERSONAL--</option>";
  while($dat=mysqli_fetch_array($resp))
  { $codigo_funcionario=$dat[0];
    $nombre_funcionario=$dat[1];
    $ci=$dat[2];
    if($globalFuncionario==$codigo_funcionario){
       echo "<option value='$codigo_funcionario' selected>$nombre_funcionario</option>";  
    }else{
      echo "<option value='$codigo_funcionario'>$nombre_funcionario</option>";        
    }
  }
  echo "</select><a href='#' class='btn btn-deffault btn-fab btn-sm'><i class='material-icons' onclick='actualizarDatosPersonal();return false;' title='Actualizar Listado Personal'>refresh</i></a>";
              ?>
            </td></tr>
  </table>  
  </center>  
</div>
<script type="text/javascript">$(".selectpicker").selectpicker();</script>
<?php

?>
