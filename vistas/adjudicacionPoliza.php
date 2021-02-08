<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();


if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';

  if ($_SESSION['adjudicacion'] == 1) {
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
                <h1 class="box-title">Contratos Polizas<button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                <div class="box-tools pull-right">
                </div>
                <div class="panel-body table-responsive" id="listadoregistros">
                  <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                      <th></th>
                      <th>Numero Contrato</th>
                      <th>Proveedor</th>
                      <th>Llamado</th>
                      <th>Numero Poliza</th>
                      <th>Fecha Inicio</th>
                      <th>Fecha Fin</th>
                      <th>Monto Poliza</th>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                      <th></th>
                      <th>Numero Contrato</th>
                      <th>Proveedor</th>
                      <th>Llamado</th>
                      <th>Numero Poliza</th>
                      <th>Fecha Inicio</th>
                      <th>Fecha Fin</th>
                      <th>Monto Poliza</th>
                    </tfoot>
                  </table>
                </div>
                <!--Formulario Agregar -->
                <div class="panel-body" id="formularioregistros" style="height: 300px">
                  <form name="formulario" id="formulario" method="POST">
                    <input type="hidden" class="form-control" name="codigo" id="codigo">
                    <div class="form-group col-md-12">
                      <div class="row" style="margin-left:2%">
                        <div class="row">
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a data-toggle="modal" href="#myModal">
                              <button id="btnAgregarArt" onclick="listarContrato()" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span> Agregar Producto</button>
                            </a>
                          </div>
                        </div>
                        <!-- Datos del contrato -->
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group row">
                              <div class="col-md-4 derecha">
                                <label for="codigo_contrato">Contrato:</label><br>
                              </div>
                              <div class="col-md-8">
                                <input type="hidden" class="form-control" name="codigo_contrato" id="codigo_contrato" required>
                                <input type="text" class="form-control" name="numero_contrato" id="numero_contrato" required>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group row">
                              <div class="col-md-4 derecha">
                                <label for="llamado">Llamado:</label><br>
                              </div>
                              <div class="col-md-8">
                                <input type="text" class="form-control" name="llamado" id="llamado" required>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group row">
                              <div class="col-md-4 derecha">
                                <label for="proveedor">Proveedor:</label><br>
                              </div>
                              <div class="col-md-8">
                                <input type="text" class="form-control" name="proveedor" id="proveedor" required>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <div class="col-md-4 derecha">
                                <label for="aseguradora">Aseguradora(*):</label><br>
                              </div>
                              <div class="col-md-8">
                                <input type="text" class="form-control" name="aseguradora" id="aseguradora" placeholder="Nombre de Aseguradora" required>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                              <div class="col-md-4 derecha">
                                <label>Numero Poliza:</label>
                              </div>
                              <div class="col-md-4">
                                <input type="text" class="form-control" name="numero_poliza" id="numero_poliza" maxlength="20" placeholder="Numero de poliza" title="Solo numeros" required>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <div class="col-md-4 derecha">
                                <label>Fecha Emision:</label>
                              </div>
                              <div class="col-md-4">
                                <div class="row">
                                  <div class="col-sm-2">
                                    <div class="input-group date">
                                      <input class="datepicker" id="fecha_emision" name="fecha_emision" placeholder="Seleccione la Fecha">
                                      <div class="input-group-addon" id="icon_calendar">
                                        <span class="fa fa-calendar"></span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row" id="divTipo_dias">
                              <div class="col-md-4 derecha">
                                <label for="codigo_tipo_dias">Monto Poliza:</label><br>
                              </div>
                              <div class="col-md-4">
                                <input type="text" class="form-control" name="monto_poliza" id="monto_poliza" placeholder="Monto de la Poliza" title="Solo numeros" required>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <div class="col-md-4 derecha">
                                <label>Fecha Inicio:</label>
                              </div>
                              <div class="col-md-4">
                                <div class="row">
                                  <div class="col-sm-2">
                                    <div class="input-group date">
                                      <input class="datepicker" id="fecha_inicio" name="fecha_inicio" placeholder="Seleccione la Fecha">
                                      <div class="input-group-addon" id="icon_calendar2">
                                        <span class="fa fa-calendar"></span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                              <div class="col-md-4 derecha">
                                <label>Fecha Fin:</label>
                              </div>
                              <div class="col-md-4">
                                <div class="row">
                                  <div class="col-sm-2">
                                    <div class="input-group date">
                                      <input type="hidden" class="form-control" name="fecha_actual" id="fecha_actual" required>
                                      <input class="datepicker" id="fecha_fin" name="fecha_fin" placeholder="Seleccione la Fecha">
                                      <div class="input-group-addon" id="icon_calendar2">
                                        <span class="fa fa-calendar"></span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <div class="col-md-4 derecha">
                                <label for="codigo_tipo_dias">Obs:</label><br>
                              </div>
                              <div class="col-md-8">
                                <textarea input id="obs" name="obs" type="text" class="form-control input-sm" placeholder="Ingrese observación" style="text-transform:uppercase;"></textarea>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row" id="divTipo_dias">
                              <div class="col-md-4 derecha">
                                <label for="codigo_tipo_dias">Estado Poliza:</label><br>
                              </div>
                              <div class="col-md-4">
                                <select id="codigo_estado_poliza" name="codigo_estado_poliza" class="form-control selectpicker" data-live-search="true" required></select>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <div class="col-md-4">
                                <label>Adjuntar Documento</label>
                              </div>
                              <div class="col-md-6">
                                <input type="file" class="form-control" name="imagen" id="imagen">
                                <input type="hidden" name="imagenactual" id="imagenactual">
                              </div>
                              <div class="col-md-2">
                                <iframe src="" width="50px" height="50px" name="imagenmuestra" id="imagenmuestra" onclick="openTab(this)" href="#"></iframe>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <button id="btnEntrega" type="button" class="btn btn-primary" onclick="formularioEntrega()"> <span class="fa fa-plus"></span> Cargar los Tipos de Entrega</button>
                      </div>

                      <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>Guardar</button>
                        <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                      </div>
                    </div>
                  </form>
                </div>

                <!--Fin centro -->

              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <!-- <div class= "modal-dialog modal-lg" role="document"> -->
      <div class="modal-dialog" style="width: 80% !important;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Seleccione un Contrato</h4>
          </div>
          <div class="modal-body">
            <table id="tblcontratos" class="table table-striped table-bordered  table-hover">
              <thead>
                <th>Opcion</th>
                <th>Codigo</th>
                <th>Contrato</th>
                <th scope="col">
                  <div style="width: 250px;text-align: left;">Proveedor</div>
                </th>
                <th scope="col">
                  <div style="width: 200px;text-align: left;">Llamado</div>
                </th>
                <th>Vigencia</th>
              </thead>
              <tbody>

              </tbody>
              <tfoot>
                <th>Opcion</th>
                <th>Codigo</th>
                <th>Contrato</th>
                <th scope="col">
                  <div style="width: 250px;text-align: left;">Proveedor</div>
                </th>
                <th scope="col">
                  <div style="width: 200px;text-align: left;">Llamado</div>
                </th>
                <th>Vigencia</th>
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
  <script type="text/javascript" src="scripts/adjudicacionPoliza.js"></script>

<?php
}
ob_end_flush();
?>