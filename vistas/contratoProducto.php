<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';
  if ($_SESSION['reactivoContrato'] == 1) {
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
                  <h1 class="box-title">Productos <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>
                    <!--<a href="../reportes/rptarticulos.php" target="_blank"><button class="btn btn-info"><i class="fa fa-clipboard"></i> Reporte</button></a>-->
                    <a href="escritorio.php" title="Cerrar Productos"> <i class="btn btn-default fa fa-times"> Cerrar</i> </a>
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
                    <th>Id.Llamado</th>
                    <th>Licitación</th>
                    <th>Título</th>
                    <th>Proveedor</th>
                    <th>Código Cátalogo</th>
                     <th>Item</th>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Can.Maxima</th>
                    <th>Can.Emitida</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Id.Llamado</th>
                    <th>Licitación</th>
                    <th>Título</th>
                    <th>Proveedor</th>
                    <th>Código Cátalogo</th>
                     <th>Item</th>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Can.Maxima</th>
                    <th>Can.Emitida</th>
                  </tfoot>
                </table>
              </div>
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
                                    <label>Llamado(*):</label>
                                    <select onchange='mostrarAdjudicacion(this);' id="codigo_llamado" name="codigo_llamado" class="form-control selectpicker" data-live-search="true"  ></select>
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
                                    <textarea class="form-control" name="desProducto" id="desProducto"></textarea>
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
                            <h5 style="font-weight: bold; border-bottom: 3px solid #b9e2f5;">Datos de la Adjudicacion</h5>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group row">
                                  <div class="col-md-2">
                                    <label>Monto:</label>
                                  </div>
                                  <div class="col-md-8">
                                     <input type="hidden" class="form-control" name="codigo_adjudicacion" id="codigo_adjudicacion"  > 
                                    <input type="text" class="form-control" name="monto_adjudicado" id="monto_adjudicado" onkeyup="formatNumero(this)" onchange="formatNumero(this)" placeholder="Monto Adjudicado" >
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group row">
                                  <div class="col-md-2">
                                    <label>Fecha:</label>
                                  </div>
                                  <div class="col-md-2 ">
                                    <div class="input-group date" >
                                      <input class="datepicker" id="fecha_adjudicacion" name="fecha_adjudicacion" placeholder="Seleccione la Fecha">
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <h5 style="font-weight: bold; border-bottom: 3px solid #b9e2f5;">Datos de la Contrato</h5>

                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group row">
                                  <div class="col-md-2">
                                    <label>Nro:</label>
                                  </div>
                                  <div class="col-md-8">
                                    <input type="hidden" class="form-control" name="codigo_contrato" id="codigo_contrato" maxlength="15"  >  
                                    <input type="text" class="form-control" name="numero_contrato" id="numero_contrato" maxlength="15" placeholder="Nro.Contrato">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group row">
                                  <div class="col-md-2">
                                    <label>Fecha Inicio:</label>
                                  </div>
                                  <div class="col-md-2 ">
                                    <div class="input-group date" >
                                      <input class="datepicker" id="fecha_inicio" name="fecha_inicio" placeholder="Seleccione la Fecha">
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group row">
                                  <div class="col-md-2 izquierda">
                                    <label>Fecha Fin:</label>
                                  </div>
                                  <div class="col-md-2 ">
                                    <div class="input-group date">
                                      <input class="datepicker" id="fecha_fin" name="fecha_fin" placeholder="Seleccione la Fecha">
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
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

                    <div class="row" id="divDatosProducto" style="margin-top:2%">
                      <div class="col-md-12">
                        <div class="form-group row">
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-12">
                                <h5 style="font-weight: bold; border-bottom: 3px solid mediumaquamarine;">Datos del Producto</h5>
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <div class="col-md-4">
                                        <label>Lote:</label>
                                      </div>
                                      <div class="col-md-8">
                                        <input type="text" class="form-control" name="lote" id="lote" placeholder="Lote" >
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <div class="col-md-4">
                                        <label>Item(*):</label>
                                      </div>
                                      <div class="col-md-7">
                                        <input type="text" class="form-control" name="item" id="item" placeholder="Item" pattern="([0-9]{1,3})" >
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <div class="col-md-4">
                                        <label>Unidad Medida(*):</label>
                                      </div>
                                      <div class="col-md-8">
                                        <input type="text" class="form-control" name="unidad_medida" id="unidad_medida" placeholder="Unidad de medida"  title="Unidad de medida">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <div class="col-md-4">
                                        <label>Marca(*):</label>
                                      </div>
                                      <div class="col-md-7">
                                        <input type="text" class="form-control" name="nombre_comercial" id="nombre_comercial" maxlength="80" placeholder="Marca"  title="Ingrese la marca">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group row">
                                      <div class="col-md-4">
                                        <label>Precio U.(*):</label>
                                      </div>
                                      <div class="col-md-8">
                                        <input type="text" class="form-control" name="precio_unitario" id="precio_unitario" maxlength="15" placeholder="Precio unitario" >
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
                                  <div class="col-md-8">
                                    <div class="form-group row">
                                      <div class="col-md-3">
                                        <label>Procedencia(*):</label>
                                      </div>
                                      <div class="col-md-9">
                                        <input type="text" class="form-control" name="procedencia" id="procedencia" maxlength="80" placeholder="Procedencia"  title="Procedencia">
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-9">
                                    <div class="row">
                                      <div class="col-md-3">
                                        <label>Observaciones:</label>
                                      </div>
                                      <div class="col-md-9">
                                        <textarea class="form-control" name="obs" id="obs"></textarea>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                    <input type="hidden" class="form-control" name="fecha" id="fecha" value="<?php echo date("Y-m-d"); ?>">
                                  </div>
                                </div>
                                
                                <div class="row" style=" margin-top:2%">
                                    <div class="col-lg-12">
                                      <h5 style="font-weight: bold; border-bottom: 3px solid #018abd">Detalle Establecimiento Contrato</h5>
                                      <div class="row">
                                        <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                          <a id="btnAgregarDetalleLugarEntrega" data-toggle="modal" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" type="button" title="Agregar Detalle Lugar Entrega" style="border: 3px solid #018abd">
                                            <span><i class="fa fa-plus" style="color: #018abd; font-size:13px"></i></span></a>
                                        </div>
                                      </div>
                                      <table id="detallesEstablecimiento" class="table table-striped table-bordered table-condensed table-hover" style="display: inline-block; table-layout: fixed; width: 100%;">
                                        <thead style="background-color:#A9D0F5; font-size: 80%;">
                                          <th style="width:15px;"></th>
                                          <th>Establecimiento</th>
                                          <th>Can.Minima</th>
                                          <th>Can.Maxima</th>
                                          <th>Can.Emitida</th>
                                          <th>Monto Min.</th>
                                          <th>Monto Max.</th>
                                          <th>Monto Emitido</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                      </table>
                                    </div>
                                </div>
                             </div>
                            </div>
                          </div>
                          <div class="col-md-5">
                            <div class="form-group row">
                              <h5 style="font-weight: bold; border-bottom: 3px solid mediumaquamarine;">Cantidades</h5>

                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group row">
                                    <div class="col-md-4">
                                      <label>Mínima(*):</label>
                                    </div>
                                    <div class="col-md-7">
                                      <input type="text" class="form-control" name="cantidad_minima" id="cantidad_minima" maxlength="15" placeholder="Cantidad mínima" >
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group row">
                                    <div class="col-md-4">
                                      <label>Máxima(*):</label>
                                    </div>
                                    <div class="col-md-7">
                                      <input type="text" class="form-control" name="cantidad_adjudicada" id="cantidad_adjudicada" maxlength="15" placeholder="Cantidad máxima" >
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group row">
                                    <div class="col-md-4">
                                      <label>Emitida(*):</label>
                                    </div>
                                    <div class="col-md-7">
                                      <input type="text" class="form-control" name="cantidad_emitida" id="cantidad_emitida" placeholder="Cantidad emitida" >
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <h5 style="font-weight: bold; border-bottom: 3px solid mediumaquamarine;">Montos</h5>

                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group row">
                                    <div class="col-md-4">
                                      <label>Mínimo(*):</label>
                                    </div>
                                    <div class="col-md-7">
                                      <input type="text" class="form-control" name="monto_minimo" id="monto_minimo" maxlength="15" placeholder="Monto Minimo" >
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group row">
                                    <div class="col-md-4">
                                      <label>Máximo(*):</label>
                                    </div>
                                    <div class="col-md-7">
                                      <input type="text" class="form-control" name="monto_maximo" id="monto_maximo" maxlength="15" placeholder="Monto Maximo" >
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6">
                                  <div class=" row">
                                    <div class="col-md-4">
                                      <label>Emitido:</label>
                                    </div>
                                    <div class="col-md-7">
                                      <input type="text" class="form-control" name="monto_emitido" id="monto_emitido" maxlength="15" placeholder="Monto emitido" >
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="row" style=" margin-top:2%">
                                <div class="col-lg-12">
                                  <h5 style="font-weight: bold; border-bottom: 3px solid #018abd">Detalles de Entrega del Item</h5>
                                  <div class="row">
                                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                      <a id="btnAgregarEntrega" data-toggle="modal" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" type="button" title="Agregar Entrega de Item" style="border: 3px solid #018abd">
                                        <span><i class="fa fa-plus" style="color: #018abd; font-size:13px"></i></span></a>
                                    </div>
                                  </div>
                                  <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style="display: inline-block; table-layout: fixed; width: 100%;">
                                    <thead style="background-color:#A9D0F5; font-size: 80%;">
                                      <th style="width:15px;"></th>
                                      <th>Nro.</th>
                                      <th>Plazo</th>
                                      <th>Tipo Plazo</th>
                                      <th>Tipo Dias</th>
                                      <th>Tipo Descuento</th>
                                      <th>%</th>
                                      <th>% Complementario</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                  </table>
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
                      <!-- Popup para agregar lugar entrega contrato -->
                  
                   <div id="mpopupDetalleLugarEntrega" class="mpopup">
                      <!-- mPopup content -->
                      <div class="mpopup-content">
                        <div class="mpopup-head">
                          <span class="close">×</span>
                          <h2>Agregue Datos del Establecimiento Adjudicado</h2>
                        </div>
                        <div class="mpopup-main">
                             <div class="row" >
                                     
                                <div class="col-md-12">
                                  <div class="col-md-6">
                                    <div class="row">
                                      <div class="col-md-12" id="divcodigo_sucursal">
                                        <label>Establecimiento(*):</label>
                                        <select  id="codigo_sucursal_popup" name="codigo_sucursal_popup" class="form-control selectpicker" data-live-search="true"></select>
                                      </div>
                                    </div>
                                  </div>
                                </div>    
                             </div>
                             <div class="form-group row">
                              <div class="col-md-4">
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <label>Cantidad Maxima(*):</label>
                                    <input type="text" class="form-control" name="cantidad_maxima_popup" id="cantidad_maxima_popup" placeholder="Cantidad Maxima" >
                                    
                                  </div>
                                </div>
                              </div>
                             
                            </div>
                            <div class="form-group row">
                              <div class="col-md-4">
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <label>Cantidad Minima(*):</label>
                                      <input type="text" class="form-control" name="cantidad_minima_popup" id="cantidad_minima_popup" placeholder="Cantidad Minima" >
                                 
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <label>Cantidad Emitida(*):</label>
                                   <input type="text" class="form-control" name="cantidad_emitida_popup" id="cantidad_emitida_popup" placeholder="Cantidad Emitida" >
                                 
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-md-4">
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <label>Monto Maximo(*):</label>
                                  <input type="text" class="form-control" name="monto_maximo_popup" id="monto_maximo_popup" placeholder="Monto Maximo" >
                                 
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <label>Monto Minimo(*):</label>
                                     <input type="text" class="form-control" name="monto_minimo_popup" id="monto_minimo_popup" placeholder="Monto Minimo" >
                                  
                                  </div>
                                </div>
                              </div>
                                
                             <div class="col-md-3">
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <label>Monto Emitido(*):</label>
                                    <input type="text" id="monto_emitido_popup" name="monto_emitido_popup" class="form-control"></input>
                                  </div>
                                </div>
                              </div> 
                                
                                
                            </div>
                         

                          <div class="row">
                            <div class="col-sm-1">
                              <p><input class="btn btn-primary" style="background-color:lightskyblue; color:#333333;" type="button" id="idbtnDetalleEstablecimientoContrato" value="Agregar" onclick="agregarDetalleEstablecimientoContrato()"/></p>
                            </div>
                            <div class="col-sm-1">
                              <p><input class="btn btn-danger" style="background-color:lightcoral; color:#333333;" type="button" id="idbuttonCerrarPopupLugarEntrega" value="Cerrar" onclick="cerrarPopupLugarEntrega()" /></p>
                            </div>
                          </div>
                        </div>
                        <div class="mpopup-foot">
                          <p>DGGIES</p>
                        </div>
                      </div>
                    </div>    
                         
                    <!-- Popup para agregar entregas -->
                    <div id="mpopupBox" class="mpopup">
                      <!-- mPopup content -->
                      <div class="mpopup-content">
                        <div class="mpopup-head">
                          <span class="close">×</span>
                          <h2>Agregue el Detalle de Entrega</h2>
                        </div>
                        <div class="mpopup-main">
                          <div class="row" style="margin-left:2%">
                            <div class="col-md-3">
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <label>Nro. Entrega(*):</label>
                                    <select id="numero_entrega_popup" name="numero_entrega_popup" class="form-control selectpicker" data-live-search="true" >
                                      <option value="-1"> </option> 
                                      <option value="1"> Primera</option> 
                                      <option value="2"> Segunda</option> 
                                      <option value="3"> Tercera</option> 
                                      <option value="4"> Quinta</option> 
                                    </select>
                                 
                                  </div>
                                </div>
                              </div>    
                            <div class="form-group row">
                              <div class="col-md-4">
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <label>Tipo Dias(*):</label>
                                    <select id="codigo_tipo_dias_popup" name="codigo_tipo_dias_popup" class="form-control selectpicker" data-live-search="true" ></select>
                                  </div>
                                </div>
                              </div>
                             
                            </div>
                            <div class="form-group row">
                              <div class="col-md-4">
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <label>Tipo Plazo(*):</label>
                                    <select id="codigo_tipo_plazo_popup" name="codigo_tipo_plazo_popup" class="form-control selectpicker" data-live-search="true" ></select>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <label>Plazo(*):</label>
                                    <input id="plazo_popup" name="plazo_popup" class="form-control selectpicker" data-live-search="true" ></input>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-md-4">
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <label>Tipo Descuento(*):</label>
                                    <select id="codigo_tipo_descuento_item_popup" name="codigo_tipo_descuento_item_popup" class="form-control selectpicker" data-live-search="true" ></select>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <label>Porcentaje(*):</label>
                                    <input id="porcentaje_popup" name="porcentaje_popup" class="form-control selectpicker" data-live-search="true" ></input>
                                  </div>
                                </div>
                              </div>
                                
                             <div class="col-md-3">
                                <div class="form-group row">
                                  <div class="col-md-12">
                                    <label>Porcentaje Complementario(*):</label>
                                    <input id="porcentaje_complementario_popup" name="porcentaje_complementario_popup" class="form-control selectpicker" data-live-search="true" ></input>
                                  </div>
                                </div>
                              </div> 
                                
                                
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-sm-1">
                              <p><input class="btn btn-primary" style="background-color:lightskyblue; color:#333333;" type="button" id="idbtnEntregaItem" value="Agregar" onclick="agregarEntrega()"/></p>
                            </div>
                            <div class="col-sm-1">
                              <p><input class="btn btn-danger" style="background-color:lightcoral; color:#333333;" type="button" id="idbuttonCerrarPopup" value="Cerrar" onclick="cerrarPopup()" /></p>
                            </div>
                          </div>
                        </div>
                        <div class="mpopup-foot">
                          <p>DGGIES</p>
                        </div>
                      </div>
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
  <script type="text/javascript" src="scripts/contratoProducto.js"></script>
  <script type="text/javascript" src="scripts/util.js"></script>
<?php
}
ob_end_flush();
?>
<script>
  $("#botonBuscarProducto").on('click', function() {
    // limpiarCampos();
   $("#buscar").load("buscarProducto.html");
  //  $("#buscar").load("buscarItem.html");
    $("#buscar").fadeIn("slow");
    $("#titulo").fadeOut("slow");
    $("#formularioregistros").fadeOut("slow");

    $("#divcodigo_llamado").show();
    $("#divcodigo_proveedor").show();
    $("#divcodigo_estado_item_adjudicacion").show();
  });
</script>