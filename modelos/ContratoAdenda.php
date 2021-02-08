<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class ContratoAdenda

{
	//Implementamos nuestro constructor
	public function __construct()
	{
	}
        public function insertar($simese, $fecha_pedido, $fecha_vigencia, 
                             $fecha_adenda, $codigo_proveedor, $codigo_medicamento, 
                             $item, $lote, $cantidad_adjudicada, $cantidad_solicitada, 
                             $cantidad_emitida_ampliacion,$precio, 
                             $monto_ampliado, $porcentaje_solicitado, $observacion, 
                             $codigo_estado_item, $codigo_sucursal_origen,
                             $codigo_adjudicacion,$codigo_llamado)
                        {
        $sql="INSERT INTO adenda(
                                simese, fecha_pedido, fecha_vigencia, 
                                fecha_adenda, codigo_proveedor, codigo_medicamento, 
                                item, lote, cantidad_adjudicada, cantidad_solicitada, 
                                cantidad_emitida_ampliacion, porcentaje_ampliacion_emitido, precio, 
                                monto_ampliado, porcentaje_solicitado, observacion, 
                                codigo_estado_item, codigo_sucursal_origen,codigo_llamado)
                        VALUES ('$simese', '$fecha_pedido', '$fecha_vigencia', 
                                '$fecha_adenda', $codigo_proveedor, $codigo_medicamento, 
                                '$item', '$lote', $cantidad_adjudicada, $cantidad_solicitada, 
                                $cantidad_emitida_ampliacion, 0, $precio, 
                                $monto_ampliado, $porcentaje_solicitado, '$observacion', 
                                $codigo_estado_item, $codigo_sucursal_origen,$codigo_llamado
                                );select currval( 'adenda_codigo_seq' )::BIGINT;";
                          //          error_log('******'.$sql);
        $codigo_adenda=ejecutarConsulta_retornarID($sql);
        $sql="UPDATE detalle_adjudicacion_temporal SET
                codigo_adenda=$codigo_adenda, codigo_estado_item = $codigo_estado_item , cantidad_adjudicada = cantidad_adjudicada + $cantidad_solicitada
                WHERE codigo_adjudicacion = $codigo_adjudicacion
                AND   codigo_proveedor    = $codigo_proveedor
                AND   codigo_medicamento  = $codigo_medicamento
                AND   item                = '$item'
               ";
        return ejecutarConsulta($sql);
        
        
      //  error_log("##############".$sql);
        return ejecutarConsulta($sql);
    }
 
    //Implementamos un método para editar registros
    public function editar($simese, $fecha_pedido, $fecha_vigencia, 
                           $fecha_adenda, $cantidad_solicitada, 
                           $cantidad_emitida_ampliacion,$precio, 
                           $monto_ampliado, $porcentaje_solicitado, $observacion, 
                           $codigo_estado_item, $codigo_sucursal_origen,$codigo
                           )
    {
        $sql="UPDATE adenda
              SET simese='$simese', fecha_pedido='$fecha_pedido', fecha_vigencia='$fecha_vigencia', fecha_adenda='$fecha_adenda', 
                  cantidad_solicitada=$cantidad_solicitada,cantidad_emitida_ampliacion=$cantidad_emitida_ampliacion, 
                  porcentaje_ampliacion_emitido=$cantidad_emitida_ampliacion,precio=$precio, monto_ampliado=$monto_ampliado, 
                  porcentaje_solicitado=$porcentaje_solicitado, observacion='$observacion', 
                  codigo_estado_item=$codigo_estado_item, codigo_sucursal_origen=$codigo_sucursal_origen 
                  
              WHERE codigo = $codigo;";
        ejecutarConsulta($sql);
        
        if ($codigo_estado_item == 5) {
            $sql="UPDATE detalle_adjudicacion_temporal a SET
                        codigo_adenda=0, codigo_estado_item = 1 , cantidad_adjudicada = a.cantidad_adjudicada - b.cantidad_solicitada
                FROM adenda b
                WHERE  a.codigo_adenda = b.codigo
                AND    a.codigo_adenda = $codigo;";
            
        }else {
             $sql="UPDATE detalle_adjudicacion_temporal a SET
                       codigo_estado_item = 1 , cantidad_adjudicada = a.cantidad_adjudicada - b.cantidad_solicitada + $cantidad_solicitada
                   FROM adenda b
                   WHERE  a.codigo_adenda = b.codigo
                   AND    a.codigo_adenda = $codigo;";   
            
        }
            
    
   error_log("##############".$sql);
        
        return ejecutarConsulta($sql);
    }
    
    

    public function listarProductoContrato($codigo_adjudicacion,$codigo_proveedor)
    {
            $sql="select lote,item,codigo_medicamento,(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion 
             from descripcion_medicamento 
             where codigo= codigo_medicamento) as producto, precio_unitario,cantidad_adjudicada, 
             nombre_comercial,  unidad_medida, procedencia, 
             cantidad_emitida, cantidad_minima,  
             monto_minimo, monto_maximo, codigo_estado_item, obs, monto_emitido
             from (select *
             from adjudicacion
             where codigo_sucursal = 1
             and   codigo_estado_adjudicacion = 1
             ) as adj
             inner join
             (select * 
             from detalle_adjudicacion_temporal
             ) as adj_det
             on adj.codigo = adj_det.codigo_adjudicacion
             and (adj_det.codigo_adenda is null or adj_det.codigo_adenda = 0)
           and adj_det.codigo_adjudicacion = $codigo_adjudicacion
           AND adj_det.codigo_proveedor    = $codigo_proveedor
                   ";
     //error_log("##############".$sql);
            return ejecutarConsulta($sql);		
    }
     public function listar()
    {
        $sql="select codigo,adj.id_llamado,licitacion,proveedor,simese, origen, mesa_entrada_dgoc, fecha_conformidad_dggies, 
       fecha_conformidad_proveedor, 
       contrato, fecha_pedido, fecha_vigencia, fecha_adenda, 
       adj.codigo_proveedor, 
       adj.codigo_medicamento,(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion 
            from descripcion_medicamento 
             where codigo= adj.codigo_medicamento) as producto,adj.item, adj.lote, adj.cantidad_adjudicada,adj.cantidad_emitida,cantidad_solicitada, 
       cantidad_emitida_ampliacion, porcentaje_ampliacion_emitido, precio_unitario, porcentaje_solicitado, 
       monto_ampliado, porcentaje_solicitado,
       adenda.codigo_estado_item, (select nombre from estado_item where codigo = adenda.codigo_estado_item) as estado,adj.codigo_adjudicacion from
(
select * from adenda
) as adenda
inner join
(
       select codigo_adenda,codigo_adjudicacion,( (select abreviacion from tipo_adjudicacion where codigo = codigo_tipo_adjudicacion)  ||' '||numero||'/'|| anio) as licitacion, titulo, monto_adjudicado, fecha_adjudicacion, 
       (select abreviacion from tipo_adjudicacion where codigo = codigo_tipo_adjudicacion) as abreviacion, codigo_estado_adjudicacion, observacion, 
       adj.codigo_sucursal, id_llamado, codigo_llamado,
       precio_unitario, cantidad_adjudicada, codigo_medicamento,(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion 
            from descripcion_medicamento 
             where codigo= codigo_medicamento) as producto,
       (select nombre from laboratorio where codigo =codigo_proveedor) as proveedor,codigo_proveedor, nombre_comercial, item, unidad_medida, procedencia, 
       cantidad_emitida, cantidad_minima, actualizado, lote, 
       monto_minimo, monto_maximo, codigo_estado_item, obs, monto_emitido
        from (select *
        from adjudicacion
        where codigo_sucursal = 1
        ) as adj
        left join
        (select * 
        from detalle_adjudicacion_temporal
        ) as adj_det
        on adj.codigo = adj_det.codigo_adjudicacion
) as adj
on adenda.codigo = adj.codigo_adenda";
        return ejecutarConsulta($sql);      
    }
    
       public function mostrar($codigo_adenda)
    {
        $sql="select codigo, simese, origen, mesa_entrada_dgoc, fecha_conformidad_dggies, 
       fecha_conformidad_proveedor, det_adj.codigo_adjudicacion, id_llamado,    
        contrato, fecha_pedido, fecha_vigencia, fecha_adenda, adenda.codigo_proveedor,adenda.codigo_medicamento, 
        producto,   
       cantidad_solicitada,  
       cantidad_emitida_ampliacion, porcentaje_ampliacion_emitido, precio,  
       monto_ampliado, porcentaje_solicitado, observacion, 
       fecha_ultmovimiento_simese,   adenda.codigo_estado_item, codigo_sucursal_origen, codigo_llamado,
       cantidad_emitida,det_adj.lote,det_adj.item,det_adj.cantidad_adjudicada as cantidad_adjudicada  
       from (

        SELECT codigo, simese, origen, mesa_entrada_dgoc, fecha_conformidad_dggies, 
       fecha_conformidad_proveedor, codigo_adjudicacion, id_llamado,    
           contrato, fecha_pedido, fecha_vigencia, fecha_adenda, codigo_proveedor,  
                 codigo_medicamento, (select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion             from descripcion_medicamento              where codigo= codigo_medicamento) as producto,   
                 cantidad_solicitada,  
                 cantidad_emitida_ampliacion, porcentaje_ampliacion_emitido, precio,  
                 monto_ampliado, porcentaje_solicitado, observacion, 
                 fecha_ultmovimiento_simese,   codigo_estado_item, codigo_sucursal_origen, codigo_llamado  
            FROM adenda  
           ) as adenda
           inner join 
           (
            select * from detalle_adjudicacion_temporal
            ) as det_adj
            on  adenda.codigo = det_adj.codigo_adenda
            and adenda.codigo =  $codigo_adenda";
    //error_log("##############".$sql);
        return ejecutarConsulta($sql);      
    } 
    
   
    
     public  function obtenerAdjudicacion($codigo_llamado)
    {
          $sql="select codigo,monto_adjudicado,to_char (fecha_adjudicacion, 'DD-MM-YYYY') as fecha_adjudicacion from adjudicacion where codigo_llamado = $codigo_llamado";
      //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
 
   
 
}

?>