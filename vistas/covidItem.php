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
                <h1 class="box-title">
                  Items Covid-19 <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)">
                    <i class="fa fa-plus-circle"> </i> Agregar
                  </button>
                </h1>
                <div class="box-tools pull-right">
                </div>
                <!-- Popup para agregar condiciones -->
                <div id="mpopupBox" class="mpopup">
                  <!-- mPopup content -->
                  <div class="mpopup-content">
                    <div class="mpopup-head">
                      <span class="close">×</span>
                      <h2>Agregue la Condicion</h2>
                    </div>
                    <div class="mpopup-main">
                      <p><input type="text" id="popupCondicionItem" placeholder="Condicion del Item" /></p>
                      <div class="row">
                        <div class="col-sm-1">
                          <p><input type="button" id="idbuttonCondicionItem" value="Agregar" /></p>
                        </div>
                        <div class="col-sm-1">
                          <p><input type="button" id="idbuttonCerrarPopup" value="Cerrar" onclick="cerrarPopup()" /></p>
                        </div>
                      </div>
                    </div>
                    <div class="mpopup-foot">
                      <p>DIGIES</p>
                    </div>
                  </div>
                </div>
                <div class="panel-body table-responsive" id="listadoregistros">
                  <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                      <th></th>
                      <th>Cod. Catalogo</th>
                      <th>Item. Nro.</th>
                      <th>Nombre</th>
                      <th>Especificaciones Tecnicas</th>
                      <th>Presentacion</th>
                      <th>Presentacion de Entrega</th>
                      <th>Precio Referencial</th>
                      <th>Cantidad Necesitada</th>
                      <th>Observacion</th>
                      <th>Fecha Inicio</th>
                      <th>Fecha Cierre</th>
                      <th>Estado</th>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                      <th></th>
                      <th>Cod. Catalogo</th>
                      <th>Item. Nro.</th>
                      <th>Nombre</th>
                      <th>Especificaciones Tecnicas</th>
                      <th>Presentacion</th>
                      <th>Presentacion de Entrega</th>
                      <th>Precio Referencial</th>
                      <th>Cantidad Necesitada</th>
                      <th>Observacion</th>
                      <th>Fecha Inicio</th>
                      <th>Fecha Cierre</th>
                      <th>Estado</th>
                    </tfoot>
                  </table>
                </div>
                <!--Formulario Agregar -->
                <div class="panel-body" id="formularioregistros">
                  <form name="formulario" id="formulario" method="POST">


                    <input type="hidden" class="form-control" name="codigo" id="codigo">

                    <div class="col-md-8">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Item. Nro:</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" name="item_numero" id="item_numero" maxlength="6" pattern="([0-9]{1,6})" title="Solo numeros">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label centrado">Codigo de Catalogo:</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" name="codigo_catalogo" id="codigo_catalogo">
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Nombre:</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" name="nombre" id="nombre">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Presentacion:</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" name="presentacion" id="presentacion">
                            </div>
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Especificaciones Tecnicas:</label>
                            <div class="col-sm-8">
                              <textarea type="text" class="form-control" name="especificacion_tecnica" id="especificacion_tecnica"> </textarea>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Presentacion de Entrega:</label>
                            <div class="col-sm-8">
                              <textarea type="text" class="form-control" name="presentacion_entrega" id="presentacion_entrega"> </textarea>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Precio Referencial:</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" name="monto" id="monto" pattern="([0-9]{1,14})" maxlength="14" title="Solo numeros">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Cantidad Necesitada:</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" name="cantidad_necesitada" id="cantidad_necesitada" pattern="([0-9]{1,14})" maxlength="14" title="Solo numeros">
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- fechas -->
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Fecha Inicio:</label>
                            <div class="col-sm-8">
                              <div class="input-group date">
                                <input class="datepicker" id="fecha_inicio" name="fecha_inicio" placeholder="Seleccione la Fecha">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Fecha Cierre:</label>
                            <div class="col-sm-8">
                              <div class="input-group date">
                                <input class="datepicker" id="fecha_cierre" name="fecha_cierre" placeholder="Seleccione la Fecha">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Observacion:</label>
                            <div class="col-sm-8">
                              <textarea type="text" class="form-control" name="observacion" id="observacion"> </textarea>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-4 col-form-label">Estado:</label>
                            <div class="col-sm-8">
                              <select id="codigo_estado" class="form-control selectpicker" data-live-search="true" name="codigo_estado" title="Seleccionar"></select>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-3 derecha">
                              <span>Adjuntar Documento</span>
                            </div>
                            <div class="col-md-9 ">
                              <input type="file" class="form-control" name="imagen" id="imagen">
                              <input type="hidden" name="imagenactual" id="imagenactual">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <iframe src="" width="350px" height="250px" id="imagenmuestra" onclick="openTab(this)" href="#" name=""></iframe>
                            <div id="myModal" class="modal">

                              <!-- The Close Button -->
                              <span class="close" style="font-size:100px; margin-top:1%; color:black;">&times;</span>

                              <!-- Modal Content (The Image) -->
                              <!-- <iframe src="" class="modal-content" id="img01"></iframe>
                          </div> -->
                              <!-- Maite -->

                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Maite -->


                    </div>



                    <!-- condiciones -->
                    <div class="col-md-4" style="border-left:2pt solid gray; align-content: center;">
                      <div class="form-group row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 table-hover col-lg-12" style="text-align:center;">
                          <button id="botonAgregarCondicionItem" class="btn btn-primary" style="background-color: darkcyan; color: smoke; " type="button">
                            <i class="fa fa-plus" style="margin-right:5px;"></i>M&aacutes Condiciones</button>
                        </div>


                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 table-hover col-lg-12" style="margin-top: 3%;">
                          <table id="tblCondicionItem" class="table-hover"></table>
                        </div>
                      </div>
                    </div>



                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>Guardar</button>
                      <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                    </div>

                  </form>
                </div>
                <!--Fin centro -->

              </div><!-- /.box-header -->
            </div><!-- /.box -->
          </div><!-- /.col -->
        </div> <!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->
  <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script type="text/javascript" src="scripts/covidItem.js"></script>

<?php
}
ob_end_flush();
?>