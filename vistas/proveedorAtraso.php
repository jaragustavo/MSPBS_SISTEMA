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
 
if ($_SESSION['adjudicacionProveedorAtraso']==1)
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
                          <h1 class="box-title">Proveedores con Atrasos  
                             <?php 
                                if ($_SESSION['adjudicacionProveedorAtrasoAgregar']==1)
                                {
                             ?>
                                  <button class="btn btn-success"
                                    id="btnagregar" onclick="editar()"> 
                                    <i class="fa fa-plus-circle"></i>  Agregar</button>
                             <?php 
                                    }

                              ?>       
                                    <button class="btn btn-primary"
                                    id="btnDetalle" onclick="mostrarDetalle()"> 
                                    <i class="fa fa-eye"></i>  Detalle</button>
                            </h1>
                    </div>
                                     
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th >Opciones</th>    
                            <th >Lugar Entrega OC</th>
                            <th >OC</th>
                            <th >Fecha OC</th>
                            <th>Llamado</th>
                            <th>Proveedor</th>
                             <th>Item</th>
                            <th >Codigo</th>
                            <th>Producto</th>
                            <th>Cant. OC</th>
                            <th>Cant. Recep.</th>
                              <th>Fec. Ult. Recep.</th>
                            <th >Saldo</th>
                            <th>Stock</th>
                            <th>Fecha Recibido Poveedor</th>
                            <th >Plazo Entrega</th>
                            <th>Dias de Atraso</th>
                             <th>Estado</th>
                            <th>Referencia</th>
                                        
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                           <thead>
                             <th >Opciones</th>    
                            <th >Lugar Entrega OC</th>
                            <th >OC</th>
                            <th >Fecha OC</th>
                            <th>Llamado</th>
                            <th>Proveedor</th>
                             <th>Item</th>
                            <th >Codigo</th>
                            <th>Producto</th>
                            <th>Cant. OC</th>
                            <th>Cant. Recep.</th>
                            <th>Fec. Ult. Recep.</th>
                            <th >Saldo</th>
                            <th>Stock</th>
                            <th>Fecha Recibido Poveedor</th>
                            <th >Plazo Entrega</th>
                            <th>Dias de Atraso</th>
                             <th>Estado</th>
                            <th>Referencia</th>
                         
                          </thead>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 100px;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                         
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Nro.OC:</label>
                             <input type="hidden" class="form-control" name="codigoOC" id="codigoOC" disabled="true" >
                            <input type="text" class="form-control" name="numero_orden_compra" id="numero_orden_compra" disabled="true" >
                          </div>
                           <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Codigo:</label>
                            <input type="text" class="form-control" name="codigo_medicamentoOC" id="codigo_medicamentoOC" disabled="true" >
                          </div>
                           <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Producto:</label>
                             <input type="text" class="form-control" name="productoDescripcion" id="productoDescripcion" disabled="true" >
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Fecha:</label>
                            <input type="text" class="form-control" name="fecha_hora" id="fecha_hora" maxlength="10" placeholder="Número" disabled="true"r  >
                          </div><br>
                           <div id="codigo_producto_recibido" class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label>Producto Recibido:</label>
                            <select id="codigoMedicamentoRecibido" name="codigoMedicamentoRecibido" 
                                    class="form-control selectpicker" data-live-search="true"
                                    required>
                              </select>
                          </div>   
                          <div id="codigo_estado_proveedor_atraso" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Estado Proveedor Atraso:</label>
                            <select id="codigoEstadoProveedorAtraso" name="codigoEstadoProveedorAtraso" 
                                    class="form-control selectpicker" data-live-search="true"
                                    required>
                              </select>
                          </div>  
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Obs:</label>
                            <textarea type="text" class="form-control" name="obs" id="obs" ></textarea>
                          </div>
             
                     
 
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>Guardar</button>
                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                    
                      <div class="panel-body" style="height: 100%;" id="formularioconsulta">
                        <form name="formularioConsulta" id="formularioConsulta" method="POST">
                              
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                            <table id="consultaDetalle" 
                             class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th >Opciones</th>
                                    <th >Nro.OC</th>
                                    <th >Cod.Pro.OC</th>
                                    <th >Producto OC</th>
                                    <th >Cod.Pro.Rec.</th>
                                    <th >Producto Recibido</th>
                                    <th>Observación</th>
                                    <th>Estado</th>
                                        
                                 </thead>
                                <tbody>
                                </tbody>
                            </table>
                          </div>
 
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button">  <i class="fa fa-arrow-circle-left"></i>  Cancelar</button>
                            <button id="btnAnular" class="btn btn-primary" onclick="anular()" type="button">   <i class="fa fa-save"></i>  Anular</button>
                          </div>
                        </form>
                    </div>
                    
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->
 
    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
 
  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class= "modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un Producto</h4>
        </div>
        <div class="modal-body">
          <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
               <th>Opciones</th>
                <th>Codigo</th>
                <th>Producto</th>
                <th>Stock</th>
                <th>DMP</th>
                <th>Meses</th>
                
            </thead>
            <tbody>
               
            </tbody>
            <tfoot>
            <th>Opciones</th>
                <th>Codigo</th>
                <th>Producto</th>
                <th>Stock</th>
                <th>DMP</th>
                <th>Meses</th>
                
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
  <script type="text/javascript" src="scripts/proveedorAtraso.js"></script>
<?php 
}
ob_end_flush();
?>