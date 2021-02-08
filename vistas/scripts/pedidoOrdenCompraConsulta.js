var tabla;
 
//Función que se ejecuta al inicio
function init(){
    mostrarform(false);
    listar();
 
    $("#formulario").on("submit",function(e)
    {
        
        guardaryeditar(e);  
    });
    
    $.post("../ajax/pedidoOrdenCompraAsignarPrioridad.php?op=selectIndicadorPrioridad", function(r){
                $("#indicadorPrioridad").html(r);
                $('#indicadorPrioridad').selectpicker('refresh');
    });
    //Cargamos los items al select proveedor
   
     
}
 
//Función limpiar
function limpiar()
{
    $("#idcodigo").val("");
    $("#fecha_hora").val("");
    $("#numero_expediente").val("");
   
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
        $("#idpedido").hide();
        $("#listadoregistros").hide();
        $("#formularioConsulta").hide();
        $("#formularioregistros").show();
        //$("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
        listarArticulos();
        $("#sele").hide();
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        detalles=0;
        $("#btnAgregarArt").show();
        $("#btnEnviar").hide();
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").hide();
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
            url: '../ajax/pedidoOrdenCompraConsulta.php?op=listar',
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
  //          "order": [[ 1, "asc" ]]//Ordenar (columna,orden)
        }).DataTable();
  }


 
//Función ListarArticulos
function listarArticulos()
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
                    url: '../ajax/pedidoOrdenCompra.php?op=listarArticulos',
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                        console.log(e.responseText);    
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
    //$("#btnGuardar").prop("disabled",true);
    
    var fechaHora= $('#fecha_hora').val();
    fechaHora = fechaHora.substr(6,4)+fechaHora.substr(3,2)+fechaHora.substr(0,2)+' '+fechaHora.substr(11,8)
    $('#fecha_hora').val(fechaHora);
    
  //  alert(fechaHora);
    
  //  fechaHora = fechaHora.substr(3,2) +'-'+fechaHora.substr(0,2)+'-'+fechaHora.substr(6,4)+' '+fechaHora.substr(11,8);
   // $('#fecha_hora').val(fechaHora);
  
  // fechaHora = fechaHora.substr(6,4)+fechaHora.substr(0,2)+fechaHora.substr(3,2)+fechaHora.substr(6,4)+fechaHora.substr(11,8)
  // alert(fechaHora);
    var formData = new FormData($("#formulario")[0]);
 
    $.ajax({
        url: "../ajax/pedidoOrdenCompra.php?op=guardaryeditar",
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
    limpiar();
}

function mostrarMovimiento(idcodigo,codigo_medicamento,producto)
{
    $("#numero_pedido").val(idcodigo);
    $("#codigo_medicamento").val(codigo_medicamento);
     $("#producto").val(producto);
    $.post("../ajax/pedidoOrdenCompra.php?op=mostrarMovimiento&id="+idcodigo+"&codigoMedicamento="+codigo_medicamento,function(r){
            $("#consultaDetalle").html(r);
    });
   
  // $('#idcodigo').prop('disabled',true);
    mostrarform(true);
    $("#formularioregistros").hide();
    $("#formularioConsulta").show();
   
   
 
   
}
 
function mostrar(idcodigo,codigo_medicamento)
{
    
    $.post("../ajax/pedidoOrdenCompra.php?op=mostrar",{idcodigo : idcodigo,codigo_medicamento : codigo_medicamento}, function(data, status)
    {
        data = JSON.parse(data);        
        mostrarform(true);
 
        $("#idcodigo").val(data[0]);
        $("#numero_expediente").val(data[1]);
        $("#fecha_hora").val(data[2]);
        $("#codigo_medicamento").val(data[3]);
        $("#obs").val(data[10]);
 
        //Ocultar y mostrar los botones
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#sele").show();
        $("#idpedido").show();
        $("#btnEnviar").show();
        $("#btnAgregarArt").hide();
    });
 
    $.post("../ajax/pedidoOrdenCompra.php?op=listarDetalle&id="+idcodigo+"&codigoMedicamento="+codigo_medicamento,function(r){
            $("#detalles").html(r);
    });
}
 
//Función para anular registros
function anular(idcodigo,codigo_medicamento)
{
    bootbox.confirm("¿Está Seguro de anular el item del pedido?", function(result){
        if(result)
        {
            $.post("../ajax/pedidoOrdenCompra.php?op=anular", {idcodigo : idcodigo,codigo_medicamento : codigo_medicamento}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    })
}
 
//Declaración de variables necesarias para trabajar con las pedido orden compra y
// sus detalles

var cont=0;
var detalles=0;
//$("#guardar").hide();
$("#btnGuardar").hide();

 
function marcarImpuesto()
  {
    var tipo_comprobante=$("#tipo_comprobante option:selected").text();
    if (tipo_comprobante=='Factura')
    {
        $("#impuesto").val(impuesto); 
    }
    else
    {
        $("#impuesto").val("0"); 
    }
  }
 
function agregarDetalle(idarticulo,articulo,stock,dmp)
  {
    var cantidad=3*dmp;
    var meses=3;

    if (idarticulo!="")
    {
       
        var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
        '<td><input type="number" name="idarticulo[]" value="'+idarticulo+'"></td>'+
     
       '<td id="articulo">'+articulo+'</td>'+
        '<td><input type="number" name="stock[]" id="stock[]" value="'+stock+'"></td>'+
        '<td><input type="number" name="dmp[]" id="dmp[]" value="'+dmp+'"></td>'+
        '<td><input type="number" name="meses[]" id="meses[]" onkeyup="modificarSubtotales()" value="'+meses+'"></td>'+
       //'<td><span name="cantidad" id="cantidad'+cont+'">'+cantidad+'</span></td>'+
       
       '<td><input type="number" name="cantidad[]" id="cantidad[]"   value="'+cantidad+'"></td>'
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
 
  function modificarSubtotales()
  {
    var meses = document.getElementsByName("meses[]");
    var dmp = document.getElementsByName("dmp[]");
    var cantidad = document.getElementsByName("cantidad[]");
    for (var i = 0; i < dmp.length; i++) {
        cantidad[i].value = dmp[i].value * meses[i].value;
       //  document.getElementsByName("cantidad")[i].innerHTML=inpC.value;
    }
  
  }
   
  
  function calcularTotales(){
   // var sub = document.getElementsByName("dmp")[].value;
   
    var total = 0.0;
 
    for (var i = 0; i <sub.length; i++) {
        total += document.getElementsByName("subtotal")[i].value;
    }
    $("#total").html("S/. " + total);
    $("#total_compra").val(total);
    evaluar();
  }
 
  function evaluar(){
    if (detalles>0)
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
    detalles=detalles-1;
    evaluar();
  }
  function enviar(e)
   {
    //e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    
    $('#idcodigo').prop('disabled',false);
   
    var formData = new FormData($("#formulario")[0]);
 
    $.ajax({
        url: "../ajax/pedidoOrdenCompra.php?op=actualizarPrioridad",
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
    $('#idcodigo').prop('disabled',true);
    limpiar();
}
 
init();