var tabla;
 
//Función que se ejecuta al inicio
function init(){
    mostrarform(false);
    listar();
 
    $("#formulario").on("submit",function(e)
    {
        
        guardaryeditar(e);  
    });
    
    $.post("../ajax/usuario.php?op=selectUsuario", function(r){
                $("#idusuarioDestino").html(r);
                $('#idusuarioDestino').selectpicker('refresh');
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
        $("#btnMostrarEnviar").hide();
        $("#btnAnular").hide();
    ///    $("#btnMostrarEnviar").show();
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
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
            url: '../ajax/pedidoOrdenCompra.php?op=listar',
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
      $('#fecha_hora').prop('disabled',false);
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
    $('#fecha_hora').prop('disabled',true);
    limpiar();
}

function mostrarMovimiento(idcodigo,codigo_medicamento)
{
 //alert('ada '+codigo_medicamento);
   
    // $('#idcodigo').prop('disabled',false);
    
    $.post("../ajax/pedidoOrdenCompra.php?op=mostrarMovimiento&id="+idcodigo+"&codigoMedicamento="+codigo_medicamento,function(r){
            $("#consultaDetalle").html(r);
    });
   // alert('op');
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
   // alert('hola');
    $.post("../ajax/pedidoOrdenCompra.php?op=listarDetalle&id="+idcodigo+"&codigoMedicamento="+codigo_medicamento,function(r){
          $("#detalles").html(r);
     });
}
 
 function mostrarEnviar()
{
    mostrarform(false);
     var hoy = new Date();
    var fecha = ("0" + hoy.getDate()).slice(-2) + '-' +  ("0" + (hoy.getMonth() + 1)).slice(-2) + '-' + hoy.getFullYear();
    var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
    var fechaHora = fecha + ' ' + hora;
    $('#fecha_hora').val(fechaHora);
 //    $("#btnMostrarEnviar").hide();
   //  $("#btnAnular").hide();
    var codigo_medicamento = new Array();
    var idcodigo = new Array();
    var idpedido = new Array();
    
    var i=0;
   // idcodigo[]=$("#idcodigo").val();
   
   $("tr").find("input:checkbox:checked").each(function() {
        idpedido.push($(this).parent().parent().find("#idpedido").val());
      
       codigo_medicamento.push($(this).parent().parent().find("#codigo_medicamento").val());
       //alert(idpedido);
   });
   

        codigo_medicamento = codigo_medicamento.toString();
        idpedido = idpedido.toString();
     //   alert(idpedido);
     
    
    if (codigo_medicamento == '') {
        alert("Debe seleccionar un item");
    } else
    {    
    $.post("../ajax/pedidoOrdenCompra.php?op=mostrarEnviar",{idpedido : idpedido,codigo_medicamento : codigo_medicamento}, function(data, status)
    {
        data = JSON.parse(data);        
        mostrarform(true);
 
       // $("#idcodigo").val(data[0]);
        $("#numero_expediente").val(data[1]);
     //   $("#fecha_hora").val(data[2]);
       // $("#codigo_medicamento").val(data[3]);
        $("#obs").val(data[10]);
 
        //Ocultar y mostrar los botones
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#sele").show();
        $("#idpedido").show();
        $("#btnEnviar").show();
        $("#btnAgregarArt").hide();
    });
  
   
   // alert('hola');
        $.post("../ajax/pedidoOrdenCompra.php?op=listarDetalle&id="+idpedido+"&codigoMedicamento="+codigo_medicamento,function(r){
              $("#detalles").html(r);
         });
    }
    
}
//Función para anular registros
function anular()
{
    bootbox.confirm("¿Está Seguro de anular ?", function(result){
        if(result)
        {
             var codigo_medicamento = [];
    var idpedido = [];
    var indice = [];
    var vectorMedicamento = [];
    var vectorPedido = [];
    var i=0;
   // idcodigo[]=$("#idcodigo").val();
   $("#tbllistado tr").each(function (index) { 
      codigo_medicamento[i] = [$(this).find("#codigo_medicamento").val()]; 
      idpedido[i] = [$(this).find("#idpedido").val()]; 
      i=i+1;
    });
    i=0;
    v=1;
    $('#tbllistado input[type=checkbox]').each(function () {
                if (this.checked) {
                   indice[i] = v; 
                   i=i+1;
                 }
                 v=v+1;
                
      });
      for (var i =0 ; i < indice.length; i++) {
              vectorMedicamento[i] = codigo_medicamento[indice[i]];
              vectorPedido[i]      = idpedido[indice[i]];
        }  
        
        codigo_medicamento = vectorMedicamento.toString();
        idpedido = vectorPedido.toString();
        if (codigo_medicamento == '') {
            alert("Debe seleccionar un item");
        } else
        {    
            $.post("../ajax/pedidoOrdenCompra.php?op=anular", {idpedido : idpedido,codigo_medicamento : codigo_medicamento}, function(e){
                    bootbox.alert(e);
                    tabla.ajax.reload();
                }); 
            }
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
 function modificarSubototales()
  {
    var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precio_compra[]");
    var sub = document.getElementsByName("subtotal");
 
    for (var i = 0; i <cant.length; i++) {
        var inpC=cant[i];
        var inpP=prec[i];
        var inpS=sub[i];
 
        inpS.value=inpC.value * inpP.value;
        document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
    }
    calcularTotales();
 
  }
  function calcularTotales(){
    var sub = document.getElementsByName("subtotal");
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
    
    //$('#idcodigo').prop('disabled',false);
    $('#fecha_hora').prop('disabled',false);
    
      
    var fechaHora= $('#fecha_hora').val();
    fechaHora = fechaHora.substr(6,4)+fechaHora.substr(3,2)+fechaHora.substr(0,2)+' '+fechaHora.substr(11,8)
    $('#fecha_hora').val(fechaHora);
    
    var formData = new FormData($("#formulario")[0]);
 
    $.ajax({
        url: "../ajax/pedidoOrdenCompraMovimiento.php?op=enviar",
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