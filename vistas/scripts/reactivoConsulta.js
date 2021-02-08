var tabla;
 
//Función que se ejecuta al inicio
function init(){
    mostrarform(false);
    listar();
    listarLugarEnvio();
    $("#imagenmuestra").hide();
    $("#formulario").on("submit",function(e)
    {
       guardaryeditar(e);  
    });
    
    $.post("../ajax/util.php?op=selectHospitalRegiones", function(r){
                $("#codigo_sucursal").html(r);
                $('#codigo_sucursal').selectpicker('refresh');
    });
     $.post("../ajax/util.php?op=selectEstadoPedido", function(r){
                $("#codigo_estado").html(r);
                $('#codigo_estado').selectpicker('refresh');
    });
     $.post("../ajax/util.php?op=selectDependenciaMsp", function(r){
                $("#destinatario").html(r);
                $('#destinatario').selectpicker('refresh');
    });
    $.post("../ajax/util.php?op=selectEstadoPedido", function(r){
                $("#codigo_estado_envio").html(r);
                $('#codigo_estado_envio').selectpicker('refresh');
    });
    //Cargamos los items al select proveedor
    $('.datepicker').datepicker({
    format: "dd-mm-yyyy",
    language: "es",
    locale: "es",
    autoclose: true

});
     
}
 
//Función limpiar
function limpiar()
{
    $("#codigo").val("");
    $("#fecha_pedido").val("");
    $("#numero_expediente").val("");
    $("#numero_nota").val("");
    $("#obs").val("");
  //  $("#obs_envio").val("");
    
    $("#imagen").val("");
    $("#imagenactual").val("");
    $("#imagenmuestra").attr("src", "");
    
    $("#imagen_envio").val("");
    $("#imagenactual_envio").val("");
    $("#imagenmuestra_envio").attr("src", "");

    
    
    $("#numero_nota").val("");
    $("#codigo_estado").val("");
    $('#codigo_estado').selectpicker('refresh');
    $("#codigo_sucursal").val("");
    $('#codigo_sucursal').selectpicker('refresh');
    $('#destinatario').selectpicker('refresh');
    $("#destinatario").val("");
    $(".filas").remove();
  
     
    //Obtenemos la fecha actual

    var hoy = new Date();
    var fecha = ("0" + hoy.getDate()).slice(-2) + '-' +  ("0" + (hoy.getMonth() + 1)).slice(-2) + '-' + hoy.getFullYear();
    var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
    var fechaHora = fecha; //+ ' ' + hora;
    $('#fecha_pedido').val(fechaHora);
   
 
}
 
//Función mostrar formulario
function mostrarform(flag)
{
    limpiar();
    if (flag)
    {
        $("#listadoregistros").hide();
       
        $("#formularioregistros").show();
        //$("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
        
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        detalles=0;
       $("#btnAgregarArt").hide();
        $("#divEstado").hide();
        $("#divLugarEnvio").hide();
        $("#btnEnviar").hide();
              
        $("#divEnvio").hide();
        $("#divDocPedido").show();
        $("#divDocPedidoEnvio").hide();
        $('#divPedido :input').attr('disabled', true);
        $("#divCodigo").hide();
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
            url: '../ajax/reactivoConsulta.php?op=listar',
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
   // alert("hola");
    tabla=$('#tblarticulos').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                     
                ],
        "ajax":
                {
                    url: '../ajax/reactivoPedido.php?op=listarArticulos',
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
  //  alert("hola");
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $('#codigo').prop('disabled',false);
   
    var fechaHora= $('#fecha_pedido').val();
    fechaHora = fechaHora.substr(6,4)+fechaHora.substr(3,2)+fechaHora.substr(0,2)+' '+fechaHora.substr(11,8)
    $('#fecha_pedido').val(fechaHora);
    
    var formData = new FormData($("#formulario")[0]);
 
    $.ajax({
        url: "../ajax/reactivoPedido.php?op=guardaryeditar",
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

function mostrar(idcodigo)
{
    //listarLugarEnvio();
    $.post("../ajax/reactivoPedido.php?op=mostrar",{idpedido : idcodigo}, function(data, status)
    {
        data = JSON.parse(data);        
        mostrarform(true);
        //$('#idcodigo').prop('disabled',false);
        $("#codigo").val(data['codigo']);
       // $('#idcodigo').prop('disabled',true);
        $("#numero_expediente").val(data['numero_expediente']);
        $("#codigo_estado").val(data['codigo_estado']);
        $('#codigo_estado').selectpicker('refresh');
         $("#codigo_sucursal").val(data['codigo_sucursal']);
        $('#codigo_sucursal').selectpicker('refresh');
        $("#fecha_pedido").val(data['fecha_pedido']);
        $("#numero_nota").val(data['numero_nota']);
        $("#obs").val(data['obs']);
        if (data.imagen === "" || data.imagen===null){
           $("#imagenmuestra").hide();
        }
        else{
            $("#imagenmuestra").show();
            $("#imagenmuestra").attr("src", "../files/reactivoPedido/" + data.imagen);
            $("#imagenactual").val(data['imagen']);
          
            
        }
        //Ocultar y mostrar los botones
        $("#btnGuardar").show();
        $("#btnCancelar").show();
      
        $("#divObsEnvio").hide();
      
        
        
       
    });
   // alert('hola');
   $.post("../ajax/reactivoPedido.php?op=mostrarDetalle&id="+idcodigo,function(r){
        $("#detalles").html(r);
    });
}

function mostrarEnviar(idcodigo)
{
    
    $.post("../ajax/reactivoPedido.php?op=mostrarEnviar",{idpedido : idcodigo}, function(data, status)
    {
        data = JSON.parse(data);        
        mostrarform(true);
        //$('#idcodigo').prop('disabled',false);
        $("#codigo").val(data['codigo']);
       // $('#idcodigo').prop('disabled',true);
        $("#numero_expediente").val(data['numero_expediente']);
        $("#codigo_estado").val(data['codigo_estado']);
        $('#codigo_estado').selectpicker('refresh');
         $("#codigo_sucursal").val(data['codigo_sucursal']);
        $('#codigo_sucursal').selectpicker('refresh');
        $("#fecha_pedido").val(data['fecha_pedido']);
        $("#numero_nota").val(data['numero_nota']);
        $("#obs").val(data['obs']);
        if (data.imagen === "" || data.imagen===null){
            $("#imagenmuestra").hide();
        }
        else{
            $("#imagenmuestra").show();
            $("#imagenmuestra").attr("src", "../files/reactivoPedido/" + data.imagen);
            $("#imagenactual").val(data['imagen']);
        }
        //Ocultar y mostrar los botones
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#divLugarEnvio").show();
        $("#btnAgregarArt").hide();
        $("#btnEnviar").show();
            
        
        $("#divEnvio").show();
        $("#divDocPedido").hide();
      
        $("#divDocPedidoEnvio").show();
        $('#divPedido :input').attr('disabled', true);
        
        //$("#idpedido").show();
      
        
    });
   // alert('hola');
   $.post("../ajax/reactivoPedido.php?op=mostrarDetalle&id="+idcodigo,function(r){
        $("#detalles").html(r);
    });
}


 
//Declaración de variables necesarias para trabajar con las pedido orden compra y
// sus detalles

var cont=0;
var detalles=0;
//$("#guardar").hide();
$("#btnGuardar").hide();

 
 
function agregarDetalle(idarticulo,articulo,codigo_catalogo,especificacion_tecnica,presentacion)
  {
    if (idarticulo!="")
    {
       
        var fila='<tr  scope="col" id="fila' + cont + '" class="filas" style="font-size: 12px;" >' +
        '<td scope="col" style="text-align: center;"><div style="width: 30px;"><a class="btn btn-accent m-btn m-btn--custom' +
        'm-btn--icon m-btn--air m-btn--pill type="button" onclick="eliminarDetalle(' + cont + ')">' +
        '<span><i class="fa fa-trash" style="color: indianred; "></i></span></a>' +
       '<td scope="col"><div style="width: 50px; font-size: 80%;"><input type="text" readonly="readonly" name="idarticulo[]" size="7" value="'+idarticulo+'"></div></td>'+
        '<td scope="col" id="codigo_catalogo" ><div style="width: 65px; font-size: 80%;">'+codigo_catalogo+'</div></td>'+
       '<td scope="col" id="articulo"><div style="width: 130px; font-size: 80%;">'+articulo+'</div></td>'+
       '<td scope="col" id="especificacion_tecnica" ><div style="width: 180px; font-size: 80%;">'+especificacion_tecnica+'</div></td>'+
       '<td scope="col" id="presentacion" ><div style="width: 100px; font-size: 80%;">'+presentacion+'</div></td>'+
       '<td scope="col"><div style="width: 60px; font-size: 80%;"><input type="text" size="9" name="presentacion_entrega[]" id="presentacion_entrega[]" value=""></div></td>'+
       '<td scope="col"><div style="width: 60px; font-size: 80%;"><input type="text" size="9" name="unidad_medida[]" id="unidad_medida[]" value=""></div></td>'+
       '<td scope="col"><div style="width: 60px; font-size: 80%;"><input type="text" size="9" name="precio_referencial[]" id="precio_referencial[]" value=""></div></td>'+
       '<td scope="col"><div style="width: 50px; font-size: 80%;"><input type="text" size="7" name="cantidad[]" id="cantidad[]"   value=""></div></td>'+
       '<td scope="col"><div style="width: 100px; font-size: 80%;"><input type="text" size="15" name="obsD[]" id="obsD[]" value=""></div></td>'
       
      
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
       $("#btnGuardar").hide(); 
    
  }
 
  function eliminarDetalle(indice){
     // alert("hola"+indice);
    $("#fila" + indice).remove();
    //calcularTotales();
    if(detalles > 0) {
       detalles=detalles-1; 
    }
    
    evaluar();
  }
  function listarLugarEnvio() {

    $.post("../ajax/reactivoPedido.php?op=listarLugarEnvio", function (r) {
        $("#lugar_envio").html(r);
    });
}
  
 function enviar(e)
   {
   
    $('#codigo').prop('disabled',false);
    
    var formData = new FormData($("#formulario")[0]);
 
    $.ajax({
        url: "../ajax/reactivoPedido.php?op=enviar",
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
 
init();