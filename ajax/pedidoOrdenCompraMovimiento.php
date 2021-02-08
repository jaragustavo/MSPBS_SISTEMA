<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/PedidoOrdenCompra.php";
require_once "../modelos/PedidoOrdenCompraMovimiento.php";
 
$pedidoOC=new PedidoOrdenCompra();
$pedidoOrdenCompraMovimiento=new PedidoOrdenCompraMovimiento();
 
$idcodigo=isset($_POST["idcodigo"])? limpiarCadena($_POST["idcodigo"]):"";
$codigo_medicamento=isset($_POST["codigo_medicamento"])? limpiarCadena($_POST["codigo_medicamento"]):"";
$fechaPedido=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$obs=isset($_POST["obs"])? limpiarCadena($_POST["obs"]):"";
$numeroExpediente=isset($_POST["numero_expediente"])? limpiarCadena($_POST["numero_expediente"]):"";
$idusuario=$_SESSION["idusuario"];
//$idusuario=1; 
$idusuarioDestino=isset($_POST["idusuarioDestino"])? limpiarCadena($_POST["idusuarioDestino"]):"";
switch ($_GET["op"]){
    case 'guardaryeditar':
     // error_log('%%%%%%%%%%%%%%%'.$idusuarioDestino);
        if (empty($idcodigo)){
       
            $rspta=$pedidoOrdenCompraMovimiento->insertar($codigo_pedido_orden_compra,$_POST["idarticulo"],$fechaPedido,$idusuario,'',$idusuarioDestino,$obs);
            echo $rspta ? "Pedido enviado" : "No se pudieron registrar todos los datos del envio";
        }
        else {
        }
    break;
    case 'enviar':
         
               
            if ($idusuarioDestino == "-1" ){
                 echo('Ingrese los datos del destinatario');
            }else
            {
              //  error_log('%%%%%%%%%%%%%%% '); 
                $rspta=$pedidoOrdenCompraMovimiento->insertar($_POST["idpedido"],$_POST["codigo_medicamento"],$idusuario,$fechaPedido,$idusuarioDestino,$fechaPedido,$obs);
                echo $rspta ? "Pedido enviado" : "No se pudieron registrar todos los datos del envio";
            }
        
       
        
    break;
    case 'anular':
        $rspta=$ingreso->anular($idingreso);
        echo $rspta ? "Ingreso anulado" : "Ingreso no se puede anular";
    break;
 
    case 'mostrar':
        $codigo_medicamento=isset($_POST["codigo_medicamento"])? limpiarCadena($_POST["codigo_medicamento"]):"";

        $rspta=$pedidoOC->mostrar($idcodigo,$codigo_medicamento);
        $rspta = pg_fetch_row($rspta);
        
        echo json_encode($rspta);
    break;
 
    case 'listarDetalle':
        //Recibimos el idingreso
        $id=$_GET['id'];
        $codigo_medicamento =$_GET['codigoMedicamento'];
        $rspta = $pedidoOC->listarDetalle($id,$codigo_medicamento);
        $total=0;
        echo '<thead style="background-color:#A9D0F5">
                                    <th >Opciones</th>
                                    <th >Codigo</th>
                                    <th >Producto</th>
                                    <th >Stock</th>
                                    <th>DMP</th>
                                    <th>Meses</th>
                                    <th>Cantidad</th>
                                </thead>';
 
        while($reg = pg_fetch_row($rspta))
                {
                
                    echo '<tr class="filas"><td></td><td>'.$reg[3].'</td><td>'.$reg[4].'</td><td>'.$reg[5].'</td><td>'.$reg[6].'</td><td>'.$reg[8].'</td><td>'.$reg[7].'</td></tr>';
                  
                }
        
    break;
 
    case 'listar':
        $rspta=$pedidoOC->listar();
        //Vamos a declarar un array
        $data= Array();
        while($reg = pg_fetch_row($rspta)){
            $data[]=array(
                "0"=>($reg[9]==1)?'<button class="btn btn-warning" onclick="mostrar('.$reg[0].','.$reg[3].')"><i class="fa fa-eye"></i></button> '.
                    ' <button class="btn btn-danger" onclick="anular('.$reg[0].','.$reg[3].')"> <i class="fa fa-close"></i></button> ':
                    ' <button class="btn btn-warning" onclick="mostrar('.$reg[0].','.$reg[3].')"> <i class="fa fa-eye"></i></button> ',
                "1"=>$reg[0],
                "2"=>$reg[1],
                "3"=>$reg[2],
                "4"=>$reg[3],
                "5"=>$reg[4],
                "6"=>$reg[5],
                "7"=>$reg[6],
                "8"=>$reg[7],
                "9"=>$reg[8],
                "10"=>($reg[9]==1)?'<span class="label bg-yellow">Temporal</span>':
                '<span class="label bg-green">Enviado</span>'
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
 
    break;
 
    case 'selectProveedor':
        require_once "../modelos/Persona.php";
        $persona = new Persona();
 
        $rspta = $persona->listarP();
 
        while ($reg = $rspta->fetch_object())
                {
                echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
                }
    break;
 
    case 'listarArticulos':
        require_once "../modelos/Articulo.php";
        $articulo=new Articulo();
 
        $rspta=$articulo->listarActivos();
        //Vamos a declarar un array
        $data= Array();
 
        while($reg = pg_fetch_row($rspta)){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg[0].',\''.$reg[1].'\','.$reg[4].','.$reg[5].')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg[0],
                "2"=>$reg[1],
                "3"=>$reg[4],
                "4"=>$reg[5],
                "5"=>$reg[6]
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

