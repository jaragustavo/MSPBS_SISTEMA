var tabla;

//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();


    $("#formulario").on("submit", function (e) {
        // guardaryeditar(e);
        actualizarFecha(e);
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

    $('#fecha_envio_correo').datepicker({

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
    $.post("../ajax/ordenCompraActualizarFecha.php?op=selectProveedor", function (r) {
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
    $.get("../ajax/ordenCompraActualizarFecha.php?op=listarFeriados", function (data) {
        $("#feriados").html(data);

    });
    $.get("../ajax/ordenCompraActualizarFecha.php?op=selectTiposPlazo", function (r) {
        $("#tipo_plazo").html(r);
        $('#tipo_plazo').selectpicker('refresh');
    });
   $("#feriados").hide();
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
    $("#imagenactual").val("");
    $("#imagenmuestra").val("");
    $("#imagen").val("");
    $("#tipo_plazo").val("");
    $('#tipo_plazo').selectpicker('refresh');
    $("#es_dia_habil").prop("checked", false);
    $("#obs_auditoria").val("");

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
        $("#divTipo_dias *").attr('disabled', false);
        $('#lugar_entrega').selectpicker('refresh');

    }
    else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();

    }
    $("#divCodigo").hide();
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
                url: '../ajax/ordenCompraActualizarFecha.php?op=listar',
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

function actualizarFecha(e) {
    e.preventDefault();
    
    var resultado = controlarCamposVacios();
    if (resultado ==0){
        $('#codigo').prop('disabled', false);
        $('#plazo_entrega').prop('disabled', false);
        $('#imagen').prop('disabled', false);
        $('#dia_habil').prop('disabled', false);
        $('#numero_orden_compra').prop('disabled', false);
        //Formateador de Fechas
        var plazo_entrega = $('#plazo_entrega').val();
        plazo_entrega = plazo_entrega.substr(6, 4) + plazo_entrega.substr(3, 2) + plazo_entrega.substr(0, 2);
        $('#plazo_entrega').val(plazo_entrega);

        var fecha_rececion_oc_proveedor = $('#fecha_recepcion_oc_proveedor').val();
        fecha_rececion_oc_proveedor = fecha_rececion_oc_proveedor.substr(6, 4) + fecha_rececion_oc_proveedor.substr(3, 2) + fecha_rececion_oc_proveedor.substr(0, 2) + '' + fecha_rececion_oc_proveedor.substr(11, 8)
        $('#fecha_recepcion_oc_proveedor').val(fecha_rececion_oc_proveedor);

        var fecha_envio_correo = $('#fecha_envio_correo').val();
        fecha_envio_correo = fecha_envio_correo.substr(6, 4) + fecha_envio_correo.substr(3, 2) + fecha_envio_correo.substr(0, 2) + '' + fecha_envio_correo.substr(11, 8)
        $('#fecha_envio_correo').val(fecha_envio_correo);

        if ($("#es_dia_habil").is(":checked")) {
            $("#dia_habil").val("SI");
        }
        else {
            $("#dia_habil").val("NO");
        }
        var formData = new FormData($("#formulario")[0]);

        $.ajax({
            url: "../ajax/ordenCompraActualizarFecha.php?op=actualizarFecha",
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
}
function controlarCamposVacios() {
    /// imagen,obs_auditoria, fecha_mail, fecha_rec_proveedor
    //// 
    var fecha_envio_correo = convertirAFecha($('#fecha_envio_correo').val());
    var fecha_recepcion_oc_proveedor = convertirAFecha($('#fecha_recepcion_oc_proveedor').val());
    var fecha_orden_compra = convertirAFecha($('#fecha_orden_compra').val());

   if (( ($('#imagen').val() == '' || $('#imagen').val() == null || $('#imagen').val() == undefined) 
        && ($('#imagenactual').val() == '' || $('#imagenactual').val() == null || $('#imagenactual').val() == undefined)  )){ 
         alert("Debe adjuntar imagen de la OC enviada");
        return 1;
       
    }

    if ($('#tipo_plazo').val() == "-1" || $('#tipo_plazo').val() == null){
        alert("Debe seleccionar el tipo de plazo");
        return 1;
        
    }
    
    if (fecha_orden_compra > fecha_recepcion_oc_proveedor){
        alert("Fecha de recepcion proveedor no puede ser menor a la fecha oc");
        return 1;
        
    }
    if($("#obs_auditoria").val() == "" || $("#obs_auditoria").val() == " " || $("#obs_auditoria").val() == null){
        alert("Debe ingresar Observacion");
        return 1;
        
    }
    if(($('#fecha_envio_correo').val() == null || $('#fecha_envio_correo').val() == '') && $('#tipo_plazo').val() == 3){
       alert("Debe ingresar fecha envio correo");
        return 1;
        
    }            
    if(($('#fecha_recepcion_oc_proveedor').val() == '' ||  $('#fecha_recepcion_oc_proveedor').val() == null) && $('#tipo_plazo').val() == 1)  {
        
        alert("Debe ingresar fecha recepcion oc proveedor");
        return 1;
        
    }
    if(fecha_orden_compra > fecha_envio_correo) {
        alert("Fecha OC no puede ser mayor a fecha envio correo");
        return 1;
        
    }
   return 0;
      
}




function mostrar(codigo) {
    $.post("../ajax/ordenCompraActualizarFecha.php?op=mostrar", { codigo: codigo }, function (data, status) {
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
        $("#tipo_plazo").val(data.tipo_plazo);
        $('#tipo_plazo').selectpicker('refresh');
        $("#fecha_recepcion_oc_proveedor").val(data.fecha_recepcion_oc_proveedor);
        $("#fecha_envio_correo").val(data.fecha_envio_correo);
        $("#lugar_entrega").val(data.lugar_entrega);
        $('#lugar_entrega').selectpicker('refresh');
        $("#dependencia_solicitante").val(data.dependencia_solicitante);
        $('#dependencia_solicitante').selectpicker('refresh');
        $("#condiciones_especiales").val(data.condiciones_especiales);
        $("#forma_pago").val(data.forma_pago);
        $("#codigo_estado").val(data.codigo_estado);
        $('#codigo_estado').selectpicker('refresh');
        $("#plazo_entrega").val(data.plazo_entrega);
        $("#dia_habil").val(data.es_dia_habil);
        $("#obs_auditoria").val(data.obs_auditoria);

        if ($("#dia_habil").val() == "SI") {
            $("#es_dia_habil").prop("checked", true);
        }
        else {
            $("#es_dia_habil").prop("checked", false);
        }

        if (data.imagen === "" || data.imagen === null || data.imagen == undefined) {
            $("#imagenmuestra").hide();
        }
        else {
            $("#imagenmuestra").show();
            $("#imagenmuestra").attr("src", "../files/ordenCompraActualizarFecha/" + data.imagen);
            $("#imagenactual").val(data['imagen']);
        }


        //Ocultar y mostrar los botones
        $("#btnGuardar").show();
        $("#btnCancelar").show();
    });
    $.post("../ajax/ordenCompraActualizarFecha.php?op=listarDetalle&id=" + codigo, function (r) {
        $("#detalles").html(r);
        $("#divTblDetalles *").attr('disabled', true);
        $("#divActualizarFecha *").attr('disabled', true);
        $("#divFecProveedor *").attr('disabled', false);
        $("#divTipo_dias *").attr('disabled', false);
        $("#fecha_resultante").attr('disabled', false);
        $("#divArchivo *").attr('disabled', false);
        $("#div_tipo_plazo *").attr('disabled', false);
        $("#divObs *").attr('disabled', false);
        diasHabilesEntreFechas('04/30/2020', '05/12/2020');
    });
}

function diasHabilesPlazo(concatenado_fecha) {
    dias_plazo = parseInt($('#dias_plazo_entrega').val(), 10);
    var fecha_inicial = new Date(concatenado_fecha);

    var cantidad_dias_feriados = document.getElementById("feriados").rows.length;
    var feriados = document.getElementById("feriados").rows;
    //alert(feriados[5].cells[2]);
    var dia_hoy = fecha_inicial.getDay();
    for (i = 0; i <= dias_plazo; i++) {
        fecha_inicial.setDate(fecha_inicial.getDate() + 1);
        if (fecha_inicial.getDay() == 0 || fecha_inicial.getDay() == 6) {
            dias_plazo = dias_plazo + 1;
        }
        else {
            for (j = 0; j < cantidad_dias_feriados; j++) {
                if (fecha_inicial.getDate() == feriados[j].cells[2].innerHTML && fecha_inicial.getMonth() + 1 == feriados[j].cells[3].innerHTML) {
                    dias_plazo = dias_plazo + 1;
                    j = cantidad_dias_feriados;
                }
            }
        }


    };

    return dias_plazo;
}

function convertirAFecha(fecha) {
    var dia = parseInt(fecha.substr(0, 2));
    var mes = parseInt(fecha.substr(3, 2));
    var anio = parseInt(fecha.substr(6, 4));
    var fecha_recep = anio + "-" + mes + "-" + dia;
    
    var fecha_recep_comparar = new Date(fecha_recep);
    
    return fecha_recep_comparar;
}

function verificarFechas(fecha_recepcion) {
    var dia = parseInt(fecha_recepcion.substr(0, 2));
    var mes = parseInt(fecha_recepcion.substr(3, 2));
    var anio = parseInt(fecha_recepcion.substr(6, 4));
    var fecha_recep = anio + "-" + mes + "-" + dia;

    var fecha_orden_compra = $("#fecha_orden_compra").val()
    dia = parseInt(fecha_orden_compra.substr(0, 2));
    mes = parseInt(fecha_orden_compra.substr(3, 2));
    anio = parseInt(fecha_orden_compra.substr(6, 4));
    var fecha_oc = anio + "-" + mes + "-" + dia;
    var fecha_oc_comparar = new Date(fecha_oc);
    var fecha_recep_comparar = new Date(fecha_recep);
    if (fecha_recep_comparar < fecha_oc_comparar) {
        alert("La fecha ingresada para el calculo del plazo de entrega debe ser mayor o igual a la fecha de la Orden de Compra.")
        fecha_recepcion = "";
    }
    return fecha_recepcion;
}

function refreshPlazoEntrega() {
    if ($("#tipo_plazo").val() == "1") {
        var fecha_recepcion = $("#fecha_recepcion_oc_proveedor").val();
    }
    else {
        if ($("#tipo_plazo").val() == "3") {
            var fecha_recepcion = $("#fecha_envio_correo").val();
        }
    }

    fecha_recepcion = verificarFechas(fecha_recepcion);

    var dia = parseInt(fecha_recepcion.substr(0, 2));
    var mes = parseInt(fecha_recepcion.substr(3, 2));
    var anio = parseInt(fecha_recepcion.substr(6, 4));
    var concatenado_fecha = anio + "-" + mes + "-" + dia;
    var dias_plazo = parseInt($('#dias_plazo_entrega').val(), 10);
    var bisiesto = anio % 4;

    var es_dia_habil = $("#es_dia_habil").is(":checked");
    if (es_dia_habil) {
        //diasHabiles(concatenado_fecha);
        dias_plazo = diasHabilesPlazo(concatenado_fecha);
    }
    //alert(dias_plazo);

    dias_plazo = dias_plazo + dia;

    while (dias_plazo > 365) {
        if ((anio % 4) != 0) {
            dias_plazo = dias_plazo - 365;
            anio = anio + 1;
        }
        else {

            dias_plazo = dias_plazo - 366;
            anio = anio + 1;
        }
    }

    while (dias_plazo > 28) {

        if (dias_plazo > 31 && (mes == 1 || mes == 3 || mes == 5 || mes == 7 || mes == 8 || mes == 10 || mes == 12)) {

            if (mes == 12) {
                dias_plazo = dias_plazo - 31;
                anio = anio + 1;
                mes = 1;
                dia = dias_plazo;
            }
            else {
                dias_plazo = dias_plazo - 31;
                mes = mes + 1;
                dia = dias_plazo;
            }
        }
        else {

            if (dias_plazo > 30 && (mes === 4 || mes === 6 || mes === 9 || mes === 11)) {
                dias_plazo = dias_plazo - 30;
                mes = mes + 1;
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
    if (dias_plazo != 0) {
        dia = dias_plazo;
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

    if (fecha_recepcion == "") {
        fecha_recepcion = "";
        $('#plazo_entrega').val("");
    }
}

function diasHabilesEntreFechas(fecha_inicio, fecha_fin) {
    fecha_inicio = new Date(fecha_inicio);
    fecha_fin = new Date(fecha_fin);
    var fecha_actual = new Date(fecha_inicio);

    var cantidad_dias_feriados = document.getElementById("feriados").rows.length;
    var feriados = document.getElementById("feriados").rows;

    var dias_no_habiles = 0;

    while (fecha_actual < fecha_fin) {
        fecha_actual.setDate(fecha_actual.getDate() + 1);
        if (fecha_actual.getDay() == 0) {
            dias_no_habiles = dias_no_habiles + 1;
        }
        else {
            for (j = 0; j < cantidad_dias_feriados; j++) {
                if (fecha_actual.getDate() == feriados[j].cells[2].innerHTML && fecha_actual.getMonth() + 1 == feriados[j].cells[3].innerHTML) {
                    dias_no_habiles = dias_no_habiles + 1;
                    j = cantidad_dias_feriados;
                }
            }
        }


    };
    var dias_totales = daysdifference(fecha_inicio, fecha_fin);
    var dias_habiles = dias_totales - dias_no_habiles;
    $("#fecha_resultante").val(dias_habiles);
}

function daysdifference(date1, date2) {
    // The number of milliseconds in one day
    var ONEDAY = 1000 * 60 * 60 * 24;
    // Convert both dates to milliseconds
    var date1_ms = date1.getTime();
    var date2_ms = date2.getTime();
    // Calculate the difference in milliseconds
    var difference_ms = Math.abs(date1_ms - date2_ms);

    // Convert back to days and return
    return Math.round(difference_ms / ONEDAY);
}
// maite fin
init();