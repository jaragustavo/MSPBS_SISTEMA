<?php
require '../config/Conexion.php';
Class Permiso
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	public function listar()
	{
		$sql="select *
                      from permiso
                      where codigo in (select idpermiso from usuario_permiso )
                      order by codigo";
		return ejecutarConsulta($sql);		
	}
}

?>