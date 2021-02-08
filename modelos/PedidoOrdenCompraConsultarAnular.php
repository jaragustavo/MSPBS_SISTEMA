<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class PedidoOrdenCompraConsultarAnular
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros
   
       
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
        $sql="select max(pocm.codigo) as codigo_movimiento,ocp.codigo as numero_pedido,ocp.numero_expediente,
                to_char(max(pocm.fecha_envio),'DD/MM/YYYY HH12:MI') as fecha_envio,
                (select apellidos || ' ' || nombres from usuario where cedula_identidad = pocm.idusuario_envio ) as usuario,
                pocm.codigo_medicamento,(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion from descripcion_medicamento 
                where codigo= pocm.codigo_medicamento) as producto,cantidad,
                pocm.obs,pocm.codigo_estado,pocm.idusuario_destino,
                (select nombre from estado_pedido_orden_compra where codigo = ocp.estado_cierre ) as estadoCierrePedido,
                (select nombre from indicador_prioridad where codigo = ocp.indicador_prioridad) as nombre_prioridad,
                ocp.indicador_prioridad,coalesce(to_char(fecha_recibo,'DD'),'0') as recibio
                from (
                
                
                select *
                from pedido_orden_compra_movimiento
                where fecha_recibo isnull
                and codigo_estado = 1
                and idusuario_envio = $idusuario    
               
                            
                ) as pocm
                inner join
                (
                        select ocp.codigo,numero_expediente,fecha_pedido,codigo_medicamento,
                        cantidad,meses_cantidad,ocpd.codigo_estado,ocpd.indicador_prioridad,ocpd.estado_cierre from (
                        select * from orden_compra_pedido ) as ocp
                        inner join
                        (select * from orden_compra_pedido_detalle ) as ocpd
                        on ocp.codigo = ocpd.codigo_orden_compra_pedido
                ) as ocp
                on ocp.codigo = pocm.codigo_pedido_orden_compra
                and ocp.codigo_medicamento = pocm.codigo_medicamento 
        
               group by numero_pedido,numero_expediente,usuario,producto,
               pocm.codigo_medicamento,producto,
                cantidad,pocm.obs,pocm.codigo_estado,
                idusuario_destino,estadocierrepedido,nombre_prioridad,indicador_prioridad,recibio
                order by numero_pedido,codigo_medicamento";
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