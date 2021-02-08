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
                  Reactivo <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)">
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
                      <th>Nombre</th>
                      <th>Especificaciones Tecnicas</th>
                      <th>Presentacion</th>
                      <th>Presentacion de Entrega</th>
                      <th>Cantidad Necesitada</th>
                      <th>Observacion</th>
                      <th>Estado</th>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                      <th></th>
                      <th>Cod. Catalogo</th>
                      <th>Nombre</th>
                      <th>Especificaciones Tecnicas</th>
                      <th>Presentacion</th>
                      <th>Presentacion de Entrega</th>
                     <th>Cantidad Necesitada</th>
                      <th>Observacion</th>
                      <th>Estado</th>
                    </tfoot>
                  </table>
                </div>
                <!--Formulario Agregar -->
                <div class="panel-body" id="formularioregistros">
                  <form name="formulario" id="formulario" method="POST">


                    <input type="hidden" class="form-control" name="codigo" id="codigo">

                    <div class="col-md-12">
                      <div class="row">
                       <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Nombre:</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" name="nombre" id="nombre">
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                       
                           <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-4 col-form-label centrado">Codigo de Catalogo:</label>
                            <div class="col-sm-8">
                              <input type="text" class="form-control" name="codigo_catalogo" id="codigo_catalogo">
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
    <script type="text/javascript" src="scripts/reactivoItem.js"></script>

<?php
}
ob_end_flush();
?>