<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
//error_log(''.$_SESSION["nombre"]);
if (!isset($_SESSION["nombre"]))
{
   header("Location: login.html");
}
else
{
require 'header.php';
if ($_SESSION['pedido']==1)
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
                          <h1 class="box-title">Linea <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Nro.OC</th>
                            <th>Llamado</th>
                            <th>Proveedor</th>
                            <th>Codigo Medicamento</th>
                            <th>Descripción Producto</th>
                            <th>Monto OC</th>
                            <th>Observación</th>
                            <th>SIMESE</th>
                            <th>Nro.Pedido</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                              <th>Opciones</th>
                            <th>Fecha</th>
                            <th>Nro.OC</th>
                            <th>Llamado</th>
                            <th>Proveedor</th>
                            <th>Codigo Medicamento</th>
                            <th>Descripción Producto</th>
                            <th>Monto OC</th>
                            <th>Observación</th>
                            <th>SIMESE</th>
                            <th>Nro.Pedido</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Linea:</label>
                            <input type="hidden" name="idlinea" id="idlinea">
                            <input type="text" class="form-control" name="desLinea" id="desLinea" maxlength="256" placeholder="Descripcion Linea" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Codigo Linea:</label>
                            <input type="text" class="form-control" name="codigoLinea" id="codigoLinea" maxlength="50" placeholder="Codigo Linea">
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
 
                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
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
 
  <script type="text/javascript" src="scripts/controlEmision.js"></script>
<?php 
}
ob_end_flush();
?>
