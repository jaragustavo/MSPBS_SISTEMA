<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class Linea
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros
    public function insertar($desLinea,$codigoLinea)
    {
        $sql="select pr_generar_codigo2  as codigo from pr_generar_codigo2(2 ::INTEGER)";
        $rspta  = ejecutarProcedimiento($sql);
        $codigo = pg_fetch_row($rspta);
        //error_log('$$$$$$$$$$ '.$rspta[0]);
        
        $sql="INSERT INTO lineas (linea,des_linea,codigo,estado,usu_ultmod,fec_ultmod,usu_alta,fec_alta)
        VALUES ($codigo[0],'$desLinea','$codigoLinea','AC','gjara','20190501','gjara','20190501');";
        error_log('####### '.$sql);
        
        
        return ejecutarConsulta($sql);
    }
 
    //Implementamos un método para editar registros
    public function editar($idlinea,$linea,$codigoLinea)
    {
        $sql="UPDATE lineas SET des_linea='$linea',codigo='$codigoLinea' WHERE linea=".$idlinea.";";
       
//error_log($sql);
        return ejecutarConsulta($sql);
    }
 
    //Implementamos un método para desactivar categorías
    public function desactivar($idlinea)
    {
        $sql="UPDATE lineas SET estado='IN' WHERE linea=".$idlinea.";";
        return ejecutarConsulta($sql);
    }
 
    //Implementamos un método para activar categorías
    public function activar($idlinea)
    {
        $sql="UPDATE lineas SET estado='AC' WHERE linea=".$idlinea.";";
        return ejecutarConsulta($sql);
    }
 
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idlinea)
    {
        $sql="SELECT * FROM lineas WHERE linea=".$idlinea.";";
       // error_log('sssssssssssss '.$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
 
    //Implementar un método para listar los registros
    public function listar()
    {
        $sql="SELECT * FROM lineas";
        return ejecutarConsulta($sql);      
    }
    //Implementar un método para listar los registros y mostrar en el select
    public function select()
    {
        $sql="SELECT * FROM categoria where condicion=1";
        return ejecutarConsulta($sql);      
    }
}
 
?>