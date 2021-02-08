<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class SolicitudCvp
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
        public function mostrarEditar($idcodigo)
    {
        $sql="select * from solicitud_cvp where codigo = $idcodigo";
        return ejecutarConsultaSimpleFila($sql);
    }
 
    //Implementamos un método para insertar registros
    public function insertar($login,$nombre,$fecha,$codigo_orden_compra,$codigo_medicamento,$plurianual,$obs)
    {
        $sql="INSERT INTO solicitud_cvp (login,nombre,fecha,codigo_estado)
        VALUES ('$login','$nombre','$fecha',1);select currval( 'solicitud_cvp_codigo_seq' )::BIGINT;";
        //return ejecutarConsulta($sql);
        
       
        $idcodigonew=ejecutarConsulta_retornarID($sql);

      error_log('insertar ########## '.$sql); 
        
        $num_elementos=0;
        $sw=true;
 
        while ($num_elementos < count($codigo_orden_compra))
        {
            $sql_detalle = "INSERT INTO solicitud_cvp_detalle"
                    . "(codigo_solicitud_cvp,codigo_orden_compra,codigo_medicamento,plurianual,obs) "
                    . "VALUES ($idcodigonew,$codigo_orden_compra[$num_elementos],$codigo_medicamento[$num_elementos],'$plurianual[$num_elementos]','$obs[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
          //   error_log('CONTROL EMISION ########## '.$sql_detalle);
        }
 
        return $sw;
    }
   public function modificar($codigo_solicitud_cvp,$login,$nombre,$fecha,$codigo_orden_compra,$codigo_medicamento,$plurianual,$obs)
    {
      $sql="update solicitud_cvp "
          . "set fecha = '$fecha' where codigo = $codigo_solicitud_cvp;"
          . "DELETE FROM solicitud_cvp_detalle WHERE codigo_solicitud_cvp = $codigo_solicitud_cvp;";
 
       
       ejecutarConsulta($sql);

       // error_log('modificar ##########  '.$sql); 
        
        $num_elementos=0;
        $sw=true;
 
        while ($num_elementos < count($codigo_orden_compra))
        {
             
            $sql_detalle = "INSERT INTO solicitud_cvp_detalle"
                    . "(codigo_solicitud_cvp,codigo_orden_compra,codigo_medicamento,plurianual,obs) "
                    . "VALUES ($codigo_solicitud_cvp,$codigo_orden_compra[$num_elementos],$codigo_medicamento[$num_elementos],'$plurianual[$num_elementos]','$obs[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
        //    error_log('CONTROL EMISION ########## '.$sql_detalle);
        
        }
 
        return $sw;
    }
     
    //Implementamos un método para anular categorías
    public function anular($idcodigo)
    {
        $sql="UPDATE solicitud_cvp SET codigo_estado=2 WHERE codigo=$idcodigo";
        return ejecutarConsulta($sql);
    }
 
 
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idingreso)
    {
        $sql="SELECT i.idingreso,DATE(i.fecha_hora) as fecha,i.idproveedor,p.nombre as proveedor,u.idusuario,u.nombre as usuario,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE i.idingreso='$idingreso'";
        return ejecutarConsultaSimpleFila($sql);
    }
 
  public function listarDetalle($idcodigo)
    {
        $sql="select ced.codigo,numero_orden_compra,fecha_orden_compra,(select nombre from laboratorio where codigo = codigo_proveedor) as proveedor,
       codigo_medicamento,(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion
       from descripcion_medicamento 
         where codigo= codigo_medicamento) as producto,monto_total,obs,plurianual,ced.codigo_orden_compra 
from (
select *
from solicitud_cvp_detalle
) as ced
inner join
(
select *
from orden_compra
) as oc
on ced.codigo_orden_compra = oc.codigo
and ced.codigo_solicitud_cvp = $idcodigo order by ced.codigo";
        
      
        return ejecutarConsulta($sql);
    }  
 
    //Implementar un método para listar los registros
    public function listar()
    {
        $sql="select distinct codigo_solicitud_cvp,dato.codigo as codigo_orden_compra,numero_orden_compra,fecha_orden_compra,
dato.codigo_adjudicacion,dato.codigo_proveedor,
(select nombre from laboratorio where codigo= dato.codigo_proveedor) as proveedor,
dato.codigo_medicamento,
	(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion 
	from descripcion_medicamento 
         where codigo= dato.codigo_medicamento) as producto,
         (cantidad_solicitada * dato.precio_unitario) monto,
         codigo_pedido_orden_compra,dato.item,numero_expediente,

(select abreviacion from tipo_adjudicacion where codigo = codigo_tipo_adjudicacion) ||' '||
numero || '/'|| anio as licitacion,id_llamado,cantidad_adjudicada,cantidad_minima,cantidad_emitida,to_char(fecha,'DD/MM/YYYY') as fecha,plurianual,obs,titulo
from (
select dato.codigo,numero_orden_compra,fecha_orden_compra,dato.codigo_adjudicacion,dato.codigo_proveedor,
(select nombre from laboratorio where codigo= dato.codigo_proveedor) as proveedor,
dato.codigo_medicamento,cantidad_solicitada,dato.precio_unitario,codigo_pedido_orden_compra,dato.item,numero_expediente,
numero,anio,codigo_tipo_adjudicacion,id_llamado,cantidad_adjudicada,cantidad_minima,cantidad_emitida,titulo
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
   from solicitud_cvp
   where codigo_estado = 1
   ) as ce
   inner join
   (
   select *
   from solicitud_cvp_detalle
   ) as ced
   on ce.codigo = ced.codigo_solicitud_cvp
--   and codigo_orden_compra = 364
) as ce
on dato.codigo = ce.codigo_orden_compra
and dato.codigo_medicamento = ce.codigo_medicamento";
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