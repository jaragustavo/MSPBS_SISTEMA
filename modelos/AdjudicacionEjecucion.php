<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class AdjudicacionEjecucion
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
 //error_log('############ '.$sql);
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
    public function anular($idcodigo,$codigo_medicamento)
    {
        $sql="UPDATE orden_compra_pedido_detalle SET codigo_estado=5 WHERE codigo_orden_compra_pedido='$idcodigo' and codigo_medicamento='$codigo_medicamento' ";
        return ejecutarConsulta($sql);
    }
    public function anularMovimiento($codigo_movimiento,$codigoMovimientoOrigen)
    {
        $sql=" SELECT count(*) from pedido_orden_compra_movimiento where codigo=$codigo_movimiento and fecha_recibo isnull";
     //  error_log('##33 '.$sql);
        $cont= ejecutarConsulta_retornarID($sql);
       
        if ($cont==1){
           $sql="UPDATE pedido_orden_compra_movimiento SET codigo_estado = 2, tiempo_proceso = null where codigo=$codigoMovimientoOrigen;delete from pedido_orden_compra_movimiento WHERE codigo=$codigo_movimiento and fecha_recibo isnull"; 
           return ejecutarConsulta($sql);
        } else {
            return null;
        };
        
        
        //  $sql="delete from pedido_orden_compra_movimiento WHERE codigo=$codigo_movimiento and fecha_recibo isnull";
      //error_log('##33 '.ejecutarConsulta($sql));
     //   
    }
     public function listarJson()
    {
        $sql="select * from laboratorio";
        
      // error_log('##########33 '.$sql);
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
       --    CAST(to_char(GREATEST(tiempo_proceso,fecha_recibo) - fecha_envio,'DD') as integer) || ' Días ' || cast(to_char(GREATEST(tiempo_proceso,fecha_recibo) - fecha_envio,'HH24') as integer) || ' Horas '
  FROM pedido_orden_compra_movimiento
  WHERE codigo_pedido_orden_compra='$idcodigo' and codigo_medicamento='$codigo_medicamento' order by codigo";
        
    // error_log('##########33 '.$sql);
        return ejecutarConsulta($sql);
    }
    public function listarDetalle($idcodigo,$codigo_medicamento)
    {
        $sql="select ocp.codigo,numero_expediente,fecha_pedido,codigo_medicamento,(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion from descripcion_medicamento 
              where codigo= codigo_medicamento) as producto,stock,dmp,cantidad,meses_cantidad,ocpd.codigo_estado,obs 
              from (
              select * from orden_compra_pedido ) as ocp
              inner join
              (select * from orden_compra_pedido_detalle ) as ocpd
              on ocp.codigo = ocpd.codigo_orden_compra_pedido
              and ocp.codigo=$idcodigo and codigo_medicamento=$codigo_medicamento";
        return ejecutarConsulta($sql);
    }
 
    //Implementar un método para listar los registros
    public function listar()
    {
        /// selecciona desde una vista
        $sql="select ejecucion.id_llamado , llamado,proveedor,ejecucion.codigo_proveedor ,ejecucion.codigo_medicamento,producto,
        ejecucion.item,monto_maximo,monto_emitido,saldo,ejecucion.cantidad_adjudicada,precio_unitario,cantidad_minima,ejecucion.cantidad_emitida,
        cant_recepcionada,cant_distribuida,porcentaje,disponibilidad_saldo_reservado,ejecucion.observacion,
        adenda.cantidad_solicitada,porcentaje_solicitado,
        cantidad_emitida_ampliacion,porcentaje_ampliacion_emitido,
        codigo_estado_item,(select nombre from estado_item where codigo = codigo_estado_item) as estado_item

         from 
        (
           select * from ejecucion
         --  where codigo_medicamento = 2191
        ) as ejecucion

        left join
        (
           select * from adenda
        ) as adenda
        on ejecucion.id_llamado = adenda.id_llamado
        and ejecucion.codigo_proveedor = adenda.codigo_proveedor
        and ejecucion.codigo_medicamento = adenda.codigo_medicamento
        and ejecucion.item = adenda.item";
        return ejecutarConsulta($sql);      
    }
}
?>