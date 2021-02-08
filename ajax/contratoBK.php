<?php
if (strlen(session_id()) < 1)
    session_start();


require_once "../modelos/Contrato.php";


//error_log('### '.str_replace('.','', '10.000'));

$contrato = new Contrato();


 $detalles=[];
$idcodigo = isset($_POST["codigo"]) ? limpiarCadena($_POST["codigo"]) : "";
$numero_expediente = isset($_POST["numero_expediente"]) ? limpiarCadena($_POST["numero_expediente"]) : "";
$codigo_dependencia = isset($_POST["codigo_dependencia"]) ? limpiarCadena($_POST["codigo_dependencia"]) : "";
$codigo_tipo_resolucion = isset($_POST["codigo_tipo_resolucion"]) ? limpiarCadena($_POST["codigo_tipo_resolucion"]) : "";
$codigo_tipo_resolucion_concepto = isset($_POST["codigo_tipo_resolucion_concepto"]) ? limpiarCadena($_POST["codigo_tipo_resolucion_concepto"]) : "";
//$fecha_inicio= isset($_POST["fecha_inicio"]) ? limpiarCadena($_POST["fecha_inicio"]) : "";
//$fecha_fin = isset($_POST["fecha_fin"]) ? limpiarCadena($_POST["fecha_fin"]) : "";
$fecha_pedido = isset($_POST["fecha"]) ? limpiarCadena($_POST["fecha"]) : "";
$codigo_objeto_gasto = isset($_POST["codigo_objeto_gasto"]) ? limpiarCadena($_POST["codigo_objeto_gasto"]) : "";
$idusuario = $_SESSION["idusuario"];




$codigo_estado_envio = isset($_POST["codigo_estado_envio"]) ? limpiarCadena($_POST["codigo_estado_envio"]) : "";

$destinatario = isset($_POST["destinatario"]) ? limpiarCadena($_POST["destinatario"]) : "";
$obs_envio = isset($_POST["obs_envio"]) ? limpiarCadena($_POST["obs_envio"]) : "";

//error_log('##########2344444 '.$numero_nota);
//$idusuario=1; 
switch ($_GET["op"]) {
    case 'guardaryeditar':
        //error_log('##### imagen'.$_FILES['imagen']['type']);

        if (empty($idcodigo)) {
           $rspta = $contrato->insertar(
                                        $numero_expediente,
                                        $codigo_dependencia,
                                        $_POST["numero_documento"],
                                        $_POST["nombre_apellido"],
                                        $codigo_tipo_resolucion,
                                        $codigo_tipo_resolucion_concepto,
                                        $_POST["objeto"],
                                        $_POST["codigo_ubicacion_prestacion"],
                                        $_POST["salario"],
                                        $_POST["carga_horaria"],
                                        $_POST["cargo_funcion"],
                                        $_POST["codigo_region_sanitaria"],
                                        $_POST["especialidad"],
                                      //  $fecha_inicio,
                                   //     $fecha_fin,
                                        $_POST["vin1"],
                                        $_POST["vin2"],
                                        $_POST["sinar"],
                                        $_POST["obs"],
                                        $_POST["estado"],
                                        $fecha_pedido,
                                        $idusuario
                                        );
            
             echo $rspta ? "Resolucion registrada" : "No se pudieron registrar todos los datos de la resolucion";
        } else {

            $rspta = $contrato->modificar(
                                        $idcodigo,
                                        $numero_expediente,
                                        $codigo_dependencia,
                                        $_POST["numero_documento"],
                                        $_POST["nombre_apellido"],
                                        $codigo_tipo_resolucion,
                                        $codigo_tipo_resolucion_concepto,
                                        $_POST["objeto"],
                                        $_POST["codigo_ubicacion_prestacion"],
                                        $_POST["salario"],
                                        $_POST["carga_horaria"],
                                        $_POST["cargo_funcion"],
                                        $_POST["codigo_region_sanitaria"],
                                        $_POST["especialidad"],
                                   //     $fecha_inicio,
                                    //    $fecha_fin,
                                        $_POST["vin1"],
                                        $_POST["vin2"],
                                        $_POST["sinar"],
                                        $_POST["obs"],
                                        $_POST["estado"],
                                        $fecha_pedido,
                                        $idusuario
                                        );
                    echo $rspta ? "Resolucion modicado" : "No se pudiero modificar todos los datos de la resolucion";
        }
        break;
     case 'mostrarEnviar':
        $idcodigo = $_POST['idcodigo'];
     // error_log('##########2344444 '.$idpedido);
        $rspta = $contrato->mostrarEnviar($idcodigo);
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
        $rspta = $contrato->mostrar($idpedido);
        $rspta = pg_fetch_array($rspta);

        echo json_encode($rspta);
    break;
 case 'mostrarDetalle':
        $cont = 3000;
        $idpedido = $_GET['id'];
        //   error_log('# '. $idpedido);   
        $rspta = $contrato->mostrarDetalle($idpedido);

        echo '<thead style="background-color:#A9D0F5"  scope="col">
                                    <th scope="col"><div style="width: 15px;text-align: center; font-size: 80%;"></div></th>
                                    <th scope="col"><div style="width: 50px;text-align: center; font-size: 80%;">Nro.Doc.</div></th>
                                    <th scope="col"><div style="width: 65px;text-align: center; font-size: 80%;">Nombre y Apellido</div></th>
                                    <th scope="col"><div style="width: 120px;text-align: center; font-size: 80%;">Dependencia</div></th>
                                    <th scope="col"><div style="width: 180px;text-align: center; font-size: 80%;">Obj.Gasto</div></th>
                                    <th scope="col"><div style="width: 100px;text-align: center; font-size: 80%;">Función</div></th>
                                   <th scope="col"><div style="width: 100px;text-align: center; font-size: 80%;">Region Sanitaria</div></th>
                                    <th scope="col"><div style="width: 60px;text-align: center; font-size: 80%;">Especialidad</div></th>
                                    <th scope="col"><div style="width: 60px;text-align: center; font-size: 80%;">Monto</div></th>
                                    <th scope="col"><div style="width: 60px;text-align: center; font-size: 80%;">Carga Horaria</div></th>
                                    <th scope="col"><div style="width: 50px;text-align: center; font-size: 80%;">Vin.1</div></th>
                                    <th scope="col"><div style="width: 100px;text-align: center; font-size: 80%;">Vin.2</div></th>
                                     <th scope="col"><div style="width: 100px;text-align: center; font-size: 80%;">Sinar</div></th>
                                      <th scope="col"><div style="width: 100px;text-align: center; font-size: 80%;">Estado</div></th>
                                       <th scope="col"><div style="width: 100px;text-align: center; font-size: 80%;">Observacion</div></th>
                            </thead>';

        
        while ($reg = pg_fetch_array($rspta)) {
            $cont = $cont + 1;
            
            $cargos = $contrato->selectFuncion();
            $selectfuncion = '<option value="-1"> </option>'; 
            while($row_cargo = pg_fetch_array($cargos))
              {
              $sw= $row_cargo['codigo']== $reg['cargo_funcion']? 'selected':'';   
              
            //  error_log($row_cargo['codigo'].' '. $reg['cargo_funcion'].' '.$sw);
              $selectfuncion = $selectfuncion . '<option value="' . $row_cargo['codigo'] . '" '.$sw.'>' . $row_cargo['descripcion'] . '</option>';
            }
            
            $dependencias = $contrato->selectDepenciaMsp();
            $selectDependencias = '<option value="-1"> </option>'; 
            while($row_dependencias = pg_fetch_array($dependencias))
              {
              $sw= $row_dependencias['codigo']== $reg['codigo_ubicacion_prestacion']? 'selected':'';   
              
            //  error_log($row_cargo['codigo'].' '. $reg['cargo_funcion'].' '.$sw);
              $selectDependencias = $selectDependencias . '<option value="' . $row_dependencias['codigo'] . '" '.$sw.'>' . $row_dependencias['nombre'] . '</option>';
            }
           
            $objeto_gasto = $contrato->selectObjetoGasto();
            $selectOG = '<option value="-1"> </option>'; 
            while($row_og = pg_fetch_array($objeto_gasto))
              {
              $sw= $row_og['codigo']== $reg['codigo_objeto_gasto']? 'selected':'';   
              
            //  error_log($row_cargo['codigo'].' '. $reg['cargo_funcion'].' '.$sw);
              $selectOG = $selectOG . '<option value="' . $row_og['codigo'] . '" '.$sw.'>' . $row_og['descripcion'] . '</option>';
            }
            
            $region_sanitaria = $contrato->selectRegionSanitaria();
            
            
            $selectRegionSanitaria = '<option value="-1"> </option>'; 
            while($row_region = pg_fetch_array($region_sanitaria))
              {
             //    error_log($row_region['codigo']);
              $sw= $row_region['codigo']== $reg['codigo_region_sanitaria']? 'selected':'';   
             
            //  error_log($row_cargo['codigo'].' '. $reg['cargo_funcion'].' '.$sw);
              $selectRegionSanitaria = $selectRegionSanitaria . '<option value="' . $row_region['codigo'] . '" '.$sw.'>' . $row_region['nombre'] . '</option>';
            }
            
            if($reg['vin1']== '1'){
                $vin1 = '<option value="-1"> </option><option selected value="1">SI</option><option value="2">NO</option>';
                
            }else {
                $vin1 = '<option value="-1"> </option><option value="1">SI</option><option selected value="2">NO</option>';
            }
                              
           if($reg['vin2']== '1'){
                $vin2 = '<option value="-1"> </option><option selected value="1">SI</option><option value="2">NO</option>';
                
            }else {
                $vin2 = '<option value="-1"> </option><option value="1">SI</option><option selected value="2">NO</option>';
            } 
            if($reg['codigo_estado']== '1'){
                $estado = '<option value="-1"> </option><option selected value="1">INCLUIR</option><option value="2">EXCLUIR</option>';
                
            }else {
                $estado = '<option value="-1"> </option><option value="1">INCLUIR</option><option selected value="2">EXCLUIR</option>';
            }         
            
            
               echo '<tr  scope="col" id="fila'.$cont. '" class="filas" style="font-size: 12px;" >
       <td scope="col" style="text-align: center;"><div style="width: 15px;"><a class="btn btn-accent m-btn m-btn--custom
       m-btn--icon m-btn--air m-btn--pill" type="button" onclick="eliminarDetalle('.$cont.')" style="padding: unset;">
       <span><i class="fa fa-trash" style="color: indianred; "></i></span></a>
      <td scope="col"><input type="hidden" readonly="readonly" name="numero_documento[]" id="numero_documento[]" value="'. $reg['numero_documento'].'">'.$reg['numero_documento'].'</td>
      <td scope="col" style="width: 180px;font-size: 100%;"><div style="width: 180px;font-size:100%;"><input style="width: 180px;font-size:100%;" type="hidden" name="nombre_apellido[]" id="nombre_apellido[]" value ="'. $reg['nombre_apellido'].'">'. $reg['nombre_apellido'].'</div></td>
          <td><select id="codigo_ubicacion_prestacion[]" name="codigo_ubicacion_prestacion[]">'.$selectDependencias.'</select></td>
        <td><select id="objeto[]" name="objeto[]">'.$selectOG.'</select></td>        
       
       <td><select id="cargo_funcion[]" name="cargo_funcion[]">'.$selectfuncion.'</select></td>  
       <td><select id="codigo_region_sanitaria[]" name="codigo_region_sanitaria[]">'.$selectRegionSanitaria.'</select></td>     
       <td scope="col" style="width: 180px;font-size: 100%;"><div style="width: 180px;font-size:100%;"><input style="width: 180px;font-size:100%;" type="text" name="especialidad[]" id="especialidad[]" value="' . $reg['especialidad'] . '"></div></td>
       <td scope="col" style="width: 100px;font-size: 100%;"><div style="width: 100px;font-size:100%;"><input style="width: 100px;font-size:100%;" type="text" name="salario[]" id="salario[]" value="' . $reg['salario'] . '"></div></td>
       <td scope="col" style="width: 100px;font-size: 100%;"><div style="width: 100px;font-size:100%;"><input style="width: 100px;font-size:100%;" type="text" name="carga_horaria[]" id="carga_horaria[]" value="' . $reg['carga_horaria'] . '"></div></td>
        <td><select id="vin_1[]" name="vin1[]">'.$vin1.'</select></td> 
        <td><select id="vin_2[]" name="vin2[]">'.$vin2.'</select></td> 
        <td scope="col" style="width: 100px;font-size: 100%;"><div style="width: 100px;font-size:100%;"><input style="width: 100px;font-size:100%;" type="text" name="sinar[]" id="sinar[]" value="' . $reg['sinar'] . '"></div></td>
        <td><select id="estado[]" name="estado[]">'.$estado.'</select></td> 
         <td scope="col" style="width: 100px;font-size: 100%;"><div style="width: 100px;font-size:100%;"><input style="width: 100px;font-size:100%;" type="text" name="obs[]" id="obs[]" value="' . $reg['obs'] . '"></div></td>
          </tr>';
        }
        break;
    case 'obtenerDependencia':
        $codigo_sirh = $_POST['codigo_sirh'];
        //  error_log('##########2344444 '.$idpedido);
        $rspta = $contrato->obtenerDependencia($codigo_sirh);
        $rspta = pg_fetch_array($rspta);

        echo json_encode($rspta);
    break;

    case 'verMovimiento':
        //Recibimos el idingreso
        $idpedido = $_GET['id'];
        //   error_log('# '. $idpedido);   
        $rspta = $contrato->verMovimiento($idpedido);

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
    case 'verVinculo':
        //Recibimos el idingreso
        $numero_cedula = $_GET['id'];
        //   error_log('# '. $idpedido);   
        $rspta = $contrato->verVinculo($numero_cedula);

        echo '<thead style="background-color:#A9D0F5"  scope="col">
                                    <th scope="col"><div style="width: 15px;text-align: center; font-size: 80%;"></div></th>
                                    <th scope="col"><div style="width: 65px;text-align: center; font-size: 100%;">Tipo Vinculo</div></th>
                                    <th scope="col"><div style="width: 120px;text-align: center; font-size: 100%;">Objeto Gasto</div></th>
                                    
                                    <th scope="col"><div style="width: 100px;text-align: center; font-size: 100%;">Monto</div></th>
                                     <th scope="col"><div style="width: 100px;text-align: center; font-size: 100%;">Horas Semanal</div></th>
                                     <th scope="col"><div style="width: 100px;text-align: center; font-size: 100%;">Horas Mensual</div></th>
                                      <th scope="col"><div style="width: 100px;text-align: center; font-size: 100%;">Frecuencia</div></th>
                               
                </thead>';

        while ($reg = pg_fetch_array($rspta)) {
            
             echo '<tr scope="col" class="filas"  style="font-size: 15px;">
    <td></td>
   <td id="modal_tipo_vinculo" scope="col"><div style="width: 65px;text-align: center; font-size: 70%;">' . $reg['tipo_vinculo'] . '</div></td>
    <td id="modal_codigo_objeto_gasto" scope="col""><div style="width: 120px;font-size: 70%;">' . $reg['codigo_objeto_gasto'] . '</div></td>
     <td id="modal_monto_vinculo" scope="col"><div style="width: 100px;font-size: 70%;">' . $reg['monto'] . '</div></td>
          <td id="modal_horas_semanal" scope="col"><div style="width: 100px;font-size: 70%;">' . $reg['horas_semanal'] . '</div></td>
               <td id="modal_horas_mensual" scope="col"><div style="width: 100px;font-size: 70%;">' . $reg['horas_mensual'] . '</div></td>
                     <td id="modal_frecuencia" scope="col"><div style="width: 100px;font-size: 70%;">' . $reg['frecuencia'] . '</div></td>
  
</tr>';
             
        }

        break;
      case 'verEspecialidad':
        //Recibimos el idingreso
        $numero_cedula = $_GET['id'];
        //   error_log('# '. $idpedido);   
        $rspta = $contrato->verEspecialidad($numero_cedula);

        echo '<thead style="background-color:#A9D0F5"  scope="col">
                                    <th scope="col"><div style="width: 15px;text-align: center; font-size: 80%;"></div></th>
                                    <th scope="col"><div style="width: 65px;text-align: center; font-size: 100%;">Codigo</div></th>
                                    <th scope="col"><div style="width: 120px;text-align: center; font-size: 100%;">Nro. Registro</div></th>
                                    
                                    <th scope="col"><div style="width: 100px;text-align: center; font-size: 100%;">Especialidad</div></th>
                                    
                               
                </thead>';

        while ($reg = pg_fetch_array($rspta)) {
            
             echo '<tr scope="col" class="filas"  style="font-size: 15px;">
    <td></td>
   <td id="modal_codigo_especialidad" scope="col"><div style="width: 65px;text-align: center; font-size: 70%;">' . $reg['codigo_especialidad'] . '</div></td>
    <td id="modal_numero_registro" scope="col""><div style="width: 120px;font-size: 70%;">' . $reg['numero_registro'] . '</div></td>
     <td id="modal_nombre_especialidad" scope="col"><div style="width: 100px;font-size: 70%;">' . $reg['nombre_especialidad'] . '</div></td>
        
  
</tr>';
             
        }

        break;   
        
        
        
    case 'listar':
        $rspta = $contrato->listar();
        //Vamos a declarar un array
        $data = array();
        while ($reg = pg_fetch_array($rspta)) {
           //  error_log('## '.$reg['codigo_lugar_envio']);
               $data[] = array(
               "0" => ($reg['codigo_estado'] == 1 ?
               '<a class="btn btn-accent m-btn m-btn--custom  
                m-btn--icon m-btn--air m-btn--pill" type="button" title="Editar" style="width:20%; font-size:18px;" onclick="mostrar(' . $reg['codigo'] . ')">
                <span><i class="fa fa-pencil" style="color: #6ab4d8;"></i></span></a>
                <a class="btn btn-accent m-btn m-btn--custom 
                m-btn--icon m-btn--air m-btn--pill" type="button" title="Borrar" style="width:20%; font-size:18px;" onclick="anularPedido(' . $reg['codigo'] . ')">
                <span><i class="fa fa-trash" style="color: indianred;"></i></span></a>
                <a class="btn btn-accent m-btn m-btn--custom 
                m-btn--icon m-btn--air m-btn--pill" type="button" title="Enviar Pedido" style="width:20%; font-size:18px;" onclick="mostrarEnviar(' . $reg['codigo'] . ')">
                <span><i class="fa fa-send fa-1x" style="color: #8064a2;" ></i></span></a>'
               :($reg['codigo'] == $reg['codigo'] ?
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
              
               
                   
                "1" => $reg['numero_item'],   
                "2" => $reg['codigo_objeto_gasto'],   
                "3" => number_format($reg['numero_documento'],0,'','.'),
                "4" => $reg['nombre_apellido'],
                "5" => $reg['descripcion_cargo'],  
                "6" => $reg['nombre_region_sanitaria'], 
                "7" => $reg['ubicacion_prestacion'],
                "8" => number_format($reg['salario'],0,'','.'),
                "9" => $reg['carga_horaria'],   
                "10" => '<input name="numero_expediente" id="numero_expediente" type="hidden" value="' . $reg['numero_expediente'] . '"> ' . $reg['numero_expediente'],
                "11" => $reg['des_tipo_resolucion'],
                "12" => $reg['des_tipo_resolucion_concepto'],
                
                "13" => $reg['especialidad'],  
            //    "12" => $reg['fecha_inicio'],   
             //   "13" => $reg['fecha_fin'],   
           //     "12" => $reg['sinar'],  
                "14" => ($reg['codigo_estado_detalle'] == 1 ? 'INCLUIR':'EXCLUIR')
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
  

    case 'listarTodasPersona':
  //  error_log('### '. 'PO'); 
        require_once "../modelos/Persona.php";
        $persona = new Persona();
        $numeroDocumentoJSON=json_decode($_GET['id']);
        $valores=array();
      // error_log("#####$$$$$$$$".count($medicamentoJSON->detalles));
        foreach($numeroDocumentoJSON->detalles as $detalle)
        {
           array_push($valores, "$detalle->numeroDocumento");
        }
      // $rspta = $articulo->listarReactivo();
        $rspta = $persona->listarTodasPersona();
       //Vamos a declarar un array
        $data = array();
  
        while ($reg = pg_fetch_array($rspta)) {
           
            $sw=in_array($reg['cedula_identidad'],$valores)?'style="display:none"':'';
            $swa=!in_array($reg['cedula_identidad'],$valores)?'style="display:none"':'';      
                  
            $data[] = array(
                "0" => '<a   '.$sw.' class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" id="btnAgregar' . $reg['cedula_identidad'] . '" class="btn btn-warning" title="Agregar Persona" onclick="agregarDetalle(' . $reg['cedula_identidad'] . ',\'' . $reg['nombres'] . '\',\'' . $reg['apellidos'] . '\')">
                        <span><i class="fa fa-plus" style="color: #f4c83a; font-size: 15px;"></i></span></a>
                 <a  '.$swa.'class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" id="btnAgregado' . $reg['cedula_identidad'] . '" class="btn btn-primary" title="Producto Agregado">
                 <span><i class="fa fa-check" style="color: #a9aa00; font-size: 15px;"></i></span></a>',
                // Maite fin
                "1" => $reg['cedula_identidad'],
                "2" => $reg['nombres'],
                "3" => $reg['apellidos']
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
      

        $rspta = $contrato->listarLugarEnvio($idusuario);

                   //Mostramos la lista de permisos en la vista y si están o no marcados
            while ($reg = pg_fetch_array($rspta)) {
                echo '<li> <input type="checkbox"  name="codigo_lugar_envio[]" value="' . $reg['codigo'] . '">' . '   - ' . $reg['nombre'] . '</li>';
            }
        
        break;
        
       case 'cargarArchivo':
           //  error_log("entre");
            $ext = explode(".", $_FILES["imagen"]["name"]);

            $imagen = round(microtime(true)) . '.' . end($ext);
         //   error_log("###### ".exec('whoami'));
            move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/contratoSIRHH/".$imagen);
           
            /*
                Ejemplo de lectura de CSV
                desde PHP
                Visita parzibyte.me/blog
            */
            # La longitud máxima de la línea del CSV. Si no la sabes,
            # ponla en 0 pero la lectura será un poco más lenta
            $longitudDeLinea = 1000;
            $numero_cedula = "";
            $nombre = "";
            $item = "";
            $objeto_gasto="";
            $codigo_funcion ="";
            $monto="";
            $codigo_ubicacion ="";
           
            
            $delimitador = ","; # Separador de columnas
            $caracterCircundante = '"'; # A veces los valores son encerrados entre comillas
            $nombreArchivo = "../files/contratoSIRHH/".$imagen; #Ruta del archivo, en este caso está junto a este script
            # Abrir el archivo
            $gestor = fopen($nombreArchivo, "r");
            if (!$gestor) {
                exit("No se puede abrir el archivo $nombreArchivo");
            }

            #  Comenzar a leer, $numeroDeFila es para llevar un índice
            $numeroDeFila = 1;


        while (($fila = fgetcsv($gestor, $longitudDeLinea, $delimitador, $caracterCircundante)) !== false) 
                {

         
            foreach ($fila as $numeroDeColumna => $columna) {
             
                if ($numeroDeColumna===0 and $numeroDeFila !== 1){
                  //  error_log("### ".$numeroDeColumna.'-'.$numeroDeFila);
                    $numero_cedula = $columna;
                    
                    
                }
                if ($numeroDeColumna===1 and $numeroDeFila !== 1){
                  //  error_log("### ".$numeroDeColumna.'-'.$numeroDeFila);
                    $item = $columna;
                    
                }
                if ($numeroDeColumna===2 and $numeroDeFila !== 1){
                  //  error_log("### ".$numeroDeColumna.'-'.$numeroDeFila);
                    $objeto_gasto = $columna;
                    
                }
                if ($numeroDeColumna===3 and $numeroDeFila !== 1){
                  //  error_log("### ".$numeroDeColumna.'-'.$numeroDeFila);
                    $codigo_funcion = $columna;
    
                }
                 if ($numeroDeColumna===5 and $numeroDeFila !== 1){
                  //  error_log("### ".$numeroDeColumna.'-'.$numeroDeFila);
                    $monto = $columna;
                    
                }
                 if ($numeroDeColumna===6 and $numeroDeFila !== 1){
                 //  error_log("### ".$numeroDeColumna.'-'.$numeroDeFila);
                    $codigo_ubicacion = $columna;
                    
                }
            }
                
             $detalle = array(
                    'numero_cedula' => $numero_cedula,
                    'item' => $item,
                    'objeto_gasto' => $objeto_gasto,
                    'codigo_funcion' => $codigo_funcion,
                    'monto' => $monto,
                    'codigo_ubicacion' =>$codigo_ubicacion);
             
             
            
             array_push($detalles, $detalle);
          //  error_log ('######### '.$detalles[1]['numero_cedula']);
            $numeroDeFila++;
        }
     
   
       foreach($detalles as $key => $val) {
       
          error_log ('######### '.$key.' NumeroCedula: '.$val['numero_cedula'].' Item: '.$val['item'].' Monto: '.$val['monto']);
        
       }   
     /////  
   //    foreach($detalles as $key => $val) {
       //   foreach($val as $key2 => $val2){
      //    error_log ('######### '.$key2.': '.$val2);
    //    }
     //  }   
    
        fclose($gestor);
      //  echo(json_encode($detalles));
      break;   
      
      
      
      
      
      case 'cargarArchivoCsv':
        $cont = 0;
     //   $archivo_cedula = $_GET['id'];
        //   error_log('# '. $idpedido);  
     /// /  require_once "../modelos/Persona.php";
       // $persona = new Persona();
    //    $rspta = $persona->listarPersona('0'.','.$archivo_cedula);

        echo '<thead style="background-color:#A9D0F5"  scope="col">
                                    <th scope="col"><div style="width: 15px;text-align: center; font-size: 80%;"></div></th>
                                    <th scope="col"><div style="width: 20px;text-align: center; font-size: 80%;">Item</div></th>
                                    <th scope="col"><div style="width: 50px;text-align: center; font-size: 80%;">Nro.Doc.</div></th>
                                    <th scope="col"><div style="width: 100px;text-align: center; font-size: 80%;">Nombre y Apellido</div></th>
                                    <th scope="col"><div style="width: 45px;text-align: center; font-size: 80%;">Obj.Gasto</div></th>
                                     <th scope="col"><div style="width: 20px;text-align: center; font-size: 80%;">Vin.</div></th>
                                     <th scope="col"><div style="width: 45px;text-align: center; font-size: 80%;">Carga Horaria</div></th>
                                    <th scope="col"><div style="width: 60px;text-align: center; font-size: 80%;">Monto</div></th>
                                 
                                  <th scope="col"><div style="width: 100px;text-align: center; font-size: 80%;">Función</div></th>
                                  <th scope="col"><div style="width: 60px;text-align: center; font-size: 80%;">Espec.</div></th>
                                   <th scope="col"><div style="width: 100px;text-align: center; font-size: 80%;">Region Sanitaria</div></th>
                                    <th scope="col"><div style="width: 50px;text-align: center; font-size: 80%;">Depen.</div></th>
                                    
                                 
                                    
                                   
                                     <th scope="col"><div style="width: 100px;text-align: center; font-size: 80%;">Sinar</div></th>
                                      <th scope="col"><div style="width: 100px;text-align: center; font-size: 80%;">Estado</div></th>
                                       <th scope="col"><div style="width: 100px;text-align: center; font-size: 80%;">Observacion</div></th>
                            </thead>';
          foreach($detalles as $key => $val) {
                 error_log ('######### '.$key.' NumeroCedula: '.$val['numero_cedula'].' Item: '.$val['item'].' Monto: '.$val['monto']);
        
        
      //  while ($reg = pg_fetch_array($rspta)) {
            $cont = $cont + 1;
            
            $cantidad_vinculo = $contrato->contarVinculo($reg['cedula_identidad']);
            $cantidad_vinculo = pg_fetch_array($cantidad_vinculo);
    //        error_log('##### '.$cantidad_vinculo['cantidad_vinculo']);
            $vinculo = $cantidad_vinculo['cantidad_vinculo'];
            
            
            $cantidad_especialidad = $contrato->contarEspecialidad($reg['cedula_identidad']);
            $cantidad_especialidad = pg_fetch_array($cantidad_especialidad);
    //        error_log('##### '.$cantidad_vinculo['cantidad_vinculo']);
            $especialidad = $cantidad_especialidad['cantidad_especialidad'];
            
            
            $cargos = $contrato->selectFuncion();
            $selectfuncion = '<option value="-1"> </option>'; 
            while($row_cargo = pg_fetch_array($cargos))
              {
            //  $sw= $row_cargo['codigo']== $reg['cargo_funcion']? 'selected':'';   
               $sw='';
            //  error_log($row_cargo['codigo'].' '. $reg['cargo_funcion'].' '.$sw);
              $selectfuncion = $selectfuncion . '<option value="' . $row_cargo['codigo'] . '" '.$sw.'>' . $row_cargo['descripcion'] . '</option>';
            }
           /* $contSelect = 0;
            $especialidadPersona = $contrato->selectEspecialidadPersona($reg['cedula_identidad']);
            $selectEspecialidad = '<option value="' . 'NO' . '">' .'SIN ESPECIALIDAD' . '</option>'; 
            while($row_especialidad = pg_fetch_array($especialidadPersona))
              {
                if ($contSelect == 0) {
                    $selectEspecialidad = '';
                }
               
            //  $sw= $row_cargo['codigo']== $reg['cargo_funcion']? 'selected':'';   
                $sw='';
           //  error_log($row_especialidad['codigo_especialidad'].' '. $row_especialidad['nombre_especialidad'].' '.$sw);
                $selectEspecialidad = $selectEspecialidad . '<option value="' . $row_especialidad['codigo_especialidad'] . '" '.$sw.'>' . $row_especialidad['nombre_especialidad'] . '</option>';
                $contSelect++;
              }
            
         */   
            $dependencias = $contrato->selectDepenciaMsp();
            $selectDependencias = '<option value="-1"> </option>'; 
            while($row_dependencias = pg_fetch_array($dependencias))
              {
            //  $sw= $row_dependencias['codigo']== $reg['codigo_ubicacion_prestacion']? 'selected':'';   
               $sw='';
            //  error_log($row_cargo['codigo'].' '. $reg['cargo_funcion'].' '.$sw);
              $selectDependencias = $selectDependencias . '<option title="' . $row_dependencias['nombre'] . '"   value="' . $row_dependencias['codigo'] . '" '.$sw.'>' . $row_dependencias['codigo'] . '</option>';
            }
           
            $objeto_gasto = $contrato->selectObjetoGasto();
            $selectOG = '<option value="-1"> </option>'; 
            while($row_og = pg_fetch_array($objeto_gasto))
              {
           //   $sw= $row_og['codigo']== $reg['codigo_objeto_gasto']? 'selected':'';   
              $sw='';
            //  error_log($row_cargo['codigo'].' '. $reg['cargo_funcion'].' '.$sw);
              $selectOG = $selectOG . '<option title="' . $row_og['descripcion'] . '" value="' . $row_og['codigo'] . '" '.$sw.'>' . $row_og['codigo'] . '</option>';
            }
            
            $region_sanitaria = $contrato->selectRegionSanitaria();
            $selectRegionSanitaria = '<option value="-1"> </option>'; 
            while($row_region = pg_fetch_array($region_sanitaria))
              {
             //    error_log($row_region['codigo']);
             // $sw= $row_region['codigo']== $reg['codigo_region_sanitaria']? 'selected':'';   
              $sw='';
            //  error_log($row_cargo['codigo'].' '. $reg['cargo_funcion'].' '.$sw);
              $selectRegionSanitaria = $selectRegionSanitaria . '<option value="' . $row_region['codigo'] . '" '.$sw.'>' . $row_region['nombre'] . '</option>';
            }
       
             $estado = '<option value="-1"> </option><option selected value="1">INCLUIR</option><option value="2">EXCLUIR</option>';
                
             
            
            
               echo '<tr  scope="col" id="fila'.$cont. '" class="filas" style="font-size: 12px;" >
       <td scope="col" style="text-align: center;"><div style="width: 15px;"><a class="btn btn-accent m-btn m-btn--custom
       m-btn--icon m-btn--air m-btn--pill" type="button" onclick="eliminarDetalle('.$cont.')" style="padding: unset;">
       <span><i class="fa fa-trash" style="color: indianred; "></i></span></a>
        <td scope="col"><input type="hidden" readonly="readonly" name="item[]" id="item[]" value="'.$cont.'">'.$cont.'</td>
      <td scope="col"><input type="hidden" readonly="readonly" name="numero_documento[]" id="numero_documento[]" value="'. $reg['cedula_identidad'].'">'.$reg['cedula_identidad'].'</td>
      <td scope="col" style="width: 180px;font-size: 100%;"><div style="width: 180px;font-size:100%;"><input style="width: 180px;font-size:100%;" type="hidden" name="nombre_apellido[]" id="nombre_apellido[]" value ="'. $reg['nombres'].' '. $reg['apellidos'].'">'. $reg['nombres'].' '. $reg['apellidos'].'</div></td>
     <td><select id="objeto[]" name="objeto[]">'.$selectOG.'</select></td>     
<td scope="col"><input type="hidden" readonly="readonly" name="vin[]" id="vin[]" value="'. $vinculo.'">'.$vinculo.'
       <a data-toggle="modal" href="#modalVinculo" class="btn btn-accent m-btn m-btn--custom 
                m-btn--icon m-btn--air m-btn--pill" type="button" title="Ver Vinculos" style="width:20%; font-size:14px;" onclick="verVinculo(' . $reg['cedula_identidad'] . ')">
                <span><i class="fa fa-eye" style="color: #82b74b;"></i></span></a>    

      </td>    

      <td scope="col" style="width: 45px;font-size: 100%;"><div style="width: 45px;font-size:100%;"><input style="width: 45px;font-size:100%;" type="text" name="carga_horaria[]" id="carga_horaria[]" value="' .'' . '"></div></td>
      
      <td scope="col" style="width: 100px;font-size: 100%;"><div style="width: 100px;font-size:100%;"><input style="width: 100px;font-size:100%;" type="text" name="salario[]" id="salario[]" value="' . '' . '"></div></td>
    
      <td><select id="cargo_funcion[]" name="cargo_funcion[]">'.$selectfuncion.'</select></td>  
 
<td scope="col"><input type="hidden" readonly="readonly" name="cantidad_especialidad[]" id="cantidad_especialidad[]" value="'. $especialidad.'">'.$especialidad.'
       <a data-toggle="modal" href="#modalEspecialidad" class="btn btn-accent m-btn m-btn--custom 
                m-btn--icon m-btn--air m-btn--pill" type="button" title="Ver Especialidad" style="width:20%; font-size:14px;" onclick="verEspecialidad(' . $reg['cedula_identidad'] . ')">
                <span><i class="fa fa-eye" style="color: #82b74b;"></i></span></a>    

      </td>          



       <td><select id="codigo_region_sanitaria[]" name="codigo_region_sanitaria[]">'.$selectRegionSanitaria.'</select></td> 
       <td><select  id="codigo_ubicacion_prestacion[]" name="codigo_ubicacion_prestacion[]">'.$selectDependencias.'</select></td>
          
        
         
        <td scope="col" style="width: 100px;font-size: 100%;"><div style="width: 100px;font-size:100%;"><input style="width: 100px;font-size:100%;" type="text" name="sinar[]" id="sinar[]" value="' . '' . '"></div></td>
        <td><select id="estado[]" name="estado[]">'.$estado.'</select></td> 
         <td scope="col" style="width: 100px;font-size: 100%;"><div style="width: 100px;font-size:100%;"><input style="width: 100px;font-size:100%;" type="text" name="obs[]" id="obs[]" value="' . '' . '"></div></td>
          </tr>';
       }
        
        break;
      
      
      
      
      
           /// cargamos el query para mostrar
      case 'cargarPersona': 
        $archivo_cedula = $_GET['id'];
        //  error_log("#### ".$archivo_cedula);
        require_once "../modelos/Persona.php";
        $persona = new Persona();
        $rspta = $persona->listarPersona('0'.','.$archivo_cedula);
       //Vamos a declarar un array
        $data = array();
  
        while ($reg = pg_fetch_array($rspta)) {
           
          //  $sw=in_array($reg['cedula_identidad'],$valores)?'style="display:none"':'';
          //  $swa=!in_array($reg['cedula_identidad'],$valores)?'style="display:none"':'';      
            $sw = 'style="display:none"'; 
            $swa= 'style="display:none"'; 
            $data[] = array(
                "0" => '<a class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" id="btnAgregar' . $reg['cedula_identidad'] . '" class="btn btn-warning" title="Agregar Persona" onclick="agregarDetalle(' . $reg['cedula_identidad'] . ',\'' . $reg['nombres'] . '\',\'' . $reg['apellidos'] . '\')">
                        <span><i class="fa fa-plus" style="color: #f4c83a; font-size: 15px;"></i></span></a>
                         <a  '.$swa.'class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" id="btnAgregado' . $reg['cedula_identidad'] . '" class="btn btn-primary" title="Producto Agregado">
                 <span><i class="fa fa-check" style="color: #a9aa00; font-size: 15px;"></i></span></a>',
                // Maite fin
                "1" => $reg['cedula_identidad'],
                "2" => $reg['nombres'],
                "3" => $reg['apellidos']
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
        
        case 'enviar':
       //error_log('############entre ');
        if (!file_exists($_FILES['imagenEnvio']['tmp_name']) || !is_uploaded_file($_FILES['imagenEnvio']['tmp_name'])) {
            $imagenEnvio = $_POST["imagenactualEnvio"];
        } else {
            $ext = explode(".", $_FILES["imagenEnvio"]["name"]);

            if ($_FILES['imagenEnvio']['type'] == "application/pdf" || $_FILES['imagenEnvio']['type'] == "image/jpg" || $_FILES['imagenEnvio']['type'] == "image/jpeg" || $_FILES['imagenEnvio']['type'] == "image/png") {

                $imagenEnvio = round(microtime(true)) . '.' . end($ext);

                move_uploaded_file($_FILES["imagenEnvio"]["tmp_name"], "../files/contratoSIRH/" . $imagenEnvio);
            }
        }
        if ($destinatario == "-1"){
            echo('Ingrese datos del destino');
        }
        if ($destinatario == "-1"){
            echo('Ingrese datos Estado Envio');
        }
        else {
           
              $rspta=$contrato->enviar($idcodigo,$idusuario, $destinatario,$obs_envio,$_POST["codigo_lugar_envio"],$imagenEnvio,$codigo_estado_envio);
              echo $rspta ? "Pedido enviado" : "No se pudieron registrar todos los datos del envio";
        
        }   
       
    break;
         case 'selectTipoResolucion':
          
          $rspta = $contrato->selectTipoResolucion();
          echo '<option value="-1"> </option>';
          while($reg = pg_fetch_array($rspta))
              {
              echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>'; 
              
          }
      break;   
    
      case 'selectTipoResolucionConcepto':
       
          
          $rspta = $contrato->selectTipoResolucionConcepto();
          echo '<option value="-1"> </option>';
          while($reg = pg_fetch_array($rspta))
              {
              echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>'; 
              
           }
      break;
      case 'selectDepenciaMsp':
          
          $rspta = $contrato->selectDepenciaMsp();
          echo '<option value="-1"> </option>';
          while($reg = pg_fetch_array($rspta))
              {
              echo '<option value=' . $reg['codigo'] . '>' . $reg['nombre'] . '</option>'; 
              
              }
      break;  
 
      case 'selectObjetoGasto':
          
          $rspta = $contrato->selectObjetoGasto();
       //   echo '<option value="-1"> </option>';
         $selectObjetoGasto = '<option value="-1"> </option>';
          while($reg = pg_fetch_array($rspta))
          {
            $selectObjetoGasto = $selectObjetoGasto . '<option value="' . $reg['codigo'] . '">' . $reg['descripcion'] . '</option>';
          }
  //    error_log($selectObjetoGasto);
           echo $selectObjetoGasto;
        break;   
        case 'selectFuncion':
          
          $rspta = $contrato->selectFuncion();
         // echo '<option value="-1"> </option>';
          $selectfuncion = '<option value="-1"> </option>';
          while($reg = pg_fetch_array($rspta))
              {
         //     echo '<option value=' . $reg['codigo'] . '>' . $reg['descripcion'] . '</option>'; 
             
              
              $selectfuncion = $selectfuncion . '<option value="' . $reg['codigo'] . '">' . $reg['descripcion'] . '</option>';
          }
    //  error_log($selectfuncion);
          echo $selectfuncion;
          break; 
          
          case 'selectRegionSanitaria':
          
          $rspta = $contrato->selectRegionSanitaria();
         // echo '<option value="-1"> </option>';
          $selectRegionSanitaria = '<option value="-1"> </option>';
          while($reg = pg_fetch_array($rspta))
              {
         //     echo '<option value=' . $reg['codigo'] . '>' . $reg['descripcion'] . '</option>'; 
             
             $selectRegionSanitaria = $selectRegionSanitaria . '<option value="' . $reg['codigo'] . '">' . $reg['nombre'] . '</option>';
          }
       //error_log($selectObjetoGasto);
           echo $selectRegionSanitaria;
          break;   
        
}
