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
 
if ($_SESSION['emision']==1)
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
                          <h1 class="box-title">Planilla Control de Emisión <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Generar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                           <th>Elaborado por</th>
                          
                            <th>Fecha OC</th>
                            <th>Nro.OC</th>
                            <th>Llamado</th>
                            <th>Proveedor</th>
                            <th>Codigo</th>
                            <th>Descripción Producto</th>
                            <th>Monto OC</th>
                            <th>% Ejec.</th>
                            <th>Observación</th>
                            <th>SIMESE</th>
                            <th>Nro.Pedido</th>
                             <th>Indicador Prioridad</th>
                             <th>Codigo Impresión</th>
                            
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                              <th>Opciones</th>
                           <th>Elaborado por</th>
                            <th>Fecha OC</th>
                            <th>Nro.OC</th>
                            <th>Llamado</th>
                            <th>Proveedor</th>
                            <th>Codigo</th>
                            <th>Descripción Producto</th>
                            <th>Monto OC</th>
                             <th>% Ejec.</th>
                            <th>Observación</th>
                            <th>SIMESE</th>
                            <th>Nro.Pedido</th>
                             <th>Indicador Prioridad</th>
                             <th>Codigo Impresión</th>
                             
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 100%;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                           <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Codigo:</label>
                            <input type="text" class="form-control" name="codigo_control_emision" id="codigo_control_emision" disabled="true">
                           </div>  
                            
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Fecha(*):</label>
                            <input type="text" class="form-control" name="fecha_hora" id="fecha_hora" required="">
                          </div><br><br><br><br>
                        

                        <div id="divAnular" class="form-check col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <input type="checkbox" class="form-check-input" id="anular" >
                             <label class="form-check-label" for="anular">ANULAR</label>
                         </div>

                         
                          <div class="form-group col-lg-12  col-md-12 col-sm-12 col-xs-12">
                          </div>
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a data-toggle="modal" href="#myModal">           
                              <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span> Agregar OC</button>
                            </a>
                          </div>
 
                          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                     <th>Opciones</th>
                                    <th>Nro.OC</th>
                                    <th>Fecha OC.</th>
                                     <th>Proveedor</th>
                                    <th>Codigo Medicamento</th>
                                    <th>Descripción Producto</th>
                                    <th>Monto OC</th>
                                    <th>Observación</th>
                                </thead>
                             
                                <tbody>
                                   
                                </tbody>
                            </table>
                          </div>
 
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
                            <button class="btn btn-primary" type="submit" id="btnAnular"><i class="fa fa-save"></i> Anular</button>
 
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
 
  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione OC</h4>
        </div>
        <div class="modal-body">
          <table id="tblOC" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <th>Opciones</th>
                <th>Nro.OC</th>
                <th>Fecha OC.</th>
                 <th>Proveedor</th>
                <th>Codigo Medicamento</th>
                <th>Descripción Producto</th>
                <th>Monto OC</th>
              
            </thead>
            <tbody>
               
            </tbody>
            <tfoot>
                 <th>Opciones</th>
                <th>Nro.OC</th>
                <th>Fecha OC.</th>
                 <th>Proveedor</th>
                <th>Codigo Medicamento</th>
                <th>Descripción Producto</th>
                <th>Monto OC</th>
              
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