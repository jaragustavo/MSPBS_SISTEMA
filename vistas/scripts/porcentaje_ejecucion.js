var tabla;
//Función que se ejecuta al inicio
function init()
{
	listar();
}

//Función Listar
function listar()
{
	//var fecha_inicio = $("#fecha_inicio").val();
    //var fecha_fin = $("#fecha_fin").val();

    	tabla=$('#tblConsolidado').dataTable(
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
                    url: 'http://localhost/indicadores_historicos/ajax/porcentaje_ejecucion.php?op=listar',
                    type : "get",
                    dataType : "json",						
                    error: function(e){
                    console.log(e.responseText);	
                    }
                    },
		"language": {
            "lengthMenu": "Mostrar : _MENU_ registros",
            "buttons": {
            "copyTitle": "Tabla Copiada",
            "copySuccess": {
                    _: '%d líneas copiadas',
                    1: '1 línea copiada'
                }
            }
                },
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 1, "asc" ]]//Ordenar (columna,orden)
	}).DataTable();
}


 init();

