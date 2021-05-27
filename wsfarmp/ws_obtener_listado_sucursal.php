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
          case 'ObtenerListadoSucursales':
            $datosResp=obtenerListadoSucursales();$existeFuncion=1;  
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

function obtenerListadoSucursales(){
  require_once __DIR__.'/../conexionmysqli2.inc';
  mysqli_set_charset($enlaceCon,"utf8");
  $consulta = "SELECT cod_ciudad,descripcion,direccion,cod_localidad from ciudades";
  $resp = mysqli_query($enlaceCon,$consulta);
  $ff=0;
  $datos=[];
  while ($dat = mysqli_fetch_array($resp)) {
     $datos[$ff]['codigo']=$dat['cod_ciudad'];
     $datos[$ff]['nombre']=$dat['descripcion'];
     $datos[$ff]['direccion']=$dat['direccion'];
     $datos[$ff]['cod_localidad']=$dat['cod_localidad'];
     $ff++;    
  }
  return array($ff,$datos);
}
