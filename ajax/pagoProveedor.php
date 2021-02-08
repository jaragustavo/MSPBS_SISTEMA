<?php 
if (strlen(session_id()) < 1) 
  session_start();
 
require_once "../modelos/PagoProveedor.php";

 $pagoProveedor=new PagoProveedor();

//$idusuario=1; 
switch ($_GET["op"]){ 
   
    case 'listar':
        $rspta=$pagoProveedor->listar();
        //Vamos a declarar un array
        $data= Array();
        while($reg = pg_fetch_array($rspta)){
            $data[]=array(
                "0"=>'<button title="Detalle Proveedores" class="btn btn-primary btn" onclick="mostrarModalLlamadoProveedor('.$reg['codigo_adjudicacion'].')"><i class="fa fa-eye"></i></button>', //<input  id="idcodigo" type="hidden" value='.$reg['licitacion'].'></input><img  onClick="mostrarDatosEspecificos( this )" title="Detalle Orden de Compra" src="../images/MasBlanco.gif" alt="[+]" onMouseOver="this.src=\'../images/MasNaranja.jpg\'" onMouseout="this.src=\'../images/MasBlanco.gif\'" value='.$reg['licitacion'].'/>',
                "1"=>$reg['id_llamado'],
                "2"=>$reg['llamado'],
                 "3"=>$reg['titulo'],
                "4"=>number_format($reg['monto_adjudicado'],0,'','.'),
                "5"=>number_format($reg['monto_recepcion'],0,'','.'),
                "6"=>number_format($reg['monto_factura'],0,'','.'),
                "7"=>number_format($reg['monto_obligado'],0,'','.'),
                "8"=>$reg['observacion']
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
 
    break;
    case 'mostrarModalLlamadoProveedor': 
        
    $codigo_adjudicacion = $_REQUEST["codigo_adjudicacion"];
 
    
    $rspta=$pagoProveedor->mostrarModalLlamadoProveedor($codigo_adjudicacion);
    //Vamos a declarar un array
    $datos= Array();

    while ($reg = pg_fetch_array($rspta)){
    $datos[]=array(
            "0"=>'<input  id="codigo_adjudicacion" type="hidden" value='.$reg['codigo_adjudicacion'].'></input><img  onClick="mostrarDatosEspecificos( this )" title="Detalle Mora Proveedor" src="../images/MasBlanco.gif" alt="[+]" onMouseOver="this.src=\'../images/MasNaranja.jpg\'" onMouseout="this.src=\'../images/MasBlanco.gif\'" value='.$reg['codigo_adjudicacion'].'/>',
            "1"=>'<input  id="codigo_proveedor" type="hidden" value="'.$reg['codigo_proveedor'].'">'.$reg['proveedor'],
            "2"=>number_format($reg['monto_maximo'],0,'','.'),
            "3"=>number_format($reg['monto_minimo'],0,'','.'),
            "4"=>number_format($reg['monto_emitido'],0,'','.'),
            "5"=>number_format($reg['monto_factura'],0,'','.'),
            "6"=>number_format($reg['monto_obligado'],0,'','.')
              
            );
    }
    $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($datos), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($datos), //enviamos el total registros a visualizar
            "aaData"=>$datos);
             echo json_encode($results);
    break;
     case 'listarItem': 
       
    $rspta=$pagoProveedor->listarItem($_POST['codigo_adjudicacion'],$_POST['codigo_proveedor']);
   
     $tabla="";
       $tabla = $tabla."<table border>"
              ."<thead >"
              ."<tr >"
               ."<th class='listaDiferenciada' style='width: auto'>Item</th>"
                ."<th class='listaDiferenciada' style='width: auto'>Codigo</th>"
                  ."<th class='listaDiferenciada' style='width: auto'>Producto</th>"
               ."<th class='listaDiferenciada' style='width: auto'>Monto Max</th>"
                ."<th class='listaDiferenciada' style='width: auto'>Monto Min.</th>" 
               ."<th class='listaDiferenciada' style='width: auto'>Monto Emitido</th>"
                 ."<th class='listaDiferenciada' style='width: auto'>Estado Stock</th>" 
               ."</tr>"
              ."</thead>";
      while($row = pg_fetch_array($rspta)){


            $tabla = $tabla."<tr class='listaDiferenciada' onmouseover='resaltarFila( this )' onmouseout='noResaltarFila( this )'>"
                                   ."<td id='item' align='left'>".$row['item']."</td>"
                                   ."<td id='codigo_medicamento' align='left'>".$row['codigo_medicamento']."</td>"
                                   ."<td id='producto' align='center'>".$row['producto']."</td>"
                                   ."<td id='monto_adjudicado' align='left'>".number_format($row['monto_adjudicado'],0,'','.')."</td>"
                                   ."<td id='monto_minimo' align='center'>".number_format($row['monto_minimo'],0,'','.')."</td>"         
                                   ."<td id='monto_emitido' align='center'>".number_format($row['monto_emitido'],0,'','.')."</td>"  
                                  
                   ."<td id='estado_stock' align='center'>".(($row['disponibilidad_saldo_reservado']>=0 and $row['disponibilidad_saldo_reservado']< 3) ?'<spam class="label label-danger"><i class="fa fa-check"> Critico</i></spam>':
                    (($row['disponibilidad_saldo_reservado']>=3 and $row['disponibilidad_saldo_reservado']<6 )? '<spam class="label label-warning"><i class="fa fa-check"> Atencion</i></spam>': 
                   (($row['disponibilidad_saldo_reservado']>=6 )?'<spam class="label label-success"><i class="fa fa-check"> Optimo</i></spam>': '<span class="label label-default"><i class="fa fa-circle-o"></i></span>')))."</td>" 
                                     ."</tr>";

        }

         $tabla = $tabla."</table>";

    
     $resultado = new stdClass();
                 
    $resultado->contenido = $tabla;

  // error_log("##########".$tabla);
    $json = json_encode($resultado);

    echo($json);
                

    break;
   
    }
?> 
       
 
 

