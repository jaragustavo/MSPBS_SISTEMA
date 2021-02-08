<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class ProveedorAtraso
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
      public function selectEstadoProveedorAtraso()
    {
        $sql="SELECT * FROM estado_proveedor_atraso  
              order by nombre;";
        
        return ejecutarConsultaSimpleFila($sql);
    }
    public function selectMedicamento()
    {
        $sql="select codigo,producto
from (
select codigo,codigo ||' '|| clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion as producto 
from descripcion_medicamento
) as descripcion
inner join
(
select codigo as codigo_medicamento
from medicamento
where codigo_estado =1
) as medicamento
on descripcion.codigo = medicamento.codigo_medicamento";
        
        return ejecutarConsultaSimpleFila($sql);
    }
 
    //Implementamos un método para insertar registros
    public function insertar($numero_orden_compra,$codigo_medicamentoOC,$codigo_medicamento_recibido,$fecha_hora,$obs,$codigo_usuario,$codigo_estado_proveedor_atraso,$codigo_orden_compra)
    {
        $sql="INSERT INTO proveedor_atraso (numero_orden_compra,codigo_medicamento_oc,codigo_medicamento_recibido,fecha_hora,obs,codigo_usuario,codigo_estado_proveedor_atraso,codigo_orden_compra)
        VALUES ($numero_orden_compra,$codigo_medicamentoOC,$codigo_medicamento_recibido,'$fecha_hora'::timestamp,'$obs',$codigo_usuario,$codigo_estado_proveedor_atraso,$codigo_orden_compra)";
    //   error_log('######## '.$sql);
        return ejecutarConsulta($sql);
       
    }
 
     
    //Implementamos un método para anular categorías
    public function anular($idcodigo)
    {
        $sql="update proveedor_atraso
              set codigo_estado_proveedor_atraso =8
              where codigo = $idcodigo";
        return ejecutarConsulta($sql);
    }
   
 
    //Implementar un método para mostrar los datos de un registro a modificar
    public function editar($idcodigo,$codigo_medicamento)
    {
        $sql="select ocp.codigo,numero_expediente,fecha_pedido,codigo_medicamento,(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion from descripcion_medicamento 
              where codigo= codigo_medicamento) as producto,stock,dmp,cantidad,meses_cantidad,ocpd.codigo_estado,obs from (
              select * from orden_compra_pedido ) as ocp
              inner joins
              (select * from orden_compra_pedido_detalle ) as ocpd
              on ocp.codigo = ocpd.codigo_orden_compra_pedido
              and ocp.codigo='$idcodigo' and codigo_medicamento='$codigo_medicamento'";
        
      // error_log('##########33 '.$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
    
     public function mostrarDetalle($numeroOC,$codigoOC)
    {
       
        $sql="select codigo, numero_orden_compra,
            (select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion from descripcion_medicamento 
                    where codigo= codigo_medicamento_oc) as producto_oc,
                    (select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion from descripcion_medicamento 
                    where codigo= codigo_medicamento_recibido) as producto_recibido,
                    fecha_hora,obs,codigo_usuario,(select nombre from estado_proveedor_atraso where codigo = codigo_estado_proveedor_atraso) as estado,
                    codigo_medicamento_oc,
                    codigo_medicamento_recibido
            from proveedor_atraso
            where codigo_orden_compra = $codigoOC";
        
  //error_log('##########33 '.$sql);
        return ejecutarConsulta($sql);
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
  WHERE codigo_pedido_orden_compra='$idcodigo' and codigo_medicamento='$codigo_medicamento' order by codigo";
        
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
        $sql="select x.numero_orden_compra,to_char (x.fecha_orden_compra, 'DD-MM-YYYY') as fecha_oc,x.tipo_compra,
  x.proveedor,x.codigo_medicamento, x.producto, x.cantidad_solicitada,x.cantidad_recepcionada, 
   (x.cantidad_solicitada-x.cantidad_recepcionada) as saldo, 
  to_char (x.fecha_recepcion_oc_proveedor, 'DD-MM-YYYY') AS recepcion_proveedor,
 to_char (x.plazo_entrega, 'DD-MM-YYYY') as plazo_entrega,x.dias_plazo_entrega,
  (x.plazo_entrega - current_date ) as dias_atraso,
  x.referencia,x.item,x.codigo_proveedor,x.codigoOC  from 
(select r.item,r.numero_orden_compra,r.codigoOC, r.codigo_adjudicacion, 
(select  abreviacion||' '||numero||'/'||anio from adjudicacion a, tipo_adjudicacion b
where a.codigo_tipo_adjudicacion = b.codigo and a.codigo = r.codigo_adjudicacion) as tipo_compra, 
r.codigo_proveedor, r.proveedor, r.fecha_orden_compra, r.fecha_recepcion_oc_proveedor, 
max(r.fecha_recepcion_parque) as ultima_fecha_parque, r.dias_plazo_entrega, 
plazo_entrega, r.codigo_medicamento, r.producto, r.cantidad_solicitada, 
sum(coalesce(r.cantidad_recepcionada,0)) as cantidad_recepcionada, r.referencia from 
(select oc.item,oc.numero_orden_compra,oc.codigoOC, oc.referencia, oc.codigo_adjudicacion, oc.codigo_proveedor, 
(select nombre from laboratorio where codigo = oc.codigo_proveedor) as proveedor, fecha_orden_compra,
 fecha_recepcion_oc_proveedor,
 fecha_recepcion as fecha_recepcion_parque, dias_plazo_entrega, plazo_entrega, oc.codigo_medicamento, (select clasificacion_medicamento||' '||coalesce(concentracion, '')||' '||forma_farmaceutica||' '||presentacion from descripcion_medicamento where codigo = oc.codigo_medicamento ) as producto,
  cantidad_solicitada, coalesce(adq.cantidad,0) as cantidad_recepcionada from 
(select b.item,a.codigo_adjudicacion, a.numero_orden_compra, a.codigo_proveedor, b.codigo_medicamento, 
a.fecha_orden_compra, a.fecha_recepcion_oc_proveedor,a.referencia, b.codigo_orden_compra as codigoOC,
b.cantidad_solicitada, a.plazo_entrega, a.dias_plazo_entrega, b.codigo_orden_compra ,  a.plazo_entrega - current_date
from orden_compra a, orden_compra_detalle b
where a.codigo= b.codigo_orden_compra and a.codigo_estado=2 ) as oc
left join
(select a.codigo, numero_orden_compra, codigo_laboratorio, codigo_sucursal, codigo_adjudicacion, d.cantidad, 
codigo_stock_medicamento, (select codigo_medicamento from stock_medicamento 
where codigo = codigo_stock_medicamento) as codigo_medicamento,  
fecha_adquisicion as fecha_recepcion, b.codigo as codigo_movimiento_stock, c.codigo as codigo_sucursal, c.nombre
 from adquisicion_medicamento a, detalle_adquisicion b, sucursal c, movimiento_stock d
where b.codigo = d.codigo and
 a.codigo = b.codigo_adquisicion_medicamento and a.codigo_sucursal=c.codigo and c.codigo_tipo_sucursal =11
 and codigo_estado_adquisicion = 2 ) as adq

on( oc.numero_orden_compra=adq.numero_orden_compra 
--and oc.codigo_adjudicacion = adq.codigo_adjudicacion 
and oc.codigo_medicamento=adq.codigo_medicamento) ) as r 
group by r.numero_orden_compra, r.codigo_adjudicacion,
 tipo_compra, codigo_proveedor, proveedor, fecha_orden_compra, 
 fecha_recepcion_oc_proveedor, dias_plazo_entrega, plazo_entrega, 
 codigo_medicamento, producto, r.cantidad_solicitada, r.referencia,r.item,r.codigoOC) as x";
        return ejecutarConsulta($sql);      
    }
     
}
   
?>