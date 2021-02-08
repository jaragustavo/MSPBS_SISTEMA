<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class OfertaCovid
{
  //Implementamos nuestro constructor
  public function __construct()
  {
  }
  public function listarmarcados($codigo_oferta_covid)
  {
    $sql = "SELECT * FROM covid_condicion_oferta WHERE codigo_oferta_covid =" . $codigo_oferta_covid . ";";
    // error_log('###### '.$sql);
    return ejecutarConsulta($sql);
  }
  public function listarCondicionItem($codigo)
  {
    $sql = "SELECT codigo, descripcion, codigo_item_covid
                  FROM covid_condicion_item
                  where codigo_item_covid= $codigo";


    return ejecutarConsulta($sql);
  }


  //Implementamos un método para insertar registros
  public function insertar($codigo_item_covid, $codigo_proveedor, $cantidad, $precio_unitario, $dias_disponible, $fecha_oferta, $obs, $codigo_estado, $condicion, $imagen)
  {
    $sql = "INSERT INTO oferta_covid(codigo_item_covid,
            codigo_proveedor, cantidad, precio_unitario, dias_disponible, 
            fecha_oferta, obs, codigo_estado, imagen)
            VALUES ($codigo_item_covid,$codigo_proveedor,$cantidad,$precio_unitario,
                    $dias_disponible,'$fecha_oferta','$obs',$codigo_estado,'$imagen');select currval( 'oferta_covid_codigo_seq' )::BIGINT;";

    $codigo_oferta_covid = ejecutarConsulta_retornarID($sql);
    $num_elementos = 0;
    $sw = true;

    while ($num_elementos < count($condicion)) {

      $sql_detalle = "INSERT INTO covid_condicion_oferta(
                                        codigo_oferta_covid, codigo_condicion_item)
            VALUES ($codigo_oferta_covid, $condicion[$num_elementos])";

      ejecutarConsulta($sql_detalle) or $sw = false;
      $num_elementos = $num_elementos + 1;
    }
    return $sw;
  }

  public function modificar($codigo, $codigo_item_covid, $codigo_proveedor, $cantidad, $precio_unitario, $dias_disponible, $fecha_oferta, $obs, $codigo_estado, $condicion, $imagen)
  {
    $sql = "UPDATE oferta_covid
                SET codigo_item_covid = $codigo_item_covid,codigo_proveedor=$codigo_proveedor, 
                    cantidad=$cantidad, precio_unitario=$precio_unitario, 
                    dias_disponible=$dias_disponible, fecha_oferta='$fecha_oferta',
                    obs='$obs', codigo_estado=$codigo_estado,imagen='$imagen'
                   WHERE codigo=$codigo;";
    //error_log('########## '.$sql);
    ejecutarConsulta($sql);
    $sql = "DELETE FROM covid_condicion_oferta
                WHERE codigo_oferta_covid =$codigo";
    ejecutarConsulta($sql);
    $num_elementos = 0;
    $sw = true;
    //if ($num_elementos > 0) {
      while ($num_elementos < count($condicion)) {

        $sql_detalle = "INSERT INTO covid_condicion_oferta(
                                        codigo_oferta_covid, codigo_condicion_item)
            VALUES ($codigo, $condicion[$num_elementos])";
        // error_log('########## '.$sql_detalle);
        ejecutarConsulta($sql_detalle) or $sw = false;
        $num_elementos = $num_elementos + 1;
      }
    //}

    return $sw;
  }

  //Implementamos un método para anular categorías




  public function editarOferta($idcodigo)
  {
    $sql = "SELECT codigo,(select item_numero || ' ' || nombre from item_covid where codigo = codigo_item_covid) as item,codigo_item_covid,
              (select nombre from laboratorio where codigo = codigo_proveedor) as nombre_proveedor,codigo_proveedor,
              cantidad, precio_unitario, dias_disponible, 
              to_char (fecha_oferta, 'DD-MM-YYYY') as fecha_oferta, obs, codigo_estado,imagen
              FROM oferta_covid 
              WHERE codigo = $idcodigo";

    //error_log('##########33 '.$sql);
    return ejecutarConsultaSimpleFila($sql);
  }




  //Implementar un método para listar los registros
  public function listar()
  {
    $sql = "select codigo,numero_item,nombre_item,(select monto from item_covid where codigo = codigo_item_covid) as precio_referencial,codigo_item_covid,nombre_proveedor,cantidad, precio_unitario,
       dias_disponible,fecha_oferta, obs, codigo_estado,
       cantidad_condicion,cantidad_oferta,imagen
from (
select codigo,numero_item,nombre_item,codigo_item_covid,nombre_proveedor,cantidad, precio_unitario, dias_disponible,fecha_oferta, obs, codigo_estado,
       cantidad_condicion,imagen
from (
SELECT codigo,(select item_numero from item_covid  where codigo = codigo_item_covid) as numero_item,
      (select nombre from item_covid where codigo = codigo_item_covid) as nombre_item,codigo_item_covid,
(select nombre from laboratorio where codigo = codigo_proveedor) as nombre_proveedor,
cantidad, precio_unitario, dias_disponible, 
to_char (fecha_oferta, 'DD-MM-YYYY') as fecha_oferta, obs, codigo_estado,imagen
FROM oferta_covid) as proveedor
LEFT JOIN 
( select codigo_item_covid as codigo_item,count(codigo) as cantidad_condicion
  from covid_condicion_item
  group by codigo_item_covid ) AS condicion
on proveedor.codigo_item_covid = condicion.codigo_item
) as dato
left join
(
  select codigo_oferta_covid as codigo_oferta,count(codigo_condicion_item) as cantidad_oferta
  from covid_condicion_oferta
  group by codigo_oferta_covid ) as oferta
on dato.codigo = oferta.codigo_oferta
order by numero_item, cantidad_oferta desc";
    return ejecutarConsulta($sql);
  }
  public function listarItem()
  {
    $sql = "SELECT codigo, item_numero, nombre, especificacion_tecnica, monto, cantidad_necesitada, 
       observacion, fecha_inicio, fecha_cierre, codigo_estado, presentacion, 
       presentacion_entrega, codigo_catalogo
  FROM item_covid";
    //    error_log('######### '.$sql);
    return ejecutarConsulta($sql);
  }

  public function selectProveedor()
  {
    $sql = "SELECT * FROM laboratorio;";

    return ejecutarConsulta($sql);
  }
  public function selectEstadoCovid()
  {
    $sql = "SELECT * FROM estado_covid;";
    //   error_log('######### '.$sql);
    return ejecutarConsulta($sql);
  }
}
