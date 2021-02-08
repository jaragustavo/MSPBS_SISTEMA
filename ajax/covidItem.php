<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/covidItem.php";

 
$itemCovid=new ItemCovid();

$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$item_numero=isset($_POST["item_numero"])? limpiarCadena($_POST["item_numero"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$especificacion_tecnica=isset($_POST["especificacion_tecnica"])? limpiarCadena($_POST["especificacion_tecnica"]):"";
$monto=isset($_POST["monto"])? limpiarCadena($_POST["monto"]):"";
$cantidad_necesitada=isset($_POST["cantidad_necesitada"])? limpiarCadena($_POST["cantidad_necesitada"]):"";
$observacion=isset($_POST["observacion"])? limpiarCadena($_POST["observacion"]):"";
$fecha_inicio=isset($_POST["fecha_inicio"])? limpiarCadena($_POST["fecha_inicio"]):"";
$fecha_cierre=isset($_POST["fecha_cierre"])? limpiarCadena($_POST["fecha_cierre"]):"";
$codigo_estado=isset($_POST["codigo_estado"])? limpiarCadena($_POST["codigo_estado"]):"";
$presentacion=isset($_POST["presentacion"])? limpiarCadena($_POST["presentacion"]):"";
$presentacion_entrega=isset($_POST["presentacion_entrega"])? limpiarCadena($_POST["presentacion_entrega"]):"";
$codigo_catalogo=isset($_POST["codigo_catalogo"])? limpiarCadena($_POST["codigo_catalogo"]):"";



 
switch ($_GET["op"]){ 
    case 'guardaryeditar':
        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $imagen = $_POST["imagenactual"];
        } else {
            $ext = explode(".", $_FILES["imagen"]["name"]);

            if ($_FILES['imagen']['type'] == "application/pdf" || $_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
                // error_log('##### '.$_FILES['imagen']['type']);
                $imagen = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/ofertaProveedor/" . $imagen);
            }
        }
        if (empty($codigo)){
            
            $rspta=$itemCovid->insertar($codigo_catalogo,$item_numero,$nombre,$especificacion_tecnica,
            $presentacion,$presentacion_entrega,$monto,$cantidad_necesitada,$observacion,$fecha_inicio,
            $fecha_cierre,$_POST["condicion_item"],$imagen);
            echo $rspta ? "Item Registrado" : "No se pudieron registrar todos los datos del Item";
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
                "2"=>$reg['item_numero'],
                "3"=>$reg['nombre'],
                "4"=>$reg['especificacion_tecnica'],
                "5"=>$reg['presentacion'],
                "6"=>$reg['presentacion_entrega'],
                "7"=>$reg['monto'],
                "8"=>$reg['cantidad_necesitada'],
                "9"=>$reg['observacion'],
                "10"=>$reg['fecha_inicio'],
                "11"=>$reg['fecha_cierre'],
                "12"=>$reg['codigo_estado']
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

