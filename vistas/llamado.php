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
 
if ($_SESSION['reactivoLlamado']==1)
{
?>
<style>
  textarea{
    width: 100%;
    max-width: 97%;
    min-width: 97%;
    min-height: 35px;

  }
</style>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title" style="margin-bottom: 15px;">Llamado y Adjudicacion  <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th></th>
                            <th>Id.Llamado</th> 
                            <th>Fecha de Llamado</th>
                            <th>Tipo de Llamado</th>
                            <th>Numero</th>
                            <th>Año</th>
                            <th>Titulo</th>
                            <th>Numero Pedido</th>
                            <th>Observacion</th> 
                            <th>Nro.Pac.</th>   
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th></th>
                            <th>Id.Llamado</th> 
                            <th>Fecha de Llamado</th>
                            <th>Tipo de Llamado</th>
                            <th>Numero</th>
                            <th>Año</th>
                            <th>Titulo</th>
                            <th>Numero Pedido</th>
                            <th>Observacion</th>  
                             <th>Nro.Pac.</th>  
                          </tfoot>
                       </table>
                    </div>
                   <div id="buscar"></div>
                   <div class="panel-body" id="formularioregistros">
                    <form name="formulario" id="formulario" method="POST">
                      <div class="form-group col-md-12">
                        <div class="row" style="margin-left:2%; margin-right:2%">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-md-2">
                                  <label>Pedido:</label>
                                </div>
                                <div class="col-md-8">
                                  <input id="codigo" name="codigo" type="hidden">
                                  <input id="codigo_pedido_producto" name="codigo_pedido_producto" type="text" 
                                  class="form-control" placeholder="Nro.Pedido" disabled="true"/>
                                </div> 
                                <button id="botonBuscarPedidoProducto" type="button" class="btn btn-success"><i class="fa fa-search"></i></button>  
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-md-2">
                                      <label>Estado Llamado</label>
                                </div>
                                <div class="col-md-8">
                                  <select class="form-class selecpicker" data-width="302px" data-style="btn-primary" data-live-search="true"  id="codigo_estado_llamado" name="codigo_estado_llamado"  required ></select>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row col-mg-12">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-md-2">
                                  <label>Tipo de Llamado</label>
                                </div>
                                <div class="col-md-8">
                                   <select class="form-class selecpicker" data-width="302px" data-style="btn-primary" data-live-search="true"  id="codigo_tipo_llamado" name="codigo_tipo_llamado" required></select>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-md-2">
                                  <label>Nro.Pac:</label>
                                </div>
                                <div class="col-md-8">
                                  <input id="numero_pac" name="numero_pac" type="text" class="form-control" placeholder="Nro.Pac">
                                </div>
                              </div>
                            </div>  
                          </div> 
                          <div class="row">
                            <div class="form-group row col-lg-6">
                              <div class="col-md-2">    
                                <label>Fecha:</label>
                              </div>
                              <div class="col-md-1" style="margin-left: 4px;">
                                <div class="input-group date">
                                  <input class="datepicker" id="fecha_llamado" name="fecha_llamado" placeholder="Seleccione la Fecha">
                                  <div class="input-group-addon" id="icon_calendar">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                </div>
                              </div>  
                            </div>
                            <div class="col-md-6" style="margin-left: 30px;">
                              <div class="form-group row">
                                <div class="col-md-2">
                                  <label>Id.Llamado:</label>
                                </div>
                                <div class="col-md-8">
                                  <input id="id_llamado" name="id_llamado" type="text" class="form-control" placeholder="Id.Llamado">
                                </div>
                              </div>
                            </div>
                          </div>  
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-md-2">
                                  <label>Año:</label>
                                </div>
                                <div class="col-md-8">
                                  <input id="anio" name="anio" type="text" class="form-control" placeholder="Año">
                                </div>
                              </div> 
                            </div> 
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-md-2">  
                                  <label>Número:</label>
                                </div>
                              <div class="col-md-8">
                                <input id="numero" name="numero" type="text" class="form-control" placeholder="Número">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-md-2" style="margin-left: 13px;">    
                                  <label>Titulo:</label>
                                </div>
                                <div class="col-md-8">
                                  <textarea id="idtitulo" name="idtitulo" type="text" class="form-control" placeholder="Titulo del Llamado"></textarea>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group row">
                                <div class="col-md-2"> 
                                  <label>Obs.:</label>
                                </div>
                                <div class="col-md-8">
                                  <textarea id="observacion" name="observacion" type="text" class="form-control input-sm" placeholder="Ingrese observación" style="text-transform:uppercase;"></textarea>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>Guardar</button>
                            <button class="btn btn-primary" onclick="enviar()"  id="btnEnviar" type="button"><i class="fa fa-save"></i>Enviar</button>
                            <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
       
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->
 
    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
 
  <!-- Fin modal -->
<?php
}
else
{
  require 'noacceso.php';
}
 
require 'footer.php';
?>
  <script type="text/javascript" src="scripts/llamado.js"></script>
<script>
     $("#botonBuscarPedidoProducto").on('click',function(){
                     // limpiarCampos();
                      $("#buscar").load("buscarPedidoProducto.html");
                      $("#buscar").fadeIn("slow");
                      $("#titulo").fadeOut("slow");
                      $("#formularioregistros").fadeOut("slow");
                      
         });
   
   </script>
<?php 
}
ob_end_flush();
?>