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
    $.post("../ajax/pedidoOrdenCompraRecibir.php?op=selectEstadoCierre", function(r){
                $("#estadoCierre").html(r);
                $('#estadoCierre').selectpicker('refresh');
    });
    //Cargamos los items al select proveedor
   
     
}
 
 function mostrarMovimiento()
{
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
   

       // codigo_medicamento = codigo_medicamento.toString();
        //idpedido = idpedido.toString();
   //alert(idpedido);
    if (idpedido == '' || idpedido.length > 1) {
        alert("Debe seleccionar correctamente");
    } else
    {    
        $.post("../ajax/pedidoOrdenCompra.php?op=mostrarMovimiento&id="+idpedido+"&codigoMedicamento="+codigo_medicamento,function(r){
                $("#consultaDetalle").html(r);
        });

        mostrarform(true);
        $("#formularioregistros").hide();
        $("#formularioconsulta").show();

    }
 
   
}
function anularMovimiento(){
  var opcion = confirm("Esta seguro de eliminar este movimiento.... Aceptar o Cancelar");
    if (opcion == true) {
        
   //alert('entre');
    var formData = new FormData($("#formularioConsulta")[0]);
 
    $.ajax({
        url: "../ajax/pedidoOrdenCompra.php?op=anularMovimiento",
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
            
} else {
	   
	}
   
    
    
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
        $("#listadoregistros").hide();
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
         $("#formularioconsulta").hide();
         $("#btnMostrarRecibir").hide();
         $("#btnMostrarMovimiento").hide();
         $("#btnAnular").hide();
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").hide();
        $("#formularioconsulta").hide();
        $("#btnMostrarRecibir").show();
        $("#btnMostrarMovimiento").show();
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
            url: '../ajax/pedidoOrdenCompraRecibir.php?op=listarReciboProveedor',
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
            "order": [[ 9, "asc" ]]//Ordenar (columna,orden)
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
 
function mostrarRecibir()
{
  
    var idcodigo = new Array();
    var i=0;
   // idcodigo[]=$("#idcodigo").val();
   
     $("input:checkbox:checked").each(function() {
         idcodigo.push($(this).val());
     });
    
    idcodigo = idcodigo.toString();
    if (idcodigo == '') {
        alert("Debe seleccionar un item");
    } else
    {    
   
        $.post("../ajax/pedidoOrdenCompraRecibir.php?op=mostrarRecibir",{idcodigo : idcodigo}, function(data, status)
        {
            data = JSON.parse(data);        
            mostrarform(true);

            var now = new Date();
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var fecha = (day)+"/"+(month)+"/"+now.getFullYear() ;

            var hora = now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();
            var fechaHora = fecha + ' ' + hora;

            $('#fecha_hora').val(fechaHora);
         

            //Ocultar y mostrar los botones
            $("#btnGuardar").hide();
            $("#btnCancelar").show();
            $("#sele").hide();
            $("#btnRecibir").show();
            $("#btnAgregarArt").hide();
            $("#btnEnviar").hide();
            $("#seleCierre").hide();
            $('#obs').prop('disabled',true);
          //   $('#fecha_hora').prop('disabled',false);
        });

        $.post("../ajax/pedidoOrdenCompraRecibir.php?op=listarDetalle&id="+idcodigo,function(r){
                $("#detalles").html(r);
        });
    }
}
 function mostrarEnviar(idcodigo)
{
   
    $.post("../ajax/pedidoOrdenCompraRecibir.php?op=mostrarEnviar",{idcodigo : idcodigo}, function(data, status)
    {
        data = JSON.parse(data);        
        mostrarform(true);
 
        $("#idcodigo").val(data[0]);
        $("#numero_expediente").val(data[1]);
     // alert ('fad'+val(data[9]));
        $("#idpedido").val(data[9]);
       var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var fecha = (day)+"/"+(month)+"/"+now.getFullYear() ;
        
        var hora = now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds();
        var fechaHora = fecha + ' ' + hora;

        $('#fecha_hora').val(fechaHora);
        $("#codigo_medicamento").val(data[4]);
        $("#obs").val(data[7]);
 
        //Ocultar y mostrar los botones
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#sele").show();
        $("#btnRecibir").hide();
        $("#btnAgregarArt").hide();
        $("#btnEnviar").show();
        $("#seleCierre").show();
         $('#obs').prop('disabled',false);
         $('#obs').val(" ");
         
    });
 
    $.post("../ajax/pedidoOrdenCompraRecibir.php?op=listarDetalle&id="+idcodigo,function(r){
            $("#detalles").html(r);
    });
}
//Función para anular registros

 
//Declaración de variables necesarias para trabajar con las pedido orden compra y
// sus detalles

var cont=0;
var detalles=0;
//$("#guardar").hide();
$("#btnGuardar").hide();

 
 
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
       
       '<td><input type="number" name="cantidad[]" id="cantidad[]"  value="'+cantidad+'"></td>'
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
  function enviar()
   {
    //e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    $('#fecha_hora').prop('disabled',false);
    $('#codigo_medicamento').prop('disabled',false);
    $('#idpedido').prop('disabled',false);
    var fechaHora= $('#fecha_hora').val();
    fechaHora = fechaHora.substr(6,4)+fechaHora.substr(3,2)+fechaHora.substr(0,2)+' '+fechaHora.substr(11,8)
    $('#fecha_hora').val(fechaHora);
    
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/pedidoOrdenCompraRecibir.php?op=enviar",
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
    $('#codigo_medicamento').prop('disabled',true);
    $('#idpedido').prop('disabled',true);
    limpiar();
}
function recibir()
   {
      // alert('hola');
    //e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    $('#fecha_hora').prop('disabled',false);
    
    var fechaHora= $('#fecha_hora').val();
    fechaHora = fechaHora.substr(6,4)+fechaHora.substr(3,2)+fechaHora.substr(0,2)+' '+fechaHora.substr(11,8)
    $('#fecha_hora').val(fechaHora);
    
    var formData = new FormData($("#formulario")[0]);
 
    $.ajax({
        url: "../ajax/pedidoOrdenCompraRecibir.php?op=recibir",
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
 
init();