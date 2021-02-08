<?php
require '../config/Conexion.php';
Class OrdenCompra
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($numero_orden_compra,
                                 $codigo_adjudicacion,
                                 $codigo_proveedor,
                                 $forma_pago ,
                                 $fecha_contrato ,
                                 $dias_plazo ,
                                 $fecha_orden_compra ,
                                 $condiciones_especiales ,
                                 $lugar_entrega ,
                                 $dependencia_solicitante ,
                                 $tipo_plazo ,
                                 $monto_total ,
                                 $nombre_monto_total ,
                                 $referencia ,
                                 $usuario ,
                                 $item ,
                                 $codigo_medicamento ,
                                 $cantidad_emitir ,
                                 $unidad_medida ,
                                 $marca ,
                                 $procedencia ,
                                 $precio_unitario )
	{
$sql= "insert into orden_compra(
                    numero_orden_compra ,
                    codigo_estado ,
                    codigo_adjudicacion ,
                    codigo_proveedor ,
                    forma_pago   ,
                    condiciones_especiales   ,
                    fecha_orden_compra    ,
                    fecha_contrato   ,
                    plazo_entrega ,
                    fecha_recepcion_oc_proveedor ,
                    lugar_entrega   ,
                    dias_plazo_entrega   ,
                    directivo_uno ,
                    cargo_uno ,
                    directivo_dos ,
                    cargo_dos ,
                    dependencia_solicitante   ,
                    expediente ,
                    monto_total ,
                    nombre_monto_total ,
                    total_iva   ,
                    total_exenta   ,
                    tipo_plazo ,
                    referencia ,
                    usuario 
                )
                values
                (
                    '$numero_orden_compra' ,
                    '$codigo_estado' ,
                    '$codigo_adjudicacion' ,
                    '$codigo_proveedor' ,
                    '$forma_pago'   ,
                    '$condiciones_especiales'   ,
                    '$fecha_orden_compra'    ,
                    '$fecha_contrato'   ,
                    '$plazo_entrega' ,
                    '$fecha_recepcion_oc_proveedor' ,
                    '$lugar_entrega'   ,
                    '$dias_plazo_entrega'   ,
                    '$directivo_uno' ,
                    '$cargo_uno' ,
                    '$directivo_dos' ,
                    '$cargo_dos' ,
                    '$dependencia_solicitante'   ,
                    '$expediente' ,
                    '$monto_total' ,
                    '$nombre_monto_total' ,
                    '$total_iva'   ,
                    '$total_exenta'   ,
                    '$tipo_plazo' ,
                    '$referencia' ,
                    '$usuario'

                );select currval( 'orden_compra_codigo_seq' )::BIGINT;";
                 
		$idordencompranew=ejecutarConsulta_retornarID($sql);
 
        $num_elementos=0;
        $sw=true;
 
        while ($num_elementos < count($codigo_medicamento))
        {
            $sql_detalle = "INSERT INTO orden_compra_detalle( 
                                codigo_medicamento ,
                                codigo_orden_compra ,
                                codigo_detalle_adjudicacion ,
                                cantidad_recepcionada ,
                                cantidad_solicitada ,
                                precio_unitario ,
                                codigo_impuesto ,
                                item ,
                                procedencia ,
                                marca ,
                                unidad_medida )
                            VALUES(
                                '$codigo_medicamento[$num_elementos] ,
                                '$idordencompranew[$num_elementos] ,
                                '$codigo_detalle_adjudicacion[$num_elementos] ,
                                '$cantidad_recepcionada[$num_elementos] ,
                                '$cantidad_solicitada[$num_elementos] ,
                                '$precio_unitario[$num_elementos] ,
                                '$codigo_impuesto[$num_elementos] ,
                                '$item[$num_elementos] ,
                                '$procedencia[$num_elementos] ,
                                '$marca[$num_elementos] ,
                                '$unidad_medida[$num_elementos]

                                );";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
        }
 
        return $sw;
              
	}

	//Implementamos un método para editar registros
	public function editar($idcategoria,$nombre,$descripcion)
	{
		$sql="UPDATE categoria SET nombre='$nombre',descripcion='$descripcion' WHERE idcategoria='$idcategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function anular($codigo_orden_compra)
	{
		$sql="UPDATE orden_compra SET codigo_estado=5 WHERE codigo='$codigo_orden_compra'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idcategoria)
	{
		$sql="UPDATE categoria SET condicion='1' WHERE idcategoria='$idcategoria'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($codigo_orden_compra)
	{
		$sql="SELECT * FROM orden_compra WHERE codigo='$codigo_orden_compra'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM orden_compra";
		return ejecutarConsulta($sql);		
	}
}

?>