var tabla;
 
//Función que se ejecuta al inicio
function init(){
    mostrarform(false);
    listar();
 
    $("#formulario").on("submit",function(e)
    {
        
        guardaryeditar(e);  
    });
    
    //Cargamos los items al select proveedor
   
     
}
 
//Función limpiar
function limpiar()
{
    $("#idpedidoproducto").val("");
    $("#fecha_hora").val("");
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
   
    if (flag)
    {
        $("#idpedido").hide();
        $("#listadoregistros").hide();
        $("#formularioConsulta").hide();
        $("#formularioregistros").show();
        //$("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
        listarProducto();
        $("#sele").hide();
       // $("#btnGuardar").hide();
        $("#btnCancelar").show();
        detalles=0;
        $("#btnAgregarArt").show();
        $("#btnEnviar").hide();
      //  $("#btnMostrarEnviar").hide();
        $("#btnAnular").hide();
    ///    $("#btnMostrarEnviar").show();
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").hide();
        $("#formularioConsulta").hide();
        $("#btnMostrarEnviar").show();
        $("#btnAnular").show();
        
    }
 
}
 
//Función cancelarform
function cancelarform()
{
    limpiar();
    mostrarform(false);
}

function editarPedido(idpedido)
{
   
    mostrarform(false);
    var hoy = new Date();
    var fecha = ("0" + hoy.getDate()).slice(-2) + '-' +  ("0" + (hoy.getMonth() + 1)).slice(-2) + '-' + hoy.getFullYear();
    var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
    var fechaHora = fecha + ' ' + hora;
    $('#fecha_hora').val(fechaHora);
    $("#idpedidoproducto").val(idpedido);
    //    $("#btnMostrarEnviar").hide();
   //  $("#btnAnular").hide();
    
    
    $.post("../ajax/pedidoProducto.php?op=editarPedido",{idpedido : idpedido}, function(data, status)
    {
        data = JSON.parse(data);        
        mostrarform(true);
     //  alert(data.numero_pedido);
        $("#obs").val(data.obs);
     });
     
     $.post("../ajax/pedidoProducto.php?op=editarPedidoDetalle&id="+idpedido,function(r){
              $("#detalles").html(r);
    });
       //Ocultar y mostrar los botones
    $("#btnGuardar").show();
       // $("#btnCancelar").show();
   // evaluar();
   
   // alert('hola');
    
    
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
            url: '../ajax/pedidoProducto.php?op=listar',
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



 
 
//Función ListarArticulos
function listarProducto()
{
    tabla=$('#tblarticulos').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                     
                ],
        "ajax":
                {
                    url: '../ajax/pedidoProducto.php?op=listarProducto',
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                        console.log(e.responseText);    
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
      $('#fecha_hora').prop('disabled',false);
    var fechaHora= $('#fecha_hora').val();
   
    fechaHora = fechaHora.substr(6,4)+fechaHora.substr(3,2)+fechaHora.substr(0,2)+' '+fechaHora.substr(11,8)
    $('#fecha_hora').val(fechaHora);
    
    var formData = new FormData($("#formulario")[0]);
 
    $.ajax({
        url: "../ajax/pedidoProducto.php?op=guardaryeditar",
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
    $('#fecha_hora').prop('disabled',true);
    limpiar();
}

 function mostrarEnviar(idpedido)
{
    mostrarform(false);
     var hoy = new Date();
    var fecha = ("0" + hoy.getDate()).slice(-2) + '-' +  ("0" + (hoy.getMonth() + 1)).slice(-2) + '-' + hoy.getFullYear();
    var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
    var fechaHora = fecha + ' ' + hora;
    $('#fecha_hora').val(fechaHora);
 //    $("#btnMostrarEnviar").hide();
   //  $("#btnAnular").hide();
    
    $.post("../ajax/pedidoProducto.php?op=mostrarEnviar",{idpedido : idpedido}, function(data, status)
    {
        data = JSON.parse(data);        
        mostrarform(true);
 
       // $("#idcodigo").val(data[0]);
      
     //   $("#fecha_hora").val(data[2]);
       // $("#codigo_medicamento").val(data[3]);
        $("#obs").val(data.obs);
 
        //Ocultar y mostrar los botones
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
       // $("#sele").show();
       // $("#idpedido").show();
        $("#btnEnviar").show();
        $("#btnAgregarArt").hide();
    });
    
    
  
   
   // alert('hola');
        $.post("../ajax/pedidoProducto.php?op=listarDetalle&id="+idpedido,function(r){
              $("#detalles").html(r);
         });
    
    
}
function mostrarPedido(idpedido)
{
    mostrarform(false);
     var hoy = new Date();
    var fecha = ("0" + hoy.getDate()).slice(-2) + '-' +  ("0" + (hoy.getMonth() + 1)).slice(-2) + '-' + hoy.getFullYear();
    var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
    var fechaHora = fecha + ' ' + hora;
    $('#fecha_hora').val(fechaHora);
 //    $("#btnMostrarEnviar").hide();
   //  $("#btnAnular").hide();
    
    $.post("../ajax/pedidoProducto.php?op=mostrarPedido",{idpedido : idpedido}, function(data, status)
    {
        data = JSON.parse(data);        
        mostrarform(true);
 
       // $("#idcodigo").val(data[0]);
      
     //   $("#fecha_hora").val(data[2]);
       // $("#codigo_medicamento").val(data[3]);
        $("#obs").val(data.obs);
 
        //Ocultar y mostrar los botones
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
       // $("#sele").show();
       // $("#idpedido").show();
        $("#btnEnviar").hide();
        $("#btnAgregarArt").hide();
    });
    
    
  
   
   // alert('hola');
        $.post("../ajax/pedidoProducto.php?op=listarDetalle&id="+idpedido,function(r){
              $("#detalles").html(r);
         });
    
    
}


var cont=0;
var detalles=0;
//$("#guardar").hide();
$("#btnGuardar").hide();

 
function agregarDetalle(idarticulo,articulo)
  {
     if (idarticulo!="")
    {
       
        var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td style="text-align: center;"><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')"><i class="fa fa-trash"></i></button></td>'+
       '<td><input type="text" readonly="readonly" name="idarticulo[]" value="'+idarticulo+'"></td>'+
       '<td id="articulo">'+articulo+'</td>'+
       '<td><input type="number" name="cantidad[]" id="cantidad[]"   value="'+0+'"></td>'
      
        '</tr>';
             
        cont++;
        detalles=detalles+1;
        $('#detalles').append(fila);
        evaluar();
      //  modificarSubototales();
    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del artículo");
    }
  }
 
  function evaluar(){
   var detalles=document.getElementById("detalles").rows.length;
   //alert(detalles);
   if (detalles >1)
    {
      $("#btnGuardar").show();
    }
    else
    {
      $("#btnGuardar").hide(); 
      cont=0;
    }
  }
 
  function eliminarDetalle(indice){
    $("#fila" + indice).remove();
    //calcularTotales();
    if(detalles > 0) {
       detalles=detalles-1; 
    }
    
    evaluar();
  }
  
  function enviar(e)
   {
     $('#fecha_hora').prop('disabled',false);
       
    var fechaHora= $('#fecha_hora').val();
    fechaHora = fechaHora.substr(6,4)+fechaHora.substr(3,2)+fechaHora.substr(0,2)+' '+fechaHora.substr(11,8)
    $('#fecha_hora').val(fechaHora);
    
    var formData = new FormData($("#formulario")[0]);
 
    $.ajax({
        url: "../ajax/pedidoProducto.php?op=enviarPedido",
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
   // $('#idcodigo').prop('disabled',true);
    $('#fecha_hora').prop('disabled',true);
    limpiar();
}
 function imprimir(codigo){
  // codigo = $("#codigo").val(); 
//   alert('codigo '+codigo);
   window.open('../ajax/imprimir/pedidoOc/imprimirOC.php?codigo='+codigo);
  
}
 
init();