<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $datos = json_decode(file_get_contents("php://input"), true); 
    //Parametros de consulta
    $accion=NULL;
    if(isset($datos['accion'])&&isset($datos['sIdentificador'])&&isset($datos['sKey']))
        if($datos['sIdentificador']=="cobofar2021"&&$datos['sKey']=="34r567y3k8dsu3izx98l1re3oiu"){
        $accion=$datos['accion']; //recibimos la accion
        $estado=0;
        $mensaje="";
        $existeFuncion=0;
        switch ($accion) {
          case 'ObtenerListadoProductos':
            $datosResp=obtenerListadoProductos();$existeFuncion=1;  
          break;
        }              
        if($existeFuncion>0){                                  
           if($datosResp[0]==0){
                 $estado=2;
                 $mensaje = "Lista Vacia";
                 $resultado=array("estado"=>$estado, 
                            "mensaje"=>$mensaje, 
                            "totalComponentes"=>0);
           }else{
                  $estado=1;
                  $lista = $datosResp[1]; 
                  $resultado=array(
                            "estado"=>$estado,
                            "mensaje"=>"Lista Obtenida Correctamente", 
                            "lista"=>$lista, 
                            "totalComponentes"=>count($lista)     
                            );
            }
          }else{
              $resultado=array("estado"=>3, 
                            "mensaje"=>"Error de funcion");
          }
        }else{
            $resultado=array("estado"=>4, 
                            "mensaje"=>"Credenciales Incorrectas");
        }
            header('Content-type: application/json');
            echo json_encode($resultado);
}else{
    $resp=array("estado"=>5, 
                "mensaje"=>"El acceso al WS es incorrecto");
    header('Content-type: application/json');
    echo json_encode($resp);
}

function obtenerListadoProductos(){
  require_once __DIR__.'/../conexionmysqli2.inc';
  mysqli_set_charset($enlaceCon,"utf8");
  $consulta = "SELECT m.codigo_material,m.descripcion_material,m.cantidad_presentacion,m.cod_linea_proveedor,(SELECT nombre_linea_proveedor from proveedores_lineas where cod_linea_proveedor=m.cod_linea_proveedor)nombre_linea,(SELECT cod_proveedor from proveedores_lineas where cod_linea_proveedor=m.cod_linea_proveedor)cod_proveedor,
(SELECT nombre_proveedor from proveedores where cod_proveedor=(SELECT cod_proveedor from proveedores_lineas where cod_linea_proveedor=m.cod_linea_proveedor))nombre_proveedor FROM material_apoyo m where m.estado=1 and m.descripcion_material!='<<< RESERVADO >>>'";
  $resp = mysqli_query($enlaceCon,$consulta);
  $ff=0;
  $datos=[];
  while ($dat = mysqli_fetch_array($resp)) {
     $datos[$ff]['codigo']=$dat['codigo_material'];
     $datos[$ff]['nombre']=$dat['descripcion_material'];
     $datos[$ff]['cod_linea']=$dat['cod_linea_proveedor'];
     $datos[$ff]['nombre_linea']=$dat['nombre_linea'];
     $datos[$ff]['cod_proveedor']=$dat['cod_proveedor'];
     $datos[$ff]['nombre_proveedor']=$dat['nombre_proveedor'];
     $ff++;    
  }
  return array($ff,$datos);
}