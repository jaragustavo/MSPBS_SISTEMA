<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class CovidMonto
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
        
    public function insertar($descripcion,$monto,$fecha)
    {
        $sql="INSERT INTO covid_monto(fecha,descripcion,monto,moneda,cotizacion)
                            VALUES '($fecha','$descripcion',$monto,$moneda,$cotizacion)";
        
        return ejecutarConsulta($sql);
      
    }

    public function editar($codigo,$fecha,$descripcion,$monto,$moneda,$cotizacion)
    {
                          $sql="UPDATE covid_monto SET  fecha='$fecha',
                                                        descripcion='$descripcion',
                                                        monto=$monto,
                                                        moneda=$moneda,
                                                        cotizacion=$cotizacion
                              WHERE codigo =$codigo";
                          
                          return ejecutarConsulta($sql);
    }


    public function listar()
    {
            $sql="SELECT codigo,descripcion,monto,moneda,CASE WHEN moneda<= 1 THEN 'Guaranies' ELSE 'Dolares' END as moneda,cotizacion,to_char (fecha, 'DD-MM-YYYY') as fecha from covid_monto";
            return ejecutarConsulta($sql);		
    }

    public function mostrar($codigo)
    {
            $sql="SELECT codigo,to_char (fecha, 'DD-MM-YYYY') as fecha,descripcion,monto,moneda, cotizacion from covid_monto where codigo='$codigo'";
            
            return ejecutarConsulta($sql);		
    }


}

?>