<?php 
require_once "../Modelo/Porcentaje_Ejecucion.php";

$porcentaje_ejecucion=new Porcentaje_Ejecucion();
 
switch ($_GET["op"]){


case 'listar': 
   
    $rspta=$porcentaje_ejecucion->listar();
    //Vamos a declarar un array
    $datos= Array();

    while ($row = pg_fetch_row($rspta)){
            $datos[]=array(
                    "0"=>$row[0],//codigo
                    "1"=>$row[1],//producto
                    "2"=>$row[2],//llamado
                    "3"=>$row[3],//proveedor
                    "4"=>number_format($row[4], 0, '', '.'),//cantidad mínima
                    "5"=>number_format($row[5], 0, '', '.'),//cantidad máxima 
                    "6"=>number_format($row[6], 0, '', '.'),//cantidad emitida 
                    "7"=>$row[7] //porcentaje
                                  
                    );
    }
    $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($datos), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($datos), //enviamos el total registros a visualizar
            "aaData"=>$datos);
             echo json_encode($results);

    break;
}
?>
