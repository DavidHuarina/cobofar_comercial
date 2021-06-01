<?php
$estilosVenta=1;
require("conexionmysqli2.inc");
require("estilos2.inc");
require("funciones.php");

$codigo_registro=$_POST["codigo_registro"];
$sqlCodigo="";
if(isset($_POST['codigo'])&&$_POST['codigo']!=""){
  $sqlCodigo="and m.codigo_material in (".$_POST['codigo'].")";
}

$sqlNombre="";
if(isset($_POST['nombre'])&&$_POST['nombre']!=""){
  $sqlNombre="and m.descripcion_material like '%".$_POST['nombre']."%'";
}

$stringLineasX="";
if(isset($_POST['lineas'])&&count($_POST['lineas'])>0){
  $stringLineasX="and m.cod_linea_proveedor in (".implode(",",$_POST['lineas']).") ";
}

$stringFormasX="";
if(isset($_POST['formas'])&&count($_POST['formas'])>0){
  $stringFormasX="and m.cod_forma_far in (".implode(",",$_POST['formas']).") ";
}

$stringAccionesX="";
if(isset($_POST['acciones'])&&count($_POST['acciones'])>0){
  $stringAccionesX="and m.codigo_material in (select codigo_material from material_accionterapeutica where cod_accionterapeutica in (".implode(",",$_POST['acciones'])."))";
}

$sqllimit="";
if($sqlCodigo==""&&$sqlNombre==""&&$stringLineasX==""&&$stringFormasX==""&&$stringAccionesX=="")
{
  $sqllimit="LIMIT 100";
}

 //echo $sql;
$sql="select m.codigo_material, m.descripcion_material, m.estado, 
    (select e.nombre_empaque from empaques e where e.cod_empaque=m.cod_empaque), 
    (select f.nombre_forma_far from formas_farmaceuticas f where f.cod_forma_far=m.cod_forma_far), 
    (select pl.nombre_linea_proveedor from proveedores p, proveedores_lineas pl where p.cod_proveedor=pl.cod_proveedor and pl.cod_linea_proveedor=m.cod_linea_proveedor),
    (select t.nombre_tipoventa from tipos_venta t where t.cod_tipoventa=m.cod_tipoventa), m.cantidad_presentacion, m.principio_activo,m.codigo_barras 
    from material_apoyo m
    where m.estado='1' $sqlCodigo $stringLineasX $sqlNombre $stringFormasX $stringAccionesX order by m.descripcion_material $sqllimit";
//echo $sql;    
$resp=mysqli_query($enlaceCon,$sql); 
echo "<center><table class='table table-sm' id='tabla_productos'>";
  echo "<tr class='bg-info text-white'><th>Indice</th><th>&nbsp;</th><th>Nombre Producto</th><th>Codigo Barras</th><th>Forma Farmaceutica</th><th>Linea Distribuidor</th><th>Principio Activo</th><th>Tipo Venta</th>
    <th>Accion Terapeutica</th></tr>";
  $indice_tabla=1;
  while($dat=mysqli_fetch_array($resp))
  {
    $codigo=$dat[0];
    $nombreProd=$dat[1];
    $estado=$dat[2];
    $empaque=$dat[3];
    $formaFar=$dat[4];
    $nombreLinea=$dat[5];
    $tipoVenta=$dat[6];
    $cantPresentacion=$dat[7];
    $principioActivo=$dat[8];
    $codBarras=$dat['codigo_barras'];
    if($codBarras==""){
      $codBarras=" - ";
    }
    $txtPrincipioActivo="";
    $sqlAccion="select a.nombre from principios_activos a, principios_activosproductos m
      where m.cod_principioactivo=a.codigo and 
      m.cod_material='$codigo'";
    $respAccion=mysqli_query($enlaceCon,$sqlAccion);
    while($datAccion=mysqli_fetch_array($respAccion)){
      $nombrePrinAct=$datAccion[0];
      $txtPrincipioActivo=$txtPrincipioActivo." - ".$nombrePrinAct;
    }
    
    $txtAccionTerapeutica="";
    $sqlAccion="select a.nombre_accionterapeutica from acciones_terapeuticas a, material_accionterapeutica m
      where m.cod_accionterapeutica=a.cod_accionterapeutica and 
      m.codigo_material='$codigo'";
    $respAccion=mysqli_query($enlaceCon,$sqlAccion);
    while($datAccion=mysqli_fetch_array($respAccion)){
      $nombreAccionTerX=$datAccion[0];
      $txtAccionTerapeutica=$txtAccionTerapeutica." - ".$nombreAccionTerX;
    }
    
    echo "<tr><td align='center'>$indice_tabla</td><td align='center'>
    <input type='checkbox' name='codigo' value='$codigo'></td>
    <td>$nombreProd</td><td>$codBarras</td><td>$formaFar</td>
    <td>$nombreLinea</td><td>$txtPrincipioActivo</td><td>$tipoVenta</td><td>$txtAccionTerapeutica</td></tr>";
    $indice_tabla++;
  }
  echo "</table>";