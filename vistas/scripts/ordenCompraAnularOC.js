var tabla;

//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();


    $("#formulario").on("submit", function (e) {
        anularOC(e);
    });

    $('#fecha_contrato').datepicker({

        format: "dd-mm-yyyy",
        language: "es",
        locale: "es",
        autoclose: true

    });
    $('#fecha_orden_compra').datepicker({

        format: "dd-mm-yyyy",
        language: "es",
        locale: "es",
        autoclose: true

    });
    $('#fecha_recepcion_oc_proveedor').datepicker({

        format: "dd-mm-yyyy",
        language: "es",
        locale: "es",
        autoclose: true

    });
    $('#plazo_entrega').datepicker({

        format: "dd-mm-yyyy",
        language: "es",
        locale: "es",
        autoclose: true

    });
    $.post("../ajax/ordenCompraAnularOC.php?op=selectProveedor", function (r) {
        $("#codigo_proveedor").html(r);
        $('#codigo_proveedor').selectpicker('refresh');
    });
    $.post("../ajax/ordenCompraActualizarFecha.php?op=selectDependenciaSolicitante", function (r) {
        $("#dependencia_solicitante").html(r);
        $('#dependencia_solicitante').selectpicker('refresh');
    });
    $.post("../ajax/ordenCompraActualizarFecha.php?op=selectLugarEntrega", function (r) {
        $("#lugar_entrega").html(r);
        $('#lugar_entrega').selectpicker('refresh');
    });
    $.post("../ajax/ordenCompraActualizarFecha.php?op=selectEstado", function (r) {
        $("#codigo_estado").html(r);
        $('#codigo_estado').selectpicker('refresh');
    });

    $('#divCodigo').attr('hidden', true);
    $("#codigo").prop('disabled', true);
    $("#numero_orden_compra").prop('disabled', true);
    $("#licitacion").prop('disabled', true);
    $("#proveedor").prop('disabled', true);
    $("#fecha_contrato").prop('disabled', true);
    $("#dias_plazo_entrega").prop('disabled', true);
    $("#fecha_orden_compra").prop('disabled', true);
    $("#divFecProveedor").prop('disabled', true);
    
    $("#lugar_entrega").prop('disabled', true);
    $("#dependencia_solicitante").prop('disabled', true);
    $("#condiciones_especiales").prop('disabled', true);
    $("#forma_pago").prop('disabled', true);
    $("#codigo_estado").prop('disabled', true);
    $("#plazo_entrega").prop('disabled', true);
    $("#plazo_entrega").prop('disabled', true);
}

//Función limpiar
function limpiar() {
    $("#codigo").val("");
    $("#numero_orden_compra").val("");
    $("#licitacion").val("");
    $("#proveedor").val("");
    $('#proveedor').selectpicker('refresh');
    $("#fecha_contrato").val("");
    $("#dias_plazo_entrega").val("");
    $("#fecha_orden_compra").val("");
    $("#fecha_recepcion_oc_proveedor").val("");
    $("#lugar_entrega").val("");
    $('#lugar_entrega').selectpicker('refresh');
    $("#dependencia_solicitante").val("");
    $('#dependencia_solicitante').selectpicker('refresh');
    $("#condiciones_especiales").val("");
    $("#forma_pago").val("");
    $("#codigo_estado").val("");
    $('#codigo_estado').selectpicker('refresh');
    $("#plazo_entrega").val("");
    $("#observacion").val("");
}



//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();


        //Botones
        $("#btnagregar").hide();
        $("#btnGuardar").show();
        $("#btnCancelar").show();
        $("#btnEnviar").hide();

        $("#divFecProveedor *").attr('disabled', false);
        $('#lugar_entrega').selectpicker('refresh');

    }
    else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").hide();

    }
}

//Función cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
}

function listar() {

    tabla = $('#tbllistado').dataTable(
        {
            "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
            buttons: [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function (data, row, column, node) {
                                data = $('<p>' + data + '</p>').text();
                                return data.replace('.', ',');
                            }
                        }
                    }
                },


                'copyHtml5',

                'csvHtml5',
                'pdf'
            ],




            "ajax":
            {
                url: '../ajax/ordenCompraAnularOC.php?op=listar',
                type: "get",
                dataType: "json",
                error: function (e) {
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
            "order": [[3, "asc"]]//Ordenar (columna,orden)
        }).DataTable();
}


function anularOC(e) {
    e.preventDefault();
    if ($('#observacion').val() != '' || $('#observacion').val() != null){
        $('#codigo').prop('disabled', false);
        $('#codigo_estado').prop('disabled', false);
        $('#numero_orden_compra').prop('disabled', false);
        $("#divTblDetalles *").attr('disabled', false);
        

        var formData = new FormData($("#formulario")[0]);
        $.ajax({
            url: "../ajax/ordenCompraAnularOC.php?op=anularOC" , 
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function (datos) {
                bootbox.alert(datos);
                mostrarform(false);
                listar();
            }
        });
        $('#codigo').prop('disabled', true);
        limpiar();
    }
    else {
        alert("Debe cargar una observacion para Anular la Orden de Compra.");
    }

}



function mostrar(codigo) {
    $.post("../ajax/ordenCompraAnularOC.php?op=mostrar", { codigo: codigo }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        

        $("#codigo").val(data.codigo);
        $("#numero_orden_compra").val(data.numero_orden_compra);
        $("#licitacion").val(data.licitacion);
        $("#codigo_proveedor").val(data.codigo_proveedor);
        $('#codigo_proveedor').selectpicker('refresh');
        $("#fecha_contrato").val(data.fecha_contrato);
        $("#dias_plazo_entrega").val(data.dias_plazo_entrega);
        $('#fecha_orden_compra').val(data.fecha_orden_compra);
        $("#fecha_recepcion_oc_proveedor").val(data.fecha_recepcion_oc_proveedor);;
        $("#lugar_entrega").val(data.lugar_entrega);
        $('#lugar_entrega').selectpicker('refresh')
        $("#dependencia_solicitante").val(data.dependencia_solicitante);
        $('#dependencia_solicitante').selectpicker('refresh');
        $("#condiciones_especiales").val(data.condiciones_especiales);
        $("#forma_pago").val(data.forma_pago);
        $("#codigo_estado").val(data.codigo_estado);
        $('#codigo_estado').selectpicker('refresh');
        $("#plazo_entrega").val(data.plazo_entrega);
        $("#observacion").attr('required', true);  
        $("#codigo_proveedor").attr('disabled', true);  
        
        //Ocultar y mostrar los botones
        $("#btnGuardar").show();
        $("#btnCancelar").show();
    });
    $.post("../ajax/ordenCompraAnularOC.php?op=listarDetalle&id=" + codigo, function (r) {
        $("#detalles").html(r);
        $("#divTblDetalles *").attr('disabled', true);
        $("#divAnularOC *").attr('disabled', true);
        $("#divFecProveedor *").attr('disabled', true);
    });
     
}

// 
function refreshPlazoEntrega() {
    var fecha_recepcion = $('#fecha_recepcion_oc_proveedor').val(); // 30/10/2019
    var dia = parseInt(fecha_recepcion.substr(0, 2)); // 30
    var mes = parseInt(fecha_recepcion.substr(3, 2)); // 10
    var anio = parseInt(fecha_recepcion.substr(6, 4)); // 2019
    var dias_plazo = parseInt($('#dias_plazo_entrega').val(), 10); //30
    var bisiesto = anio % 4;

    dias_plazo = dias_plazo + dia; // 30+30=60

    while (dias_plazo > 365) { //no entra
        if ((anio % 4) != 0) {
            dias_plazo = dias_plazo - 365;
            anio = anio + 1;
        }
        else {

            dias_plazo = dias_plazo - 366;
            anio = anio + 1;        
        }
    }

    while (dias_plazo > 28) { // 1 entra con 60 / 2 entra con 30

        if (dias_plazo > 31 && (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 8 || mes == 10 || mes == 12)) { // 1 entra con 10

            if (mes == 12) {
                dias_plazo = dias_plazo - 31; // 65-31=34 
                anio = anio + 1;
                mes = 1;
                dia = dias_plazo;
                
            }
            else {
                dias_plazo = dias_plazo - 31; // 65-31=34 
                mes = mes + 1; // 11
                dia = dias_plazo;
                
            }
        }
        else {

            if (dias_plazo > 30 && (mes == 4 || mes == 6 || mes == 9 || mes == 11)) { // 2 entra con 11
                dias_plazo = dias_plazo - 30; // 4
                mes = mes + 1; // 12
                dia = dias_plazo;
                
            }
            else {
                if (mes == 2) {
                    if (bisiesto == 0 && dias_plazo > 29) {
                        dias_plazo = dias_plazo - 29;
                        mes = mes + 1;
                        dia = dias_plazo;
                        
                    } else {
                        if (bisiesto != 0 && dias_plazo > 28) {
                            dias_plazo = dias_plazo - 28;
                            mes = mes + 1;
                            dia = dias_plazo;
                            
                        }
                    }
                }
                else {
                    dia = dias_plazo;
                    dias_plazo = 0;
                    
                }
            }
        }

    }
    if (mes < 10) {
        if (dia < 10) {
            $('#plazo_entrega').val("0" + dia + "-0" + mes + "-" + anio);
            
        }
        else {
            $('#plazo_entrega').val(dia + "-0" + mes + "-" + anio);
            
        }
    }
    else {
        if (dia < 10) {
            $('#plazo_entrega').val("0" + dia + "-" + mes + "-" + anio);
            
        }
        else {
            $('#plazo_entrega').val(dia + "-" + mes + "-" + anio);
            
        }
    }

}
// maite fin



init();