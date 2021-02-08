<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class AdjudicacionContrato
{
  //Implementamos nuestro constructor
  public function __construct()
  {
  }

  //Insertar Registros
  public function insertar(
    $codigo_adjudicacion,
    $numero_contrato,
    $codigo_proveedor,
    $fecha_contrato,
    $vigencia,
    $monto_contrato,
    $imagen,
    $porcentaje_mora,
    $frecuencia_diaria_aumento_mora,
    $porcentaje_rescision,
    $obs,
    $codigo_estado_contrato,
    $codigo_tipo_vigencia,
    $fecha_rescision
  ) {
    $sql = "INSERT INTO contrato(
                                        codigo_adjudicacion,
                                        numero_contrato,
                                        codigo_proveedor,
                                        fecha_contrato,
                                        vigencia,
                                        monto_contrato,
                                        imagen,
                                        porcentaje_mora,
                                        frecuencia_diaria_aumento_mora,
                                        porcentaje_rescision,
                                        obs,
                                        codigo_estado_contrato,
                                        codigo_tipo_vigencia,
                                        fecha_rescision
                                      ) 
                                      VALUES (
                                      '$codigo_adjudicacion',
                                      '$numero_contrato',
                                      '$codigo_proveedor',
                                      '$fecha_contrato',
                                      '$vigencia',
                                      $monto_contrato,
                                      '$imagen',
                                      $porcentaje_mora,
                                      $frecuencia_diaria_aumento_mora,
                                      $porcentaje_rescision,
                                      '$obs',
                                      $codigo_estado_contrato,
                                      $codigo_tipo_vigencia,
                                      '$fecha_rescision'
                                    )";
   // error_log('######### ' . $sql);
    return ejecutarConsulta($sql);
  }

  //Editar
  public function editar(
    $codigo,
    $codigo_adjudicacion,
    $numero_contrato,
    $codigo_proveedor,
    $fecha_contrato,
    $vigencia,
    $monto_contrato,
    $imagen,
    $porcentaje_mora,
    $frecuencia_diaria_aumento_mora,
    $porcentaje_rescision,
    $obs,
    $codigo_estado_contrato,
    $codigo_tipo_vigencia,
    $fecha_rescision
  ) {
    $sql = "UPDATE contrato SET codigo_adjudicacion='$codigo_adjudicacion',
                                                        numero_contrato='$numero_contrato',
                                                        codigo_proveedor='$codigo_proveedor',
                                                        fecha_contrato='$fecha_contrato',
                                                        vigencia='$vigencia',
                                                        monto_contrato='$monto_contrato',
                                                        imagen='$imagen',
                                                        porcentaje_mora='$porcentaje_mora',
                                                        frecuencia_diaria_aumento_mora='$frecuencia_diaria_aumento_mora',
                                                        porcentaje_rescision='$porcentaje_rescision',
                                                        obs='$obs',
                                                        codigo_estado_contrato='$codigo_estado_contrato',
                                                        codigo_tipo_vigencia='$codigo_tipo_vigencia',
                                                        fecha_rescision='$fecha_rescision'

                              WHERE codigo ='$codigo'";


    return ejecutarConsulta($sql);
  }


  public function mostrar($codigo)
  {

    $sql = "SELECT codigo,codigo_adjudicacion,numero_contrato,codigo_proveedor, to_char(fecha_contrato, 'DD-MM-YYYY') as fecha_contrato,
      to_char(vigencia, 'DD-MM-YYYY') as vigencia,monto_contrato,imagen,porcentaje_mora,frecuencia_diaria_aumento_mora,porcentaje_rescision,obs,
      codigo_estado_contrato,codigo_tipo_vigencia,to_char(fecha_rescision, 'DD-MM-YYYY') as fecha_rescision FROM contrato where codigo=$codigo";

    //return ejecutarConsulta($sql);
    return ejecutarConsulta($sql);
  }


  //Implementar un método para listar los registros
  public function listar()
  {
    $sql = "SELECT con.codigo, codigo_adjudicacion, 
    ta.abreviacion ||' '||a.numero||'/'||a.anio as adjudicacion, numero_contrato,a.titulo,a.id_llamado,
    (select nombre from laboratorio where codigo=codigo_proveedor) as codigo_proveedor,
      to_char (fecha_contrato, 'DD-MM-YYYY')as fecha_contrato, to_char (vigencia, 'DD-MM-YYYY') as vigencia,
      (select nombre from estado_contrato where codigo = con.codigo_estado_contrato) as estado
      FROM contrato as con
      left join laboratorio as lab on con.codigo_proveedor=lab.codigo
    left join adjudicacion as a on a.codigo = con.codigo_adjudicacion
    left join tipo_adjudicacion as ta on ta.codigo = a.codigo_tipo_adjudicacion";
    return ejecutarConsulta($sql);
  }


  public function selectProveedor()
  {
    $sql = "select * from laboratorio";
    return ejecutarConsulta($sql);
  }

  public function selectTipoVigencia()
  {
    $sql = "select * from tipo_vigencia";
    return ejecutarConsulta($sql);
  }

  public function selectEstadoContrato()
  {
    $sql = "select * from estado_contrato";
    return ejecutarConsulta($sql);
  }
}
