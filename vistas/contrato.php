<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();


if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';
  if ($_SESSION['reactivoPedido'] == 1) {
?>


    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Resolucion <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle">
                    </i> Agregar</button></h1>
              </div>
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th scope="col" style="width:90px">Opciones</th>
                     <th>Orden</th>
                     <th>Objeto Gasto</th>
                     <th>Nro Documento</th>
                     <th>Nombre.Apellido</th>
                     <th>Funcion</th>
                     <th>Region Sanitaria</th>
                     <th>Lugar</th>
                     <th>Monto</th>
                     <th>Carga Horaria</th>
                     <th>Nro Expediente</th>
                     <th>Tipo Resolucion</th>
                     <th>Concepto</th>
                     <th>Especialidad</th>
                     <th>Estado</th>
                    <!--
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th> 
                     <th>SINAR</th> 
                     -->
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                     <th scope="col" style="width:90px">Opciones</th>
                     <th>Orden</th>
                     <th>Objeto Gasto</th>
                     <th>Nro Documento</th>
                     <th>Nombre.Apellido</th>
                     <th>Funcion</th>
                     <th>Region Sanitaria</th>
                     <th>Lugar</th>
                     <th>Monto</th>
                     <th>Carga Horaria</th>
                     <th>Nro Expediente</th>
                     <th>Tipo Resolucion</th>
                     <th>Concepto</th>
                     <th>Especialidad</th>
                     <th>Estado</th>
                    <!--
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th> 
                     <th>SINAR</th> 
                    -->
                   
                  </tfoot>
                </table>
              </div>

              <div class="panel-body" style="height: 500%;" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="row" id="divDetalle" style="font-size: 12px;">
                    <div class="col-md-12">
                      <div class="row" style="margin-left:2%">
                         <div class="col-md-3">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Nro.Expediente</label>
                            </div>
                            <div class="col-md-7">
                                <input id="codigo" name="codigo" type="hidden" > 
                                <input id="fecha" name="fecha" type="hidden" > 
                                <input id="nro_expediente" name="nro_expediente" type="text" class="form-control input-sm" placeholder="Número Expediente">
                            </div>
                          </div>
                        </div>   
                        <div class="col-md-4">
                          <div class="form-group row">
                            <div class="col-md-3">
                              <label>Dependencia Pedido</label>
                            </div>
                            <div class="col-md-9">
                              <select id="codigo_dependencia" name="codigo_dependencia" class="form-control selectpicker" data-live-search="true">
                              </select>
                            </div>
                          </div>
                        </div>     
                                             
                      </div>
                      <div class="row" style="margin-left:2%">
                        <div class="col-md-4">
                          <div class="form-group row">
                            <div class="col-md-3">
                              <label>Tipo resolucion</label>
                            </div>
                            <div class="col-md-9">
                              <select id="codigo_tipo_resolucion" name="codigo_tipo_resolucion" class="form-control selectpicker" data-live-search="true">
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                            <div class="col-md-3">
                              <label>Concepto</label>
                            </div>
                            <div class="col-md-9">
                              <select class = "codigo_tipo_resolucion_concepto" id="codigo_tipo_resolucion_concepto" name="codigo_tipo_resolucion_concepto" class="form-control selectpicker" data-live-search="true">
                              </select>
                            </div>
                          </div>
                        </div>  
                          <div class="resultado"></div>
                     
                      </div>
                  
                       <div class="row" style="margin-left:2%" id="divAdjuntarPlanilla">
                            <div class="col-md-6">
                            <div class="form-group row">
                              <div class="col-md-4" id="divDocLlamado">
                                <label>Adjuntar Planilla</label>
                                <input type="file" class="form-control" name="imagen" id="imagen">
                                <input type="hidden" name="imagenactual" id="imagenactual">
                              </div>
                              <div class="col-md-8">
                                <iframe src="" width="50px" height="50px" name="imagenmuestra" id="imagenmuestra" onclick="openTab(this)" href="#"></iframe>
                                <br><br>
                                 
                                      <button id="btnCargarPersona" onclick="cargarArchivoCsv()" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span> Cargar Archivo</button>
                                
                               
                              </div>
                             
                            </div>
                            <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                
                               
                            </div> 
                          </div>
                          
                           
                           
                       </div>    
                   

                  
                  <div class="row">
                    
                        <div class="col-md-3" class="divCic" id="divCic">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Nro.Cedula</label>
                            </div>
                            <div class="col-md-7">
                                <input id="nro_cedula" name="nro_cedula" type="text" class="form-control input-sm" placeholder="Nro.Cedula">
                            </div>
                          </div>
                        </div>   
                      <div class="col-md-3" class="divReemplazante" id="divReemplazante">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Nro.Cedula Reemplazante</label>
                            </div>
                            <div class="col-md-7">
                                <input id="nro_cedula_reemplazante" name="nro_cedula_reemplazante" type="text" class="form-control input-sm" placeholder="Nro.Cedula Reemplazante">
                            </div>
                          </div>
                        </div>   
                      <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
               <!--       <a data-toggle="modal" href="#myModal"> -->
                          <button id="btnAgregarPersona" onclick="agregarPersona()" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span> Agregar</button>
                 <!--      </a>   -->
                    </div>
                  </div>
                  <div class="row" id="divEnvio">
                    <div class="form-group col-md-11 box-header with-border" style="margin-left:2%; border-bottom: 3px solid mediumaquamarine">
                      <h4 style="font-weight: bold;">Datos del Envio</h4>
                    </div>
                    <div class="form-group col-md-8" style="font-size: 13px;">
                      <div class="row" style="margin-left:2%">
                        <div class="col-md-6">
                          <div class="form-group row" id="divAdjDocEnvio">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-md-12 ">
                                  <label>Documento de Envio</label>
                                  <input type="file" class="form-control" name="imagenEnvio" id="imagenEnvio">
                                  <input type="hidden" name="imagenactualEnvio" id="imagenactualEnvio">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group row">
                                <div class="col-md-3">
                                  <iframe src="" width="100px" height="100px" name="imagenmuestraEnvio" id="imagenmuestraEnvio" onclick="openTab(this)" href="#"></iframe>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Destinatario</label>
                            </div>
                            <div class="col-md-8">
                              <select id="destinatario" name="destinatario" class="form-control selectpicker" data-live-search="true">
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row" style="margin-left:2%">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Obs. Envio</label>
                            </div>
                            <div class="col-md-8">
                              <textarea input id="obs_envio" name="obs_envio" type="text" class="form-control input-sm" placeholder="Ingrese observación" style="text-transform:uppercase;"></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row" id="divEstadoEnvio">
                            <div class="col-md-4 derecha">
                              <label>Estado</label>
                            </div>
                            <div class="col-md-8">
                              <select id="codigo_estado_envio" name="codigo_estado_envio" class="form-control selectpicker" data-live-search="true">
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-4" id="divLugarEnvio">
                      <div class="col-md-12" style=" align-content: center;">
                        <div class="form-group row">
                          <label style="margin-left: 2%; text-decoration: underline;">Enviar Copia a:</label>
                          <ul style="list-style: none;" id="lugar_envio">
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-11 box-header with-border" style="margin-left:2%; border-bottom: 3px solid mediumaquamarine">
                    </div>
                  </div>      
                 
                  <div class="col-lg-12">
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style="overflow: scroll; display: inline-block; table-layout: fixed; width: 100%;">
            <!--     <thead style="background-color:#A9D0F5"  scope="col">
                                    <th scope="col"><div style="width: 15px;text-align: center; font-size: 80%;"></div></th>
                                    <th scope="col"><div style="width: 20px;text-align: center; font-size: 80%;">Item</div></th>
                                    <th scope="col"><div style="width: 50px;text-align: center; font-size: 80%;">Nro.Doc.</div></th>
                                    <th scope="col"><div style="width: 120px;text-align: center; font-size: 80%;">Nombre y Apellido</div></th>
                                    <th scope="col"><div style="width: 40px;text-align: center; font-size: 80%;">Obj.Gasto</div></th>
                                     <th scope="col"><div style="width: 40px;text-align: center; font-size: 80%;">Vin.</div></th>
                                     <th scope="col"><div style="width: 45px;text-align: center; font-size: 80%;">Carga Horaria</div></th>
                                    <th scope="col"><div style="width: 60px;text-align: center; font-size: 80%;">Monto</div></th>
                                 
                                  <th scope="col"><div style="width:50px;text-align: center; font-size: 80%;">Función</div></th>
                                  <th scope="col"><div style="width: 60px;text-align: center; font-size: 80%;">Espec.</div></th>
                                   <th scope="col"><div style="width: 50px;text-align: center; font-size: 80%;">Region</div></th>
                                    <th scope="col"><div style="width: 50px;text-align: center; font-size: 80%;">Depen.</div></th>
                                   <th scope="col"><div style="width: 50px;text-align: center; font-size: 80%;">Estado</div></th> 
                                 
                               <!--     
                                   
                                     <th scope="col"><div style="width: 100px;text-align: center; font-size: 80%;">Sinar</div></th>
                                      
                                       <th scope="col"><div style="width: 100px;text-align: center; font-size: 80%;">Observacion</div></th>
                              
                            </thead>
                 -->
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                    
                 
                                  
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>Guardar</button>
                    <button class="btn btn-primary" onclick="enviar()" id="btnEnviar" type="button"><i class="fa fa-paper-plane"></i>Enviar</button>
                    <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>

                  </div>


                </form>
                <!--Fin centro -->
              </div>

            </div><!-- /.box -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <!-- <div class= "modal-dialog modal-lg" role="document"> -->
      <div class="modal-dialog" style="width: 50% !important; font-size: 13px;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Seleccione la Persona</h4>
          </div>
          <div class="modal-body">
            <table id="tblpersonas" class="table table-striped table-bordered table-condensed table-hover" style="font-size: 12px;">
              <thead>
                <th scope="col">
                  <div style="width: 30px;text-align: center;">Opc.</div>
                </th>
                <th scope="col">
                  <div style="width: 60px;text-align: center;">Nro.Documento</div>
                </th>
                <th scope="col">
                  <div style="width:90px;text-align: center;">Nombre</div>
                </th>
                 <th scope="col">
                  <div style="width: 90px;text-align: center;">Apellido</div>
                </th>

              </thead>
              <tbody scope="col">

              </tbody>
              <tfoot>
                <th scope="col">
                  <div style="width: 30px;text-align: center;">Opc.</div>
                </th>
                <th scope="col">
                  <div style="width: 90px;text-align: center;">Nro.Documento</div>
                </th>
                  <th scope="col">
                  <div style="width: 90px;text-align: center;">Nombre</div>
                </th>
                 <th scope="col">
                  <div style="width: 90px;text-align: center;">Apellido</div>
                </th>
              </tfoot>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
   <!-- Fin modal Reactivo Producto -->
   
   
    <!-- Modal Movimiento Pedido-->
    <div class="modal fade" id="modalMovimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <!-- <div class= "modal-dialog modal-lg" role="document"> -->
      <div class="modal-dialog" style="width: 80% !important; font-size: 13px;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Detalle Movimientos</h4>
          </div>
          <div class="modal-body">
            <table id="tblmovimientos" class="table table-striped table-bordered table-condensed table-hover" style="font-size: 10px;">
              <thead>
                <th scope="col">
                  <div style="width: 30px;text-align: center;"></div>
                </th>
                <th scope="col">
                  <div style="width: 50px;text-align: center;">Fecha de Envio</div>
                </th>
                <th scope="col">
                  <div style="width: 60px;text-align: center;">Usuario que Envio</div>
                </th>
                <th scope="col">
                  <div style="width: 130px;text-align: center;">Tiempo de Proceso</div>
                </th>
                <th scope="col">
                  <div style="width: 180px;text-align: center;">Estado</div>
                </th>
                <th scope="col">
                  <div style="width: 80px;text-align: center;">Obs Enviada</div>
                </th>
                 <th scope="col">
                  <div style="width: 80px;text-align: center;">Destinatario</div>
                </th>

              </thead>
              <tbody scope="col">

              </tbody>
              <tfoot>
               <th scope="col">
                  <div style="width: 30px;text-align: center;"></div>
                </th>
                <th scope="col">
                  <div style="width: 50px;text-align: center;">Fecha de Envio</div>
                </th>
                <th scope="col">
                  <div style="width: 60px;text-align: center;">Usuario que Envio</div>
                </th>
                <th scope="col">
                  <div style="width: 130px;text-align: center;">Tiempo de Proceso</div>
                </th>
                <th scope="col">
                  <div style="width: 180px;text-align: center;">Estado</div>
                </th>
                <th scope="col">
                  <div style="width: 80px;text-align: center;">Obs Enviada</div>
                </th>
                 <th scope="col">
                  <div style="width: 80px;text-align: center;">Destinatario</div>
                </th>
              </tfoot>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
   <!-- Fin modal -->
    <!-- Modal vinculo -->
   <div class="modal fade" id="modalVinculo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <!-- <div class= "modal-dialog modal-lg" role="document"> -->
      <div class="modal-dialog" style="width: 50% !important; font-size: 20px;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Detalle Vinculo</h4>
          </div>
          <div class="modal-body">
            <table id="tblvinculo" class="table table-striped table-bordered table-condensed table-hover" style="font-size: 15px;">
              <thead>
                <th scope="col">
                  <div style="width: 0px;text-align: center;"></div>
                </th>
                <th scope="col">
                  <div style="width: 10px;text-align: center;">Tipo Vinculo</div>
                </th>
                <th scope="col">
                  <div style="width: 10px;text-align: center;">Objeto Gasto</div>
                </th>
                <th scope="col">
                  <div style="width: 15px;text-align: center;">Monto</div>
                </th>
                <th scope="col">
                  <div style="width: 15px;text-align: center;">Horas Semanal</div>
                </th>
                <th scope="col">
                  <div style="width: 15px;text-align: center;">Horas Mensual</div>
                </th>
                <th scope="col">
                  <div style="width: 15px;text-align: center;">Frecuencia</div>
                </th>


              </thead>
              <tbody scope="col">

              </tbody>
              <tfoot>
               <th scope="col">
                  <div style="width: 5px;text-align: center;"></div>
                </th>
                <th scope="col">
                  <div style="width:20px;text-align: center;">Tipo Vinculo</div>
                </th>
                <th scope="col">
                  <div style="width: 20px;text-align: center;">Objeto Gasto</div>
                </th>
                <th scope="col">
                  <div style="width: 30px;text-align: center;">Monto</div>
                </th>
                <th scope="col">
                  <div style="width: 15px;text-align: center;">Horas Semanal</div>
                </th>
                <th scope="col">
                  <div style="width: 15px;text-align: center;">Horas Mensual</div>
                </th>
                <th scope="col">
                  <div style="width: 15px;text-align: center;">Frecuencia</div>
                </th>
              </tfoot>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    
     <!-- Modal especialidad persona -->
   <div class="modal fade" id="modalEspecialidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <!-- <div class= "modal-dialog modal-lg" role="document"> -->
      <div class="modal-dialog" style="width: 30% !important; font-size: 20px;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Detalle Especialidad</h4>
          </div>
          <div class="modal-body">
            <table id="tblespecialidad" class="table table-striped table-bordered table-condensed table-hover" style="font-size: 15px;">
              <thead>
                <th scope="col">
                  <div style="width: 0px;text-align: center;"></div>
                </th>
                <th scope="col">
                  <div style="width: 10px;text-align: center;">Codigo</div>
                </th>
                <th scope="col">
                  <div style="width: 10px;text-align: center;">Nro. Registro</div>
                </th>
                <th scope="col">
                  <div style="width: 20px;text-align: center;">Especialidad</div>
                </th>
                


              </thead>
              <tbody scope="col">

              </tbody>
              <tfoot>
              <th scope="col">
                  <div style="width: 0px;text-align: center;"></div>
                </th>
                <th scope="col">
                  <div style="width: 10px;text-align: center;">Codigo</div>
                </th>
                <th scope="col">
                  <div style="width: 10px;text-align: center;">Nro. Registro</div>
                </th>
                <th scope="col">
                  <div style="width: 20px;text-align: center;">Especialidad</div>
                </th>
              </tfoot>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
   
   
  <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script type="text/javascript" src="scripts/contrato.js"></script>
  <script type="text/javascript" src="scripts/util.js"></script>
<?php
}
ob_end_flush();
?>