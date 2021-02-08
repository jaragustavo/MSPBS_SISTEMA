<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';
  if ($_SESSION['contratoAdenda'] == 1) {
?>

    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content" style="font-size:13px">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div id="titulo">
                <div class="box-header with-border">
                  <h1 class="box-title">Resolucion <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>
                    <!--<a href="../reportes/rptarticulos.php" target="_blank"><button class="btn btn-info"><i class="fa fa-clipboard"></i> Reporte</button></a>-->
                   </h1>
                  <div class="box-tools pull-right">
                  </div>
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Opciones</th>
                    <th>Nro.Expediente</th>
                    <th>Nro.Resolucion</th>
                    <th>Doc.Nro.</th>
                    <th>Apellido y Nombre</th>
                    <th>Tipo Resolucion</th>
                     <th>Tipo</th>
                    <th>Objeto</th>
                    <th>Rubro</th>
                    <th>Ubicacion Prestacion</th>
                    <th>Salario</th>
                    <th>Grupo Ocupacional</th>
                    <th>Cargo</th>
                    <th>Especialidad</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th> 
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Nro.Expediente</th>
                    <th>Nro.Resolucion</th>
                    <th>Doc.Nro.</th>
                    <th>Apellido y Nombre</th>
                    <th>Tipo Resolucion</th>
                     <th>Tipo</th>
                    <th>Objeto</th>
                    <th>Rubro</th>
                    <th>Ubicacion Prestacion</th>
                    <th>Salario</th>
                    <th>Grupo Ocupacional</th>
                    <th>Cargo</th>
                    <th>Especialidad</th>
                     <th>Fecha Inicio</th>
                    <th>Fecha Fin</th> 
                    <th>Estado</th>
                  </tfoot>
                </table>
              </div>
              
              <div id="buscar"></div>
              
              
              
              <div class="panel-body" id="formularioregistros">
                <!--  <div class="text-red col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <label>Los campos con (*) son obligatorios!!</label>
                          </div>
-->
                <form name="formulario" id="formulario" method="POST">
                  <div class="row" style="margin-left:2%">
                    <div class="col-md-6">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="form-group row">
                            <div class="row">
                              <div class="col-md-5">
                                <div class="row">
                                  <div  class="col-md-12" id="divcodigo_llamado">
                                    <label>Nro(*):</label>
                                        <select onchange='obtenerAdjudicacion(this);' id="codigo_llamado" name="codigo_llamado" class="form-control selectpicker" data-live-search="true"  ></select>
                                  </div>
                                </div>
                              </div>
                             
                                
                                
                              <div class="col-md-6">
                                <div class="row">
                                  <div class="col-md-12" id="divcodigo_proveedor">
                                    <label>Proveedor(*):</label>
                                    <select onchange='mostrarContrato(this);' id="codigo_proveedor" name="codigo_proveedor" class="form-control selectpicker" data-live-search="true"></select>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <div class="row">
                              <div class="col-md-4">
                                <label>Producto(*):</label>
                                <div class="form-group row">
                                  <div class="col-md-9">
                                      <input type="hidden" name="codigo" id="codigo">
                                       <input type="hidden" name="codigo_adjudicacion" id="codigo_adjudicacion">
                                      <input id="codigo_medicamento" name="codigo_medicamento" class="form-control selectpicker" data-live-search="true" disabled="true"></input>
                                  </div>
                                  <div class="col-md-3" style="font-size:15px">
                                    <span class="fa fa-search" id="botonBuscarProducto"></span>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-7">
                                <div class="row">
                                  <div class="col-md-12">
                                    <label>Descripcion Producto:</label>
                                    <textarea class="form-control" name="desProducto" id="desProducto" disabled="true"></textarea>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="col-md-5" style="margin-left:1%;">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="form-group row">
                            <h5 style="font-weight: bold; border-bottom: 3px solid #b9e2f5;">Datos del Producto</h5>
                            <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <div class="col-md-4">
                                        <label>Lote:</label>
                                      </div>
                                      <div class="col-md-8">
                                        <input type="text" class="form-control" name="lote" id="lote" placeholder="Lote" disabled="true">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <div class="col-md-4">
                                        <label>Item(*):</label>
                                      </div>
                                      <div class="col-md-7">
                                        <input type="text" class="form-control" name="item" id="item" placeholder="Item" disabled="true" >
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <div class="col-md-4">
                                        <label>Cantidad Maxima(*):</label>
                                      </div>
                                      <div class="col-md-8">
                                        <input type="text" class="form-control" name="cantidad_adjudicada" id="cantidad_adjudicada" placeholder="Cantidad Maxima"  title="Cantidad Maxima" disabled="true">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <div class="col-md-4">
                                        <label>Cantidad Emitida(*):</label>
                                      </div>
                                      <div class="col-md-7">
                                        <input type="text" class="form-control" name="cantidad_emitida" id="cantidad_emitida" maxlength="80" placeholder="Cantidad Emitida"  title="Cantidad Emitida" disabled="true">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                          </div>
                         
                        </div>
                      </div>

                    </div>

                    <div class="row" id="divDatosProducto" style="margin-top:2%">
                      <div class="col-md-12">
                        <div class="form-group row">
                          <div class="col-md-10">
                            <div class="row">
                              <div class="col-md-12">
                                <h5 style="font-weight: bold; border-bottom: 3px solid mediumaquamarine;">Datos de la Adenda</h5>
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <div class="col-md-4">
                                        <label>SIMESE(*):</label>
                                      </div>
                                      <div class="col-md-8">
                                        <input type="text" class="form-control" name="simese" id="simese" placeholder="SIMESE" >
                                      </div>
                                    </div>
                                  </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                          <div class="col-md-4">
                                            <label>Origen(*):</label>
                                          </div>
                                          <div class="col-md-7" id="divcodigo_sucursal_origen">
                                            <select id="codigo_sucursal_origen" name="codigo_sucursal_origen" class="form-control selectpicker" data-live-search="true" ></select>
                                          </div>
                                        </div>
                                      </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group row">
                                         <div class="col-md-4 derecha">
                                           <label>Fecha Pedido</label>
                                         </div>
                                         <div class="col-md-8 ">
                                           <div class="input-group date">
                                             <input class="datepicker" id="fecha_pedido" name="fecha_pedido" placeholder="Seleccione la Fecha">
                                           </div>
                                         </div>
                                       </div>
                                     </div>
                                    <div class="col-md-6">
                                       <div class="form-group row">
                                         <div class="col-md-4 derecha">
                                           <label>Fecha Vigencia</label>
                                         </div>
                                         <div class="col-md-8 ">
                                           <div class="input-group date">
                                             <input class="datepicker" id="fecha_vigencia" name="fecha_vigencia" placeholder="Seleccione la Fecha">
                                           </div>
                                         </div>
                                       </div>
                                     </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                   <div class="form-group row">
                                     <div class="col-md-4 derecha">
                                       <label>Fecha Adenda</label>
                                     </div>
                                     <div class="col-md-8 ">
                                       <div class="input-group date">
                                         <input class="datepicker" id="fecha_adenda" name="fecha_adenda" placeholder="Seleccione la Fecha">
                                       </div>
                                     </div>
                                   </div>
                                 </div>
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <div class="col-md-4">
                                        <label>Estado Item(*):</label>
                                      </div>
                                      <div class="col-md-7" id="divcodigo_estado_item_adjudicacion">
                                        <select id="codigo_estado_item" name="codigo_estado_item" class="form-control selectpicker" data-live-search="true" ></select>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                                 <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <div class="col-md-4">
                                        <label>Porcentaje Solicitado(*):</label>
                                      </div>
                                      <div class="col-md-2">
                                        <input type="text" class="form-control" name="porcentaje_solicitado" id="porcentaje_solicitado" maxlength="15" placeholder="Porcentaje Solicitado" >
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <div class="col-md-4">
                                        <label>Monto Ampliado(*):</label>
                                      </div>
                                      <div class="col-md-6">
                                        <input onkeyup="formatNumero(this)" onchange="formatNumero(this)" type="text" class="form-control" name="monto_ampliado" id="monto_ampliado" maxlength="15" placeholder="Monto Ampliado" >
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                 <div class="row">
                                   <div class="col-md-6">
                                        <div class="form-group row">
                                          <div class="col-md-4">
                                            <label>Cantidad Solicitada(*):</label>
                                          </div>
                                          <div class="col-md-6">
                                            <input onkeyup="formatNumero(this)" onchange="formatNumero(this)" type="text" class="form-control" name="cantidad_solicitada" id="cantidad_solicitada"  placeholder="Cantidad Solicitada" >
                                          </div>
                                        </div>
                                    </div>
                                   <div class="col-md-6">
                                        <div class="form-group row">
                                          <div class="col-md-4">
                                            <label>Cantidad Emitida(*):</label>
                                          </div>
                                          <div class="col-md-6">
                                            <input onkeyup="formatNumero(this)" onchange="formatNumero(this)" type="text" class="form-control" name="cantidad_emitida_ampliacion" id="cantidad_emitida_ampliacion"  placeholder="Cantidad Emitida" >
                                          </div>
                                        </div>
                                    </div>
                                </div>
                      <div class="row" >
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4">
                              <label>Obs</label>
                            </div>
                            <div class="col-md-8">
                              <textarea input id="observacion" name="observacion" type="text" class="form-control input-sm" placeholder="Ingrese observación" style="text-transform:uppercase;"></textarea>
                            </div>
                          </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group row">
                              <div class="col-md-4">
                                <label>Precio Unitario(*):</label>
                              </div>
                              <div class="col-md-6">
                                <input onkeyup="formatNumero(this)" onchange="formatNumero(this)" type="text" class="form-control" name="precio" id="precio"  placeholder="Precio Unitario" >
                              </div>
                            </div>
                         </div>  
                        
                      </div>
                            </div>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                      <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                    </div>
                  
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
  } else {
    require 'noacceso.php';
  }
  require 'footer.php';
  ?>
  <script type="text/javascript" src="scripts/contratoAdenda.js"></script>
  <script type="text/javascript" src="scripts/util.js"></script>
<?php
}
ob_end_flush();
?>
<script>
   $("#botonBuscarProducto").on('click', function() {
    // limpiarCampos();
    $("#buscar").load("buscarProductoContrato.html");
  //  $("#buscar").load("buscarItem.html");
    $("#buscar").fadeIn("slow");
   $("#titulo").fadeOut("slow");
    $("#formularioregistros").fadeOut("slow");

  });
</script>