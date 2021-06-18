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
            case 'consultaClienteID':
                $existeFuncion=1;
                if(!isset($datos['identificacion'])){
                    $existeFuncion=0;
                    $datosResp[0]=0;
                }else{
                    if($datos['identificacion']!=""){
                        $datosResp=consultar_cliente_ID($datos['identificacion']);                 
                    }else{
                        $existeFuncion=0;
                        $datosResp[0]=0;
                    }
                    
                }             
            break;
            case 'registrarCliente':
                $existeFuncion=1;
                if(!isset($datos['nombre']) && !isset($datos['paterno']) && !isset($datos['nit']) && !isset($datos['identificacion']) && !isset($datos['email']) && !isset($datos['telefono']) && !isset($datos['direccion']) ){
                    $existeFuncion=0;
                    $datosResp[0]=0;
                }else{
                    if($datos['nombre']!="" && $datos['paterno']!="" && $datos['identificacion']!="" && $datos['nit']!="" ){
                        if(!verificarciexistente($datos['identificacion'])){
                            $datosResp=insertar_cliente($datos['nombre'],$datos['paterno'],$datos['nit'],$datos['identificacion'],$datos['email'],$datos['telefono'],$datos['direccion']);
                            $datosResp[0]=1;
                        }else{
                            $datosResp[0]=-100;
                        }
                    }else{
                        $existeFuncion=0;
                        $datosResp[0]=0;
                    }
                    
                }             
            break;
        }              
        if($existeFuncion>0){                                  
            //var_dump($datosResp);
            if($datosResp[0]==0){
                 $estado=2;
                 $mensaje = "Lista Vacia";
                 $resultado=array("estado"=>$estado, 
                            "mensaje"=>$mensaje, 
                            "totalComponentes"=>0);
            }elseif($datosResp[0]==-100){
                 $estado=6;
                 $mensaje = "CI ya Registrado";
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
                    "mensaje"=>"Error de funcion / parametros");
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

function consultar_cliente_ID($identificacion){
  require_once __DIR__.'/../conexionmysqli2.inc';
  require_once __DIR__.'/../funciones.php';
  mysqli_set_charset($enlaceCon,"utf8");
  $consulta = "SELECT c.cod_cliente, c.nombre_cliente,c.paterno,c.nit_cliente,c.ci_cliente,c.email_cliente,c.telf1_cliente,c.dir_cliente
        from clientes c where c.ci_cliente=$identificacion";
         //echo $consulta; 
  $resp = mysqli_query($enlaceCon,$consulta);
  $ff=0;
  $datos=[];
  while ($dat = mysqli_fetch_array($resp)) {
        $datos[$ff]['codigo']=$dat['cod_cliente'];
        $datos[$ff]['nombre']=$dat['nombre_cliente']." ".$dat['paterno'];
        $datos[$ff]['nit']=$dat['nit_cliente'];
        $datos[$ff]['identificacion']=$dat['ci_cliente'];
        $datos[$ff]['email']=$dat['email_cliente'];
        $datos[$ff]['telefono']=$dat['telf1_cliente'];
        $datos[$ff]['direccion']=$dat['dir_cliente'];
        $datos[$ff]['cod_ciudad_inicial']=obtenerCodCiudad_primeraFac($dat['cod_cliente'],$enlaceCon);
        $datos[$ff]['nombre_ciudad_inicial']=obtenerNomCiudad_primeraFac($dat['cod_cliente'],$enlaceCon);
        $ff++;
  }
  return array($ff,$datos);
}

function  obtenerCodCiudad_primeraFac($cod_cliente,$enlaceCon){
    // require_once __DIR__.'/../conexionmysqli2.inc';
    // require_once __DIR__.'/../funciones.php';
    mysqli_set_charset($enlaceCon,"utf8");
    $consulta = "SELECT ci.cod_ciudad from ciudades ci where ci.cod_ciudad in (select a.cod_ciudad from almacenes a where a.cod_almacen in (select sa.cod_almacen from salida_almacenes sa where sa.cod_tiposalida=1001 and sa.cod_cliente=$cod_cliente))";
    // echo $consulta;
    $resp = mysqli_query($enlaceCon,$consulta);
    $codigo_ciudad=0;
    while ($dat = mysqli_fetch_array($resp)) {
        // echo "aqui";
        $codigo_ciudad=$dat['cod_ciudad'];
    }
    return $codigo_ciudad;
}
function  obtenerNomCiudad_primeraFac($cod_cliente,$enlaceCon){
    // require_once __DIR__.'/../conexionmysqli2.inc';
    // require_once __DIR__.'/../funciones.php';
    mysqli_set_charset($enlaceCon,"utf8");
    $consulta = "SELECT ci.descripcion from ciudades ci where ci.cod_ciudad in (select a.cod_ciudad from almacenes a where a.cod_almacen in (select sa.cod_almacen from salida_almacenes sa where sa.cod_tiposalida=1001 and sa.cod_cliente=$cod_cliente))";
    // echo $consulta;
    $resp = mysqli_query($enlaceCon,$consulta);
    $codigo_ciudad="";
    while ($dat = mysqli_fetch_array($resp)) {
        $codigo_ciudad=$dat['descripcion'];
    }
    return $codigo_ciudad;
}

function insertar_cliente($nombre,$paterno,$nit,$identificacion,$email,$telefono,$direccion){
    require_once __DIR__.'/../conexionmysqli2.inc';
    require_once __DIR__.'/../funciones.php';
    mysqli_set_charset($enlaceCon,"utf8");
    $ff=0;


    $cod_cliente=obtener_codigoCliente($enlaceCon);
    $consulta = "INSERT into clientes(cod_cliente,nombre_cliente,paterno,nit_cliente,ci_cliente,dir_cliente,telf1_cliente,email_cliente) values($cod_cliente,'$nombre','$paterno','$nit','$identificacion','$direccion','$telefono','$email')";
         //echo $consulta; 
    $sql_inserta=mysqli_query($enlaceCon,$consulta);
    if($sql_inserta=="1"){
        $datos[0]['cod_cliente']=$cod_cliente;
        return array($ff,$datos);   
    }else{
        return array($ff,0);
    }

}

function  obtener_codigoCliente($enlaceCon){
    mysqli_set_charset($enlaceCon,"utf8");
    $consulta = "select cod_cliente from clientes order by cod_cliente desc limit 1";
    // echo $consulta;
    $resp = mysqli_query($enlaceCon,$consulta);
    $codigo=0;
    while ($dat = mysqli_fetch_array($resp)) {
        $codigo=$dat['cod_cliente'];
    }
    $codigo++;
    return $codigo;
}
function verificarciexistente($identificacion){
    require_once __DIR__.'/../conexionmysqli2.inc';
    require_once __DIR__.'/../funciones.php';
    mysqli_set_charset($enlaceCon,"utf8");
    $consulta = "select cod_cliente from clientes where ci_cliente=$identificacion limit 1";
    // echo $consulta;
    $resp = mysqli_query($enlaceCon,$consulta);
    $codigo=0;
    while ($dat = mysqli_fetch_array($resp)) {
        $codigo++;
    }
    if($codigo>0){
        return true;
    }else{
        return false;
    }
    

}