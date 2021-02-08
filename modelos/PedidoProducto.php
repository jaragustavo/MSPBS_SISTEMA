<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class PedidoProducto
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
   
 
    //Implementamos un método para insertar registros
    public function insertar($fechaPedido,$idusuario,$obs,$codigo_sucursal,$numero_expediente,$codigo_medicamento,$cantidad)
    {
        $sql="INSERT INTO pedido_producto (fecha_pedido, idusuario,obs, codigo_sucursal,
                                           numero_expediente, 
                                           codigo_tipo_pedido, indicador_estado)
        VALUES ('$fechaPedido'::timestamp,'$idusuario','$obs',$codigo_sucursal,'$numero_expediente',1,'PENDIENTE');select currval( 'pedido_producto_codigo_seq' )::BIGINT;";
        //return ejecutarConsulta($sql);
        
        $idpedidonew=ejecutarConsulta_retornarID($sql);
//error_log('############AGREGAR'.$sql);
        $num_elementos=0;
        $sw=true;
 
        while ($num_elementos < count($codigo_medicamento))
        {
            $sql_detalle = "INSERT INTO pedido_producto_detalle(codigo_pedido,codigo_medicamento, cantidad)"
                    . " VALUES ('$idpedidonew', '$codigo_medicamento[$num_elementos]','$cantidad[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
            error_log('############AGREGARPEDIDO'.$sql_detalle);
        }
 
        return $sw;
    }
 
     public function modificar($idcodigo,$fechaPedido,$idusuario,$obs,$numero_expediente,$codigo_medicamento,$cantidad)
    {
        $sql="UPDATE pedido_producto
   SET fecha_pedido='$fechaPedido', idusuario='$idusuario',obs='$obs'
       
 WHERE codigo = $idcodigo;delete from pedido_producto_detalle where codigo_pedido=$idcodigo;";
    ejecutarConsulta($sql);      
//error_log('############AGREGAR'.$sql);
        $num_elementos=0;
        $sw=true;
 
        while ($num_elementos < count($codigo_medicamento))
        {
            $sql_detalle = "INSERT INTO pedido_producto_detalle(codigo_pedido,codigo_medicamento, cantidad)"
                    . " VALUES ('$idcodigo', '$codigo_medicamento[$num_elementos]','$cantidad[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
        }
 
        return $sw;
    }
     
    //Implementamos un método para anular categorías
    public function anular($idpedido,$codigo_medicamento)
    {
        $sql="update orden_compra_pedido_detalle
              set codigo_estado =5
              where codigo in (
                  select codigo
                  from (
                  select codigo,codigo_medicamento,codigo_estado
                  from orden_compra_pedido_detalle
                  where codigo_orden_compra_pedido in ( $idpedido))
                  as dato
                  where codigo_medicamento in ($codigo_medicamento))";
        return ejecutarConsulta($sql);
    }
    
 
 
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idcodigo,$codigo_medicamento)
    {
        $sql="select ocp.codigo,numero_expediente,fecha_pedido,codigo_medicamento,(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion from descripcion_medicamento 
              where codigo= codigo_medicamento) as producto,stock,dmp,cantidad,meses_cantidad,ocpd.codigo_estado,obs from (
              select * from orden_compra_pedido ) as ocp
              inner join
              (select * from orden_compra_pedido_detalle ) as ocpd
              on ocp.codigo = ocpd.codigo_orden_compra_pedido
              and ocp.codigo='$idcodigo' and codigo_medicamento='$codigo_medicamento'";
        
      // error_log('##########33 '.$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
    
     public function mostrarEnviar($idcodigo)
    {
       
        $sql="select    a.codigo as numero_pedido,a.fecha_pedido,
           b.codigo_medicamento,
          (select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion 
            from descripcion_medicamento 
             where codigo= b.codigo_medicamento) as producto,
             b.cantidad,
             c.nombre as nombre_sucursal,
             a.indicador_estado,a.obs
from pedido_producto a,pedido_producto_detalle b, sucursal c
where a.codigo = b.codigo_pedido
and   a.codigo_sucursal = c.codigo
and   a.codigo =$idcodigo";
        
    //error_log('##########33 '.$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
       public function editarPedido($idcodigo)
    {
       
        $sql="select    a.codigo as numero_pedido,a.fecha_pedido,
           b.codigo_medicamento,
          (select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion 
            from descripcion_medicamento 
             where codigo= b.codigo_medicamento) as producto,
             b.cantidad,
             c.nombre as nombre_sucursal,
             a.indicador_estado,a.obs
from pedido_producto a,pedido_producto_detalle b, sucursal c
where a.codigo = b.codigo_pedido
and   a.codigo_sucursal = c.codigo
and   a.codigo =$idcodigo";
        
    //error_log('##########33 '.$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
 public function mostrarMovimiento($idcodigo,$codigo_medicamento)
    {
    //error_log('########## '.$codigo_medicamento);
        $sql="SELECT codigo, codigo_pedido_orden_compra, codigo_medicamento,
	(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion 
	from descripcion_medicamento 
         where codigo= codigo_medicamento) as producto, 
         to_char(fecha_envio,'DD/MM/YYYY HH12:MI') AS fecha_envio,
         ( select apellidos ||' '||nombres from usuario where cedula_identidad = idusuario_envio) as enviadoPor, 
          coalesce(to_char(fecha_recibo,'DD/MM/YYYY HH12:MI'),'SIN RECIBIR') as fecha_recibo,
          ( select apellidos ||' '||nombres from usuario where cedula_identidad = idusuario_destino) as recibidoPor, obs, 
          (select nombre from estado_pedido_orden_compra where codigo = codigo_estado_informe) as estado_informe,
          CAST(to_char(least(now(),(GREATEST(tiempo_proceso,fecha_recibo)))- fecha_envio,'DD') as integer) || ' Días ' || CAST(to_char(least(now(),(GREATEST(tiempo_proceso,fecha_recibo)))- fecha_envio,'HH24') as integer) || ' Horas '
       
  FROM pedido_orden_compra_movimiento
  WHERE codigo_pedido_orden_compra=$idcodigo and codigo_medicamento=$codigo_medicamento order by codigo";
        
 //  error_log('##########33 '.$sql);
        return ejecutarConsulta($sql);
    }
     public function enviarPedido($idpedido,$fechaPedido)
    {
        $sql="UPDATE pedido_producto SET indicador_estado='ENVIADO',fecha_pedido = '$fechaPedido' WHERE codigo='$idpedido[0]'";
       //error_log('##########33 '.$sql);
        
        return ejecutarConsulta($sql);
    }
    public function listarDetalle($idcodigo)
    {
        $sql="select    a.codigo as numero_pedido,a.fecha_pedido,
           b.codigo_medicamento,
          (select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion 
            from descripcion_medicamento 
             where codigo= b.codigo_medicamento) as producto,
             b.cantidad,
             c.nombre as nombre_sucursal,
             a.indicador_estado
from pedido_producto a,pedido_producto_detalle b, sucursal c
where a.codigo = b.codigo_pedido
and   a.codigo_sucursal = c.codigo
and   a.codigo =$idcodigo";
        
     //  error_log('######### '.$sql);
        return ejecutarConsulta($sql);
    }
     public function editarPedidoDetalle($idcodigo)
    {
        $sql="select    a.codigo as numero_pedido,a.fecha_pedido,
           b.codigo_medicamento,
          (select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion 
            from descripcion_medicamento 
             where codigo= b.codigo_medicamento) as producto,
             b.cantidad,
             c.nombre as nombre_sucursal,
             a.indicador_estado
from pedido_producto a,pedido_producto_detalle b, sucursal c
where a.codigo = b.codigo_pedido
and   a.codigo_sucursal = c.codigo
and   a.codigo =$idcodigo";
        
    //  error_log('######### '.$sql);
        return ejecutarConsulta($sql);
    }
    //Implementar un método para listar los registros
    public function listar($idusuario)
    {
        $sql="select    a.codigo as numero_pedido,to_char (a.fecha_pedido, 'DD-MM-YYYY') as fecha_pedido,
              c.nombre as nombre_sucursal,
             a.indicador_estado,a.idusuario
from pedido_producto a, sucursal c
where a.codigo_sucursal = c.codigo and a.idusuario ='$idusuario' and a.indicador_estado <> 'PENDIENTE'";
        return ejecutarConsulta($sql);      
    }
      public function listarProducto()
    {
        $sql="select codigo_medicamento, producto, sum(cantidad) as stock from
(select codigo_sucursal, (select nombre from sucursal where codigo = codigo_sucursal) as establecimiento, codigo_medicamento, (select clasificacion_medicamento||' '||coalesce(concentracion, '')||' '||forma_farmaceutica||' '||presentacion from descripcion_medicamento where codigo= codigo_medicamento) as producto, 
codigo_adjudicacion, numero_lote, fecha_vencimiento, cantidad, precio_unitario from stock_medicamento
where cantidad > 0 and codigo_sucursal in (884,1701,1790,1801) and fecha_vencimiento > now() and fecha_vencimiento < (select (date_trunc('month', now()) + interval '4 month'))) as d
group by codigo_medicamento, producto
order by producto asc";
      //  error_log('######### '.$sql);
        return ejecutarConsulta($sql);      
    }
     
}
   
?>