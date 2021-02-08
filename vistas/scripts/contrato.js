var tabla;
 
////// ACTIVAR EVENTE EN EL SELECT ///////////////

const selectElement = document.querySelector('.codigo_tipo_resolucion_concepto'); 
selectElement.addEventListener('change', (event) => {
     
    if (`${event.target.value}` == 16){
        $("#divReemplazante").show();
    }    
    else {
        $("#divReemplazante").hide(); 
    }
    
   
});

//////////////******************************////////////////////


function anularPedido(idpedido){
    var resp = confirm("Esta seguro de eliminar el pedido!");
    if (resp == true) {
        $.post("../ajax/reactivoPedido.php?op=anularPedido&id="+idpedido,function(r){
        bootbox.alert(r);
        listar();
     });
    }

}


function verMovimiento(idcodigo)
{

   $.post("../ajax/contrato.php?op=verMovimiento&id="+idcodigo,function(r){
        $("#tblmovimientos").html(r);
  
    });
}
function verVinculo(numero_cedula)
{

   $.post("../ajax/contrato.php?op=verVinculo&id="+numero_cedula,function(r){
        $("#tblvinculo").html(r);
  
    });
}
function verEspecialidad(numero_cedula)
{

   $.post("../ajax/contrato.php?op=verEspecialidad&id="+numero_cedula,function(r){
        $("#tblespecialidad").html(r);
  
    });
}
function init(){
    mostrarform(false);
    listar();
    listarLugarEnvio();
 //   listarArticulos();
    $("#imagenmuestra").hide();
    $("#formulario").on("submit",function(e)
    {
       guardaryeditar(e);  
    });
   
    $.post("../ajax/contrato.php?op=selectDepenciaMsp", function(r){
                $("#codigo_dependencia").html(r);
                $('#codigo_dependencia').selectpicker('refresh');
    });
     $.post("../ajax/util.php?op=selectEstadoPedido", function(r){
                $("#codigo_estado").html(r);
                $('#codigo_estado').selectpicker('refresh');
    });
   /*  $.post("../ajax/util.php?op=selectDependenciaMsp", function(r){
                $("#destinatario").html(r);
                $('#destinatario').selectpicker('refresh');
    });
   */
    $.post("../ajax/util.php?op=selectUsuarioDependencia", function(r){
                $("#destinatario").html(r);
                $('#destinatario').selectpicker('refresh');
    });
    $.post("../ajax/util.php?op=selectEstadoPedido", function(r){
                $("#codigo_estado_envio").html(r);
                $('#codigo_estado_envio').selectpicker('refresh');
    });
    $.post("../ajax/util.php?op=selectTipoPedido", function(r){
                $("#codigo_tipo_pedido").html(r);
                $('#codigo_tipo_pedido').selectpicker('refresh');
    });
    
//nuevo    
    
   
    $.post("../ajax/contrato.php?op=selectTipoResolucion", function(r){
                $("#codigo_tipo_resolucion").html(r);
                $('#codigo_tipo_resolucion').selectpicker('refresh');
    });
    $.post("../ajax/contrato.php?op=selectTipoResolucionConcepto", function(r){
                $("#codigo_tipo_resolucion_concepto").html(r);
                $('#codigo_tipo_resolucion_concepto').selectpicker('refresh');
    });
     $.post("../ajax/contrato.php?op=selectObjetoGasto", function(r){
                $("#objeto").val(r);
      });
     $.post("../ajax/contrato.php?op=selectDepenciaMsp", function(r){
                $("#dependencia").val(r);
      }); 
      $.post("../ajax/contrato.php?op=selectRegionSanitaria", function(r){
               $("#region_sanitaria").val(r);
      }); 
    
     $.post("../ajax/contrato.php?op=selectFuncion", function(r){
             //   alert (r);
                $("#funcion_cargo").val(r);
                
             
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
    $("#numero_expediente").val("");
  //  $("#obs").val("");
 //   $("#ojetoGasto").val("");
    
    $("#imagen").val("");
    $("#imagenactual").val("");
    $("#imagenmuestra").attr("src", "");
    
    $("#imagen_envio").val("");
    $("#imagenactual_envio").val("");
    $("#imagenmuestra_envio").attr("src", "");

    
    
   // $("#objeto_gasto").val("");
  //  $("#fecha_inicio").val("");
  //  $("#fecha_fin").val("");
    $("#codigo_dependencia").val("");
    $('#codigo_dependencia').selectpicker('refresh');
    $("#codigo_tipo_resolucion").val("");
    $('#codigo_tipo_resolucion').selectpicker('refresh');
    $("#codigo_tipo_resolucion_concepto").val("");
    $('#codigo_tipo_resolucion_concepto').selectpicker('refresh');
  //  $("#objeto").val("");
  //  $("#dependencia").val("");
 //   $("#funcion_cargo").val("");
  //  $("#region_sanitaria").val("");
   
    $('#destinatario').selectpicker('refresh');
    $("#destinatario").val("");
    $(".filas").remove();
  
     
    //Obtenemos la fecha actual

    var hoy = new Date();
    var fecha = ("0" + hoy.getDate()).slice(-2) + '-' +  ("0" + (hoy.getMonth() + 1)).slice(-2) + '-' + hoy.getFullYear();
    var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
    var fechaHora = fecha; //+ ' ' + hora;
    $('#fecha').val(fechaHora);
   
 
}
 

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
        $("#btnAgregarArt").show();
        $("#divEstado").hide();
        $("#divLugarEnvio").hide();
        $("#btnEnviar").hide();
        $("#divCic").show();      
        $("#divEnvio").hide();
        $("#divDocPedido").show();
        $("#divDocPedidoEnvio").hide();
        $('#divPedido :input').attr('disabled', false);
        $("#divCodigo").hide();
        $("#divReemplazante").hide();
        $("#codigo_tipo_pedido").prop("disabled", false);
        $('#codigo_tipo_pedido').selectpicker('refresh');
        $("#codigo_sucursal").prop("disabled", false);
        $('#codigo_sucursal').selectpicker('refresh');
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
            url: '../ajax/contrato.php?op=listar',
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
         "iDisplayLength": 10
        }).DataTable();
  }

 
//Función ListarArticulos
function listarTodasPersona()
{ 
   var detalles = [];
   numeroDocumento = document.getElementsByName("numero_documento[]");
  
   for (var i = 0; i < numeroDocumento.length; i++) {
         var detalle = {
            "numeroDocumento" : numeroDocumento[i].value
         };
         detalles.push(detalle);
    }
    var send = { 
        "detalles" : detalles
    };
    var numeroDocumentoJSON = JSON.stringify(send);
  
    tabla=$('#tblpersonas').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                     
                ],
        "ajax":
                {
                   
                    url: "../ajax/contrato.php?op=listarTodasPersona&id="+numeroDocumentoJSON,
                    type: "POST",
                    contentType: false,
                    processData: false,           
                    error: function(e){
                        console.log(e.responseText);    
                    }
                },
        "bDestroy": true,
        "iDisplayLength": 10,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();
    
}





function listarPersona()
{ 
      var archivo_cedula = '0' + document.getElementById("archivo_cedula").value;
    //  alert("hola"+archivo_cedula);
  // archivo_cedula = '0,1128963,3611617,6908217';
    tabla=$('#tblpersonas').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                     
                ],
        "ajax":
                {
                    //url: "../ajax/contrato.php?op=listarPersona&id="+archivo_cedula,
                    url: "../ajax/contrato.php?op=cargarPersona&id="+archivo_cedula,
                    type: "POST",
                   // data: formData,
                    contentType: false,
                    processData: false,        
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
  //  alert("hola");
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $('#codigo').prop('disabled',false);
   var formData = new FormData($("#formulario")[0]);
  //   var formData = new FormData(document.getElementById("formulario"));
    // var $num = document.getElementById('detalles').getElementsByTagName('tr').length - 1;
   // 			alert($num);
    $.ajax({
        url: "../ajax/contrato.php?op=guardaryeditar",
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
    $.post("../ajax/contrato.php?op=mostrar",{idcodigo : idcodigo}, function(data, status)
    {
        data = JSON.parse(data);        
        mostrarform(true);
        //$('#idcodigo').prop('disabled',false);
        $("#codigo").val(data['codigo']);
       // $('#idcodigo').prop('disabled',true);
       //alert('hola'+data['numero_expediente']);
        $("#nro_expediente").val(data['numero_expediente']);
        
       $("#codigo_dependencia").val(data['codigo_dependencia']);
       $('#codigo_dependencia').selectpicker('refresh');
         $("#codigo_tipo_resolucion").val(data['codigo_tipo_resolucion']);
        $('#codigo_tipo_resolucion').selectpicker('refresh');
        $("#codigo_tipo_resolucion_concepto").val(data['codigo_tipo_resolucion_concepto']);
        $('#codigo_tipo_resolucion_concepto').selectpicker('refresh');
       // $("#fecha_inicio").val(data['fecha_inicio']);
   //     $("#fecha_fin").val(data['fecha_fin']);
    //    $("#codigo_objeto_gasto").val(data['codigo_objeto_gasto']);
   //     $('#codigo_objeto_gasto').selectpicker('refresh');
        var nrows=document.getElementById("detalles").rows.length;
        var codigo_tipo_resolucion_concepto = document.getElementById('codigo_tipo_resolucion_concepto').value;
        if(codigo_tipo_resolucion_concepto==16){
             $("#divReemplazante").show();
        }
        
        
        
        //Ocultar y mostrar los botones
        $("#btnGuardar").show();
        $("#btnCancelar").show();
       
        
      ///  alert('hola'+codigo_tipo_resolucion_concepto);
        $.post("../ajax/contrato.php?op=mostrarDetalle&id="+idcodigo+"&nrows="+nrows+"&codigo_tipo_resolucion_concepto="+codigo_tipo_resolucion_concepto,function(r){   

         $('#detalles').append(r);
       //  detalles=detalles+1;
        evaluar();
        });
           
        
       
    });
   // alert('hola');
    
   
}



function verContrato(idcodigo)
{
    //listarLugarEnvio();
  //  alert("hola");
    $.post("../ajax/contrato.php?op=mostrar",{idcodigo : idcodigo}, function(data, status)
    {
        data = JSON.parse(data);        
        mostrarform(true);
         $("#codigo").val(data['codigo']);
       // $('#idcodigo').prop('disabled',true);
       //alert('hola'+data['numero_expediente']);
        $("#nro_expediente").val(data['numero_expediente']);
        
       $("#codigo_dependencia").val(data['codigo_dependencia']);
       $('#codigo_dependencia').selectpicker('refresh');
         $("#codigo_tipo_resolucion").val(data['codigo_tipo_resolucion']);
        $('#codigo_tipo_resolucion').selectpicker('refresh');
        $("#codigo_tipo_resolucion_concepto").val(data['codigo_tipo_resolucion_concepto']);
        $('#codigo_tipo_resolucion_concepto').selectpicker('refresh');
        
        //Ocultar y mostrar los botones
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
      
        $("#divObsEnvio").hide();
        $("#btnAgregarPersona").hide();
        $("#divAdjuntarPlanilla").hide();
        $("#divCic").hide();
      //   $("#btnInsertarPersona").hide();
       // $('#divPedido :input').attr('disabled', true);
      //   var nrows=document.getElementById("detalles").rows.length;
        var nrows=0;
        var codigo_tipo_resolucion_concepto = document.getElementById('codigo_tipo_resolucion_concepto').value;
            $('#detalles').html("");       
      ///  alert('hola'+codigo_tipo_resolucion_concepto);
        $.post("../ajax/contrato.php?op=mostrarDetalle&id="+idcodigo+"&nrows="+nrows+"&codigo_tipo_resolucion_concepto="+codigo_tipo_resolucion_concepto,function(r){   

         $('#detalles').append(r);
        
       //  detalles=detalles+1;
       // evaluar();
        });
 
             
       
    });
   // alert('hola');
 
}

function mostrarEnviar(idcodigo)
{
  
    $.post("../ajax/contrato.php?op=mostrarEnviar",{idcodigo : idcodigo }, function(data, status)
    {
        data = JSON.parse(data);        
        mostrarform(true);
        $("#codigo").val(data['codigo']);
       // $('#idcodigo').prop('disabled',true);
       //alert('hola'+data['numero_expediente']);
        $("#nro_expediente").val(data['numero_expediente']);
        
       $("#codigo_dependencia").val(data['codigo_dependencia']);
       $('#codigo_dependencia').selectpicker('refresh');
         $("#codigo_tipo_resolucion").val(data['codigo_tipo_resolucion']);
        $('#codigo_tipo_resolucion').selectpicker('refresh');
        $("#codigo_tipo_resolucion_concepto").val(data['codigo_tipo_resolucion_concepto']);
        $('#codigo_tipo_resolucion_concepto').selectpicker('refresh');
        
        
        
        //Ocultar y mostrar los botones
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#divLugarEnvio").show();
        $("#btnAgregarArt").hide();
        $("#btnEnviar").show();
            
        
        $("#divEnvio").show();
        $("#divDocPedido").hide();
        $("#divAdjuntarPlanilla").hide();
         $("#btnAgregarPersona").hide();
         $("#divCic").hide();
        $("#divDocPedidoEnvio").show();
        $('#divPedido :input').attr('disabled', true);
        
        var nrows=0;
        var codigo_tipo_resolucion_concepto = document.getElementById('codigo_tipo_resolucion_concepto').value;
        $('#detalles').html("");        
      ///  alert('hola'+codigo_tipo_resolucion_concepto);
        $.post("../ajax/contrato.php?op=mostrarDetalle&id="+idcodigo+"&nrows="+nrows+"&codigo_tipo_resolucion_concepto="+codigo_tipo_resolucion_concepto,function(r){   

         $('#detalles').append(r);
         
      
        
         });
   
   
    });
}

function cargarArchivoCsv()
{
    
  
 var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/contrato.php?op=cargarArchivo",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
 
        success: function(datos)
        { 
     
             $("#detalles").html(datos);
             $("#detalles *").attr('disabled',false);
              evaluar();
            
        }
 
    });
 
}
 
 
//Declaración de variables necesarias para trabajar con las pedido orden compra y
// sus detalles

var cont=0;
var detalles=0;
//$("#guardar").hide();
$("#btnGuardar").hide();

 function agregarDetalle(cedula_identidad,nombres,apellidos)
  {
      //alert("hola "+ idarticulo);
        var btn_1 = document.getElementById('btnAgregar'+cedula_identidad);
        var btn_2 = document.getElementById('btnAgregado'+cedula_identidad);
         
       
        
            btn_1.style.display = 'none';
            btn_2.style.display = 'inline';
      
      
 //       $("#btnAgregar" + idarticulo).display = 'none';
   //     $("#btnOK" + idarticulo).display = 'inline';  
    if (cedula_identidad!="")
    {
       
     //  var json = <?= json_encode($_SESSION)?>;
    
        var funcion_cargo = document.getElementById("funcion_cargo").value;
        var objeto_gasto = document.getElementById("objeto").value;
        var dependencia = document.getElementById("dependencia").value;
        var region_sanitaria = document.getElementById("region_sanitaria").value;
 //      alert("hola "+objetoGasto );
      // var objetoGasto = '<?php echo $_SESSION["objetoGasto"]; ?>';
       
       //alert("hola "+objetoGasto );
//    objeto_gasto=document.getElementById("codigo_objeto_gasto").value;
  //     codigo_dependencia=document.getElementById("codigo_dependencia").value;
  //     dependencia_msp = document.getElementById("codigo_dependencia");
     //  dependencia_msp = dependencia_msp.options[dependencia_msp.selectedIndex].text;
       // alert("hola "+ cedula_identidad);
   //    codigo_objeto_gasto=document.getElementById("codigo_objeto_gasto").value;
    //   descripcion_objeto_gasto = document.getElementById("codigo_objeto_gasto");
 //      descripcion_objeto_gasto = descripcion_objeto_gasto.options[descripcion_objeto_gasto.selectedIndex].text;
       //    alert("hola 2");
      // dependencia_msp=document.getElementById("dependencia_msp").innerHTML;
    
       //   '<td scope="col" style="width: 50px;font-size: 100%;"><div style="width: 50px;font-size:100%;"><input style="width: 50px;font-size:100%;" type="text" name="objeto[]" id="objeto[]" value ="'+objeto_gasto+'"></div></td>'+
    
    //   dependencia_msp= dependencia_msp.replace(/"/g, '');
        var fila='<tr  scope="col" id="fila' + cont + '" class="filas" style="font-size: 12px;" >' +
       '<td scope="col" style="text-align: center;"><div style="width: 15px;"><a class="btn btn-accent m-btn m-btn--custom' +
       'm-btn--icon m-btn--air m-btn--pill" type="button" onclick="eliminarDetalle(' + cont + ')" style="padding: unset;">' +
       '<span><i class="fa fa-trash" style="color: indianred; "></i></span></a>' +
       '<td scope="col"><input type="hidden" readonly="readonly" name="numero_documento[]" id="numero_documento[]" value="'+cedula_identidad+'">'+cedula_identidad+'</td>'+
       '<td scope="col" style="width: 180px;font-size: 100%;"><div style="width: 180px;font-size:100%;"><input style="width: 180px;font-size:100%;" type="hidden" name="nombre_apellido[]" id="nombre_apellido[]" value ="'+nombres + ' '+apellidos+'">'+nombres + ' '+apellidos+'</div></td>' +
        '<td><select id="codigo_ubicacion_prestacion[]" name="codigo_ubicacion_prestacion[]">'+dependencia+'</select></td>'+  
        '<td><select id="objeto[]" name="objeto[]">'+objeto_gasto+'</select></td>'+ 
      
         '<td><select id="cargo_funcion[]" name="cargo_funcion[]">'+funcion_cargo+'</select></td>'+       
          '<td><select id="codigo_region_sanitaria[]" name="codigo_region_sanitaria[]">'+region_sanitaria+'</select></td>'+ 
       '<td scope="col" style="width: 180px;font-size: 100%;"><div style="width: 180px;font-size:100%;"><input style="width: 180px;font-size:100%;" type="text" name="especialidad[]" id="especialidad[]"></div></td>'+
       '<td scope="col" style="width: 100px;font-size: 100%;"><div style="width: 100px;font-size:100%;"><input style="width: 100px;font-size:100%;" type="text" name="salario[]" id="salario[]"></div></td>'+
       '<td scope="col" style="width: 100px;font-size: 100%;"><div style="width: 100px;font-size:100%;"><input style="width: 100px;font-size:100%;" type="text" name="carga_horaria[]" id="carga_horaria[]"></div></td>' +
         '<td><select id="vin_1[]" name="vin1[]"><option value="-1"> </option><option value="1">SI</option><option value="2">NO</option></select></td>'+ 
         '<td><select id="vin_2[]" name="vin2[]"><option value="-1"> </option><option value="1">SI</option><option value="2">NO</option></select></td>'+  
        '<td scope="col" style="width: 100px;font-size: 100%;"><div style="width: 100px;font-size:100%;"><input style="width: 100px;font-size:100%;" type="text" name="sinar[]" id="sinar[]"></div></td>' +
        '<td><select id="estado[]" name="estado[]"><option value="1">INCLUIR</option><option value="2">EXCLUIR</option></select></td>'+  
        '<td scope="col" style="width: 100px;font-size: 100%;"><div style="width: 100px;font-size:100%;"><input style="width: 100px;font-size:100%;" type="text" name="obs[]" id="obs[]"></div></td>'
        '</tr>';
             
        cont++;
        detalles=detalles+1;
       
    //alert("hola "+fila);
        $('#detalles').append(fila);
        evaluar();
           
      //  modificarSubototales();
    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos de la persona");
    }
  }
 
function agregarPersona()
  {
      //alert("hola "+ idarticulo);
     
      var nro_cedula = document.getElementById('nro_cedula').value;
      var nrows=document.getElementById("detalles").rows.length;
      var codigo_tipo_resolucion_concepto = document.getElementById('codigo_tipo_resolucion_concepto').value;
      var cic_reemplazante = document.getElementById('nro_cedula_reemplazante').value;
      
         
    
   //  $.post("../ajax/contrato.php?op=agregarPersona&id=",{nro_cedula : nro_cedula, nrows : nrows}, function(data, status){
       // $("#detalles").html(r);
       // $("#detalles *").attr('disabled',false);
     $.post("../ajax/contrato.php?op=agregarPersona&id="+nro_cedula+"&nrows="+nrows+"&codigo_tipo_resolucion_concepto="+codigo_tipo_resolucion_concepto+"&cic_reemplazante="+cic_reemplazante,function(r){   
       
    //alert("hola "+fila);
        $('#detalles').append(r);
       //  detalles=detalles+1;
        evaluar();
    });
        
       
           
  
   
  }
 
function obtenerDependencia(input)
{
     var codigo_sirh = input.value;
    $.post("../ajax/contrato.php?op=obtenerDependencia",{codigo_sirh : codigo_sirh}, function(data, status)
    {
        data = JSON.parse(data);        
       // mostrarform(true);
        //$('#idcodigo').prop('disabled',false);
      // alert(data['nombre']);
       if (data['codigo'] > 0 ){
           $("#dependencia_msp").html(data['nombre']);
       }else {
          $("#dependencia_msp").html("");  
           
       }  
     }
       
    );
  
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
      $("#detalles").html("");
      cont=0;
    }
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

    $.post("../ajax/contrato.php?op=listarLugarEnvio", function (r) {
        $("#lugar_envio").html(r);
    });
}
 
 function enviar(e)
   {
   // alert('hola');
    $('#codigo').prop('disabled',false);
    
    var formData = new FormData($("#formulario")[0]);
 
    $.ajax({
        url: "../ajax/contrato.php?op=enviar",
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