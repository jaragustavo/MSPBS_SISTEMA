<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();


if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';
 
if ($_SESSION['adjudicacion']==1)
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
                          <h1 class="box-title">Covid Monto<button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th></th>
                            <th>Descripcion</th>
                            <th>Monto</th>
                            <th>Moneda</th>
                            <th>Cotizacion</th>
                            <th>Fecha</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th></th>
                            <th>Descripcion</th>
                            <th>Monto</th>
                            <th>Moneda</th>
                            <th>Cotizacion</th>
                            <th>Fecha</th>
                          </tfoot>
                       </table>
                    </div>
                                  <!--Formulario Agregar -->
                      <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <input type="hidden" class="form-control" name="codigo" id="codigo">
                          <div class="form-group row">
                              <label class="col-sm-2 col-form-label">Fecha:</label>
                                <div class="col-sm-2">
                                    <div class="input-group date">
                                      <input class="datepicker" id="fecha" name="fecha" placeholder="Seleccione la Fecha" required>
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                    </div>
                                </div>
                          </div> 
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Descripcion:</label>
                            <div class="col-sm-4">
                              <input type="text" class="form-control" name="descripcion" id="descripcion" required>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Monto:</label>
                            <div class="col-sm-2">
                              <input type="text" class="form-control" name="monto" id="monto" maxlength="10" pattern="([0-9]{1,10})" title="Solo numeros" required>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Moneda:</label>
                            <div class="col-sm-2">
                              <select type="text" class="form-control selectpicker" name="moneda" id="moneda">
                              <option value="1">Guaranies</option>
                              <option value="2">Dolares</option>
                              </select>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Cotizacion:</label>
                            <div class="col-sm-2">
                              <input type="text" class="form-control" name="cotizacion" id="cotizacion" maxlength="5" pattern="([0-9]{1,5})" title="Solo numeros">
                            </div>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>Guardar</button>
                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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
}
else
{
  require 'noacceso.php';
}
 
require 'footer.php';
?>
  <script type="text/javascript" src="scripts/covidMonto.js"></script>

<?php 
}
ob_end_flush();
?>