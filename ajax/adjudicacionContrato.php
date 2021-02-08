<?php
if (strlen(session_id()) < 1)
    session_start();

require_once "../modelos/AdjudicacionContrato.php";

$adjudicacionContrato = new AdjudicacionContrato();

$codigo = isset($_POST["codigo"]) ? limpiarCadena($_POST["codigo"]) : "";
$codigo_adjudicacion = isset($_POST["codigo_adjudicacion"]) ? limpiarCadena($_POST["codigo_adjudicacion"]) : "";
$numero_contrato = isset($_POST["numero_contrato"]) ? limpiarCadena($_POST["numero_contrato"]) : "";
$codigo_proveedor = isset($_POST["codigo_proveedor"]) ? limpiarCadena($_POST["codigo_proveedor"]) : "";
$fecha_contrato = isset($_POST["fecha_contrato"]) ? limpiarCadena($_POST["fecha_contrato"]) : "";
$vigencia = isset($_POST["vigencia"]) ? limpiarCadena($_POST["vigencia"]) : "";
$monto_contrato = isset($_POST["monto_contrato"]) ? limpiarCadena($_POST["monto_contrato"]) : "";
$imagen = isset($_POST["imagen"]) ? limpiarCadena($_POST["imagen"]) : "";
$porcentaje_mora = isset($_POST["porcentaje_mora"]) ? limpiarCadena($_POST["porcentaje_mora"]) : "";
$frecuencia_diaria_aumento_mora = isset($_POST["frecuencia_diaria_aumento_mora"]) ? limpiarCadena($_POST["frecuencia_diaria_aumento_mora"]) : "";
$porcentaje_rescision = isset($_POST["porcentaje_rescision"]) ? limpiarCadena($_POST["porcentaje_rescision"]) : "";
$obs = isset($_POST["obs"]) ? limpiarCadena($_POST["obs"]) : "";
$codigo_estado_contrato = isset($_POST["codigo_estado_contrato"]) ? limpiarCadena($_POST["codigo_estado_contrato"]) : "";
$codigo_tipo_vigencia = isset($_POST["codigo_tipo_vigencia"]) ? limpiarCadena($_POST["codigo_tipo_vigencia"]) : "";
$fecha_rescision = isset($_POST["fecha_rescision"]) ? limpiarCadena($_POST["fecha_rescision"]) : "";



switch ($_GET["op"]) {
    case 'guardaryeditar':

        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $imagen = $_POST["imagenactual"];
        } else {
            $ext = explode(".", $_FILES["imagen"]["name"]);

            if ($_FILES['imagen']['type'] == "application/pdf" || $_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {

                $imagen = round(microtime(true)) . '.' . end($ext);

                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/adjudicacionContrato/".$imagen);
            }
        }

        if (empty($codigo)) {

            $rspta = $adjudicacionContrato->insertar(
                $codigo_adjudicacion,
                $numero_contrato,
                $codigo_proveedor,
                $fecha_contrato,
                $vigencia,
                $monto_contrato,
                $imagen,
                $porcentaje_mora,
                $frecuencia_diaria_aumento_mora,
                $porcentaje_rescision,
                $obs,
                $codigo_estado_contrato,
                $codigo_tipo_vigencia,
                $fecha_rescision
            );
            echo $rspta ? "Contrato registrado" : "No se pudieron registrar todos los datos del Contrato";
        } else {

            $rspta = $adjudicacionContrato->editar(
                $codigo,
                $codigo_adjudicacion,
                $numero_contrato,
                $codigo_proveedor,
                $fecha_contrato,
                $vigencia,
                $monto_contrato,
                $imagen,
                $porcentaje_mora,
                $frecuencia_diaria_aumento_mora,
                $porcentaje_rescision,
                $obs,
                $codigo_estado_contrato,
                $codigo_tipo_vigencia,
                $fecha_rescision
            );
            echo $rspta ? "Contrato modificado" : "No se pudo modificar el Contrato";
        }
        break;

    case 'mostrar':
        $codigo = isset($_POST["codigo"]) ? limpiarCadena($_POST["codigo"]) : "";
        $rspta = $adjudicacionContrato->mostrar($codigo);
        $rspta = pg_fetch_array($rspta);
        echo json_encode($rspta);
        break;



    case 'listar':
        $rspta = $adjudicacionContrato->listar();
        //Vamos a declarar un array
        $data = array();
        while ($reg = pg_fetch_array($rspta)) {
            $data[] = array(
                "0" => '<button class="btn btn-warning" onclick="mostrar(' . $reg['codigo'] . ')"><i class="fa fa-pencil"></i></button>',
                "1" => $reg['id_llamado'],
                "2" => $reg['adjudicacion'],
                "3" => $reg['titulo'],
                "4" => $reg['numero_contrato'],
                "5" => $reg['codigo_proveedor'],
                "6" => $reg['fecha_contrato'],
                "7" => $reg['vigencia'],
                "8" => $reg['estado'],
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
      
        $rspta = $adjudicacionContrato->selectProveedor();
        echo '<option value="-1"> </option>';
        while ($reg = pg_fetch_array($rspta)) {
            echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>';
        }
        break;

    case 'selectTipoVigencia':
        $rspta = $adjudicacionContrato->selectTipoVigencia();
        echo '<option value="-1"> </option>';
        while ($reg = pg_fetch_array($rspta)) {
            echo '<option value=' . $reg['codigo'] . '>' . $reg['descripcion'] . '</option>';
        }
        break;

    case 'selectEstadoContrato':
        
        $rspta = $adjudicacionContrato->selectEstadoContrato();
        echo '<option value="-1"> </option>';
        while ($reg = pg_fetch_array($rspta)) {
            echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>';
        }
        break;
}
