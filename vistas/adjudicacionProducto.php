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
                     <div id="titulo"> 
                    <div class="box-header with-border">
                          <h1 class="box-title">Productos <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> 
                            <!--<a href="../reportes/rptarticulos.php" target="_blank"><button class="btn btn-info"><i class="fa fa-clipboard"></i> Reporte</button></a>-->
                            <a href="escritorio3.php" title="Cerrar Productos"> <i class="btn btn-default fa fa-times"> Cerrar</i> </a>
                          </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                   </div>       
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div id="buscar"></div>
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Lote</th>
                            <th>Item</th>
                            <th>Nombre</th>
                            <th>Unidad</th>
                            <th>Presentación</th>
                            <th>Marca</th>
                            <th>Procedencia</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th>Opciones</th>
                            <th>Lote</th>
                            <th>Item</th>
                            <th>Nombre</th>
                            <th>Unidad</th>
                            <th>Presentación</th>
                            <th>Marca</th>
                            <th>Procedencia</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" id="formularioregistros">
                    <!--  <div class="text-red col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <label>Los campos con (*) son obligatorios!!</label>
                          </div>
-->                    <form name="formulario" id="formulario" method="POST">
                          <!--PRIMERA FILA-->
                          <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>Llamado(*):</label>
                            <select id="idllamado" name="idllamado" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Proveedor(*):</label>
                            <select id="codigo_proveedor" name="codigo_proveedor" class="form-control selectpicker" data-live-search="true" required></select>  
                          </div>
                         <!-- SEXTA FILA -->
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Tipo Descuento(*):</label>
                            <select id="tipo_descuento" name="tipo_descuento" class="form-control selectpicker" data-live-search="true" required>
                              <option value="montos">Montos</option>
                              <option value="unidades">Unidades</option>
                            </select>  
                          </div>
                      <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                         <label>Producto(*):</label>
                         <input id="codigo_medicamento" name="codigo_medicamento" type="text" 
                                class="form-control" placeholder="codigo medicamento" disabled="true"/>
                    </div> 
                    <div class="col-md-1 izquierda">
                        <label>Buscar:</label>
                           <button id="botonBuscarProducto"
                                   type="button"
                                   class="btn btn-primary btn-sm izquierda">
                               <span class="glyphicon glyphicon-search" ></span>
                           </button>
                    </div>
                         <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Descripcion Producto:</label>
                            <textarea class="form-control" name="desProducto" id="desProducto"></textarea>
                        </div>
                       
                         <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Lote:</label>
                            <input type="number" class="form-control" name="lote" id="lote" placeholder="Lote" required>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Items(*):</label>
                            <input type="text" class="form-control" name="item" id="item" placeholder="Item" pattern="([0-9]{1,3})"required>
                          </div>
                                      <!--SEGUNDA FILA-->
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Unidad(*):</label>
                            <input type="text" class="form-control" name="unidad_medida" id="unidad_medida"  placeholder="Unidad de medida" required title="Unidad de medida">
                          </div>
                        
                          <!--TERCERA FILA-->
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Marca(*):</label>
                            <input type="text" class="form-control" name="nombre_comercial" id="nombre_comercial" maxlength="80" placeholder="Marca" required title="Ingrese la marca">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Procedencia(*):</label>
                            <input type="text" class="form-control" name="procedencia" id="procedencia" maxlength="80" placeholder="Procedencia" required title="Ingrese la procedencia">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Cant. Mínima(*):</label>
                            <input type="number" class="form-control" name="cantidad_minima" id="cantidad_minima" maxlength="15" placeholder="Cantidad mínima" required>
                          </div>  
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Cant. Máxima(*):</label>
                            <input type="number" class="form-control" name="cantidad_adjudicada" id="cantidad_adjudicada" maxlength="15" placeholder="Cantidad máxima" required>
                          </div>  
                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Cant. Emitida(*):</label>
                            <input type="number" class="form-control" name="cantidad_emitida" id="cantidad_emitida" placeholder="Cantidad emitida" required>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Precio U.(*):</label>
                            <input type="number" class="form-control" name="precio_unitario" id="precio_unitario" maxlength="15" placeholder="Precio unitario" required>
                          </div>          
                          
                           <!--CUARTA FILA-->
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Monto Mín.(*):</label>
                            <input type="number" class="form-control" name="mont_min" id="mont_min" maxlength="15" placeholder="Precio unitario" required>
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Monto Máx.(*):</label>
                            <input type="number" class="form-control" name="monto_max" id="monto_max" maxlength="15" placeholder="Precio unitario" required>
                          </div>
                     <!--   <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Presentación(*):</label>
                            <input type="text" class="form-control" name="presentacion" id="presentacion" maxlength="300" placeholder="Unidad de medida" required title="Ingrese la presentación">
                          </div> 
                     <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                            <label>Tipo Producto(*):</label>
                            <select id="idtipo" name="idtipo" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Grupo Farmacológico(*):</label>
                            <select id="idgrupo" name="idgrupo" class="form-control selectpicker" data-live-search="true" required></select>
                          </div>
                         <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <label>Nombre(*):</label>
                            <!--<input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="300" placeholder="Descripción" required>-->
                        <!--    <textarea class="form-control" name="nombre" id="nombre" required=""> 
                            </textarea>
                          </div>
                         -->
                          <!--QUINTA FILA-->
                         
                        
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Cant.Ampliado:</label>
                            <input type="number" class="form-control" name="cant_ampliado" id="cant_ampliado" placeholder="Cantidad Ampliado">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Monto Ampliado:</label>
                            <input type="number" class="form-control" name="monto_ampliado" id="monto_ampliado" placeholder="Monto Ampliado">
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Porcentaje Ampliado:</label>
                            <input type="number" class="form-control" name="por_ampliado" id="por_ampliado" placeholder="Porcentaje Ampliado">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Observaciones:</label>
                            <textarea class="form-control" name="obs" id="obs"> 
                            </textarea>
                         </div>
                         <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <label>Estado Item(*):</label>
                            <select id="tipo_descuento" name="tipo_descuento" class="form-control selectpicker" data-live-search="true" required>
                              <option value="ampliacion">AMPLIACION</option>
                              <option value="normal">NORMAL</option>
                              <option value="anulado">ANULADO</option>
                            </select>  
                          </div>
                          <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <input type="hidden" class="form-control" name="fecha" id="fecha" value="<?php echo date("Y-m-d"); ?>">
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
  <script type="text/javascript" src="scripts/adjudicacionProducto.js"></script>
<?php 
}
ob_end_flush();
?>
  <script>
     $("#botonBuscarProducto").on('click',function(){
                     // limpiarCampos();
                      $("#buscar").load("buscarProducto.html");
                      $("#buscar").fadeIn("slow");
                      $("#titulo").fadeOut("slow");
                      $("#formularioregistros").fadeOut("slow");
                      
         });
   
   </script>