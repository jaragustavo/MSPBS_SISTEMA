<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class ReactivoPedido
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
  
 
      public function enviar($idcodigo,$idusuario, $destinatario,$obs_envio,$codigo_lugar_envio,$imagenEnvio,$codigo_estado_envio)
    {
         $sql=" select cast(to_char(now()-fecha,'DD') as integer) ||' Dias '|| cast(to_char(now()-fecha,'HH24') as integer) ||' Horas'
                from pedido_producto_movimiento
                where codigo in(
                select max(codigo)
                from pedido_producto_movimiento
                where codigo_pedido = $idcodigo)"; 
         
         $tiempoProceso=ejecutarConsulta_retornarID($sql); 
        
         //error_log("######### ".$tiempoProceso);
        $sql="INSERT INTO pedido_producto_movimiento(
                codigo_pedido, fecha, idusuario, 
                imagen_envio,obs_envio,codigo_estado,
                destinatario,tiempo_proceso)
                VALUES ($idcodigo, now(),$idusuario,
                        '$imagenEnvio','$obs_envio',$codigo_estado_envio,
                         $destinatario,'$tiempoProceso');
                select currval( 'pedido_producto_movimiento_codigo_seq' )::BIGINT;";
        
       // error_log('############AGREGARPEDIDO'.$sql);
        
        $codigoPedidoMovimiento=ejecutarConsulta_retornarID($sql);  
          
        $num_elementos=0;
        $sw=true;
      
        while ($num_elementos < count($codigo_lugar_envio))
        {
            $sql_detalle = "INSERT INTO pedido_producto_movimiento_cc(
                            codigo_pedido_producto_movimiento, codigo_lugar_envio)
                            VALUES ($codigoPedidoMovimiento,'$codigo_lugar_envio[$num_elementos]')";
         
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
           
        }
        $sql="UPDATE pedido_producto
        SET codigo_estado= $codigo_estado_envio, destinatario = $destinatario
        WHERE codigo = $idcodigo;";
        ejecutarConsulta($sql);    
 
        return $sw;
    }     
          
          
    //Implementamos un método para insertar registros
    public function insertar($fechaPedido,$idusuario,$obs,$codigo_sucursal,$numero_expediente,$numero_nota,$imagen,$codigo_medicamento,$cantidad,$precio_referencial,$presentacion_entrega,$obsD,$unidad_medida,$codigo_tipo_pedido)
    {
      
      
        $sql="INSERT INTO pedido_producto (fecha_pedido, idusuario,obs, codigo_sucursal,
                                           numero_expediente, 
                                           codigo_tipo_pedido,numero_nota,
                                           imagen,codigo_estado,
                                           codigo_grupo_medicamento,destinatario
                                           )
        VALUES ('$fechaPedido'::timestamp,'$idusuario','$obs',$codigo_sucursal,'$numero_expediente',$codigo_tipo_pedido,
               '$numero_nota','$imagen',1,8,0 );select currval( 'pedido_producto_codigo_seq' )::BIGINT;";
        //return ejecutarConsulta($sql);
  //error_log('############AGREGAR'.$sql);
        
        $idpedidonew=ejecutarConsulta_retornarID($sql);
        
        
     //   error_log('############AGREGAR'.$sql);
        $num_elementos=0;
        $sw=true;
 
        while ($num_elementos < count($codigo_medicamento))
        {
             $precio_referencial[$num_elementos] = !empty($precio_referencial[$num_elementos]) ? str_replace('.','', $precio_referencial[$num_elementos]) : 0;
             $cantidad[$num_elementos] = !empty($cantidad[$num_elementos]) ? str_replace('.','', $cantidad[$num_elementos]) : 0;
       
            $sql_detalle = "INSERT INTO pedido_producto_detalle(codigo_pedido,codigo_medicamento, cantidad,precio_referencial, 
                             presentacion_entrega, obs, unidad_medida)
                             VALUES ('$idpedidonew', '$codigo_medicamento[$num_elementos]',$cantidad[$num_elementos],
                            $precio_referencial[$num_elementos],'$presentacion_entrega[$num_elementos]','$obsD[$num_elementos]', '$unidad_medida[$num_elementos]')";
     // error_log('############AGREGARPEDIDO'.$sql_detalle);
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
           
        }
        
        return $sw;
    }
    public function modificar($idcodigo,$fechaPedido,$idusuario,$obs,$codigo_sucursal,$numero_expediente,$numero_nota,$imagen,$codigo_medicamento,$cantidad,$precio_referencial,$presentacion_entrega,$obsD,$unidad_medida,$codigo_tipo_pedido)
    {
        $sql="UPDATE pedido_producto
        SET fecha_pedido='$fechaPedido', idusuario='$idusuario',obs='$obs',codigo_sucursal =$codigo_sucursal,
            numero_expediente='$numero_expediente',numero_nota='$numero_nota',
            imagen='$imagen',codigo_tipo_pedido =$codigo_tipo_pedido    
        WHERE codigo = $idcodigo;delete from pedido_producto_detalle where codigo_pedido=$idcodigo;";
        ejecutarConsulta($sql);      
//error_log('############AGREGAR'.$sql);
        $num_elementos=0;
        $sw=true;
 
        while ($num_elementos < count($codigo_medicamento))
        {
             $precio_referencial[$num_elementos] = !empty($precio_referencial[$num_elementos]) ? str_replace('.','', $precio_referencial[$num_elementos]) : 0;
             $cantidad[$num_elementos] = !empty($cantidad[$num_elementos]) ? str_replace('.','', $cantidad[$num_elementos]) : 0;
            $sql_detalle = "INSERT INTO pedido_producto_detalle(codigo_pedido,codigo_medicamento, cantidad,precio_referencial, 
                             presentacion_entrega, obs, unidad_medida)
                             VALUES ('$idcodigo', '$codigo_medicamento[$num_elementos]',$cantidad[$num_elementos],
                              $precio_referencial[$num_elementos],'$presentacion_entrega[$num_elementos]','$obsD[$num_elementos]', '$unidad_medida[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
        }
       
 
        return $sw;
    }
 
   public function listarLugarEnvio($idusuario)
    {
        $sql="select * from dependencia_msp where codigo in 
                                             (select codigo_dependencia 
                                              from usuario_dependencia 
                                              where indicador_estado = 'AC'
                                              and   idusuario != $idusuario)";
        
     // error_log('##########33 '.$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
    public function anularPedido($idpedido)
    {
        $sql="UPDATE pedido_producto
        SET codigo_estado=5
        WHERE codigo = $idpedido";
        return ejecutarConsulta($sql);
     
    }
    
    
   
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idcodigo)
    {
        $sql="SELECT codigo, to_char (fecha_pedido, 'DD-MM-YYYY') as fecha_pedido, idusuario, (select nombre from sucursal where codigo =codigo_sucursal) as establecimiento, codigo_sucursal,obs, numero_expediente, 
       codigo_tipo_pedido, numero_nota, imagen, 
                codigo_estado
           FROM pedido_producto
           where  codigo =$idcodigo";
        
      // error_log('##########33 '.$sql);
        return ejecutarConsulta($sql);  
    }
     public function mostrarEnviar($idcodigo)
    {
        $sql="SELECT codigo, to_char (fecha_pedido, 'DD-MM-YYYY') as fecha_pedido, idusuario, (select nombre from sucursal where codigo =codigo_sucursal) as establecimiento, codigo_sucursal,obs, numero_expediente, 
       codigo_tipo_pedido, numero_nota, imagen, 
       codigo_estado
  FROM pedido_producto
  where  codigo =$idcodigo";
        
    //  error_log('##########33 '.$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
    
    public function mostrarDetalle($idcodigo)
    {
        $sql="select *
from(select x.codigo,codigo_contrataciones as codigo_catalogo, producto, coalesce(concentracion, '')||' '||especificaciones_tecnicas as especificacion_tecnica, presentacion from
(select a.codigo, clasificacion_medicamento as producto, concentracion, forma_farmaceutica as especificaciones_tecnicas, presentacion, codigo_estado from descripcion_medicamento a, medicamento b
where a.codigo = b.codigo and codigo_estado = 1 and a.codigo in (select  b.codigo_medicamento from grupo_medicamento a, rel_medicamento_grupo b
		where a.codigo = b.codigo_grupo
		and b.codigo_grupo= 8 --reactivo--
		group by b.codigo_medicamento, a.codigo)) as x
left join
(select * from rel_medicamento_producto_contrataciones a, producto_contrataciones b 
where a.codigo_producto_contrataciones = b.codigo and actual = 't') as y
on(x.codigo = y.codigo_medicamento) order by producto asc
) as reactivo
inner join
(SELECT codigo_pedido, codigo_medicamento, cantidad,precio_referencial,unidad_medida,obs,presentacion_entrega
   FROM pedido_producto_detalle 
   WHERE codigo_pedido = $idcodigo) as pedido
on reactivo.codigo = pedido.codigo_medicamento";
        
     // error_log('##########33 '.$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
    
     public function verMovimiento($idcodigo)
    {
        $sql="select codigo_pedido,to_char(fecha,'DD-MM-YYYY') as fecha_envio,
                (select nombres ||','||apellidos from usuario where cedula_identidad = cast(idusuario as integer)) as remitente,obs_envio,
                 (select nombres ||','||apellidos from usuario where cedula_identidad = cast(destinatario as integer)) as destinatario,
              imagen_envio,coalesce(tiempo_proceso,'---') as tiempo_proceso,(select descripcion from estado_pedido where codigo=codigo_estado) as  estado
              from pedido_producto_movimiento
              where codigo_pedido = $idcodigo
              order by codigo";
        
    ///    error_log('######### '.$sql);
        return ejecutarConsulta($sql);
    }

    public function listarDetalle($idcodigo,$codigo_medicamento)
    {
        $sql="select codigo,numero_expediente,fecha_pedido,
        codigo_medicamento,producto,stock,dmp,cantidad,meses_cantidad,
        codigo_estado,obs from(
        select ocp.codigo,numero_expediente,fecha_pedido,codigo_medicamento,(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion from descripcion_medicamento 
        where codigo= codigo_medicamento) as producto,stock,dmp,cantidad,meses_cantidad,ocpd.codigo_estado,obs from (
        select * from orden_compra_pedido ) as ocp
        inner join
        (select * from orden_compra_pedido_detalle ) as ocpd
        on ocp.codigo = ocpd.codigo_orden_compra_pedido
        and ocp.codigo in ($idcodigo)) as dato
        where codigo_medicamento in ($codigo_medicamento)";
        
    ///    error_log('######### '.$sql);
        return ejecutarConsulta($sql);
    }
 
    //Implementar un método para listar los registros
    public function listar($idusuario)
    {
        $sql="SELECT codigo, to_char (fecha_pedido, 'DD-MM-YYYY') as fecha_pedido, idusuario,
        (select nombre from sucursal where codigo =codigo_sucursal) as establecimiento, obs, numero_expediente, 
       (select nombre from tipo_pedido where codigo = codigo_tipo_pedido) as tipo_pedido, numero_nota, imagen, 
       (select descripcion from estado_pedido where codigo = codigo_estado) as estado_pedido,codigo_estado,destinatario
       FROM pedido_producto
       where  codigo_estado <> 5
       and  codigo_grupo_medicamento =8
       and (idusuario in  (select cast(idusuario as text)
       from usuario_dependencia
       where codigo_dependencia in(select codigo_dependencia from usuario_dependencia 
       where idusuario in ($idusuario))or destinatario = $idusuario))";
     //  error_log('######### '.$sql);
       return ejecutarConsulta($sql);      
    }
     
}
   
?>