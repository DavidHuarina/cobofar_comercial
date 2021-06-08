<?php
ini_set('memory_limit','1G');
set_time_limit(0);

header("Pragma: public");
header("Expires: 0");
$filename = "datos_market.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

require_once __DIR__.'/../conexion_externa_farma.php';
error_reporting(0);
$estilosVenta=1;
require_once '../function_web.php';

?>
<table border="1">
  <thead>
    <tr>
        <th style='background: #EFDCA2 !important;font-weight: bold;' colspan="7">PRODUCTOS VENTAS Y SALDO</th>
    </tr>
    <tr>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Sucursal</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Codigo</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Descripcion</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Div</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Saldo</th>
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Tipo</th> 
        <th style='background: #EFDCA2 !important;font-weight: bold;'>Precio</th> 
</tr>
   </thead>
<?php
$listAlma=obtenerListadoAlmacenes();//obtenerListadoAlmacenes();//obtenerListadoAlmacenesEspecifico("Aà");//obtenerListadoAlmacenes();
foreach ($listAlma->lista as $alma) {
      $age1=$alma->age1;
      $nombre=$alma->des;
      $ip=$alma->ip;
      $dbh = ConexionFarma($ip,"Gestion");

/*$sql="SELECT D.CPROD,P.DES,SUM(D.INGRESO)-SUM(D.SALIDA) AS SALDOS,D.TIPO,S.PRECIOVENT,S.PRECIOCOMP,S.PRECIOCOSTO, S.PRECIOUNIT PRECIO,O.DES PROVEEDOR, P.DIV, P.SICO, P.CANENVASE, O.DESCTO 
FROM VSALDOS D JOIN APRODUCTOS P ON P.CPROD=D.CPROD
GROUP BY D.CPROD,P.DES,D.TIPO;";*/
$sql="SELECT D.CPROD,P.DES,SUM(D.INGRESO)-SUM(D.SALIDA) AS SALDOS,D.TIPO, D.PRECIOUNIT PRECIO, P.DIV, P.SICO, P.CANENVASE, O.DESCTO,
      (D.PRECIOUNIT-(D.PRECIOUNIT*(O.DESCTO/100)))PRECIO1      
FROM VSALDOS D JOIN APRODUCTOS P ON P.CPROD=D.CPROD
JOIN PROVEEDORES O ON P.IDPROVEEDOR=O.IDPROVEEDOR
WHERE P.CPROD IN (3762  ,
6890  ,
21573 ,
23844 ,
99185 ,
2663  ,
5792  ,
5793  ,
6338  ,
6339  ,
8059  ,
8140  ,
9340  ,
12563 ,
2669  ,
12803 ,
17141 ,
17142 ,
17143 ,
50028 ,
50030 ,
58463 ,
92251 ,
92252 ,
1826  ,
5835  ,
5836  ,
6363  ,
18157 ,
20379 ,
20661 ,
21210 ,
21723 ,
22729 ,
498 ,
499 ,
892 ,
4241  ,
8669  ,
8889  ,
9339  ,
10935 ,
11934 ,
11935 ,
13547 ,
22327 ,
22337 ,
23409 ,
23410 ,
24859 ,
25115 ,
25620 ,
25800 ,
26785 ,
27938 ,
58030 ,
58358 ,
58367 ,
58980 ,
59033 ,
88732 ,
90649 ,
95905 ,
95906 ,
95907 ,
95908 ,
97887 ,
100910  ,
101174  ,
101274  ,
102416  ,
102512  ,
102417  ,
102440  ,
102513  ,
15150 ,
20033 ,
23505 ,
34135 ,
91400 ,
92571 ,
93985 ,
94502 ,
94647 ,
95144 ,
95378 ,
97222 ,
97292 ,
98044 ,
100394  ,
101224  ,
102086  ,
102453  ,
102454  ,
22365 ,
22579 ,
24629 ,
26035 ,
26832 ,
59000 ,
88897 ,
95437 ,
95434 ,
96767 ,
96869 ,
98650 ,
99003 ,
99004 ,
100181  ,
100811  ,
101103  ,
102510  ,
6315  ,
6316  ,
15398 ,
20654 ,
20655 ,
21997 ,
22507 ,
23101 ,
27024 ,
27422 ,
89963 ,
90159 ,
90267 ,
90298 ,
90299 ,
91325 ,
91459 ,
91647 ,
93318 ,
94195 ,
95941 ,
96893 ,
98223 ,
98359 ,
98970 ,
100692  ,
102084  ,
102087)
GROUP BY D.CPROD,P.DES,D.TIPO,D.PRECIOUNIT, P.DIV, P.SICO, P.CANENVASE, O.DESCTO ;
";
//echo $sql;
if($dbh!=false){
$stmt = $dbh->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
   $cod_prod=$row['CPROD'];
   $des_prod=$row['DES'];
   $saldos=$row['SALDOS'];
   $tipo=$row['TIPO'];
   $div=$row['CANENVASE']; 
   $precio=$row['PRECIO1'];
   if($row['SICO']=="N"){
     $precio=$precio-($precio*(7/100));
   } 
       ?><tr>
          <td class='font-weight-bold'><?=$nombre?></td>
          <td><?=$cod_prod?></td>
          <td><?=$des_prod?></td>
          <td><?=$div?></td>
          <td><?=$saldos?></td>
          <td><?=$tipo?></td>
          <td><?=number_format($precio,2,'.','')?></td>
        </tr><?php
      }
 }
}

?>
  </table>
