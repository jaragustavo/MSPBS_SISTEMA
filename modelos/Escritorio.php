<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class Escritorio
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
  // (clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion) as producto 
    public function obtenerDatos()
    {
        $sql="select codigo_medicamento,producto,porcentaje,cant_distribuida
from (
select d.codigo_medicamento, producto,  cast(coalesce(porcentaje ,0) as integer) as porcentaje,cant_distribuida from
(select codigo_medicamento, clasificacion_medicamento as producto, cant_distribuida  from 

(select sum(a.cantidad) as cant_distribuida, b.codigo_medicamento,
c.codigo_tipo_sucursal
from movimiento_stock a, 
stock_medicamento b, sucursal c
where 
a.codigo_stock_medicamento=b.codigo and 
b.codigo_sucursal = c.codigo and
c.codigo_tipo_sucursal=11 and
a.codigo_tipo_movimiento = 3 
and a.fecha_hora between (select current_date - interval '12 month')
 and (select current_date - interval '0 month')
group by b.codigo_medicamento, c.codigo_tipo_sucursal
order by b.codigo_medicamento) as distribucion
inner join
(select * from descripcion_medicamento) as descripcion
on distribucion.codigo_medicamento=descripcion.codigo
order by cant_distribuida desc limit 10) as d

left join


(select codigo_medicamento, round(cantidad_emitida*100/cantidad_maxima) as porcentaje from
(select codigo_medicamento, sum(cantidad_maxima) as cantidad_maxima, sum(cantidad_emitida) as cantidad_emitida from
(select codigo_medicamento,  GREATEST(cantidad_minima, cantidad_maxima) as cantidad_maxima, cantidad_emitida from
(select codigo_medicamento, coalesce(cantidad_emitida) as cantidad_emitida, coalesce(cantidad_minima,0) as cantidad_minima, coalesce(cantidad_adjudicada,0) as cantidad_maxima from detalle_adjudicacion_temporal) as x) as y
group by codigo_medicamento) as z) as m
on(d.codigo_medicamento = m.codigo_medicamento)
order by cant_distribuida desc
) as dato";
      //  error_log('##### '.$sql);
        return ejecutarConsulta($sql);      
    }
     
}
   
?>