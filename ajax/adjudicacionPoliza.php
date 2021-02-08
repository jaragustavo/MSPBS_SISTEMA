<?php
if (strlen(session_id()) < 1)
    session_start();

require_once "../modelos/AdjudicacionPoliza.php";


$adjudicacionPoliza = new AdjudicacionPoliza();

$codigo = isset($_POST["codigo"]) ? limpiarCadena($_POST["codigo"]) : "";
$codigo_contrato = isset($_POST["codigo_contrato"]) ? limpiarCadena($_POST["codigo_contrato"]) : "";
$aseguradora = isset($_POST["aseguradora"]) ? limpiarCadena($_POST["aseguradora"]) : "";
$numero_poliza = isset($_POST["numero_poliza"]) ? limpiarCadena($_POST["numero_poliza"]) : "";
$fecha_emision = isset($_POST["fecha_emision"]) ? limpiarCadena($_POST["fecha_emision"]) : "";
$fecha_inicio = isset($_POST["fecha_inicio"]) ? limpiarCadena($_POST["fecha_inicio"]) : "";
$fecha_fin = isset($_POST["fecha_fin"]) ? limpiarCadena($_POST["fecha_fin"]) : "";
$monto_poliza = isset($_POST["monto_poliza"]) ? limpiarCadena($_POST["monto_poliza"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";
$obs = isset($_POST["obs"]) ? limpiarCadena($_POST["obs"]) : "";
$codigo_estado_poliza = isset($_POST["codigo_estado_poliza"]) ? limpiarCadena($_POST["codigo_estado_poliza"]) : "";



switch ($_GET["op"]) {
    case 'guardaryeditar':

        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $imagen = $_POST["imagenactual"];
        } else {
            $ext = explode(".", $_FILES["imagen"]["name"]);

            if ($_FILES['imagen']['type'] == "application/pdf" || $_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {

                $imagen = round(microtime(true)) . '.' . end($ext);

                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/adjudicacionPoliza/" . $imagen);
            }
        }

        if (empty($codigo)) {

            $rspta = $adjudicacionPoliza->insertar(
                $codigo_contrato,
                $aseguradora,
                $numero_poliza,
                $fecha_emision,
                $fecha_inicio,
                $fecha_fin,
                $monto_poliza,
                $obs,
                $codigo_estado_poliza,
                $imagen
            );
            echo $rspta ? "Contrato registrado" : "No se pudieron registrar todos los datos del Contrato";
        } else {

            $rspta = $adjudicacionPoliza->editar(
                $codigo,
                $codigo_contrato,
                $aseguradora,
                $numero_poliza,
                $fecha_emision,
                $fecha_inicio,
                $fecha_fin,
                $monto_poliza,
                $obs,
                $codigo_estado_poliza,
                $imagen
            );
            echo $rspta ? "Contrato modificado" : "No se pudo modificar el Contrato";
        }
        break;

    case 'mostrar':
        $codigo = isset($_POST["codigo"]) ? limpiarCadena($_POST["codigo"]) : "";
        $rspta = $adjudicacionPoliza->mostrar($codigo);
        $rspta = pg_fetch_array($rspta);
        echo json_encode($rspta);
        break;



    case 'listar':
        $rspta = $adjudicacionPoliza->listar();
        //Vamos a declarar un array
        $data = array();
        while ($reg = pg_fetch_array($rspta)) {
            $data[] = array(
                "0" => '<button class="btn btn-warning" onclick="mostrar(' . $reg['codigo'] . ')"><i class="fa fa-pencil"></i></button>',
                "1" => $reg['numero_contrato'],
                "2" => $reg['proveedor'],
                "3" => $reg['llamado'],
                "4" => $reg['numero_poliza'],
                "5" => $reg['fecha_inicio'],
                "6" => $reg['fecha_fin'],
                "7" => $reg['monto_poliza']

            );
        }

        // "7" => ($reg['fecha_fin'] < $reg["fecha_actual"] ?
        //         '<span class="label bg-red">' . $reg["fecha_fin"] . '</span>' :
        //          ($reg["fecha_fin"] > $reg["fecha_actual"] ?
        //           '<span class="label bg-blue">' . $reg["fecha_fin"] . '</span>' : 
        //           '<span class="label bg-yellow">' . $reg["fecha_fin"] . '</span>')),
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case 'selectAseguradora':
        require_once "../modelos/AdjudicacionPoliza.php";
        $poliza = new AdjudicacionPoliza();
        $rspta = $poliza->selectAseguradora();
        echo '<option value="-1"> </option>';
        while ($reg = pg_fetch_array($rspta)) {
            echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>';
        }
        break;

    case 'selectEstadoPoliza':
        require_once "../modelos/AdjudicacionPoliza.php";
        $poliza = new AdjudicacionPoliza();
        $rspta = $poliza->selectEstadoPoliza();
        echo '<option value="-1"> </option>';
        while ($reg = pg_fetch_array($rspta)) {
            echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>';
        }
        break;

    case 'listarContrato':
        //  error_log('### '. 'PO'); 
        require_once "../modelos/AdjudicacionContrato.php";
        $contrato = new AdjudicacionPoliza();
        $contratosJSON = json_decode($_GET['id']);
        $valores = array();
        // error_log("#####$$$$$$$$".count($medicamentoJSON->detalles));
        foreach ($contratosJSON->detalles as $detalle) {
            array_push($valores, "$detalle->contratos");
        }
        $rspta = $contrato->listarContrato();
        //Vamos a declarar un array
        $data = array();

        while ($reg = pg_fetch_array($rspta)) {

            $sw = in_array($reg['codigo_contrato'], $valores) ? 'style="display:none"' : '';
            $swa = !in_array($reg['codigo_contrato'], $valores) ? 'style="display:none"' : '';

            $data[] = array(
                "0" => '<a   ' . $sw . ' class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" id="btnAgregar' . 
                $reg['codigo_contrato'] . '" class="btn btn-warning" title="Agregar Contrato"  data-dismiss="modal" onclick="agregarContrato(' . $reg['codigo_contrato'] . ',\'' . 
                $reg['numero_contrato'] . '\',\'' . $reg['codigo_proveedor'] . '\',\'' . $reg['adjudicacion'] . '\',\'' . $reg['vigencia'] . '\')">
                                  <span><i class="fa fa-plus" style="color: #f4c83a; font-size: 15px;"></i></span></a>
                          <a  ' . $swa . 'class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" id="btnAgregado' . 
                          $reg['codigo_contrato'] . '" class="btn btn-primary" title="Contrato Agregado">
                           <span><i class="fa fa-check" style="color: #a9aa00; font-size: 15px;"></i></span></a>',
                // Maite fin
                "1" => $reg['codigo_contrato'],
                "2" => $reg['numero_contrato'],
                "3" => $reg['codigo_proveedor'],
                "4" => $reg['adjudicacion'],
                "5" => $reg['vigencia']
            );
            //error_log('### '. $reg['codigo']);
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
