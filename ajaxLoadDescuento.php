
<?php
$estilosVenta=1;
require("funciones.php");

$codMaterial = $_GET["codmat"];
$indice = $_GET["indice"];
$codTipoPrecio=$_GET["tipoPrecio"];
$globalAgencia=$_COOKIE["global_agencia"];

//
require("conexionmysqli.inc");
$cadRespuesta="";
$consulta="
    select p.`precio` from precios p where p.`codigo_material`='$codMaterial' and p.cod_precio=1 and cod_ciudad=$globalAgencia and cod_ciudad>0";
    //echo $consulta;
$rs=mysqli_query($enlaceCon,$consulta);
$registro=mysqli_fetch_array($rs);
$cadRespuesta=$registro[0];
if($cadRespuesta=="")
{   $cadRespuesta=0;
}


//no aplicar el descuento si no hay el tipo precio
$fecha=0;
if(isset($_GET["fecha"])){
	$fecha=explode("/",$_GET["fecha"]);
	$fechaCompleta=$fecha[2]."-".$fecha[1]."-".$fecha[0];	        	
}
$ciudad=$_COOKIE['global_agencia'];
$sql1="select t.codigo, t.nombre, t.abreviatura from tipos_precio t where '$fechaCompleta 00:00:00' between t.desde and t.hasta and DAYOFWEEK('$fechaCompleta') in (SELECT cod_dia from tipos_precio_dias where cod_tipoprecio=t.codigo) and estado=1 and cod_estadodescuento=3 and $ciudad in (SELECT cod_ciudad from tipos_precio_ciudad where cod_tipoprecio=t.codigo) and ($codMaterial in (SELECT codigo_material from material_apoyo where cod_linea_proveedor in (SELECT cod_linea_proveedor from tipos_precio_lineas where cod_tipoprecio=t.codigo)) or $codMaterial in (SELECT cod_material from tipos_precio_productos where cod_tipoprecio=t.codigo)) order by 1";
$resp1=mysqli_query($enlaceCon,$sql1);
$contadorAux=0;
while($dat=mysqli_fetch_array($resp1)){
	//$codTipoPrecio=$dat[0];
	$contadorAux++;
}
if($contadorAux>0){
	//$codTipoPrecio=$codTipoPrecioAux;
}else{
	$codTipoPrecio=-9999;
}
// FIN DE APLICACION DE PRECIOS
echo "#####_#####";
            $fecha=0;
	        if(isset($_GET["fecha"])){
	        	$fecha=explode("/",$_GET["fecha"]);
	        	$fechaCompleta=$fecha[2]."-".$fecha[1]."-".$fecha[0];	        	
	        }
	        $ciudad=$_COOKIE['global_agencia'];	        
			$sql1="select t.codigo, t.nombre, t.abreviatura from tipos_precio t where '$fechaCompleta 00:00:00' between t.desde and t.hasta and DAYOFWEEK('$fechaCompleta') in (SELECT cod_dia from tipos_precio_dias where cod_tipoprecio=t.codigo) and estado=1 and cod_estadodescuento=3 and $ciudad in (SELECT cod_ciudad from tipos_precio_ciudad where cod_tipoprecio=t.codigo) and ($codMaterial in (SELECT codigo_material from material_apoyo where cod_linea_proveedor in (SELECT cod_linea_proveedor from tipos_precio_lineas where cod_tipoprecio=t.codigo)) or $codMaterial in (SELECT cod_material from tipos_precio_productos where cod_tipoprecio=t.codigo)) order by 3";
			$resp1=mysqli_query($enlaceCon,$sql1);
			if($contadorAux>0){
				//echo "<option value='-9999'>-</option>";		
			  while($dat=mysqli_fetch_array($resp1)){
				$codigo=$dat[0];
				$nombre=$dat[1];
				$abreviatura=$dat[2];
				if($codigo==$codTipoPrecio){
                 echo "<option value='$codigo' selected>$abreviatura %</option>";					 
				}else{
				echo "<option value='$codigo'>$abreviatura %</option>";					
				}
			  }
			}else{
			   echo "<option value='-9999'> - </option>";		
			}
			
			//echo $sql1;
?>
