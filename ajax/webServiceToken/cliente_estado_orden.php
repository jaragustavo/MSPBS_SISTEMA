<?php

    /*** INICIO CONSUMO DE Consulta estado de orden de compra ***/
    // Definimos el cuerpo del mensaje a enviar
    $data = array(
        'serviceName' => "estadoOrdenCompra",
        'param' => array("ordenCompra" => 452) // nro orden de compra
    );
    $getData = json_encode($data);

    // Iniciamos una conexion http, pasamos los parametros de cabecera y el cuerpo del mensaje
    $cURLConnection = curl_init();
    curl_setopt($cURLConnection, CURLOPT_URL, 'http://localhost/systework/sistema/webservices/');
    curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer '.$token
    ));
    curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, 'GET' );
    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $getData);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

    // Enviamos la solicitud y obtenemos la respuesta
    $apiResponse = curl_exec($cURLConnection);
    $status = curl_getinfo($cURLConnection, CURLINFO_HTTP_CODE); // 200
    curl_close($cURLConnection);

    if ('200' == $status)
    {
        // respuesta recibida del webservice
        $data = json_decode($apiResponse, true);
        $respuesta = $data['response'];
        if($respuesta['status'] == '200'){
            // guardamos las ordenes de compra y el total de registros
            $totalRegistros = $respuesta['result']['totalRegistros'];
            $expedientes = $respuesta['result']['expedientes'];
        }else{
            print json_encode(array("status" => $respuesta['status'], "message" => $respuesta['result']));
        }
    }else{
      print json_encode(array("status" => "error", "message" => "sistework_server_failure"));
    } 
    /*** FIN CONSUMO DE Consulta estado de orden de compra ***/

?>
