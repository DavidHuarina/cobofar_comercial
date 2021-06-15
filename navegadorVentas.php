<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="lib/externos/jquery/jquery-ui/completo/jquery-ui-1.8.9.custom.css" rel="stylesheet" type="text/css"/>
        <link href="lib/css/paneles.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="lib/externos/jquery/jquery-1.4.4.min.js"></script>
        <script type="text/javascript" src="lib/externos/jquery/jquery-ui/minimo/jquery.ui.core.min.js"></script>
        <script type="text/javascript" src="lib/externos/jquery/jquery-ui/minimo/jquery.ui.widget.min.js"></script>
        <script type="text/javascript" src="lib/externos/jquery/jquery-ui/minimo/jquery.ui.button.min.js"></script>
        <script type="text/javascript" src="lib/externos/jquery/jquery-ui/minimo/jquery.ui.mouse.min.js"></script>
        <script type="text/javascript" src="lib/externos/jquery/jquery-ui/minimo/jquery.ui.draggable.min.js"></script>
        <script type="text/javascript" src="lib/externos/jquery/jquery-ui/minimo/jquery.ui.position.min.js"></script>
        <script type="text/javascript" src="lib/externos/jquery/jquery-ui/minimo/jquery.ui.resizable.min.js"></script>
        <script type="text/javascript" src="lib/externos/jquery/jquery-ui/minimo/jquery.ui.dialog.min.js"></script>
        <script type="text/javascript" src="lib/externos/jquery/jquery-ui/minimo/jquery.ui.datepicker.min.js"></script>
        <script type="text/javascript" src="lib/js/xlibPrototipo-v0.1.js"></script>
        <script type='text/javascript' language='javascript'>

function nuevoAjax()
{	var xmlhttp=false;
	try {
			xmlhttp = new ActiveXObject('Msxml2.XMLHTTP');
	} catch (e) {
	try {
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	} catch (E) {
		xmlhttp = false;
	}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
 	xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}		
	
function ShowBuscar(){
	document.getElementById('divRecuadroExt').style.visibility='visible';
	document.getElementById('divProfileData').style.visibility='visible';
	document.getElementById('divProfileDetail').style.visibility='visible';
    document.getElementById('nroProcesoBusqueda').focus();
}

function HiddenBuscar(){
	document.getElementById('divRecuadroExt').style.visibility='hidden';
	document.getElementById('divProfileData').style.visibility='hidden';
	document.getElementById('divProfileDetail').style.visibility='hidden';
}
	
function funOk(codReg,funOkConfirm)
{   $.get("programas/salidas/frmConfirmarCodigoSalida.php","codigo="+codReg, function(inf1) {
        dlgAC("#pnldlgAC","Codigo de confirmacion",inf1,function(){
            var cad1=$("input#idtxtcodigo").val();
            var cad2=$("input#idtxtclave").val();
            if(cad1!="" && cad2!="") {
                dlgEsp.setVisible(true);
                $.get("programas/salidas/validacionCodigoConfirmar.php","codigo="+cad1+"&clave="+cad2, function(inf2) {
                    inf2=xtrim(inf2);
                    dlgEsp.setVisible(false);
                    if(inf2=="" || inf2=="OK") {
                        /**/funOkConfirm();/**/
                    } else {
                        dlgA("#pnldlgA2","Informe","<div class='pnlalertar'>El codigo ingresado es incorrecto.</div>",function(){},function(){});
                    }
                });
            } else {
                dlgA("#pnldlgA3","Informe","<div class='pnlalertar'>Introdusca el codigo de confirmacion.</div>",function(){},function(){});
            }
        },function(){});
    });
}

function funVerifi(codReg){   
var parametros={"codigo":codReg};
 $.ajax({
        type: "GET",
        dataType: 'html',
        url: "programas/salidas/frmConfirmarCodigoSalida2.php",
        data: parametros,
        success:  function (resp) { 
            $("#datos_anular").html(resp);
            $("#codigo_salida").val(codReg);
            $("#contrasena_admin").val("");
            $("#modalAnularFactura").modal("show");           
      }
 }); 
}
function confirmarCodigo(){   
  var cad1=$("input#idtxtcodigo").val();
  var cad2=$("input#idtxtclave").val(); 
  var parametros={"codigo":cad1,"clave":cad2};
  $.ajax({
        type: "GET",
        dataType: 'html',
        url: "programas/salidas/validacionCodigoConfirmar.php",
        data: parametros,
        success:  function (resp) { 
            resp=xtrim(resp);
            if(resp=="" || resp=="OK") {
                location.href='anular_venta.php?codigo_registro='+$("#codigo_salida").val();
            }else{
               Swal.fire("Error!","El codigo que ingreso es incorrecto","error");
               $("#modalAnularFactura").modal("hide");    
            }
      }
 }); 
}


function obtenerCodigoGenerado(){
  var cad1=$("input#idtxtcodigo").val();
  var pss=$("input#contrasena_admin").val();
  var parametros={"codigo":cad1,"pass":pss};
  $.ajax({
        type: "GET",
        dataType: 'html',
        url: "programas/salidas/insertarCodigoConfirmar.php",
        data: parametros,
        success:  function (resp) { 
            $("input#idtxtclave").val(resp); 
      }
 });  
}
function pressEnter(e, f){
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==13){
        ajaxBuscarVentas(f);                              
    }
}
function ajaxBuscarVentas(f){
	var fechaIniBusqueda, fechaFinBusqueda, nroCorrelativoBusqueda,nroProcesoBusqueda, verBusqueda, global_almacen, clienteBusqueda;
	fechaIniBusqueda=document.getElementById("fechaIniBusqueda").value;
	fechaFinBusqueda=document.getElementById("fechaFinBusqueda").value;
	nroCorrelativoBusqueda=document.getElementById("nroCorrelativoBusqueda").value;
    nroProcesoBusqueda=document.getElementById("nroProcesoBusqueda").value;
	verBusqueda=document.getElementById("verBusqueda").value;
	global_almacen=document.getElementById("global_almacen").value;
	clienteBusqueda=document.getElementById("clienteBusqueda").value;
	var contenedor;
	contenedor = document.getElementById('divCuerpo');
	ajax=nuevoAjax();

	ajax.open("GET", "ajaxSalidaVentas.php?fechaIniBusqueda="+fechaIniBusqueda+"&fechaFinBusqueda="+fechaFinBusqueda+"&nroCorrelativoBusqueda="+nroCorrelativoBusqueda+"&verBusqueda="+verBusqueda+"&global_almacen="+global_almacen+"&clienteBusqueda="+clienteBusqueda+"&nroProcesoBusqueda="+nroProcesoBusqueda,true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			contenedor.innerHTML = ajax.responseText;
			HiddenBuscar();
		}
	}
	ajax.send(null)
}

function enviar_nav()
{   window.open('registrar_salidaventas.php', '_blank');
}
function editar_salida(f)
{   var i;
    var j=0;
    var j_cod_registro, estado_preparado;
    var fecha_registro;
    for(i=0;i<=f.length-1;i++)
    {   if(f.elements[i].type=='checkbox')
        {   if(f.elements[i].checked==true)
            {   j_cod_registro=f.elements[i].value;
                fecha_registro=f.elements[i-2].value;
                estado_preparado=f.elements[i-1].value;
                j=j+1;
            }
        }
    }
    if(j>1)
    {   alert('Debe seleccionar solamente un registro para anularlo.');
    }
    else
    {   if(j==0)
        {   alert('Debe seleccionar un registro para anularlo.');
        }
        else
        {   if(f.fecha_sistema.value==fecha_registro)
            {
                {   
                        location.href='editarVentas.php?codigo_registro='+j_cod_registro;
                }
            }
            else
            {   funOk(j_cod_registro,function(){
                        location.href='editarVentas.php?codigo_registro='+j_cod_registro;
                    });
            }
        }
    }
}
function anular_salida(f)
{   var i;
    var j=0;
    var j_cod_registro, estado_preparado;
    var fecha_registro;
    for(i=0;i<=f.length-1;i++)
    {   if(f.elements[i].type=='checkbox')
        {   if(f.elements[i].checked==true)
            {   j_cod_registro=f.elements[i].value;
                fecha_registro=f.elements[i-2].value;
                estado_preparado=f.elements[i-1].value;
                j=j+1;
            }
        }
    }
    if(j>1)
    {   alert('Debe seleccionar solamente un registro para anularlo.');
    }
    else
    {   if(j==0)
        {   alert('Debe seleccionar un registro para anularlo.');
        }
        else
        {   funVerifi(j_cod_registro);
        }
    }
}

function anular_salida2(f)
{   var i;
    var j=0;
    var j_cod_registro, estado_preparado;
    var fecha_registro;
    for(i=0;i<=f.length-1;i++)
    {   if(f.elements[i].type=='checkbox')
        {   if(f.elements[i].checked==true)
            {   j_cod_registro=f.elements[i].value;
                fecha_registro=f.elements[i-2].value;
                estado_preparado=f.elements[i-1].value;
                j=j+1;
            }
        }
    }
    if(j>1)
    {   alert('Debe seleccionar solamente un registro para anularlo.');
    }
    else
    {   if(j==0)
        {   alert('Debe seleccionar un registro para anularlo.');
        }
        else
        {   if(confirm('Esta seguro de anular?')) {
                        location.href='anular_venta.php?codigo_registro='+j_cod_registro;
            };
        }
    }
}

function cambiarCancelado(f)
{   var i;
    var j=0;
    var j_cod_registro, estado_preparado;
    var fecha_registro;
    for(i=0;i<=f.length-1;i++)
    {   if(f.elements[i].type=='checkbox')
        {   if(f.elements[i].checked==true)
            {   j_cod_registro=f.elements[i].value;
                fecha_registro=f.elements[i-2].value;
                estado_preparado=f.elements[i-1].value;
                j=j+1;
            }
        }
    }
    if(j>1)
    {   alert('Debe seleccionar solamente un registro.');
    }
    else
    {   if(j==0)
        {   alert('Debe seleccionar un registro.');
        }
        else
		{      
			funOk(j_cod_registro,function() {
				location.href='cambiarEstadoCancelado.php?codigo_registro='+j_cod_registro+'';
			});            
        }
    }
}

function cambiarNoEntregado(f)
{   var i;
    var j=0;
    var j_cod_registro;
    for(i=0;i<=f.length-1;i++)
    {   if(f.elements[i].type=='checkbox')
        {   if(f.elements[i].checked==true)
            {   j_cod_registro=f.elements[i].value;
                j=j+1;
            }
        }
    }
    if(j>1)
    {   alert('Debe seleccionar solamente una Salida.');
    }
    else
    {   if(j==0)
        {   alert('Debe seleccionar una Salida.');
        }
        else
        {   location.href='cambiarEstadoNoEntregado.php?codigo_registro='+j_cod_registro+'';
        }
    }
}
function cambiarNoCancelado(f)
{   var i;
    var j=0;
    var j_cod_registro;
    for(i=0;i<=f.length-1;i++)
    {   if(f.elements[i].type=='checkbox')
        {   if(f.elements[i].checked==true)
            {   j_cod_registro=f.elements[i].value;
                j=j+1;
            }
        }
    }
    if(j>1)
    {   alert('Debe seleccionar solamente una Salida.');
    }
    else
    {   if(j==0)
        {   alert('Debe seleccionar una Salida.');
        }
        else
        {   location.href='cambiarEstadoNoCancelado.php?codigo_registro='+j_cod_registro+'';
        }
    }
}

function imprimirNotas(f)
{   var i;
    var j=0;
    datos=new Array();
    for(i=0;i<=f.length-1;i++)
    {   if(f.elements[i].type=='checkbox')
        {   if(f.elements[i].checked==true)
            {   datos[j]=f.elements[i].value;
                j=j+1;
            }
        }
    }
    if(j==0)
    {   alert('Debe seleccionar al menos una salida para imprimir la Nota.');
    }
    else
    {   window.open('navegador_detallesalidamaterialResumen.php?codigo_salida='+datos+'','','scrollbars=yes,status=no,toolbar=no,directories=no,menubar=no,resizable=yes,width=1000,height=800');
    }
}
function preparar_despacho(f)
{   var i;
    var j=0;
    datos=new Array();
    for(i=0;i<=f.length-1;i++)
    {   if(f.elements[i].type=='checkbox')
        {   if(f.elements[i].checked==true)
            {   datos[j]=f.elements[i].value;
                j=j+1;
            }
        }
    }
    if(j==0)
    {   alert('Debe seleccionar al menos una salida para proceder a su preparado.');
    }
    else
    {   location.href='preparar_despacho.php?datos='+datos+'&tipo_material=1&grupo_salida=2';
    }
}
function enviar_datosdespacho(f)
{   var i;
    var j=0;
    datos=new Array();
    for(i=0;i<=f.length-1;i++)
    {   if(f.elements[i].type=='checkbox')
        {   if(f.elements[i].checked==true)
            {   datos[j]=f.elements[i].value;
                j=j+1;
            }
        }
    }
    if(j==0)
    {   alert('Debe seleccionar al menos una salida para proceder al registro del despacho.');
    }
    else
    {   location.href='registrar_datosdespacho.php?datos='+datos+'&tipo_material=1&grupo_salida=2';
    }
}
function llamar_preparado(f, estado_preparado, codigo_salida)
{   window.open('navegador_detallesalidamateriales.php?codigo_salida='+codigo_salida,'popup','');
}

function mostrarRegistroConTarjeta(codigo){
    $("#titulo_tarjeta").html("");
    $("#codigo_salida_tarjeta").val(codigo);
    $("#modalPagoTarjeta").modal("show");   
}

function removerRegistroConTarjeta(codigo){
    Swal.fire({
        title: '¿Quitar Tarjeta?',
        text: "Se removerá la tarjeta de la Factura",
         type: 'info',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-default',
        confirmButtonText: 'Remover',
        cancelButtonText: 'Cancelar',
        buttonsStyling: false
       }).then((result) => {
          if (result.value) {
            quitarTarjetaVenta(codigo)               
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            return(false);
          }
    });   
}
function quitarTarjetaVenta(codigo){
  var parametros={"codigo":codigo};
    $.ajax({
        type: "GET",
        dataType: 'html',
        url: "ajaxSaveRemoveTarjetaVenta.php",
        data: parametros,
        success:  function (resp) {  
           window.location.reload();                      
        }
    });
}

function guardarTarjetaVenta(){
    var codigo=$("#codigo_salida_tarjeta").val();
    var banco_tarjeta=$("#banco_tarjeta").val();
    var nro_tarjeta=$("#nro_tarjeta").val();
    var monto_tarjeta=$("#monto_tarjeta").val();

 if(nro_tarjeta!=""&&monto_tarjeta>0){
    var parametros={"codigo":codigo,"banco_tarjeta":banco_tarjeta,"nro_tarjeta":nro_tarjeta,"monto_tarjeta":monto_tarjeta};
    $.ajax({
        type: "GET",
        dataType: 'html',
        url: "ajaxSaveTarjetaVenta.php",
        data: parametros,
        success:  function (resp) {  
           window.location.reload();                      
        }
    });
 }else{
    Swal.fire("Informativo!","Debe ingresar el nro de tarjeta y el monto","warning");
 }
}

        </script>
    </head>
    <body>
<?php

require("conexionmysqli.inc");
require('funciones.php');
require('function_formatofecha.php');

if(!isset($_GET["txtnroingreso"])){
  $txtnroingreso="";  
}else{
  $txtnroingreso = $_GET["txtnroingreso"];    
}
if(!isset($_GET["fecha1"])){
  $fecha1="";  
}else{
  $fecha1 = $_GET["fecha1"];    
}
if(!isset($_GET["fecha2"])){
  $fecha2="";  
}else{
  $fecha2 = $_GET["fecha2"];    
}


require("estilos_almacenes.inc");

$cadComboBancos = "";
$consulta="SELECT c.codigo, c.nombre FROM bancos AS c WHERE estado = 1 ORDER BY c.nombre ASC";
$rs=mysqli_query($enlaceCon,$consulta);
while($reg=mysqli_fetch_array($rs))
   {$codBanco = $reg["codigo"];
    $nomBanco = $reg["nombre"];
    $cadComboBancos=$cadComboBancos."<option value='$codBanco'>$nomBanco</option>";
   }





//SACAMOS LA CONFIGURACION PARA LA ANULACION
$anulacionCodigo=1;
$sqlConf="select valor_configuracion from configuraciones where id_configuracion=6";
$respConf=mysqli_query($enlaceCon,$sqlConf);
$anulacionCodigo=mysqli_result($respConf,0,0);

echo "<form method='post' action=''>";
echo "<input type='hidden' name='fecha_sistema' value='$fecha_sistema'>";

echo "<h1>Listado de Ventas</h1>";
echo "<table class='texto' cellspacing='0' width='90%'>
<tr><th>Leyenda:</th>
<th>Ventas Registradas</th><td bgcolor='#f9e79f' width='5%'></td>

<th>Ventas Anuladas</th><td bgcolor='#e74c3c' width='5%'></td>
<td bgcolor='' width='10%'>&nbsp;</td></tr></table><br>";
//<th>Ventas Depositadas</th><td bgcolor='#1abc9c' width='5%'></td>
echo "<div class=''>
		<input type='button' value='Registrar' name='adicionar' class='btn btn-primary' onclick='enviar_nav()'>
        
		<input type='button' value='Buscar' class='btn btn-info' onclick='ShowBuscar()'></td>";		
//<input type='button' value='Editar' class='btn btn-primary' onclick='editar_salida(this.form)'>        
if($anulacionCodigo==1){
	echo "<input type='button' value='Anular' class='btn btn-danger' onclick='anular_salida(this.form)'>";
}else{
	echo "<input type='button' value='Anular' class='btn btn-danger' onclick='anular_salida2(this.form)'>";	
}
echo "</div>";
		
echo "<div id='divCuerpo'>";
echo "<center><table class='table table-sm'>";
echo "<tr class='bg-info text-white'><th>&nbsp;</th><th>Nro. Factura</th><th>Fecha/hora<br>Registro Salida</th><th>Tipo de Salida</th><th>Monto</th>
	<th>Cliente</th><th>Razon Social</th><th>NIT</th><th>Proceso</th><th>Pago</th><th>&nbsp;</th></tr>";
	
echo "<input type='hidden' name='global_almacen' value='$global_almacen' id='global_almacen'>";

$sqlUser=" and s.cod_chofer='".$_COOKIE["global_usuario"]."' ";
if($_COOKIE["global_usuario"]==-1){
  $sqlUser="";
}
$consulta = "
	SELECT s.cod_salida_almacenes, s.fecha, s.hora_salida, ts.nombre_tiposalida, 
	(select a.nombre_almacen from almacenes a where a.`cod_almacen`=s.almacen_destino), s.observaciones, 
	s.estado_salida, s.nro_correlativo, s.salida_anulada, s.almacen_destino, 
	(select c.nombre_cliente from clientes c where c.cod_cliente = s.cod_cliente), s.cod_tipo_doc, razon_social, nit,s.cod_tipopago,s.monto_final,(SELECT count(*) from registro_depositos where cod_funcionario=s.cod_chofer and CONCAT(s.fecha,' ',s.hora_salida) BETWEEN CONCAT(fecha,' ',hora,':00') and CONCAT(fechaf,' ',horaf,':00') and cod_estadoreferencial=1)AS depositado
	FROM salida_almacenes s, tipos_salida ts 
	WHERE s.cod_tiposalida = ts.cod_tiposalida AND s.cod_almacen = '$global_almacen' and s.cod_tiposalida=1001 $sqlUser ";

if($txtnroingreso!="")
   {$consulta = $consulta."AND s.nro_correlativo='$txtnroingreso' ";
   }
if($fecha1!="" && $fecha2!="")
   {$consulta = $consulta."AND '$fecha1'<=s.fecha AND s.fecha<='$fecha2' ";
   }
$consulta = $consulta."ORDER BY s.fecha desc, s.nro_correlativo DESC limit 0, 100 ";
//echo $consulta;
//
$resp = mysqli_query($enlaceCon,$consulta);
	
	
while ($dat = mysqli_fetch_array($resp)) {
    $codigo = $dat[0];
    $fecha_salida = $dat[1];
    $fecha_salida_mostrar = "$fecha_salida[8]$fecha_salida[9]-$fecha_salida[5]$fecha_salida[6]-$fecha_salida[0]$fecha_salida[1]$fecha_salida[2]$fecha_salida[3]";
    $hora_salida = $dat[2];
    $nombre_tiposalida = $dat[3];
    $nombre_almacen = $dat[4];
    $obs_salida = $dat[5];
    $estado_almacen = $dat[6];
    $nro_correlativo = $dat[7];
    $salida_anulada = $dat[8];
    $cod_almacen_destino = $dat[9];
	$nombreCliente=$dat[10];
	$codTipoDoc=$dat[11];
	$razonSocial=$dat[12];
	$nitCli=$dat[13];
    $depositado=$dat['depositado'];
	$montoFactura=number_format($dat['monto_final'],1,'.',',')."0";
    $fechaValidacion=0;
    if($fechaValidacion){
        $fechaValidacion=1;
    }

    $fecha_actual = strtotime(date("Y-m-d H:i:00",time()));
    $fecha_entrada = strtotime($fecha_salida." ".$hora_salida." + 1 days");    
    if($fecha_actual > $fecha_entrada){
        $fechaValidacion=1;     
    }



	$anio_salida=intval("$fecha_salida[0]$fecha_salida[1]$fecha_salida[2]$fecha_salida[3]");
    if(!isset($_COOKIE["globalGestion"])){
      $globalGestionActual= date("Y");  
    }else{
      $globalGestionActual = intval($_COOKIE["globalGestion"]);    
    }
	
    echo "<input type='hidden' name='fecha_salida$nro_correlativo' value='$fecha_salida_mostrar'>";
	
	$sqlEstadoColor="select color from estados_salida where cod_estado='$estado_almacen'";
	$respEstadoColor=mysqli_query($enlaceCon,$sqlEstadoColor);
	$numFilasEstado=mysqli_num_rows($respEstadoColor);
	if($numFilasEstado>0){
		$color_fondo=mysqli_result($respEstadoColor,0,0);
	}else{
        $color_fondo="#ffffff";		
	}	
	$chk = "<input type='checkbox' name='codigo' value='$codigo'>";

	if ($anio_salida != $globalGestionActual) {
        $chk = "";
    }
	
     if(!isset($estado_preparado)){
      $estado_preparado= "";  
    }
    if($codTipoDoc==4){
        $nro_correlativo="<i class='text-danger'>M-$nro_correlativo</i>";
    }else{
        $nro_correlativo="F-$nro_correlativo";
    }

    echo "<input type='hidden' name='estado_preparado' value='$estado_preparado'>";
    //echo "<tr><td><input type='checkbox' name='codigo' value='$codigo'></td><td align='center'>$fecha_salida_mostrar</td><td>$nombre_tiposalida</td><td>$nombre_ciudad</td><td>$nombre_almacen</td><td>$nombre_funcionario</td><td>&nbsp;$obs_salida</td><td>$txt_detalle</td></tr>";
    echo "<tr>";
    echo "<td align='center'>&nbsp;$chk</td>";
    echo "<td align='center'><b>$nro_correlativo</b></td>";
    echo "<td align='center'>$fecha_salida_mostrar $hora_salida</td>";
    echo "<td>$nombre_tiposalida</td>";
    echo "<td align='right'><b>$montoFactura</b></td>";
    echo "<td>&nbsp;$nombreCliente</td><td>&nbsp;$razonSocial</td><td>&nbsp;$nitCli</td><td>&nbsp;P-$codigo</td>";
    $url_notaremision = "navegador_detallesalidamuestras.php?codigo_salida=$codigo";    
    
	/*echo "<td bgcolor='$color_fondo'><a href='javascript:llamar_preparado(this.form, $estado_preparado, $codigo)'>
		<img src='imagenes/icon_detail.png' width='30' border='0' title='Detalle'></a></td>";
	*/
    $codTarjeta=$dat['cod_tipopago'];
    if($codTarjeta==2){
        echo "<td class='text-primary'><b>Tarjeta</b></td>";
    }else{
        echo "<td class='text-success'><b>Efectivo</b></td>";
    }    
	if($codTipoDoc==1){
        $htmlTarjeta="";
      if($fechaValidacion==0&&$salida_anulada!=1&&$estado_almacen==1){
        if($codTarjeta==1){            
            $htmlTarjeta="<a href='#' class='btn btn-default btn-fab btn-sm' title='Relacionar Tarjeta' onclick='mostrarRegistroConTarjeta($codigo);return false;'><i class='material-icons'>credit_card_off</i></a>";            
        }else{
            $htmlTarjeta="<a href='#' class='btn btn-primary btn-fab btn-sm' title='Quitar Tarjeta' onclick='removerRegistroConTarjeta($codigo);return false;'><i class='material-icons'>credit_card</i></a>"; 
        }          
      }  
		echo "<td  bgcolor='$color_fondo'>$htmlTarjeta<a href='formatoFactura.php?codVenta=$codigo' target='_BLANK'><img src='imagenes/factura1.jpg' width='30' border='0' title='Factura Formato Pequeño'></a>";
		echo "</td>";
        /*<a href='formatoFacturaExtendido.php?codVenta=$codigo' target='_BLANK'><img src='imagenes/factura1.jpg' width='30' border='0' title='Factura Extendida'></a>*/
	}else{
		echo "<td  bgcolor='$color_fondo'><a href='formatoFactura.php?codVenta=$codigo' target='_BLANK'><img src='imagenes/factura1.jpg' width='30' border='0' title='Factura Formato Pequeño'></a></td>";
	}
	
	/*echo "<td  bgcolor='$color_fondo'><a href='notaSalida.php?codVenta=$codigo' target='_BLANK'><img src='imagenes/factura1.jpg' width='30' border='0' title='Factura Formato Grande'></a></td>";*/
	
	echo "</tr>";
}
echo "</table></center><br>";
echo "</div>";

echo "<div class=''>
		<input type='button' value='Registrar' name='adicionar' class='btn btn-primary' onclick='enviar_nav()'>
        
		<input type='button' value='Buscar' class='btn btn-info' onclick='ShowBuscar()'></td>";
        //<input type='button' value='Editar' class='btn btn-primary' onclick='editar_salida(this.form)'>	
if($anulacionCodigo==1){
	echo "<input type='button' value='Anular' class='btn btn-danger' onclick='anular_salida(this.form)'>";
}else{
	echo "<input type='button' value='Anular' class='btn btn-danger' onclick='anular_salida2(this.form)'>";	
}
    echo "</div>";
	
echo "</form>";

?>

<div id="divRecuadroExt" style="background-color:#666; position:absolute; width:800px; height: 500px; top:30px; left:150px; visibility: hidden; opacity: .70; -moz-opacity: .70; filter:alpha(opacity=70); -webkit-border-radius: 20px; -moz-border-radius: 20px; z-index:2;">
</div>

<div id="divProfileData" style="background-color:#FFF; width:750px; height:450px; position:absolute; top:50px; left:170px; -webkit-border-radius: 20px; 	-moz-border-radius: 20px; visibility: hidden; z-index:2;">
  	<div id="divProfileDetail" style="visibility:hidden; text-align:center">
		<h2 align='center' class='texto'>Buscar Ventas</h2>
		<table align='center' class='texto'>
			<tr>
				<td>Fecha Ini(dd/mm/aaaa)</td>
				<td>
				<input type='text' name='fechaIniBusqueda' id="fechaIniBusqueda" class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Fecha Fin(dd/mm/aaaa)</td>
				<td>
				<input type='text' name='fechaFinBusqueda' id="fechaFinBusqueda" class='form-control'>
				</td>
			</tr>
			<tr>
				<td>Nro. de Factura</td>
				<td>
				<input type='number' name='nroCorrelativoBusqueda' id="nroCorrelativoBusqueda" class='form-control'>
				</td>
			</tr>
            <tr>
                <td>Nro. de Proceso</td>
                <td>
                <input type='number' name='nroProcesoBusqueda' id="nroProcesoBusqueda" class='form-control' onkeypress="return pressEnter(event, this.form);" onkeyup="return pressEnter(event, this.form);">
                </td>
            </tr>			
			<tr>
				<td>Cliente:</td>
				<td>
					<select name="clienteBusqueda" class="selectpicker form-control" id="clienteBusqueda">
						<option value="0">Todos</option>
					<?php
						$sqlClientes="select c.`cod_cliente`, c.`nombre_cliente` from clientes c order by 2";
						$respClientes=mysqli_query($enlaceCon,$sqlClientes);
						while($datClientes=mysqli_fetch_array($respClientes)){
							$codCliBusqueda=$datClientes[0];
							$nombreCliBusqueda=$datClientes[1];
					?>
							<option value="<?php echo $codCliBusqueda;?>"><?php echo $nombreCliBusqueda;?></option>
					<?php
						}
					?>
					</select>
				
				</td>
			</tr>			

			<tr>
				<td>Ver:</td>
				<td>
				<select name='verBusqueda' id='verBusqueda' class='selectpicker form-control' >
					<option value='0'>Todo</option>
					<option value='1'>No Cancelados</option>
                    <option value='2'>Anulados</option>
				</select>
				</td>
			</tr>			
		</table>	
		<center>
			<input type='button' class='btn btn-warning' value='Buscar' onClick="ajaxBuscarVentas(this.form)">
			<input type='button' class='btn btn-danger' value='Cancelar' onClick="HiddenBuscar()">
			
		</center>
	</div>
</div>

        <script type='text/javascript' language='javascript'>
        </script>
        <div id="pnldlgfrm"></div>
        <div id="pnldlgSN"></div>
        <div id="pnldlgAC"></div>
        <div id="pnldlgA1"></div>
        <div id="pnldlgA2"></div>
        <div id="pnldlgA3"></div>
        <div id="pnldlgArespSvr"></div>
        <div id="pnldlggeneral"></div>
        <div id="pnldlgenespera"></div>


<!-- small modal -->
<div class="modal fade modal-primary" id="modalAnularFactura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content card">
                <div class="card-header card-header-danger card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">delete</i>
                  </div>
                  <h4 class="card-title text-danger font-weight-bold">Anulación de Facturas</h4>
                  <button type="button" class="btn btn-danger btn-sm btn-fab float-right" data-dismiss="modal" aria-hidden="true" style="position:absolute;top:0px;right:0;">
                    <i class="material-icons">close</i>
                  </button>
                </div>
                <input type="hidden" name="codigo_salida" id="codigo_salida" value="0">
                <div class="card-body" id="datos_anular">
                   
                </div>
                <div class="card-footer">
                   <button class="btn btn-default" onclick="confirmarCodigo()">ANULAR</button>
                   <?php 
                    if($_COOKIE["global_usuario"]==-1){
                       ?><input type="password" id="contrasena_admin" value="" class='form-control' style='background: #5DFF00;color:#000;' placeholder='pass_admin' size='50'><a class="btn btn-primary btn-sm btn-fab" style='background:#100F0F;color:#5DFF00;' href="#" onclick="obtenerCodigoGenerado(); return false;"><i class='material-icons'>lock</i></a><?php 
                    }
                   ?>                   
                </div>
      </div>  
    </div>
  </div>
<!--    end small modal -->


<!-- small modal -->
<div class="modal fade modal-primary" id="modalPagoTarjeta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content card">
               <div class="card-header card-header-primary card-header-icon">
                  <div class="card-icon" style="background: #96079D;color:#fff;">
                    <i class="material-icons">credit_card</i>
                  </div>
                  <h4 class="card-title text-dark font-weight-bold">Pago con Tarjeta <small id="titulo_tarjeta"></small></h4>
                  <button type="button" class="btn btn-danger btn-sm btn-fab float-right" data-dismiss="modal" aria-hidden="true" style="position:absolute;top:0px;right:0;">
                    <i class="material-icons">close</i>
                  </button>
                </div>
                <div class="card-body">
                    <input type="hidden" id="codigo_salida_tarjeta">
<div class="row">
    <div class="col-sm-12">
                 <div class="row">
                  <label class="col-sm-3 col-form-label">Banco</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <select class="selectpicker form-control" name="banco_tarjeta" id="banco_tarjeta" data-style="btn btn-success" data-live-search="true">                       
                          <?php echo "$cadComboBancos"; ?>
                          <option value="0">Otro</option>
                       </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-3 col-form-label">Numero <br>Tarjeta</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <input class="form-control" type="text" style="background: #D7B3D8;" id="nro_tarjeta" name="nro_tarjeta" value="" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-3 col-form-label">Monto <br>Tarjeta</label>
                  <div class="col-sm-9">
                    <div class="form-group">
                      <input class="form-control" type="number" style="background: #A5F9EA;" id="monto_tarjeta" name="monto_tarjeta" value=""/>
                    </div>
                  </div>
                </div>                
                <br><br>
       </div>
</div>                

                </div>
                <div class="card-footer">
                    <a href="#" onclick="guardarTarjetaVenta();return false;" class="btn btn-default btn-sm">GUARDAR</a>
                </div>
      </div>  
    </div>
  </div>
<!--    end small modal -->


    </body>
</html>
