<?php
if (strlen(session_id()) < 1)
    session_start();

require_once "../modelos/OrdenCompraActualizarFecha.php";


$ordenCompraAF = new OrdenCompraActualizarFecha();

$codigo = isset($_POST["codigo"]) ? limpiarCadena($_POST["codigo"]) : "";
$codigo_adjudicacion = isset($_POST["codigo_adjudicacion"]) ? limpiarCadena($_POST["codigo_adjudicacion"]) : "";
$numero_orden_compra = isset($_POST["numero_orden_compra"]) ? limpiarCadena($_POST["numero_orden_compra"]) : "";
$codigo_estado = isset($_POST["codigo_estado"]) ? limpiarCadena($_POST["codigo_estado"]) : "";
$licitacion = isset($_POST["licitacion"]) ? limpiarCadena($_POST["licitacion"]) : "";
$proveedor = isset($_POST["proveedor"]) ? limpiarCadena($_POST["proveedor"]) : "";
$codigo_proveedor = isset($_POST["codigo_proveedor"]) ? limpiarCadena($_POST["codigo_proveedor"]) : "";
$proveedor = isset($_POST["proveedor"]) ? limpiarCadena($_POST["proveedor"]) : "";
$fecha_recepcion_oc_proveedor = isset($_POST["fecha_recepcion_oc_proveedor"]) ? limpiarCadena($_POST["fecha_recepcion_oc_proveedor"]) : "";
$fecha_envio_correo = isset($_POST["fecha_envio_correo"]) ? limpiarCadena($_POST["fecha_envio_correo"]) : "";
$plazo_entrega = isset($_POST["plazo_entrega"]) ? limpiarCadena($_POST["plazo_entrega"]) : "";
//$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";
$es_dia_habil = isset($_POST["es_dia_habil"]) ? limpiarCadena($_POST["es_dia_habil"]) : "";
$dia_habil = isset($_POST["dia_habil"]) ? limpiarCadena($_POST["dia_habil"]) : "";
$tipo_plazo = isset($_POST["tipo_plazo"]) ? limpiarCadena($_POST["tipo_plazo"]) : "";
$obs_auditoria = isset($_POST["obs_auditoria"]) ? limpiarCadena($_POST["obs_auditoria"]) : "";
$id= $_SESSION['idusuario'];

switch ($_GET["op"]) {
    case 'actualizarFecha':
        
      //   error_log('imagen'. $imagen);
        
        // error_log('files'.$_FILES['imagen']['tmp_name']);
        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $imagen = $_POST["imagenactual"];
            
        } else {
            $ext = explode(".", $_FILES["imagen"]["name"]);
             //  error_log('imagen'. $imagen);
            if ($_FILES['imagen']['type'] == "application/pdf" || $_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {

                $imagen = round(microtime(true)) . '.' . end($ext);
             
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/ordenCompraActualizarFecha/" . $imagen);
            }
        }
        $fecha_auditoria = date("Y-m-d h:i:s");
  
       
      //  if($fecha_recepcion_oc_proveedor == ""){
            $rspta = $ordenCompraAF->actualizarFecha($codigo, $fecha_recepcion_oc_proveedor, $fecha_envio_correo, $plazo_entrega, 
            $imagen, $dia_habil, $tipo_plazo, $obs_auditoria, $id, $fecha_auditoria, $numero_orden_compra, $codigo_estado);
      /* }
        else{
            if($fecha_envio_correo == ""){
                $rspta = $ordenCompraAF->actualizarFecha($codigo, $fecha_recepcion_oc_proveedor, NULL, $plazo_entrega, 
                $imagen, $dia_habil, $tipo_plazo, $obs_auditoria, $id, $fecha_auditoria, $numero_orden_compra, $codigo_estado);
            }
            else{
                $rspta = $ordenCompraAF->actualizarFecha($codigo, $fecha_recepcion_oc_proveedor, $fecha_envio_correo, $plazo_entrega, 
                $imagen, $dia_habil, $tipo_plazo, $obs_auditoria, $id, $fecha_auditoria, $numero_orden_compra, $codigo_estado);
            }
        }
        
       */
      // error_log('# '. $rspta); 
        echo $rspta ? "Fecha actualizada" : "No se pudo actualizar la fecha $$$$" . $fecha_recepcion_oc_proveedor . "  $$$$$$" . $fecha_envio_correo;
        break;

    case 'mostrar':
        $codigo = isset($_POST["codigo"]) ? limpiarCadena($_POST["codigo"]) : "";
        $rspta = $ordenCompraAF->mostrar($codigo);
        $rspta = pg_fetch_array($rspta);
        echo json_encode($rspta);
        break;
    case 'listarDetalle':
        //Recibimos el idingreso
        $cont = 3000;
        $codigo = $_GET['id'];
        //   error_log('# '. $idpedido);   
        $rspta = $ordenCompraAF->listarDetalle($codigo);

        echo '<thead style="background-color:#A9D0F5"  scope="col">
                                        <th scope="col"><div style="width: 30px;text-align: center;"></div></th>
                                        <th scope="col"><div style="width: 50px;text-align: center;">Item</div></th>
                                        <th scope="col"><div style="width: 50px;text-align: center;">Código</div></th>
                                        <th scope="col"><div style="width: 180px;text-align: center;">Medicamento</div></th>
                                        <th scope="col"><div style="width: 60px;text-align: center;">U. Medida</div></th>
                                        <th scope="col"><div style="width: 60px;text-align: center;">Marca</div></th>
                                        <th scope="col"><div style="width: 100px;text-align: center;">Procedencia</div></th>
                                        <th scope="col"><div style="width: 50px;text-align: center;">Cant. a Emitir</div></th>
                                        <th scope="col"><div style="width: 60px;text-align: center;">Precio Unitario</div></th>
                                </thead>';

        while ($reg = pg_fetch_array($rspta)) {
            $cont = $cont + 1;
            echo '<tr  scope="col" class="filas" id="fila' . $cont . '" style="font-size: 12px;">
                        <td style="text-align: center important;" scope="col"><div style="width: 30px;"></div></td>
                         <td scope="col"><div style="width: 50px;text-align: center;">' . $reg['item'] . '</div></td>
                         <td scope="col" id="codigo"><div style="width: 50px;">' . $reg['codigo'] . '</div></td>
                         <td id="medicamento" scope="col" style=""><div style="width: 180px;">' . $reg['medicamento'] . '</div></td>
                         <td id="unidad_medida" scope="col" style=""><div style="width: 100px;">' . $reg['unidad_medida'] . '</div></td>
                         <td scope="col"><div style="width: 130px; ">' . $reg['marca'] . '</div></td>
                         <td scope="col"><div style="width: 120px;">' . $reg['procedencia'] . '</div></td>
                         <td scope="col"><div style="width: 80px;text-align: right;">' . $reg['cantidad_solicitada'] . '</div></td>
                         <td scope="col"><div style="width: 50px;text-align: right;">' . $reg['precio_unitario'] . '</div></td>
                         </tr>';
        }

        break;

    case 'listar':
        $rspta = $ordenCompraAF->listar($id);
        //Vamos a declarar un array
        $data = array();
        while ($reg = pg_fetch_array($rspta)) {
            $data[] = array(
                "0" => '<button class="btn btn-warning" onclick="mostrar(' . $reg['codigo'] . ')"><i class="fa fa-pencil"></i></button>',
                "1" => '<div style="text-align:center;">' . $reg['numero_orden_compra'] . '</div>',
                // "2" => $reg['codigo_adjudicacion'],
                "2" => '<div style="text-align:center;">' . $reg['licitacion'] . '</div>',
                "3" => '<div>' . $reg['proveedor'] . '</div>',
                "4" => '<div style="text-align:center;">' . $reg['fecha_envio_correo'] . '</div>',
                "5" => '<div style="text-align:center;">' . $reg['fecha_recepcion_oc_proveedor'] . '</div>',
                "6" => '<div style="text-align:center;">' . $reg['plazo_entrega'] . '</div>',
                "7" => '<div style="text-align:right;">' . $reg['dias_plazo_entrega'] . '</div>',
                "8" => '<div style="text-align:center;">' . $reg['es_dia_habil'] . '</div>'
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
        $ordenCompraAF = new ordenCompraActualizarFecha();
        $rspta = $ordenCompraAF->selectProveedor();
        echo '<option value="-1"> </option>';
        while ($reg = pg_fetch_array($rspta)) {
            echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>';
        }
        break;
    case 'selectLugarEntrega':
        $ordenCompraAF = new ordenCompraActualizarFecha();
        $rspta = $ordenCompraAF->selectLugarEntrega();
        echo '<option value="-1"> </option>';
        while ($reg = pg_fetch_array($rspta)) {
            echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>';
        }
        break;
    case 'selectDependenciaSolicitante':
        $ordenCompraAF = new ordenCompraActualizarFecha();
        $rspta = $ordenCompraAF->selectDependenciaSolicitante();
        echo '<option value="-1"> </option>';
        while ($reg = pg_fetch_array($rspta)) {
            echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>';
        }
        break;
    case 'selectEstado':
        $ordenCompraAF = new ordenCompraActualizarFecha();
        $rspta = $ordenCompraAF->selectEstado();
        echo '<option style="font-size:12px;" value="-1"> </option>';
        while ($reg = pg_fetch_array($rspta)) {
            echo '<option style="font-size:12px;" value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>';
        }
        break;

    case 'selectTiposPlazo':
        $ordenCompraAF = new ordenCompraActualizarFecha();
        $rspta = $ordenCompraAF->selectTiposPlazo();
        echo '<option style="font-size:12px;" value="-1"> </option>';
        while ($reg = pg_fetch_array($rspta)) {
            echo '<option style="font-size:12px;" value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>';
        }
        break;

    case 'listarFeriados':
        //Recibimos el idingreso
        $cont = 3000;
       // $codigo = $_GET['codigo'];
        //   error_log('# '. $idpedido);   
        $rspta = $ordenCompraAF->listarFeriados();

        echo '<thead style="background-color:#A9D0F5"  scope="col">
                                            <th scope="col"><div style="width: 50px;text-align: center;">Código</div></th>
                                            <th scope="col"><div style="width: 180px;text-align: center;">Fecha</div></th>
                                            <th scope="col"><div style="width: 60px;text-align: center;">Dia</div></th>
                                            <th scope="col"><div style="width: 60px;text-align: center;">Mes</div></th>
                                            <th scope="col"><div style="width: 100px;text-align: center;">Nombre</div></th>
                                    </thead>';

        while ($reg = pg_fetch_array($rspta)) {
            $cont = $cont + 1;
            echo '<tr  scope="col" class="filas" id="fila' . $cont . '" style="font-size: 12px;">
                            <td id="codigo" scope="col" id="codigo">' . $reg['codigo'] . '</td>
                             <td id="fecha" scope="col" id="codigo">' . $reg['fecha'] . '</td>
                             <td id="dia" scope="col" style="">' . $reg['dia'] . '</td>
                             <td id="mes" scope="col" style="">' . $reg['mes'] . '</td>
                             <td id="nombre" scope="col">' . $reg['nombre'] . '</td>
                             </tr>';
        }

        break;
}
