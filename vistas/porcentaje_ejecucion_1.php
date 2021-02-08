<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Indicador de Porcentaje de Ejecución de Contratos</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../public/css/font-awesome.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <link rel="apple-touch-icon" href="public/img/apple-touch-icon.png">
    <link rel="shortcut icon" href="public/img/favicon.ico">
    <!--LIBRERIAS DE DATATABLES-->
    <link rel="stylesheet" type="text/css" href="../public/datatables/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../public/datatables/responsive.dataTables.min.css">
    <!--LIBRERIAS DE SELECT-->
    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">
    <!--estilo libre-->
      <style>
        h3,h4 { color: #0B0B3B; }
      </style>
    </head>
    <body>
       <!--######################
        BARRA NAV PARA MOSTRAR LOGO DEL MINISTERIO-->
      <nav class="navbar navbar-light bg-faded">
        <a class="navbar-brand" href="#">
          <img class="rounded mx-auto d-block" src="../images/logomspbs.png" >
        </a>
      </nav>

        <!--Contenido-->
      <!-- Content Wrapper. Contains page content 
      <div class="content-wrapper">      --> 
        <!-- Main content -->
        <section class="content">
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
      </section><!-- /.content -->
    <!--</div> /.content-wrapper -->
  <!--Fin-Contenido-->
  
  
  
  <!-- jQuery 2.1.4 -->
    <script src="../public/js/jquery-3.1.1.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../public/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../public/js/app.min.js"></script>
    <!-- Js de ALERT -->
    <script src="../public/js/bootbox.min.js"></script>
    <!-- LIBRERIA DE SELECT -->
    <script src="../public/js/bootstrap-select.min.js"></script>
    <!--LIBRERIA DE DATATABLES-->
    <script src="../public/datatables/jquery.dataTables.min.js"></script>
    <script src="../public/datatables/jszip.min.js"></script>
    <script src="../public/datatables/pdfmake.min.js"></script>
    <script src="../public/datatables/vfs_fonts.js"></script>
    <script src="../public/datatables/buttons.colVis.min.js"></script>
    <script src="../public/datatables/buttons.html5.min.js"></script>
    <script src="../public/datatables/dataTables.buttons.min.js"></script>
    
    </body>
</html>
<script type="text/javascript" src="scripts/porcentaje_ejecucion.js"></script>









