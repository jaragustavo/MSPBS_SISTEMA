<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Producto
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
        
        public function insertar($precio_unitario, $cantidad_adjudicada, 
                                 $codigo_medicamento, $codigo_adjudicacion, 
                                 $codigo_proveedor, $nombre_comercial, $item,
                                 $unidad_medida, $procedencia,$cantidad_emitida,
                                 $cantidad_minima)
    {
        $sql="INSERT INTO detalle_adjudicacion_temporal(
            precio_unitario, cantidad_adjudicada, codigo_medicamento, codigo_adjudicacion, 
            codigo_proveedor, nombre_comercial, item, unidad_medida, procedencia, 
            cantidad_emitida, cantidad_minima, actualizado)
            VALUES ($precio_unitario, $cantidad_adjudicada, 
                    $codigo_medicamento, $codigo_adjudicacion, 
                    $codigo_proveedor, '$nombre_comercial', $item,
                    '$unidad_medida', '$procedencia',$cantidad_emitida,
                    $cantidad_minima,'SI')";
     //   error_log('####### '.$sql);
        return ejecutarConsulta($sql);
      
    }

    public function listarProducto()
    {
            $sql="SELECT * FROM descripcion_medicamento";
            return ejecutarConsulta($sql);		
    }



}

?>