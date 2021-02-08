var tabla;
$('.datepicker').datepicker({
    format: "dd-mm-yyyy",
    language: "es",
    autoclose: true

});

//Función que se ejecuta al inicio
function init(){
    mostrarform(false);
    listar();
 
   // alert('stopt');
    $("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);  
    });

    $("#imagenmuestra").hide();

    $.post("../ajax/util.php?op=selectAdjudicacion", function(r){
        $("#codigo_adjudicacion").html(r);
        $('#codigo_adjudicacion').selectpicker('refresh');
    });

    $.post("../ajax/util.php?op=selectProveedor", function(r){
        $("#codigo_proveedor").html(r);
        $('#codigo_proveedor').selectpicker('refresh');	
        
    });

    $.post("../ajax/adjudicacionContrato.php?op=selectTipoVigencia", function(r){
        $("#codigo_tipo_vigencia").html(r);
        $('#codigo_tipo_vigencia').selectpicker('refresh');	
        
    });
    $.post("../ajax/adjudicacionContrato.php?op=selectEstadoContrato", function(r){
        $("#codigo_estado_contrato").html(r);
        $('#codigo_estado_contrato').selectpicker('refresh');	
        
    });
}
 
$("#icon_calendar").click(function() { 
    $("#fecha_contrato").datepicker( "show" );
});

$("#icon_calendar2").click(function() { 
    $("#vigencia").datepicker( "show" );
});

$("#icon_calendar3").click(function() { 
    $("#fecha_rescision").datepicker( "show" );
});

//Función limpiar
function limpiar()
{
    $("#codigo").val("");
    $("#codigo_adjudicacion").val("");
    $('#codigo_adjudicacion').selectpicker('refresh');
    $("#numero_contrato").val("");
    $("#codigo_proveedor").val("");
    $('#codigo_proveedor').selectpicker('refresh');	
    $("#fecha_contrato").val("");
    $("#vigencia").val("");
    $("#monto_contrato").val("");
    $("#imagenmuestra").attr("src", "");
    $("#porcentaje_mora").val("");
    $("#frecuencia_diaria_aumento_mora").val("");
    $("#fecha_rescision").val("");
    $("#porcentaje_rescision").val("");
    $("#codigo_tipo_vigencia").val("");
    $('#codigo_tipo_vigencia').selectpicker('refresh');	
    $("#codigo_estado_contrato").val("");
    $('#codigo_estado_contrato').selectpicker('refresh');	
    $("#obs").val("");
    $("#imagenactual").val("");
}


 
//Función mostrar formulario
function mostrarform(flag)
{
    limpiar();
    if (flag)
    {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnEntrega").hide();
        
        //Botones
        $("#btnagregar").hide();
        $("#btnGuardar").show();
        $("#btnEntrega").hide();
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
                               // return column = 12 ? data.replace( /[$,.]/g, ',' ) : data;
                              return column == 12 ? data.replace( /[.]/g, '.' ) : data.replace( /[.]/g, ',' );
                            //    return data.replace('.', ',');
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
            url: '../ajax/adjudicacionContrato.php?op=listar',
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
     
    var formData = new FormData($("#formulario")[0]);
 
    $.ajax({
        url: "../ajax/adjudicacionContrato.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
 
        success: function(datos)
        {                    
              bootbox.alert(datos);           
              mostrarform(false);
              listar();
        },
 
    });
    $('#codigo').prop('disabled',true);
    limpiar();
}


 
function mostrar(codigo)
{
    $.post("../ajax/adjudicacionContrato.php?op=mostrar",{codigo : codigo}, function(data, status)
    {
        data = JSON.parse(data);        
        mostrarform(true);
        
        $("#codigo").val(data.codigo);
        $("#codigo_adjudicacion").val(data.codigo_adjudicacion);
        $('#codigo_adjudicacion').selectpicker('refresh');	
        $("#numero_contrato").val(data.numero_contrato);
        $("#codigo_proveedor").val(data.codigo_proveedor);
        $('#codigo_proveedor').selectpicker('refresh');	
        $("#fecha_contrato").val(data.fecha_contrato);
        $("#vigencia").val(data.vigencia);
        $("#monto_contrato").val(data.monto_contrato);
        $("#porcentaje_mora").val(data.porcentaje_mora);
        $("#frecuencia_diaria_aumento_mora").val(data.frecuencia_diaria_aumento_mora);
        $("#porcentaje_rescision").val(data.porcentaje_rescision);
        $("#obs").val(data.obs);
        $("#codigo_estado_contrato").val(data.codigo_estado_contrato);
        $('#codigo_estado_contrato').selectpicker('refresh');
        $("#codigo_tipo_vigencia").val(data.codigo_tipo_vigencia);
        $('#codigo_tipo_vigencia').selectpicker('refresh');
        $("#fecha_rescision").val(data.fecha_rescision);

        if (data.imagen === "" || data.imagen === null || data.imagen == undefined) {
            $("#imagenmuestra").hide();
        }
        else {
            $("#imagenmuestra").show();
            $("#imagenmuestra").attr("src", "../files/adjudicacionContrato/" + data.imagen);
            $("#imagenactual").val(data['imagen']);
        }
       

        //Ocultar y mostrar los botones
        $("#btnGuardar").show();
        $("#btnCancelar").show();

        $.post("../ajax/adjudicacionContrato.php?op=listarEntregas&id=" + codigo, function (r) {
            $("#entregas").html(r);
        }); 


    });

}

 init();