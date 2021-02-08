<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class Llamado
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
   
    //Insertar Registros
    public function insertar(
                              $id_llamado,
                              $fecha_llamado,
                              $codigo_tipo_llamado,
                              $numero,
                              $anio,
                              $titulo,
                              $observacion,
                              $codigo_pedido_producto,
                              $numero_pac
                            )
    {
      $sql="INSERT INTO llamado (
                                        id_llamado,
                                        fecha_llamado,
                                        codigo_tipo_llamado,
                                        numero,
                                        anio,
                                        titulo,
                                        observacion,
                                        codigo_pedido_producto,
                                        codigo_estado_llamado,
                                        numero_pac
                                      ) 
                                      VALUES (
                                      $id_llamado,
                                      '$fecha_llamado',
                                       $codigo_tipo_llamado,
                                      '$numero',
                                      '$anio',
                                      '$titulo',
                                      '$observacion',
                                       $codigo_pedido_producto,
                                       1,
                                       $numero_pac
                                    );select currval( 'llamado_codigo_seq' )::BIGINT;";
                                    // error_log('******'.$sql);
                                    $consulta_codigo=ejecutarConsulta_retornarID($sql);
      $sql_2="INSERT INTO adjudicacion( numero,
                                        anio,
                                        titulo,
                                        fecha_adjudicacion,
                                        codigo_tipo_adjudicacion,
                                        codigo_estado_adjudicacion,
                                        observacion,
                                        id_llamado,
                                        codigo_llamado,
                                        numero_pac,
                                        codigo_pedido_producto
                                      )
                                      VALUES ( 
                                        '$numero',
                                        '$anio',
                                        '$titulo',
                                        '$fecha_llamado',
                                        $codigo_tipo_llamado,
                                        1,
                                        '$observacion',
                                        '$id_llamado',
                                        '$consulta_codigo',
                                        $numero_pac,
                                        $codigo_pedido_producto
      )";
      // error_log('$$$$$'.$consulta_codigo);
      // error_log('%%%%'.$sql_2);
      return ejecutarConsulta($sql_2);
    }
  
     public function editar($codigo,$id_llamado,$fecha_llamado,$codigo_tipo_llamado,$numero,$anio,$titulo,$observacion,$codigo_pedido_producto,$codigo_estado_llamado,$numero_pac)
    {
      if ($codigo_pedido_producto == null){
          $codigo_pedido_producto = 0;
      }
      $sql="UPDATE llamado SET id_llamado=$id_llamado,fecha_llamado='$fecha_llamado',codigo_tipo_llamado=$codigo_tipo_llamado,numero='$numero',anio='$anio',titulo='$titulo',observacion='$observacion', codigo_pedido_producto=$codigo_pedido_producto , codigo_estado_llamado=$codigo_estado_llamado,numero_pac=$numero_pac  WHERE codigo =$codigo";
  
      ejecutarConsulta($sql);

      $sql_2="UPDATE adjudicacion SET id_llamado=$id_llamado,fecha_adjudicacion='$fecha_llamado',codigo_tipo_adjudicacion=$codigo_tipo_llamado,numero='$numero',anio='$anio',titulo='$titulo',observacion='$observacion',codigo_pedido_producto=$codigo_pedido_producto,codigo_estado_adjudicacion=$codigo_estado_llamado,numero_pac=$numero_pac WHERE codigo_llamado=$codigo";
      return ejecutarConsulta($sql_2);
    }
    
     public function mostrar($codigo)
    {

      $sql="SELECT codigo, numero, anio, titulo, fecha_llamado, codigo_tipo_llamado,
                  (select abreviacion from tipo_adjudicacion where codigo= codigo_tipo_llamado) as tipo_llamado,
                  (select nombre from estado_llamado where codigo =codigo_estado_llamado) as estado_llamado,
                  observacion, codigo_sucursal, id_llamado, codigo_estado_llamado,
                   codigo_pedido_producto,numero_pac 
                  FROM llamado where codigo=$codigo";
     //  error_log('##### '.$sql);
      //return ejecutarConsulta($sql);
      return ejecutarConsultaSimpleFila($sql);
    }
    

    //Implementar un método para listar los registros
    public function listar()
    {
        $sql="SELECT codigo, numero, anio, titulo, fecha_llamado, codigo_tipo_llamado,
       (select abreviacion from tipo_adjudicacion where codigo= codigo_tipo_llamado) as tipo_llamado,
       (select nombre from estado_llamado where codigo =codigo_estado_llamado) as estado_llamado,
       observacion, codigo_sucursal, id_llamado, 
       codigo_pedido_producto,numero_pac 
  FROM llamado";
    return ejecutarConsulta($sql);      
    }
    
     public function listarPedidoProducto()
    {
        $sql="SELECT codigo, to_char (fecha_pedido, 'DD-MM-YYYY') as fecha_pedido,
        (select nombre from sucursal where codigo =codigo_sucursal) as establecimiento, obs, numero_expediente, 
       (select nombre from tipo_pedido where codigo = codigo_tipo_pedido) as tipo_pedido, numero_nota, 
       (select descripcion from estado_pedido where codigo = codigo_estado) as estado_pedido
       FROM pedido_producto
       where  codigo_estado <> 5
       and  codigo_grupo_medicamento =8";
    return ejecutarConsulta($sql);      
    }
     
     

   /* public function selectTipoLlamado()
    {
          error_log('message');
          $sql="SELECT abreviacion from tipo_adjudicacion where codigo=$codigo" ;
        
      return ejecutarConsultaSimpleFila($sql);
    }
    */

}
   
?>