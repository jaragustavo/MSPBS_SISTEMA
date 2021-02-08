<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();


if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';

  if ($_SESSION['pedidoOrdenCompraReciboProveedor'] == 1) {
?>
    <style>
      .filter-option {
        font-size: 12px;
      }
    </style>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Canje de Productos
                </h1>
              </div>
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th></th>
                    <th>Sucursal</th>
                    <th>Licitacion</th>
                    <th>Orden Compra</th>
                    <th>Proveedor</th>
                    <th>Cod. Medicamento</th>
                    <th>Medicamento</th>
                    <th>Nro. Lote</th>
                    <th>Fecha Vencimiento</th>
                    <th>Fecha Canje</th>
                    <th>Stock Actual</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th></th>
                    <th>Sucursal</th>
                    <th>Licitacion</th>
                    <th>Orden Compra</th>
                    <th>Proveedor</th>
                    <th>Cod. Medicamento</th>
                    <th>Medicamento</th>
                    <th>Nro. Lote</th>
                    <th>Fecha Vencimiento</th>
                    <th>Fecha Canje</th>
                    <th>Stock Actual</th>
                  </tfoot>
                </table>
              </div>
              <div class="panel-body" style="height:auto;" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="row" id="divStockCanje" style="font-size: 12px;">
                    <div class="col-md-12">
                      <div class="row" style="margin-left:2%">
                        <!-- codigo OC -->
                        <div class="col-md-6" id="divCodigo">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Código</label>
                            </div>
                            <div class="col-md-8">
                              <input id="codigo_stock_medicamento" name="codigo_stock_medicamento" type="text" class="form-control input-sm" placeholder="Codigo medicamento" disabled="true" style="text-transform:uppercase;">
                            </div>
                          </div>
                        </div>
                        <!-- Licitacion -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Licitacion</label>
                            </div>
                            <div class="col-md-8">
                              <input id="licitacion" name="licitacion" type="text" class="form-control input-sm">
                            </div>
                          </div>
                        </div>
                        <!-- Orden de Compra -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Orden Compra</label>
                            </div>
                            <div class="col-md-8">
                              <input id="orden_compra" name="orden_compra" type="text" class="form-control input-sm">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row" style="margin-left:2%">
                        <!-- Proveedor -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Proveedor</label>
                            </div>
                            <div class="col-md-8">
                              <input id="codigo_proveedor" name="codigo_proveedor" type="text" class="form-control input-sm">
                            </div>
                          </div>
                        </div>
                        <!-- Sucursal -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Sucursal</label>
                            </div>
                            <div class="col-md-8">
                              <input id="sucursal" name="sucursal" type="text" class="form-control input-sm">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row" style="margin-left:2%">
                        <!-- Numero Lote -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4">
                              <label>Nro. Lote</label>
                            </div>
                            <div class="col-md-4">
                              <input id="numero_lote" name="numero_lote" type="text" class="form-control input-sm">
                            </div>
                          </div>
                        </div>
                        <!-- Medicamento -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Medicamento</label>
                            </div>
                            <div class="col-md-8">
                              <input id="medicamento" name="medicamento" type="text" class="form-control input-sm">
                            </div>
                          </div>
                        </div>

                      </div>
                      <div class="row" style="margin-left:2%">
                        <!-- Cantidad -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Cantidad</label>
                            </div>
                            <div class="col-md-3">
                              <input id="cantidad" name="cantidad" type="text" class="form-control input-sm">
                            </div>
                          </div>
                        </div>
                        <!-- Fecha Vencimiento -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Fecha Vcto.</label>
                            </div>
                            <div class="col-md-4">
                              <input id="fecha_vencimiento" name="fecha_vencimiento" type="text" class="form-control input-sm">
                            </div>
                          </div>
                        </div>
                      </div>


                      <!-- seccion canje -->
                      <div style="border-top: 2px solid darkcyan; margin-bottom:10px;">

                      </div>
                      <div class="row" style="margin-left:2%" id="divCanje1">

                        <!-- Fecha Canje -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Fecha Canje</label>
                            </div>
                            <div class="col-md-8">
                              <input id="codigo_canje" name="codigo_canje" type="hidden" class="form-control input-sm">
                              <input class="datepicker" id="fecha_canje" name="fecha_canje" placeholder="Fecha de Canje">
                              <input class="datepicker" id="fecha_hoy" name="fecha_canje" type="hidden">
                            </div>
                          </div>
                        </div>
                        <!-- Cantidad Canje-->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Cantidad Canje</label>
                            </div>
                            <div class="col-md-4">
                              <input id="cantidad_canje" name="cantidad_canje" type="text" class="form-control input-sm" placeholder="Cantidad de canje">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row" style="margin-left:2%" id="divCanje2">
                        <!-- Observacion -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Observacion</label>
                            </div>
                            <div class="col-md-8">
                              <textarea input id="observacion_canje" name="observacion_canje" type="text" class="form-control input-sm" placeholder="Servicio Afectado - Observacion" style="text-transform:uppercase;"></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6" id="divArchivo">
                          <div class="form-group row">
                            <div class="col-md-4">
                              <label>Adjuntar Documento(*)</label>
                            </div>
                            <div class="col-md-6">
                              <input type="file" class="form-control" name="imagen" id="imagen">
                              <input name="imagenactual" id="imagenactual" hidden>
                            </div>
                            <div class="col-md-2">
                              <iframe src="" width="50px" height="50px" name="imagenmuestra" id="imagenmuestra" onclick="openTab(this)" href="#"></iframe>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>Guardar</button>
                    <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>

                  </div>
                </form>
                <!--Fin centro -->
              </div>
              <!--Fin centro -->

            </div><!-- /.box -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->

  <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script type="text/javascript" src="scripts/stockCanje.js"></script>
<?php
}
ob_end_flush();
?>