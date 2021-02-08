<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class Contrato
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
  
 
      public function enviar($idcodigo,$idusuario, $destinatario,$obs_envio,$codigo_lugar_envio,$imagenEnvio,$codigo_estado_envio)
    {
         $sql=" select cast(to_char(now()-fecha,'DD') as integer) ||' Dias '|| cast(to_char(now()-fecha,'HH24') as integer) ||' Horas'
                from sirh_resolucion_movimiento
                where codigo in(
                select max(codigo)
                from sirh_resolucion_movimiento
                where codigo_resolucion = $idcodigo)"; 
         
         $tiempoProceso=ejecutarConsulta_retornarID($sql); 
        
        // error_log("######### ".$tiempoProceso);
        $sql="INSERT INTO sirh_resolucion_movimiento(
                codigo_resolucion, fecha, idusuario, 
                imagen_envio,obs_envio,codigo_estado,
                destinatario,tiempo_proceso)
                VALUES ($idcodigo, now(),$idusuario,
                        '$imagenEnvio','$obs_envio',$codigo_estado_envio,
                         $destinatario,'$tiempoProceso');
                select currval( 'sirh_resolucion_movimiento_codigo_seq' )::BIGINT;";
        
      // error_log('############AGREGARPEDIDO '.$sql);
        
        $codigoResolucionMovimiento=ejecutarConsulta_retornarID($sql);  
          
        $num_elementos=0;
        $sw=true;
      
        while ($num_elementos < count($codigo_lugar_envio))
        {
            $sql_detalle = "INSERT INTO sirh_resolucion_movimiento_cc(
                            codigo_resolucion_movimiento, codigo_lugar_envio)
                            VALUES ($codigoResolucionMovimiento,'$codigo_lugar_envio[$num_elementos]')";
         
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
           
        }
        $sql="UPDATE sirh_resolucion
        SET codigo_estado= $codigo_estado_envio, destinatario = $destinatario
        WHERE codigo = $idcodigo;";
        ejecutarConsulta($sql);    
 
        return $sw;
    }     
          
          
    //Implementamos un método para insertar registros
    public function insertar( $numero_expediente,
                              $codigo_dependencia,
                              $numero_documento,
                              $item,
                              $nombre_apellido,
                              $codigo_tipo_resolucion,
                              $codigo_tipo_resolucion_concepto,
                              $codigo_objeto_gasto,
                              $codigo_ubicacion_prestacion,
                              $salario,
                              $carga_horario,
                              $cargo_funcion,
                              $codigo_region_sanitaria,
                              $cantidad_especialidad,
                         //     $fecha_inicio,
                     //         $fecha_fin,
                              $vin,
                              $estado,
                              $fecha_pedido,
                              $idusuario,
                              $cic_reemplazante,
                              $nombre_reemplazante)
            
    {
     
      
       $sql="INSERT INTO sirh_resolucion(
                                numero_expediente,codigo_dependencia,
                                codigo_tipo_resolucion, 
                                codigo_tipo_resolucion_concepto,
                                codigo_estado,
                                fecha_pedido,
                                usuario_pedido)
                                VALUES ('$numero_expediente',$codigo_dependencia,
                                $codigo_tipo_resolucion,
                                $codigo_tipo_resolucion_concepto,
                                1,
                                '$fecha_pedido','$idusuario');select currval( 'sirh_resolucion_codigo_seq' )::BIGINT;";
       //return ejecutarConsulta($sql);
//error_log('############AGREGAR'.$sql);
        
       $idresolucionnew=ejecutarConsulta_retornarID($sql);
              
        
    // error_log('############AGREGAR'. count($numero_documento));
        $num_elementos=0;
        $sw=true;
 
     
        while ($num_elementos < count($numero_documento))
        {
            // $precio_referencial[$num_elementos] = !empty($precio_referencial[$num_elementos]) ? str_replace('.','', $precio_referencial[$num_elementos]) : 0;
            // $cantidad[$num_elementos] = !empty($cantidad[$num_elementos]) ? str_replace('.','', $cantidad[$num_elementos]) : 0;
              $salario[$num_elementos] = !empty($salario[$num_elementos]) ? str_replace('.','', $salario[$num_elementos]) : 0;
              $sql_detalle = "INSERT INTO sirh_resolucion_detalle(codigo_resolucion,
                                numero_item,
                                numero_documento,nombre_apellido,codigo_objeto_gasto,
                                codigo_ubicacion_prestacion, salario, carga_horaria, 
                                cargo_funcion,  codigo_region_sanitaria,
                                cantidad_especialidad, vin,codigo_estado,
                                cic_reemplazante,nombre_reemplazante
                                )
                                VALUES ($idresolucionnew,
                               $item[$num_elementos],
                              '$numero_documento[$num_elementos]',
                              '$nombre_apellido[$num_elementos]',
                               $codigo_objeto_gasto[$num_elementos],
                               $codigo_ubicacion_prestacion[$num_elementos],
                               $salario[$num_elementos],
                              '$carga_horario[$num_elementos]',
                               $cargo_funcion[$num_elementos],
                               $codigo_region_sanitaria[$num_elementos],     
                               $cantidad_especialidad[$num_elementos],
                               $vin[$num_elementos],
                             
                               $estado[$num_elementos],
                               '$cic_reemplazante[$num_elementos]',
                               '$nombre_reemplazante[$num_elementos]'   


                               )";
       //     error_log('############AGREGARPEDIDO'.$sql_detalle);
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
           
        }
        
        return $sw;
     
    }
    public function modificar($idcodigo,
                              $numero_expediente,
                              $codigo_dependencia,
                              $numero_documento,
                              $item,
                              $nombre_apellido,
                              $codigo_tipo_resolucion,
                              $codigo_tipo_resolucion_concepto,
                              $codigo_objeto_gasto,
                              $codigo_ubicacion_prestacion,
                              $salario,
                              $carga_horario,
                              $cargo_funcion,
                              $codigo_region_sanitaria,
                              $cantidad_especialidad,
                           ///   $fecha_inicio,
                         //     $fecha_fin,
                              $vin,
                            //  $vin2,
                            //  $sinar,
                            //  $obs,
                              $estado,
                              $fecha_pedido,
                              $idusuario,
                              $cic_reemplazante,
                              $nombre_reemplazante)
    {
        
        
        
        $sql="UPDATE sirh_resolucion
              SET  numero_expediente='$numero_expediente', 
                   codigo_dependencia = $codigo_dependencia,
                   codigo_tipo_resolucion=$codigo_tipo_resolucion, 
                   codigo_tipo_resolucion_concepto=$codigo_tipo_resolucion_concepto,
                   fecha_pedido='$fecha_pedido', usuario_pedido='$idusuario'
               WHERE codigo = $idcodigo ;delete from sirh_resolucion_detalle where codigo_resolucion=$idcodigo;";
        ejecutarConsulta($sql);      
//error_log('############AGREGAR'.$sql);
        $num_elementos=0;
        $sw=true;
 
         while ($num_elementos < count($numero_documento))
        {
              $salario[$num_elementos] = !empty($salario[$num_elementos]) ? str_replace('.','', $salario[$num_elementos]) : 0;
            // $precio_referencial[$num_elementos] = !empty($precio_referencial[$num_elementos]) ? str_replace('.','', $precio_referencial[$num_elementos]) : 0;
            // $cantidad[$num_elementos] = !empty($cantidad[$num_elementos]) ? str_replace('.','', $cantidad[$num_elementos]) : 0;
              $sql_detalle = "INSERT INTO sirh_resolucion_detalle(codigo_resolucion,
                                numero_item,
                                numero_documento,nombre_apellido,codigo_objeto_gasto,
                                codigo_ubicacion_prestacion, salario, carga_horaria, 
                                cargo_funcion,  codigo_region_sanitaria,
                                cantidad_especialidad, vin,codigo_estado,
                                cic_reemplazante,nombre_reemplazante
                                )
                                VALUES ($idcodigo,
                               $item[$num_elementos],
                              '$numero_documento[$num_elementos]',
                              '$nombre_apellido[$num_elementos]',
                               $codigo_objeto_gasto[$num_elementos],
                               $codigo_ubicacion_prestacion[$num_elementos],
                               $salario[$num_elementos],
                              '$carga_horario[$num_elementos]',
                               $cargo_funcion[$num_elementos],
                               $codigo_region_sanitaria[$num_elementos],     
                               $cantidad_especialidad[$num_elementos],
                               $vin[$num_elementos],
                             
                               $estado[$num_elementos],
                               '$cic_reemplazante[$num_elementos]',
                               '$nombre_reemplazante[$num_elementos]' )";
       // error_log('############AGREGARPEDIDO'.$sql_detalle);
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
           
        }
        
        return $sw;
    }
 
   public function listarLugarEnvio($idusuario)
    {
        $sql="select * from dependencia_msp where codigo in 
                                             (select codigo_dependencia 
                                              from usuario_dependencia 
                                              where indicador_estado = 'AC'
                                              and   idusuario != $idusuario)";
        
     // error_log('##########33 '.$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
    public function anularPedido($idpedido)
    {
        $sql="UPDATE pedido_producto
        SET codigo_estado=5
        WHERE codigo = $idpedido";
        return ejecutarConsulta($sql);
     
    }
    
    
   
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idcodigo)
    {
        $sql="SELECT codigo, numero_expediente, numero_resolucion,
                     codigo_dependencia,
              codigo_tipo_resolucion, codigo_tipo_resolucion_concepto
            --  to_char (fecha_inicio , 'DD-MM-YYYY') as fecha_inicio, 
            --  to_char (fecha_fin , 'DD-MM-YYYY') as fecha_fin
              FROM sirh_resolucion
              where  codigo =$idcodigo";
        
     //error_log('##########33 '.$sql);
        return ejecutarConsulta($sql);  
    }
     public function mostrarEnviar($idcodigo)
    {
        $sql="SELECT codigo, numero_expediente, numero_resolucion,
              codigo_tipo_resolucion, codigo_tipo_resolucion_concepto,
              codigo_dependencia,
              to_char (fecha_inicio , 'DD-MM-YYYY') as fecha_inicio, 
              to_char (fecha_fin , 'DD-MM-YYYY') as fecha_fin
              FROM sirh_resolucion
              where  codigo =$idcodigo";
        
    //  error_log('##########33 '.$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
    
      public function obtenerDependencia($codigo_sirh)
    {
        $sql="SELECT * FROM dependencia_msp
       where  codigo_sirh =$codigo_sirh";
        
    //  error_log('##########33 '.$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
      public function obtenerPersona($numero_cedula)
    {
        $sql="SELECT * FROM paciente
       where  cedula_identidad =$numero_cedula";
        
   // error_log('##########33 '.$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
    public function mostrarDetalle($idcodigo)
    {
        $sql="SELECT codigo, codigo_resolucion,numero_item, numero_documento, nombre_apellido, 
                    codigo_objeto_gasto, (select descripcion from objeto_gasto where codigo = codigo_objeto_gasto) as descripcion_objeto_gasto,
                    codigo_ubicacion_prestacion,(select nombre from dependencia_msp where codigo = codigo_ubicacion_prestacion) as dependencia_msp,
                    salario, carga_horaria, 
                    cargo_funcion, codigo_region_sanitaria,
                    cantidad_especialidad,vin, 
                    sinar, obs, codigo_estado,cic_reemplazante,nombre_reemplazante
                    FROM sirh_resolucion_detalle
                    WHERE codigo_resolucion = $idcodigo
                    order by codigo_resolucion,numero_item";
        
     // error_log('##########33 '.$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
    
     public function verMovimiento($idcodigo)
    {
        $sql="select codigo_resolucion,to_char(fecha,'DD-MM-YYYY') as fecha_envio,
                (select nombres ||','||apellidos from usuario where cedula_identidad = cast(idusuario as integer)) as remitente,obs_envio,
                 (select nombres ||','||apellidos from usuario where cedula_identidad = cast(destinatario as integer)) as destinatario,
              imagen_envio,coalesce(tiempo_proceso,'---') as tiempo_proceso,(select descripcion from estado_pedido where codigo=codigo_estado) as  estado
              from sirh_resolucion_movimiento
              where codigo_resolucion = $idcodigo
              order by codigo";
        
    ///    error_log('######### '.$sql);
        return ejecutarConsulta($sql);
    }
 public function verVinculo($numero_cedula)
    {
        $sql="select * from vinculo
              where numero_cedula = '$numero_cedula'";
        
    ///    error_log('######### '.$sql);
        return ejecutarConsulta($sql);
    }
    public function verEspecialidad($numero_cedula)
    {
        $sql="select * from especialidad_persona where numero_cedula = '$numero_cedula' and codigo_especialidad is not null";
        
    ///    error_log('######### '.$sql);
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
        $sql="select numero_item,
       reso.codigo as codigo, numero_expediente, numero_resolucion, codigo_tipo_resolucion, (SELECT nombre FROM tipo_resolucion WHERE codigo = codigo_tipo_resolucion ) as des_tipo_resolucion,
       codigo_tipo_resolucion_concepto,(SELECT nombre FROM tipo_resolucion_concepto WHERE codigo = codigo_tipo_resolucion_concepto ) as des_tipo_resolucion_concepto,
       to_char (fecha_fin , 'DD-MM-YYYY') as fecha_fin, to_char (fecha_inicio , 'DD-MM-YYYY') as fecha_inicio,
       reso.codigo_estado as codigo_estado, fecha_pedido, usuario_pedido, destinatario,
       codigo_resolucion, numero_documento, nombre_apellido, 
       codigo_region_sanitaria,(select nombre from region_sanitaria where codigo = codigo_region_sanitaria) as nombre_region_sanitaria,
       codigo_objeto_gasto,(select descripcion from objeto_gasto where codigo = codigo_objeto_gasto) as descripcion_objeto_gasto, 
       codigo_ubicacion_prestacion,(select nombre from dependencia_msp where codigo = codigo_ubicacion_prestacion) as ubicacion_prestacion,
       salario, carga_horaria, 
       cargo_funcion,(select descripcion from funcion where codigo = cargo_funcion) as descripcion_cargo,
       cantidad_especialidad,  vin, 
       sinar, reso_det.obs as obs, reso_det.codigo_estado as codigo_estado_detalle
       
from 
(
select * from sirh_resolucion) as reso
inner join
(
select * from sirh_resolucion_detalle
) as reso_det
on reso.codigo = reso_det.codigo_resolucion
order by reso.codigo,numero_item asc";
     //  error_log('######### '.$sql);
       return ejecutarConsulta($sql);      
    }
     public  function selectTipoResolucion()
    {
          $sql="select * from tipo_resolucion order by codigo";
          
        return ejecutarConsultaSimpleFila($sql);
    }
    public  function selectTipoResolucionConcepto()
    {
          $sql="select * from tipo_resolucion_concepto order by codigo";
          
        return ejecutarConsultaSimpleFila($sql);
    }
    
     public  function contarVinculo($numero_cedula)
    {
          $sql="select coalesce(count(codigo),0) as cantidad_vinculo from vinculo
where numero_cedula = '$numero_cedula'";
          
        return ejecutarConsultaSimpleFila($sql);
    }
     public  function contarEspecialidad($numero_cedula)
    {
          $sql="select coalesce(count(numero_cedula),0) as cantidad_especialidad from especialidad_persona
where numero_cedula = '$numero_cedula' and codigo_especialidad is not null";
          
        return ejecutarConsultaSimpleFila($sql);
    }
    public  function selectDepenciaMsp()
    {
          $sql="select codigo,codigo || '-' || nombre as nombre from dependencia_msp order by codigo";
          
        return ejecutarConsultaSimpleFila($sql);
    }
     public  function selectEspecialidadPersona($numero_cedula)
    {
           $sql="select * from especialidad_persona where numero_cedula = '$numero_cedula' and codigo_especialidad is not null";
           //error_log('######### '.$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
     public  function selectObjetoGasto()
    {
          $sql="select codigo, codigo || '-' || descripcion as descripcion from objeto_gasto order by codigo";
          
        return ejecutarConsultaSimpleFila($sql);
    }
    public  function selectRegionSanitaria()
    {
          $sql="select codigo, codigo || '-' || nombre as nombre from region_sanitaria order by codigo";
          
        return ejecutarConsultaSimpleFila($sql);
    }
       public  function selectFuncion()
    {
          $sql="select codigo, codigo || '-' || descripcion as descripcion from funcion order by codigo";
          
        return ejecutarConsultaSimpleFila($sql);
    }
     
}
   
?>