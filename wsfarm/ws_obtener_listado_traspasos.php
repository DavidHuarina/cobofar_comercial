<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $datos = json_decode(file_get_contents("php://input"), true); 
    //Parametros de consulta
    $accion=NULL;
    if(isset($datos['accion'])&&isset($datos['sIdentificador'])&&isset($datos['sKey']))
        if($datos['sIdentificador']=="farma"&&$datos['sKey']=="89i6u32v7xda12jf96jgi30lh"){
        $accion=$datos['accion']; //recibimos la accion
        $estado=0;
        $mensaje="";
        if($accion=="ObtenerListadoAlmacenes"){
          //recibimos la variable para el proceso
          $tipo="";
          if(isset($datos['tipo'])){
            $tipo=$datos['tipo'];
          } 

          $datosResp=obtenerDatosTraspasos($tipo);                
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
                            "totalComponentes"=>1     
                            );
                }
          }else{
            $resultado=array("estado"=>3, 
                            "mensaje"=>"Error de función");
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

function obtenerDatosTraspasos($tipo){
  require_once __DIR__.'/../conexion_externa_farma.php';
  $dbh = new ConexionFarma();
  $sqlTipo="";
  if($tipo!=""){
    $sqlTipo="where a.tipo='".$tipo."' ";
  }
  $sql="SELECT a.* FROM almacen a $sqlTipo";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $ff=0;
  $datos=[];
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
     $datos[$ff]['des']=$row['DES'];
     $datos[$ff]['direc']=$row['DIREC'];
     $datos[$ff]['age1']=$row['AGE1'];
     $datos[$ff]['age']=$row['AGE'];
     $datos[$ff]['tipo']=$row['TIPO'];
     $ff++;
  }

 return array($ff,$datos);
}
