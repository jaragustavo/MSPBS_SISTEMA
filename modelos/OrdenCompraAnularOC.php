<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class OrdenCompraAnularOC
{
    //Implementamos nuestro constructor
    public function __construct()
    {
    }

    
    //Implementamos un método para insertar registros
    public function anularOC($codigo,$codigo_estado,$id,$item,$codigo_medicamento,$cantidad_emitir,$fecha_auditoria,$numero_orden_compra,$observacion,$codigo_proveedor)
    {
        $sql_2="INSERT INTO orden_compra_auditoria(
        codigo_orden_compra, usuario, fecha_hora, codigo_accion, 
        observacion, valor_anterior)
        VALUES ($codigo,$id,'$fecha_auditoria',24,'$observacion','Numero OC: '|| '$numero_orden_compra ' || 'Codigo_Estado: '|| '$codigo_estado' ||'');";
        ejecutarConsulta($sql_2);
        $sql = "select anular_orden_compra('$codigo','$codigo_estado','$id','$item','$codigo_medicamento','$cantidad_emitir');";
        return ejecutarConsulta($sql);
    }

    //Implementar un método para listar los registros
    public function listar()
    {
        $sql = "select oc.codigo, oc.numero_orden_compra,
        ta.abreviacion || ' ' || a.numero || '/' || a.anio as licitacion,
        l.nombre as proveedor,fecha_orden_compra,fecha_recepcion_oc_proveedor,
        eoc.nombre as codigo_estado,monto_total
        from orden_compra as oc
        inner join adjudicacion as a on a.codigo = oc.codigo_adjudicacion
        inner join tipo_adjudicacion as ta on ta.codigo = a.codigo_tipo_adjudicacion
        inner join laboratorio as l on l.codigo = oc.codigo_proveedor
        inner join estado_orden_compra as eoc on eoc.codigo = oc.codigo_estado
        where oc.codigo_estado=2 order by numero_orden_compra";
        //error_log('##########33 '.$sql);

        return ejecutarConsulta($sql);
    }

    public function mostrar($idcodigo)
    {
        $sql = "select codigo, numero_orden_compra, codigo_estado, 
        (select (select abreviacion from tipo_adjudicacion as ta where ta.codigo = a.codigo_tipo_adjudicacion)
        from adjudicacion as a where a.codigo = codigo_adjudicacion) || ' ' || (select numero from adjudicacion as a where a.codigo = codigo_adjudicacion) || '/' ||
        (select anio from adjudicacion as a where a.codigo = codigo_adjudicacion) as licitacion, (select codigo from laboratorio as l where l.codigo = codigo_proveedor) as codigo_proveedor,
        to_char (fecha_contrato, 'DD-MM-YYYY') as fecha_contrato, dias_plazo_entrega, to_char (fecha_orden_compra, 'DD-MM-YYYY') as fecha_orden_compra, to_char (fecha_recepcion_oc_proveedor, 'DD-MM-YYYY') as fecha_recepcion_oc_proveedor, (select codigo from sucursal where codigo = lugar_entrega) as lugar_entrega, 
        (select codigo from sucursal where codigo = dependencia_solicitante) as dependencia_solicitante, condiciones_especiales, forma_pago, 
        to_char (plazo_entrega, 'DD-MM-YYYY') as plazo_entrega from orden_compra where codigo in ($idcodigo)";

        return ejecutarConsulta($sql);
    }

    public function listarDetalle($idcodigo)
    {
        $sql = "select item, codigo, (select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion from descripcion_medicamento 
        where codigo= codigo_medicamento) as medicamento, 
        codigo_medicamento, unidad_medida, marca, procedencia,
        cantidad_solicitada, precio_unitario, (cantidad_solicitada*precio_unitario) as monto
        from orden_compra_detalle where codigo_orden_compra =($idcodigo)";

        return ejecutarConsulta($sql);
    }

    public  function selectProveedor()
    {
          $sql="select * from laboratorio order by codigo";
      //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }

    public  function selectEstado()
    {
          $sql="select * from estado_orden_compra order by codigo";
      //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }

    public  function selectLugarEntrega()
    {
          $sql="select * from sucursal order by codigo";
      //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
    
    public  function selectDependenciaSolicitante()
    {
          $sql="select * from sucursal order by codigo";
      //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }

    public  function calculoPlazoEntrega()
    {
          $sql="select * from sucursal order by codigo";
      //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
}
