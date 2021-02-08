<?php

$user = "postgres";
$passwd = "postgres";
$db = "siciap_01";
//$db = "marelli_db";
$port = 5432;
$host = "localhost";


//$host = "192.168.12.10";

/*

$user = "mspbs_siciap_usuario";
$passwd = "gestockadmin";
$db = "mspbs_siciap";
//$db = "marelli_db";
$port = 5432;
$host = "192.168.1.61";
*/

$strCnx = "host=$host dbname=$db user=$user password=$passwd";
$conexion = pg_connect($strCnx) or die ("Error de conexion. ".pg_last_error());

if (!function_exists('ejecutarConsulta'))
{
	function ejecutarConsulta($sql)
	{
		global $conexion;
		$query = pg_query($conexion,$sql);
                //pg_close($conexion);
                return $query;
	}
        function ejecutarProcedimiento($sql)
	{
		global $conexion;
		$result = pg_exec($conexion,$sql);
               // pg_close($conexion);
                return $result;
	}

	function ejecutarConsultaSimpleFila($sql)
	{
		global $conexion;
                $query = pg_query($conexion,$sql);
                
              //  error_log('######### '.$sql);
                 //pg_close($conexion);
                  // $query = pg_fetch_row($query);
	       	return $query;	        
                 
	}

	function ejecutarConsulta_retornarID($sql)
	{
		global $conexion;
                
		$query = pg_query($conexion,$sql);
                $reg=pg_fetch_row($query);
              //  error_log('############ '.$reg[0]);
               	return $reg[0];			
	}
       

	function limpiarCadena($str)
	{
		global $conexion;
               // error_log('qqqqqqqqqqqqqq');
		//$str = mysqli_real_escape_string($conexion,trim($str));
		return htmlspecialchars($str);
	}
}
?>


