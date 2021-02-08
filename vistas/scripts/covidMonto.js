var tabla;
 
//Función que se ejecuta al inicio
function init(){
    mostrarform(false);
    listar();
 
    
    $("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);  
    });   
    
    $('.datepicker').datepicker({
        
        format: "dd-mm-yyyy",
        language: "es",
        locale: "es",
        autoclose:true
       
    });

}
 
//Función limpiar
function limpiar()
{
    $("#codigo").val("");
    $("#descripcion").val("");
    $("#monto").val("");
    $("#fecha").val("");
    $("#moneda").val("");
    $('#moneda').selectpicker('refresh');
    $("#cotizacion").val("");
    
 
}


 
//Función mostrar formulario
function mostrarform(flag)
{
    limpiar();
    if (flag)
    {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        
        
        //Botones
        $("#btnagregar").hide();
        $("#btnGuardar").show();
        $("#btnCancelar").show(); 
        $("#btnEnviar").hide();
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
        
    }
}

//Función cancelarform
function cancelarform()
{
    limpiar();
    mostrarform(false);
}
 
function listar()
{
   
        tabla=$('#tbllistado').dataTable(
        {
                    "lengthMenu": [ 5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
         "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
            buttons: [ 
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                data = $('<p>' + data + '</p>').text();
                                return data.replace('.', ',');
                            }
                        }
                    }
                    }, 
                
                
                     'copyHtml5',
                   
                     'csvHtml5',
                     'pdf'
                 ],
        
          
                 
        
         "ajax":
           {
            url: '../ajax/covidMonto.php?op=listar',
            type : "get",
            dataType : "json",      
            error: function(e){
             console.log(e.responseText); 
            }
           },
           
           
           
           
         "language": {
                    "lengthMenu": "Mostrar : _MENU_ registros",
                    "buttons": {
                    "copyTitle": "Registros Copiados",
                    "copySuccess": {
                            _: '%d líneas copiadas',
                            1: '1 línea copiada'
                        }
                    }
                }, 
         "bDestroy": true,
         "iDisplayLength": 10,//Paginación
            "order": [[ 3, "asc" ]]//Ordenar (columna,orden)
        }).DataTable();
  }
    
 

//Función para guardar o editar
 
function guardaryeditar(e)
{
    e.preventDefault();

    $('#codigo').prop('disabled',false);
    
    //Formateador de Fechas
    var fecha= $('#fecha').val();
    fecha = fecha.substr(6,4)+fecha.substr(3,2)+fecha.substr(0,2)+''+fecha.substr(11,8)
    $('#fecha').val(fecha);

    
     //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);
 
    $.ajax({
        url: "../ajax/covidMonto.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
 
        success: function(datos)
        {                    
              bootbox.alert(datos);           
              mostrarform(false);
              listar();
        }
 
    });
    $('#codigo').prop('disabled',true);
    limpiar();
}


 
function mostrar(codigo)
{
    $.post("../ajax/covidMonto.php?op=mostrar",{codigo : codigo}, function(data, status)
    {
        data = JSON.parse(data);        
        mostrarform(true);

        $("#codigo").val(data.codigo);
        $("#fecha").val(data.fecha);
        $("#descripcion").val(data.descripcion);
        $("#monto").val(data.monto);
        $("#moneda").val(data.moneda);
        $('#moneda').selectpicker('refresh');
        $("#cotizacion").val(data.cotizacion);
        
       
        
 
        //Ocultar y mostrar los botones
        $("#btnGuardar").show();
        $("#btnCancelar").show();
    });

    
 
}


  
    

 init();