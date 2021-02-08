<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/Llamado.php";

 
$llamado=new Llamado();

$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$id_llamado=isset($_POST["id_llamado"])? limpiarCadena($_POST["id_llamado"]):"";
$fecha_llamado=isset($_POST["fecha_llamado"])? limpiarCadena($_POST["fecha_llamado"]):"";
$tipo_llamado=isset($_POST["tipo_llamado"])? limpiarCadena($_POST["tipo_llamado"]):"";
$codigo_tipo_llamado=isset($_POST["codigo_tipo_llamado"])? limpiarCadena($_POST["codigo_tipo_llamado"]):"";
$codigo_estado_llamado=isset($_POST["codigo_estado_llamado"])? limpiarCadena($_POST["codigo_estado_llamado"]):"";
$numero=isset($_POST["numero"])? limpiarCadena($_POST["numero"]):"";
$anio=isset($_POST["anio"])? limpiarCadena($_POST["anio"]):"";
$titulo=isset($_POST["idtitulo"])? limpiarCadena($_POST["idtitulo"]):"";
$codigo_pedido_producto=isset($_POST["codigo_pedido_producto"])? limpiarCadena($_POST["codigo_pedido_producto"]):"";
$observacion=isset($_POST["observacion"])? limpiarCadena($_POST["observacion"]):"";
$numero_pac=isset($_POST["numero_pac"])? limpiarCadena($_POST["numero_pac"]):"";


switch ($_GET["op"]){ 
    case 'guardaryeditar':
        if (empty($codigo)){
            $rspta=$llamado->insertar($id_llamado,$fecha_llamado,$codigo_tipo_llamado,$numero,$anio,$titulo,$observacion,$codigo_pedido_producto,$numero_pac);
            echo $rspta ? "Llamado registrado" : "No se pudieron registrar todos los datos del Llamado";
        }
        else {
          $rspta=$llamado->editar($codigo,$id_llamado,$fecha_llamado,$codigo_tipo_llamado,$numero,$anio,$titulo,$observacion,$codigo_pedido_producto,$codigo_estado_llamado,$numero_pac);
            echo $rspta ? "Llamado modificado" : "No se pudo modificar el Llamado";
        }
    break;

    case 'mostrar':
            $codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";

            $rspta=$llamado->mostrar($codigo);
            $rspta = pg_fetch_array($rspta);
            
            echo json_encode($rspta);
    break;

    case 'listar':
        $rspta=$llamado->listar();
        //Vamos a declarar un array
        $data= Array();
        while($reg = pg_fetch_array($rspta)){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg['codigo'].')"><i class="fa fa-pencil"></i></button>',
                "1"=>$reg['id_llamado'],
                "2"=>$reg['fecha_llamado'],
                "3"=>$reg['tipo_llamado'],
                "4"=>$reg['numero'],
                "5"=>$reg['anio'],
                "6"=>$reg['titulo'],
                "7"=>$reg['codigo_pedido_producto'],
                "8"=>$reg['observacion'],
                "9"=>$reg['numero_pac']
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
 
    break;

    
     case 'listarPedidoProducto':
        $rspta=$llamado->listarPedidoProducto();
        //Vamos a declarar un array
        $data= Array();
        while($reg = pg_fetch_array($rspta)){
            $data[]=array(
                "0"=>$reg['codigo'],
                "1"=>$reg['fecha_pedido'],
                "2"=>$reg['establecimiento'],
                "3"=>$reg['numero_expediente'],
                "4"=>$reg['numero_nota'],
                "5"=>$reg['estado_pedido'],
                "6"=>$reg['obs']
               
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

