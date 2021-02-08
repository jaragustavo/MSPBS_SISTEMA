<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Escritorio.php";
$escritorio= new Escritorio();

//$idusuario=1; 
switch ($_GET["op"]){
   
    case 'obtenerDatos':
        
        $rspta=$escritorio->obtenerDatos();
        //Vamos a declarar un array
        while($reg = pg_fetch_row($rspta))
        {
           echo '<tr class="filas"><td><input name="codigo_medicamento" id="codigo_medicamento" type="checkbox" checked value="'.$reg[0].'"> '.$reg[0].'</td><td><input name="medicamento" id="medicamento" type="hidden" value="'.$reg[1].'"> '.$reg[1].'</td><td><input name="porcentaje_ejecucion" id="porcentaje_ejecucion" type="hidden" value="'.$reg[3].'"> '.$reg[3].'</td><td><input name="cantidad_distribuida" id="cantidad_distribuida" type="hidden" value="'.$reg[4].'"> '.$reg[4].'</td></tr>';
        }
       
    break;
  
}
?>

