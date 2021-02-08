<?php
require "../config/Conexion.php";
 
Class Util
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
    function sacar_puntos_comas($cadena){ 
       
        for ($i=0;$i<strlen($cadena);$i++){ 
           // error_log('### '.strlen($cadena));
           if ($cadena[$i]=='.'){ 
                $cadena[$i]=''; 
                } 
            if ($cadena[$i]==','){ 
                $cadena[$i]=''; 
            } 
         } 
    return $cadena; 
    }  
    
     public  function selectEstado()
    {
          $sql="select * from estado_covid order by codigo";
          
        return ejecutarConsultaSimpleFila($sql);
    }
     public  function selectDependenciaMsp()
    {
          $sql="select * from dependencia_msp order by codigo";
          
        return ejecutarConsultaSimpleFila($sql);
    }
     public  function selectUsuarioDependencia()
    {
          $sql="select idusuario,nombre_usuario,codigo_dependencia,(select nombre from dependencia_msp where codigo = codigo_dependencia) as nombre_dependencia
                from (
                SELECT cedula_identidad,nombres ||','||apellidos as nombre_usuario
                FROM USUARIO ) as usuario
                inner join
                (
                select * from usuario_dependencia
                ) as usuDep
                on usuario.cedula_identidad = usuDep.idusuario";
          
          //error_log("NOSE".$sql);
          
        return ejecutarConsultaSimpleFila($sql);
    }
    
   public  function selectMedicamento()
    {
          $sql="select codigo,producto
                from (
                select codigo,codigo ||' '|| clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion as producto 
                from descripcion_medicamento
                ) as descripcion
                inner join
                (
                select codigo as codigo_medicamento
                from medicamento
                where codigo_estado =1
                ) as medicamento
                on descripcion.codigo = medicamento.codigo_medicamento";

        return ejecutarConsultaSimpleFila($sql);
    }
    public  function selectProveedor()
    {
          $sql="SELECT codigo, nombre, contacto, correo, telefono, direccion, ruc, codigo_estandar, 
                 codigo_estado, gln
                 FROM laboratorio
                 WHERE codigo_estado = 1";

        return ejecutarConsultaSimpleFila($sql);
    }
    public  function selectLlamado()
    {
          $sql="select codigo,(select abreviacion from tipo_adjudicacion where codigo = codigo_tipo_llamado)  ||' '||numero||'/'||anio as nombre
                from llamado ";

        return ejecutarConsultaSimpleFila($sql);
    }
    
     public  function selectTipoDescuentoSaldo()
    {
          $sql="SELECT *
                FROM tipo_descuento_saldo ";

        return ejecutarConsultaSimpleFila($sql);
    }
      public  function selectEstadoItem()
    {
          $sql="SELECT *
                FROM estado_item";

        return ejecutarConsultaSimpleFila($sql);
    }
       public  function selectTipoDias()
    {
          $sql="SELECT *
                FROM tipo_dias";

        return ejecutarConsultaSimpleFila($sql);
    }
     public  function selectTipoPlazo()
    {
          $sql="SELECT *
                FROM tipo_plazo";

        return ejecutarConsultaSimpleFila($sql);
    }
    
       public  function selectTipoDescuentoItem()
    {
          $sql="SELECT *
                FROM tipo_descuento_item";

        return ejecutarConsultaSimpleFila($sql);
    }
    public  function selectTipoLlamado()
    {
          $sql="select * from tipo_adjudicacion order by codigo";
      //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
     public  function selectEstadoLlamado()
    {
          $sql="select * from estado_llamado order by codigo";
      //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
     public  function selectSucursal()
    {
          $sql="select * from sucursal order by codigo";
      //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
      public  function selectHospitalRegiones()
    {
          $sql="select codigo, nombre from sucursal where codigo_tipo_sucursal in (2,8) and codigo_estado = 1 or codigo = 289
order by nombre asc";
      //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
     public  function selectEstadoPedido()
    {
          $sql="select * from estado_pedido where codigo <> 1 order by codigo";
      //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
     public  function selectTipoPedido()
    {
          $sql="select * from tipo_pedido order by codigo";
      //  error_log("##############".$sql);
        return ejecutarConsultaSimpleFila($sql);
    }
   public  function selectAdjudicacion()
    {
          $sql="select a.codigo,ta.abreviacion ||' '||a.numero||'/'||a.anio as nombre
          from adjudicacion as a
          left join tipo_adjudicacion as ta on a.codigo_tipo_adjudicacion = ta.codigo
          where   a.codigo_sucursal = 1
          order by ta.abreviacion,a.numero,a.anio desc";
          
        return ejecutarConsultaSimpleFila($sql);
    }
    
}