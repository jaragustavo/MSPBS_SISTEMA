<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class PagoProveedor
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
   
     //Implementar un método para listar los registros
    public function listar()
    {
       $sql="select distinct r.id_llamado, llamado,titulo, monto_recepcion, monto_adjudicado, monto_factura, monto_obligado, codigo_adjudicacion,  observacion from
(select fact.id_llamado,  monto_recepcion, monto_adjudicado, monto_factura, coalesce(monto_obligado,0) as monto_obligado from
(select * from (select rec.id_llamado, monto_recepcion, monto_adjudicado, coalesce(monto_factura,0) as monto_factura from
(select recep.id_llamado, monto_recepcion, coalesce(monto_adjudicado,0) as monto_adjudicado from
(select id_llamado, sum(monto_recepcion) as monto_recepcion from
(select id_llamado, codigo_medicamento, clasificacion_medicamento||' '||coalesce(concentracion, '')||' '||forma_farmaceutica||' '||presentacion as producto,numero_lote, fecha_recepcion,
to_char(fecha_vencimiento, 'DD/MM/YYYY') as vencimiento,cantidad_recibida,precio_unitario,(cantidad_recibida*precio_unitario)as monto_recepcion,(abreviacion|| ' ' ||numero|| '/' ||anio)as llamado, proveedor,sucursal  
from (
        select proveedor,codigo_adjudicacion,codigo_medicamento,clasificacion_medicamento,concentracion,forma_farmaceutica,presentacion,
        codigo_stock_medicamento,numero_lote,fecha_vencimiento,cantidad_actual,cantidad_recibida,precio_unitario,sucursal, fecha_recepcion
from (
        select proveedor,codigo_sucursal,codigo_adjudicacion,codigo_medicamento,clasificacion_medicamento,concentracion,forma_farmaceutica,presentacion,
        codigo_stock_medicamento,numero_lote,fecha_vencimiento,cantidad_actual,cantidad_recibida,precio_unitario, fecha_recepcion 

from (
        select  codigo_laboratorio,codigo_sucursal,codigo_adjudicacion,codigo_medicamento,clasificacion_medicamento,concentracion,forma_farmaceutica,presentacion,
        codigo_stock_medicamento,numero_lote,fecha_vencimiento,cantidad_actual,cantidad_recibida,precio_unitario, fecha_recepcion 

from (
     select codigo_laboratorio,codigo_sucursal,codigo_adjudicacion,codigo_medicamento,codigo_stock_medicamento,numero_lote,fecha_vencimiento,cantidad_actual,cantidad_recibida,precio_unitario, fecha_hora as fecha_recepcion 
     from (
             select 
             codigo,codigo_sucursal,codigo_adjudicacion,
             codigo_medicamento,numero_lote, 
             fecha_vencimiento, precio_unitario,
             cantidad as cantidad_actual 
            from stock_medicamento
      where codigo_sucursal in (select codigo from sucursal where codigo_tipo_sucursal = 11)
           ) as stock
      inner join
(
        select codigo_laboratorio,codigo_stock_medicamento,sum(cantidad_recibida) as cantidad_recibida, fecha_hora          
        from (
                select  a.codigo as codigo_movimiento_stock, a.codigo_stock_medicamento,a.cantidad as cantidad_recibida,a.fuente_destino, a.fecha_hora
                from movimiento_stock a, stock_medicamento b
                where a.codigo_tipo_movimiento = 5 
                and   a.codigo_stock_medicamento = b.codigo
                and   b.codigo_sucursal in 
                (884, 1701, 1790, 1801)
        ) as movimiento
        inner join
        (
        select codigo_adquisicion,codigo_laboratorio,codigo_sucursal,codigo_movimiento_stock
        from (
           select codigo as codigo_adquisicion,codigo_laboratorio,codigo_sucursal
           from adquisicion_medicamento
           ) as adquisicion
           inner join
           (
           select codigo as codigo_movimiento_stock,codigo_adquisicion_medicamento
           from detalle_adquisicion
           ) as adquisicionDET
          on adquisicion.codigo_adquisicion = adquisicionDET.codigo_adquisicion_medicamento
        ) as adquisicion
        on adquisicion.codigo_movimiento_stock = movimiento.codigo_movimiento_stock
        group by codigo_laboratorio, codigo_stock_medicamento, fecha_hora   
    ) as recepcion
                             on stock.codigo = recepcion.codigo_stock_medicamento
       ) as datos     
       inner join 
       (
       select *
       from descripcion_medicamento
       ) as medicamento
       on datos.codigo_medicamento = medicamento.codigo
       ) as datos
       inner join
       (
         select codigo, nombre as proveedor
         from laboratorio
       ) as proveedor
       on proveedor.codigo = datos.codigo_laboratorio
       ) as datos
       inner join
       (
        select codigo, nombre as sucursal
        from sucursal
       ) as sucursal
       on datos.codigo_sucursal = sucursal.codigo
       ) as datos
       inner join
(
        select a.id_llamado, a.codigo,a.numero,a.anio,a.codigo_tipo_adjudicacion, b.abreviacion
        from adjudicacion a, tipo_adjudicacion b
        where a.codigo_tipo_adjudicacion = b.codigo

) as adjudicacion
on adjudicacion.codigo = datos.codigo_adjudicacion
order by producto asc) as r
group by id_llamado
order by id_llamado asc) as recep
left join
(select id_llamado, monto_adjudicado from adjudicacion
where codigo_sucursal = 1 and codigo_estado_adjudicacion = 1) as adj
on(recep.id_llamado = adj.id_llamado)) as rec
left join

(select pac,  sum(cast(monto as bigint)) as monto_factura  from pago_proveedores_temp
group by pac) as total
on(rec.id_llamado = cast(total.pac as bigint) )) as G where id_llamado notnull) as fact
left join

(select pac,  sum(cast(monto as bigint)) as monto_obligado  from pago_proveedores_temp
where estado = 'Obligado'
group by pac) as obl
on(fact.id_llamado = cast(obl.pac as bigint) )) as r
left join 

(select  id_llamado, abreviacion||' '||numero||'/'||anio as llamado, a.codigo as codigo_adjudicacion, observacion ,titulo
from adjudicacion a, tipo_adjudicacion b
where a.codigo_tipo_adjudicacion = b.codigo and a.codigo_sucursal = 1 and a.codigo_estado_adjudicacion=1) as tipo_compra
on(r.id_llamado = tipo_compra.id_llamado)";
      
return ejecutarConsulta($sql);      
    }

  public function mostrarModalLlamadoProveedor($codigo_adjudicacion)
    {
        $sql="select codigo_adjudicacion,id_llamado,llamado,titulo,codigo_proveedor,ruc,proveedor,observacion,monto_maximo,monto_minimo,monto_emitido,
       coalesce(monto_factura,0) as monto_factura,coalesce(monto_obligado,0) as monto_obligado
from (
	select codigo_adjudicacion,id_llamado,llamado,titulo,codigo_proveedor,adj.ruc,proveedor,observacion,monto_maximo,monto_minimo,monto_emitido,
	       coalesce(monto_obligado,0) as monto_obligado,coalesce(monto_factura,0) as monto_factura
	from (
	select codigo_adjudicacion,id_llamado,llamado,titulo,codigo_proveedor,(select ruc from laboratorio where codigo = codigo_proveedor) as ruc,
		    (select nombre from laboratorio where codigo = codigo_proveedor) as proveedor,observacion,monto_maximo,monto_minimo,monto_emitido
	from (
	select codigo,id_llamado,(select abreviacion from tipo_adjudicacion where codigo = codigo_tipo_adjudicacion)||' '||numero||'/'||anio as llamado,titulo,observacion
	from adjudicacion  
	where codigo_sucursal = 1
	and   codigo_estado_adjudicacion = 1
	) as adj
	inner join
	(
	select codigo_adjudicacion,codigo_proveedor,sum(cantidad_adjudicada *precio_unitario) as monto_maximo,sum(cantidad_minima *precio_unitario) as monto_minimo,
				sum(cantidad_emitida *precio_unitario) as monto_emitido
	from detalle_adjudicacion_temporal
	group by codigo_adjudicacion,codigo_proveedor
	) as detalle
	on adj.codigo = detalle.codigo_adjudicacion
) as adj
left join 
(
	select mf.laboratorio,mf.pac,mf.monto_factura,obl.monto_obligado,mf.ruc
	from (
	select  ruc,laboratorio, pac, coalesce(sum(cast(monto as bigint)),0) as monto_factura from pago_proveedores_temp
	--where pac = '348199'
	group by ruc,laboratorio, pac 
	) as mf
	left join
	(
	select ruc,laboratorio, pac, coalesce(sum(cast(monto as bigint)),0) as monto_obligado from pago_proveedores_temp
	where estado = 'Obligado'
	--and  pac = '348199'
	group by ruc,laboratorio, pac
	) as obl
	on mf.pac = obl.pac
	and mf.ruc = obl.ruc
) as mf
on adj.id_llamado = cast(mf.pac as bigint)
and adj.ruc = mf.ruc
) as dato
where codigo_adjudicacion =$codigo_adjudicacion";
return ejecutarConsulta($sql);      
    }   
    
    public function listarItem($codigo_adjudicacion,$codigo_proveedor)
	{
        $sql="select item,det.codigo_medicamento,producto,codigo_proveedor,monto_adjudicado,monto_minimo,monto_emitido,disponibilidad_saldo_reservado
from 
(select item,codigo_medicamento,(select clasificacion_medicamento||' '||coalesce(concentracion, '')||' '||forma_farmaceutica||' '||presentacion from descripcion_medicamento where codigo = codigo_medicamento ) as producto,
        codigo_proveedor,cantidad_adjudicada * precio_unitario as monto_adjudicado,
        cantidad_minima * precio_unitario as monto_minimo,cantidad_emitida * precio_unitario as monto_emitido
        from detalle_adjudicacion_temporal
        where codigo_adjudicacion = $codigo_adjudicacion
        and   codigo_proveedor =  $codigo_proveedor
) as det
inner join
(

        
select xx.codigo_medicamento, xx.clasificacion_medicamento, 
xx.concentracion, xx.forma_farmaceutica, xx.presentacion, cant_meses_distribuido,
 cant_distribuida, stock_actual,
  DMP,
   
     coalesce(ROUND(CASE WHEN DMP=0 THEN 0            
            ELSE (stock_actual-coalesce(cant_reservada,0))/DMP
    END),'0') AS disponibilidad_saldo_reservado,
  coalesce(cant_reservada,0) as cant_reservada,
   (stock_actual-coalesce(cant_reservada,0)) as saldo
  
 
  
  from
(select stock.codigo_medicamento, stock.clasificacion_medicamento, stock.concentracion, 
stock.forma_farmaceutica,
 stock.presentacion,coalesce(cant_meses_distribuido, '0')as cant_meses_distribuido,
 coalesce(cant_distribuida, '0') as cant_distribuida ,
  STOCK_ACTUAL, coalesce(DMP,'0') as DMP,
    coalesce(ROUND(CASE WHEN DMP=0 THEN 0            
            ELSE STOCK_ACTUAL/DMP
    END),'0') AS disponibilidad_stock_fisico   
 from 
                (select codigo_medicamento, clasificacion_medicamento, concentracion, forma_farmaceutica, presentacion, stock_actual, codigo_estado from 
                (Select codigo_medicamento, sum(cantidad) as STOCK_ACTUAL 
                 from 
                public.stock_medicamento a, 
                public.sucursal b where 
                a.codigo_sucursal = b.codigo 
                and b.codigo_tipo_sucursal = 11 
                and a.codigo_sucursal <> 1808 
                group by codigo_medicamento
                order by codigo_medicamento asc) as saldo
                inner join
                (select a.codigo, clasificacion_medicamento, presentacion, forma_farmaceutica, concentracion, codigo_estado from descripcion_medicamento a, medicamento b
where a.codigo=b.codigo) as descripcion
                on (saldo.codigo_medicamento=descripcion.codigo) where stock_actual >= 0 and codigo_estado = 1 order by clasificacion_medicamento asc
                ) as stock

                left join

                (select codigo_medicamento, clasificacion_medicamento, concentracion, forma_farmaceutica, presentacion,count(*) as cant_meses_distribuido, sum(cantidad_x_mes) as cant_distribuida, round((sum(cantidad_x_mes))/count(*)) as DMP from
                (Select codigo_medicamento, clasificacion_medicamento, concentracion, forma_farmaceutica, presentacion, sum(cant_distribuida) cantidad_x_mes, mes, anho  from 
                (select codigo_medicamento, clasificacion_medicamento, concentracion, forma_farmaceutica, presentacion, cant_distribuida, fecha_hora, extract(month FROM fecha_hora) as mes,extract(year FROM fecha_hora) as anho   from 

                (select sum(a.cantidad) as cant_distribuida, b.codigo_medicamento, a.fecha_hora,
                c.codigo_tipo_sucursal
                from movimiento_stock a, 
                stock_medicamento b, sucursal c
                where 
                a.codigo_stock_medicamento=b.codigo and 
                b.codigo_sucursal = c.codigo and
                c.codigo_tipo_sucursal=11 and
                a.codigo_tipo_movimiento = 3 
                and a.fecha_hora between (now()::date-'12 month'::interval)   and
                (now()::date) and b.codigo_sucursal not in(1808,1809) 
                group by b.codigo_medicamento, c.codigo_tipo_sucursal, a.fecha_hora
                order by b.codigo_medicamento) as distribucion
                inner join
                (select * from descripcion_medicamento) as descripcion
                on distribucion.codigo_medicamento=descripcion.codigo
                order by cant_distribuida desc) as distribucion_mes
                group by codigo_medicamento, clasificacion_medicamento, concentracion, 
                forma_farmaceutica, presentacion, mes, anho
                order by mes, anho,  cantidad_x_mes desc) as distribucion_mes
                group by codigo_medicamento, clasificacion_medicamento, concentracion, forma_farmaceutica, presentacion
                order by clasificacion_medicamento asc) as dmp
                on(stock.codigo_medicamento = dmp.codigo_medicamento)) as xx
                left join 
                (select codigo_medicamento, sum(cantidad_a_distribuir) as cant_reservada from
		(select codigo_medicamento, cantidad_a_distribuir, c.codigo as codigo_sucursal_origen, c.nombre as origen, codigo_sucursal_destino, (select nombre from sucursal where codigo = codigo_sucursal_destino) as destino from detalle_transferencia_temporal a, stock_medicamento b, sucursal c, transferencia d
		where a.codigo_stock=b.codigo and b.codigo_sucursal = c.codigo and d.codigo = a.codigo_transferencia
		and c.codigo_tipo_sucursal = 11 and c.codigo not in (1808, 1809, 668, 599, 1667)) as y
		group by codigo_medicamento) as yy
		on(xx.codigo_medicamento = yy.codigo_medicamento)
		order by clasificacion_medicamento asc
) as estado
on det.codigo_medicamento = estado.codigo_medicamento";


       // error_log($sql);
        
        return ejecutarConsulta($sql);                
                
	}
    
}
   
?>