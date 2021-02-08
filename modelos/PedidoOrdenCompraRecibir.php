<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class PedidoOrdenCompraRecibir
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros
    public function enviar($idcodigo,$idpedido,$codigo_medicamento,$fechaPedido,$idusuario,$fechaRecibo,$idusuarioDestino,$obs,$estadoCierre)
    {
       //  error_log('########### '.$idcodigo);
        $sql="INSERT INTO pedido_orden_compra_movimiento (
            codigo_pedido_orden_compra, codigo_medicamento, fecha_envio, 
            idusuario_envio, fecha_recibo, idusuario_destino, obs, codigo_estado,codigo_estado_informe)
            VALUES ('$idpedido','$codigo_medicamento',"
                . "'$fechaPedido'::timestamp,'$idusuario',null,'$idusuarioDestino','$obs',1,$estadoCierre);"
                
                . "UPDATE pedido_orden_compra_movimiento 
                 set codigo_estado = 3  ,tiempo_proceso='$fechaPedido'::timestamp where codigo='$idcodigo';"
               
             . "UPDATE orden_compra_pedido_detalle 
                 set estado_cierre = $estadoCierre "
                . "where codigo_orden_compra_pedido=$idpedido"
                . " and codigo_medicamento=$codigo_medicamento;";
   
 //error_log('########### '.$sql);
        
       return ejecutarConsulta($sql);
       
    }
    
      public function recibir($idcodigo,$fechaRecibo)
    {
          
        $sql="UPDATE pedido_orden_compra_movimiento 
            set codigo_estado = 2, fecha_recibo ='$fechaRecibo'::timestamp where codigo in ($idcodigo);";
           // error_log('############ $sql '.$sql);   
         /*       . "UPDATE orden_compra_pedido_detalle 
            set estado_cierre = 1 ,codigo_estado = 1 
            where codigo_orden_compra_pedido=$idpedido and codigo_estado "
                . "and codigo_medicamento=$codigoMedicamento;";
         * 
         */
        return ejecutarConsulta($sql);
 
    }
     
    //Implementamos un método para anular categorías
    public function anular($idingreso)
    {
        $sql="UPDATE ingreso SET estado='Anulado' WHERE idingreso='$idingreso'";
        return ejecutarConsulta($sql);
    }
 
 
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrarRecibir($idcodigo)
    {
        $sql="select pocm.codigo,ocp.numero_expediente,
to_char(pocm.fecha_envio,'DD/MM/YYYY HH12:MI'),
(select apellidos || ' ' || nombres from usuario where cedula_identidad = pocm.idusuario_envio ),
pocm.codigo_medicamento,(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion from descripcion_medicamento 
where codigo= pocm.codigo_medicamento) as producto,cantidad,
pocm.obs,pocm.codigo_estado,codigo_pedido_orden_compra
from (
select *
from pedido_orden_compra_movimiento
) as pocm
inner join
(
	select ocp.codigo,numero_expediente,fecha_pedido,codigo_medicamento,cantidad,meses_cantidad from (
	select * from orden_compra_pedido ) as ocp
	inner join
	(select * from orden_compra_pedido_detalle ) as ocpd
	on ocp.codigo = ocpd.codigo_orden_compra_pedido
) as ocp
on ocp.codigo = pocm.codigo_pedido_orden_compra
and ocp.codigo_medicamento = pocm.codigo_medicamento
and pocm.codigo in ($idcodigo)";
        
      // error_log('##########33 '.$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
 
     public function mostrarEnviar($idcodigo)
    {
        $sql="select pocm.codigo,ocp.numero_expediente,
to_char(pocm.fecha_envio,'DD/MM/YYYY HH12:MI'),
(select apellidos || ' ' || nombres from usuario where cedula_identidad = pocm.idusuario_envio ),
pocm.codigo_medicamento,(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion from descripcion_medicamento 
where codigo= pocm.codigo_medicamento) as producto,cantidad,
pocm.obs,pocm.codigo_estado,ocp.codigo as codigo_pedido_orden_compra
from (
select *
from pedido_orden_compra_movimiento
) as pocm
inner join
(
	select ocp.codigo,numero_expediente,fecha_pedido,codigo_medicamento,cantidad,meses_cantidad from (
	select * from orden_compra_pedido ) as ocp
	inner join
	(select * from orden_compra_pedido_detalle ) as ocpd
	on ocp.codigo = ocpd.codigo_orden_compra_pedido
) as ocp
on ocp.codigo = pocm.codigo_pedido_orden_compra
and ocp.codigo_medicamento = pocm.codigo_medicamento
and pocm.codigo ='$idcodigo'";
        
   //  error_log('##########33 '.$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
 
    
    public function listarDetalle($idcodigo)
    {
        $sql="select pocm.codigo,ocp.numero_expediente,
to_char(pocm.fecha_envio,'DD/MM/YYYY HH12:MI') as fecha_envio,
(select apellidos || ' ' || nombres from usuario where cedula_identidad = pocm.idusuario_envio ) as usuarioEnvio,
pocm.codigo_medicamento,(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion from descripcion_medicamento 
where codigo= pocm.codigo_medicamento) as producto,cantidad,
pocm.obs,pocm.codigo_estado,pocm.codigo_pedido_orden_compra
from (
select *
from pedido_orden_compra_movimiento
) as pocm
inner join
(
	select ocp.codigo,numero_expediente,fecha_pedido,codigo_medicamento,cantidad,meses_cantidad from (
	select * from orden_compra_pedido ) as ocp
	inner join
	(select * from orden_compra_pedido_detalle ) as ocpd
	on ocp.codigo = ocpd.codigo_orden_compra_pedido
) as ocp
on ocp.codigo = pocm.codigo_pedido_orden_compra
and ocp.codigo_medicamento = pocm.codigo_medicamento
and pocm.codigo in ($idcodigo)";
        
      
        return ejecutarConsulta($sql);
    }
 
    //Implementar un método para listar los registros
    public function listar($idusuario)
    {
        $sql="select * from (select max(pocm.codigo) as codigo_movimiento,ocp.codigo as numero_pedido,ocp.numero_expediente,
                to_char(pocm.fecha_envio,'DD/MM/YYYY HH12:MI') as fecha_evio,
                (select apellidos || ' ' || nombres from usuario where cedula_identidad = pocm.idusuario_envio ) as usuario,
                pocm.codigo_medicamento,(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion from descripcion_medicamento 
                where codigo= pocm.codigo_medicamento) as producto,cantidad,
                pocm.obs,pocm.codigo_estado,pocm.idusuario_destino,(select nombre from estado_pedido_orden_compra where codigo = pocm.codigo_estado_informe ) as estadoCierrePedido,
                (select nombre from indicador_prioridad where codigo = ocp.indicador_prioridad) as nombre_prioridad,ocp.indicador_prioridad,coalesce(to_char(fecha_recibo,'DD'),'0') as recibio
                from (
                
                select *
                from pedido_orden_compra_movimiento
                where codigo_estado_informe <>12
                ) as pocm
                inner join
                (
                        select ocp.codigo,numero_expediente,fecha_pedido,codigo_medicamento,cantidad,meses_cantidad,ocpd.codigo_estado,ocpd.indicador_prioridad from (
                        select * from orden_compra_pedido ) as ocp
                        inner join
                        (select * from orden_compra_pedido_detalle ) as ocpd
                        on ocp.codigo = ocpd.codigo_orden_compra_pedido
                ) as ocp
                on ocp.codigo = pocm.codigo_pedido_orden_compra
                and ocp.codigo_medicamento = pocm.codigo_medicamento 
                and pocm.idusuario_destino = '$idusuario' 
                and  pocm.codigo_estado =1
                group by numero_pedido,numero_expediente,fecha_envio,usuario,producto,pocm.codigo_medicamento,producto,
                cantidad,pocm.obs,pocm.codigo_estado,
                idusuario_destino,estadocierrepedido,nombre_prioridad,indicador_prioridad,recibio
                order by codigo_estado,indicador_prioridad,fecha_envio asc ) as dato
                WHERE  estadocierrepedido <> 'ENTREGADO AL PROVEEDOR'";
       // error_log('##########33 '.$sql);
        
        return ejecutarConsulta($sql);      
    }
     public function listarReciboProveedor()
    {
        $sql="select *
                from (
                select max(pocm.codigo) as codigo_movimiento,ocp.codigo as numero_pedido,ocp.numero_expediente,
                to_char(pocm.fecha_envio,'DD/MM/YYYY HH12:MI') as fecha_evio,
                (select apellidos || ' ' || nombres from usuario where cedula_identidad = pocm.idusuario_envio ) as usuario,
                pocm.codigo_medicamento,(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion from descripcion_medicamento 
                where codigo= pocm.codigo_medicamento) as producto,cantidad,
                pocm.obs,pocm.codigo_estado,pocm.idusuario_destino,(select nombre from estado_pedido_orden_compra where codigo = pocm.codigo_estado_informe ) as estadoCierrePedido,
                (select nombre from indicador_prioridad where codigo = ocp.indicador_prioridad) as nombre_prioridad,ocp.indicador_prioridad,coalesce(to_char(fecha_recibo,'DD'),'0') as recibio
                from (
                
                select *
                from pedido_orden_compra_movimiento
                where codigo_estado_informe <>12
                ) as pocm
                inner join
                (
                        select ocp.codigo,numero_expediente,fecha_pedido,codigo_medicamento,cantidad,meses_cantidad,ocpd.codigo_estado,ocpd.indicador_prioridad from (
                        select * from orden_compra_pedido ) as ocp
                        inner join
                        (select * from orden_compra_pedido_detalle ) as ocpd
                        on ocp.codigo = ocpd.codigo_orden_compra_pedido
                ) as ocp
                on ocp.codigo = pocm.codigo_pedido_orden_compra
                and ocp.codigo_medicamento = pocm.codigo_medicamento 
                and  pocm.codigo_estado =1
            
                group by numero_pedido,numero_expediente,fecha_envio,usuario,producto,pocm.codigo_medicamento,producto,
                cantidad,pocm.obs,pocm.codigo_estado,
                idusuario_destino,estadocierrepedido,nombre_prioridad,indicador_prioridad,recibio
                order by codigo_estado,indicador_prioridad,fecha_envio asc ) as dato
                WHERE  estadocierrepedido = 'ENTREGADO AL PROVEEDOR'";
       // error_log('##########33 '.$sql);
        
        return ejecutarConsulta($sql);      
    }
    
    public function selectEstadoCierre()
    {
        $sql="SELECT codigo,nombre FROM estado_pedido_orden_compra
             order by codigo;";
        
        return ejecutarConsultaSimpleFila($sql);
    } 
    
      public function verificarPedidoOc($idpedido,$codigoMedicamento)
    {
        $sql="SELECT count(b.codigo) as cantidad FROM orden_compra a,orden_compra_detalle b
             where a.codigo = b.codigo_orden_compra and a.codigo_estado = 2
             and b.codigo_pedido_orden_compra ='$idpedido' and codigo_medicamento ='$codigoMedicamento';";
        
        //error_log('##########33 '.$sql);
        return ejecutarConsulta_retornarID($sql);
    } 
}
 
?>