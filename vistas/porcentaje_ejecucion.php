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
 
if ($_SESSION['pedidoOrdenCompraReciboProveedor']==1)
{
?>
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                  <div class="box-header with-border">
                          <h3 class="">Indicador de Porcentaje de Ejecución de Contratos</h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tblConsolidado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Cod. Med.</th>    <!--0-->
                            <th>Producto</th>     <!--1-->
                            <th>Llamado</th>      <!--2-->
                            <th>Proveedor</th>    <!--3-->
                            <th>Cant. Mínima</th> <!--4-->
                            <th>Cant. Máxima</th> <!--5-->
                            <th>Cant. Emitida</th> <!--6-->                            
                            <th>Por. s/Máxima</th><!--7-->
                          </thead>
                          <tbody>                               
                          </tbody>
                         
                        </table>
                    </div>
                     
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
    
        
<?php
}
else
{
  require 'noacceso.php';
}
 
require 'footer.php';
?>
  <script type="text/javascript" src="scripts/porcentaje_ejecucion.js"></script>


<?php 
}
ob_end_flush();
?>






