<?php
if (strlen(session_id()) < 1)
    session_start();

require_once "../modelos/OfertaCovid.php";


$ofertaCovid = new OfertaCovid();


$idcodigo = isset($_POST["codigo"]) ? limpiarCadena($_POST["codigo"]) : "";
$codigo_item_covid = isset($_POST["codigo_item"]) ? limpiarCadena($_POST["codigo_item"]) : "";
$codigo_proveedor = isset($_POST["codigo_proveedor"]) ? limpiarCadena($_POST["codigo_proveedor"]) : "";
$cantidad = isset($_POST["cantidad_ofrecida"]) ? limpiarCadena($_POST["cantidad_ofrecida"]) : "";
$precio_unitario = isset($_POST["precio_unitario"]) ? limpiarCadena($_POST["precio_unitario"]) : "";
$precio_referencial = isset($_POST["precio_referencial"]) ? limpiarCadena($_POST["precio_referencial"]) : "";
$dias_disponible = isset($_POST["dias_disponible"]) ? limpiarCadena($_POST["dias_disponible"]) : "";
$obs = isset($_POST["obs"]) ? limpiarCadena($_POST["obs"]) : "";


$fechaPedido = isset($_POST["fecha_hora"]) ? limpiarCadena($_POST["fecha_hora"]) : "";
$obs = isset($_POST["obs"]) ? limpiarCadena($_POST["obs"]) : "";
$numeroExpediente = isset($_POST["numero_expediente"]) ? limpiarCadena($_POST["numero_expediente"]) : "";
$fecha_oferta = '20090327';
$codigo_estado = 1;


//$idusuario=1; 
switch ($_GET["op"]) {
    case 'guardaryeditar':
        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $imagen = $_POST["imagenactual"];
        } else {
            $ext = explode(".", $_FILES["imagen"]["name"]);

            if ($_FILES['imagen']['type'] == "application/pdf" || $_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
                // error_log('##### '.$_FILES['imagen']['type']);
                $imagen = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/ofertaProveedor/" . $imagen);
            }
        }
        if (empty($idcodigo)) {
            //error_log('######### '.$idcodigo);
            $rspta = $ofertaCovid->insertar($codigo_item_covid, $codigo_proveedor, $cantidad, $precio_unitario,
             $dias_disponible, $fecha_oferta, $obs, $codigo_estado, $_POST["condicion"], $imagen);
            echo $rspta ? "Oferta Proveedor registrada" : "No se pudieron registrar todos los datos de la oferta";
        } else {

            $rspta = $ofertaCovid->modificar($idcodigo, $codigo_item_covid, $codigo_proveedor, $cantidad, 
            $precio_unitario, $dias_disponible, $fecha_oferta, $obs, $codigo_estado, $_POST["condicion"], $imagen);

            // error_log('###### '.$rspta);

            echo $rspta ? "Oferta Proveedor modicada.." : "No se pudiero modificar todos los datos...";
        }
        break;


    case 'listarCondicion':
        //Obtenemos todos los permisos de la tabla permisos
        $codigo_oferta = isset($_GET["codigo_oferta"]) ? limpiarCadena($_GET["codigo_oferta"]) : 0;
        $codigo_item_covid = $_GET["codigo_item_covid"];

        //  error_log('#### '.$codigo_item_covid);

        $rspta = $ofertaCovid->listarCondicionItem($codigo_item_covid);

        //Obtener los permisos asignados al usuario

        if ($codigo_item_covid > 0) {
            $marcados = $ofertaCovid->listarmarcados($codigo_oferta);
            //Declaramos el array para almacenar todos los permisos marcados
            $valores = array();

            //Almacenar los permisos asignados al usuario en el array

            while ($proveedorCumple = pg_fetch_row($marcados)) {
                array_push($valores, $proveedorCumple[2]);
            }

            //Mostramos la lista de permisos en la vista y si están o no marcados
            while ($reg = pg_fetch_row($rspta)) {

                $sw = in_array($reg[0], $valores) ? 'checked' : '';

                echo '<li> <input type="checkbox" ' . $sw . '  name="condicion[]" value="' . $reg[0] . '">' . '   - ' . $reg[1] . '</li>';
            }
        }
        break;


    case 'editarOferta':
        $idcodigo = $_POST["idcodigo"];

        $rspta = $ofertaCovid->editarOferta($idcodigo);
        $rspta = pg_fetch_array($rspta);
        echo json_encode($rspta);
        break;

    case 'listar':
        //  error_log('######');
        $rspta = $ofertaCovid->listar();

        //Vamos a declarar un array
        $data = array();
        while ($reg = pg_fetch_array($rspta)) {
            //   error_log($reg['numero_item']);
            $data[] = array(


                "0" => ($reg['codigo_estado'] == '1' ? '<button class="btn btn-success" onclick="editarOferta(' . $reg['codigo'] . ',' . $reg['codigo_item_covid'] . ')"><i class="fa fa-pencil fa-1x">' : ''),

                "1" => $reg['numero_item'],
                "2" => $reg['nombre_item'],
                "3" => $reg['nombre_proveedor'],
                "4" => $reg['cantidad'],
                "5" => $reg['precio_unitario'],
                "6" => ($reg['precio_referencial'] < $reg["precio_unitario"] && $reg["precio_referencial"] > 0 ?
                 '<span class="label bg-red">' . ($reg["precio_unitario"] - $reg["precio_referencial"]). ' mas ' . '</span>' :
                  ($reg["precio_referencial"] == $reg["precio_unitario"] && $reg["precio_referencial"] > 0 ?
                   '<span class="label bg-blue">' . ' igual ' . '</span>' : 
                   '<span class="label bg-yellow">SIN DATO</span>')),

                "7" => ($reg["cantidad_oferta"] < $reg["cantidad_condicion"] ? '<span class="label bg-red">' 
                . $reg["cantidad_oferta"] . ' de ' . $reg["cantidad_condicion"] . '</span>' : 
                ($reg["cantidad_oferta"] == $reg["cantidad_condicion"] && $reg["cantidad_condicion"] > 0 ?
                 '<span class="label bg-blue">' . $reg["cantidad_oferta"] . ' de ' . 
                 $reg["cantidad_condicion"] . '</span>' : '<span class="label bg-yellow">SIN DATO</span>')),
                "8" => $reg['dias_disponible'],
                "9" => $reg['fecha_oferta'],
                //   
                "10" => $reg['obs'],
                //  "10"=>"<iframe src='../files/ofertaProveedor/".$reg['imagen']."'height='50px' width='70px'alt='SIN DOC.'></iframe>"
                //   "10"=>'<img src="../public/img/1585918088.jpg" class="img-circle" alt="User Image">"'
                //   "10"=>"<img src='../files/proveedorOferta/".$reg['imagen']."' height='50px' width='50px' >'
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

    case 'listarItem':



        $rspta = $ofertaCovid->listarItem();
        //Vamos a declarar un array
        $data = array();

        while ($reg = pg_fetch_array($rspta)) {
            $data[] = array(
                "0" => $reg['codigo'],
                "1" => $reg['item_numero'],
                "2" => $reg['codigo_catalogo'],
                "3" => $reg['nombre'],
                "4" => $reg['especificacion_tecnica'],
                "5" => $reg['presentacion'],
                "6" => $reg['presentacion_entrega'],
                "7" => $reg['cantidad_necesitada']
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


        $rspta = $ofertaCovid->selectProveedor();
        echo '<option value="-1">  </option>';
        while ($reg = pg_fetch_array($rspta)) {
            echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>';
        }

        break;

    case 'selectEstadoCovid':


        $rspta = $ofertaCovid->selectEstadoCovid();
        echo '<option value="-1">  </option>';
        while ($reg = pg_fetch_array($rspta)) {
            echo '<option value=' . $reg['codigo'] . '>' . $reg['descripcion'] . '</option>';
        }

        break;
}
