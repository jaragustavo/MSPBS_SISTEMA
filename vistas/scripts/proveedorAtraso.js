var tabla;
 
//Función que se ejecuta al inicio
function init(){
    mostrarform(false);
    listar();
 
    $("#formulario").on("submit",function(e)
    {
        
        guardaryeditar(e);  
    });
    
 
    $.post("../ajax/proveedorAtraso.php?op=selectEstadoProveedorAtraso", function(r){
                $("#codigoEstadoProveedorAtraso").html(r);
                $('#codigoEstadoProveedorAtraso').selectpicker('refresh');
    });
      $.post("../ajax/proveedorAtraso.php?op=selectMedicamento", function(r){
                $("#codigoMedicamentoRecibido").html(r);
                $('#codigoMedicamentoRecibido').selectpicker('refresh');
    });
     
}
 
//Función limpiar
function limpiar()
{
    $("#idcodigo").val("");
    $("#fecha_hora").val("");
    $("#codigoEstadoProveedorAtraso").val("-1");
    $("#codigoEstadoProveedorAtraso").selectpicker('refresh');
    
    $("#codigoMedicamentoRecibido").val("-1");
    $("#codigoMedicamentoRecibido").selectpicker('refresh');
    $("#obs").val("");
    $(".filas").remove();
  
     
    //Obtenemos la fecha actual

     var hoy = new Date();
 
     
    var fecha = ("0" + hoy.getDate()).slice(-2) + '-' +  ("0" + (hoy.getMonth() + 1)).slice(-2) + '-' + hoy.getFullYear();
    var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
    var fechaHora = fecha + ' ' + hora;
    $('#fecha_hora').val(fechaHora);
   
 
}
 
//Función mostrar formulario
function mostrarform(flag)
{
    limpiar();
    if (flag)
    {
       
        $("#listadoregistros").hide();
        $("#formularioConsulta").hide();
        $("#formularioregistros").show();
        //$("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
       // listarArticulos();
      
        $("#btnGuardar").show();
        $("#btnCancelar").show();
        detalles=0;
        $("#btnAgregarArt").show();
      //  $("#btnEnviar").hide();
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
        $("#btnDetalle").show();
        $("#formularioConsulta").hide();
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
            url: '../ajax/proveedorAtraso.php?op=listar',
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
            "order": [[ 1, "asc" ]]//Ordenar (columna,orden)
        }).DataTable();
  }


 
//Función para guardar o editar
 
function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    $('#codigo_medicamentoOC').prop('disabled',false);
    $('#codigoOC').prop('disabled',false);
    $('#codigo_medicamento_recibido').prop('disabled',false);
    $('#fecha_hora').prop('disabled',false);
    $('#numero_orden_compra').prop('disabled',false);
    
   // alert('hoLA '+$('#numero_orden_compra').val());
    var fechaHora= $('#fecha_hora').val();
    fechaHora = fechaHora.substr(6,4)+fechaHora.substr(3,2)+fechaHora.substr(0,2)+' '+fechaHora.substr(11,8)
    $('#fecha_hora').val(fechaHora);
    
   // alert(fechaHora);
    
  //  fechaHora = fechaHora.substr(3,2) +'-'+fechaHora.substr(0,2)+'-'+fechaHora.substr(6,4)+' '+fechaHora.substr(11,8);
   // $('#fecha_hora').val(fechaHora);
  
  // fechaHora = fechaHora.substr(6,4)+fechaHora.substr(0,2)+fechaHora.substr(3,2)+fechaHora.substr(6,4)+fechaHora.substr(11,8)
  // alert(fechaHora);
    var formData = new FormData($("#formulario")[0]);
 
    $.ajax({
        url: "../ajax/proveedorAtraso.php?op=guardaryeditar",
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
    $('#codigo_medicamentoOC').prop('disabled',true);
    $('#codigo_medicamento_recibido').prop('disabled',true);
    $('#fecha_hora').prop('disabled',true);
    $('#numero_orden_compra').prop('disabled',true);
  //   $('#codigo_orden_compra').prop('disabled',true);
    
    limpiar();
}


 
function editar()
{
    var codigo_medicamento = new Array();
    var numeroOC = new Array();
    var producto = new Array();
    var codigo_orden_compra = new Array();
    
   $("tr").find("input:checkbox:checked").each(function() {
      
        numeroOC.push($(this).parent().parent().find("#numeroOC").val());
      
        codigo_medicamento.push($(this).parent().parent().find("#codigo_medicamento").val());
        
        producto.push($(this).parent().parent().find("#producto").val());
        
        codigo_orden_compra.push($(this).parent().parent().find("#codigo_orden_compra").val());
   });
   
    if (numeroOC == '' || numeroOC.length > 1) {
        alert("Debe seleccionar correctamente");
    } else
    {    
        var hoy = new Date();
        var fecha = ("0" + hoy.getDate()).slice(-2) + '-' +  ("0" + (hoy.getMonth() + 1)).slice(-2) + '-' + hoy.getFullYear();
        var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
        var fechaHora = fecha + ' ' + hora;
        $('#fecha_hora').val(fechaHora);
        $("#numero_orden_compra").val(numeroOC);
        $("#codigo_medicamentoOC").val(codigo_medicamento);
      // alert("Debe "+producto[0]);
        $("#productoDescripcion").val(producto[0]);
        $("#codigoOC").val(codigo_orden_compra);
        mostrarform(true);
    }
        //Ocultar y mostrar los botones
       
    //    $("#btnCancelar").show();
     //   $("#sele").show();
   //     $("#idpedido").show();
     
     //   $("#btnAgregarArt").hide();
  
}
 
//Función para anular registros
function anular()
{
    bootbox.confirm("¿Está Seguro de anular el item?", function(result){
        if(result)
        {
             var idcodigo = new Array();
             $("tr").find("input:radio:checked").each(function() {
                
               idcodigo.push($(this).parent().parent().find("#idcodigo").val());
               
             });
            if (idcodigo == '') {
                alert("Debe seleccionar un item");
            } else
            {    
                  idcodigo = idcodigo[0];
            
                $.post("../ajax/proveedorAtraso.php?op=anular", {idcodigo : idcodigo}, function(e){
                    bootbox.alert(e);
                    cancelarform();
                }); 
            }
        }
        })
}

function mostrarDetalle()
{
  
     var numeroOC = new Array();
      var codigoOC = new Array();
     $("tr").find("input:checkbox:checked").each(function() {
      
        numeroOC.push($(this).parent().parent().find("#numeroOC").val());
        codigoOC.push($(this).parent().parent().find("#codigo_orden_compra").val());
     
   });
 
     
    if (numeroOC == '' || numeroOC.length > 1) {
        alert("Debe seleccionar un item");
    } else
    {    
        $("#btnagregar").hide();
        $("#btnDetalle").hide();
        $("#listadoregistros").hide();
        $("#formularioregistros").hide();
     //   $("#btnagregar").show();
        $("#formularioConsulta").show();
        
        numeroOC = numeroOC[0];
        codigoOC = codigoOC[0];
       // alert('codigoOC '+codigoOC);
      $.post("../ajax/proveedorAtraso.php?op=mostrarDetalle", {numeroOC : numeroOC,codigoOC : codigoOC}, function(e){
               // bootbox.alert(e);
                 $("#consultaDetalle").html(e);
       });    
    
    }
}
 
init();