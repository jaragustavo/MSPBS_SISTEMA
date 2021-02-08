<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class Usuario
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros
    public function insertar($nombre,$cedula_identidad,$login,$clave,$permisos)
   
    {
        $sql="INSERT INTO usuario (nombre,cedula_identidad,login,clave,estado)
        VALUES ('$nombre','$cedula_identidad','$login','$clave','AC');select currval( 'usuario_idusuario_seq' )::BIGINT;";
       // return ejecutarConsulta($sql);
        $idusuarionew=ejecutarConsulta_retornarID($sql);
 
        $num_elementos=0;
        $sw=true;
 
        while ($num_elementos < count($permisos))
        {
            $sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES('$idusuarionew', '$permisos[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
        }
 
        return $sw;
    }
 
    //Implementamos un método para editar registros
       public function editar($idusuario,$permisos)
 //   public function editar($idusuario,$nombre,$cedula_identidad,$login,$clave)
   
            {
     //   $sql="UPDATE usuario SET nombre='$nombre',cedula_identidad='$cedula_identidad',login='$login',clave='$clave' WHERE idusuario='$idusuario'";
       // ejecutarConsulta($sql);
 
        //Eliminamos todos los permisos asignados para volverlos a registrar
        $sqldel="DELETE FROM usuario_permiso WHERE idusuario=".$idusuario.";";
        
        ejecutarConsulta($sqldel);
 
        $num_elementos=0;
        $sw=true;
 
        while ($num_elementos < count($permisos))
        {
       
            $sql_detalle = "INSERT INTO usuario_permiso(idusuario, idpermiso) VALUES('$idusuario', '$permisos[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
        //     error_log('###########'.$sql_detalle);
            $num_elementos=$num_elementos + 1;
        }
 
        return $sw;
 
    }
 
    //Implementamos un método para desactivar categorías
    public function desactivar($idusuario)
    {
        $sql="UPDATE usuario SET condicion='0' WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }
 
    //Implementamos un método para activar categorías
    public function activar($idusuario)
    {
        $sql="UPDATE usuario SET condicion='1' WHERE idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }
 
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idusuario)
    {
        $sql="SELECT * FROM usuario WHERE cedula_identidad=".$idusuario.";";
        return ejecutarConsultaSimpleFila($sql);
    }
 
    //Implementar un método para listar los registros
    public function listar()
    {
        $sql="SELECT * FROM usuario";
        return ejecutarConsulta($sql);      
    }
    //Implementar un método para listar los permisos marcados
    public function listarmarcados($idusuario)
    {
        $sql="SELECT * FROM usuario_permiso WHERE idusuario=".$idusuario.";";
        return ejecutarConsulta($sql);
    }
 
    //Función para verificar el acceso al sistema
    public function verificar($login,$clave)
    {
      //   error_log('#########clave '.$clave);
        $sql="SELECT cedula_identidad,nombres || ' '|| apellidos FROM usuario WHERE cedula_identidad='$login'  AND contrasenia='$clave'"; 
   //  error_log('############ '.$sql);
        return ejecutarConsulta($sql);  
    }
     public function selectUsuario()
    {
        $sql="SELECT identificador as idusuario,trim(apellidos)||' '||trim(nombres) ||'-'|| cedula_identidad as nombre FROM usuario  
             where cedula_identidad in (select idusuario from usuario_permiso)
              order by nombre;";
        
        return ejecutarConsultaSimpleFila($sql);
    }
}
 
?>