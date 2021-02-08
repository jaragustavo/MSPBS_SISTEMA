
<?php 
ob_start();
if (strlen(session_id()) < 1){
	session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/ContratoAdenda.php";

$adenda= new ContratoAdenda();
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$codigo_llamado=isset($_POST["codigo_llamado"])? limpiarCadena($_POST["codigo_llamado"]):"";
$codigo_adjudicacion=isset($_POST["codigo_adjudicacion"])? limpiarCadena($_POST["codigo_adjudicacion"]):"";
$simese=isset($_POST["simese"])? limpiarCadena($_POST["simese"]):"";
$fecha_pedido=isset($_POST["fecha_pedido"])? limpiarCadena($_POST["fecha_pedido"]):"";
$fecha_vigencia=isset($_POST["fecha_vigencia"])? limpiarCadena($_POST["fecha_vigencia"]):"";
$fecha_adenda=isset($_POST["fecha_adenda"])? limpiarCadena($_POST["fecha_adenda"]):"";
$codigo_proveedor=isset($_POST["codigo_proveedor"])? limpiarCadena($_POST["codigo_proveedor"]):"";
$codigo_medicamento=isset($_POST["codigo_medicamento"])? limpiarCadena($_POST["codigo_medicamento"]):"";
$item=isset($_POST["item"])? limpiarCadena($_POST["item"]):"";
$lote=isset($_POST["lote"])? limpiarCadena($_POST["lote"]):"";
$cantidad_adjudicada=isset($_POST["cantidad_adjudicada"])? limpiarCadena($_POST["cantidad_adjudicada"]):"";
$cantidad_solicitada=isset($_POST["cantidad_solicitada"])? limpiarCadena($_POST["cantidad_solicitada"]):"";
$cantidad_emitida_ampliacion=isset($_POST["cantidad_emitida_ampliacion"])? limpiarCadena($_POST["cantidad_emitida_ampliacion"]):"";

$precio=isset($_POST["precio"])? limpiarCadena($_POST["precio"]):"";
$monto_ampliado=isset($_POST["monto_ampliado"])? limpiarCadena($_POST["monto_ampliado"]):"";
$porcentaje_solicitado=isset($_POST["porcentaje_solicitado"])? limpiarCadena($_POST["porcentaje_solicitado"]):"";                      
$observacion=isset($_POST["observacion"])? limpiarCadena($_POST["observacion"]):"";                          
$codigo_estado_item=isset($_POST["codigo_estado_item"])? limpiarCadena($_POST["codigo_estado_item"]):"";  
$codigo_sucursal_origen=isset($_POST["codigo_sucursal_origen"])? limpiarCadena($_POST["codigo_sucursal_origen"]):"";  

                       


switch ($_GET["op"]){
        case 'guardaryeditar':
        if (empty($codigo)){
            
            
            $rspta=$adenda->insertar($simese, $fecha_pedido, $fecha_vigencia, 
                                     $fecha_adenda, $codigo_proveedor, $codigo_medicamento, 
                                     $item, $lote, str_replace('.', '', $cantidad_adjudicada), str_replace('.', '', $cantidad_solicitada), 
                                     str_replace('.', '', $cantidad_emitida_ampliacion), str_replace('.', '', $precio), 
                                     str_replace('.', '', $monto_ampliado), $porcentaje_solicitado, $observacion, 
                                     $codigo_estado_item, $codigo_sucursal_origen,
                                     $codigo_adjudicacion,$codigo_llamado
                                     );
          // error_log('##########2344444 ');
           echo $rspta ? "Ampliacion registrada" : "No se pudieron registrar todos los datos de la adenda";
        }
        else {
                     
            $rspta=$adenda->editar($simese, $fecha_pedido, $fecha_vigencia, 
                           $fecha_adenda, str_replace('.', '', $cantidad_solicitada), 
                           str_replace('.', '', $cantidad_emitida_ampliacion),str_replace('.', '', $precio), 
                           str_replace('.', '', $monto_ampliado), $porcentaje_solicitado, $observacion, 
                           $codigo_estado_item, $codigo_sucursal_origen,$codigo
                           );
            echo $rspta ? "Ampliacion actualizada" : "Ampliacion no se pudo actualizar";
        }
        break;
    
        case 'listarProducto':
                
            $rspta=$producto->listarProducto();
            //Vamos a declarar un array
            $data= Array();

            while($reg = pg_fetch_array($rspta)){
                $data[]=array(
                    "0"=>$reg['codigo'],
                    "1"=>$reg['clasificacion_medicamento'],
                    "2"=>$reg['concentracion'],
                    "3"=>$reg['forma_farmaceutica'],
                    "4"=>$reg['presentacion']
                    );
            }
            $results = array(
                "sEcho"=>1, //Información para el datatables
                "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                "aaData"=>$data);
            
            
            echo json_encode($results);
        break;
    
  
	case 'listar':
		$rspta=$adenda->listar();
 		//Vamos a declarar un array
 		$data= Array();

                while ($reg = pg_fetch_array($rspta)) {
 		$data[]=array(
 			        "0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg['codigo'].')"><i class="fa fa-pencil"></i></button>',
                                "1"=>$reg['id_llamado'],
                                "2"=>$reg['licitacion'],
                            	"3"=>$reg['proveedor'],
                                "4"=>$reg['lote'],
                                "5"=>$reg['item'],
 				"6"=>$reg['codigo_medicamento'],
                                "7"=>$reg['producto'],
 				"8"=>number_format($reg['cantidad_adjudicada'],0,'','.'),
 				"9"=>number_format($reg['cantidad_emitida'],0,'','.'),
                                "10"=>number_format($reg['cantidad_solicitada'],0,'','.'),
                                "11"=>$reg['porcentaje_solicitado'],
                                "12"=>$reg['porcentaje_ampliacion_emitido'],  
                                "13"=>$reg['estado']
                    );

 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	
  
	
     case 'mostrar':
           $codigo_adenda = $_POST['codigo_adenda'];
           $rspta = $adenda->mostrar($codigo_adenda);
           $rspta = pg_fetch_array($rspta);

            echo json_encode($rspta);
     break;
     case 'obtenerAdjudicacion':
        $codigo_llamado = $_POST['codigo_llamado'];
     // error_log('##########2344444 '.$idpedido);
        $rspta = $adenda->obtenerAdjudicacion($codigo_llamado);
        $rspta = pg_fetch_array($rspta);

        echo json_encode($rspta);
        break;
    
  
          
    case 'listarProductoContrato':
                
            $rspta=$adenda->listarProductoContrato($codigo_adjudicacion,$codigo_proveedor);
            //Vamos a declarar un array
            $data= Array();

            while($reg = pg_fetch_array($rspta)){
                $data[]=array(
                    "0"=>$reg['lote'],
                    "1"=>$reg['item'],
                    "2"=>$reg['codigo_medicamento'],
                    "3"=>$reg['producto'],
                    "4"=>number_format($reg['precio_unitario'],0,'','.'),
                    "5"=>number_format($reg['cantidad_adjudicada'],0,'','.'),
                    "6"=>number_format($reg['cantidad_emitida'],0,'','.')
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

ob_end_flush();
?>