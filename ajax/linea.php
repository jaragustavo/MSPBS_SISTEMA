<?php 
require_once "../modelos/Linea.php";
 
$linea=new Linea();

$idlinea=isset($_POST["idlinea"])? $_POST["idlinea"]:"";
$desLinea=isset($_POST["desLinea"])? $_POST["desLinea"]:"";
$codigoLinea=isset($_POST["codigoLinea"])? $_POST["codigoLinea"]:"";

switch ($_GET["op"]){
    case 'guardaryeditar':
        if (empty($idlinea)){
            $rspta=$linea->insertar($desLinea,$codigoLinea);
            echo $rspta ? "Linea registrada" : "Linea no se pudo registrar";
        }
        else {
                     
            $rspta=$linea->editar($idlinea,$desLinea,$codigoLinea);
            echo $rspta ? "Linea actualizada" : "Linea no se pudo actualizar";
        }
    break;
 
    case 'desactivar':
        $rspta=$linea->desactivar($idlinea);
        echo $rspta ? "Linea Desactivada" : "Linea no se puede desactivar";
        break;
    break;
 
    case 'activar':
        $rspta=$linea->activar($idlinea);
        echo $rspta ? "Linea activada" : "Linea no se puede activar";
        break;
    break;
 
    case 'mostrar':
        $rspta=$linea->mostrar($idlinea);
        $rspta = pg_fetch_row($rspta);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;
    break;
 
    case 'listar':
        $rspta=$linea->listar();
        //Vamos a declarar un array
        $data= Array();
        while($reg = pg_fetch_row($rspta)){
            $data[]=array(
                "0"=>($reg[2]=='AC')?'<button class="btn btn-warning" onclick="mostrar('.$reg[0].')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-danger" onclick="desactivar('.$reg[0].')"><i class="fa fa-close"></i></button>':
                    '<button class="btn btn-warning" onclick="mostrar('.$reg[0].')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-primary" onclick="activar('.$reg[0].')"><i class="fa fa-check"></i></button>',
                "1"=>$reg[1],
                "2"=>$reg[7],
                "3"=>($reg[2]=='AC')?'<span class="label bg-green">Activado</span>':
                '<span class="label bg-red">Desactivado</span>'
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