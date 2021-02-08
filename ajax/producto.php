<?php 
ob_start();
if (strlen(session_id()) < 1){
	session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/Producto.php";

$producto=new Producto();

$codigo_adjudicacion=isset($_POST["idllamado"])? limpiarCadena($_POST["idllamado"]):"";
$precio_unitario=isset($_POST["precio_unitario"])? limpiarCadena($_POST["precio_unitario"]):"";
$cantidad_adjudicada=isset($_POST["cantidad_adjudicada"])? limpiarCadena($_POST["cantidad_adjudicada"]):"";
$codigo_medicamento=isset($_POST["codigo_medicamento"])? limpiarCadena($_POST["codigo_medicamento"]):"";
$codigo_proveedor=isset($_POST["codigo_proveedor"])? limpiarCadena($_POST["codigo_proveedor"]):"";
$nombre_comercial=isset($_POST["nombre_comercial"])? limpiarCadena($_POST["nombre_comercial"]):"";
$item=isset($_POST["item"])? limpiarCadena($_POST["item"]):"";
$unidad_medida=isset($_POST["unidad_medida"])? limpiarCadena($_POST["unidad_medida"]):"";
$procedencia=isset($_POST["procedencia"])? limpiarCadena($_POST["procedencia"]):"";
$cantidad_emitida=isset($_POST["cantidad_emitida"])? limpiarCadena($_POST["cantidad_emitida"]):"";
$cantidad_minima=isset($_POST["cantidad_minima"])? limpiarCadena($_POST["cantidad_minima"]):"";


switch ($_GET["op"]){
    
    
    case 'guardaryeditar':
        if (empty($idcodigo)){
            $rspta=$producto->insertar($precio_unitario, $cantidad_adjudicada, 
                                       $codigo_medicamento, $codigo_adjudicacion, 
                                       $codigo_proveedor, $nombre_comercial, $item,
                                       $unidad_medida, $procedencia,$cantidad_emitida,
                                       $cantidad_minima);
            echo $rspta ? "Detalle Contrato registrado" : "No se pudieron registrar todos los datos del contrato";
        }
        else {
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
		$rspta=$producto->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idproducto.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idproducto.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->lote,
 				"2"=>$reg->item,
 				"3"=>$reg->descripcion,
 				"4"=>$reg->unidadmedida,
 				"5"=>$reg->presentacion,
 				"6"=>$reg->marca,
 				"7"=>$reg->procedencia,
 				"8"=>($reg->estado)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'selectTipo':
		$rspta = $producto->selectTipo();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idtipoproducto . '>' . $reg->nombre . '</option>';
				}
	break;

	case 'selectGrupo':
		$rspta = $producto->selectGrupo();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idgrupo . '>' . $reg->nombre . '</option>';
				}
	break;

	case 'selectRubro':
		$rspta = $producto->selectRubro();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idrubro . '>' . $reg->nombre . '</option>';
				}
	break;

	case 'selectLlamado':
		$rspta = $producto->selectLlamado();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idllamado . '>' . $reg->llamado . '</option>';
				}
	break;		

	case 'selectProveedor':
		$rspta = $producto->selectProveedor();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idproveedor . '>' . $reg->empresa . '</option>';
				}
	break;
}

ob_end_flush();
?>