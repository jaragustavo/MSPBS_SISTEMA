<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/PedidoProducto.php";

 
$pedidoProducto=new PedidoProducto();

 
$idcodigo=isset($_POST["idpedidoproducto"])? limpiarCadena($_POST["idpedidoproducto"]):"";
$fechaPedido=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$obs=isset($_POST["obs"])? limpiarCadena($_POST["obs"]):"";
$numeroExpediente=isset($_POST["numero_expediente"])? limpiarCadena($_POST["numero_expediente"]):"";
$idusuario=$_SESSION["idusuario"];

    
//$idusuario=1; 
switch ($_GET["op"]){
    case 'guardaryeditar':
       
        if (empty($idcodigo)){ 
           //error_log('######### '.$idcodigo);
            $rspta=$pedidoProducto->insertar($fechaPedido,$idusuario,$obs,$codigo_sucursal,$numeroExpediente,$_POST["idarticulo"],$_POST["cantidad"]);
            echo $rspta ? "Pedido registrado" : "No se pudieron registrar todos los datos del pedido";
        }
        else {
           
            $rspta=$pedidoProducto->modificar($idcodigo,$fechaPedido,$idusuario,$obs,$numeroExpediente,$_POST["idarticulo"],$_POST["cantidad"]);
            echo $rspta ? "Pedido modicado" : "No se pudiero modificar todos los datos del pedido";
       
            
        }
    break;
      
    case 'anular':
       
        $rspta=$pedidoProducto->anular($_POST["idpedido"],$_POST["codigo_medicamento"]);
        echo $rspta ? "Item pedido anulado" : "Item pedido no se puede anular";
    break;
 
    case 'mostrar':
        $codigo_medicamento=isset($_POST["codigo_medicamento"])? limpiarCadena($_POST["codigo_medicamento"]):"";

        $rspta=$pedidoProducto->mostrar($idcodigo,$codigo_medicamento);
        $rspta = pg_fetch_row($rspta);
        
        echo json_encode($rspta);
    break;

     case 'mostrarEnviar':
         $idpedido = $_POST["idpedido"];
         $rspta=$pedidoProducto->mostrarEnviar($idpedido);
         $rspta = pg_fetch_array($rspta);
        
         echo json_encode($rspta);
    break;
  case 'mostrarPedido':
    $cont = 3000;
         $idpedido = $_POST["idpedido"];
         $rspta=$pedidoProducto->mostrarEnviar($idpedido);
        // $rspta = pg_fetch_array($rspta);
         
         echo '<thead style="background-color:#A9D0F5">
                                  
                                    <th >Opcion</th>
                                    <th >Codigo</th>
                                    <th >Producto</th>
                                     <th>Cantidad</th>
                            </thead>';
 
        while($reg = pg_fetch_array($rspta))
        {
                   $cont = $cont +1;

                    echo '<tr class="filas" id="fila'.$cont.'"><td style="text-align: center;"><button type="button" class="btn btn-eye" onclick="stockDetalle('.$reg['codigo_medicamento'].')"><i class="fa fa-trash"></i></button></td><td><input type="text" readonly="readonly"  name="idarticulo[]" value="'.$reg['codigo_medicamento'].'"></td><td id="articulo">'.$reg['producto'].'</td><td><input type="number" name="cantidad[]" id="cantidad[]"   value="'.$reg['cantidad'].'"></td></tr>';
              ///    error_log("#####".$reg['codigo_medicamento']);
        }
        
        break;
 
    case 'editarPedido':
         $idpedido = $_POST["idpedido"];
           
      $rspta=$pedidoProducto->editarPedido($idpedido);
      $rspta = pg_fetch_array($rspta);
        
      echo json_encode($rspta);
    break;
    
    case 'listar':
        $rspta=$pedidoProducto->listar($idusuario);
        //Vamos a declarar un array
        $data= Array();
        while($reg = pg_fetch_array($rspta)){
            $data[]=array(
                
             
                "0"=>($reg['indicador_estado']=='ENVIADO')?'<button class="btn btn-primary btn" onclick="mostrarEnviar('.$reg['numero_pedido'].')"><i class="fa fa-paper-plane"></i></button> <button class="btn btn-success" onclick="editarPedido('.$reg['numero_pedido'].')"><i class="fa fa-pencil fa-1x">'
                                  :'<button class="btn btn-info btn" onclick="mostrarPedido('.$reg['numero_pedido'].')"><i class="fa fa-eye"></i></button> ',
                    
                "1"=>'<input name="idpedido" id="idpedido" type="hidden" value="'.$reg['numero_pedido'].'"> '.$reg['numero_pedido'],
                "2"=>$reg['fecha_pedido'],
              
                "3"=>$reg['nombre_sucursal'],
                "4"=>$reg['indicador_estado']
                   
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
 
    break;
 
    case 'listarProducto':
        
    
 
        $rspta=$pedidoProducto->listarProducto();
        //Vamos a declarar un array
        $data= Array();
 
        while($reg = pg_fetch_array($rspta)){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg['codigo_medicamento'].',\''.$reg['producto'].'\')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg['codigo_medicamento'],
                "2"=>'<td scope="col"><div style="width: 500px;text-align: left;">'.$reg['producto'].'</div></th>',
                "3"=>$reg['stock']
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;
    case 'listarDetalle':
        //Recibimos el idingreso
        $idpedido=$_GET['id'];
          
        $rspta = $pedidoProducto->listarDetalle($idpedido);
      
        echo '<thead style="background-color:#A9D0F5">
                                  
                                    <th >Opcion</th>
                                    <th >Codigo</th>
                                    <th >Producto</th>
                                     <th>Cantidad</th>
                            </thead>';
 
        while($reg = pg_fetch_array($rspta))
        {
                
                    echo '<tr class="filas"><td><input name="idpedido[]" id="idpedido[]" type="hidden" value="'.$reg['numero_pedido'].'"> '.$reg['numero_pedido'].'</td><td><input name="codigo_medicamento[]" id="codigo_medicamento[]" type="hidden" value="'.$reg['codigo_medicamento'].'"> '.$reg['codigo_medicamento'].'</td><td>'.$reg['producto'].'</td><td>'.$reg['cantidad'].'</td></tr>';
                  
        }
        
    break;
    case 'editarPedidoDetalle':
        //Recibimos el idingreso
        $cont = 3000;
        $idpedido=$_GET['id'];
       // $codigo_medicamento=$_GET['codigoMedicamento'];
       
       // $idpedido = substr($idpedido, 1 );
       // $codigo_medicamento = substr($codigo_medicamento, 1 );
       
        $rspta = $pedidoProducto->editarPedidoDetalle($idpedido);
      
        echo '<thead style="background-color:#A9D0F5">
                                  
                                    <th >Opcion</th>
                                    <th >Codigo</th>
                                    <th >Producto</th>
                                     <th>Cantidad</th>
                            </thead>';
 
        while($reg = pg_fetch_array($rspta))
        {
                   $cont = $cont +1;

                    echo '<tr class="filas" id="fila'.$cont.'"><td style="text-align: center;"><button type="button" class="btn btn-danger" onclick="eliminarDetalle('.$cont.')"><i class="fa fa-trash"></i></button></td><td><input type="text" readonly="readonly"  name="idarticulo[]" value="'.$reg['codigo_medicamento'].'"></td><td id="articulo">'.$reg['producto'].'</td><td><input type="number" name="cantidad[]" id="cantidad[]"   value="'.$reg['cantidad'].'"></td></tr>';
              ///    error_log("#####".$reg['codigo_medicamento']);
        }
        
        break;
}
?>

