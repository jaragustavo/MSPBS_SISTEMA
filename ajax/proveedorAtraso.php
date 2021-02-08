<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/ProveedorAtraso.php";

 
$proveedorAtraso=new ProveedorAtraso();

$idusuario=$_SESSION["idusuario"];
//$idusuario=1; 
switch ($_GET["op"]){
    case 'guardaryeditar':
        $codigo_orden_compra=isset($_POST["codigoOC"])? limpiarCadena($_POST["codigoOC"]):"";
         $numero_orden_compra=isset($_POST["numero_orden_compra"])? limpiarCadena($_POST["numero_orden_compra"]):"";
         $codigo_medicamentoOC=isset($_POST["codigo_medicamentoOC"])? limpiarCadena($_POST["codigo_medicamentoOC"]):"";
         $codigo_medicamento_recibido=isset($_POST["codigoMedicamentoRecibido"])? limpiarCadena($_POST["codigoMedicamentoRecibido"]):"";
         $fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
         $obs=isset($_POST["obs"])? limpiarCadena($_POST["obs"]):"";
         $codigo_estado_proveedor_atraso=isset($_POST["codigoEstadoProveedorAtraso"])? limpiarCadena($_POST["codigoEstadoProveedorAtraso"]):"";
    //7   error_log('###### numero_orden_compra '.$numero_orden_compra);
    ///    error_log('###### $codigo_orden_compra '.$codigo_orden_compra);
         $rspta=$proveedorAtraso->insertar($numero_orden_compra,$codigo_medicamentoOC,$codigo_medicamento_recibido,$fecha_hora,$obs,$idusuario,$codigo_estado_proveedor_atraso,$codigo_orden_compra);
            echo $rspta ? "Proveedor Atraso estado registrado" : "No se pudieron registrar todos los datos";
    break;
  
  
    case 'editar':
        $idcodigoOC=isset($_POST["idcodigo"])? limpiarCadena($_POST["idcodigo"]):"";

        $codigo_medicamento=isset($_POST["codigo_medicamento"])? limpiarCadena($_POST["codigo_medicamento"]):"";

        $rspta=$proveedorAtraso->editar($idcodigoOC,$codigo_medicamento);
        $rspta = pg_fetch_row($rspta);
        
        echo json_encode($rspta);
    break;

 

  
    
    
    case 'anular':
        
       
        $idcodigo=$_POST["idcodigo"];
        $rspta=$proveedorAtraso->anular($idcodigo);
       echo $rspta ? "Registro anulado" : "No se puede anular";
          
    break;
 
    case 'listar':
        $rspta=$proveedorAtraso->listar();
        //Vamos a declarar un array
        $data= Array();
        while($row = pg_fetch_array($rspta)){
            $data[]=array(
                "0"=>'<input type="checkbox" name="numeroOC" id="numeroOC"  value="'.$row[0].'"> ' ,
                "1"=>$row['lugar_entrega'],
                "2"=>'<input type="hidden" name="codigo_orden_compra" id="codigo_orden_compra"  value="'.$row['codigo_orden_compra'].'"> '.$row['numero_orden_compra'],
                     "3"=>$row['fecha_oc'],
                     "4"=>$row['tipo_compra'],
                     "5"=>$row['proveedor'],
                     "6"=>$row['item'],
                     "7"=>'<input type="hidden" name="codigo_medicamento" id="codigo_medicamento"  value="'.$row['codigo_medicamento'].'"> '.$row['codigo_medicamento'],
                     "8"=>'<input type="hidden" name="producto" id="producto"  value="'.$row['producto'].'"> '.$row['producto'],
                     "9"=> number_format($row['cantidad_solicitada'], 0, ",", "."),
                     "10"=> number_format($row['cantidad_recepcionada'], 0, ",", "."),
                     "11"=>$row['ultima_fecha_recepcion'],
                     "12"=> number_format($row['saldo'], 0, ",", "."),
                     "13"=> number_format($row['cantidad_actual'], 0, ",", "."),
                    "14"=>($row['recepcion_proveedor']=='')?'<span class="label bg-red">NO RECIBIO</span>':$row['recepcion_proveedor'],
                    "15"=>$row['plazo_entrega'],
                   
                    
                    "16"=>($row['dias_atraso']<0 ) ?'<span class="label bg-red">'.($row['dias_atraso']*-1).'</span>':
                     '<span class="label bg-yellow">0</span>',
                    "17"=>(($row['saldo']==0 and $row['codigo_estado_proveedor_atraso']==0)?'<span class="label bg-green">COMPLETADA</span>':
                          ($row['codigo_estado_proveedor_atraso']>0 ?'<span class="label bg-green">'.$row['descripcion_estado_proveedor_atraso'].'</span>':
                                   '<span class="label bg-red">PENDIENTE</span>')),
                      "18"=>$row['referencia'] 
//                    "19"=>'<button title="Detalle Recepción" class="btn btn-primary btn" onclick="mostrarModalOCrecepcion('.$row['numero_orden_compra'].',\''.$row['codigo_medicamento'].'\')"><i class="fa fa-eye"></i></button>'
    
                    // "20"=>'<input type="hidden" name="codigo_orden_compra" id="codigo_orden_compra"  value="'.$row[16].'"> '.$row[16]
               
                   //  "9"=>'<input id="oc" type="hidden" value='.$row[0].'></input>'
                   
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
 
  
  
     case 'selectEstadoProveedorAtraso':
       
 
        $rspta = $proveedorAtraso->selectEstadoProveedorAtraso();
       echo '<option value="-1">  </option>';
        while($reg = pg_fetch_row($rspta))
                {
                echo '<option value=' . $reg[0] . '>' . $reg[1] . '</option>';
                }
        
        
        
    break;
    case 'selectMedicamento':
       
 
        $rspta = $proveedorAtraso->selectMedicamento();
       echo '<option value="-1">  </option>';
        while($reg = pg_fetch_row($rspta))
                {
                echo '<option value=' . $reg[0] . '>' . $reg[1] . '</option>';
                }
        
        
        
    break;
    case 'mostrarDetalle':
     error_log ('################ '.$_POST["codigoOC"]);
        $rspta=$proveedorAtraso->mostrarDetalle($_POST["numeroOC"],$_POST["codigoOC"]);
      //  $rspta = pg_fetch_row($rspta);
       
       
        echo '<thead style="background-color:#A9D0F5">
                                    <th >Opciones</th>
                                    <th >Nro.OC</th>
                                    <th >Cod.Pro.OC</th>
                                    <th >Producto OC</th>
                                    <th >Cod.Pro.Rec.</th>
                                    <th >Producto Recibido</th>
                                    <th>Observación</th>
                                    <th>Estado</th>
                                   
                                </thead>';
 
        while($reg = pg_fetch_row($rspta))
        {
          
            //     error_log ('################ '.$reg[1]);
             echo '<tr class="filas">'
            . '<td><input type="radio" name="idcodigo" id="idcodigo"  value="'.$reg[0].'"></td>'
            . '<td>'.$reg[1].'</td>'
            . '<td>'.$reg[8].'</td>'
            . '<td>'.$reg[2].'</td>'
            . '<td>'.$reg[9].'</td>'
            . '<td>'.$reg[3].'</td>'
            . '<td>'.$reg[5].'</td>'
            . '<td>'.$reg[7].'</td>'
            . '</tr>';
                  
         }
        
    break;
        
        
        
    break;
}
?>

