var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	//listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	
	//Cargamos los items al select llamado
	$.post("../ajax/util.php?op=selectLlamado", function(r){
	            $("#idllamado").html(r);
	            $('#idllamado').selectpicker('refresh');
	        });
	//Cargamos los items al select proveedor
	$.post("../ajax/util.php?op=selectProveedor", function(r){
	            $("#codigo_proveedor").html(r);
	            $('#codigo_proveedor').selectpicker('refresh');	
	        });                  	
}

//Función limpiar
function limpiar()
{
	$("#lote").val("");
	$("#item").val("");	
	$("#unidad").val("");
	$("#descripcion").val("");
	$("#presentacion").val("");
	$("#marca").val("");
	$("#procedencia").val("");
	$("#cant_minima").val("");
	$("#cant_maxima").val("");
	$("#precio").val("");
	$("#mont_min").val("");
	$("#mont_max").val("");
	$("#cod_siciap").val("");
	$("#cant_emitido").val("");
	$("#cant_ampliado").val("");
	$("#idproducto").val("");
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
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

//Función Listar
function listar()
{
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
					url: '../ajax/producto.php?op=listar',
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
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
        $("#codigo_medicamento").prop("disabled",false);       

	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/producto.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}

function mostrar(idproducto)
{
	$.post("../ajax/producto.php?op=mostrar",{idproducto : idproducto}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#idtipo").html(data.idtipoproducto);
	    $('#idtipo').selectpicker('refresh');
		$("#idgrupo").html(data.idgrupo);
	    $('#idgrupo').selectpicker('refresh');
		$("#idrubro").html(data.idrubro);
	    $('#idrubro').selectpicker('refresh');
		$("#idllamado").html(data.idllamado);
	    $('#idllamado').selectpicker('refresh');
	$("#idproveedor").html(data.idproveedor);
	    $('#idproveedor').selectpicker('refresh');
		$("#lote").val(data.lote);
		$("#item").val(data.item);	
		$("#unidad").val(data.unidadmedida);
		$("#descripcion").val(data.descripcion);
		$("#presentacion").val(data.presentacion);
		$("#marca").val(data.marca);
		$("#procedencia").val(data.procedencia);
		$("#cant_minima").val(data.cant_min);
		$("#cant_maxima").val(data.cant_max);
		$("#precio").val(data.precio_uni);
		$("#mont_min").val(data.monto_min);
		$("#mont_max").val(data.monto_max);
		$("#cod_siciap").val(data.cod_siciap);
		$("#cant_emitido").val(data.cant_emitido);
		$("#cant_ampliado").val(data.cant_ampliado);
		$("#idproducto").val(data.idproducto);

 	})
}

//Función para desactivar registros
function desactivar(idproducto)
{
	bootbox.confirm("¿Está Seguro de desactivar el Producto?", function(result){
		if(result)
        {
        	$.post("../ajax/producto.php?op=desactivar", {idproducto : idproducto}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idproducto)
{
	bootbox.confirm("¿Está Seguro de activar el Producto?", function(result){
		if(result)
        {
        	$.post("../ajax/producto.php?op=activar", {idproducto : idproducto}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

function listarProducto(){
  
   tabla=$('#tbllistado').dataTable(
        {
         "lengthMenu": [ 5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
         "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
            buttons: [            
                     ],
         "ajax":
           {
            url: '../ajax/producto.php?op=listarProducto',
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
            "order": [[ 1, "desc" ]]//Ordenar (columna,orden)
     
            
        }).DataTable();
       
    
}
 

init();