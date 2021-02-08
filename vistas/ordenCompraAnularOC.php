<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();


if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';

  if ($_SESSION['emisionCvpOrdenCompra'] == 1) {
?>
    <style>
        .filter-option {
            font-size: 9px;
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
                            <h1 class="box-title">Anular Orden de Compra
                                <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        </div>
                        <div class="panel-body table-responsive" id="listadoregistros">
                            <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                    <th>Opciones</th>
                                    <th>Numero OC</th>
                                    <th>Licitacion</th>
                                    <th>Proveedor</th>
                                    <th>Fecha OC</th>
                                    <th>Fecha de Recepcion</th>
                                    <th>Estado OC</th>
                                    <th>Monto Total</th>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <th>Opciones</th>
                                    <th>Numero OC</th>
                                    <th>Licitacion</th>
                                    <th>Proveedor</th>
                                    <th>Fecha OC</th>
                                    <th>Fecha de Recepcion</th>
                                    <th>Estado OC</th>
                                    <th>Monto Total</th>
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
                                                    <div class="col-md-4">
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
                                                        <input id="numero_orden_compra" name="numero_orden_compra" type="text" class="form-control input-sm" placeholder="Número Nota Interna" style="text-transform:uppercase;">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Fecha Contrato -->
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-md-4 derecha">
                                                        <label>Fecha Contrato</label>
                                                    </div>
                                                    <div class="col-md-4">
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
                                                    <div class="col-md-4">
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
                                                    <div class="col-md-5">
                                                        <select id="codigo_proveedor" name="codigo_proveedor" class="form-control selectpicker" data-live-search="true">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-left:2%">
                                            <!-- Dias Plazo -->
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-md-4 derecha">
                                                        <label>Dias Plazo</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input id="dias_plazo_entrega" name="dias_plazo_entrega" type="text" class="form-control input-sm" placeholder="Dias de plazo" style="text-transform:uppercase;">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Fecha OC. -->
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-md-4 derecha">
                                                        <label>Fecha OC.</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="datepicker" id="fecha_orden_compra" name="fecha_orden_compra" placeholder="Fecha de orden de compra">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-left:2%">
                                            <!-- Fecha Recibo Proveedor-->
                                            <div class="col-md-6">
                                                <div class="form-group row" id="divFecProveedor">
                                                    <div class="col-md-4">
                                                        <label>Fecha Recibo Prov.</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="datepicker" id="fecha_recepcion_oc_proveedor" onchange="refreshPlazoEntrega()" name="fecha_recepcion_oc_proveedor" placeholder="Recibo Proveedor">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Lugar Entrega -->
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-md-4 derecha">
                                                        <label>Lugar Entrega</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select id="lugar_entrega" name="lugar_entrega" class="form-control selectpicker" data-live-search="true"></select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-left:2%">
                                            <!-- Condiciones Especiales -->
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-md-4 derecha">
                                                        <label>Condiciones Especiales</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <textarea style="font-size:12px;" input id="condiciones_especiales" name="condiciones_especiales" type="text" class="form-control input-sm" placeholder="Lugar de entrega" style="text-transform:uppercase;"></textarea>
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
                                                        <input id="forma_pago" name="forma_pago" type="text" class="form-control input-sm" placeholder="Lugar de entrega" style="text-transform:uppercase;"></input>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-left:2%">
                                            <!-- Estado OC -->
                                            <div class="col-md-6">
                                                <div class="form-group row" id="divEstado">
                                                    <div class="col-md-4">
                                                        <label>Estado OC.</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select id="codigo_estado" name="codigo_estado" class="form-control selectpicker" data-live-search="true"></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5" style="bottom: 20px;">
                                                <div class="form-group row" style="border-left-width: 2px;border-left-style: solid;border-top-width: 2px;border-top-style: solid;border-right-width: 2px;border-right-style: solid;border-bottom-width: 2px;border-bottom-style: solid;padding-top: 5px;padding-bottom: 5px;padding-right: 5px;padding-left: 5px; border-color:red;">
                                                    <div class="col-md-5 derecha">
                                                        <label style="margin-top: 20px;">Motivo de Anulacion*</label>
                                                    </div>
                                                    <div class="col-md-7 has-danger">
                                                        <textarea id="observacion" name="observacion" class="form-control input-sm"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12" id="divTblDetalles">
                                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" style="overflow: scroll; display: inline-block; table-layout: fixed; width: 100%;">
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
                                            <th>Monto</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <button class="btn btn-primary" type="submit" id="btnGuardar" style="margin-right: 20px;"><i class="fa fa-save"></i> Anular</button>
                                    <button class="btn btn-danger" id="btnCancelar" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                </div>
                            </form>
                            <!--Fin centro -->
                        </div>
                        <!--Fin centro -->

                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
    <!--Fin-Contenido-->
    <?php
  } else {
    require 'noacceso.php';
  }

  require 'footer.php';
  ?>
        <script type="text/javascript" src="scripts/ordenCompraAnularOC.js"></script>

        <?php
}
ob_end_flush();
?>