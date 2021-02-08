<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Util.php";

 
$util=new Util();

$idusuario=$_SESSION["idusuario"];
//$idusuario=1; 
switch ($_GET["op"]){
    
    
     case 'selectMedicamento':
       

        $rspta = $util->selectMedicamento();
       echo '<option value="-1">  </option>';
        while($reg = pg_fetch_array($rspta))
                {
           
                echo '<option value=' . $reg['codigo'] . '>' . $reg['producto'] . '</option>';
                }
     break;
       case 'selectEstado':
          require_once "../modelos/Util.php";
          $util = new Util();
          $rspta = $util->selectEstado();
          echo '<option value="-1"> </option>';
          while($reg = pg_fetch_array($rspta))
              {
              echo '<option value=' . $reg['codigo'] . '>' . $reg['descripcion'] . '</option>'; 
              
              }
      break;
      case 'selectSucursal':
         // error_log ("entre");
          require_once "../modelos/Util.php";
          $util = new Util();
          $rspta = $util->selectSucursal();
          echo '<option value="-1"> </option>';
          while($reg = pg_fetch_array($rspta))
              {
              echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>'; 
              
              }
      break;
       case 'selectHospitalRegiones':
          require_once "../modelos/Util.php";
          $util = new Util();
          $rspta = $util->selectHospitalRegiones();
          echo '<option value="-1"> </option>';
          while($reg = pg_fetch_array($rspta))
              {
              echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>'; 
              
              }
      break;
     case 'selectDependenciaMsp':
          require_once "../modelos/Util.php";
          $util = new Util();
          $rspta = $util->selectDependenciaMsp();
          echo '<option value="-1"> </option>';
          while($reg = pg_fetch_array($rspta))
              {
              echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>'; 
              
              }
      break;
      
      case 'selectUsuarioDependencia':
          require_once "../modelos/Util.php";
          $util = new Util();
          $rspta = $util->selectUsuarioDependencia();
          echo '<option value="-1"> </option>';
          while($reg = pg_fetch_array($rspta))
              {
              echo '<option value=' . $reg['idusuario'] . '>' . $reg['nombre_usuario'] . '</option>'; 
              
              }
      break;
     
      case 'selectEstadoPedido':
          require_once "../modelos/Util.php";
          $util = new Util();
          $rspta = $util->selectEstadoPedido();
          echo '<option value="-1"> </option>';
          while($reg = pg_fetch_array($rspta))
              {
              echo '<option value=' . $reg['codigo'] . '>' . $reg['descripcion'] . '</option>'; 
              
              }
      break;
        case 'selectTipoPedido':
          require_once "../modelos/Util.php";
          $util = new Util();
          $rspta = $util->selectTipoPedido();
          echo '<option value="-1"> </option>';
          while($reg = pg_fetch_array($rspta))
              {
              echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>'; 
              
              }
      break;
         case 'selectEstadoLlamado':
          require_once "../modelos/Util.php";
          $util = new Util();
          $rspta = $util->selectEstadoLlamado();
          echo '<option value="-1"> </option>';
          while($reg = pg_fetch_array($rspta))
              {
              echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>'; 
              
              }
      break;
          case 'selectTipoDescuentoSaldo':
          require_once "../modelos/Util.php";
          $util = new Util();
          $rspta = $util->selectTipoDescuentoSaldo();
          echo '<option value="-1"> </option>';
          while($reg = pg_fetch_array($rspta))
              {
              echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>'; 
              
              }
      break;
     case 'selectProveedor':
       $rspta = $util->selectProveedor();
       echo '<option value="-1">  </option>';
        while($reg = pg_fetch_array($rspta))
                {
                           echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>';
                }
     break;
     case 'selectLlamado':
     $rspta = $util->selectLlamado();
       echo '<option value="-1">  </option>';
        while($reg = pg_fetch_array($rspta))
                {
                echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>';
                }
     break;
      case 'selectEstadoItem':
     $rspta = $util->selectEstadoItem();
       echo '<option value="-1">  </option>';
        while($reg = pg_fetch_array($rspta))
                {
                echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>';
                }
     break;
      case 'selectTipoDias':
     $rspta = $util->selectTipoDias();
       echo '<option value="-1">  </option>';
        while($reg = pg_fetch_array($rspta))
                {
                echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>';
                }
     break;
      case 'selectTipoPlazo':
     $rspta = $util->selectTipoPlazo();
       echo '<option value="-1">  </option>';
        while($reg = pg_fetch_array($rspta))
                {
                echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>';
                }
     break;
      case 'selectTipoDescuentoItem':
     $rspta = $util->selectTipoDescuentoItem();
       echo '<option value="-1">  </option>';
        while($reg = pg_fetch_array($rspta))
                {
                echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>';
                }
     break;
     case 'listarProducto':
            $result = $util->listarProducto();
            $tabla="";
            while($row = pg_fetch_row($result)){
                $tabla = $tabla."<tr>"
                                       ."<td class='centrado'>".$row[0]."</td>"
                                       ."<td>".$row[1]."</td>"
                                       ."</tr>";
            }
            $objeto = new stdClass();
            $objeto->mensaje ="Datos encontrados";
            $objeto->contenido = $tabla;
            $json = json_encode($objeto);
            echo($json);
         break;
         
         case 'selectTipoLlamado':
            require_once "../modelos/Util.php";
            $util = new Util();
            $rspta = $util->selectTipoLlamado();
            echo '<option value="-1"> </option>';
            while($reg = pg_fetch_array($rspta))
                {
                echo '<option value=' . $reg['codigo'] . '>' . $reg['abreviacion'] . '</option>'; 
          
          }
          break; 
         
           case 'selectAdjudicacion':
                $rspta = $util->selectAdjudicacion();
                  echo '<option value="-1">  </option>';
                   while($reg = pg_fetch_array($rspta))
                           {
                           echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>';
                           }
                break;
    
   
}
?>

