
<?php 
ob_start();
if (strlen(session_id()) < 1){
	session_start();//Validamos si existe o no la sesión
}
require_once "../modelos/ContratoProducto.php";

$producto=new ContratoProducto();
$codigo_adjudicacion=isset($_POST["codigo_adjudicacion"])? limpiarCadena($_POST["codigo_adjudicacion"]):"";
$monto_adjudicado=isset($_POST["monto_adjudicado"])? limpiarCadena($_POST["monto_adjudicado"]):"";
$fecha_adjudicacion=isset($_POST["fecha_adjudicacion"])? limpiarCadena($_POST["fecha_adjudicacion"]):"";

$codigo_contrato=isset($_POST["codigo_contrato"])? limpiarCadena($_POST["codigo_contrato"]):"";
$numero_contrato=isset($_POST["numero_contrato"])? limpiarCadena($_POST["numero_contrato"]):"";
$fecha_inicio=isset($_POST["fecha_inicio"])? limpiarCadena($_POST["fecha_inicio"]):"";
$fecha_fin=isset($_POST["fecha_fin"])? limpiarCadena($_POST["fecha_fin"]):"";

$codigo_llamado=isset($_POST["codigo_llamado"])? limpiarCadena($_POST["codigo_llamado"]):"";
$precio_unitario=isset($_POST["precio_unitario"])? limpiarCadena($_POST["precio_unitario"]):"";
$cantidad_adjudicada=isset($_POST["cantidad_adjudicada"])? limpiarCadena($_POST["cantidad_adjudicada"]):"";
$codigo_medicamento=isset($_POST["codigo_medicamento"])? limpiarCadena($_POST["codigo_medicamento"]):"";
$codigo_proveedor=isset($_POST["codigo_proveedor"])? limpiarCadena($_POST["codigo_proveedor"]):"";
$lote=isset($_POST["lote"])? limpiarCadena($_POST["lote"]):"";
$item=isset($_POST["item"])? limpiarCadena($_POST["item"]):"";
$unidad_medida=isset($_POST["unidad_medida"])? limpiarCadena($_POST["unidad_medida"]):"";
$nombre_comercial=isset($_POST["nombre_comercial"])? limpiarCadena($_POST["nombre_comercial"]):"";
$procedencia=isset($_POST["procedencia"])? limpiarCadena($_POST["procedencia"]):"";
$cantidad_minima=isset($_POST["cantidad_minima"])? limpiarCadena($_POST["cantidad_minima"]):"";
$cantidad_adjudicada=isset($_POST["cantidad_adjudicada"])? limpiarCadena($_POST["cantidad_adjudicada"]):"";
$cantidad_emitida=isset($_POST["cantidad_emitida"])? limpiarCadena($_POST["cantidad_emitida"]):"";
$precio_unitario=isset($_POST["precio_unitario"])? limpiarCadena($_POST["precio_unitario"]):"";
$monto_minimo=isset($_POST["monto_minimo"])? limpiarCadena($_POST["monto_minimo"]):"";
$monto_maximo=isset($_POST["monto_maximo"])? limpiarCadena($_POST["monto_maximo"]):"";
$monto_emitido=isset($_POST["monto_emitido"])? limpiarCadena($_POST["monto_emitido"]):"";
$obs=isset($_POST["obs"])? limpiarCadena($_POST["obs"]):"";
$codigo_estado_item=isset($_POST["codigo_estado_item"])? limpiarCadena($_POST["codigo_estado_item"]):"";

switch ($_GET["op"]){
    case 'guardaryeditar':
           $rspta=$producto->actualizar($codigo_llamado,$codigo_proveedor,
                                       $codigo_medicamento,$lote,$item,
                                       $unidad_medida,$nombre_comercial, $procedencia,
                                       $cantidad_minima,$cantidad_adjudicada,
                                       $cantidad_emitida, $precio_unitario, 
                                       $monto_minimo,$monto_maximo,$monto_emitido,
                                       $obs,$codigo_estado_item,
                                       $codigo_adjudicacion,$monto_adjudicado,
                                       $fecha_adjudicacion,
                                       $codigo_contrato,$numero_contrato,
                                       $fecha_inicio,$fecha_fin,
                                       $_POST["numero_entrega"],
                                       $_POST["plazo"],$_POST["codigo_tipo_dias"],
                                       $_POST["codigo_tipo_descuento_item"],
                                       $_POST["codigo_tipo_plazo"],
                                       $_POST["porcentaje"],
                                       $_POST["porcentaje_complementario"]
                                );
          // error_log('##########2344444 ');
           echo $rspta ? "Contrato registrado" : "No se pudieron registrar todos los datos del contrato";
       
       // error_log('##########2344444 ');
           
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

                while ($reg = pg_fetch_array($rspta)) {
 		$data[]=array(
 			        "0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg['codigo_adjudicacion'].','.$reg['codigo_proveedor'].','.$reg['codigo_medicamento'].')"><i class="fa fa-pencil"></i></button>',
                                "1"=>$reg['id_llamado'],
                                "2"=>$reg['licitacion'],
                                "3"=>$reg['titulo'],   
 				"4"=>$reg['proveedor'],
                                "5"=>$reg['codigo_contrataciones'],
                                "6"=>$reg['item'],
 				"7"=>$reg['codigo_medicamento'],
                                "8"=>$reg['producto'],
 				"9"=>number_format($reg['cantidad_adjudicada'],0,'','.'),
 				"10"=>number_format($reg['cantidad_emitida'],0,'','.'));

 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	
        case 'selectNumeroEntrega':
        require_once "../modelos/ContratoProducto.php";
        $producto = new ContratoProducto();
        $rspta = $producto->selectNumeroEntrega();
        echo '<option value="-1"> </option>';
        while ($reg = pg_fetch_array($rspta)) {
            echo '<option value=' . $reg['codigo'] . '>' . $reg['codigo'] . '</option>';
        }
        break;

	case 'selectProveedor':
		$rspta = $producto->selectProveedor();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idproveedor . '>' . $reg->empresa . '</option>';
				}
	break;
     case 'mostrar':
       /*     $codigo_adjudicacion = $_POST['codigo_adjudicacion'];
            $codigo_proveedor = $_POST['codigo_proveedor'];
            $codigo_medicamento = $_POST['codigo_medicamento'];
         
        *    //  error_log('##########2344444 '.$idpedido);
        */
            $rspta = $producto->mostrar($codigo_adjudicacion,$codigo_proveedor,$codigo_medicamento);
            $rspta = pg_fetch_array($rspta);

            echo json_encode($rspta);
        break;
     case 'mostrarAdjudicacion':
      //  $codigo_llamado = $_POST['codigo_llamado'];
     // error_log('##########2344444 '.$idpedido);
        $rspta = $producto->mostrarAdjudicacion($codigo_llamado);
        $rspta = pg_fetch_array($rspta);

        echo json_encode($rspta);
        break;
    
    case 'mostrarContrato':
      //  $codigo_llamado = $_POST['codigo_llamado'];
     // error_log('##########2344444 '.$idpedido);
        $rspta = $producto->mostrarContrato($codigo_adjudicacion,$codigo_proveedor);
        $rspta = pg_fetch_array($rspta);

        echo json_encode($rspta);
        break;
    case 'mostrarDetalleEntrega':
        //Recibimos el idingreso
        $cont = 3000;

     //     error_log('# '. $codigo_adjudicacion.' '.$codigo_proveedor.' '.$codigo_medicamento);   
        $rspta = $producto->mostrarDetalleEntrega($codigo_adjudicacion,$codigo_proveedor,$codigo_medicamento);

        echo ' <thead style="background-color:#A9D0F5; font-size: 80%;">
                                      <th style="width:15px;"></th>
                                      <th>Nro.</th>
                                      <th>Plazo</th>
                                      <th>Tipo Plazo</th>
                                      <th>Tipo Dias</th>
                                      <th>Tipo Descuento</th>
                                      <th>%</th>
                                    </thead>';

        while ($reg = pg_fetch_array($rspta)) {
            $cont = $cont + 1;
          //   error_log('# '. $reg['des_tipo_plazo']);
            echo '<tr  scope="col" id="fila' . $cont .'" class="filas" style="font-size: 12px;" >
		  <td scope="col" style="text-align: center;"><div style="width: 15px;"><a class="btn btn-accent m-btn m-btn--custom
		m-btn--icon m-btn--air m-btn--pill" type="button" onclick="eliminarDetalle(' . $cont . ')" style="padding: unset;">
		<span><i class="fa fa-trash" style="color: indianred; "></i></span></a>
		<td scope="col"><div style="width: 50px; font-size: 80%;"><input type="hidden" readonly="readonly" name="numero_entrega[]" value="'. $reg['numero_entrega'] .'">' . $reg['numero_entrega'] . ' </div></td>
		<td scope="col"><div style="width: 65px; font-size: 80%;"><input type="text" readonly="readonly" name="plazo[]" size="7" value="' . $reg['plazo'] . '"></div></td>
                <td scope="col"><input type="hidden" readonly="readonly" name="codigo_tipo_plazo[]" value="'. $reg['codigo_tipo_plazo'] . '">' . $reg['des_tipo_plazo'] .' </td>
		      
                <td scope="col"><div style="width: 50px; font-size: 80%;"><input type="hidden" readonly="readonly" name="codigo_tipo_dias[]" value="' . $reg['codigo_tipo_dias'] . '">' . $reg['des_tipo_dias'] . ' </div></td>
		<td scope="col"><input type="hidden" readonly="readonly" name="codigo_tipo_descuento_item[]" value="' . $reg['codigo_tipo_descuento_item'] . '">' . $reg['des_tipo_descuento_item'] .' </td>
              	<td scope="col"><input type="hidden" readonly="readonly" name="porcentaje[]" value="' . $reg['porcentaje'] .'">' . $reg['porcentaje'] . ' </td>

		</tr>';
            
            
        }
        break;
        
        
        case 'listarReactivo':
                
            $rspta=$producto->listarReactivo();
            //Vamos a declarar un array
            $data= Array();

            while($reg = pg_fetch_array($rspta)){
                $data[]=array(
                    "0"=>$reg['codigo'],
                    "1"=>$reg['codigo_catalogo'],
                    "2"=>$reg['producto'],
                    "3"=>$reg['especificacion_tecnica'],
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
}

ob_end_flush();
?>