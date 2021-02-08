<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class StockCanje
{
    //Implementamos nuestro constructor
    public function __construct()
    {
    }

    //Implementamos un método para guardar un nuevo canje
    public function guardar(
        $codigo_stock_medicamento,
        $fecha_canje,
        $cantidad_canje,
        $observacion,
        $imagen,
        $fecha_auditoria,
        $id
    ) {
        $sql = "INSERT INTO canje_medicamento(codigo_stock_medicamento, fecha_canje, cantidad_canje, 
        imagen, observacion)
        VALUES($codigo_stock_medicamento,'$fecha_canje', $cantidad_canje, '$imagen', '$observacion')";
        
        $sql_2 = "INSERT INTO stock_auditoria(codigo_stock, usuario, fecha_hora, codigo_accion, 
            observacion, datos_afectados)
            VALUES ($codigo_stock_medicamento,$id,'$fecha_auditoria',25,'$observacion','Fecha canje: '|| '$fecha_canje ' || 
            ' Cantidad canje: '|| '$cantidad_canje ');";
            error_log('$$$$$$' . $sql_2);
        ejecutarConsulta($sql_2);

        return ejecutarConsulta($sql);
    }

    //Implementamos un método para modificar un canje
    public function editar(
        $codigo_stock_medicamento,
        $codigo_canje,
        $fecha_canje,
        $cantidad_canje,
        $observacion_canje,
        $imagen,
        $fecha_auditoria,
        $id
    ) {
    
        $sql = "UPDATE canje_medicamento 
        set fecha_canje = '$fecha_canje', cantidad_canje = '$cantidad_canje', 
        imagen = '$imagen', observacion = '$observacion_canje' 
        where codigo in($codigo_canje) and codigo_stock_medicamento in($codigo_stock_medicamento);";
            error_log('$$$$$$' . $sql);

        $sql_2 = "INSERT INTO stock_auditoria(codigo_stock, usuario, fecha_hora, codigo_accion, 
            observacion, datos_afectados)
            VALUES ($codigo_stock_medicamento,$id,'$fecha_auditoria',26, '$observacion_canje', 'Codigo_canje: '|| '$codigo_canje ' ||
            'Fecha canje: '|| '$fecha_canje ' || ' Cantidad canje: '|| '$cantidad_canje ');";
            error_log('$$$$$$' . $sql_2);
        ejecutarConsulta($sql_2);

        return ejecutarConsulta($sql);
    }

    //Implementar un método para listar los registros
    public function listar()
    {
        $sql = "select sm.codigo as codigo_stock_medicamento, abreviacion || ' ' || numero  || '/' ||  anio as licitacion,
        sum(sm.cantidad) as cantidad, sm.codigo_medicamento, sm.numero_lote, 
        dm.clasificacion_medicamento||' '||coalesce(dm.concentracion,'')||' '||dm.forma_farmaceutica||' '||dm.presentacion as medicamento,
        to_char (sm.fecha_vencimiento, 'DD-MM-YYYY') as fecha_vencimiento, l.nombre as proveedor, s.nombre as sucursal, 
        numero_orden_compra as orden_compra, to_char (cm.fecha_canje, 'DD-MM-YYYY') as fecha_canje
        
        from stock_medicamento as sm
        left join canje_medicamento as cm on cm.codigo_stock_medicamento = sm.codigo
        inner join adjudicacion as a on a.codigo = sm.codigo_adjudicacion
        left join detalle_adjudicacion_temporal as dat on a.codigo = dat.codigo_adjudicacion
        inner join tipo_adjudicacion as ta on ta.codigo = a.codigo_tipo_adjudicacion
        left join laboratorio as l on l.codigo = dat.codigo_proveedor
        inner join sucursal as s on s.codigo = sm.codigo_sucursal
        inner join medicamento as m on sm.codigo_medicamento = m.codigo
        inner join descripcion_medicamento as dm on m.codigo = dm.codigo
        left join orden_compra as oc on oc.codigo_adjudicacion = sm.codigo_adjudicacion
        where cantidad > 0 and s.codigo in(1801,1701,1790,884)
        
        group by licitacion, proveedor, sucursal, numero_orden_compra, numero_lote, sm.codigo_medicamento, 
        medicamento, fecha_vencimiento, sm.codigo, cm.fecha_canje
        order by cm.fecha_canje asc;";
        // error_log('########## ' . $sql);

        return ejecutarConsulta($sql);
    }

    public function mostrar($idcodigo)
    {
        $sql = "select sm.codigo as codigo_stock_medicamento, abreviacion || ' ' || numero  || '/' ||  anio as licitacion,
        sum(sm.cantidad) as cantidad, sm.codigo_medicamento, sm.numero_lote, 
        dm.clasificacion_medicamento||' '||coalesce(dm.concentracion,'')||' '||dm.forma_farmaceutica||' '||dm.presentacion as medicamento,
        to_char (sm.fecha_vencimiento, 'DD-MM-YYYY') as fecha_vencimiento, l.nombre as proveedor, s.nombre as sucursal,
        cm.codigo as codigo_canje, to_char (cm.fecha_canje, 'DD-MM-YYYY') as fecha_canje, cm.cantidad_canje, 
        cm.imagen as imagen, cm.observacion as observacion_canje, numero_orden_compra as orden_compra
        
        from stock_medicamento as sm
        inner join canje_medicamento as cm on cm.codigo_stock_medicamento = sm.codigo
        left join adjudicacion as a on a.codigo = sm.codigo_adjudicacion
        left join detalle_adjudicacion_temporal as dat on a.codigo = dat.codigo_adjudicacion
        left join tipo_adjudicacion as ta on ta.codigo = a.codigo_tipo_adjudicacion
        left join laboratorio as l on l.codigo = dat.codigo_proveedor
        left join sucursal as s on s.codigo = sm.codigo_sucursal
        left join medicamento as m on sm.codigo_medicamento = m.codigo
        left join descripcion_medicamento as dm on m.codigo = dm.codigo
        left join orden_compra as oc on oc.codigo_adjudicacion = sm.codigo_adjudicacion
        where sm.codigo in($idcodigo)
        group by licitacion, proveedor, sucursal, numero_lote, sm.codigo_medicamento, medicamento, fecha_vencimiento, sm.codigo,
        codigo_canje, fecha_canje, cantidad_canje, cm.imagen, observacion_canje, numero_orden_compra;";
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
