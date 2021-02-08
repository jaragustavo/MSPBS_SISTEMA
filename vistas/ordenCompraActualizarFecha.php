<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();


if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';

  if ($_SESSION['pedidoOrdenCompraReciboProveedor'] == 1) {
?>
    <style>
      .filter-option {
        font-size: 12px;
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
                <h1 class="box-title">Actualizar Fecha Orden Compra
                </h1>
              </div>
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th></th>
                    <th style="text-align:center;">Numero OC</th>
                    <!-- <th>Cod. Adjudicacion</th> -->
                    <th>Licitacion</th>
                    <th>Proveedor</th>
                    <th>Fecha Envio Correo</th>
                    <th>Fecha Ent. Proveedor</th>
                    <th>Plazo Entrega</th>
                    <th>Dias Plazo</th>
                    <th>Dias Habiles</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th></th>
                    <th style="text-align:center;">Numero OC</th>
                    <!-- <th>Cod. Adjudicacion</th> -->
                    <th>Licitacion</th>
                    <th>Proveedor</th>
                    <th>Fecha Envio Correo</th>
                    <th>Fecha Ent. Proveedor</th>
                    <th>Plazo Entrega</th>
                    <th>Dias Plazo</th>
                    <th>Dias Habiles</th>
                  </tfoot>
                </table>
              </div>
              <div class="panel-body" style="height:auto;" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="row" id="divActualizarFecha" style="font-size: 12px;">
                    <div class="col-md-12">
                      <div class="row" style="margin-left:2%">
                        <!-- codigo OC -->
                        <div class="col-md-6" id="divCodigo">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Código</label>
                            </div>
                            <div class="col-md-8">
                              <input id="codigo" name="codigo" type="text" class="form-control input-sm" placeholder="Codigo" disabled="true" style="text-transform:uppercase;">
                            </div>
                          </div>
                        </div>
                        <!-- Nro OC -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Nro. OC</label>
                            </div>
                            <div class="col-md-4">
                              <input id="numero_orden_compra" name="numero_orden_compra" type="text" class="form-control input-sm" placeholder="Número Nota Interna" style="text-transform:uppercase; font-size:15px">
                            </div>
                          </div>
                        </div>
                        <!-- Fecha Contrato -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Fecha Contrato</label>
                            </div>
                            <div class="col-md-8">
                              <input class="datepicker" id="fecha_contrato" name="fecha_contrato" placeholder="Fecha del Contrato">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row" style="margin-left:2%">
                        <!-- Licitacion -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Licitacion</label>
                            </div>
                            <div class="col-md-6">
                              <input id="licitacion" name="licitacion" type="text" class="form-control input-sm" placeholder="Número Nota Interna" style="text-transform:uppercase;">
                            </div>
                          </div>
                        </div>
                        <!-- Proveedor -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Proveedor</label>
                            </div>
                            <div class="col-md-6">
                              <select id="codigo_proveedor" name="codigo_proveedor" class="form-control selectpicker" data-live-search="true">
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row" style="margin-left:2%">
                        <!-- Fecha OC. -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4">
                              <label>Fecha OC.</label>
                            </div>
                            <div class="col-md-8">
                              <input class="datepicker" id="fecha_orden_compra" name="fecha_orden_compra" placeholder="Fecha de orden de compra">
                            </div>
                          </div>
                        </div>
                        <!-- Forma Pago -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Forma Pago</label>
                            </div>
                            <div class="col-md-6">
                              <input id="forma_pago" name="forma_pago" type="text" class="form-control input-sm" placeholder="Forma de Pago" style="text-transform:uppercase;">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row" style="margin-left:2%">
                        <!-- Lugar Entrega -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Lugar Entrega</label>
                            </div>
                            <div class="col-md-8">
                              <select id="lugar_entrega" name="lugar_entrega" class="form-control selectpicker" data-live-search="true">
                              </select>
                            </div>
                          </div>
                        </div>
                        <!-- Dependencia Solicitante -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Dependencia Solicitante</label>
                            </div>
                            <div class="col-md-8">
                              <select id="dependencia_solicitante" name="dependencia_solicitante" class="form-control selectpicker" data-live-search="true">
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row" style="margin-left:2%">
                        <!-- Estado OC -->
                        <div class="col-md-6">
                          <div class="form-group row" id="divEstado">
                            <div class="col-md-4 derecha">
                              <label>Estado OC.</label>
                            </div>
                            <div class="col-md-6">
                              <select id="codigo_estado" name="codigo_estado" class="form-control selectpicker" data-live-search="true">
                              </select>
                            </div>
                          </div>
                        </div>
                        <!-- Condiciones Especiales -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Condiciones Especiales</label>
                            </div>
                            <div class="col-md-8">
                              <textarea input id="condiciones_especiales" name="condiciones_especiales" type="text" class="form-control input-sm" placeholder="Condiciones Especiales" style="text-transform:uppercase;"></textarea>
                            </div>
                          </div>
                        </div>

                      </div>

                      <!-- seccion modificacion de fecha -->
                      <div style="border-top: 2px solid darkcyan; margin-bottom:10px;">

                      </div>
                      <div class="row" style="margin-left:2%">
                        <div class="col-md-6" id="divTipo_dias">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label for="codigo_tipo_dias"> Dias Habiles:</label><br>
                            </div>
                            <div class="col-md-4">
                              <!-- Rounded switch -->
                              <label class="switch">
                                <input type="checkbox" id="es_dia_habil" name="es_dia_habil" onchange="refreshPlazoEntrega()">
                                <span class="slider round"></span>
                                <input type="hidden" id="dia_habil" name="dia_habil">
                              </label>
                              <!-- <input type="checkbox" id="es_dia_habil" name="es_dia_habil"> -->
                            </div>
                          </div>
                        </div>
                        <!-- Dias Plazo -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Dias Plazo</label>
                            </div>
                            <div class="col-md-2">
                              <input id="dias_plazo_entrega" name="dias_plazo_entrega" type="text" class="form-control input-sm" placeholder="Dias de plazo" style="text-transform:uppercase;">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row" style="margin-left:2%" id="div_tipo_plazo">
                        <!-- Tipo Plazo -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Tipo Plazo</label>
                            </div>
                            <div class="col-md-8">
                              <select id="tipo_plazo" style="font-size:unset;" name="tipo_plazo" class="form-control selectpicker" data-live-search="true" onchange="refreshPlazoEntrega()">
                              </select>
                            </div>
                          </div>
                        </div>
                        <!-- Fecha Recibo Proveedor-->
                        <div class="col-md-3">
                          <div class="form-group row" id="divFecCorreo">
                            <div class="col-md-4">
                              <label id="label_envioCorreo">Fecha Envio Correo(*)</label>
                            </div>
                            <div class="col-md-8">
                              <div class="form-group row">
                                <div class="input-group date">
                                  <div class="col-md-8">
                                    <input class="datepicker" id="fecha_envio_correo" onchange="refreshPlazoEntrega()" name="fecha_envio_correo" placeholder="Envio correo">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group row" id="divFecProveedor">
                            <div class="col-md-4">
                              <label id="label_entregaProv">Fecha Recibo Prov.(*)</label>
                            </div>
                            <div class="col-md-8">
                              <div class="form-group row">
                                <div class="input-group date">
                                  <div class="col-md-8">
                                    <input class="datepicker" id="fecha_recepcion_oc_proveedor" onchange="refreshPlazoEntrega()" name="fecha_recepcion_oc_proveedor" placeholder="Recibo Proveedor">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                      <div class="row" style="margin-left:2%">
                        <div class="col-md-6" id="divArchivo">
                          <div class="form-group row">
                            <div class="col-md-4">
                              <label>Adjuntar Documento(*)</label>
                            </div>
                            <div class="col-md-6">
                               <input type="file" class="form-control" name="imagen" id="imagen">
                              <input type="hidden" name="imagenactual" id="imagenactual">  
                          
                            </div>
                            <div class="col-md-2">
                              <iframe src="" width="50px" height="50px" name="imagenmuestra" id="imagenmuestra" onclick="openTab(this)" href="#"></iframe>
                            </div>
                          </div>
                        </div>
                        <!-- Plazo Entrega -->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Plazo Entrega</label>
                            </div>
                            <div class="col-md-6">
                              <input class="datepicker" id="plazo_entrega" name="plazo_entrega" placeholder="Plazo de entrega">
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row" style="margin-left:2%" id="divObs">
                        <!-- Observacion de Auditoria-->
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-md-4 derecha">
                              <label>Obs. de Entrega</label>
                            </div>
                            <div class="col-md-8">
                              <textarea input id="obs_auditoria" name="obs_auditoria" type="text" class="form-control input-sm" placeholder="Observacion de los datos de la entrega de quien envio y quien recibio." style="text-transform:uppercase;"></textarea>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div style="border-top: 2px solid darkcyan; margin-bottom:10px;">

                      </div>
                    </div>
                  </div>

                  <div class="col-lg-12" id="divTblDetalles">
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style="overflow: scroll; display: inline-block; table-layout: fixed; width: 100%; font-size:12px;">
                      <thead style="background-color:#A9D0F5;">
                        <th></th>
                        <th>Elegir</th>
                        <th>Item</th>
                        <th>Codigo</th>
                        <th>Medicamento</th>
                        <th>Unidad de Medida</th>
                        <th>Marca</th>
                        <th>Procedencia</th>
                        <th>Cantidad a Emitir</th>
                        <th>Precio Unitario</th>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>Guardar</button>
                    <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>

                  </div>

                  <div class="col-lg-12" id="divTblFeriados">
                    <table id="feriados" class="table table-striped table-bordered table-condensed table-hover" style="overflow: scroll; display: inline-block; table-layout: fixed; width: 100%;">
                      <thead style="background-color:#A9D0F5;">
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </form>
                <!--Fin centro -->
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
  <script type="text/javascript" src="scripts/ordenCompraActualizarFecha.js"></script>
<?php
}
ob_end_flush();
?>