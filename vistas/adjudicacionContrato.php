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
                <h1 class="box-title">Contratos Proveedor <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                <div class="box-tools pull-right">
                </div>
                <div class="panel-body table-responsive" id="listadoregistros">
                  <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                      <th></th>
                      <th>Id. Llamado</th>
                      <th>Llamado</th>
                       <th>Titulo</th>
                      <th>Nro. Contrato</th>
                      <th>Proveedor</th>
                      <th>Fecha inicio</th>
                      <th>Vigencia</th>
                      <th>Estado</th>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                      <th></th>
                      <th>Id. Llamado</th>
                      <th>Llamado</th>
                       <th>Titulo</th>
                      <th>Nro. Contrato</th>
                      <th>Proveedor</th>
                      <th>Fecha inicio</th>
                      <th>Vigencia</th>
                       <th>Estado</th>
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
                          <div class="col-md-6">
                            <div class="form-group row" id="divTipo_dias">
                              <div class="col-md-4 derecha">
                                <label for="codigo_tipo_dias">Llamado(*):</label><br>
                              </div>
                              <div class="col-md-8">
                                <select id="codigo_adjudicacion" name="codigo_adjudicacion" class="form-control selectpicker" data-live-search="true" required></select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row" id="divTipo_dias">
                              <div class="col-md-4 derecha">
                                <label for="codigo_tipo_dias">Proveedor:</label><br>
                              </div>
                              <div class="col-md-8">
                                <select id="codigo_proveedor" name="codigo_proveedor" class="form-control selectpicker" data-live-search="true" required></select>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <div class="col-md-4 derecha">
                                <label>Numero del Contrato:</label>
                              </div>
                              <div class="col-md-4">
                                <input type="text" class="form-control" name="numero_contrato" id="numero_contrato" placeholder="Numero de contrato" required>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row" id="divTipo_dias">
                              <div class="col-md-4 derecha">
                                <label for="codigo_tipo_dias">Monto Contrato:</label><br>
                              </div>
                              <div class="col-md-4">
                                <input type="text" class="form-control" name="monto_contrato" id="monto_contrato" placeholder="Monto del contrato" title="Solo numeros" required>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <div class="col-md-4 derecha">
                                <label>Fecha del Contrato:</label>
                              </div>
                              <div class="col-md-6">
                                <div class="row">
                                  <div class="col-sm-2">
                                    <div class="input-group date">
                                      <input class="datepicker" id="fecha_contrato" name="fecha_contrato" placeholder="Seleccione la Fecha">
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
                            <div class="form-group row">
                              <div class="col-md-4 derecha">
                                <label>Fecha de Vigencia:</label>
                              </div>
                              <div class="col-md-6">
                                <div class="row">
                                  <div class="col-sm-2">
                                    <div class="input-group date">
                                      <input class="datepicker" id="vigencia" name="vigencia" placeholder="Seleccione la Fecha">
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
                                <label>Porcentaje Mora:</label>
                              </div>
                              <div class="col-md-4">
                                <input type="text" class="form-control" name="porcentaje_mora" id="porcentaje_mora" maxlength="4" placeholder="Porcentaje de mora" title="Solo numeros" required>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row" id="divTipo_dias">
                              <div class="col-md-4 derecha">
                                <label for="codigo_tipo_dias">Frecuencia Diaria Aum.:</label><br>
                              </div>
                              <div class="col-md-4">
                                <input type="text" class="form-control" name="frecuencia_diaria_aumento_mora" id="frecuencia_diaria_aumento_mora" placeholder="Frecuencia diaria de aumento de mora" title="Solo numeros" required>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <div class="col-md-4 derecha">
                                <label>Fecha Rescision:</label>
                              </div>
                              <div class="col-md-6">
                                <div class="row">
                                  <div class="col-sm-2">
                                    <div class="input-group date">
                                      <input class="datepicker" id="fecha_rescision" name="fecha_rescision" placeholder="Seleccione la Fecha">
                                      <div class="input-group-addon" id="icon_calendar3">
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
                                <label>Porcentaje Rescision:</label>
                              </div>
                              <div class="col-md-4">
                                <input type="text" class="form-control" name="porcentaje_rescision" id="porcentaje_rescision" maxlength="4" placeholder="Porcentaje de rescision" title="Solo numeros" required>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row" id="divTipo_dias">
                              <div class="col-md-4 derecha">
                                <label for="codigo_tipo_dias">Tipo Vigencia:</label><br>
                              </div>
                              <div class="col-md-8">
                                <select id="codigo_tipo_vigencia" name="codigo_tipo_vigencia" class="form-control selectpicker" data-live-search="true" required></select>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                              <div class="col-md-4 derecha">
                                <label>Estado Contrato:</label>
                              </div>
                              <div class="col-md-8">
                                <select id="codigo_estado_contrato" name="codigo_estado_contrato" class="form-control selectpicker" data-live-search="true" required></select>
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
                            <div class="form-group row">
                              <div class="col-md-4" id="divDocLlamado">
                                <label>Adjuntar Documento</label>
                                <input type="file" class="form-control" name="imagen" id="imagen">
                                <input type="hidden" name="imagenactual" id="imagenactual">
                              </div>
                              <div class="col-md-8">
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


  <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script type="text/javascript" src="scripts/adjudicacionContrato.js"></script>

<?php
}
ob_end_flush();
?>