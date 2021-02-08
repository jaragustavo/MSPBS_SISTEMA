<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class ControlEmision
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros
    public function insertar($login,$nombre,$fecha,$codigo_orden_compra,$codigo_medicamento,$obs)
    {
        $sql="INSERT INTO control_emision (login,nombre,fecha,codigo_estado)
        VALUES ('$login','$nombre','$fecha',1);select currval( 'control_emision_codigo_seq' )::BIGINT;";
        //return ejecutarConsulta($sql);
        
       
        $idcodigonew=ejecutarConsulta_retornarID($sql);

    //  error_log('CONTROL EMISION ########## '.$sql); 
        
        $num_elementos=0;
        $sw=true;
 
        while ($num_elementos < count($codigo_orden_compra))
        {
            $sql_detalle = "INSERT INTO control_emision_detalle"
                    . "(codigo_control_emision,codigo_orden_compra,codigo_medicamento,obs) "
                    . "VALUES ($idcodigonew,$codigo_orden_compra[$num_elementos],$codigo_medicamento[$num_elementos],'$obs[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
        //     error_log('CONTROL EMISION ########## '.$sql_detalle);
        }
 
        return $sw;
    }
 
     public function modificar($codigo_control_emision,$login,$nombre,$fecha,$codigo_orden_compra,$codigo_medicamento,$obs)
    {
      $sql="update control_emision "
          . "set fecha = '$fecha' where codigo = $codigo_control_emision;"
          . "DELETE FROM control_emision_detalle WHERE codigo_control_emision = $codigo_control_emision;";
        //return ejecutarConsulta($sql);
    
      //         $sql="DELETE FROM control_emision_detalle WHERE codigo_control_emision = $codigo_control_emision;";
        //return ejecutarConsulta($sql);
       
       ejecutarConsulta($sql);

    ///error_log('modificar ########## '.$sql); 
        
        $num_elementos=0;
        $sw=true;
 
        while ($num_elementos < count($codigo_orden_compra))
        {
            $sql_detalle = " INSERT INTO control_emision_detalle"
                    . "(codigo_control_emision,codigo_orden_compra,codigo_medicamento,obs) "
                    . "VALUES ($codigo_control_emision,$codigo_orden_compra[$num_elementos],$codigo_medicamento[$num_elementos],'$obs[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
          // error_log('CONTROL EMISION ########## '.$sql_detalle);
        }
 
        return $sw;
    }
     
    //Implementamos un método para anular categorías
    public function anular($idcodigo)
    {
        $sql="UPDATE control_emision SET codigo_estado=2 WHERE codigo='$idcodigo'";
        return ejecutarConsulta($sql);
    }
 
 
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrarEditar($idcodigo)
    {
        $sql="select * from control_emision where codigo = $idcodigo";
        return ejecutarConsultaSimpleFila($sql);
    }
 
  
 
    //Implementar un método para listar los registros
    public function listar()
    {
        $sql="select codigo_control_emision,codigo_orden_compra,numero_orden_compra,
 fecha_orden_compra,
codigo_adjudicacion,codigo_proveedor,
proveedor,
dato.codigo_medicamento,
	 producto,
         monto,
        codigo_pedido_orden_compra,item,numero_expediente,
licitacion,id_llamado,cantidad_adjudicada,cantidad_minima,cantidad_emitida,fecha,
plurianual,obs,nombre_usuario,
por_ejecucion,indicador_prioridad from (
select distinct codigo_control_emision,dato.codigo as codigo_orden_compra,numero_orden_compra,
to_char(fecha_orden_compra,'DD/MM/YYYY') AS fecha_orden_compra,
dato.codigo_adjudicacion,dato.codigo_proveedor,
(select nombre from laboratorio where codigo= dato.codigo_proveedor) as proveedor,
dato.codigo_medicamento,
	(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion 
	from descripcion_medicamento 
         where codigo= dato.codigo_medicamento) as producto,
         (cantidad_solicitada * dato.precio_unitario) monto,
         codigo_pedido_orden_compra,dato.item,numero_expediente,

(select abreviacion from tipo_adjudicacion where codigo = codigo_tipo_adjudicacion) ||' '||
numero || '/'|| anio as licitacion,id_llamado,cantidad_adjudicada,cantidad_minima,cantidad_emitida,to_char(fecha,'DD/MM/YYYY') as fecha,
plurianual,obs,(select trim(nombres) ||' ' || trim(apellidos) from usuario where cedula_identidad = cast(login as bigint)) as nombre_usuario,
round((cantidad_emitida*100)/cast(cantidad_adjudicada as decimal),4) as por_ejecucion
from (
select dato.codigo,numero_orden_compra,fecha_orden_compra,dato.codigo_adjudicacion,dato.codigo_proveedor,
(select nombre from laboratorio where codigo= dato.codigo_proveedor) as proveedor,
dato.codigo_medicamento,cantidad_solicitada,dato.precio_unitario,codigo_pedido_orden_compra,dato.item,numero_expediente,
numero,anio,codigo_tipo_adjudicacion,id_llamado,cantidad_adjudicada,cantidad_minima,cantidad_emitida
from (
select dato.codigo,numero_orden_compra,fecha_orden_compra,codigo_adjudicacion,codigo_proveedor,
(select nombre from laboratorio where codigo= codigo_proveedor) as proveedor,
codigo_medicamento,cantidad_solicitada,precio_unitario,codigo_pedido_orden_compra,item,numero_expediente from
(
select oc.codigo,numero_orden_compra,fecha_orden_compra,codigo_adjudicacion,codigo_proveedor,
codigo_medicamento,cantidad_solicitada,precio_unitario,codigo_pedido_orden_compra,item
from (
select *
from orden_compra
where codigo_estado = 2
) as oc
inner join
(
select *
from orden_compra_detalle
) as ocd
on oc.codigo = ocd.codigo_orden_compra
--and oc.codigo = 364
)as dato
left join
(
select *
from orden_compra_pedido
) as pedido
on dato.codigo_pedido_orden_compra = pedido.codigo 
) as dato
inner join
(
select *
from (
	select *
	from adjudicacion
	) as adj
	inner join
	(
	select *
	from detalle_adjudicacion_temporal
	) as dat
	on adj.codigo = dat.codigo_adjudicacion
	) as adj
on adj.codigo = dato.codigo_adjudicacion
and adj.item = dato.item
and  adj.codigo_medicamento = dato.codigo_medicamento
and adj.codigo_proveedor = dato.codigo_proveedor
) as dato
inner join
(
select *
from (  
   select *
   from control_emision
   where codigo_estado = 1
   ) as ce
   inner join
   (
   select *
   from control_emision_detalle
   ) as ced
   on ce.codigo = ced.codigo_control_emision
--   and codigo_orden_compra = 364
) as ce
on dato.codigo = ce.codigo_orden_compra
and dato.codigo_medicamento = ce.codigo_medicamento
order by codigo_control_emision desc
) as dato
inner join
(
   select a.codigo_medicamento,a.codigo_orden_compra_pedido,b.codigo,b.nombre as indicador_prioridad
   from orden_compra_pedido_detalle a,indicador_prioridad b
   where a.indicador_prioridad = b.codigo

) as ocpd
on dato.codigo_medicamento = ocpd.codigo_medicamento
and dato.codigo_pedido_orden_compra = ocpd.codigo_orden_compra_pedido";
        return ejecutarConsulta($sql);      
    }
    
  public function listarDetalle($idcodigo)
    {
        $sql="select ced.codigo,numero_orden_compra,fecha_orden_compra,(select nombre from laboratorio where codigo = codigo_proveedor) as proveedor,
       codigo_medicamento,(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion
       from descripcion_medicamento 
         where codigo= codigo_medicamento) as producto,monto_total,obs,ced.codigo_orden_compra 
from (
select *
from control_emision_detalle
) as ced
inner join
(
select *
from orden_compra
) as oc
on ced.codigo_orden_compra = oc.codigo
and ced.codigo_control_emision = $idcodigo order by ced.codigo";
        
      
        return ejecutarConsulta($sql);
    }  
     public function listarOC()
    {
        $sql="select dato.codigo as codigo_orden_compra,numero_orden_compra,to_char(fecha_orden_compra,'DD/MM/YYYY'),
(select nombre from laboratorio where codigo= dato.codigo_proveedor) as proveedor,
dato.codigo_medicamento,
	(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion 
	from descripcion_medicamento 
         where codigo= dato.codigo_medicamento) as producto,
         (cantidad_solicitada * dato.precio_unitario) monto,codigo_pedido_orden_compra,
        dato.item,numero_expediente,

(select abreviacion from tipo_adjudicacion where codigo = codigo_tipo_adjudicacion) ||' '||
numero || '/'|| anio as licitacion,id_llamado,cantidad_adjudicada,cantidad_minima,cantidad_emitida
from (
select dato.codigo,numero_orden_compra,fecha_orden_compra,dato.codigo_adjudicacion,dato.codigo_proveedor,
(select nombre from laboratorio where codigo= dato.codigo_proveedor) as proveedor,
dato.codigo_medicamento,cantidad_solicitada,dato.precio_unitario,codigo_pedido_orden_compra,dato.item,numero_expediente,
numero,anio,codigo_tipo_adjudicacion,id_llamado,cantidad_adjudicada,cantidad_minima,cantidad_emitida
from (
select dato.codigo,numero_orden_compra,fecha_orden_compra,codigo_adjudicacion,codigo_proveedor,
(select nombre from laboratorio where codigo= codigo_proveedor) as proveedor,
codigo_medicamento,cantidad_solicitada,precio_unitario,codigo_pedido_orden_compra,item,numero_expediente from
(
select oc.codigo,numero_orden_compra,fecha_orden_compra,codigo_adjudicacion,codigo_proveedor,
codigo_medicamento,cantidad_solicitada,precio_unitario,codigo_pedido_orden_compra,item
from (
select *
from orden_compra
where codigo_estado = 2
) as oc
inner join
(
select *
from orden_compra_detalle
) as ocd
on oc.codigo = ocd.codigo_orden_compra
)as dato
left join
(
select *
from orden_compra_pedido
) as pedido
on dato.codigo_pedido_orden_compra = pedido.codigo 
) as dato
inner join
(
select *
from (
	select *
	from adjudicacion
	) as adj
	inner join
	(
	select *
	from detalle_adjudicacion_temporal
	) as dat
	on adj.codigo = dat.codigo_adjudicacion
	) as adj
on adj.codigo = dato.codigo_adjudicacion
and adj.item = dato.item
and  adj.codigo_medicamento = dato.codigo_medicamento
and adj.codigo_proveedor = dato.codigo_proveedor

) as dato";
        return ejecutarConsulta($sql);      
    }
}
 
?>