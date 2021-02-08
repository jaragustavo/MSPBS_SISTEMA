<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';

  if ($_SESSION['pedidoRecibir'] == 1)
  // if ($_SESSION['covidCompra']==1) 
  // cambiar
  {
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
                <h1 class="box-title">Oferta Proveedor
                  <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)">
                    <i class="fa fa-plus-circle">
                    </i> Agregar</button></h1>
              </div>
              <div id="buscarItem"></div>
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Opciones</th>
                    <th>Item</th>
                    <th>Descripción</th>
                    <th>Proveedor</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Precio Referencial</th>
                    <th>Condiciones</th>
                    <th>Dias</th>
                    <th>Fecha Oferta</th>
                    <th>Obs</th>

                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Item</th>
                    <th>Descripción</th>
                    <th>Proveedor</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Precio Referencial</th>
                    <th>Condiciones</th>
                    <th>Dias</th>
                    <th>Fecha Oferta</th>
                    <th>Obs</th>

                  </tfoot>
                </table>
              </div>

              <div class="panel-body" style="height: 100%;" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-md-8">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <div class="col-md-3 derecha">
                            <span>Codigo</span>
                          </div>
                          <div class="col-md-9">
                            <input id="codigo" name="codigo" type="text" class="form-control input-sm" placeholder="Codigo" disabled="true" style="text-transform:uppercase;">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <div class="col-md-3 derecha">
                            <span>Fecha Oferta</span>
                          </div>
                          <div class="col-md-9 ">
                            <div class="input-group date">
                              <input class="datepicker" id="fecha_oferta" name="fecha_oferta" placeholder="Seleccione la Fecha">
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
                          <div class="col-md-3">
                            <span>Proveedor</span>
                          </div>
                          <div class="col-md-9">
                            <select id="codigo_proveedor" name="codigo_proveedor" class="form-control selectpicker" data-live-search="true" required>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <div class="col-md-3 derecha">
                            <span>Cantidad</span>
                          </div>
                          <div class="col-md-9">
                            <input id="cantidad_ofrecida" name="cantidad_ofrecida" type="text" class="form-control input-sm" placeholder="Ingrese la cantidad" style="text-transform:uppercase;">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <div class="col-md-3 derecha">
                            <span>Precio Unitario</span>
                          </div>
                          <div class="col-md-9">
                            <input id="precio_unitario" name="precio_unitario" type="text" class="form-control input-sm" placeholder="Precio Unitario" style="text-transform:uppercase;">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <div class="col-md-3 derecha">
                            <span>Dias</span>
                          </div>
                          <div class="col-md-9">
                            <input id="dias_disponible" name="dias_disponible" type="text" class="form-control input-sm" placeholder="Dias a disponer" style="text-transform:uppercase;">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <div class="col-md-3 derecha">
                            <span>Estado</span>
                          </div>
                          <div class="col-md-9 ">
                            <select id="codigo_estado" name="codigo_estado" class="form-control selectpicker" data-live-search="true" required>
                            </select>
                          </div>

                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <div class="col-md-3 derecha">
                            <span>Obs</span>
                          </div>
                          <div class="col-md-9 ">
                            <textarea input id="obs" name="obs" type="text" class="form-control input-sm" placeholder="Ingrese observación" style="text-transform:uppercase;"></textarea>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <div class="col-md-3 derecha">
                            <span>Forma Pago</span>
                          </div>
                          <div class="col-md-9 ">
                            <select id="codigo_monto" name="codigo_monto" class="form-control selectpicker" data-live-search="true">
                            </select>
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
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>Guardar</button>
                        <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                      </div>
                  </div>
                  <div class="form-group col-md-4" style="border-left:2pt solid gray;">
                    <!-- ITEM -->
                    <div class="form-group row" style=" align-content: center; margin-left:0%">
                      <div class="col-md-3 ">
                        <span>Item</span>
                      </div>
                      <div class="col-md-9">
                        <div class="form-group row">
                          <div class="col-md-9">
                            <input type="hidden" class="form-control" name="codigo_item" id="codigo_item">
                            <input id="nombre_item" name="nombre_item" type="text" disabled="true" class="form-control input-sm" placeholder="Ingrese el Item" style="text-transform:uppercase;">
                          </div>

                          <div class="col-md-3">
                            <button id="botonBuscarItem" type="button" class="btn btn-success">
                              <i class="fa fa-search"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- END ITEM -->
                    <!-- condiciones -->
                    <div id="divCondicion" class="col-md-12" style=" align-content: center;">
                      <div class="form-group row">
                        <label style="margin-left: 2%; font-size:1.5em;">Condiciones:</label>
                        <ul style="list-style: none;" id="condiciones">
                        </ul>
                      </div>
                    </div>
                  </div>




                </form>
                <!--Fin centro -->

              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
      </section>
      <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
    <!--Fin-Contenido-->

  <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
  <script type="text/javascript" src="scripts/ofertaCovid.js"></script>

<?php
}
ob_end_flush();
?>