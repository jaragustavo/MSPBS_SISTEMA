<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class OrdenCompraActualizarFecha
{
    //Implementamos nuestro constructor
    public function __construct()
    {
    }

    //Implementamos un método para actualizar fecha de orden de compra
    public function actualizarFecha(
        $codigo,
        $fecha_recepcion_oc_proveedor,
        $fecha_envio_correo,
        $plazo_entrega,
        $imagen,
        $dia_habil,
        $tipo_plazo,
        $obs_auditoria,
        $id,
        $fecha_auditoria,
        $numero_orden_compra,
        $codigo_estado
    ) {
         if($fecha_envio_correo == ''){
            $fecha_envio_correo = 'null';
            $fecha_recepcion_oc_proveedor = "'".$fecha_recepcion_oc_proveedor."'";
         }elseif ($fecha_recepcion_oc_proveedor == '') {
            $fecha_recepcion_oc_proveedor = 'null';
            $fecha_envio_correo = "'".$fecha_envio_correo."'"; 
            // error_log('entre');
         } else  {  
             $fecha_recepcion_oc_proveedor = "'".$fecha_recepcion_oc_proveedor."'";
             $fecha_envio_correo = "'".$fecha_envio_correo."'";
         }
        
        $sql = "UPDATE orden_compra 
            set fecha_envio_correo = $fecha_envio_correo, fecha_recepcion_oc_proveedor = 
            $fecha_recepcion_oc_proveedor, plazo_entrega = '$plazo_entrega', imagen = '$imagen',
            es_dia_habil='$dia_habil', tipo_plazo=$tipo_plazo where codigo='$codigo';";

        $sql_2 = "INSERT INTO orden_compra_auditoria(
            codigo_orden_compra, usuario, fecha_hora, codigo_accion, 
            observacion, valor_anterior)
            VALUES ($codigo,$id,'$fecha_auditoria',23,'$obs_auditoria','Numero OC: '|| '$numero_orden_compra ' || 
            ' Fecha Envio Correo: '|| '$fecha_envio_correo ' ||
            ' Fecha Recep. Proveedor: '|| '$fecha_recepcion_oc_proveedor ' ||
            ' Plazo Entrega: '|| '$plazo_entrega ' || ' Es Dia Habil: '|| '$dia_habil ' || 
            ' Tipo Plazo: '|| '$tipo_plazo ');";
     //   ejecutarConsulta($sql_2);
      error_log('$$$$$$' . $sql);

        return ejecutarConsulta($sql);
    }

    //Implementar un método para listar los registros
    public function listar($id)
    {
        $sql = "select oc.codigo, oc.codigo_adjudicacion, oc.numero_orden_compra, abreviacion || ' ' || numero  || '/' ||  anio as licitacion, 
        l.nombre as proveedor,
        to_char (fecha_recepcion_oc_proveedor, 'DD-MM-YYYY') as fecha_recepcion_oc_proveedor, 
        to_char (fecha_envio_correo, 'DD-MM-YYYY') as fecha_envio_correo,
        to_char (plazo_entrega, 'DD-MM-YYYY') as plazo_entrega, dias_plazo_entrega, es_dia_habil from orden_compra as oc
        inner join adjudicacion as a on a.codigo = oc.codigo_adjudicacion
        inner join tipo_adjudicacion as ta on ta.codigo = a.codigo_tipo_adjudicacion
        inner join laboratorio as l on l.codigo = oc.codigo_proveedor where oc.codigo_estado = 2 and oc.tipo_plazo not in(2)";
        //error_log('##########33 '.$sql);

        return ejecutarConsulta($sql);
    }

    public function mostrar($idcodigo)
    {
        $sql = "
select * from (
select oc.codigo, numero_orden_compra, codigo_estado, 
        (select (select abreviacion from tipo_adjudicacion as ta where ta.codigo = a.codigo_tipo_adjudicacion)
        from adjudicacion as a where a.codigo = codigo_adjudicacion) || ' ' || (select numero from adjudicacion as a where a.codigo = codigo_adjudicacion) || '/' ||
        (select anio from adjudicacion as a where a.codigo = codigo_adjudicacion) as licitacion, 
        (select codigo from laboratorio as l where l.codigo = codigo_proveedor) as codigo_proveedor,
        to_char (fecha_envio_correo, 'DD-MM-YYYY') as fecha_envio_correo,
        to_char (fecha_contrato, 'DD-MM-YYYY') as fecha_contrato, dias_plazo_entrega, to_char (fecha_orden_compra, 'DD-MM-YYYY') as fecha_orden_compra, 
        to_char (fecha_recepcion_oc_proveedor, 'DD-MM-YYYY') as fecha_recepcion_oc_proveedor, (select codigo from sucursal where codigo = lugar_entrega) as lugar_entrega, 
        (select codigo from sucursal where codigo = dependencia_solicitante) as dependencia_solicitante, condiciones_especiales, forma_pago, 
        to_char (plazo_entrega, 'DD-MM-YYYY') as plazo_entrega, imagen, es_dia_habil, tipo_plazo from orden_compra oc
	 where oc.codigo in ($idcodigo) 
) as oc
left join
(
    select codigo_orden_compra,observacion as obs_auditoria
    from orden_compra_auditoria
     where codigo in (select max(codigo) from orden_compra_auditoria where codigo_orden_compra =$idcodigo)
   
) as oca
on oca.codigo_orden_compra = oc.codigo";
        // $sql = "select codigo, numero_orden_compra, codigo_estado, 
        // (select (select abreviacion from tipo_adjudicacion as ta where ta.codigo = a.codigo_tipo_adjudicacion)
        // from adjudicacion as a where a.codigo = codigo_adjudicacion) || ' ' || (select numero from adjudicacion as a where a.codigo = codigo_adjudicacion) || '/' ||
        // (select anio from adjudicacion as a where a.codigo = codigo_adjudicacion) as licitacion, 
        // (select codigo from laboratorio as l where l.codigo = codigo_proveedor) as codigo_proveedor,
        // to_char (fecha_envio_correo, 'DD-MM-YYYY') as fecha_envio_correo,
        // to_char (fecha_contrato, 'DD-MM-YYYY') as fecha_contrato, dias_plazo_entrega, to_char (fecha_orden_compra, 'DD-MM-YYYY') as fecha_orden_compra, 
        // to_char (fecha_recepcion_oc_proveedor, 'DD-MM-YYYY') as fecha_recepcion_oc_proveedor, (select codigo from sucursal where codigo = lugar_entrega) as lugar_entrega, 
        // (select codigo from sucursal where codigo = dependencia_solicitante) as dependencia_solicitante, condiciones_especiales, forma_pago, 
        // to_char (plazo_entrega, 'DD-MM-YYYY') as plazo_entrega, imagen, es_dia_habil, tipo_plazo from orden_compra where codigo in ($idcodigo)";
    //    error_log("##############" . $sql);
        return ejecutarConsulta($sql);
    }

    public function listarDetalle($idcodigo)
    {
        $sql = "select item, codigo, (select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion from descripcion_medicamento 
        where codigo= codigo_medicamento) as medicamento, 
        codigo_medicamento, unidad_medida, marca, procedencia,
        cantidad_solicitada, precio_unitario
        from orden_compra_detalle where codigo_orden_compra =($idcodigo)";

        return ejecutarConsulta($sql);
    }

    public  function selectProveedor()
    {
        $sql = "select * from laboratorio order by codigo";
        //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }

    public  function selectEstado()
    {
        $sql = "select * from estado_orden_compra order by codigo";
        //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }

    public  function selectLugarEntrega()
    {
        $sql = "select * from sucursal order by codigo";
        //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }

    public  function selectDependenciaSolicitante()
    {
        $sql = "select * from sucursal order by codigo";
        //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }

    public  function calculoPlazoEntrega()
    {
        $sql = "select * from sucursal order by codigo";
        //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }

    public  function listarFeriados()
    {
        $sql = "select codigo, fecha, dia, mes, nombre from feriado order by fecha";
        //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }

    public  function selectTiposPlazo()
    {
        $sql = "select * from tipo_plazo where codigo <> 2 order by codigo";
        //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
}
