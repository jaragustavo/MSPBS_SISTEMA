var tabla;

$('.datepicker').datepicker({

    format: "dd-mm-yyyy",
    language: "es",
    locale: "es",
    autoclose: true

});

$("#botonBuscarItem").on('click', function () {
    // limpiarCampos();
    $("#buscarItem").load("buscarItem.html");
    $("#buscarItem").fadeIn("slow");
    $("#formularioregistros").fadeOut("slow");

});

//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();
    $("#imagenmuestra").hide();

    $.post("../ajax/ofertaCovid.php?op=selectProveedor", function (r) {
        $("#codigo_proveedor").html(r);
        $('#codigo_proveedor').selectpicker('refresh');
    });
    $.post("../ajax/ofertaCovid.php?op=selectEstadoCovid", function (r) {
        $("#codigo_estado").html(r);
        $('#codigo_estado').selectpicker('refresh');
    });




    $("#formulario").on("submit", function (e) {

        guardaryeditar(e);


    });
    var hoy = new Date();
    var fecha = ("0" + hoy.getDate()).slice(-2) + '-' + ("0" + (hoy.getMonth() + 1)).slice(-2) + '-' + hoy.getFullYear();
    var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
    var fechaHora = fecha + ' ' + hora;
    $('#fecha_hora').val(fechaHora);
    // alert("hola");
    //Cargamos los items al select proveedor
    $("#imagenmuestra").on('click', function () {
        abrirImagen();

    });
    $("#imagenmuestra").hide();
}

//Función limpiar
function limpiar() {
    $("#codigo").val("");
    $("#fecha_oferta").val("");
    $("#codigo_item").val("");
    $("#nombre_item").val("");
    $("#codigo_proveedor").val("-1");
    $('#codigo_proveedor').selectpicker('refresh');
    $("#cantidad_ofrecida").val("");
    $("#precio_unitario").val("");
    $("#dias_disponible").val("");
    $("#codigo_estado").val("-1");
    $('#codigo_estado').selectpicker('refresh');
    $("#condiciones").val("");
    $("#condiciones").empty();
    $("#obs").val("");
    $("#imagenmuestra").attr("src", "");
     $("#imagenmuestra").hide();
    $("#imagen").val("");



    //Obtenemos la fecha actual

    var hoy = new Date();
    var fecha = ("0" + hoy.getDate()).slice(-2) + '-' + ("0" + (hoy.getMonth() + 1)).slice(-2) + '-' + hoy.getFullYear();
    var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
    var fechaHora = fecha + ' ' + hora;
    $('#fecha_hora').val(fechaHora);


}

//Función mostrar formulario
function mostrarform(flag) {

    if (flag) {
        $("#listadoregistros").hide();

        $("#formularioregistros").show();
        //$("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();


        $("#btnGuardar").show();
        $("#btnCancelar").show();

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

function editarOferta(idcodigo, codigo_item) {
    var codigo_item;
    mostrarform(false);
    $("#codigo").val(idcodigo);
    //    $("#btnMostrarEnviar").hide();
    //  $("#btnAnular").hide();


    $.post("../ajax/ofertaCovid.php?op=editarOferta", { idcodigo: idcodigo }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        $("#codigo_item").val(data.codigo_item_covid);
        $("#nombre_item").val(data.item);
        $("#codigo_proveedor").val(data.codigo_proveedor);
        $("#cantidad_ofrecida").val(data.cantidad);
        $("#codigo_proveedor").val(data.codigo_proveedor);
        $('#codigo_proveedor').selectpicker('refresh');
        $("#precio_unitario").val(data.precio_unitario);
        $("#dias_disponible").val(data.dias_disponible);
        $("#obs").val(data.obs);
        $("#fecha_oferta").val(data.fecha_oferta);
        $("#codigo_estado").val(data.codigo_estado);
        $('#codigo_estado').selectpicker('refresh');
        // listarCondicionOferta(val(data.codigo),val(data.codigo_item_covid));

        
        //alert("../files/proveedorOferta/"+data.imagen);
        if (data.imagen === "" || data.imagen===null){
            $("#imagenmuestra").hide();
        }
        else{
            $("#imagenmuestra").show();
            $("#imagenmuestra").attr("src", "../files/ofertaProveedor/" + data.imagen);
        }
        


        //Maite
        $("#img01").attr("src", "../files/ofertaProveedor/" + data.imagen);
    });
    $("#btnGuardar").show();
    //  alert(codigo_item);
    listarCondicionOferta(idcodigo, codigo_item);
    // $("#btnCancelar").show();
    // evaluar();
    // listarCondicionOferta(idcodigo);
    // alert('hola');


}
function listarCondicionOferta(codigo_oferta, codigo_item_covid) {

    $.post("../ajax/ofertaCovid.php?op=listarCondicion&codigo_oferta=" + codigo_oferta + "&codigo_item_covid=" + codigo_item_covid, function (r) {
        $("#condiciones").html(r);
    });
}


//Función Listar
function listar() {

    tabla = $('#tbllistado').dataTable(
        {
            "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
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
                url: '../ajax/ofertaCovid.php?op=listar',
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
            "order": [[1, "desc"]]//Ordenar (columna,orden)
        }).DataTable();
}







function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento


    $('#codigo').prop('disabled', false);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/ofertaCovid.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            bootbox.alert(datos);
            mostrarform(false);
            listar();
            limpiar();

        }

    });
    $('#codigo').prop('disabled', true);
    //    $('#fecha_hora').prop('disabled',true);


}

function darFormatoNumero() {

    var cantidad = document.getElementsByName("cantidad[]");
    var stock = document.getElementsByName("stock[]");

    for (var i = 0; i < stock.length; i++) {
        cantidad[i].value = cantidad[i].value.replace(/\./g, '');

        if (!isNaN(cantidad[i].value)) {
            var aux = parseInt(cantidad[i].value);

            aux = aux.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
            aux = aux.split('').reverse().join('').replace(/^[\.]/, '');
            cantidad[i].value = aux;
        } else {
            cantidad[i].value = 0;
        }
    }
    verificarCantidadSolicitada();
}

function sacarFormatoNumero() {

    var cantidad = document.getElementsByName("cantidad[]");
    var stock = document.getElementsByName("stock[]");

    for (var i = 0; i < stock.length; i++) {
        if (!isNaN(cantidad[i].value)) {
            cantidad[i].value = cantidad[i].value.replace(/\./g, '');
        }
    }
    verificarCantidadSolicitada();
}
function listarItem() {

    tabla = $('#tblItem').dataTable(
        {
            "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
            buttons: [
            ],
            "ajax":
            {
                url: '../ajax/ofertaCovid.php?op=listarItem',
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
            "order": [[1, "desc"]]//Ordenar (columna,orden)


        }).DataTable();



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

function openTab(th)
{
    window.open(th.src,'_blank');
}
// Maite
init();
