<?php
require("conexionmysqli.inc");
require("estilos.inc");

$sql_upd=mysqli_query($enlaceCon,"update material_apoyo set descripcion_material='$material', estado='$estado', cod_tipo_material='$tipo_material', peso='$peso',
						orden_grupo='$codOrdenGrupo', abreviatura='$abreviatura', item_metraje='$item_metraje', nro_metros='$nro_metros' where codigo_material='$codigo'");
echo "<script language='Javascript'>
			alert('Los datos fueron modificados correctamente.');
			location.href='navegador_material.php';
			</script>";
?>