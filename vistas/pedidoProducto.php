<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();   
//$idusuario = $_GET['cedula'];

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
                          <h1 class="box-title">Pedido Productos <button class="btn btn-success"
                              id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle">
                          </i> Agregar</button></h1>
                           
                    </div>
                    
                      
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Numero Pedido</th> 
                            <th>Fecha Pedido</th>
                          
                            <th>Establecimiento</th>
                          <th>Estado</th>
                           
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Numero Pedido</th> 
                            <th>Fecha Pedido</th>
                          
                            <th>Establecimiento</th>
                            <th>Estado</th>
                           
                           
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 100%;" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Fecha(*):</label>
                              <input type="hidden" name="idpedidoproducto"   id="idpedidoproducto">
                              <input type="text" class="form-control" name="fecha_hora" id="fecha_hora" disabled="true" required="">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Obs:</label>
                            <textarea type="text" class="form-control" name="obs" id="obs"></textarea>
                          </div>
                          <div id="sele" class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <label>Enviar a (*):</label>
                            <select id="idusuarioDestino" name="idusuarioDestino" 
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
                                    <th >Opcion</th>
                                    <th >Codigo</th>
                                    <th >Producto</th>
                                    <th>Cantidad</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                          </div>
 
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>Guardar</button>
                            <button class="btn btn-primary" onclick="enviar()"  id="btnEnviar" type="button"><i class="fa fa-paper-plane"></i>Enviar</button>
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
   <!-- <div class= "modal-dialog modal-lg" role="document"> -->
          <div class="modal-dialog" style="width: 80% !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un Producto</h4>
        </div>
        <div class="modal-body">
          <table id="tblarticulos" class="table table-striped table-bordered  table-hover">
            <thead>
               <th>Opcion</th>
                <th>Codigo</th>
                <th scope="col"><div style="width: 700px;text-align: left;">Producto</div></th>
                 <th>Stock</th>
                 
            </thead>
            <tbody>
               
            </tbody>
            <tfoot>
                 <th>Opcion</th>
                <th>Codigo</th>
                <th scope="col"><div style="width: 700px;text-align: left;">Producto</div></th>
                 <th>Stock</th>
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
  

<script type="text/javascript" src="scripts/pedidoProducto.js"></script>
<?php 
}
ob_end_flush();
?>