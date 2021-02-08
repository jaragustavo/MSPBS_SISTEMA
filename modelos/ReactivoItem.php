<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class ItemCovid
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
     public function listarCondicionItem($codigo)
    {
            $sql="SELECT codigo, descripcion, codigo_item_covid
                  FROM covid_condicion_item
                  where codigo_item_covid= $codigo";

      //   error_log('###### '.$sql);
            return ejecutarConsulta($sql);		
    }   
        
        
    public function insertar($codigo_catalogo,$nombre,$especificacion_tecnica,$presentacion,$presentacion_entrega,$observacion)
    {
        $sql="INSERT INTO item_covid(codigo_catalogo,item_numero,nombre,especificacion_tecnica,presentacion,presentacion_entrega,monto,cantidad_necesitada,observacion,fecha_inicio,fecha_cierre,codigo_estado, imagen)
                            VALUES ('$codigo_catalogo',$item_numero,'$nombre','$especificacion_tecnica','$presentacion','$presentacion_entrega',$monto,$cantidad_necesitada,'$observacion','$fecha_inicio',null,'1','$imagen');select currval( 'item_covid_codigo_seq' )::BIGINT;";
         //error_log('COVID###### '.$sql); 
        $iditem=ejecutarConsulta_retornarID($sql);
        
        $num_elementos=0;
        $sw=true;
 
        while ($num_elementos < count($condicion_item))
        {   
           
            
            $sql_detalle = "INSERT INTO covid_condicion_item(
                                        descripcion, codigo_item_covid)
            VALUES ('$condicion_item[$num_elementos]', $iditem)";
            // error_log('COVID###### '.$sql_detalle);
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
        }
        return $sw;
      
    }

    public function editar($codigo,$codigo_catalogo,$item_numero,$nombre,$especificacion_tecnica,$presentacion,$presentacion_entrega,$monto,$cantidad_necesitada,$observacion,$fecha_inicio,$fecha_cierre,$codigo_estado,$condicion_item,$imagen)
    {
                          $sql="UPDATE item_covid SET   codigo_catalogo='$codigo_catalogo',
                                                        item_numero=$item_numero,
                                                        nombre='$nombre',
                                                        especificacion_tecnica='$especificacion_tecnica',
                                                        presentacion='$presentacion',
                                                        presentacion_entrega='$presentacion_entrega',
                                                        monto=$monto,
                                                        cantidad_necesitada=$cantidad_necesitada,
                                                        observacion='$observacion',
                                                        fecha_inicio='$fecha_inicio',
                                                        fecha_cierre=null,
                                                        codigo_estado='$codigo_estado',
                                                        imagen='$imagen'
                              WHERE codigo =$codigo";
                           //   error_log("####".$sql);
      
                          ejecutarConsulta($sql);
        $sql ="DELETE FROM covid_condicion_item
                WHERE codigo_item_covid =$codigo";
        ejecutarConsulta($sql); 
        
        $num_elementos=0;
        $sw=true;
     //  error_log('##### condicion_item'.$sql);
        
        while ($num_elementos < count($condicion_item))
        {   
           $sql_detalle = "INSERT INTO covid_condicion_item(
                       descripcion, codigo_item_covid)
            VALUES ( '$condicion_item[$num_elementos]', $codigo);";
         // error_log('###### '.$sql_detalle); 
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
        }
     
        return $sw;
    }


    public function listar()
    {
            $sql="SELECT codigo, nombre, codigo_catalogo, especificacion_tecnica, presentacion, 
                 presentacion_entrega, observacion, imagen, codigo_grupo, codigo_estado
                 FROM item_producto";
                 return ejecutarConsulta($sql);
    }

    public function mostrar($codigo)
    {
            $sql="SELECT codigo,codigo_catalogo,item_numero,nombre,especificacion_tecnica,presentacion,presentacion_entrega,monto,cantidad_necesitada,observacion,to_char (fecha_inicio, 'DD-MM-YYYY') as fecha_inicio,to_char (fecha_cierre, 'DD-MM-YYYY') as fecha_cierre,codigo_estado,imagen  FROM item_covid where codigo='$codigo'";
          //  error_log('###### '.$sql); 
            return ejecutarConsulta($sql);		
    }

    


}

?>