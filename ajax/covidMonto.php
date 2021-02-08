<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/covidMonto.php";

 
$covidMonto=new CovidMonto();

$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$monto=isset($_POST["monto"])? limpiarCadena($_POST["monto"]):"";
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
$moneda=isset($_POST["moneda"])? limpiarCadena($_POST["moneda"]):"";
$cotizacion=isset($_POST["cotizacion"])? limpiarCadena($_POST["cotizacion"]):"";




 
switch ($_GET["op"]){ 
    case 'guardaryeditar':
        
        if (empty($codigo)){
            
            $rspta=$covidMonto->insertar($fecha,$descripcion,$monto,$moneda,$cotizacion);
            echo $rspta ? "Item Registrado" : "No se pudieron registrar todos los datos del Item";
        }
        else {
            
          $rspta=$covidMonto->editar($codigo,$fecha,$descripcion,$monto,$moneda,$cotizacion);
            
            echo $rspta ? "Item modificado" : "No se pudo modificar el Item";
        }
    break;

    case 'mostrar':
            $codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
            $rspta=$covidMonto->mostrar($codigo);
            $rspta = pg_fetch_array($rspta);
            echo json_encode($rspta);
        break;

   
    case 'listar':
        $rspta=$covidMonto->listar();
        //Vamos a declarar un array
        $data= Array();
        while($reg = pg_fetch_array($rspta)){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg['codigo'].')"><i class="fa fa-pencil"></i></button>',
                "1"=>$reg['descripcion'],
                "2"=>$reg['monto'],
                "3"=>$reg['moneda'],   
                "4"=>$reg['cotizacion'],
                "5"=>$reg['fecha']               
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;


    

    

}
?>

