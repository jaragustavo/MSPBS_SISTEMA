<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

class AdjudicacionPoliza
{
  //Implementamos nuestro constructor
  public function __construct()
  {
  }

  //Insertar Registros
  public function insertar(
    $codigo_contrato,
    $aseguradora,
    $numero_poliza,
    $fecha_emision,
    $fecha_inicio,
    $fecha_fin,
    $monto_poliza,
    $obs,
    $codigo_estado_poliza,
    $imagen
  ) {
    $sql = "INSERT INTO poliza(
                                        codigo_contrato,
                                        aseguradora,
                                        numero_poliza,
                                        fecha_emision,
                                        fecha_inicio,
                                        fecha_fin,
                                        monto_poliza,
                                        obs,
                                        codigo_estado_poliza,
                                        imagen
                                      ) 
                                      VALUES (
                                        '$codigo_contrato',
                                        '$aseguradora',
                                        '$numero_poliza',
                                        '$fecha_emision',
                                        '$fecha_inicio',
                                        '$fecha_fin',
                                        '$monto_poliza',
                                        '$obs',
                                        '$codigo_estado_poliza',
                                        '$imagen'
                                    )";
    error_log('######### ' . $sql);
    return ejecutarConsulta($sql);
  }

  //Editar
  public function editar(
    $codigo,
    $codigo_contrato,
    $aseguradora,
    $numero_poliza,
    $fecha_emision,
    $fecha_inicio,
    $fecha_fin,
    $monto_poliza,
    $obs,
    $codigo_estado_poliza,
    $imagen
  ) {
    $sql = "UPDATE poliza SET codigo_contrato='$codigo_contrato',
                                                        aseguradora='$aseguradora',
                                                        numero_poliza='$numero_poliza',
                                                        fecha_emision='$fecha_emision',
                                                        fecha_inicio='$fecha_inicio',
                                                        fecha_fin='$fecha_fin',
                                                        monto_poliza='$monto_poliza',
                                                        obs='$obs',
                                                        codigo_estado_poliza='$codigo_estado_poliza',
                                                        imagen='$imagen'

                              WHERE codigo ='$codigo'";


    return ejecutarConsulta($sql);
  }


  public function mostrar($codigo)
  {

    $sql = "SELECT pol.codigo, pol.codigo_contrato, con.numero_contrato, lab.nombre as proveedor, aseguradora, numero_poliza, 
    ta.abreviacion ||' '||a.numero||'/'||a.anio as llamado, to_char(fecha_emision, 'DD-MM-YYYY')as fecha_emision, 
    to_char(fecha_inicio, 'DD-MM-YYYY')as fecha_inicio, to_char(fecha_fin, 'DD-MM-YYYY')as fecha_fin, monto_poliza, 
    pol.obs, codigo_estado_poliza, pol.imagen FROM poliza as pol
    left join contrato as con on con.codigo = pol.codigo_contrato
    left join laboratorio as lab on con.codigo_proveedor=lab.codigo
    left join adjudicacion as a on a.codigo = con.codigo_adjudicacion
    left join tipo_adjudicacion as ta on ta.codigo = a.codigo_tipo_adjudicacion where pol.codigo=$codigo";

    //return ejecutarConsulta($sql);
    return ejecutarConsulta($sql);
  }


  //Implementar un método para listar los registros
  public function listar()
  {
    $sql = "SELECT pol.codigo, pol.codigo_contrato, con.numero_contrato, numero_poliza, lab.nombre as proveedor,
    ta.abreviacion ||' '||a.numero||'/'||a.anio as llamado, 
    to_char(fecha_inicio, 'DD-MM-YYYY')as fecha_inicio, 
    to_char(fecha_fin, 'DD-MM-YYYY')as fecha_fin, monto_poliza FROM poliza as pol
    left join contrato as con on con.codigo = pol.codigo_contrato
    left join laboratorio as lab on con.codigo_proveedor=lab.codigo
    left join adjudicacion as a on a.codigo = con.codigo_adjudicacion
    left join tipo_adjudicacion as ta on ta.codigo = a.codigo_tipo_adjudicacion";
    return ejecutarConsulta($sql);
  }


  public function selectAseguradora()
  {
    $sql = "select * from laboratorio";
    return ejecutarConsulta($sql);
  }

  public function selectEstadoPoliza()
  {
    $sql = "select * from estado_poliza";
    return ejecutarConsulta($sql);
  }

  public function listarContrato()
  {
    $sql = "SELECT con.codigo as codigo_contrato, numero_contrato, lab.nombre as codigo_proveedor, 
    ta.abreviacion ||' '||a.numero||'/'||a.anio as adjudicacion, to_char(con.vigencia, 'DD-MM-YYYY')as vigencia FROM contrato as con
    left join laboratorio as lab on con.codigo_proveedor=lab.codigo
    left join adjudicacion as a on a.codigo = con.codigo_adjudicacion
    left join tipo_adjudicacion as ta on ta.codigo = a.codigo_tipo_adjudicacion";
    return ejecutarConsulta($sql);
  }
}
