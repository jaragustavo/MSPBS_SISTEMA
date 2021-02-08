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
        var cont=0;
	
	
	$.post("../ajax/util.php?op=selectLlamado", function(r){
	            $("#codigo_llamado").html(r);
	            $('#codigo_llamado').selectpicker('refresh');
	        });
                
         $.post("../ajax/util.php?op=selectTipoPlazo", function(r){
	            $("#codigo_tipo_plazo_popup").html(r);
	            $('#codigo_tipo_plazo_popup').selectpicker('refresh');
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
        $.post("../ajax/util.php?op=selectTipoDias", function(r){
	            $("#codigo_tipo_dias_popup").html(r);
	            $('#codigo_tipo_dias_popup').selectpicker('refresh');	
	        }); 
        $.post("../ajax/util.php?op=selectTipoDescuentoItem", function(r){
	            $("#codigo_tipo_descuento_item_popup").html(r);
	            $('#codigo_tipo_descuento_item_popup').selectpicker('refresh');	
	        }); 
        $.post("../ajax/util.php?op=selectSucursal", function(r){
	            $("#codigo_sucursal_popup").html(r);
	            $('#codigo_sucursal_popup').selectpicker('refresh');	
	        });         
                
        $("#divcodigo_llamado").show();
	$("#divcodigo_proveedor").show();
	$("#divcodigo_estado_item_adjudicacion").show();
   
      
}
$("#btnAgregarEntrega").on('click', function () {
    agregarEntregaItemPopup();

});
$("#btnAgregarDetalleLugarEntrega").on('click', function () {
    agregarDetalleLugarEntregaPopup();

});



function cerrarPopup() {
    $('#mpopupBox').hide();
    // Maite Inicio
    $("#divcodigo_llamado").show();
    $("#divcodigo_proveedor").show();
    $("#divcodigo_estado_item_adjudicacion").show();
}

function cerrarPopupLugarEntrega() {
    $('#mpopupDetalleLugarEntrega').hide();
    // Maite Inicio
    $("#divcodigo_llamado").show();
    $("#divcodigo_proveedor").show();
    $("#divcodigo_estado_item_adjudicacion").show();
}


function agregarEntrega() {
	//var btn_1 = document.getElementById('btnAgregar' + codigo);
       //  alert('hola2');
        numero_entrega = document.getElementById("numero_entrega_popup").value;
        plazo = document.getElementById("plazo_popup").value;
       
        codigo_tipo_dias = document.getElementById("codigo_tipo_dias_popup").value;
        des_tipo_dias = document.getElementById("codigo_tipo_dias_popup");
        des_tipo_dias = des_tipo_dias.options[des_tipo_dias.selectedIndex].text;
       
        codigo_tipo_descuento_item = document.getElementById("codigo_tipo_descuento_item_popup").value;
        des_tipo_descuento_item = document.getElementById("codigo_tipo_descuento_item_popup");
        des_tipo_descuento_item = des_tipo_descuento_item.options[des_tipo_descuento_item.selectedIndex].text;
      
        codigo_tipo_plazo = document.getElementById("codigo_tipo_plazo_popup").value;
        des_tipo_plazo = document.getElementById("codigo_tipo_plazo_popup");
        des_tipo_plazo = des_tipo_plazo.options[des_tipo_plazo.selectedIndex].text;
     
        porcentaje = document.getElementById("porcentaje_popup").value;
        porcentaje_complementario = document.getElementById("porcentaje_complementario_popup").value;
       
	if (numero_entrega != "") {
                
                cont=cont +1; 
		var fila = '<tr  scope="col" id="fila' + cont + '" class="filas" style="font-size: 12px;" >' +
			'<td scope="col" style="text-align: center;"><div style="width: 15px;"><a class="btn btn-accent m-btn m-btn--custom' +
			'm-btn--icon m-btn--air m-btn--pill" type="button" onclick="eliminarDetalle(' + cont + ')" style="padding: unset;">' +
			'<span><i class="fa fa-trash" style="color: indianred; "></i></span></a>' +
			'<td scope="col"><div style="width: 50px; font-size: 80%;"><input type="hidden" readonly="readonly" name="numero_entrega[]" value="' + numero_entrega + '">' + numero_entrega + ' </div></td>' +
			'<td scope="col"><div style="width: 65px; font-size: 80%;"><input type="text" readonly="readonly" name="plazo[]" size="7" value="' + plazo + '"></div></td>' +
                        '<td scope="col"><input type="hidden" readonly="readonly" name="codigo_tipo_plazo[]" value="' + codigo_tipo_plazo + '">' + des_tipo_plazo + ' </td>' +
		      
                        '<td scope="col"><div style="width: 50px; font-size: 80%;"><input type="hidden" readonly="readonly" name="codigo_tipo_dias[]" value="' + codigo_tipo_dias + '">' + des_tipo_dias + ' </div></td>' +
			'<td scope="col"><input type="hidden" readonly="readonly" name="codigo_tipo_descuento_item[]" value="' + codigo_tipo_descuento_item + '">' + des_tipo_descuento_item + ' </td>' +
              		'<td scope="col"><input type="hidden" readonly="readonly" name="porcentaje[]" value="' + porcentaje + '">' + porcentaje + ' </td>' +
                        '<td scope="col"><input type="hidden" readonly="readonly" name="porcentaje_complementario[]" value="' + porcentaje_complementario + '">' + porcentaje_complementario + ' </td>' +
		'</tr>';

		cont++;
		detalles = detalles + 1;
		$('#detalles').append(fila);
                $("#divcodigo_llamado").show();
                $("#divcodigo_proveedor").show();
                $("#divcodigo_estado_item_adjudicacion").show();
		//evaluar();

		//  modificarSubototales();
	}
	else {
		alert("Error al ingresar el detalle, revisar los datos del artículo");
	}
	detalles = detalles + 1;
	$('#tblEntregaItem').append(fila);
	$('#mpopupBox').hide();
}

function agregarDetalleEstablecimientoContrato() {
	//var btn_1 = document.getElementById('btnAgregar' + codigo);
       
        numero_entrega = document.getElementById("numero_entrega_popup").value;
        plazo = document.getElementById("plazo_popup").value;
       
        codigo_tipo_dias = document.getElementById("codigo_tipo_dias_popup").value;
        des_tipo_dias = document.getElementById("codigo_tipo_dias_popup");
        des_tipo_dias = des_tipo_dias.options[des_tipo_dias.selectedIndex].text;
       
        codigo_tipo_descuento_item = document.getElementById("codigo_tipo_descuento_item_popup").value;
        des_tipo_descuento_item = document.getElementById("codigo_tipo_descuento_item_popup");
        des_tipo_descuento_item = des_tipo_descuento_item.options[des_tipo_descuento_item.selectedIndex].text;
      
        codigo_tipo_plazo = document.getElementById("codigo_tipo_plazo_popup").value;
        des_tipo_plazo = document.getElementById("codigo_tipo_plazo_popup");
        des_tipo_plazo = des_tipo_plazo.options[des_tipo_plazo.selectedIndex].text;
     
        porcentaje = document.getElementById("porcentaje_popup").value;
        porcentaje_complementario = document.getElementById("porcentaje_complementario_popup").value;
       
	if (numero_entrega != "") {
                
                cont=cont +1; 
		var fila = '<tr  scope="col" id="fila' + cont + '" class="filas" style="font-size: 12px;" >' +
			'<td scope="col" style="text-align: center;"><div style="width: 15px;"><a class="btn btn-accent m-btn m-btn--custom' +
			'm-btn--icon m-btn--air m-btn--pill" type="button" onclick="eliminarDetalle(' + cont + ')" style="padding: unset;">' +
			'<span><i class="fa fa-trash" style="color: indianred; "></i></span></a>' +
			'<td scope="col"><div style="width: 50px; font-size: 80%;"><input type="hidden" readonly="readonly" name="numero_entrega[]" value="' + numero_entrega + '">' + numero_entrega + ' </div></td>' +
			'<td scope="col"><div style="width: 65px; font-size: 80%;"><input type="text" readonly="readonly" name="plazo[]" size="7" value="' + plazo + '"></div></td>' +
                        '<td scope="col"><input type="hidden" readonly="readonly" name="codigo_tipo_plazo[]" value="' + codigo_tipo_plazo + '">' + des_tipo_plazo + ' </td>' +
		      
                        '<td scope="col"><div style="width: 50px; font-size: 80%;"><input type="hidden" readonly="readonly" name="codigo_tipo_dias[]" value="' + codigo_tipo_dias + '">' + des_tipo_dias + ' </div></td>' +
			'<td scope="col"><input type="hidden" readonly="readonly" name="codigo_tipo_descuento_item[]" value="' + codigo_tipo_descuento_item + '">' + des_tipo_descuento_item + ' </td>' +
              		'<td scope="col"><input type="hidden" readonly="readonly" name="porcentaje[]" value="' + porcentaje + '">' + porcentaje + ' </td>' +
                        '<td scope="col"><input type="hidden" readonly="readonly" name="porcentaje_complementario[]" value="' + porcentaje_complementario + '">' + porcentaje_complementario + ' </td>' +
		'</tr>';

		cont++;
		detalles = detalles + 1;
		$('#detalles').append(fila);
                $("#divcodigo_llamado").show();
                $("#divcodigo_proveedor").show();
                $("#divcodigo_estado_item_adjudicacion").show();
		//evaluar();

		//  modificarSubototales();
	}
	else {
		alert("Error al ingresar el detalle, revisar los datos del artículo");
	}
	detalles = detalles + 1;
	$('#tblEntregaItem').append(fila);
	$('#mpopupBox').hide();
}

function agregarEntregaItemPopup() {

    // get the mPopup
 
    var mpopup = $('#mpopupBox');

    // open the mPopup
    mpopup.show();
    $("#divcodigo_llamado").hide();
    $("#divcodigo_proveedor").hide();
    $("#divcodigo_estado_item_adjudicacion").hide();
   // $('#mpopupBox').show();
        //alert('hola');
    // close the mPopup once close element is clicked
    $(".close").on('click', function () {
        mpopup.hide();
        $("#divcodigo_llamado").show();
        $("#divcodigo_proveedor").show();
        $("#divcodigo_estado_item_adjudicacion").show();
    });

    // close the mPopup when user clicks outside of the box
    $(window).on('click', function (e) {
        if (e.target == mpopup[0]) {
            mpopup.hide();
        }
    });
}
function agregarDetalleLugarEntregaPopup() {

    // get the mPopup
 
    var mpopup = $('#mpopupDetalleLugarEntrega');

    // open the mPopup
    mpopup.show();
    $("#divcodigo_llamado").hide();
    $("#divcodigo_proveedor").hide();
    $("#divcodigo_estado_item_adjudicacion").hide();
 //   $('#mpopupBox').show();
   //     alert('hola');
    // close the mPopup once close element is clicked
    $(".close").on('click', function () {
        mpopup.hide();
        $("#divcodigo_llamado").show();
        $("#divcodigo_proveedor").show();
        $("#divcodigo_estado_item_adjudicacion").show();
    });

    // close the mPopup when user clicks outside of the box
    $(window).on('click', function (e) {
        if (e.target == mpopup[0]) {
            mpopup.hide();
        }
    });
}
var cont = 0;
var detalles = 0;
function eliminarDetalle(indice) {
    $("#fila" + indice).remove();
    //calcularTotales();
    detalles = detalles - 1;

}



//Función limpiar
function limpiar()
{
	$("#lote").val("");
	$("#item").val("");	
	$("#unidad_medida").val("");
	$("#desProducto").val("");
	$("#presentacion").val("");
	$("#nombre_comercial").val("");
	$("#procedencia").val("");
	$("#cantidad_minima").val("");
	$("#cantidad_maxima").val("");
	$("#precio_unitario").val("");
        
	$("#monto_minimo").val("");
	$("#monto_maximo").val("");
        $("#monto_emitido").val("");
	$("#codigo_medicamento").val("");
	$("#cantidad_emitida").val("");
        $("#codigo_contrato").val("");
        $("#numero_contrato").val("");
        $("#fecha_inicio").val("");
        $("#fecha_fin").val("");
        $("#codigo_adjudicacion").val("");
        $("#monto_adjudicacion").val("");
        $("#fecha_adjudicacion").val("");
	
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
					url: '../ajax/contratoProducto.php?op=listar',
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

	var formData = new FormData($("#formulario")[0]);

	$.ajax({
      	    url: "../ajax/contratoProducto.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
                
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          listar();
                //  limpiar();
	    }

	});
        $("#codigo_medicamento").prop("disabled",true);   
       // limpiar();
	
}

function mostrar(codigo_adjudicacion,codigo_proveedor,codigo_medicamento)
{
  //   alert("hola");
	$.post("../ajax/contratoProducto.php?op=mostrar",{codigo_adjudicacion:codigo_adjudicacion,codigo_proveedor:codigo_proveedor,codigo_medicamento:codigo_medicamento}, function(data, status)
	{
            // alert("chau");
		data = JSON.parse(data);		
		mostrarform(true);

		$("#codigo_llamado").val(data.codigo_llamado);
                $('#codigo_llamado').selectpicker('refresh');
                
               // alert(data.codigo_proveedor);
	        $("#codigo_proveedor").val(data.codigo_proveedor);
                $('#codigo_proveedor').selectpicker('refresh');
                $("#codigo_medicamento").val(data.codigo_medicamento);
                $("#desProducto").val(data.producto);
                $("#monto_adjudicado").val(data.monto_adjudicado);
                formatNumero(document.getElementById("monto_adjudicado"));
                $("#fecha_adjudicacion").val(data.fecha_adjudicacion);
                $("#codigo_adjudicacion").val(data.codigo_adjudicacion); 
               
                $("#codigo_contrato").val(data.codigo_contrato);
                $("#numero_contrato").val(data.numero_contrato);
                $("#fecha_inicio").val(data.fecha_inicio);
                $("#fecha_fin").val(data.fecha_fin);
                
                 $("#lote").val(data.lote);
                 $("#item").val(data.item);
                 $("#unidad_medida").val(data.unidad_medida);
                 $("#nombre_comercial").val(data.nombre_comercial);
                 $("#precio_unitario").val(data.precio_unitario);
                 $("#procedencia").val(data.procedencia);
                 $("#obs").val(data.obs);
                 $("#codigo_estado_item").val(data.codigo_estado_item);
                 $('#codigo_estado_item').selectpicker('refresh');
                 
                 $("#cantidad_minima").val(data.cantidad_minima);
                 formatNumero(document.getElementById("cantidad_minima"));
                 $("#cantidad_adjudicada").val(data.cantidad_adjudicada);
                  formatNumero(document.getElementById("cantidad_adjudicada"));
                 $("#cantidad_emitida").val(data.cantidad_emitida);
                 formatNumero(document.getElementById("cantidad_emitida"));
                 $("#monto_minimo").val(data.monto_minimo);
                 formatNumero(document.getElementById("monto_minimo"));
                 $("#monto_maximo").val(data.monto_maximo);
                 formatNumero(document.getElementById("monto_maximo"));
                 $("#monto_emitido").val(data.monto_emitido);
                 formatNumero(document.getElementById("monto_emitido"));
 	})
       
        $.post("../ajax/contratoProducto.php?op=mostrarDetalleEntrega",{codigo_adjudicacion:codigo_adjudicacion,codigo_proveedor:codigo_proveedor,codigo_medicamento:codigo_medicamento}, function(r)
	{
         $("#detalles").html(r);
       
    });
        
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

function listarReactivo(){
  
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
            url: '../ajax/contratoProducto.php?op=listarReactivo',
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
function mostrarAdjudicacion(valor)
{
    //alert('entre'+valor.value);
    $.post("../ajax/contratoProducto.php?op=mostrarAdjudicacion",{codigo_llamado : valor.value}, function(data, status)
    {
        data = JSON.parse(data);        
    
        $("#codigo_adjudicacion").val(data['codigo']);
        $("#monto_adjudicado").val(data['monto_adjudicado']);
        formatNumero(document.getElementById("monto_adjudicado"));
        $("#fecha_adjudicacion").val(data['fecha_adjudicacion']);
       // $('#idcodigo').prop('disabled',true);
        
    });
 }
 function mostrarContrato(valor)
{
    //alert('entre'+valor.value);
    $.post("../ajax/contratoProducto.php?op=mostrarContrato",{codigo_adjudicacion :  $("#codigo_adjudicacion").val(),codigo_proveedor : valor.value}, function(data, status)
    {
        data = JSON.parse(data);        
        $("#codigo_contrato").val(data['codigo']);
        $("#numero_contrato").val(data['numero_contrato']);
        $("#fecha_inicio").val(data['fecha_inicio']);
        $("#fecha_fin").val(data['fecha_fin']);
       // $('#idcodigo').prop('disabled',true);
        
    });
 }
 

init();