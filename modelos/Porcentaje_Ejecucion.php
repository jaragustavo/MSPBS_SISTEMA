<?php 
//Incluímos inicialmente la conexión a la base de datos

require '../conexion.php';
Class Porcentaje_Ejecucion
{    
	//Implementamos nuestro constructor
	public function __construct()
	{
           
	}
	//Implementar un método para listar los registros
	public function listar()
	{
        $sql="
            select codigo_medicamento, producto,  (tipo_compra||' '||numero||'/'||anio)as llamado, proveedor, cantidad_minima, cantidad_adjudicada, cantidad_emitida, porcentaje , codigo_proveedor from
  (select codigo_medicamento, (select clasificacion_medicamento||' '||coalesce(concentracion, '')||' '||forma_farmaceutica||' '||presentacion from descripcion_medicamento where codigo= codigo_medicamento) as producto,
  numero, anio, codigo_tipo_adjudicacion, (select abreviacion from tipo_adjudicacion where codigo = codigo_tipo_adjudicacion)as tipo_compra, cantidad_adjudicada, cantidad_emitida, cantidad_minima,
   codigo_proveedor, (select nombre from laboratorio where codigo=codigo_proveedor) as proveedor,
   round((coalesce(cast(cantidad_emitida as decimal),0)*100)/coalesce(cantidad_adjudicada),2) as porcentaje
  from adjudicacion a,detalle_adjudicacion_temporal b where a.codigo = b.codigo_adjudicacion) as e 
              ";      
        
        return ejecutarConsulta($sql);                
                
	}
}
?>
