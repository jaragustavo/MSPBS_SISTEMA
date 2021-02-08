var tabla;
var hoy = new Date();
var fecha = ("0" + hoy.getDate()).slice(-2) + '-' + ("0" + (hoy.getMonth() + 1)).slice(-2) + '-' + hoy.getFullYear();
var fechaActual = fecha;
// alert(fechaActual);
$('#fecha_inicio').val(fechaActual);


$('.datepicker').datepicker({
    format: "dd-mm-yyyy",
    language: "es",
    locale: "es",
    autoclose: true

});
$("#botonAgregarCondicionItem").on('click', function () {
    agregarCondicionItemPopup();

});
$("#idbuttonCondicionItem").on('click', function () {
    agregarCondicion();

});

function cerrarPopup() {
    $('#mpopupBox').hide();
}

//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();



    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });

    $.post("../ajax/util.php?op=selectEstado", function (r) {
        $('#codigo_estado').html(r);
        $('#codigo_estado').selectpicker('refresh');
    });

}

function agregarCondicionItemPopup() {

    // get the mPopup
    var mpopup = $('#mpopupBox');

    // open the mPopup
    mpopup.show();

    // close the mPopup once close element is clicked
    $(".close").on('click', function () {
        mpopup.hide();
    });

    // close the mPopup when user clicks outside of the box
    $(window).on('click', function (e) {
        if (e.target == mpopup[0]) {
            mpopup.hide();
        }
    });
}

var cont = 0;
var detalles = 0;
function eliminarDetalle(indice) {
    $("#fila" + indice).remove();
    //calcularTotales();
    detalles = detalles - 1;

}
function agregarCondicion() {
    popupCondicionItem = document.getElementById("popupCondicionItem").value;
    //alert('Condicion agrgado:'+popupCondicionItem);
    var fila = '<tr id="fila' + cont + '" class="filas" style="font-size: 12px;" >' +
        '<td style="text-align: center;"><a class="btn btn-accent m-btn m-btn--custom' +
        'm-btn--icon m-btn--air m-btn--pill type="button" onclick="eliminarDetalle(' + cont + ')">' +
        '<span><i class="fa fa-trash" style="color: indianred; font-size: 1.5em; "></i></span></a>' +
        '<td scope="col"><div style="width: 120px;"><input title="' + popupCondicionItem + '"type="text"' +
        ' readonly="readonly"  name="condicion_item[]" id="condicion_item[]"  value="' + popupCondicionItem + '"></div></td>'
    cont++;
    detalles = detalles + 1;
    $('#tblCondicionItem').append(fila);
    $('#mpopupBox').hide();
}
//Función limpiar
function limpiar() {
    $("#codigo").val("");
    $("#codigo_catalogo").val("");
    $("#item_numero").val("");
    $("#nombre").val("");
    $("#especificacion_tecnica").val("");
    $("#presentacion").val("");
    $("#presentacion_entrega").val("");
    $("#monto").val("");
    $("#cantidad_necesitada").val("");
    $("#observacion").val("");
    $("#fecha_inicio").val("");
    $("#fecha_cierre").val("");
    $("#codigo_estado").val("");
    $('#codigo_estado').selectpicker('refresh');
    $("#tblCondicionItem").empty();
    $("#imagenmuestra").val("");
    //alert("entre");

}



//Función mostrar formulario
function mostrarform(flag) {
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();


        //Botones
        $("#btnagregar").hide();
        $("#btnGuardar").show();
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
                url: '../ajax/covidItem.php?op=listar',
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



//Función para guardar o editar

function guardaryeditar(e) {
    e.preventDefault();

    $('#codigo').prop('disabled', false);


    var fecha_inicio = $('#fecha_inicio').val();
    fecha_inicio = fecha_inicio.substr(6, 4) + fecha_inicio.substr(3, 2) + fecha_inicio.substr(0, 2) + '' + fecha_inicio.substr(11, 8)
    $('#fecha_inicio').val(fecha_inicio);

    var fecha_cierre = $('#fecha_cierre').val();
    fecha_cierre = fecha_cierre.substr(6, 4) + fecha_cierre.substr(3, 2) + fecha_cierre.substr(0, 2) + '' + fecha_cierre.substr(11, 8)
    $('#fecha_cierre').val(fecha_cierre);
    //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    //alert($('#cantidad_necesitada').val());
    if ($('#cantidad_necesitada').val() == "") {
        $('#cantidad_necesitada').val(0)
        alert($('#cantidad_necesitada').val());
    }
    if ($('#monto').val() == "") {
        $('#monto').val(0)
    }




    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/covidItem.php?op=guardaryeditar",
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



function mostrar(codigo) {
    $.post("../ajax/covidItem.php?op=mostrar", { codigo: codigo }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);

        //  document.getElementById("selectEstado").hidden = false;

        $("#codigo").val(data.codigo);
        $("#codigo_catalogo").val(data.codigo_catalogo);
        $("#item_numero").val(data.item_numero);
        $("#nombre").val(data.nombre);
        $("#especificacion_tecnica").val(data.especificacion_tecnica);
        $("#presentacion").val(data.presentacion);
        $("#presentacion_entrega").val(data.presentacion_entrega);
        $("#monto").val(data.monto);
        $("#cantidad_necesitada").val(data.cantidad_necesitada);
        $("#observacion").val(data.observacion);
        $("#fecha_inicio").val(data.fecha_inicio);
        $("#fecha_cierre").val(data.fecha_cierre);
        $("#codigo_estado").val(data.codigo_estado);
        $('#codigo_estado').selectpicker('refresh');
        $("#imagenmuestra").val(data.imagen);

        //Ocultar y mostrar los botones
        $("#btnGuardar").show();
        $("#btnCancelar").show();
        //esconder frame cuando no hay archivo. Maite    
        if (data.imagen === "" || data.imagen === null) {
            $("#imagenmuestra").hide();
        }
        else {
            $("#imagenmuestra").show();
            $("#imagenmuestra").attr("src", "../files/ofertaProveedor/" + data.imagen);
        }
        //Maite
    });
    //alert(codigo);
    $.post("../ajax/covidItem.php?op=listarCondicionItem&codigo=" + codigo, function (r) {
        $("#tblCondicionItem").html(r);
    });

}
//   Maite
function abrirImagen() {

    // Get the modal

    var modal = document.getElementById("myModal");


    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById("imagenmuestra");
    var modalImg = document.getElementById("imagenactual");
    var captionText = document.getElementById("caption");

    modal.style.display = "block";
    modal.src = this.src;
    captionText.innerHTML = this.alt;


    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    span.focus();
    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }


}
//Maite

init();