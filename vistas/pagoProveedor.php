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
 
if ($_SESSION['adjudicacion']==1)
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
                        <h1 class="box-title">Pago Proveedor</h1>
                    </div>
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th></th>
                              <th>Id.Llamado</th> 
                            <th>Llamado</th>
                            <th>Titulo</th>
                            <th>Monto Adjudicado</th>
                            <th>Monto Recepcion</th>
                            <th>Monto Factura</th>
                            <th>Monto Obligado</th>
                            <th>Obs.</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          <tfoot>
                            <th></th>
                             <th>Id.Llamado</th> 
                            <th>Llamado</th>
                            <th>Titulo</th>
                            <th>Monto Adjudicado</th>
                            <th>Monto Recepcion</th>
                            <th>Monto Factura</th>
                            <th>Monto Obligado</th>
                            <th>Obs.</th>
                          </tfoot>
                        </table>
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
          <h4 class="modal-title">Lista de Proveedores</h4>
        </div>
        <div class="modal-body">
          <table id="tblModal" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
               <th>Opciones</th>
                 <th>Proveedor</th>
                 <th>Monto Maximo</th>
                 <th>Monto Minimo</th>
                 <th>Monto Emitido</th>
                <th>Monto Factura</th>
                <th>Monto Obligado</th>
              </thead>
            <tbody>
               
            </tbody>
            <tfoot>
            <th>Opciones</th>
            <th>Proveedor</th>
             <th>Monto Maximo</th>
             <th>Monto Minimo</th>
             <th>Monto Emitido</th>
             <th>Monto Factura</th>
             <th>Monto Obligado</th>
           
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
  <script type="text/javascript" src="scripts/pagoProveedor.js"></script>
<?php 
}
ob_end_flush();
?>