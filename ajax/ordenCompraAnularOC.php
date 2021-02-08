<?php
if (strlen(session_id()) < 1)
    session_start();

require_once "../modelos/OrdenCompraAnularOC.php";


$ordenCompraAnularOC = new OrdenCompraAnularOC();

$codigo = isset($_POST["codigo"]) ? limpiarCadena($_POST["codigo"]) : "";
$codigo_adjudicacion = isset($_POST["codigo_adjudicacion"]) ? limpiarCadena($_POST["codigo_adjudicacion"]) : "";
$numero_orden_compra = isset($_POST["numero_orden_compra"]) ? limpiarCadena($_POST["numero_orden_compra"]) : "";
$licitacion = isset($_POST["licitacion"]) ? limpiarCadena($_POST["licitacion"]) : "";
$proveedor = isset($_POST["proveedor"]) ? limpiarCadena($_POST["proveedor"]) : "";
$codigo_proveedor = isset($_POST["codigo_proveedor"]) ? limpiarCadena($_POST["codigo_proveedor"]) : "";
$codigo_estado = isset($_POST["codigo_estado"]) ? limpiarCadena($_POST["codigo_estado"]) : "";
$proveedor = isset($_POST["proveedor"]) ? limpiarCadena($_POST["proveedor"]) : "";
$fecha_recepcion_oc_proveedor = isset($_POST["fecha_recepcion_oc_proveedor"]) ? limpiarCadena($_POST["fecha_recepcion_oc_proveedor"]) : "";
$plazo_entrega = isset($_POST["plazo_entrega"]) ? limpiarCadena($_POST["plazo_entrega"]) : "";
$dias_plazo_entrega = isset($_POST["dias_plazo_entrega"]) ? limpiarCadena($_POST["dias_plazo_entrega"]) : "";
$observacion = isset($_POST["observacion"]) ? limpiarCadena($_POST["observacion"]) : "";
$monto_total = isset($_POST["monto_total"]) ? limpiarCadena($_POST["monto_total"]) : "";

$item = isset($_POST["item"][0]) ? limpiarCadena($_POST["item"][0]) : "";
$codigo_medicamento = isset($_POST["codigo_medicamento"][0]) ? limpiarCadena($_POST["codigo_medicamento"][0]) : "";
$cantidad_emitir = isset($_POST["cantidad_emitir"][0]) ? limpiarCadena($_POST["cantidad_emitir"][0]) : "";
$cantidad_emitida = isset($_POST["cantidad_emitida"][0]) ? limpiarCadena($_POST["cantidad_emitida"][0]) : "";
$id= $_SESSION['idusuario'];



switch ($_GET["op"]) {
    case 'anularOC':
        $fecha_auditoria = date("Y-m-d h:i:s");
        $rspta = $ordenCompraAnularOC->anularOC($codigo,$codigo_estado,$id,$item,$codigo_medicamento,$cantidad_emitir,$fecha_auditoria,$numero_orden_compra,$observacion,$codigo_proveedor);
        echo $rspta ? "Orden Compra Anulada" : "No se pudo anular la Orden de Compra";   
        break;

    case 'mostrar':
        $codigo = isset($_POST["codigo"]) ? limpiarCadena($_POST["codigo"]) : "";
        $rspta = $ordenCompraAnularOC->mostrar($codigo);
        $rspta = pg_fetch_array($rspta);
        echo json_encode($rspta);
        break;
    case 'listarDetalle':
        //Recibimos el idingreso
        $cont = 3000;
        $codigo = $_GET['id'];
        //   error_log('# '. $idpedido);   
        $rspta = $ordenCompraAnularOC->listarDetalle($codigo);

        echo '<thead style="background-color:#A9D0F5"  scope="col">
                                        <th scope="col"><div style="width: 30px;text-align: center; font-size: 80%;"></div></th>
                                        <th scope="col"><div style="width: 50px;text-align: center; font-size: 80%;">Item</div></th>
                                        <th scope="col"><div style="width: 50px;text-align: center; font-size: 80%;">Código</div></th>
                                        <th scope="col"><div style="width: 220px;text-align: center; font-size: 80%;">Medicamento</div></th>
                                        <th scope="col"><div style="width: 70px;text-align: center; font-size: 80%;">U. Medida</div></th>
                                        <th scope="col"><div style="width: 60px;text-align: center; font-size: 80%;">Marca</div></th>
                                        <th scope="col"><div style="width: 100px;text-align: center; font-size: 80%;">Procedencia</div></th>
                                        <th scope="col"><div style="width: 100px;text-align: center; font-size: 80%;">Cant. a Emitir</div></th>
                                        <th scope="col"><div style="width: 100px;text-align: center; font-size: 80%;">Precio Unitario</div></th>
                                        <th scope="col"><div style="width: 100px;text-align: center; font-size: 80%;">Monto</div></th>
                                </thead>';

        while ($reg = pg_fetch_array($rspta)) {
            $cont = $cont + 1;
            echo '<tr  scope="col" class="filas" id="fila' . $cont . '" style="font-size: 12px;">
                        <td style="text-align: center important;" scope="col"><div style="width: 30px;">' . $reg[''] . '</div></td>
                         <td scope="col"><div style="width: 50px; font-size: 80%;"><input style="text-align: center;" type="text" size="7" name="item[]" value="' . $reg['item'] . '"></div></td>
                         <td scope="col"><div style="width: 50px; font-size: 80%;"><input style="text-align: center;" type="text" size="7" name="codigo_medicamento[]" value="' . $reg['codigo_medicamento'] . '"></div></td>
                         <td scope="col" style=" font-size: 80%;"><div style="width: 220px;">' . $reg['medicamento'] . '</div></td>
                         <td scope="col" style=" font-size: 80%;"><div style="width: 100px;">' . $reg['unidad_medida'] . '</div></td>
                         <td scope="col"><div style="width: 60px; font-size: 80%; ">' . $reg['marca'] . '</div></td>
                         <td scope="col"><div style="width: 80px; font-size: 80%;">' . $reg['procedencia'] . '</div></td>
                         <td scope="col"><div style="width: 80px; font-size: 80%;text-align: right;"><input style="text-align: center;" type="text" size="7" name="cantidad_emitir[]" value="' . $reg['cantidad_solicitada'] . '"></div></td>
                         <td scope="col"><div style="width: 50px; font-size: 80%;text-align: right;">' . $reg['precio_unitario'] . '</div></td>
                         <td scope="col"><div style="width: 50px; font-size: 80%;text-align: right;">' . $reg['monto'] . '</div></td>
                         </tr>';
        }

        break;

    case 'listar':
        $rspta = $ordenCompraAnularOC->listar();
        //Vamos a declarar un array
        $data = array();
        while ($reg = pg_fetch_array($rspta)) {
            $data[] = array(
                "0" => '<button class="btn btn-warning" onclick="mostrar(' . $reg['codigo'] . ')"><i class="fa fa-pencil"></i></button>',
                "1" => $reg['numero_orden_compra'],
                "2" => $reg['licitacion'],
                "3" => $reg['proveedor'],
                "4" => $reg['fecha_orden_compra'],
                "5" => $reg['fecha_recepcion_oc_proveedor'],
                "6" => $reg['codigo_estado'],
                "7" => $reg['monto_total']
            );
        }
        
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
        break;
        case 'selectProveedor':
            $ordenCompraAnularOC = new ordenCompraAnularOC();
            $rspta = $ordenCompraAnularOC->selectProveedor();
            echo '<option value="-1"> </option>';
            while($reg = pg_fetch_array($rspta))
                {
                echo '<option style="font-size:10px;" value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>'; 
                
                }
        break;
        case 'selectLugarEntrega':
            $ordenCompraAnularOC = new ordenCompraAnularOC();
            $rspta = $ordenCompraAnularOC->selectLugarEntrega();
            echo '<option value="-1"> </option>';
            while($reg = pg_fetch_array($rspta))
                {
                echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>'; 
                
                }
        break;
        case 'selectDependenciaSolicitante':
            $ordenCompraAnularOC = new ordenCompraAnularOC();
            $rspta = $ordenCompraAnularOC->selectDependenciaSolicitante();
            echo '<option value="-1"> </option>';
            while($reg = pg_fetch_array($rspta))
                {
                echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>'; 
                
                }
        break;
        case 'selectEstado':
            $ordenCompraAnularOC = new ordenCompraAnularOC();
            $rspta = $ordenCompraAnularOC->selectEstado();
            echo '<option value="-1"> </option>';
            while($reg = pg_fetch_array($rspta))
                {
                echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>'; 
                
                }
        break;
}


