<?php
require("../conexionmysqli.inc");
require("../estilos2.inc");
require("configModule.php");
?>
<script>
	function cambiarSubLinea(){
  var categoria=$("#rpt_banco").val();
  var parametros={"categoria":categoria};
     $.ajax({
        type: "GET",
        dataType: 'html',
        url: "../ajaxCambiarComboLinea.php",
        data: parametros,   
        success:  function (resp) { 
        	//alert(resp);
          $("#rpt_subcategoria").html(resp);
          $(".selectpicker").selectpicker("refresh");
        }
    });
 }
 function monstrarLoad(){
    $("#boton_envio").attr("disabled",true);
    $("#boton_envio").val("Enviando...",true);
 }
</script>
<?php
$fecha_rptinidefault=date("Y")."-".date("m")."-01";
$hora_rptinidefault=date("H:i");
$fecha_rptdefault=date("Y-m-d");
echo "<form action='$urlSave' method='post' onsubmit='monstrarLoad()' enctype='multipart/form-data'>";

echo "<h1>$moduleNameSingular</h1>";

echo "<center><table class='table table-sm' width='60%'>";

echo "<tr><td align='left' class='bg-info text-white'>Descripción</td>";
echo "<td align='left' colspan='3'>
	<input type='text' class='form-control' name='nombre' size='40' onKeyUp='javascript:this.value=this.value.toUpperCase();' required>
</td></tr>";
echo "<tr><td align='left' class='bg-info text-white'>A Fecha</td>";
echo "<td align='left'>
	<INPUT  type='date' class='form-control' value='$fecha_rptdefault' id='fecha_fin' size='10' name='fecha_fin'>
</td>";
echo "</tr>";
echo "<tr><td align='left' class='bg-info text-white'>Banco</td>";
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
echo "</tr>";

echo "<tr><td align='left' class='bg-info text-white'>Número Cuenta</td>";
echo "<td align='left' colspan='3'>
	<input type='text' class='form-control' name='numero_cuenta' size='40'>
</td></tr>";
echo "<tr><td align='left' class='bg-info text-white'>Monto Depositado</td>";
echo "<td align='left' colspan='3'>
	<input type='number' class='form-control' name='monto' step='any'>
</td></tr>";
echo "<tr><td align='left' class='bg-info text-white'>Adjuntar Archivo</td>";
echo "<td align='left' colspan='3'>
	<small id='label_txt_documentos_cabecera'></small> 
                      <span class='input-archivo'>
                        <input type='file' class='archivo' name='documentos_cabecera' id='documentos_cabecera'/>
                      </span>
                      <label title='Ningún archivo' for='documentos_cabecera' id='label_documentos_cabecera' class='label-archivo btn btn-info btn-sm'><i class='material-icons'>publish</i> Subir Archivo
                      </label>
</td></tr>";
echo "</table></center>";

echo "<div class=''>
<input type='submit' class='btn btn-primary' value='Guardar' id='boton_envio'>
<input type='button' class='btn btn-danger' value='Cancelar' onClick='location.href=\"$urlList2\"'>
";

echo "</form>";
?>