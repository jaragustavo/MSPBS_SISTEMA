<?php
if (strlen(session_id()) < 1)
    session_start();

require_once "../modelos/ReactivoPedido.php";



//error_log('### '.str_replace('.','', '10.000'));

$reactivoPedido = new ReactivoPedido();


$idcodigo = isset($_POST["codigo"]) ? limpiarCadena($_POST["codigo"]) : "";
$fechaPedido = isset($_POST["fecha_pedido"]) ? limpiarCadena($_POST["fecha_pedido"]) : "";
$obs = isset($_POST["obs"]) ? limpiarCadena($_POST["obs"]) : "";
$numero_expediente = isset($_POST["numero_expediente"]) ? limpiarCadena($_POST["numero_expediente"]) : "";
$numero_nota = !empty($_POST["numero_nota"]) ? limpiarCadena($_POST["numero_nota"]) : "";
//$numero_nota = !empty($numero_nota) ? limpiarCadena($numero_nota) :0;
$codigo_sucursal = isset($_POST["codigo_sucursal"]) ? limpiarCadena($_POST["codigo_sucursal"]) : "";
$idusuario = $_SESSION["idusuario"];

$codigo_estado_envio = isset($_POST["codigo_estado_envio"]) ? limpiarCadena($_POST["codigo_estado_envio"]) : "";

$destinatario = isset($_POST["destinatario"]) ? limpiarCadena($_POST["destinatario"]) : "";
$obs_envio = isset($_POST["obs_envio"]) ? limpiarCadena($_POST["obs_envio"]) : "";
$codigo_tipo_pedido = isset($_POST["codigo_tipo_pedido"]) ? limpiarCadena($_POST["codigo_tipo_pedido"]) : "";
//error_log('##########2344444 '.$numero_nota);
//$idusuario=1; 
switch ($_GET["op"]) {
    case 'guardaryeditar':
        //error_log('##### imagen'.$_FILES['imagen']['type']);
        if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
            $imagen = $_POST["imagenactual"];
        } else {
            $ext = explode(".", $_FILES["imagen"]["name"]);

            if ($_FILES['imagen']['type'] == "application/pdf" || $_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {

                $imagen = round(microtime(true)) . '.' . end($ext);

                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/reactivoPedido/" . $imagen);
            }
        }
        if (empty($idcodigo)) {
         //  $numero_nota = !empty($numero_nota) ? limpiarCadena($numero_nota) :0;
           $rspta = $reactivoPedido->insertar($fechaPedido, $idusuario, $obs, $codigo_sucursal, $numero_expediente, $numero_nota, $imagen,  $_POST["idarticulo"], $_POST["cantidad"], $_POST["precio_referencial"], $_POST["presentacion_entrega"], $_POST["obsD"], $_POST["unidad_medida"],$codigo_tipo_pedido);
            echo $rspta ? "Pedido registrado" : "No se pudieron registrar todos los datos del pedido";
        } else {

            $rspta = $reactivoPedido->modificar($idcodigo, $fechaPedido, $idusuario, $obs, $codigo_sucursal, $numero_expediente, $numero_nota, $imagen, $_POST["idarticulo"], $_POST["cantidad"], $_POST["precio_referencial"], $_POST["presentacion_entrega"], $_POST["obsD"], $_POST["unidad_medida"],$codigo_tipo_pedido);
            echo $rspta ? "Pedido modicado" : "No se pudiero modificar todos los datos del pedido";
        }
        break;
     case 'mostrarEnviar':
        $idpedido = $_POST['idpedido'];
     // error_log('##########2344444 '.$idpedido);
        $rspta = $reactivoPedido->mostrarEnviar($idpedido);
        $rspta = pg_fetch_array($rspta);

        echo json_encode($rspta);
        break;
    case 'anularPedido':
        $idpedido = $_GET['id'];
        // error_log('##########2344444 '.$idpedido);
         $rspta = $reactivoPedido->anularPedido($idpedido);
         echo $rspta ? "Pedido anulado" : "No se pudo anular pedido";
     break;
    case 'mostrar':
        $idpedido = $_POST['idpedido'];
        //  error_log('##########2344444 '.$idpedido);
        $rspta = $reactivoPedido->mostrar($idpedido);
        $rspta = pg_fetch_array($rspta);

        echo json_encode($rspta);
        break;
    case 'verMovimiento':
        //Recibimos el idingreso
        $idpedido = $_GET['id'];
        //   error_log('# '. $idpedido);   
        $rspta = $reactivoPedido->verMovimiento($idpedido);

        echo '<thead style="background-color:#A9D0F5"  scope="col">
                                    <th scope="col"><div style="width: 15px;text-align: center; font-size: 80%;"></div></th>
                                    <th scope="col"><div style="width: 65px;text-align: center; font-size: 100%;">Fecha de Envio</div></th>
                                    <th scope="col"><div style="width: 120px;text-align: center; font-size: 100%;">Usuario que Envio</div></th>
                                    
                                    <th scope="col"><div style="width: 100px;text-align: center; font-size: 100%;">Tiempo de Proceso</div></th>
                                   
                                    <th scope="col"><div style="width: 180px;text-align: center; font-size: 100%;">Estado</div></th>
                                   <th scope="col"><div style="width: 120px;text-align: center; font-size: 100%;">Obs Enviada</div></th>
                                    <th scope="col"><div style="width: 100px;text-align: center; font-size: 100%;">Destinatario</div></th>
                </thead>';

        while ($reg = pg_fetch_array($rspta)) {
            
             echo '<tr scope="col" class="filas"  style="font-size: 15px;">
    <td></td>
   <td id="fecha_envio" scope="col"><div style="width: 65px;text-align: center; font-size: 70%;">' . $reg['fecha_envio'] . '</div></td>
    <td id="remitente" scope="col""><div style="width: 120px;font-size: 70%;">' . $reg['remitente'] . '</div></td>
     <td id="tiempo_proceso" scope="col"><div style="width: 100px;font-size: 70%;">' . $reg['tiempo_proceso'] . '</div></td>
   
   <td id="estado" scope="col"><div style="width: 180px;font-size: 70%;">' . $reg['estado'] . '</div></td>
   <td scope="col" id="obs_envio"><div style="width: 150px; font-size: 80%;font-size: 70%;">' . $reg['obs_envio'] . '</div></td>
  <td id="destinatario" scope="col" ><div style="width: 100px;font-size: 70%;">' . $reg['destinatario'] . '</div></td>
</tr>';
             
        }

        break;
    
    
    
    case 'mostrarDetalle':
        //Recibimos el idingreso
        $cont = 3000;
        $idpedido = $_GET['id'];
        //   error_log('# '. $idpedido);   
        $rspta = $reactivoPedido->mostrarDetalle($idpedido);

        echo '<thead style="background-color:#A9D0F5"  scope="col">
                                    <th scope="col"><div style="width: 15px;text-align: center; font-size: 80%;"></div></th>
                                    <th scope="col"><div style="width: 50px;text-align: center; font-size: 80%;">Código</div></th>
                                    <th scope="col"><div style="width: 65px;text-align: center; font-size: 80%;">Código Catalogo</div></th>
                                    <th scope="col"><div style="width: 120px;text-align: center; font-size: 80%;">Descripción Producto</div></th>
                                    <th scope="col"><div style="width: 180px;text-align: center; font-size: 80%;">Especificación Técnica</div></th>
                                    <th scope="col"><div style="width: 100px;text-align: center; font-size: 80%;">Presentación</div></th>
                                    <th scope="col"><div style="width: 60px;text-align: center; font-size: 80%;">Pres. Entrega</div></th>
                                    <th scope="col"><div style="width: 60px;text-align: center; font-size: 80%;">U. Medida</div></th>
                                    <th scope="col"><div style="width: 60px;text-align: center; font-size: 80%;">Precio Ref.</div></th>
                                    <th scope="col"><div style="width: 50px;text-align: center; font-size: 80%;">Cant.</div></th>
                                    <th scope="col"><div style="width: 100px;text-align: center; font-size: 80%;">Observacion</div></th>
                            </thead>';

        while ($reg = pg_fetch_array($rspta)) {
            $cont = $cont + 1;
             echo '<tr scope="col" class="filas" id="fila' . $cont . '" style="font-size: 12px;">
                    <td style="text-align: center important;" scope="col"><div style="width: 15px;"><a class="btn btn-accent m-btn m-btn--custom 
                     m-btn--icon m-btn--air m-btn--pill" type="button" onclick="eliminarDetalle(' . $cont . ')">
                     <span><i class="fa fa-trash" style="color: indianred;"></i></span></a></div></td>
                     <td scope="col"><div style="width: 50px; font-size: 80%;"><input type="text" size="7" readonly="readonly"  name="idarticulo[]" value="' . $reg['codigo_medicamento'] . '"></div></td>
                     <td id="codigo_catalogo" scope="col" style=" font-size: 80%;"><div style="width: 65px;">' . $reg['codigo_catalogo'] . '</div></td>
                     <td scope="col" id="articulo"><div style="width: 150px; font-size: 80%;">' . $reg['producto'] . '</div></td>
                     <td id="especificacion_tecnica" scope="col" style=" font-size: 80%;"><div style="width: 180px;">' . $reg['especificacion_tecnica'] . '</div></td>
                     <td id="presentacion" scope="col" style=" font-size: 80%;"><div style="width: 100px;">' . $reg['presentacion'] . '</div></td>
                 <td scope="col"><div style="width: 60px; font-size: 80%;"><input type="text" size="9" name="presentacion_entrega[]" id="presentacion_entrega[]"value="' . $reg['presentacion_entrega'] . '"></div></td>
                     <td scope="col"><div style="width: 60px; font-size: 80%;"><input type="text" size="9" name="unidad_medida[]" id="unidad_medida[]"   value="' . $reg['unidad_medida'] . '"></div></td>
                     <td scope="col"><div style="width: 60px; font-size: 80%;"><input type="text" size="9" onkeyup="formatNumero(this)" onchange="formatNumero(this)" name="precio_referencial[]" id="precio_referencial[]"   value="'.number_format($reg['precio_referencial'], 0, '', '.').'"></div></td>
                     <td scope="col"><div style="width: 50px; font-size: 80%;"><input type="text" size="9" onkeyup="formatNumero(this)" onchange="formatNumero(this)" name="cantidad[]" id="cantidad[]"   value="'.number_format($reg['cantidad'], 0, '', '.'). '"></div></td>
                     <td scope="col"><div style="width: 100px; font-size: 80%;"><input type="text" size="15" name="obsD[]" id="obsD[]"   value="' . $reg['obs'] . '"></div></td></tr>';
        }
        break;
    case 'listar':
        $rspta = $reactivoPedido->listar($idusuario);
        //Vamos a declarar un array
        $data = array();
        while ($reg = pg_fetch_array($rspta)) {
           //  error_log('## '.$reg['codigo_lugar_envio']);
               $data[] = array(
               "0" => ($reg['destinatario'] == 0 ?
               '<a class="btn btn-accent m-btn m-btn--custom  
                m-btn--icon m-btn--air m-btn--pill" type="button" title="Editar" style="width:20%; font-size:18px;" onclick="mostrar(' . $reg['codigo'] . ')">
                <span><i class="fa fa-pencil" style="color: #6ab4d8;"></i></span></a>
                <a class="btn btn-accent m-btn m-btn--custom 
                m-btn--icon m-btn--air m-btn--pill" type="button" title="Borrar" style="width:20%; font-size:18px;" onclick="anularPedido(' . $reg['codigo'] . ')">
                <span><i class="fa fa-trash" style="color: indianred;"></i></span></a>
                <a class="btn btn-accent m-btn m-btn--custom 
                m-btn--icon m-btn--air m-btn--pill" type="button" title="Enviar Pedido" style="width:20%; font-size:18px;" onclick="mostrarEnviar(' . $reg['codigo'] . ')">
                <span><i class="fa fa-send fa-1x" style="color: #8064a2;" ></i></span></a>'
               :($reg['destinatario'] == $idusuario ?
               '<a class="btn btn-accent m-btn m-btn--custom 
                m-btn--icon m-btn--air m-btn--pill" type="button" title="Ver Pedido" style="width:20%; font-size:18px;" onclick="verPedido(' . $reg['codigo'] . ')">
                <span><i class="fa fa-folder-open" style="color:#ebd405;"></i></span></a>
                <a class="btn btn-accent m-btn m-btn--custom 
                m-btn--icon m-btn--air m-btn--pill" type="button" title="Enviar Pedido" style="width:20%; font-size:18px;" onclick="mostrarEnviar(' . $reg['codigo'] . ')">
                <span><i class="fa fa-send fa-1x" style="color: #8064a2;" ></i></span></a>
                <a data-toggle="modal" href="#modalMovimiento" class="btn btn-accent m-btn m-btn--custom 
                m-btn--icon m-btn--air m-btn--pill" type="button" title="Ver Movimientos" style="width:20%; font-size:18px;" onclick="verMovimiento(' . $reg['codigo'] . ')">
                <span><i class="fa fa-eye" style="color: #82b74b;"></i></span></a>'
               :
               '<a class="btn btn-accent m-btn m-btn--custom 
                m-btn--icon m-btn--air m-btn--pill" type="button" title="Ver Pedido" style="width:20%; font-size:18px;" onclick="verPedido(' . $reg['codigo'] . ')">
                <span><i class="fa fa-folder-open" style="color:#ebd405;"></i></span></a>
                <a data-toggle="modal" href="#modalMovimiento" class="btn btn-accent m-btn m-btn--custom 
                m-btn--icon m-btn--air m-btn--pill" type="button" title="Ver Movimientos" style="width:20%; font-size:18px;" onclick="verMovimiento(' . $reg['codigo'] . ')">
                <span><i class="fa fa-eye" style="color: #82b74b;"></i></span></a>
                ')),
              
                "1" => '<input name="idpedido" id="idpedido" type="hidden" value="' . $reg['codigo'] . '"> ' . $reg['codigo'],
                "2" => $reg['fecha_pedido'],
                "3" => $reg['establecimiento'],
                "4" => $reg['numero_expediente'],
                "5" => $reg['numero_nota'],
                "6" => $reg['estado_pedido']
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

    case 'listarArticulos':
  //  error_log('### '. 'PO'); 
        require_once "../modelos/Articulo.php";
        $articulo = new Articulo();
        $medicamentoJSON=json_decode($_GET['id']);
        $valores=array();
      // error_log("#####$$$$$$$$".count($medicamentoJSON->detalles));
        foreach($medicamentoJSON->detalles as $detalle)
        {
           array_push($valores, "$detalle->medicamento");
        }
      // $rspta = $articulo->listarReactivo();
        $rspta = $articulo->listarProducto();
       //Vamos a declarar un array
        $data = array();
  
        while ($reg = pg_fetch_array($rspta)) {
           
            $sw=in_array($reg['codigo'],$valores)?'style="display:none"':'';
            $swa=!in_array($reg['codigo'],$valores)?'style="display:none"':'';      
                  
            $data[] = array(
               "0" => '<a   '.$sw.' class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" id="btnAgregar' . $reg['codigo'] . '" class="btn btn-warning" title="Agregar Producto" onclick="agregarDetalle(' . $reg['codigo'] . ',\'' . $reg['producto'] . '\',\'' . $reg['codigo_catalogo'] . '\',\'' . $reg['especificacion_tecnica'] . '\',\'' . $reg['presentacion'] . '\')">
                        <span><i class="fa fa-plus" style="color: #f4c83a; font-size: 15px;"></i></span></a>
                <a  '.$swa.'class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" id="btnAgregado' . $reg['codigo'] . '" class="btn btn-primary" title="Producto Agregado">
                 <span><i class="fa fa-check" style="color: #a9aa00; font-size: 15px;"></i></span></a>',
                // Maite fin
                "1" => $reg['codigo'],
                "2" => $reg['codigo_catalogo'],
                "3" => $reg['producto'],
                "4" => $reg['especificacion_tecnica'],
                "5" => $reg['presentacion']
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
       
        case 'listarLugarEnvio':
      

        $rspta = $reactivoPedido->listarLugarEnvio($idusuario);

                   //Mostramos la lista de permisos en la vista y si están o no marcados
            while ($reg = pg_fetch_array($rspta)) {
                echo '<li> <input type="checkbox"  name="codigo_lugar_envio[]" value="' . $reg['codigo'] . '">' . '   - ' . $reg['nombre'] . '</li>';
            }
        
        break;
        
        case 'enviar':
       
        if (!file_exists($_FILES['imagenEnvio']['tmp_name']) || !is_uploaded_file($_FILES['imagenEnvio']['tmp_name'])) {
            $imagenEnvio = $_POST["imagenactualEnvio"];
        } else {
            $ext = explode(".", $_FILES["imagenEnvio"]["name"]);

            if ($_FILES['imagenEnvio']['type'] == "application/pdf" || $_FILES['imagenEnvio']['type'] == "image/jpg" || $_FILES['imagenEnvio']['type'] == "image/jpeg" || $_FILES['imagenEnvio']['type'] == "image/png") {

                $imagenEnvio = round(microtime(true)) . '.' . end($ext);

                move_uploaded_file($_FILES["imagenEnvio"]["tmp_name"], "../files/reactivoPedido/" . $imagenEnvio);
            }
        }
        if ($destinatario == "-1"){
            echo('Ingrese datos del destino');
        }
        if ($destinatario == "-1"){
            echo('Ingrese datos Estado Envio');
        }
        else {
           
              $rspta=$reactivoPedido->enviar($idcodigo,$idusuario, $destinatario,$obs_envio,$_POST["codigo_lugar_envio"],$imagenEnvio,$codigo_estado_envio);
              echo $rspta ? "Pedido enviado" : "No se pudieron registrar todos los datos del envio";
        
        }   
       
    break;
        
}
