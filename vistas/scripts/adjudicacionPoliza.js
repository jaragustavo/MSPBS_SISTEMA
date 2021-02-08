var tabla;
$('.datepicker').datepicker({
    format: "dd-mm-yyyy",
    language: "es",
    autoclose: true

});

//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();


    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });

    $("#imagenmuestra").hide();

    $.post("../ajax/adjudicacionPoliza.php?op=selectEstadoPoliza", function (r) {
        $("#codigo_estado_poliza").html(r);
        $('#codigo_estado_poliza').selectpicker('refresh');

    });

    $('#numero_contrato').prop('disabled', true);
    $('#proveedor').prop('disabled', true);
    $('#llamado').prop('disabled', true);

}

$("#icon_calendar").click(function () {
    $("#fecha_emision").datepicker("show");
});

$("#icon_calendar2").click(function () {
    $("#fecha_inicio").datepicker("show");
});

$("#icon_calendar3").click(function () {
    $("#fecha_fin").datepicker("show");
});

//Función limpiar
function limpiar() {
    $("#codigo").val("");
    $("#codigo_contrato").val("");
    $("#numero_contrato").val("");
    $("#proveedor").val("");
    $("#llamado").val("");
    $('#aseguradora').val("");
    $("#numero_poliza").val("");
    $("#fecha_emision").val("");
    $("#fecha_inicio").val("");
    $("#fecha_fin").val("");
    $("#monto_poliza").val("");
    $("#imagenmuestra").attr("src", "");
    $("#codigo_estado_poliza").val("");
    $('#codigo_estado_poliza').selectpicker('refresh');
    $("#obs").val("");
    $("#imagenactual").val("");
    $("#imagen").empty();
}



//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnEntrega").hide();

        //Botones
        $("#btnagregar").hide();
        $("#btnGuardar").show();
        $("#btnEntrega").hide();
        $("#btnCancelar").show();
        $("#btnEnviar").hide();
    }
    else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

//Función cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
}


function listar() {
    // var fecha_actual = new Date();
    // $('#fecha_actual').val(fecha_actual);
    // alert($('#fecha_actual').val());
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
                url: '../ajax/adjudicacionPoliza.php?op=listar',
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

//Función ListarContratos
function listarContrato() {
    var detalles = [];
    idcontrato = document.getElementsByName("idcontrato[]");

    for (var i = 0; i < idcontrato.length; i++) {
        var detalle = {
            "contratos": idcontrato[i].value
        };
        detalles.push(detalle);
    }
    var send = {
        "detalles": detalles
    };
    var contratosJSON = JSON.stringify(send);

    tabla = $('#tblcontratos').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [

            ],
            "ajax":
            {

                url: "../ajax/adjudicacionPoliza.php?op=listarContrato&id=" + contratosJSON,
                type: "POST",
                contentType: false,
                processData: false,
                error: function (e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "iDisplayLength": 10,//Paginación
            "order": [[0, "desc"]]//Ordenar (columna,orden)
        }).DataTable();
}

function agregarContrato(codigo_contrato, numero_contrato, codigo_proveedor, llamado) {
    //alert("hola "+ idarticulo);
    var btn_1 = document.getElementById('btnAgregar' + codigo_contrato);
    var btn_2 = document.getElementById('btnAgregado' + codigo_contrato);
    //alert("hola "+ idarticulo);
    // alert("hola "+ btn_2);

    btn_1.style.display = 'none';
    btn_2.style.display = 'inline';


    //       $("#btnAgregar" + idarticulo).display = 'none';
    //     $("#btnOK" + idarticulo).display = 'inline';  
    if (codigo_contrato != "") {
        $("#codigo_contrato").val(codigo_contrato);
        $("#numero_contrato").val(numero_contrato);
        $("#proveedor").val(codigo_proveedor);
        $("#llamado").val(llamado);  
    }
    else {
        alert("Error al ingresar el detalle, revisar los datos del artículo");
    }
    $('#mpopupBox').hide();
}

//Función para guardar o editar
function guardaryeditar(e) {
    e.preventDefault();

    $('#codigo').prop('disabled', false);

    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/adjudicacionPoliza.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            bootbox.alert(datos);
            mostrarform(false);
            listar();
        },

    });
    $('#codigo').prop('disabled', true);
    limpiar();
}



function mostrar(codigo) {
    $.post("../ajax/adjudicacionPoliza.php?op=mostrar", { codigo: codigo }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);

        $("#codigo").val(data.codigo);
        $("#numero_contrato").val(data.numero_contrato);
        $("#proveedor").val(data.proveedor);
        $("#llamado").val(data.llamado);
        $("#aseguradora").val(data.aseguradora);
        $('#codigo_contrato').val(data.codigo_contrato);
        $("#numero_poliza").val(data.numero_poliza);
        $("#fecha_emision").val(data.fecha_emision);
        $("#fecha_inicio").val(data.fecha_inicio);
        $("#fecha_fin").val(data.fecha_fin);
        $("#monto_poliza").val(data.monto_poliza);
        $("#obs").val(data.obs);
        $("#codigo_estado_poliza").val(data.codigo_estado_poliza);
        $('#codigo_estado_poliza').selectpicker('refresh');

        if (data.imagen === "" || data.imagen === null || data.imagen == undefined) {
            $("#imagenmuestra").hide();
        }
        else {
            $("#imagenmuestra").show();
            $("#imagenmuestra").attr("src", "../files/adjudicacionPoliza/" + data.imagen);
            $("#imagenactual").val(data['imagen']);
        }


        //Ocultar y mostrar los botones
        $("#btnGuardar").show();
        $("#btnCancelar").show();
    });

}

init();