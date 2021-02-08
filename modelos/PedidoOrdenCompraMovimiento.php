<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class PedidoOrdenCompraMovimiento
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros
                            
    public function insertar($idcodigo,$codigo_medicamento,$idusuario_envio,$fecha_envio,$idusuario_destino,$fecha_recibo,$obs)
    {
        $num_elementos=0;
        $sw=true;
       //  error_log('##########333 '.$codigo_medicamento);
        while ($num_elementos < count($codigo_medicamento))
        {
           
             $sql="INSERT INTO pedido_orden_compra_movimiento (codigo_pedido_orden_compra,codigo_medicamento,idusuario_envio,fecha_envio,idusuario_destino,fecha_recibo,obs,codigo_estado,codigo_estado_informe)
             VALUES ($idcodigo[$num_elementos],$codigo_medicamento[$num_elementos],'$idusuario_envio','$fecha_envio','$idusuario_destino',null,'$obs',1,1);"
      
             ."update orden_compra_pedido_detalle set codigo_estado = 3, estado_cierre =1 where codigo_medicamento=$codigo_medicamento[$num_elementos] and codigo_orden_compra_pedido =$idcodigo[$num_elementos] and codigo_estado = 1;";
     
     //error_log('##########333 '.$sql);
            ejecutarConsulta($sql) or $sw = false;
            $num_elementos=$num_elementos + 1;
        }
        
         return $sw;
        
    }
 
     
    //Implementamos un método para anular categorías
    public function anular($idingreso)
    {
        $sql="UPDATE ingreso SET estado='Anulado' WHERE idingreso='$idingreso'";
        return ejecutarConsulta($sql);
    }
 
 
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idingreso)
    {
        $sql="SELECT i.idingreso,DATE(i.fecha_hora) as fecha,i.idproveedor,p.nombre as proveedor,u.idusuario,u.nombre as usuario,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM ingreso i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN usuario u ON i.idusuario=u.idusuario WHERE i.idingreso='$idingreso'";
        return ejecutarConsultaSimpleFila($sql);
    }
 
    public function listarDetalle($idingreso)
    {
        $sql="SELECT di.idingreso,di.idarticulo,a.nombre,di.cantidad,di.precio_compra,di.precio_venta FROM detalle_ingreso di inner join articulo a on di.idarticulo=a.idarticulo where di.idingreso='$idingreso'";
        return ejecutarConsulta($sql);
    }
 
    //Implementar un método para listar los registros
    public function listar()
    {
        $sql="select * from pedido_orden_compra_movimiento";
        return ejecutarConsulta($sql);      
    }
     
}
 
?>