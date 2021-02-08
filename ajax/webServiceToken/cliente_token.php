<?php

    /*** INICIO OBTENCION DEL TOKEN ***/
    $token = null;

    // Definimos el cuerpo del mensaje a enviar
    $data = array(
        'serviceName' => "getToken",
        'param' => array("email" => "email proveido",
                         "password" => "password proveido")
    );
    $postData = json_encode($data);

    // Iniciamos una conexion http, pasamos los parametros de cabecera y el cuerpo del mensaje
    $cURLConnection = curl_init();
    curl_setopt($cURLConnection, CURLOPT_URL, 'http://192.168.1.5/systework/sistema/webservices/');
    curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));
    curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $postData);
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
            // guardamos el token recibido
            $token = $respuesta['result']['token'];
        }else{
            print json_encode(array("status" => $respuesta['status'], "message" => $respuesta['result']));
        }
    }else{
      print json_encode(array("status" => "error", "message" => "sistework_server_failure"));
    } 
    /*** FIN OBTENCION DEL TOKEN ***/
    
?>
