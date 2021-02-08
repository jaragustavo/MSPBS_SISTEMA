<?php

    $codigo = $_GET['codigo'];
 
    header( "Content-Type: application/pdf" );
    header( "Content-Disposition: inline; filename= pedidoOc-".date( "Ymd_H_i_s" ).".pdf" );	
    
   
    header("Cache-Control: no-cache");
    header("Pragma: no-cache");

   
    echo( "<head><title>PedidoOrdenCompra</title></head>");
    $comando = 'java -jar "ReporteOrdenCompra.jar" ReportGenerator.class '.$codigo;
    error_log('ORDENCOMPRA:'.$comando);
    passthru( $comando,$salida);    
