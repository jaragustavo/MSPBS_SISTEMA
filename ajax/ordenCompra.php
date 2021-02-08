<?php
if (strlen(session_id())<1)
    session_start();

require_once "../modelos/OrdenCompra.php";

$ordenCompra=new OrdenCompra();
$codigo_orden_compra=isset($_POST["codigo_orden_compra"])? limpiarCadena($_POST["codigo_orden_compra"]):"";
$numero_orden_compra=isset($_POST["numero_orden_compra"])? limpiarCadena($_POST["numero_orden_compra"]):"";
$codigo_adjudicacion=isset($_POST["codigo_adjudicacion"])? limpiarCadena($_POST["codigo_adjudicacion"]):"";
$codigo_proveedor=isset($_POST["codigo_proveedor"])? limpiarCadena($_POST["codigo_proveedor"]):"";
$forma_pago=isset($_POST["forma_pago"])? limpiarCadena($_POST["forma_pago"]):"";
$fecha_contrato=isset($_POST["fecha_contrato"])? limpiarCadena($_POST["fecha_contrato"]):"";
$dias_plazo=isset($_POST["dias_plazo"])? limpiarCadena($_POST["dias_plazo"]):"";
$fecha_orden_compra=isset($_POST["fecha_orden_compra"])? limpiarCadena($_POST["fecha_orden_compra"]):"";
$condiciones_especiales=isset($_POST["condiciones_especiales"])? limpiarCadena($_POST["condiciones_especiales"]):"";
$lugar_entrega=isset($_POST["lugar_entrega"])? limpiarCadena($_POST["lugar_entrega"]):"";
$dependencia_solicitante=isset($_POST["dependencia_solicitante"])? limpiarCadena($_POST["dependencia_solicitante"]):"";
$tipo_plazo=isset($_POST["tipo_plazo"])? limpiarCadena($_POST["tipo_plazo"]):"";
$monto_total=isset($_POST["monto_total"])? limpiarCadena($_POST["monto_total"]):"";
$nombre_monto_total= convertir($monto_total);
$referencia=isset($_POST["referencia"])? limpiarCadena($_POST["referencia"]):"";
$usuario= $_SESSION['idusuario'];

switch ($_GET["op"]){
	case 'guardaryeditar':
                 if (empty($codigo_orden_compra)){
                       $rspta=$ordenCompra->insertar(  
                        $numero_orden_compra,$codigo_adjudicacion,
                        $codigo_proveedor,$forma_pago,
                        $fecha_contrato,$dias_plazo,
                        $fecha_orden_compra,$condiciones_especiales,
                        $lugar_entrega,$dependencia_solicitante,
                        $tipo_plazo,$monto_total,
                        $nombre_monto_total,$referencia,
                        $_POST("$item"),$_POST("$item"),
                        $_POST("$codigo_medicamento"),$_POST("$cantidad_emitir"),
                        $_POST("$cantidad_restante"),$_POST("$unidad_medida"),
                        $_POST("$marca"),$_POST("$procedencia"),
                        $_POST("$precio_unitario"));
                        echo $rspta ? "Orden Compra registrado" : "No se pudieron registrar todos los datos";
                }
        else {
            $rspta=$usuario->editar($idusuario,$nombre,$cedula_identidad,$login,$clavehash,$_POST['permiso']);
            // $rspta=$usuario->editar($idusuario,$nombre,$cedula_identidad,$login,$clavehash);
           
            echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
        }
       
            
	break;

	case 'desactivar':
		$rspta=$categoria->desactivar($idcategoria);
 		echo $rspta ? "Categoría Desactivada" : "Categoría no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$categoria->activar($idcategoria);
 		echo $rspta ? "Categoría activada" : "Categoría no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$categoria->mostrar($idcategoria);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$ordenCompra->listar();
 		//Vamos a declarar un array
 		$data= Array();
                while($reg = pg_fetch_row($rspta)){
 			$data[]=array(
 				"0"=>($reg[2])?'<button class="btn btn-warning" onclick="mostrar('.$reg[0].')"><i class="fa fa-eye"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg[0].')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg[0].')"><i class="fa fa-eye"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg[0].')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg[1],
 				"2"=>$reg[2],
 				"3"=>($reg[2]==1)?'<span class="label bg-green">Pendiente</span>':
 				'<span class="label bg-red">Permanente</span>'
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