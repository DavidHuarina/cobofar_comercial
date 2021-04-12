<?php
require_once '../conexionmysqli.inc';
require_once '../function_web.php';
$estilosVenta=1;
$listProd=obtenerListadoProductosWeb("A");//web service
$contador=0;
$user=1017;//USUARIO PARA EL LOG ADMIN
echo "<br><br>Iniciando....<br><br><br><br>";
foreach ($listProd->lista as $prod) {
	//echo $prod->idproveedor."<br>";
	$codigo=$prod->cprod;
	$nombre=$prod->des;
	$estado=1;
	$cod_linea=$prod->idslinea;
	$cod_forma_far=1;
	$principio_activo=1;
	$cod_tipoventa=1; //RECETA MEDICA
	$codigo_barras=$prod->cod_bar;
  $precioInsertar=0;
  //$precioInsertar=obtenerPrecioVentaMaxProcesoAnteriorSistema($prod->cprod);//$prod->precio_venta;
	if($contador==0){
		/*$sql="DELETE FROM material_apoyo";
		$sqlDelete=mysqli_query($enlaceCon,$sql);*/
	}

    $sico=0;
    if($prod->sico=="S"){
      $sico=1;
    }

    $div=0;
    if($prod->div=="S"){
      $div=1;
    }

    $cantidad_presentacion=$prod->canenvase;
    $cod_empaque=$prod->idenvase;

  $cod_existe=verificarProductoExistente($codigo);
  if($cod_existe>0){

        $sql="UPDATE material_apoyo SET descripcion_material='$nombre',estado='$estado',cod_linea_proveedor='$cod_linea',cod_forma_far='$cod_forma_far',cod_empaque='$cod_empaque',cantidad_presentacion='$cantidad_presentacion',principio_activo='$principio_activo',cod_tipoventa='$cod_tipoventa',producto_controlado='$sico',divi='$div' 
        where codigo_material='$codigo'";
        $sqlinserta=mysqli_query($enlaceCon,$sql);
        if($sqlinserta==1){
        $sqlCiudades="SELECT cod_ciudad from ciudades where cod_estadoreferencial=1";           
        $respCiudades=mysqli_query($enlaceCon,$sqlCiudades);
        while($detCiudad=mysqli_fetch_array($respCiudades)){    
             $ciudad=$detCiudad[0];   
             if($deletePrecios==1){
                $sqlDel="DELETE FROM precios where cod_precio=1 and codigo_material='$codigo' and cod_ciudad='$ciudad'";
                $delete=mysqli_query($enlaceCon,$sqlDel);
                $sqlIns="INSERT INTO precios ('$codigo','1','$precioInsertar','$ciudad','$user')";
                $insert=mysqli_query($enlaceCon,$sqlIns);
             }
        }
      }
  }else{      
    $sql="INSERT INTO material_apoyo (codigo_material,descripcion_material,estado,cod_linea_proveedor,cod_forma_far,cod_empaque,cantidad_presentacion,principio_activo,cod_tipoventa,codigo_barras,producto_controlado,divi) VALUES ('$codigo','$nombre','$estado','$cod_linea','$cod_forma_far','$cod_empaque','$cantidad_presentacion','$principio_activo','$cod_tipoventa','$codigo_barras','$sico','$div')";
    $sqlinserta=mysqli_query($enlaceCon,$sql);
    //ACTUALIZACION DE PRECIOS
    /*if($sqlinserta==1){
        $sqlCiudades="SELECT cod_ciudad from ciudades where cod_estadoreferencial=1";           
        $respCiudades=mysqli_query($enlaceCon,$sqlCiudades);
        while($detCiudad=mysqli_fetch_array($respCiudades)){    
             $ciudad=$detCiudad[0];   
             if($deletePrecios==1){
                $sqlDel="DELETE FROM precios where cod_precio=1 and codigo_material='$codigo' and cod_ciudad='$ciudad'";
                $delete=mysqli_query($enlaceCon,$sqlDel);
                $sqlIns="INSERT INTO precios ('$codigo','1','$precioInsertar','$ciudad','$user')";
                $insert=mysqli_query($enlaceCon,$sqlIns);
             }
        }
    }*/
  }

   $contador++;
}
echo "Realizado!";

