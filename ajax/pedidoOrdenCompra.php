<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/PedidoOrdenCompra.php";
require_once "../modelos/PedidoOrdenCompraMovimiento.php";
 
$pedidoOC=new PedidoOrdenCompra();
$pedidoOrdenCompraMovimiento=new PedidoOrdenCompra();
 
$idcodigo=isset($_POST["idcodigo"])? limpiarCadena($_POST["idcodigo"]):"";
$fechaPedido=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$obs=isset($_POST["obs"])? limpiarCadena($_POST["obs"]):"";
$numeroExpediente=isset($_POST["numero_expediente"])? limpiarCadena($_POST["numero_expediente"]):"";
$idusuario=$_SESSION["idusuario"];
$indicadorPrioridad=isset($_POST["indicadorPrioridad"])? limpiarCadena($_POST["indicadorPrioridad"]):"";
    
//$idusuario=1; 
switch ($_GET["op"]){
    case 'guardaryeditar':
        if (empty($idcodigo)){
            $rspta=$pedidoOC->insertar($fechaPedido,$idusuario,$obs,$numeroExpediente,$_POST["idarticulo"],$_POST["stock"],$_POST["dmp"],$_POST["cantidad"],$_POST["meses"]);
            echo $rspta ? "Pedido registrado" : "No se pudieron registrar todos los datos del pedido";
        }
        else {
        }
    break;
    case 'actualizarPrioridad':
        if (empty($idcodigo) || $indicadorPrioridad == "-1" ){
                       echo('Ingrese todos los datos del formulario');
        }
        else {
             $codigo_medicamento=isset($_POST["idmedicamento"])? limpiarCadena($_POST["idmedicamento"]):"";

              $rspta=$pedidoOC->actualizarPrioridad($idcodigo,$codigo_medicamento,$indicadorPrioridad);
               echo $rspta ? "Indicador Prioridad actualizado" : "No se pudieron registrar los datos";

        }   
       
    break;
   
    case 'anular':
       
        $rspta=$pedidoOC->anular($_POST["idpedido"],$_POST["codigo_medicamento"]);
        echo $rspta ? "Item pedido anulado" : "Item pedido no se puede anular";
    break;
 
    case 'mostrar':
        $codigo_medicamento=isset($_POST["codigo_medicamento"])? limpiarCadena($_POST["codigo_medicamento"]):"";

        $rspta=$pedidoOC->mostrar($idcodigo,$codigo_medicamento);
        $rspta = pg_fetch_row($rspta);
        
        echo json_encode($rspta);
    break;

     case 'mostrarEnviar':
         $idpedido = $_POST["idpedido"];
         $codigo_medicamento = $_POST["codigo_medicamento"];
      //   $codigoMedicamento = explode(',',$codigoMedicamento);
         
         
    //   $idpedido = substr($idpedido, 1 );
    //   $codigo_medicamento = substr($codigo_medicamento, 1 );
    //   $codigo_medicamento = substr($codigo_medicamento, 0, -1 );
         
      //   error_log('##########2344444 '.$codigo_medicamento);
         
      $rspta=$pedidoOC->mostrarEnviar($idpedido,$codigo_medicamento);
      $rspta = pg_fetch_row($rspta);
        
      echo json_encode($rspta);
    break;

    case 'mostrarMovimiento':
        $id=$_GET['id'];
        $codigo_medicamento=$_GET['codigoMedicamento'];
 //error_log('##########33 '.$id);
  //error_log('##########33 '.$codigo_medicamento);
        $rspta=$pedidoOC->mostrarMovimiento($id,$codigo_medicamento);
        
        echo '<thead style="background-color:#A9D0F5">
                                    <th >Opciones</th>
                                    <th >Codigo</th>
                                    <th >FechaEnvio</th>
                                    <th >EnviadoPor</th>
                                    <th>FechaRecibo</th>
                                    <th>UsuarioDestino</th>
                                    <th>Obs</th>
                                    <th>Informe Pedido</th>
                                    <th>Duración</th>
                                    <th>Cod.Med.</th>
                                     <th>Nro.Pedido</th>
                                </thead>';
 
        while($reg = pg_fetch_row($rspta))
        {
           // error_log('############ '.$reg[6]);
          
            
            $sw= ($reg[6]<>'SIN RECIBIR'?'disabled = false':'checked disabled = false');
            echo '<tr class="filas"><td><input name="numero[]" id="numero[]" type="hidden" value="'.$reg[0].'"> </td><td><input type="checkbox"  name="idcodigo[]" id="idcodigo[]" '.$sw.' value="'.$reg[0].'">  '.$reg[0].'</td><td>'.$reg[4].'</td><td>'.$reg[5].'</td><td>'.$reg[6].'</td><td>'.$reg[7].'</td><td>'.$reg[8].'</td><td>'.$reg[9].'</td><td>'.$reg[10].'</td><td>'.$codigo_medicamento.'</td><td>'.$id.'</td></tr>';

        }
    break;
    
    
    case 'anularMovimiento':
        
       //$codigo_movimiento=$_POST["idcodigo"];
        $numero=$_POST["numero"];
        $codigoMovimientoOrigen = $numero[count($numero)-2];
        $codigo_movimiento = $numero[count($numero)-1];
        $codigo_medicamento = $_POST["codigo_medicamento"];
        $numero_pedido = $_POST["numero_pedido"];
     //  error_log('########### '.$numero_pedido);
       $rspta=$pedidoOC->anularMovimiento($codigo_movimiento,$codigoMovimientoOrigen,$codigo_medicamento,$numero_pedido);
       echo $rspta ? "Envio anulado" : "No se puede anular";
     /*   $num_elementos=0;
         while ($num_elementos < count($codigo_movimiento))
        {
        error_log('########### '.$codigo_movimiento[$num_elementos]);
        $num_elementos=$num_elementos + 1;
        }
      //  $rspta=$pedidoOC->anular($idcodigo,$codigo_medicamento);
      * 
      */
        
        
    break;
 
    case 'listar':
        $rspta=$pedidoOC->listar();
        //Vamos a declarar un array
        $data= Array();
        while($reg = pg_fetch_row($rspta)){
            $data[]=array(
                
             
                "0"=>($reg[9]==1)?'<input type="checkbox" name="idcodigo" id="idcodigo"  value="'.$reg[0].'"> '
                                  :'<button class="btn btn-primary btn" onclick="mostrarMovimiento('.$reg[0].','.$reg[3].')"><i class="fa fa-eye"></i></button> <button class="btn btn-imprimir" onclick="imprimir('.$reg[0].')"><i class="fa fa-print fa-1x">',
                    
                "1"=>'<input name="idpedido" id="idpedido" type="hidden" value="'.$reg[0].'"> '.$reg[0],
                "2"=>$reg[1],
                "3"=>$reg[2],
                "4"=>'<input name="codigo_medicamento" id="codigo_medicamento" type="hidden" value="'.$reg[3].'"> '.$reg[3],
                "5"=>$reg[4],
                "6"=>$reg[5],
                "7"=>$reg[6],
                "8"=>$reg[7],
                "9"=>$reg[8],
                "10"=>$reg[13],
               
            //    "11"=>($reg[9]==1?'<span class="label bg-red">Temporal</span>':
              //       ($reg[9]==2?'<span class="label bg-orange">Recibido</span>':
                //   '<span class="label bg-blue">Enviado</span>'))
               "11"=>$reg[12],
               "12"=>($reg[15]==1?"<span class='label bg-red'>$reg[14]</span>":
                     ($reg[15]==2?"<span class='label bg-gray'>$reg[14]</span>":
                     "<span class='label bg-orange'>$reg[14]</span>"))  ,
                
                 "13"=>$reg[16],
                 "14"=>$reg[17]   
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
    case 'listarDetalle':
        //Recibimos el idingreso
        $idpedido=$_GET['id'];
        $codigo_medicamento=$_GET['codigoMedicamento'];
       
       // $idpedido = substr($idpedido, 1 );
       // $codigo_medicamento = substr($codigo_medicamento, 1 );
       
        $rspta = $pedidoOC->listarDetalle($idpedido,$codigo_medicamento);
      
        echo '<thead style="background-color:#A9D0F5">
                                  
                                    <th >Nro.Pedido</th>
                                    <th >Codigo</th>
                                    <th >Producto</th>
                                    <th >Stock</th>
                                    <th>DMP</th>
                                    <th>Meses</th>
                                    <th>Cantidad</th>
                            </thead>';
 
        while($reg = pg_fetch_row($rspta))
        {
                
                    echo '<tr class="filas"><td><input name="idpedido[]" id="idpedido[]" type="hidden" value="'.$reg[0].'"> '.$reg[0].'</td><td><input name="codigo_medicamento[]" id="codigo_medicamento[]" type="hidden" value="'.$reg[3].'"> '.$reg[3].'</td><td>'.$reg[4].'</td><td>'.$reg[5].'</td><td>'.$reg[6].'</td><td>'.$reg[8].'</td><td>'.$reg[7].'</td></tr>';
                  
        }
        
    break;
}
?>

