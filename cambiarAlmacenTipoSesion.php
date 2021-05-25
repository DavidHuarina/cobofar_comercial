<?php

require_once 'conexionmysqli.inc';

$globalTipo=$_COOKIE['global_tipo_almacen'];
$global_agencia=$_COOKIE['global_agencia'];
?>

              <form id="form1" class="form-horizontal" action="saveTipoAgencia.php" method="post">
              <div class="card">
                <div class="card-header card-header-icon">
                  <CENTER><h4 class="card-title"><b>Cambiar Tipo Agencia</b></h4></CENTER>
                </div>
                
                <div class="card-body">
                  <div class="">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Tipo Agencia</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td align="center">                            
                               <select name="tipo_almacen" id="tipo_almacen" class="selectpicker" data-style="btn btn-primary" data-show-subtext="true" data-live-search="true" required>

                              <option disabled selected value="">--SELECCIONE UNA TIPO--</option>
                              <?php
                               $sql="select t.codigo, t.nombre, t.abreviatura from tipos_almacenes t where t.estado=1 and t.codigo in (SELECT cod_tipoalmacen from almacenes where cod_ciudad='$global_agencia') order by 1";
                               $resp=mysqli_query($enlaceCon,$sql);
                               while($dat=mysqli_fetch_array($resp)){
                                 $codigo=$dat[0];
                                 $nombre=$dat[1];
                                 if($codigo==$globalTipo){
                                   echo "<option value='$codigo' selected>$nombre</option>";
                                 }else{
                                   echo "<option value='$codigo'>$nombre</option>";
                                 }
                               }

                              
                                ?>
                            </select>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="card-body">
                    <button type="submit" class="btn btn-warning">Guardar</button>
              </div>
               </form>

