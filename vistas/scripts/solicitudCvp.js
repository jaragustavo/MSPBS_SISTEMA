var tabla;

function editarPlanillaEmision(codigo_planilla_emision)
{
   
        $.post("../ajax/solicitudCvp.php?op=mostrarEditar",{idcodigo : codigo_planilla_emision}, function(data, status)
        {
               data = JSON.parse(data);        
               mostrarform(true);
               $("#codigo_solicitud_cvp").val(data[0]);
              
                fecha = data[3].substr(8,2)+'-'+data[3].substr(5,2)+'-'+data[3].substr(0,4);
                $('#fecha_hora').val(fecha);
               
               
          //     $("#fecha_hora").val(data[3]);
                  
             
            $("#divAnular").show();
            $("#btnGuardar").show();
            $("#btnCancelar").show();
          
       
          //   $('#fecha_hora').prop('disabled',false);
        });

        $.post("../ajax/solicitudCvp.php?op=listarDetalle&id="+codigo_planilla_emision,function(r){
                $("#detalles").html(r);
        });
       
  }
 
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
   
 
    $(".filas").remove();
    $("#total").html("0");
     
    //Obtenemos la fecha actual
    var hoy = new Date();
 
     
    var fecha = ("0" + hoy.getDate()).slice(-2) + '-' +  ("0" + (hoy.getMonth() + 1)).slice(-2) + '-' + hoy.getFullYear();
    var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
    var fechaHora = fecha //+ ' ' + hora;
    $('#fecha_hora').val(fechaHora);
    $('#codigo_solicitud_cvp').val("");
   //  $('#anular').checked = 0;
     $("#anular").prop("checked", false);  
    //Marcamos el primer tipo_documento
 
}
 
//Función mostrar formulario
function mostrarform(flag)
{
    limpiar();
    if (flag)
    {
        $("#divAnular").hide();
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        //$("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
        listarOC();
        $("#btnAnular").hide();
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        detalles=0;
        $("#btnAgregarArt").show();
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
            url: '../ajax/solicitudCvp.php?op=listar',
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
            "order": [[ 0, "asc" ]]//Ordenar (columna,orden)
        }).DataTable();
  }
function anular(idcodigo)
{
        bootbox.confirm("¿Está Seguro de anular?", function(result){
        if(result)
        {
            $.post("../ajax/solicitudCvp.php?op=anular", {idcodigo : idcodigo}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
                mostrarform(false);
                limpiar();
           listar();
            }); 
        }
    })
}
 
//Función ListarArticulos
function listarOC()
{
    tabla=$('#tblOC').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                     
                ],
        "ajax":
                {
                    url: '../ajax/solicitudCvp.php?op=listarOC',
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
    //
     if( $('#anular').prop('checked') ) {
           var idcodigo = $('#codigo_solicitud_cvp').val();
           anular(idcodigo);
  
        
     }else {
    
          $('#codigo_solicitud_cvp').prop('disabled',false);
          var fechaHora= $('#fecha_hora').val();
          fechaHora = fechaHora.substr(6,4)+fechaHora.substr(3,2)+fechaHora.substr(0,2)
          $('#fecha_hora').val(fechaHora);
          var formData = new FormData($("#formulario")[0]);
 
          $.ajax({
            url: "../ajax/solicitudCvp.php?op=guardaryeditar",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function(datos)
            {                    
              bootbox.alert(datos);           
              mostrarform(false);
              limpiar();
              listar();
            }

        });
    $('#codigo_solicitud_cvp').prop('disabled',true);
    }
}
 
function mostrar(idingreso)
{
    $.post("../ajax/ingreso.php?op=mostrar",{idingreso : idingreso}, function(data, status)
    {
        data = JSON.parse(data);        
        mostrarform(true);
 
        $("#idproveedor").val(data.idproveedor);
        $("#idproveedor").selectpicker('refresh');
        $("#tipo_comprobante").val(data.tipo_comprobante);
        $("#tipo_comprobante").selectpicker('refresh');
        $("#serie_comprobante").val(data.serie_comprobante);
        $("#num_comprobante").val(data.num_comprobante);
        $("#fecha_hora").val(data.fecha);
        $("#impuesto").val(data.impuesto);
        $("#idingreso").val(data.idingreso);
 
        //Ocultar y mostrar los botones
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").hide();
    });
 
    $.post("../ajax/ingreso.php?op=listarDetalle&id="+idingreso,function(r){
            $("#detalles").html(r);
    });
}
 

 
//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
var impuesto=18;
var cont=0;
var detalles=0;
//$("#guardar").hide();
$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);
 
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
 
function agregarDetalle(codigo_orden_compra,
        numero_orden_compra,
        fecha_orden_compra,
        proveedor,
        codigo_medicamento,
        producto,
         monto)
  {
   var plurianual ='';
    var obs ='';
//alert('Monto '+monto);
    if (codigo_orden_compra!="")
    {
         var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')">X</button></td>'+
        '<td><input type="hidden" name="codigo_orden_compra[]" id="codigo_orden_compra[]" value="'+codigo_orden_compra+'">'+numero_orden_compra+'</td>'+
        '<td><name="fecha_orden_compra" id="fecha_orden_compra">'+fecha_orden_compra+'</td>'+
        '<td><name="proveedor" id="proveedor">'+proveedor+'</td>'+
        '<td><input type="hidden" name="codigo_medicamento[]" id="codigo_medicamento[]" value="'+codigo_medicamento+'">'+codigo_medicamento+'</td>'+
        '<td><name="producto" >'+producto+'</td>'+
        '<td><name="monto">'+monto+'</td>'+
        '<td><input type="text" name="plurianual[]" id="plurianual[]"   value="'+plurianual+'"></td>'+
        '<td><textarea   type="text" name="obs[]"        id="obs[]"          value="'+obs+'"></textarea></td>'+
      
                
      //  '<td><span name="subtotal" id="subtotal'+cont+'">'+subtotal+'</span></td>'+
         '</tr>';
        cont++;
        detalles=detalles+1;
        $('#detalles').append(fila);
     //   modificarSubototales();
        evaluar();
    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos de la OC.");
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
   // calcularTotales();
 
  }
 
 
  function evaluar(){
     // alert("evaluar"+detalles);
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
    var codigo_medicamento = document.getElementsByName("codigo_medicamento[]");
   detalles =    codigo_medicamento.length;
  // alert(detalles);
  ///  detalles=detalles-1;
    evaluar();
  }
  function imprimir(codigo){
  // codigo = $("#codigo").val(); 
//   alert('codigo '+codigo);
   window.open('../ajax/imprimir/solicitudCvp/imprimirOC.php?codigo='+codigo);
  
}
 
init();