<?php
if (strlen(session_id()) < 1)
    session_start();

require_once "../modelos/StockCanje.php";


$stockCanje = new StockCanje();

$codigo_stock_medicamento = isset($_POST["codigo_stock_medicamento"]) ? limpiarCadena($_POST["codigo_stock_medicamento"]) : "";
$codigo_proveedor = isset($_POST["codigo_proveedor"]) ? limpiarCadena($_POST["codigo_proveedor"]) : "";
$licitacion = isset($_POST["licitacion"]) ? limpiarCadena($_POST["licitacion"]) : "";
$sucursal = isset($_POST["sucursal"]) ? limpiarCadena($_POST["sucursal"]) : "";
$medicamento = isset($_POST["medicamento"]) ? limpiarCadena($_POST["medicamento"]) : "";
$fecha_vencimiento = isset($_POST["fecha_vencimiento"]) ? limpiarCadena($_POST["fecha_vencimiento"]) : "";
$cantidad = isset($_POST["cantidad"]) ? limpiarCadena($_POST["cantidad"]) : "";
$codigo_canje = isset($_POST["codigo_canje"]) ? limpiarCadena($_POST["codigo_canje"]) : "";
$fecha_canje = isset($_POST["fecha_canje"]) ? limpiarCadena($_POST["fecha_canje"]) : "";
$cantidad_canje = isset($_POST["cantidad_canje"]) ? limpiarCadena($_POST["cantidad_canje"]) : "";
$observacion_canje = isset($_POST["observacion_canje"]) ? limpiarCadena($_POST["observacion_canje"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";
$id = $_SESSION['idusuario'];

switch ($_GET["op"]) {
    case 'guardaryeditar':
        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $imagen = $_POST["imagenactual"];
        } else {
            $ext = explode(".", $_FILES["imagen"]["name"]);

            if ($_FILES['imagen']['type'] == "application/pdf" || $_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {

                $imagen = round(microtime(true)) . '.' . end($ext);

                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/stockCanje/" . $imagen);
            }
        }
        $fecha_auditoria = date("Y-m-d h:i:s");
        if (empty($codigo_canje)) {
            $rspta = $stockCanje->guardar(
                $codigo_stock_medicamento,
                $fecha_canje,
                $cantidad_canje,
                $observacion,
                $imagen,
                $fecha_auditoria,
                $id
            );
            echo $rspta ? "Canje guardado" : "No se pudo canjear $$$$" . $codigo_stock_medicamento;
        } else {
            $rspta = $stockCanje->editar(
                $codigo_stock_medicamento,
                $codigo_canje,
                $fecha_canje,
                $cantidad_canje,
                $observacion_canje,
                $imagen,
                $fecha_auditoria,
                $id
            );
            echo $rspta ? "Canje modificado" : "No se pudo modificar $$$$" . $codigo_stock_medicamento;
        }

        break;

    case 'mostrar':
        $codigo_stock_medicamento = isset($_POST["codigo_stock_medicamento"]) ? limpiarCadena($_POST["codigo_stock_medicamento"]) : "";
        $rspta = $stockCanje->mostrar($codigo_stock_medicamento);
        $rspta = pg_fetch_array($rspta);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $stockCanje->listar($id);
        $fecha_alerta = $_GET["fecha_alerta"];
        $hoy = date("d-m-Y");
        //Vamos a declarar un array
        $data = array();
        while ($reg = pg_fetch_array($rspta)) {
            $data[] = array(
                "0" => '<button class="btn btn-warning" onclick="mostrar(' . $reg['codigo_stock_medicamento'] . ')"><i class="fa fa-pencil"></i></button>',
                "1" => '<div style="text-align:center;">' . $reg['sucursal'] . '</div>',
                "2" => '<div">' . $reg['licitacion'] . '</div>',
                "3" => '<div>' . $reg['orden_compra'] . '</div>',
                "4" => '<div>' . $reg['proveedor'] . '</div>',
                "5" => '<div style="text-align:center;">' . $reg['codigo_medicamento'] . '</div>',
                "6" => '<div>' . $reg['medicamento'] . '</div>',
                "7" => '<div>' . $reg['numero_lote'] . '</div>',
                "8" => '<div>' . $reg['fecha_vencimiento'] . '</div>',
                // "9" => '<div>' . $reg['fecha_canje'] . '</div>',
                "9" => ($reg['fecha_canje'] <= $fecha_alerta && $reg["fecha_canje"] > $hoy ?
                    '<div style="background-color: indian-red;">' . ($reg["fecha_canje"]) . '</div>' :
                    '<div style="background-color: unset;"> '. $reg["fecha_canje"] .'</div>'),
                "10" => '<div>' . $reg['cantidad'] . '</div>',
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
}
