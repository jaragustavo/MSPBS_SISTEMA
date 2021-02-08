var tabla;

//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();


    $("#formulario").on("submit", function (e) {
        // guardaryeditar(e);
        guardaryeditar(e);
    });

    $('#fecha_canje').datepicker({

        format: "dd-mm-yyyy",
        language: "es",
        locale: "es",
        autoclose: true

    });

    $('#fecha_hoy').datepicker({

        format: "dd-mm-yyyy",
        language: "es",
        locale: "es",
        autoclose: true

    });

    // $.post("../ajax/stockCanje.php?op=selectProveedor", function (r) {
    //     $("#codigo_proveedor").html(r);
    //     $('#codigo_proveedor').selectpicker('refresh');
    // });
}

//Función limpiar
function limpiar() {
    $("#codigo").val("");
    $("#codigo_proveedor").val("");
    $("#orden_compra").val("");
    $("#licitacion").val("");
    $("#sucursal").val("");
    $("#numero_lote").val("");
    $("#medicamento").val("");
    $("#fecha_vencimiento").val("");
    $("#cantidad").val("");
    $("#codigo_canje").val("");
    $("#fecha_canje").val("");
    $('#cantidad_canje').val("");
    $("#obs").val("");
    $("#imagen").val("");
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

    var fecha_alerta = new Date();

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
                url: '../ajax/stockCanje.php?op=listar&fecha_alerta=' + fecha_alerta,
                // url: '../ajax/stockCanje.php?op=listar',
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

function convertirAFecha(fecha) {
    var dia = parseInt(fecha.substr(0, 2));
    var mes = parseInt(fecha.substr(3, 2));
    var anio = parseInt(fecha.substr(6, 4));
    var concatenado = anio + "-" + mes + "-" + dia;

    var fecha_resultante = new Date(concatenado);

    return fecha_resultante;
}

function guardaryeditar(e) {
    e.preventDefault();

    var resultado = controlarCamposVacios();
    if (resultado == 0) {
        $('#codigo_canje').prop('disabled', false);
        $('#codigo_stock_medicamento').prop('disabled', false);

        //Formateador de Fechas
        var fecha_canje = $('#fecha_canje').val();
        fecha_canje = fecha_canje.substr(6, 4) + fecha_canje.substr(3, 2) + fecha_canje.substr(0, 2);
        $('#fecha_canje').val(fecha_canje);

        var formData = new FormData($("#formulario")[0]);

        $.ajax({
            url: "../ajax/stockCanje.php?op=guardaryeditar",
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
        $('#codigo_canje').prop('disabled', true);
        limpiar();
    }
}
function controlarCamposVacios() {
    /// imagen,obs_auditoria, fecha_mail, fecha_rec_proveedor
    //// 

    // if ((($('#imagen').val() == '' || $('#imagen').val() == null || $('#imagen').val() == undefined)
    //     && ($('#imagenactual').val() == '' || $('#imagenactual').val() == null || $('#imagenactual').val() == undefined))) {
    //     alert("Debe adjuntar imagen de la OC enviada");
    //     return 1;

    // }

    if ($("#observacion_canje").val() == "" || $("#observacion_canje").val() == " " || $("#observacion_canje").val() == null) {
        alert("Debe ingresar la Observacion");
        return 1;

    }

    if ($("#cantidad_canje").val() == "" || $("#cantidad_canje").val() == " " || $("#cantidad_canje").val() == null) {
        alert("Debe ingresar la Observacion");
        return 1;

    }

    if ($('#fecha_canje').val() == null || $('#fecha_canje').val() == '') {
        alert("Debe ingresar fecha de canje");
        return 1;

    }

    return 0;

}

function mostrar(codigo_stock_medicamento) {
    $.post("../ajax/stockCanje.php?op=mostrar", { codigo_stock_medicamento: codigo_stock_medicamento }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);

        $("#codigo_stock_medicamento").val(data.codigo_stock_medicamento);
        $("#licitacion").val(data.licitacion);
        $("#codigo_proveedor").val(data.codigo_proveedor);
        $("#orden_compra").val(data.orden_compra);
        $("#sucursal").val(data.sucursal);
        $("#numero_lote").val(data.numero_lote);
        $('#medicamento').val(data.medicamento);
        $("#fecha_vencimiento").val(data.fecha_vencimiento);
        $("#cantidad").val(data.cantidad);
        $("#codigo_canje").val(data.codigo_canje);
        $("#fecha_canje").val(data.fecha_canje);
        $("#cantidad_canje").val(data.cantidad_canje);
        $("#observacion_canje").val(data.observacion_canje);

        if (data.imagen === "" || data.imagen === null || data.imagen == undefined) {
            $("#imagenmuestra").hide();
        }
        else {
            $("#imagenmuestra").show();
            $("#imagenmuestra").attr("src", "../files/stockCanje/" + data.imagen);
            $("#imagenactual").val(data['imagen']);
        }


        //Ocultar y mostrar los botones
        $("#btnGuardar").show();
        $("#btnCancelar").show();
    });
    $("#divStockCanje *").attr('disabled', true);
    $("#divCanje1 *").attr('disabled', false);
    $("#divCanje2 *").attr('disabled', false);
}

init();