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
 
if ($_SESSION['pedidoOrdenCompraConsulta']==1)
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
                          <h1 class="box-title">Pedido Orden Compra - Consulta<button class="btn btn-success"
                              id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle">
                          </i>Agregar</button></h1>
                    </div>
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                           <th>Numero Pedido</th> 
                            <th>SIMESE</th>
                            <th>Fecha Pedido</th>
                            <th>Codigo Medicamento</th>
                            <th>Medicamento</th>
                            <th>Stock</th>
                            <th>DMP</th>
                            <th>Cantidad</th>
                            <th>Meses Cantidad</th>
                            <th>Dias Transcurridos</th>
                            <th>Estado</th>
                             <th>Prioridad</th>
                             <th>Nro.OC.</th>
                            <th>Fecha OC.</th>
                           
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Numero Pedido</th> 
                            <th>SIMESE</th>
                            <th>Fecha Pedido</th>
                            <th>Codigo Medicamento</th>
                            <th>Medicamento</th>
                            <th>Stock</th>
                            <th>DMP</th>
                            <th>Cantidad</th>
                            <th>Meses Cantidad</th>
                            <th>Dias Transcurridos</th>
                            <th>Estado</th>
                            <th>Prioridad</th>
                             <th>Nro.OC.</th>
                            <th>Fecha OC.</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 100%;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                         
                          <div name="idpedido" id="idpedido" class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Nro.Pedido(*):</label>
                            <input type="text" class="form-control" name="idcodigo" id="idcodigo" disabled="true" >
                          </div>
                           <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Fecha(*):</label>
                             <input type="text" class="form-control" name="fecha_hora" id="fecha_hora" disabled="true" >
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Nro.SIMESE:</label>
                            <input type="text" class="form-control" name="numero_expediente" id="numero_expediente" maxlength="10" placeholder="Número" disabled="true"r  >
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Obs:</label>
                            <textarea type="text" class="form-control" name="obs" id="obs" disabled="true"></textarea>
                          </div>
                          <div id="sele" class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Indicador Prioridad:</label>
                            <select id="indicadorPrioridad" name="indicadorPrioridad" 
                                    class="form-control selectpicker" data-live-search="true"
                                    required>
                              </select>
                          </div>   
                          <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a data-toggle="modal" href="#myModal">           
                              <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span> Agregar Producto</button>
                            </a>
                          </div>
 
                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                            <table id="detalles" 
                                   class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th >Opciones</th>
                                    <th >Codigo</th>
                                    <th >Producto</th>
                                    <th >Stock</th>
                                    <th>DMP</th>
                                    <th>Meses</th>
                                    <th>Cantidad</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                          </div>
 
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>Guardar</button>
                            <button class="btn btn-primary" onclick="enviar()"  id="btnEnviar" type="button"><i class="fa fa-save"></i>Guardar</button>
                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                    
                      <div class="panel-body" style="height: 100%;" id="formularioconsulta">
                        <form name="formularioConsulta" id="formularioConsulta" method="POST">
                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <label>Nro.Pedido:</label>
                               <input type="text" class="form-control" name="numero_pedido" id="numero_pedido"  disabled="true">
                           </div>  
                       <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <label>Codigo:</label>
                               <input type="text" class="form-control" name="codigo_medicamento" id="codigo_medicamento"  disabled="true">
                           </div>  
                                               
                            <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <label>Producto:</label>
                              <input type="text" class="form-control" name="producto" id="producto" required="" disabled="true">
                          </div>
                               
                            
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                            <table id="consultaDetalle" 
                                   class="table table-striped table-bordered table-condensed table-hover">
                              <thead style="background-color:#A9D0F5">
                                    <th >Opciones</th>
                                    <th >Codigo</th>
                                    <th >FechaEnvio</th>
                                    <th >EnviadoPor</th>
                                    <th>FechaRecibo</th>
                                    <th>UsuarioDestino</th>
                                    <th>Obs</th>
                                    <th>Informe Pedido</th>
                                    <th>Duración</th>
                                        
                                 </thead>
                                <tbody>
                                </tbody>
                            </table>
                          </div>
 
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i>Cancelar</button>
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
  <script type="text/javascript" src="scripts/pedidoOrdenCompraConsulta.js"></script>
<?php 
}
ob_end_flush();
?>