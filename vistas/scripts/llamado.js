var tabla;

//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function(e) {

        guardaryeditar(e);
    });

    $.post("../ajax/util.php?op=selectTipoLlamado", function(r) {
        $('#codigo_tipo_llamado').html(r);
        $('#codigo_tipo_llamado').selectpicker('refresh');
        //alert(r);
    });
    $.post("../ajax/util.php?op=selectEstadoLlamado", function(r) {
        $('#codigo_estado_llamado').html(r);
        $('#codigo_estado_llamado').selectpicker('refresh');
        //alert(r);
    });
    $('.datepicker').datepicker({
        format: "dd-mm-yyyy",
        language: "es",
        locale: "es",
        autoclose: true
    });
    $("#icon_calendar").click(function() {
        $("#fecha_llamado").datepicker("show");
    });

}

//Función limpiar
function limpiar() {
    $("#id_llamado").val("");
    $("#fecha_llamado").val("");
    $("#tipo_llamado").val("");
    $("#numero").val("");
    $("#anio").val("");
    $("#idtitulo").val("");
    $("#observacion").val("");
    $("#codigo_pedido_producto").val("");
    $("#numero_pac").val("");

}



//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioConsulta").hide();
        $("#formularioregistros").show();
        //$("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
        //listarArticulos();
        // $("#codigo_tipo_adjudicacion").true();
        $("#btnGuardar").show();
        $("#btnCancelar").show();
        detalles = 0;
        $("#btnAgregarArt").show();
        $("#btnEnviar").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
        $("#formularioConsulta").hide();
    }

}

//Función cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
}

function listar() {
    tabla = $('#tbllistado').dataTable({
        "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        dom: '<Bl<f>rtip>', //Definimos los elementos del control de tabla
        buttons: [{
                extend: 'excel',
                exportOptions: {
                    columns: ':visible',
                    format: {
                        body: function(data, row, column, node) {
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




        "ajax": {
            url: '../ajax/llamado.php?op=listar',
            type: "get",
            dataType: "json",
            error: function(e) {
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
        "iDisplayLength": 10, //Paginación
        "order": [
                [3, "asc"]
            ] //Ordenar (columna,orden)
    }).DataTable();
}



//Función para guardar o editar

function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#codigo_pedido_producto").prop("disabled", false);

    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/llamado.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            bootbox.alert(datos);
            mostrarform(false);
            listar();
        }

    });
    $("#codigo_pedido_producto").prop("disabled", true);
    limpiar();
}



function mostrar(codigo) {

    $.post("../ajax/llamado.php?op=mostrar", { codigo: codigo }, function(data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        //alert(''+val('codigo'));
        $("#codigo").val(data['codigo']);
        $("#id_llamado").val(data['id_llamado']);
        $("#fecha_llamado").val(data['fecha_llamado']);
        $("#codigo_tipo_llamado").val(data['codigo_tipo_llamado']);
        $("#codigo_tipo_llamado").selectpicker('refresh');
        $("#codigo_estado_llamado").val(data['codigo_estado_llamado']);
        $("#codigo_estado_llamado").selectpicker('refresh');
        $("#numero").val(data['numero']);
        $("#anio").val(data['anio']);
        $("#idtitulo").val(data['titulo']);
        $("#observacion").val(data['observacion']);
        $("#codigo_pedido_producto").val(data['codigo_pedido_producto']);
        $("#numero_pac").val(data['numero_pac']);
        //Ocultar y mostrar los botones
        $("#btnGuardar").show();
        $("#btnCancelar").show();
    });

}

function listarPedidoProducto() {

    tabla = $('#tblPedidoProducto').dataTable({
        "lengthMenu": [5, 10, 25, 75, 100], //mostramos el menú de registros a revisar
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        dom: '<Bl<f>rtip>', //Definimos los elementos del control de tabla
        buttons: [],
        "ajax": {
            url: '../ajax/llamado.php?op=listarPedidoProducto',
            type: "get",
            dataType: "json",
            error: function(e) {
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
        "iDisplayLength": 10, //Paginación
        "order": [
                [1, "desc"]
            ] //Ordenar (columna,orden)


    }).DataTable();


}


init();