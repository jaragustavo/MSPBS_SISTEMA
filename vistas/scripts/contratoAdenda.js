var tabla;
$('.datepicker').datepicker({

    format: "dd-mm-yyyy",
    language: "es",
    autoclose: true

});
//Función que se ejecuta al inicio
$("#formulario").on("submit",function(e)
{
        guardaryeditar(e);	
});
function init(){
	mostrarform(false);
	listar();
      //  alert('hola');
        var cont=0;
	
	
	$.post("../ajax/util.php?op=selectLlamado", function(r){
	            $("#codigo_llamado").html(r);
	            $('#codigo_llamado').selectpicker('refresh');
	        });
                
   
         $.post("../ajax/util.php?op=selectEstadoItem", function(r){
	            $("#codigo_estado_item").html(r);
	            $('#codigo_estado_item').selectpicker('refresh');
	        });       
	//Cargamos los items al select proveedor
	$.post("../ajax/util.php?op=selectProveedor", function(r){
	            $("#codigo_proveedor").html(r);
	            $('#codigo_proveedor').selectpicker('refresh');	
	        }); 
  
        $.post("../ajax/util.php?op=selectSucursal", function(r){
	            $("#codigo_sucursal_origen").html(r);
	            $('#codigo_sucursal_origen').selectpicker('refresh');	
	        });         
    
    $('.datepicker').datepicker({
    format: "dd-mm-yyyy",
    language: "es",
    locale: "es",
    autoclose: true   
    });
   
      
}

//Función limpiar
function limpiar(){
        $("#codigo").val("");
         $("#codigo_adjudicacion").val("");
        $("#codigo_medicamento").val("");
        $("#desProducto").val("");
	$("#lote").val("");
	$("#item").val("");	
	$("#cantidad_maxima").val("");
        $("#cantidad_emitida").val("");
	//$("#precio_unitario").val("");
     
	$("#codigo_estado_item").val("");
        $('#codigo_estado_item').selectpicker('refresh');
        $("#codigo_sucursal_origen").val("");
        $('#codigo_sucursal_origen').selectpicker('refresh');
        $("#codigo_llamado").val("");
        $('#codigo_llamado').selectpicker('refresh');
        $("#codigo_proveedor").val("");
        $('#codigo_proveedor').selectpicker('refresh');
        
        $("#precio").val("");
        $("#simese").val("");
        $("#fecha_pedido").val("");
	$("#fecha_vigencia").val("");
        $("#fecha_adenda").val("");
	$("#porcentaje_solicitado").val("");	
	$("#monto_ampliado").val("");
        $("#cantidad_solicitada").val("");
        $("#cantidad_emitida").val("");
        $("#cantidad_adjudicada").val("");
        $("#observacion").val("");
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
                $("#btnagregar").hide();
                $("#btnagregar").hide();
                 $("#btncerrar").hide();
     			
	}
	else
	{
                               
                $("#formularioregistros").hide();
                $("#listadoregistros").show();
                $("#btnagregar").show();
                $("#btncerrar").show();
             
    
    
   
              
                
		
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
{
    //alert('Hola');
	tabla=$('#tbllistado').dataTable(
	{
		"lengthMenu": [ 5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/contratoAdenda.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"language": {
            "lengthMenu": "Mostrar : _MENU_ registros",
            "buttons": {
            "copyTitle": "Tabla Copiada",
            "copySuccess": {
                    _: '%d líneas copiadas',
                    1: '1 línea copiada'
                }
            }
        },
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	
        e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
        $("#codigo_medicamento").prop("disabled",false);       
        $("#item").prop("disabled",false);
        $("#lote").prop("disabled",false);
        $("#cantidad_adjudicada").prop("disabled",false);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
      	    url: "../ajax/contratoAdenda.php?op=guardaryeditar",
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
        $("#codigo_medicamento").prop("disabled",true); 
        $("#item").prop("disabled",true);
        $("#lote").prop("disabled",true);
        $("#cantidad_adjudicada").prop("disabled",true);
     //  limpiar();
	
}

function mostrar(codigo_adenda)
{
  //   alert("hola");
	$.post("../ajax/contratoAdenda.php?op=mostrar",{codigo_adenda:codigo_adenda}, function(data, status)
	{
          //  alert("chau");
		data = JSON.parse(data);		
		mostrarform(true);
                $("#codigo").val(codigo_adenda);
		$("#codigo_llamado").val(data.codigo_llamado);
                $('#codigo_llamado').selectpicker('refresh');
                
               // alert(data.codigo_proveedor);
	        $("#codigo_proveedor").val(data.codigo_proveedor);
                $('#codigo_proveedor').selectpicker('refresh');
                $("#codigo_medicamento").val(data.codigo_medicamento);
                $("#desProducto").val(data.producto);
                $("#lote").val(data.lote);
                $("#item").val(data.item);
                $("#cantidad_adjudicada").val(data.cantidad_adjudicada);
                formatNumero(document.getElementById("cantidad_adjudicada"));
                $("#cantidad_emitida").val(data.cantidad_emitida);
                formatNumero(document.getElementById("cantidad_emitida"));
                $("#simese").val(data.simese);
                $("#codigo_sucursal_origen").val(data.codigo_sucursal_origen);
                $('#codigo_sucursal_origen').selectpicker('refresh');
                $("#fecha_pedido").val(data.fecha_pedido);
                $("#fecha_vigencia").val(data.fecha_vigencia);
                $("#fecha_adenda").val(data.fecha_adenda);
                $("#codigo_estado_item").val(data.codigo_estado_item);
                $('#codigo_estado_item').selectpicker('refresh');
                $("#porcentaje_solicitado").val(data.porcentaje_solicitado);
                $("#monto_ampliado").val(data.monto_ampliado);
                formatNumero(document.getElementById("monto_ampliado"));
                $("#cantidad_solicitada").val(data.cantidad_solicitada);
                formatNumero(document.getElementById("cantidad_solicitada"));
                $("#cantidad_emitida_ampliacion").val(data.cantidad_emitida_ampliacion);
                formatNumero(document.getElementById("cantidad_emitida_ampliacion"));
                $("#observacion").val(data.observacion);  
                $("#precio").val(data.precio);  
            
            
 	})
       
      
       
   
        
}



function listarProductoContrato(){
    var codigo_adjudicacion = $('#codigo_adjudicacion').val();
    var codigo_proveedor = $('#codigo_proveedor').val();
   
   tabla=$('#tbllistadoProducto').dataTable(
        {
         "lengthMenu": [ 5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
         "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
            buttons: [            
                     ],
         "ajax":
           {
            url: '../ajax/contratoAdenda.php?op=listarProductoContrato',
            'data' : { 'codigo_adjudicacion' : codigo_adjudicacion ,
                       'codigo_proveedor'    : codigo_proveedor},
            type : "post",
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
            "order": [[ 1, "desc" ]]//Ordenar (columna,orden)
     
            
        }).DataTable();
       
    
}
function obtenerAdjudicacion(valor)
{
   // alert('entre'+valor.value);
    $.post("../ajax/contratoAdenda.php?op=obtenerAdjudicacion",{codigo_llamado : valor.value}, function(data, status)
    {
        data = JSON.parse(data);        
    //    alert ('HOLA ' + data['codigo']);
        $("#codigo_adjudicacion").val(data['codigo']);
     //   $("#monto_adjudicado").val(data['monto_adjudicado']);
    //    formatNumero(document.getElementById("monto_adjudicado"));
  //      $("#fecha_adjudicacion").val(data['fecha_adjudicacion']);
       // $('#idcodigo').prop('disabled',true);
        
    });
 }
 
 

init();