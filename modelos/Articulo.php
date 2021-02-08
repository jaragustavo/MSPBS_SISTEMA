<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class Articulo
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros
    public function insertar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen)
    {
        $sql="INSERT INTO articulo (idcategoria,codigo,nombre,stock,descripcion,imagen,condicion)
        VALUES ('$idcategoria','$codigo','$nombre','$stock','$descripcion','$imagen','1')";
        return ejecutarConsulta($sql);
    }
 
    //Implementamos un método para editar registros
    public function editar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen)
    {
        $sql="UPDATE articulo SET idcategoria='$idcategoria',codigo='$codigo',nombre='$nombre',stock='$stock',descripcion='$descripcion',imagen='$imagen' WHERE idarticulo='$idarticulo'";
        return ejecutarConsulta($sql);
    }
 
    //Implementamos un método para desactivar registros
    public function desactivar($idarticulo)
    {
        $sql="UPDATE articulo SET condicion='0' WHERE idarticulo='$idarticulo'";
        return ejecutarConsulta($sql);
    }
 
    //Implementamos un método para activar registros
    public function activar($idarticulo)
    {
        $sql="UPDATE articulo SET condicion='1' WHERE idarticulo='$idarticulo'";
        return ejecutarConsulta($sql);
    }
 
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idarticulo)
    {
        $sql="SELECT * FROM articulo WHERE idarticulo='$idarticulo'";
        return ejecutarConsultaSimpleFila($sql);
    }
 
    //Implementar un método para listar los registros
    public function listar()
    {
        $sql="SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN categoria c ON a.idcategoria=c.idcategoria";
        return ejecutarConsulta($sql);      
    }
 
    //Implementar un método para listar los registros activos
    public function listarActivos()
    {
        $sql="select y.codigo, y.producto, coalesce(cant_meses_distribuido,0) as cant_meses_distribuido, coalesce(cant_distribuida, 0) as cant_distribuida, coalesce(STOCK_ACTUAL,0) as STOCK_ACTUAL, coalesce(DMP,0) as DMP, coalesce(disponibilidad, 0) as disponibilidad  from
(select stock.codigo_medicamento,(select clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion from descripcion_medicamento 
              where codigo= stock.codigo_medicamento) as producto,coalesce(cant_meses_distribuido, '0')as cant_meses_distribuido,coalesce(cant_distribuida, '0') as cant_distribuida , STOCK_ACTUAL, coalesce(DMP,'0') as DMP,
    coalesce(ROUND(CASE WHEN DMP=0 THEN 0            
            ELSE STOCK_ACTUAL/DMP
    END),'0') AS disponibilidad   
 from 
                (select codigo_medicamento, clasificacion_medicamento, concentracion, forma_farmaceutica, presentacion, stock_actual from 
                (Select codigo_medicamento, sum(cantidad) as STOCK_ACTUAL 
                 from 
                public.stock_medicamento a, 
                public.sucursal b where 
                a.codigo_sucursal = b.codigo 
                and b.codigo_tipo_sucursal = 11 
                and a.codigo_sucursal <> 1808 
                group by codigo_medicamento
                order by codigo_medicamento asc) as saldo
                inner join
                (select * from descripcion_medicamento) as descripcion
                on (saldo.codigo_medicamento=descripcion.codigo)
                ) as stock

                left join

                (select codigo_medicamento, clasificacion_medicamento, concentracion, forma_farmaceutica, presentacion,count(*) as cant_meses_distribuido, sum(cantidad_x_mes) as cant_distribuida, round((sum(cantidad_x_mes))/count(*)) as DMP from
                (Select codigo_medicamento, clasificacion_medicamento, concentracion, forma_farmaceutica, presentacion, sum(cant_distribuida) cantidad_x_mes, mes, año  from 
                (select codigo_medicamento, clasificacion_medicamento, concentracion, forma_farmaceutica, presentacion, cant_distribuida, fecha_hora, extract(month FROM fecha_hora) as mes,extract(year FROM fecha_hora)as año   from 

                (select sum(a.cantidad) as cant_distribuida, b.codigo_medicamento, a.fecha_hora,
                c.codigo_tipo_sucursal
                from movimiento_stock a, 
                stock_medicamento b, sucursal c
                where 
                a.codigo_stock_medicamento=b.codigo and 
                b.codigo_sucursal = c.codigo and
                c.codigo_tipo_sucursal=11 and
                a.codigo_tipo_movimiento = 3 
                and a.fecha_hora between '20190101'  and
                'today' and b.codigo_sucursal not in(1808,1809) 
                group by b.codigo_medicamento, c.codigo_tipo_sucursal, a.fecha_hora
                order by b.codigo_medicamento) as distribucion
                inner join
                (select * from descripcion_medicamento) as descripcion
                on distribucion.codigo_medicamento=descripcion.codigo
                order by cant_distribuida desc) as distribucion_mes
                group by codigo_medicamento, clasificacion_medicamento, concentracion, forma_farmaceutica, presentacion, mes, año
                order by mes, año,  cantidad_x_mes desc) as distribucion_mes
                group by codigo_medicamento, clasificacion_medicamento, concentracion, forma_farmaceutica, presentacion
                order by clasificacion_medicamento asc) as dmp
                on(stock.codigo_medicamento = dmp.codigo_medicamento)) as stock
               right join
             (select codigo, clasificacion_medicamento||' '||coalesce(concentracion,'')||' '||forma_farmaceutica||' '||presentacion as producto from descripcion_medicamento 
              ) as Y ----descripcion de los productos-----;
              on(stock.codigo_medicamento= y.codigo);";
        return ejecutarConsulta($sql);      
    }
   public function listarReactivo()
    {
        $sql="select x.codigo,codigo_contrataciones as codigo_catalogo, producto, trim(coalesce(concentracion, '')||' '||especificaciones_tecnicas) as especificacion_tecnica, presentacion from
(select a.codigo, clasificacion_medicamento as producto, concentracion, forma_farmaceutica as especificaciones_tecnicas, presentacion, codigo_estado from descripcion_medicamento a, medicamento b
where a.codigo = b.codigo and codigo_estado = 1 and a.codigo in (select  b.codigo_medicamento from grupo_medicamento a, rel_medicamento_grupo b
		where a.codigo = b.codigo_grupo
		and b.codigo_grupo= 8 --reactivo--
		group by b.codigo_medicamento, a.codigo)) as x
left join
(select * from rel_medicamento_producto_contrataciones a, producto_contrataciones b 
where a.codigo_producto_contrataciones = b.codigo and actual = 't') as y
on(x.codigo = y.codigo_medicamento) order by producto asc";
        return ejecutarConsulta($sql);      
    }
    
    public function listarProducto()
    {
        $sql="select x.codigo,codigo_contrataciones as codigo_catalogo, producto, trim(coalesce(concentracion, '')||' '||especificaciones_tecnicas) as especificacion_tecnica, presentacion from
(select a.codigo, clasificacion_medicamento as producto, concentracion, forma_farmaceutica as especificaciones_tecnicas, presentacion, codigo_estado from descripcion_medicamento a, medicamento b
where a.codigo = b.codigo and codigo_estado = 1 and a.codigo in (select  b.codigo_medicamento from grupo_medicamento a, rel_medicamento_grupo b
		where a.codigo = b.codigo_grupo
		--and b.codigo_grupo= 8 --reactivo--
		group by b.codigo_medicamento, a.codigo)) as x
left join
(select * from rel_medicamento_producto_contrataciones a, producto_contrataciones b 
where a.codigo_producto_contrataciones = b.codigo and actual = 't') as y
on(x.codigo = y.codigo_medicamento) order by producto asc";
        return ejecutarConsulta($sql);      
    }
    //Implementar un método para listar los registros activos, su último precio y el stock (vamos a unir con el último registro de la tabla detalle_ingreso)
 
}
 
?>