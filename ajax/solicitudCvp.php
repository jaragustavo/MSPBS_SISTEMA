<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/SolicitudCvp.php";
 
$solicitudCvp=new SolicitudCvp();
 
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
 
switch ($_GET["op"]){
    case 'guardaryeditar':
       if (empty($_POST["codigo_solicitud_cvp"])){
            $rspta=$solicitudCvp->insertar($_SESSION['login'],$_SESSION['nombre'],$fecha_hora,$_POST["codigo_orden_compra"],$_POST["codigo_medicamento"],$_POST["plurianual"],$_POST["obs"]);
            echo $rspta ? "Registrado" : "No se pudieron registrar todos los datos";
            }
        else {
          
            $rspta=$solicitudCvp->modificar($_POST["codigo_solicitud_cvp"],$_SESSION['login'],$_SESSION['nombre'],$fecha_hora,$_POST["codigo_orden_compra"],$_POST["codigo_medicamento"],$_POST["plurianual"],$_POST["obs"]);
            echo $rspta ? "Actualizado" : "No se pudo actualizar los datos";
        }        
        
   
    break;
 
    case 'anular':
        $rspta=$solicitudCvp->anular($_POST["idcodigo"]);
        echo $rspta ? "Solicitudo CDP anulada" : "Solicitud CDP no se pudo anular";
    break;
 
  
 
   case 'listarDetalle':
        
        $id=$_GET['id'];
       
        $rspta = $solicitudCvp->listarDetalle($id);
       
        echo '<thead style="background-color:#A9D0F5">
                                   <th>Opciones</th>
                                    <th>Nro.OC</th>
                                    <th>Fecha OC.</th>
                                     <th>Proveedor</th>
                                    <th>Codigo Medicamento</th>
                                    <th>Descripción Producto</th>
                                    <th>Monto OC</th>
                                    <th>Plurianual</th>
                                    <th>Observación</th>
                                </thead>';
 
        while($reg = pg_fetch_row($rspta))
                {
                   
                    echo '<tr class="filas" id="fila'.$reg[0].'"><td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('.$reg[0].')">X</button></td><td><input type="hidden" name="codigo_orden_compra[]" id="codigo_orden_compra[]" value="'.$reg[9].'">'.$reg[1].'</td><td><name="fecha_orden_compra" id="fecha_orden_compra">'.$reg[2].'</td><td><name="proveedor" id="proveedor">'.$reg[3].'</td><td><input type="hidden" name="codigo_medicamento[]" id="codigo_medicamento[]" value="'.$reg[4].'">'.$reg[4].'</td><td><name="producto" >'.$reg[5].'</td><td><name="monto">'.$reg[6].'</td><td><input type="text" name="plurianual[]" id="plurianual[]" value="'.$reg[8].'"></td><td><input type="text" name="obs[]" id="obs[]" value="'.$reg[7].'"></td></tr>';
                  
                }
        
    break;
    case 'mostrarEditar':

        $rspta=$solicitudCvp->mostrarEditar($_POST["idcodigo"]);
        $rspta = pg_fetch_row($rspta);
        
        echo json_encode($rspta);
    break;
 
    case 'listar':
        $rspta=$solicitudCvp->listar();
        //Vamos a declarar un array
        $data= Array();
 
        while($reg = pg_fetch_row($rspta)){
            $data[]=array(
                "0"=>'<button class="btn btn-imprimir" onclick="imprimir('.$reg[0].')"><i class="fa fa-print fa-1x"></i></button>  <button class="btn btn-success active" onclick="editarPlanillaEmision('.$reg[0].')"><i class="fa fa-pencil"></i></button>',
                 "1"=>$reg[0], 
                "2"=>$reg[18],
                "3"=>$reg[2],
                "4"=>number_format($reg[14],0,'','.'),
                "5"=>$reg[13],
                 "6"=>$reg[21],
                "7"=>$reg[6],
                "8"=>$reg[7],
                "9"=>$reg[8],
                "10"=>number_format($reg[9],0,'','.'),
                "11"=>$reg[20],
                "12"=>$reg[12],
                 "13"=>$reg[10]
          /*     
            //    "11"=>($reg[9]==1?'<span class="label bg-red">Temporal</span>':
              //       ($reg[9]==2?'<span class="label bg-orange">Recibido</span>':
                //   '<span class="label bg-blue">Enviado</span>'))
           //   
             //  "12"=>($reg[15]==1?"<span class='label bg-red'>$reg[14]</span>":
               //      ($reg[15]==2?"<span class='label bg-gray'>$reg[14]</span>":
                     "<span class='label bg-orange'>$reg[14]</span>"))  ,
                
                 "13"=>$reg[16],
                 "14"=>$reg[17]  
           * */
         
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
 
    break;
 
   
    case 'listarOC':
        require_once "../modelos/SolicitudCvp.php";
      // error_log('###########3');
 
        $rspta=$solicitudCvp->listarOC();
        //Vamos a declarar un array
        $data= Array();
 
        while($reg = pg_fetch_row($rspta)){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg[0].','.$reg[1].',\''.$reg[2].'\',\''.$reg[3].'\','.$reg[4].',\''.$reg[5].'\','.$reg[6].')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg[1],
                "2"=>$reg[2],
                "3"=>$reg[3],
                "4"=>$reg[4],
                "5"=>$reg[5],
                "6"=>number_format($reg[6],0,'','.')
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

