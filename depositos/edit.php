<?php

require("../conexionmysqli.inc");
require("../estilos2.inc");
require("configModule.php");

$sql=mysqli_query($enlaceCon,"select glosa,fecha,monto_registrado,cod_banco,nro_cuenta from $table where codigo=$codigo_registro");
$dat=mysqli_fetch_array($sql);

$nombre=$dat[0];
$fecha=$dat["fecha"];
$monto_recibido=$dat[2];
$cod_banco=$dat[3];
$cuenta=$dat[4];
echo "<form action='$urlSaveEdit' method='post' enctype='multipart/form-data'>";

echo "<h1>Editar Depósito</h1>";

echo "<center><input name='codigo' value='$codigo_registro' type='hidden'>
<table class='table table-sm' width='60%'>";
echo "<tr><td align='left' class='bg-info text-white'>Descripción</td>";
echo "<td align='left' colspan='3'>
	<input type='text' class='form-control' name='nombre' size='40' onKeyUp='javascript:this.value=this.value.toUpperCase();' value='$nombre' required>
</td></tr>";
echo "<tr><td align='left' class='bg-info text-white'>A Fecha</td>";
echo "<td align='left'>
	<INPUT  type='date' class='form-control' value='$fecha' id='fecha_fin' size='10' name='fecha_fin'>
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
		if($codigo_cat==$cod_banco){  //BANCO MERCANTIL POR DEFECTO SELECCIONADO
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
	<input type='text' class='form-control' name='numero_cuenta' value='$cuenta' size='40'>
</td></tr>";
echo "<tr><td align='left' class='bg-info text-white'>Monto Depositado</td>";
echo "<td align='left' colspan='3'>
	<input type='number' class='form-control' name='monto' value='$monto_recibido' step='any'>
</td></tr>";
echo "<tr><td align='left' class='bg-info text-white'>Adjuntar Archivo</td>";
echo "<td align='left' colspan='3'>
	<small id='label_txt_documentos_cabecera'></small> 
                      <span class='input-archivo'>
                        <input type='file' class='archivo' name='documentos_cabecera' id='documentos_cabecera'/>
                      </span>
                      <label title='Ningún archivo' for='documentos_cabecera' id='label_documentos_cabecera' class='label-archivo btn btn-info btn-sm'><i class='material-icons'>publish</i> Subir Archivo
                      </label>
                      <a href='$urlListArchivos?c=$codigo_registro&b=0' target='_blank' class='btn btn-sm btn-info btn-fab' style='background:#BD9A22;'><i class='material-icons'>folder_open</i>&nbsp;</a>
</td></tr>";
echo "</table></center>";

echo "<div class='divBotones'>
<input type='submit' class='btn btn-primary' value='Guardar'>
<input type='button' class='btn btn-danger' value='Cancelar' onClick='location.href=\"$urlList2\"'>
</div>";

echo "</form>";
?>