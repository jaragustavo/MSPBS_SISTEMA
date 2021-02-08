<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/AdjudicacionEjecucion.php";

 
$adjudicacionEjecucion=new AdjudicacionEjecucion();
 
//$idusuario=1; 
switch ($_GET["op"]){ 
    
 
    case 'listar':
        $rspta=$adjudicacionEjecucion->listar();
        //Vamos a declarar un array
        $data= Array();
        while($reg = pg_fetch_array($rspta)){
            $data[]=array(
                "0"=>'', //<input  id="idcodigo" type="hidden" value='.$reg['licitacion'].'></input><img  onClick="mostrarDatosEspecificos( this )" title="Detalle Orden de Compra" src="../images/MasBlanco.gif" alt="[+]" onMouseOver="this.src=\'../images/MasNaranja.jpg\'" onMouseout="this.src=\'../images/MasBlanco.gif\'" value='.$reg['licitacion'].'/>',
                "1"=>$reg['id_llamado'],
                "2"=>$reg['llamado'],
                "3"=>$reg['proveedor'],
                "4"=>$reg['codigo_medicamento'],
                "5"=>$reg['producto'],
                "6"=>$reg['item'],
               "7"=>number_format($reg['cantidad_adjudicada'],0,'','.'),
                "8"=>number_format($reg['cantidad_emitida'],0,'','.'),
                
                "9"=>$reg['cant_recepcionada']>$reg['cantidad_adjudicada']?'<span class="label bg-red">'.number_format($reg['cant_recepcionada'],0,'','.').'</span>':number_format($reg['cant_recepcionada'],0,'','.'),
                "10"=>number_format($reg['cant_distribuida'],0,'','.'),
                
                
                "11"=>number_format($reg['monto_maximo'],0,'','.'),
                "12"=>$reg['monto_emitido']>$reg['monto_maximo']?'<span class="label bg-red">'.number_format($reg['monto_emitido'],0,'','.').'</span>':number_format($reg['monto_emitido'],0,'','.'),
                "13"=> number_format($reg['saldo'],0,'','.'),
               
              //  "9"=>$reg['cantidad_emitida']>$reg['cantidad_maxima']?'<span class="label bg-red">'.number_format($reg['cantidad_emitida'],0,'','.').'</span>':number_format($reg['cantidad_emitida'],0,'','.'),
             
                
                
             
                "14"=>$reg['porcentaje'],
                "15"=>($reg['porcentaje']>50?'<span class="label bg-red">SI</span>':'<span class="label bg-green">NO</span>'),
               
                "16"=>(($reg['disponibilidad_saldo_reservado'] < 0 )? '<spam class="label label-info"><i class="fa fa-check"> Nuevo</i></spam>': 
                      (($reg['disponibilidad_saldo_reservado']>=0 and $reg['disponibilidad_saldo_reservado']< 3) ?'<spam class="label label-danger"><i class="fa fa-check"> Critico</i></spam>':
                      (($reg['disponibilidad_saldo_reservado']>=3 and $reg['disponibilidad_saldo_reservado']<6 )? '<spam class="label label-warning"><i class="fa fa-check"> Atencion</i></spam>': 
                      
                       (($reg['disponibilidad_saldo_reservado']>=6 )?'<spam class="label label-success"><i class="fa fa-check"> Optimo</i></spam>': '<span class="label label-default"><i class="fa fa-circle-o"></i></span>')))),
              
                
                "17"=>$reg['estado_item'],
                 "18"=>number_format($reg['cantidad_solicitada'],0,'','.'),
                  "19"=>$reg['porcentaje_solicitado'],
                 "20"=>$reg['porcentaje_ampliacion_emitido'],
                "21"=>$reg['observacion']
                
            //    "11"=>($reg[9]==1?'<span class="label bg-red">Temporal</span>':
              //       ($reg[9]==2?'<span class="label bg-orange">Recibido</span>':
                //   '<span class="label bg-blue">Enviado</span>'))
            //   "11"=>$reg[12],
              // "12"=>($reg[15]==1?"<span class='label bg-red'>$reg[14]</span>":
                //     ($reg[15]==2?"<span class='label bg-gray'>$reg[14]</span>":
                  //   "<span class='label bg-orange'>$reg[14]</span>"))  ,
                
                 //"13"=>$reg[16],
                // "14"=>$reg[17]   
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
 
    break;
    
    
    
    
      case 'listarJson':
        $rspta=$adjudicacionEjecucion->listarJson();
        //Vamos a declarar un array
        $data= Array();
        while($reg = pg_fetch_array($rspta)){
            $data[]=array(
                "codigo"=>$reg['codigo'], 
                "nombre"=>$reg['nombre'],
                "correo"=>$reg['correo'],
                "telefono"=>$reg['telefono'],
                "direccion"=>$reg['direccion'],
                "ruc"=>$reg['ruc']
             );
        } 
       $results = array(
           "TotalRegistros"=>count($data), //enviamos el total registros al datatable
           "Proveedores"=>$data);
      //  $results =Array();
        //$results[] = array("proveedor"=>$data);
        echo json_encode($results);
 
    break;
 
    case 'listarEstadoOcSW':
         
        $url = "http://sistework.mspbs.gov.py/sistema/webservices/estadoOrdenCompra.php?oc=5007";
        $data = json_decode(file_get_contents($url),true);
        //var_dump($data);
        //echo $data->estado; 
        $listaItems = $data["Expedientes"];
        
       for ($i = 0; $i<count($listaItems); $i++){
          echo ($listaItems[$i]["estado"]); 
       } 
        
    break;
    }
?> 
       
 
 

