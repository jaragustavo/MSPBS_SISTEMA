<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/PedidoOrdenCompra.php";
require_once "../modelos/PedidoOrdenCompraRecibir.php";
 
$pedidoOC=new PedidoOrdenCompra();
$pedidoOrdenCompraRecibir=new PedidoOrdenCompraRecibir();

$idusuarioDestino=isset($_POST["idusuarioDestino"])? limpiarCadena($_POST["idusuarioDestino"]):"";
$estadoCierre=isset($_POST["estadoCierre"])? limpiarCadena($_POST["estadoCierre"]):"";

$idpedido=isset($_POST["idpedido"])? limpiarCadena($_POST["idpedido"]):"";
//$idcodigo=isset($_POST["idcodigo"])? limpiarCadena($_POST["idcodigo"]):"";
$fechaPedido=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$fechaRecibo=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$codigoMedicamento=isset($_POST["codigo_medicamento"])? limpiarCadena($_POST["codigo_medicamento"]):"";
//error_log('################# '.$idpedido);
$obs=isset($_POST["obs"])? limpiarCadena($_POST["obs"]):"";
$numeroExpediente=isset($_POST["numero_expediente"])? limpiarCadena($_POST["numero_expediente"]):"";
$idusuario=$_SESSION["idusuario"];
//$idusuario=1; 
switch ($_GET["op"]){
   
    case 'recibir':
        
          //error_log('############ idpedido'.$idpedido);
         $idcodigo =implode(",", $_POST["idcodigo"]);
         $rspta=$pedidoOrdenCompraRecibir->recibir($idcodigo,$fechaRecibo);
         echo $rspta ? "Recepción registrada" : "No se pudieron registrar todos los datos";
       
       
    break;
   
    case 'anular':
        $rspta=$ingreso->anular($idingreso);
        echo $rspta ? "Ingreso anulado" : "Ingreso no se puede anular";
    break;
 
    case 'mostrarRecibir':
      
        $rspta=$pedidoOrdenCompraRecibir->mostrarRecibir($_POST["idcodigo"]);
        $rspta = pg_fetch_row($rspta);
        
        echo json_encode($rspta);
    break;

    case 'mostrarEnviar':
      
        $rspta=$pedidoOrdenCompraRecibir->mostrarEnviar($idcodigo);
        $rspta = pg_fetch_row($rspta);
        
        echo json_encode($rspta);
    break;
 
    case 'listarDetalle':
        //Recibimos el idingreso
        $id=$_GET['id'];
       
        $rspta = $pedidoOrdenCompraRecibir->listarDetalle($id);
        $total=0;
        echo '<thead style="background-color:#A9D0F5">
                                    <th >CodMov</th>
                                    <th >Simese</th>
                                    <th >Nro.Pedido</th>
                                    <th >Codigo</th>
                                    <th >Producto</th>
                                    <th>Cantidad</th>
                                    <th>Usuario Envio</th>
                                    <th>Observación</th>
                                </thead>';
 
        while($reg = pg_fetch_row($rspta))
                {
                
                    echo '<tr class="filas"><td><input name="idcodigo[]" id="idcodigo[]" type="hidden" value="'.$reg[0].'"> '.$reg[0].'</td><td>'.$reg[1].'</td><td>'.$reg[9].'</td><td>'.$reg[4].'</td><td>'.$reg[5].'</td><td>'.$reg[6].'</td><td>'.$reg[3].'</td><td>'.$reg[7].'</td></tr>';
                  
                }
        
    break;
 
    case 'listar':
        
        $rspta=$pedidoOrdenCompraRecibir->listar($idusuario);
        //Vamos a declarar un array
        $data= Array();
        while($reg = pg_fetch_row($rspta)){
            $data[]=array(
               "0"=>($reg[9]==1?'<input name="idcodigo" id="idcodigo" type="hidden" value="'.$reg[0].'">
               <input type="checkbox" name="chcodigo" id="chcodigo"  value="'.$reg[0].'"> ':
                      
                     ($reg[9]==2?'<button class="btn btn-warning btn" onclick="mostrarEnviar('.$reg[0].')"><i class="fa fa-paper-plane"></i></button>  <button class="btn btn-primary btn" onclick="mostrarMovimiento('.$reg[1].','.$reg[5].')"><i class="fa fa-eye"></i></button>': 
                     ($reg[9]==3?'<button class="btn btn-primary btn" onclick="mostrarMovimiento('.$reg[1].','.$reg[5].')"><i class="fa fa-eye"></i></button>':  
                     ' '))),
                  
                "1"=>'<input name="idpedido" id="idpedido" type="hidden" value="'.$reg[1].'"> '.$reg[1],
                "2"=>$reg[2],
                "3"=>$reg[3],
                "4"=>$reg[4],
                "5"=>'<input name="codigo_medicamento" id="codigo_medicamento" type="hidden" value="'.$reg[5].'"> '.$reg[5],
                "6"=>$reg[6],
                "7"=>$reg[7],
                "8"=>$reg[8],
              "9"=>$reg[11],

              "10"=>($reg[13]==1?"<span class='label bg-red'>$reg[12]</span>":"<span class='label bg-yellow'>$reg[12]</span>")
         //    "10"=>($reg[9]==2 && $reg[14]==0 ?'<button class="btn btn-danger btn" onclick="anularMovimiento('.$reg[1].','.$reg[5].')"><i class="fa fa-close"></i></button>': 
         //              ' ')  
                //     ($reg[9]==2?'<span class="label bg-orange">Recibido</span>':
                  // '<span class="label bg-blue">Enviado</span>'))
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
 
    break;
     case 'listarReciboProveedor':
        
        $rspta=$pedidoOrdenCompraRecibir->listarReciboProveedor();
        //Vamos a declarar un array
        $data= Array();
        while($reg = pg_fetch_row($rspta)){
            $data[]=array(
               "0"=>($reg[9]==1?'<input name="idcodigo" id="idcodigo" type="hidden" value="'.$reg[0].'">
               <input type="checkbox" name="chcodigo" id="chcodigo"  value="'.$reg[0].'"> ':
                      
                     ($reg[9]==2?'<button class="btn btn-warning btn" onclick="mostrarEnviar('.$reg[0].')"><i class="fa fa-paper-plane"></i></button>  <button class="btn btn-primary btn" onclick="mostrarMovimiento('.$reg[1].','.$reg[5].')"><i class="fa fa-eye"></i></button>': 
                     ($reg[9]==3?'<button class="btn btn-primary btn" onclick="mostrarMovimiento('.$reg[1].','.$reg[5].')"><i class="fa fa-eye"></i></button>':  
                     ' '))),
                  
                "1"=>'<input name="idpedido" id="idpedido" type="hidden" value="'.$reg[1].'"> '.$reg[1],
                "2"=>$reg[2],
                "3"=>$reg[3],
                "4"=>$reg[4],
                "5"=>'<input name="codigo_medicamento" id="codigo_medicamento" type="hidden" value="'.$reg[5].'"> '.$reg[5],
                "6"=>$reg[6],
                "7"=>$reg[7],
                "8"=>$reg[8],
              "9"=>$reg[11],
               
              "10"=>($reg[13]==1?"<span class='label bg-red'>$reg[12]</span>":"<span class='label bg-yellow'>$reg[12]</span>")
         //    "10"=>($reg[9]==2 && $reg[14]==0 ?'<button class="btn btn-danger btn" onclick="anularMovimiento('.$reg[1].','.$reg[5].')"><i class="fa fa-close"></i></button>': 
         //              ' ')  
                //     ($reg[9]==2?'<span class="label bg-orange">Recibido</span>':
                  // '<span class="label bg-blue">Enviado</span>'))
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
    
    case 'selectEstadoCierre':
       
 
        $rspta = $pedidoOrdenCompraRecibir->selectEstadoCierre();
        echo '<option value="-1">  </option>';
        while($reg = pg_fetch_row($rspta))
                {
                echo '<option value=' . $reg[0] . '>' . $reg[1] . '</option>';
                }
        
        
        
    break;
}
?>

