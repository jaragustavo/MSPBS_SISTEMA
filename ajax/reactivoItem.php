<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/covidItem.php";

 
$itemCovid=new ItemCovid();

$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$especificacion_tecnica=isset($_POST["especificacion_tecnica"])? limpiarCadena($_POST["especificacion_tecnica"]):"";
$observacion=isset($_POST["observacion"])? limpiarCadena($_POST["observacion"]):"";
$codigo_estado=isset($_POST["codigo_estado"])? limpiarCadena($_POST["codigo_estado"]):"";
$presentacion=isset($_POST["presentacion"])? limpiarCadena($_POST["presentacion"]):"";
$presentacion_entrega=isset($_POST["presentacion_entrega"])? limpiarCadena($_POST["presentacion_entrega"]):"";
$codigo_catalogo=isset($_POST["codigo_catalogo"])? limpiarCadena($_POST["codigo_catalogo"]):"";



 
switch ($_GET["op"]){ 
    case 'guardaryeditar':
         if (empty($codigo)){
            
            $rspta=$itemCovid->insertar($codigo_catalogo,$item_numero,$nombre,$especificacion_tecnica,
            $presentacion,$presentacion_entrega,$monto,$cantidad_necesitada,$observacion);
            echo $rspta ? "Reactivo Registrado" : "No se pudieron registrar todos los datos del Reactivo";
        }
        else {
            
          $rspta=$itemCovid->editar($codigo,$codigo_catalogo,$item_numero,$nombre,$especificacion_tecnica,
          $presentacion,$presentacion_entrega,$monto,$cantidad_necesitada,$observacion,$fecha_inicio,
          $fecha_cierre,$codigo_estado,$_POST["condicion_item"],$imagen);
            echo $rspta ? "Item modificado" : "No se pudo modificar el Item";
        }
    break;

    case 'mostrar':
            $codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
            $rspta=$itemCovid->mostrar($codigo);
            $rspta = pg_fetch_array($rspta);
            echo json_encode($rspta);
        break;
      case 'listarCondicionItem':
            $codigo=isset($_GET["codigo"])? limpiarCadena($_GET["codigo"]):"";
         // error_log('##########3 '.$codigo);
            $rspta=$itemCovid->listarCondicionItem($codigo);
        while($reg = pg_fetch_array($rspta)){
          echo '<tr id="fila'.$reg['codigo'].'" class="filas" style="font-size: 12px;">
  <td style="text-align: center;"><a class="btn btn-accent m-btn m-btn--custom 
  m-btn--icon m-btn--air m-btn--pill type="button" onclick="eliminarDetalle('.$reg['codigo'].')">
  <span><i class="fa fa-trash" style="color: indianred; font-size: 1.5em; "></i></span></a>
  <td scope="col"><div style="width: 120px;"><input title="'.$reg['descripcion'].'"type="text"
  readonly="readonly"  name="condicion_item[]" id="condicion_item[]"  value="'.$reg['descripcion'].'"></div></td>
               </tr>';

               
                  }
        break;

   
    case 'listar':
        $rspta=$itemCovid->listar();
        //Vamos a declarar un array
        $data= Array();
        while($reg = pg_fetch_array($rspta)){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg['codigo'].')"><i class="fa fa-pencil"></i></button>',
                "1"=>$reg['codigo_catalogo'],
                "2"=>$reg['nombre'],
                "3"=>$reg['especificacion_tecnica'],
                "4"=>$reg['presentacion'],
                "5"=>$reg['presentacion_entrega'],
                "6"=>$reg['observacion'],
                "7"=>$reg['codigo_estado']
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;

    

}
?>

