<?php
require_once '../conexionmysqli.inc';
require_once '../function_web.php';
$listProv=obtenerListadoProveedoresWeb();//web service
$contador=0;
echo "<br><br>Iniciando....<br><br><br><br>";
foreach ($listProv->lista as $prov) {
	//echo $prov->idproveedor."<br>";
	$codigo=$prov->idproveedor;
	$nombre=$prov->des;
	$direccion=$prov->dir;
	$telefono=$prov->tel;
	$contacto=$prov->responsa;

	if($contador==0){
		$sql="DELETE FROM proveedores";
		$sqlDelete=mysqli_query($enlaceCon,$sql);
	}


	$sql="INSERT INTO proveedores (cod_proveedor,nombre_proveedor,direccion,telefono1,contacto)
        VALUES ('$codigo','$nombre','$direccion','$telefono','$contacto')";
    $sqlinserta=mysqli_query($enlaceCon,$sql);


	if(isset($_GET['lineas'])&&$_GET['lineas']==1){
		if($contador==0){
		   $sql="DELETE FROM proveedores_lineas";
		   $sqlDelete=mysqli_query($enlaceCon,$sql);
	    }
		$listLinea=obtenerListadoLineasProveedoresWeb($codigo);//web service 
		if($listLinea->totalComponentes>0){
			foreach ($listLinea->lista as $linea) {
			//echo $linea->idslinea;
			$codLinea=$linea->idslinea;
	        $nombreLinea=$linea->des;
	        $procedenciaLinea=1;
	        $margenLinea=35;
            $sql="INSERT INTO proveedores_lineas (cod_linea_proveedor,nombre_linea_proveedor,abreviatura_linea_proveedor,cod_proveedor,estado,cod_procedencia,margen_precio)
              VALUES ('$codLinea','$nombreLinea','$nombreLinea','$codigo',1,'$procedenciaLinea','$margenLinea')";
           echo $sql."<br>";
            $sqlinserta=mysqli_query($enlaceCon,$sql);
		 }
		}
		
	}
   $contador++;
}
echo "Realizado!";

