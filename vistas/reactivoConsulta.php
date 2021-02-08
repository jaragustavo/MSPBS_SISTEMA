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
                <h1 class="box-title">Pedido Reactivo Consulta</h1>
              </div>


              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th scope="col" style="width:90px">Opciones</th>
                    <th>Código</th>
                    <th>Fecha Pedido</th>
                    <th>Establecimiento</th>
                    <th>Simese</th>
                    <th>Nro.Nota</th>
                    <th>Estado</th>        
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Código</th>
                    <th>Fecha Pedido</th>
                    <th>Establecimiento</th>
                    <th>Simese</th>
                    <th>Nro.Nota</th>
 <th>Estado</th>
                  </tfoot>
                </table>
              </div>

              <div class="panel-body" style="height: 500%;" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="row" id="divPedido" style="font-size: 13px;">
                    <div class="col-md-12">
                      <div class="row" style="margin-left:2%">
                        <div class="col-md-6" id="divCodigo">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Código</label>
                            </div>
                            <div class="col-md-8">
                              <input id="codigo" name="codigo" type="text" class="form-control input-sm" placeholder="Codigo" disabled="true" style="text-transform:uppercase;">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Fecha Pedido</label>
                            </div>
                            <div class="col-md-8 ">
                              <div class="input-group date">
                                <input class="datepicker" id="fecha_pedido" name="fecha_pedido" placeholder="Seleccione la Fecha">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Nro.Nota</label>
                            </div>
                            <div class="col-md-4">
                              <input id="numero_nota" name="numero_nota" type="text" class="form-control input-sm" placeholder="Número Nota Interna" style="text-transform:uppercase;">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row" style="margin-left:2%">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Nro.Simese</label>
                            </div>
                            <div class="col-md-4">
                              <input id="numero_expediente" name="numero_expediente" type="text" class="form-control input-sm" placeholder="Número Simese" style="text-transform:uppercase;">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4">
                              <label>Establecimiento</label>
                            </div>
                            <div class="col-md-6">
                              <select id="codigo_sucursal" name="codigo_sucursal" class="form-control selectpicker" data-live-search="true">
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row" style="margin-left:2%">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Obs</label>
                            </div>
                            <div class="col-md-6">
                              <textarea input id="obs" name="obs" type="text" class="form-control input-sm" placeholder="Ingrese observación" style="text-transform:uppercase;"></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4" id="divDocPedido">
                              <label>Adjuntar Documento</label>
                              <input type="file" class="form-control" name="imagen" id="imagen">
                              <input type="hidden" name="imagenactual" id="imagenactual">
                            </div>
                            <div class="col-md-4" id="divDocPedidoEnvio">
                              <label>Documento del Pedido</label>
                            </div>
                            <div class="col-md-8">
                              <iframe src="" width="100px" height="100px" name="imagenmuestra" id="imagenmuestra" onclick="openTab(this)" href="#"></iframe>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Estado -->
                      <div class="row">
                        <div class="form-group row" id="divEstado">
                          <div class="col-md-4 derecha">
                            <label>Estado</label>
                          </div>
                          <div class="col-md-8">
                            <select id="codigo_estado" name="codigo_estado" class="form-control selectpicker" data-live-search="true">
                            </select>
                          </div>
                        </div>
                      </div>
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
                  <div class="row">
                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                      <a data-toggle="modal" href="#myModal">
                        <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span> Agregar Producto</button>
                      </a>
                    </div>
                  </div>

                  <div class="col-lg-12">
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style="overflow: scroll; display: inline-block; table-layout: fixed; width: 100%;">
                      <thead style="background-color:#A9D0F5;">
                        <th></th>
                        <th>Código</th>
                        <th>Código Catalogo</th>
                        <th>Descripción Producto</th>
                        <th>Especificación Técnica</th>
                        <th>Presentación</th>
                        <th>Presentación Entrega</th>
                        <th>Und.Medida</th>
                        <th>Precio Ref.</th>
                        <th>Cantidad</th>
                        <th>Observación</th>
                      </thead>
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
      <div class="modal-dialog" style="width: 80% !important; font-size: 13px;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Seleccione un Producto</h4>
          </div>
          <div class="modal-body">
            <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover" style="font-size: 10px;">
              <thead>
                <th scope="col">
                  <div style="width: 30px;text-align: center;">Opc.</div>
                </th>
                <th scope="col">
                  <div style="width: 50px;text-align: center;">Cod. Siciap</div>
                </th>
                <th scope="col">
                  <div style="width: 60px;text-align: center;">Cod. Catalogo</div>
                </th>
                <th scope="col">
                  <div style="width: 130px;text-align: center;">Descripción Producto</div>
                </th>
                <th scope="col">
                  <div style="width: 180px;text-align: center;">Especificación Técnica</div>
                </th>
                <th scope="col">
                  <div style="width: 80px;text-align: center;">Presentación</div>
                </th>

              </thead>
              <tbody scope="col">

              </tbody>
              <tfoot>
                <th scope="col">
                  <div style="width: 30px;text-align: center;">Opc.</div>
                </th>
                <th scope="col">
                  <div style="width: 50px;text-align: center;">Cod. Siciap</div>
                </th>
                <th scope="col">
                  <div style="width: 60px;text-align: center;">Cod. Catalogo</div>
                </th>
                <th scope="col">
                  <div style="width: 130px;text-align: center;">Descripción Producto</div>
                </th>
                <th scope="col">
                  <div style="width: 180px;text-align: center;">Especificación Técnica</div>
                </th>
                <th scope="col">
                  <div style="width: 70px;text-align: center;">Presentación</div>
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
  <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script type="text/javascript" src="scripts/reactivoConsulta.js"></script>
<?php
}
ob_end_flush();
?>