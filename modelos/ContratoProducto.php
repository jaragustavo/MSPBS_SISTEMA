<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class ContratoProducto

{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
        
       public function actualizar($codigo_llamado,$codigo_proveedor,
                                $codigo_medicamento,$lote,$item,
                                $unidad_medida,$nombre_comercial, $procedencia,
                                $cantidad_minima,$cantidad_adjudicada,
                                $cantidad_emitida, $precio_unitario, 
                                $monto_minimo,$monto_maximo,$monto_emitido,
                                $obs,$codigo_estado_item,
                                $codigo_adjudicacion,$monto_adjudicado,
                                $fecha_adjudicacion,
                                $codigo_contrato,$numero_contrato,
                                $fecha_inicio,$fecha_fin,
                                $numero_entrega,
                                $plazo,$codigo_tipo_dias,
                                $codigo_tipo_descuento_item,
                                $codigo_tipo_plazo,
                                $porcentaje,
                                $porcentaje_complementario)
       {
        
       $monto_adjudicado= str_replace('.','',$monto_adjudicado);
       $cantidad_minima= str_replace('.','',$cantidad_minima);
       $cantidad_adjudicada= str_replace('.','',$cantidad_adjudicada);
       $cantidad_emitida= str_replace('.','',$cantidad_emitida);
       $precio_unitario= str_replace('.','',$precio_unitario); 
       $monto_minimo= str_replace('.','',$monto_minimo);  
       $monto_maximo= str_replace('.','',$monto_maximo); 
                     
       if (empty($codigo_adjudicacion)){     
        
              $sql="INSERT INTO adjudicacion(
                 numero, anio, titulo, monto_adjudicado, fecha_adjudicacion, 
                 codigo_tipo_adjudicacion, codigo_estado_adjudicacion, observacion, 
                 codigo_sucursal, id_llamado, codigo_llamado)
            
             (SELECT  numero,anio,titulo,$monto_adjudicado,'$fecha_adjudicacion',
                      codigo_tipo_llamado, 1,'',1,id_llamado,codigo
              FROM llamado
              WHERE codigo = $codigo_llamado);
              SELECT currval( 'adjudicacion_codigo_seq' )::BIGINT";
              $codigo_adjudicacion = ejecutarConsulta_retornarID($sql); 
       }else {
            $sql="UPDATE adjudicacion
                  SET monto_adjudicado=$monto_adjudicado, 
                 fecha_adjudicacion='$fecha_adjudicacion'
                 WHERE codigo=$codigo_adjudicacion";
            ejecutarConsulta($sql);
           
       }
        // error_log('#######adjudicacion '.$sql);  
         $sql="SELECT coalesce(count(*),0) as cant
            FROM detalle_adjudicacion_temporal
            WHERE codigo_adjudicacion = $codigo_adjudicacion
            AND   codigo_proveedor = $codigo_proveedor
            AND   codigo_medicamento =$codigo_medicamento"; 
      
       //  error_log('#######adjudicacion '.ejecutarConsulta_retornarID($sql));
        if (ejecutarConsulta_retornarID($sql)==0){   
        $sql="INSERT INTO detalle_adjudicacion_temporal(
                     codigo_proveedor,codigo_medicamento,codigo_adjudicacion,lote,item,
                     unidad_medida,nombre_comercial,procedencia,
                     cantidad_minima,cantidad_adjudicada,
                     cantidad_emitida, precio_unitario, 
                     monto_minimo,monto_maximo,monto_emitido,
                     obs,codigo_estado_item)
            VALUES ($codigo_proveedor,$codigo_medicamento,$codigo_adjudicacion,
                    '$lote','$item',
                   '$unidad_medida','$nombre_comercial', '$procedencia',
                    $cantidad_minima,$cantidad_adjudicada,
                    $cantidad_emitida, $precio_unitario, 
                    $monto_minimo,$monto_maximo,$monto_emitido,
                   '$obs',$codigo_estado_item)";
                   ejecutarConsulta($sql);
        }else{
             $sql="UPDATE detalle_adjudicacion_temporal
                   SET precio_unitario=$precio_unitario, cantidad_adjudicada=$cantidad_adjudicada, 
                    nombre_comercial='$nombre_comercial',item='$item', unidad_medida='$unidad_medida', 
                    procedencia='$procedencia', cantidad_emitida=$cantidad_emitida, cantidad_minima=$cantidad_minima, 
                    lote='$lote', monto_minimo=$monto_minimo, 
                    monto_maximo=$monto_maximo, codigo_estado_item=$codigo_estado_item, obs='$obs',
                    monto_emitido=$monto_emitido
              WHERE codigo_adjudicacion = $codigo_adjudicacion
              AND   codigo_proveedor = $codigo_proveedor
              AND   codigo_medicamento =$codigo_medicamento";
            
        }
       ejecutarConsulta($sql);
        
    // error_log('#######detalle_adjudicacion_temporal '.$sql); 
      //   error_log('#######contrato '.$codigo_contrato); 
         if (empty($codigo_contrato)){
            $sql="INSERT INTO contrato(
                 codigo_adjudicacion, numero_contrato, codigo_proveedor, 
                 fecha_inicio, fecha_fin)
                 VALUES ($codigo_adjudicacion, '$numero_contrato', $codigo_proveedor,
                       '$fecha_inicio', '$fecha_fin');";
         }else{
                    $sql=" UPDATE contrato
                           SET codigo_adjudicacion=$codigo_adjudicacion, numero_contrato='$numero_contrato',
                           codigo_proveedor=$codigo_proveedor, 
                           fecha_inicio='$fecha_inicio', fecha_fin='$fecha_fin'
                           WHERE codigo=$codigo_contrato";

             
         }
        
        // error_log('contrato '.$sql);  
          
        ejecutarConsulta_retornarID($sql);  
        
        $sql="delete from detalle_entrega where codigo_medicamento=$codigo_medicamento
              and codigo_proveedor =$codigo_proveedor and codigo_adjudicacion = $codigo_adjudicacion";
        ejecutarConsulta($sql);
            
        $num_elementos = 0;
        $sw = true;
        while ($num_elementos < count($numero_entrega)) {
         
          $sql_detalle = "INSERT INTO detalle_entrega(
                          codigo_proveedor,codigo_medicamento,codigo_adjudicacion, 
                          numero_entrega, plazo, 
                          codigo_tipo_dias, codigo_tipo_descuento_item,
                          codigo_tipo_plazo,
                          porcentaje,
                          porcentaje_complementario)
                VALUES ($codigo_proveedor,$codigo_medicamento,$codigo_adjudicacion,
                        $numero_entrega[$num_elementos],
                        $plazo[$num_elementos],$codigo_tipo_dias[$num_elementos],
                        $codigo_tipo_descuento_item[$num_elementos],
                        $codigo_tipo_plazo[$num_elementos],
                        $porcentaje[$num_elementos],
                        $porcentaje_complementario[$num_elementos])";
               ejecutarConsulta($sql_detalle) or $sw = false;
      
     ///  error_log('#######detalle_entrega '.$sql_detalle);  
          $num_elementos = $num_elementos + 1;
       
        }
        //  error_log('##########$sw '.$sw);
        $num_elementos = 0;
        $sw = true;
        while ($num_elementos < count($codigo_sucursal)) {
         
          $sql_detalle = "INSERT INTO contrato_lugar_entrega(
                            codigo_contrato, codigo_sucursal, codigo_medicamento, 
                            item, lote, cantidad_maxima, cantidad_minima, monto_maximo, monto_minimo, 
                            monto_emitido, cantidad_emitida, codigo_estado, obs)
                            VALUES ($codigo_contrato, $codigo_sucursal[$num_elementos], $codigo_medicamento, 
                                    item, lote, $cantidad_maxima[$num_elementos], $cantidad_minima[$num_elementos], 
                                    $monto_maximo[$num_elementos], $monto_minimo[$num_elementos], 
                                    $monto_emitido[$num_elementos], $cantidad_emitida[$num_elementos], 
                                    1, $obs[$num_elementos])";
                                    
               
               ejecutarConsulta($sql_detalle) or $sw = false;
      
     ///  error_log('#######detalle_entrega '.$sql_detalle);  
          $num_elementos = $num_elementos + 1;
       
        }
        return $sw;
      
    }

    public function listarProducto()
    {
            $sql="SELECT * FROM descripcion_medicamento";
            return ejecutarConsulta($sql);		
    }
     public function listar()
    {
        $sql="select codigo_adjudicacion,licitacion, titulo, 
            monto_adjudicado, fecha_adjudicacion, 
            codigo_estado_adjudicacion, observacion, 
            codigo_sucursal, id_llamado, codigo_llamado,
            precio_unitario, cantidad_adjudicada, dato.codigo_medicamento, producto,
            codigo_proveedor,proveedor, nombre_comercial, item, unidad_medida, procedencia, 
             cantidad_emitida, cantidad_minima, actualizado, lote,  
             monto_minimo, monto_maximo, codigo_estado_item, obs, monto_emitido,codigo_contrataciones from 
 ( 
select codigo_adjudicacion,( (select abreviacion from tipo_adjudicacion where codigo = codigo_tipo_adjudicacion)  ||' '||numero||'/'|| anio) as licitacion, titulo, monto_adjudicado, fecha_adjudicacion, 
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
        ) as dato
        left join
        (select * from rel_medicamento_producto_contrataciones a, producto_contrataciones b 
        where a.codigo_producto_contrataciones = b.codigo and actual = 't') as y
        on y.codigo_medicamento = dato.codigo_medicamento";
        return ejecutarConsulta($sql);      
    }
    
       public function mostrar($codigo_adjudicacion,$codigo_proveedor,$codigo_medicamento)
    {
        $sql="select dato.codigo_adjudicacion,licitacion, titulo, monto_adjudicado, to_char(fecha_adjudicacion,'DD-MM-YYYY') as fecha_adjudicacion, 
       codigo_estado_adjudicacion, observacion,
       codigo_sucursal, id_llamado, codigo_llamado,
       precio_unitario, cantidad_adjudicada, dato.codigo_medicamento, producto,
       dato.codigo_proveedor,proveedor, nombre_comercial, item, unidad_medida, procedencia, 
       cantidad_emitida, cantidad_minima, actualizado, lote,  
       monto_minimo, monto_maximo, codigo_estado_item, dato.obs, monto_emitido,numero_contrato,to_char(fecha_contrato,'DD-MM-YYYY') as fecha_inicio,
       to_char(vigencia,'DD-MM-YYYY') as fecha_fin,codigo as codigo_contrato from 
 ( 
select codigo_adjudicacion,( (select abreviacion from tipo_adjudicacion where codigo = codigo_tipo_adjudicacion)  ||' '||numero||'/'|| anio) as licitacion, titulo, monto_adjudicado, fecha_adjudicacion, 
       (select abreviacion from tipo_adjudicacion where codigo = codigo_tipo_adjudicacion) as abreviacion, codigo_estado_adjudicacion,observacion, 
       adj.codigo_sucursal, id_llamado, coalesce(codigo_llamado,0) as codigo_llamado,
       precio_unitario, coalesce(cantidad_adjudicada,0) as cantidad_adjudicada, codigo_medicamento,(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion 
            from descripcion_medicamento 
             where codigo= codigo_medicamento) as producto,
       (select nombre from laboratorio where codigo =codigo_proveedor) as proveedor,codigo_proveedor, nombre_comercial, item, unidad_medida, procedencia, 
       coalesce(cantidad_emitida,0) as cantidad_emitida, coalesce(cantidad_minima,0) as cantidad_minima, actualizado, lote,  
       coalesce(monto_minimo,0) as monto_minimo, coalesce(monto_maximo,0) as monto_maximo, codigo_estado_item, obs, coalesce(monto_emitido,0) as monto_emitido
        from (select *
        from adjudicacion
        ) as adj
        inner join
        (select * 
        from detalle_adjudicacion_temporal
      where codigo_adjudicacion = $codigo_adjudicacion
      and   codigo_proveedor = $codigo_proveedor
        and   codigo_medicamento = $codigo_medicamento
        ) as adj_det
        on adj.codigo = adj_det.codigo_adjudicacion
        ) as dato
        left join
        (
        select * from contrato
        ) as contrato
       on   contrato.codigo_adjudicacion = dato.codigo_adjudicacion
       and  contrato.codigo_proveedor = dato.codigo_proveedor";
      //  error_log("##############".$sql);
        return ejecutarConsulta($sql);      
    } 
    
    public function selectNumeroEntrega()
    {
        $sql="select * from detalle_entrega";
        return ejecutarConsulta($sql);      
    }
    
     public function mostrarDetalleEntrega($codigo_adjudicacion,$codigo_proveedor,$codigo_medicamento)
    {
        $sql="SELECT codigo, numero_entrega, plazo, codigo_tipo_dias,(select nombre from tipo_dias where codigo = codigo_tipo_dias) as des_tipo_dias, codigo_tipo_descuento_item,
       (select nombre from tipo_descuento_item where codigo = codigo_tipo_descuento_item) as des_tipo_descuento_item, 
       porcentaje, cantidad, codigo_tipo_plazo,(select nombre from tipo_plazo where codigo= codigo_tipo_plazo) as des_tipo_plazo, codigo_adjudicacion, 
       codigo_proveedor, codigo_medicamento
  FROM detalle_entrega
  WHERE codigo_adjudicacion = $codigo_adjudicacion
    AND codigo_proveedor =$codigo_proveedor
    AND codigo_medicamento = $codigo_medicamento";
        return ejecutarConsulta($sql);      
    }
     public  function mostrarAdjudicacion($codigo_llamado)
    {
          $sql="select codigo,monto_adjudicado,to_char (fecha_adjudicacion, 'DD-MM-YYYY') as fecha_adjudicacion from adjudicacion where codigo_llamado = $codigo_llamado";
      //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
    public  function mostrarContrato($codigo_adjudicacion,$codigo_proveedor)
    {
          $sql="select * from contrato where codigo_adjudicacion = $codigo_adjudicacion and codigo_proveedor = $codigo_proveedor";
      //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
    public function listarReactivo()
    {
            $sql="select x.codigo,codigo_contrataciones as codigo_catalogo, producto, trim(coalesce(concentracion, '')||' '||especificaciones_tecnicas) as especificacion_tecnica, presentacion from
(select a.codigo, clasificacion_medicamento as producto, concentracion, forma_farmaceutica as especificaciones_tecnicas, presentacion, codigo_estado from descripcion_medicamento a, medicamento b
where a.codigo = b.codigo and codigo_estado = 1 and a.codigo in (select  b.codigo_medicamento from grupo_medicamento a, rel_medicamento_grupo b
		where a.codigo = b.codigo_grupo
		and b.codigo_grupo= 8 --reactivo--
		group by b.codigo_medicamento, a.codigo)) as x
left join
(select * from rel_medicamento_producto_contrataciones a, producto_contrataciones b 
where a.codigo_producto_contrataciones = b.codigo and actual = 't') as y
on(x.codigo = y.codigo_medicamento) order by producto asc";
            return ejecutarConsulta($sql);		
    }
 
}

?>