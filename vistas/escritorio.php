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

if ($_SESSION['escritorio']==1)
{
    
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" >        
        <!-- Main content -->
        <section class="content" >
            <input type="hidden" class="form-control" name="medicamento" id="medicamento" value ="<?php echo $_SESSION['medicamento'][0].'{}'.$_SESSION['medicamento'][1].'{}'.$_SESSION['medicamento'][2].'{}'.$_SESSION['medicamento'][3].'{}'.$_SESSION['medicamento'][4].'{}'.$_SESSION['medicamento'][5].'{}'.$_SESSION['medicamento'][6].'{}'.$_SESSION['medicamento'][7].'{}'.$_SESSION['medicamento'][8].'{}'.$_SESSION['medicamento'][9]; ?>" >
            <input type="hidden" class="form-control" name="porcentaje_ejecucion" id="porcentaje_ejecucion" value ="<?php echo $_SESSION['porcentaje_ejecucion'][0].'{}'.$_SESSION['porcentaje_ejecucion'][1].'{}'.$_SESSION['porcentaje_ejecucion'][2].'{}'.$_SESSION['porcentaje_ejecucion'][3].'{}'.$_SESSION['porcentaje_ejecucion'][4].'{}'.$_SESSION['porcentaje_ejecucion'][5].'{}'.$_SESSION['porcentaje_ejecucion'][6].'{}'.$_SESSION['porcentaje_ejecucion'][7].'{}'.$_SESSION['porcentaje_ejecucion'][8].'{}'.$_SESSION['porcentaje_ejecucion'][9]; ?>" >
             <input type="hidden" class="form-control" name="cantidad_distribuida" id="cantidad_distribuida" value ="<?php echo $_SESSION['cantidad_distribuida'][0].'{}'.$_SESSION['cantidad_distribuida'][1].'{}'.$_SESSION['cantidad_distribuida'][2].'{}'.$_SESSION['cantidad_distribuida'][3].'{}'.$_SESSION['cantidad_distribuida'][4].'{}'.$_SESSION['cantidad_distribuida'][5].'{}'.$_SESSION['cantidad_distribuida'][6].'{}'.$_SESSION['cantidad_distribuida'][7].'{}'.$_SESSION['cantidad_distribuida'][8].'{}'.$_SESSION['cantidad_distribuida'][9]; ?>" >
      
            <div class="row" >
                <div class="col-md-12">
                <div class="chart-container" style="position: relative; height:40vh; width:80vw">
                     <canvas id="grafico1"></canvas>
                </div>
                    
                    <!--Fin centro -->
                  </div><!-- /.box -->
           </div><!-- /.col -->
       </section>
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

<script type="text/javascript" src="scripts/Chart.js"></script>
<script type="text/javascript" src="scripts/escritorio.js"></script>

<?php 
}
ob_end_flush();
?>


