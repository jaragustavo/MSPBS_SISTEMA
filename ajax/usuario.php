<?php
session_start(); 
require_once "../modelos/Usuario.php";
require_once "../modelos/Escritorio.php";
 
$usuario=new Usuario();
 
$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$cedula_identidad=isset($_POST["cedula_identidad"])? limpiarCadena($_POST["cedula_identidad"]):"";
$login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
 
switch ($_GET["op"]){
    case 'guardaryeditar':
 
      /*  if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
        {
            $imagen=$_POST["imagenactual"];
        }
        else
        {
            $ext = explode(".", $_FILES["imagen"]["name"]);
            if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
            {
                $imagen = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
            }
        }
       * 
       */
        //Hash SHA256 en la contraseña
      //  $clavehash=hash("SHA256",$clave);
 
        if (empty($idusuario)){
       //77    $rspta=$usuario->insertar($nombre,$cedula_identidad,$login,$clavehash,$_POST['permiso']);
            // $rspta=$usuario->insertar($nombre,$cedula_identidad,$login,$clavehash);
           
           // echo $rspta ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario";
        }
        else {
            $rspta=$usuario->editar($idusuario,$_POST['permiso']);
            // $rspta=$usuario->editar($idusuario,$nombre,$cedula_identidad,$login,$clavehash);
           
            echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
        }
    break;
 
    case 'desactivar':
        $rspta=$usuario->desactivar($idusuario);
        echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
    break;
 
    case 'activar':
        $rspta=$usuario->activar($idusuario);
        echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
    break;
    case 'selectUsuario':
       $rspta = $usuario->selectUsuario();
       echo '<option value="-1">  </option>';
        while($reg = pg_fetch_row($rspta))
                {
                echo '<option value=' . $reg[0] . '>' . $reg[1] . '</option>';
                }
        
        
        
    break;
 
    case 'mostrar':
        $rspta=$usuario->mostrar($idusuario);
        //Codificar el resultado utilizando json
         $rspta = pg_fetch_row($rspta);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        
    break;
 
    case 'listar':
       $rspta=$usuario->listar();
        //Vamos a declarar un array
        $data= Array();
        while($reg = pg_fetch_row($rspta)){
            $data[]=array(
                "0"=>//($reg[5]=='AC')?'<button class="btn btn-warning" onclick="mostrar('.$reg[0].')"><i class="fa fa-pencil"></i></button>'.
                   // ' <button class="btn btn-danger" onclick="desactivar('.$reg[0].')"><i class="fa fa-close"></i></button>':
                  '  <button class="btn btn-warning" onclick="mostrar('.$reg[0].')"><i class="fa fa-pencil"></i></button>',
                //    ' <button class="btn btn-primary" onclick="activar('.$reg[0].')"><i class="fa fa-check"></i></button>',
                "1"=>$reg[1].' '.$reg[2],
                
                "2"=>$reg[0],
                
                "3"=>$reg[0]
       //         "4"=>($reg[5]=='AC')?'<span class="label bg-green">Activado</span>':
         //       '<span class="label bg-red">Desactivado</span>'
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
 
    break;
 
    case 'permisos':
        //Obtenemos todos los permisos de la tabla permisos
        require_once "../modelos/Permiso.php";
        $permiso = new Permiso();
        $rspta = $permiso->listar();
 
        //Obtener los permisos asignados al usuario
        $id=$_GET['id'];
   
        if ($id > 0) {
        $marcados = $usuario->listarmarcados($id);
        //Declaramos el array para almacenar todos los permisos marcados
        $valores=array();
 
        //Almacenar los permisos asignados al usuario en el array
       
        while ($per = pg_fetch_row($marcados))
            {
             
                array_push($valores, $per[2]);
            }

        //Mostramos la lista de permisos en la vista y si están o no marcados
            while($reg = pg_fetch_row($rspta))
       
                {
                 
                    $sw=in_array($reg[0],$valores)?'checked':'';
                    echo '<li> <input type="checkbox" '.$sw.'  name="permiso[]" value="'.$reg[0].'">'.'   - '.$reg[1].'</li>';
                  

                }
        }
    break;
 
    case 'verificar':
      
        $logina=$_POST['logina'];
        $clavea=$_POST['clavea'];
 
        //   error_log('#########clave '.$clavea);
        //Hash SHA256 en la contraseña
      //  $clavehash=hash("SHA256",$clavea);
        
              
        $rspta=$usuario->verificar($logina, $clavea);
        
        $fetch = pg_fetch_row($rspta);
       
 
        if (isset($fetch))
        {
           
            
            //Declaramos las variables de sesión
            $_SESSION['idusuario']=$fetch[0];
            $_SESSION['nombre']=$fetch[1];
          //  $_SESSION['imagen']=$fetch[0];
            $_SESSION['login']=$fetch[0];
            
            $escritorio = new Escritorio();
            $escritorio = $escritorio->obtenerDatos();
   //Declaramos el array para almacenar todos los permisos marcados
            $_SESSION['codigo_medicamento']=array();
            $_SESSION['medicamento']=array();
            $_SESSION['porcentaje_ejecucion']=array();
             $_SESSION['cantidad_distribuida']=array();
            //Almacenamos los permisos marcados en el array
            while ($dato = pg_fetch_row($escritorio))
            {
                array_push($_SESSION['codigo_medicamento'], $dato[0]);
                array_push($_SESSION['medicamento'], $dato[1]);
                array_push($_SESSION['porcentaje_ejecucion'],$dato[2]);
                array_push($_SESSION['cantidad_distribuida'],$dato[3]);
           // error_log('##### '.$dato[0]);
                
            }
           /// error_log('##### '.$_SESSION['codigo_medicamento'][0]);
            
          
            
       //   error_log('##### '.$_SESSION['login']);
           //Obtenemos los permisos del usuario
            $marcados = $usuario->listarmarcados($fetch[0]);
 
            //Declaramos el array para almacenar todos los permisos marcados
            $valores=array();
 
            //Almacenamos los permisos marcados en el array
            while ($per = pg_fetch_row($marcados))
            {
                array_push($valores, $per[2]);
               // error_log('##### '.$per[2]);
            }

            //Determinamos los accesos del usuario
            
            in_array(178,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
           
       /// Modulo de pedidos orden compra
           in_array(177,$valores)?$_SESSION['pedido']=1:$_SESSION['pedido']=0;
          
            in_array(179,$valores)?$_SESSION['pedidoOrdenCompraGenerar']=1:$_SESSION['pedidoOrdenCompraGenerar']=0;
            in_array(180,$valores)?$_SESSION['pedidoRecibir']=1:$_SESSION['pedidoRecibir']=0;
            in_array(181,$valores)?$_SESSION['pedidoOrdenCompraAsignarPrioridad']=1:$_SESSION['pedidoOrdenCompraAsignarPrioridad']=0;
            in_array(192,$valores)?$_SESSION['pedidoOrdenCompraReciboProveedor']=1:$_SESSION['pedidoOrdenCompraReciboProveedor']=0;
     
           in_array(188,$valores)?$_SESSION['pedidoEnviar']=1:$_SESSION['pedidoEnviar']=0;
           in_array(189,$valores)?$_SESSION['pedidoConsultarAnular']=1:$_SESSION['pedidoConsultarAnular']=0;
           in_array(190,$valores)?$_SESSION['pedidoOrdenCompraConsulta']=1:$_SESSION['pedidoOrdenCompraConsulta']=0;
           
      /// Modulo de Emisión orden compra
            in_array(183,$valores)?$_SESSION['emision']=1:$_SESSION['emision']=0;
            in_array(184,$valores)?$_SESSION['controlEmisionOrdenCompra']=1:$_SESSION['controlEmisionOrdenCompra']=0;
            in_array(185,$valores)?$_SESSION['emisionCvpOrdenCompra']=1:$_SESSION['emisionCvpOrdenCompra']=0;
            in_array(202,$valores)?$_SESSION['ordenCompraAnular']=1:$_SESSION['ordenCompraAnular']=0;

 
          
       /////////////#####///////77 
            in_array(182,$valores)?$_SESSION['acceso']=1:$_SESSION['acceso']=0;
            
       // covid compra
            in_array(195,$valores)?$_SESSION['covidCompra']=1:$_SESSION['covidCompra']=0;
         // covid compra    
             in_array(196,$valores)?$_SESSION['covidDonacion']=1:$_SESSION['covidDonacion']=0;
             
           // Reactivo
             in_array(197,$valores)?$_SESSION['reactivo']=1:$_SESSION['reactivo']=0;
             in_array(198,$valores)?$_SESSION['reactivoPedido']=1:$_SESSION['reactivoPedido']=0;
             in_array(199,$valores)?$_SESSION['reactivoConsulta']=1:$_SESSION['reactivoConsulta']=0;
             in_array(200,$valores)?$_SESSION['reactivoLlamado']=1:$_SESSION['reactivoLlamado']=0;
             in_array(201,$valores)?$_SESSION['reactivoContrato']=1:$_SESSION['reactivoContrato']=0;
           
          
               /// Modulo de Adjudicación y contrato
            in_array(186,$valores)?$_SESSION['adjudicacion']=1:$_SESSION['adjudicacion']=0;
            in_array(187,$valores)?$_SESSION['adjudicacionEjecucion']=1:$_SESSION['adjudicacionEjecucion']=0;
            in_array(191,$valores)?$_SESSION['adjudicacionProveedorAtraso']=1:$_SESSION['adjudicacionProveedorAtraso']=0;
            in_array(194,$valores)?$_SESSION['adjudicacionProveedorAtrasoAgregar']=1:$_SESSION['adjudicacionProveedorAtrasoAgregar']=0;
        //   in_array(193,$valores)?$_SESSION['adjudicacionProducto']=1:$_SESSION['adjudicacionProducto']=0;   

// Contrato
             in_array(209,$valores)?$_SESSION['contrato']=1:$_SESSION['contrato']=0;
             in_array(210,$valores)?$_SESSION['adjudicacionContrato']=1:$_SESSION['adjudicacionContrato']=0;
             in_array(213,$valores)?$_SESSION['contratoProducto']=1:$_SESSION['contratoProducto']=0;
             in_array(211,$valores)?$_SESSION['contratoPoliza']=1:$_SESSION['contratoPoliza']=0;
             in_array(212,$valores)?$_SESSION['contratoConsultaPagoProveedor']=1:$_SESSION['contratoConsultaPagoProveedor']=0;
              in_array(214,$valores)?$_SESSION['contratoAdenda']=1:$_SESSION['contratoAdenda']=0;
        }
        echo json_encode($fetch);
    break;
 
    case 'salir':
        //Limpiamos las variables de sesión   
        session_unset();
        //Destruìmos la sesión
        session_destroy();
        //Redireccionamos al login
        header("Location: ../index.php");
 
    break;
}
?>