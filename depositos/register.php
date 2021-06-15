<meta charset="utf-8">
<?php
require("../conexionmysqli.inc");
require("../estilos2.inc");
require("configModule.php");
require('../funcion_nombres.php');
require("../funciones.php");
if(obtenerCargoPersonal($_COOKIE["global_usuario"])==31){

?>

<script>
	function cambiarSubLinea(){
  var categoria=$("#rpt_banco").val();
  //var cuenta=$("#rpt_cuenta").val();
  var parametros={"categoria":categoria};
     $.ajax({
        type: "GET",
        dataType: 'html',
        url: "../ajaxCambiarComboLinea.php",
        data: parametros,   
        success:  function (resp) { 
        	
          $("#rpt_subcategoria").html(resp);
          $(".selectpicker").selectpicker("refresh");
        }
    });
 }
 function monstrarLoad(){
    $("#boton_envio").attr("disabled",true);
    $("#boton_envio").val("Enviando...",true);
 }
 function calcularMontoDepositado(){
    var fechai=$("#fecha_ini").val();
    var fecha=$("#fecha_fin").val();
    var horai=$("#exahorainicial").val();
    var hora=$("#exahorafinal").val();
    var personal=$("#rpt_personal").val();
    var parametros={"fecha":fecha,"fechai":fechai,"hora":hora,"horai":horai,"personal":personal};
     $.ajax({
        type: "GET",
        dataType: 'html',
        url: "ajaxCalcularMontoArqueo.php",
        data: parametros,   
        success:  function (resp) { 
          var r=resp.split("#####");
          //alert(resp);
          $("#monto_calc").val(r[0]); 
          $("#monto_calc2").val(r[1]);
          $("#monto").val(r[0]); 
          $("#monto2").val(r[1]);          
        }
    });
 }
 function cambiarDescripcion(){
  var texto = $("#rpt_personal").find('option:selected').text();
  $("#nombre").val("Cierre. "+texto); 
 }
</script>
<meta charset="utf-8">
<?php
$globalCiudad=$_COOKIE["global_agencia"];
$globalFuncionario=$_COOKIE["global_usuario"];
$fecha_rptinidefault=date("Y")."-".date("m")."-01";
//$hora_rptinidefault=date("H:i");
$hora_rptinidefault="06:00";
$hora_rptfindefault="23:00";
$fecha_rptdefault=date("Y-m-d");
$nombreFuncionario=nombreVisitador($_COOKIE["global_usuario"]);
$datosNombreDefault="Cierre.".$nombreFuncionario;
echo "<form action='$urlSave' method='post' onsubmit='monstrarLoad()' enctype='multipart/form-data'>";

echo "<h1>$moduleNameSingular</h1>";
?>
<!--<center>
<div class="alert alert-warning col-sm-8" role="alert">
  <h4 class="alert-heading">Estimado Usuario</h4>
  <p>Modificamos el proceso de Registro de Depósitos, ya no es necesario generar el PDF del cierre y subir el archivo, ahora este se guarda automaticamente.</p>
  <hr>
  <p class="mb-0">Departamento de Sistemas - COBOFAR</p>
</div>
</center>-->
<?php
echo "<center><table class='table table-sm table-condensed' width='60%'>";

echo "<tr><td align='left' class='bg-info text-white'>Descripción</td>";
echo "<td align='left' colspan='3'>
	<input type='text' class='form-control' name='nombre' id='nombre' onKeyUp='javascript:this.value=this.value.toUpperCase();' value='$datosNombreDefault' required>
</td></tr>";

if(obtenerCargoPersonal($_COOKIE["global_usuario"])==31){
   echo "<tr><th align='left' class='bg-info text-white'>Personal</th><td><select name='rpt_personal' id='rpt_personal' class='selectpicker' data-live-search='true' data-style='btn btn-info' onchange='cambiarDescripcion()'>";
  $sql="SELECT codigo_funcionario,CONCAT(paterno,' ',materno,' ',nombres)personal FROM funcionarios WHERE cod_ciudad='$globalCiudad' order by paterno,materno,nombres";
  $resp=mysqli_query($enlaceCon,$sql);
  while($dat=mysqli_fetch_array($resp))
  { $codigo_funcionario=$dat[0];
    $nombre_funcionario=$dat[1];
    if($globalFuncionario==$codigo_funcionario){
       echo "<option value='$codigo_funcionario' selected>$nombre_funcionario</option>";  
    }else{
      echo "<option value='$codigo_funcionario'>$nombre_funcionario</option>";        
    }
  }
  echo "</select></td></tr>";
}


echo "<tr><td align='left' class='bg-info text-white'>Fecha</td>";
echo "<td align='left'>
	<INPUT  type='date' class='form-control col-sm-10' value='$fecha_rptdefault' id='fecha_ini' size='10' name='fecha_ini'><INPUT  type='time' class='form-control col-sm-10' value='$hora_rptinidefault' id='exahorainicial' size='10' name='exahorainicial'>
</td>";
echo "<td align='left' colspan='2'>
  <INPUT  type='date' class='form-control col-sm-10' value='$fecha_rptdefault' id='fecha_fin' size='10' name='fecha_fin'><INPUT  type='time' class='form-control col-sm-10' value='$hora_rptfindefault' id='exahorafinal' size='10' name='exahorafinal'>
</td>";
echo "</tr>";
/*echo "<tr><td align='left' class='bg-info text-white'>Banco</td>";
echo "<td align='left'>
	<select name='rpt_banco'  id='rpt_banco' class='selectpicker form-control' data-style='btn btn-primary' data-live-search='true'>";
	$sql="select codigo, nombre from bancos where estado=1 order by 2";
	$resp=mysqli_query($enlaceCon,$sql);
	while($dat=mysqli_fetch_array($resp))
	{	$codigo_cat=$dat[0];
		$nombre_cat=$dat[1];
		if($codigo_cat==1){  //BANCO MERCANTIL POR DEFECTO SELECCIONADO
           echo "<option value='$codigo_cat' selected>$nombre_cat</option>";
		}else{
           echo "<option value='$codigo_cat'>$nombre_cat</option>";
		}		
	}
	echo "</select>
</td>";
echo "</tr>";*/
echo "<tr><td align='left'class='text-white' width='15%' style='background:#888888'>Cuenta</td>";
echo "<td align='left' width='30%'>
<input type='hidden' value='1' name='rpt_banco'  id='rpt_banco'>
  <select name='rpt_cuenta'  id='rpt_cuenta' class='selectpicker form-control' data-style='btn btn-primary' data-live-search='true'>";
  $sql="select codigo, descripcion,moneda from cuentas_bancarias where estado=1 order by 2";
  $resp=mysqli_query($enlaceCon,$sql);
  while($dat=mysqli_fetch_array($resp))
  { $codigo_cat=$dat[0];
    $nombre_cat=$dat[1]." (".$dat[1].")";
    if($codigo_cat==1){  //BANCO MERCANTIL POR DEFECTO SELECCIONADO
           echo "<option value='$codigo_cat' selected>$nombre_cat</option>";
    }else{
           echo "<option value='$codigo_cat'>$nombre_cat</option>";
    }   
  }
  echo "</select><input type='hidden' class='form-control' name='numero_cuenta' size='40'>
</td><td align='left' width='15%' class='bg-success text-white'>Cuenta (USD)</td>";
echo "<td align='left' width='20%'>
  <select name='rpt_cuenta2'  id='rpt_cuenta2' class='selectpicker form-control' data-style='btn btn-success' data-live-search='true'>";
  $sql="select codigo, descripcion,moneda from cuentas_bancarias where estado=1 order by 2";
  $resp=mysqli_query($enlaceCon,$sql);
  while($dat=mysqli_fetch_array($resp))
  { $codigo_cat=$dat[0];
    $nombre_cat=$dat[1]." (".$dat[1].")";
    if($codigo_cat==1){  //BANCO MERCANTIL POR DEFECTO SELECCIONADO
           echo "<option value='$codigo_cat' selected>$nombre_cat</option>";
    }else{
           echo "<option value='$codigo_cat'>$nombre_cat</option>";
    }   
  }
  echo "</select>
</td>";
echo "</tr>";

echo "<tr><td align='left' class=' text-white' style='background:#888888'>Monto a Depositar</td>";
echo "<td align='left'>
  <input type='number' readonly class='form-control col-sm-10' name='monto_calc' id='monto_calc' step='any' required>
 <a href='#' title='CALCULAR MONTO A DEPOSITAR' onclick='calcularMontoDepositado(); return false;' class='btn btn-fab btn-sm btn-default col-sm-1 float-right' style='margin-top:-25px'><i class='material-icons'>refresh</i></a>
</td><td align='left' class='bg-success text-white'>Monto a Depositar (USD)</td>";
echo "<td align='left'>
  <input type='number' readonly class='form-control' name='monto_calc2' id='monto_calc2' step='any' required>
</td></tr>";
echo "<tr><td align='left' class=' text-white' style='background:#888888'>Monto Depositado</td>";
echo "<td align='left'>
	<input type='number' class='form-control' name='monto' id='monto' step='any' required>
</td><td align='left' class='bg-success text-white'>Monto Depositado (USD)</td>";
echo "<td align='left'>
  <input type='number' class='form-control' name='monto2' id='monto2' step='any' required>
</td></tr>";
echo "<tr><td align='left' class='bg-info text-white'>Adjuntar Archivo</td>";
echo "<td align='left' colspan='3'>
	<small id='label_txt_documentos_cabecera'></small> 
                      <span class='input-archivo'>
                        <input type='file' class='archivo' name='documentos_cabecera' id='documentos_cabecera'/>
                      </span>
                      <label title='Ningún archivo' for='documentos_cabecera' id='label_documentos_cabecera' class='label-archivo btn btn-info btn-sm'><i class='material-icons'>publish</i> Subir Archivo
                      </label>
                      <p style='color:#737272; float:right;'>Por defecto se adjuntará el Cierre</p>
</td></tr>";
echo "</table></center>";

echo "<div class=''>
<input type='submit' class='btn btn-primary' value='Guardar' id='boton_envio'>
<input type='button' class='btn btn-danger' value='Cancelar' onClick='location.href=\"$urlList2\"'>
";

echo "</form>";
}
?>