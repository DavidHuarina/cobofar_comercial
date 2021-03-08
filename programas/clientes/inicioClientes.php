<?php
$estilosVenta=1;
?>
<html>
    <head>
        <title>Clientes</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="../../lib/css/paneles.css"/>
        <script type="text/javascript" src="../../dist/bootstrap/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="../../dist/bootstrap/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../../lib/js/xlibPrototipo-v0.1.js"></script>       
        <script type='text/javascript' language='javascript'>
/*proceso inicial*/
$(document).ready(function() {
    //
    listadoClientes();
    //
});
/*proceso inicial*/
function listadoClientes() {
     cargarPnl("#pnl00","prgListaClientes.php");
}
//procesos
function frmAdicionar() {
     location.href="frmClienteAdicionar.php";
}
function frmModificar() {
    var total=$("#idtotal").val();
    var tag,sel,cod,c=0;
    for(var i=1;i<=total;i++) {
        if(document.getElementById("idchk"+i).checked == 1){
           cod=document.getElementById("idchk"+i).value;
           c++;
        }   
    }
    if(c==1) {
        location.href="frmClienteEditar.php?codcli="+cod;
        //cargarPnl("#pnl00","frmClienteEditar.php","codcli="+cod);
    } else if(c>1) {
        alert("Seleccione solo un elemento para editar.");
    } else {
        alert("Seleccione un elemento para editar.");
    }
}
function frmEliminar() {
    var total=$("#idtotal").val();
    var tag,sel,cods="0",c=0;
    for(var i=1;i<=total;i++) {
         if(document.getElementById("idchk"+i).checked == 1){
           cods=cods+","+document.getElementById("idchk"+i).value;
           c++;
        } 
    }
    if(c>0) {
        if(confirm("Esta seguro de eliminar "+c+" elemento(s) ?")) {
            eliminarCliente(cods);
        }
    } else {
        alert("Seleccione para eliminar.");
    }
}
function adicionarCliente() {
    var nomcli = $("#nomcli").val();
    var apcli = $("#apcli").val();
    var ci = $("#ci").val();
    var nit = $("#nit").val();
    var dir = $("#dir").val();
    var tel1 = $("#tel1").val();
    var mail = $("#mail").val();
    var area = $("#area").val();
    var fact = $("#fact").val();
    var edad = $("#edad").val();
    var genero = $("#genero").val();
    var parms="nomcli="+nomcli+"&nit="+nit+"&ci="+ci+"&dir="+dir+"&tel1="+tel1+"&mail="+mail+"&area="+area+"&fact="+fact+"&edad="+edad+"&apcli="+apcli+"&genero="+genero+"";
    cargarPnl("#pnl00","prgClienteAdicionar.php",parms);
}
function modificarCliente() {
    var codcli = $("#codcli").text();
    var nomcli = $("#nomcli").val();
    var nit = $("#nit").val();
    var dir = $("#dir").val();
    var tel1 = $("#tel1").val();
    var mail = $("#mail").val();
    var area = $("#area").val();
    var fact = $("#fact").val();
    var parms="codcli="+codcli+"&nomcli="+nomcli+"&nit="+nit+"&dir="+dir+"&tel1="+tel1+"&mail="+mail+"&area="+area+"&fact="+fact+"";
    cargarPnl("#pnl00","prgClienteModificar.php",parms);
}
function eliminarCliente(cods) {
    var codcli = cods;
    var parms="codcli="+codcli+"";
    cargarPnl("#pnl00","prgClienteEliminar.php",parms);
}
        </script>
    </head>
    <body>
        <div id='pnl00'></div>
        <div id='pnldlgfrm'></div>
        <div id='pnldlggeneral'></div>
        <div id='pnldlgenespera'></div>
    </body>
</html>

<?php
if(isset($_GET['registrar'])){
    ?><script>frmAdicionar()</script><?php
}

?>
