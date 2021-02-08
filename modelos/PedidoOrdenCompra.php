<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class PedidoOrdenCompra
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
    public function selectIndicadorPrioridad()
    {
        $sql="SELECT * FROM indicador_prioridad  
                          order by codigo;";
        
        return ejecutarConsultaSimpleFila($sql);
    }
    
     public function actualizarPrioridad($idcodigo,$codigo_medicamento,$indicadorPrioridad)
    {
      // error_log('########### '.$codigo_medicamento);
        
        $sql="UPDATE orden_compra_pedido_detalle 
                 set indicador_prioridad = $indicadorPrioridad "
                . "where codigo_orden_compra_pedido=$idcodigo "
               .  "and  codigo_medicamento = $codigo_medicamento ;";
               
   
 //error_log('########### '.$sql);
        
       return ejecutarConsulta($sql);
       
    }
 
    //Implementamos un método para insertar registros
    public function insertar($fechaPedido,$idusuario,$obs,$numero_expediente,$codigo_medicamento,$stock,$dmp,$cantidad,$meses_cantidad)
    {
        $sql="INSERT INTO orden_compra_pedido (fecha_pedido,codigo_estado,idusuario,obs,numero_expediente)
        VALUES ('$fechaPedido'::timestamp,1,'$idusuario','$obs','$numero_expediente');select currval( 'orden_compra_pedido_codigo_seq' )::BIGINT;";
        //return ejecutarConsulta($sql);
        $idpedidoOCnew=ejecutarConsulta_retornarID($sql);
//error_log('############AGREGAR'.$sql);
        $num_elementos=0;
        $sw=true;
 
        while ($num_elementos < count($codigo_medicamento))
        {
            $sql_detalle = "INSERT INTO orden_compra_pedido_detalle(codigo_orden_compra_pedido,codigo_medicamento, stock,dmp,cantidad,meses_cantidad,codigo_estado,indicador_prioridad)"
                    . " VALUES ('$idpedidoOCnew', '$codigo_medicamento[$num_elementos]','$stock[$num_elementos]','$dmp[$num_elementos]','$cantidad[$num_elementos]','$meses_cantidad[$num_elementos]',1,3)";
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
    public function anularMovimiento($codigo_movimiento,$codigoMovimientoOrigen,$codigo_medicamento,$numero_pedido)
    {
        $sql="SELECT count(*) from pedido_orden_compra_movimiento"
         . " where codigo_medicamento=$codigo_medicamento and codigo_pedido_orden_compra =$numero_pedido";
     
        $cont= ejecutarConsulta_retornarID($sql);
                   
        if ($cont==1){
         //   error_log('########111 '.$cont);
             $sql="UPDATE orden_compra_pedido_detalle 
                    SET  codigo_estado = 1
                     WHERE codigo_orden_compra_pedido=$numero_pedido "
                     . " and codigo_medicamento = $codigo_medicamento;"
                     . "delete from pedido_orden_compra_movimiento "
                  . " where codigo_medicamento=$codigo_medicamento and codigo_pedido_orden_compra =$numero_pedido";
         } else {
          //   error_log('########2=> '.$cont);
             $sql="UPDATE pedido_orden_compra_movimiento "
                . "SET codigo_estado = 2, tiempo_proceso = null "
                . "where codigo=$codigoMovimientoOrigen;"
                . "UPDATE orden_compra_pedido_detalle a
                    SET  estado_cierre = b.codigo_estado_informe
                    FROM pedido_orden_compra_movimiento b
                    WHERE b.codigo = $codigoMovimientoOrigen
                    AND   a.codigo_medicamento = b.codigo_medicamento
                    AND   a.codigo_orden_compra_pedido = b.codigo_pedido_orden_compra;"
                . "delete from pedido_orden_compra_movimiento "
                . "WHERE codigo=$codigo_movimiento and fecha_recibo isnull"; 
      
      
        };
        
      //  error_log('######## '.$sql);
        
        
        return ejecutarConsulta($sql);
        
        
        //  $sql="delete from pedido_orden_compra_movimiento WHERE codigo=$codigo_movimiento and fecha_recibo isnull";
      //error_log('##33 '.ejecutarConsulta($sql));
     //   
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
    
     public function mostrarEnviar($idcodigo,$codigo_medicamento)
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
    public function listar()
    {
        $sql="select codigo,numero_expediente,to_char(fecha_pedido,'DD/MM/YYYY') as fecha_pedido,dato.codigo_medicamento,producto,stock,dmp,cantidad,meses_cantidad,codigo_estado,
obs,estado_cierre,estadocierrepedido,cast(coalesce(to_char((least(now(),fecha_orden_compra) - fecha_pedido),'DD'),'0') as integer)as diasproceso,
nombre_prioridad,indicador_prioridad,numero_orden_compra,to_char(fecha_orden_compra,'DD/MM/YYYY')
from 
(

select codigo,numero_expediente,fecha_pedido,pedido.codigo_medicamento,producto,stock,dmp,cantidad,meses_cantidad,codigo_estado,
obs,estado_cierre,estadocierrepedido, diasProceso,(select nombre from indicador_prioridad where codigo = indicador_prioridad) as nombre_prioridad,indicador_prioridad from 
(select ocp.codigo,numero_expediente,fecha_pedido,codigo_medicamento,
            (select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion 
            from descripcion_medicamento 
where codigo= codigo_medicamento) as producto,stock,dmp,cantidad,meses_cantidad,ocpd.codigo_estado,obs, ocpd.estado_cierre,

(select nombre 
from estado_pedido_orden_compra where codigo = ocpd.estado_cierre ) as estadoCierrePedido,
indicador_prioridad
 
 from (
select * from orden_compra_pedido ) as ocp
inner join
(select * from orden_compra_pedido_detalle where codigo_estado <>5) as ocpd
on ocp.codigo = ocpd.codigo_orden_compra_pedido) AS pedido
left join
(
select max(codigo),codigo_pedido_orden_compra,codigo_medicamento ,sum(cast(coalesce(to_char((fecha_recibo - fecha_envio),'DD'),'0') as integer)) as DiasProceso 
from pedido_orden_compra_movimiento
group by codigo_pedido_orden_compra,codigo_medicamento --, DiasProceso
) as movimiento
on pedido.codigo = movimiento.codigo_pedido_orden_compra
and pedido.codigo_medicamento = movimiento.codigo_medicamento
group by codigo,numero_expediente,
fecha_pedido,pedido.codigo_medicamento,producto,
stock,dmp,cantidad,meses_cantidad,codigo_estado,obs,estado_cierre,
estadocierrepedido,diasProceso,indicador_prioridad
--order by codigo

) as dato
left join
(
	select numero_orden_compra,codigo_medicamento,codigo_pedido_orden_compra,fecha_orden_compra
	from (
		select * from orden_compra
		where codigo_estado = 2
		) as oc
	inner join
		(
		select *
		from orden_compra_detalle
		where codigo_pedido_orden_compra >0
		) as ocd
	on oc.codigo = ocd.codigo_orden_compra

) as pedido
on dato.codigo_medicamento = pedido.codigo_medicamento
and dato.codigo = pedido.codigo_pedido_orden_compra
order by indicador_prioridad,fecha_pedido asc";
        return ejecutarConsulta($sql);      
    }
     
}
   
?>