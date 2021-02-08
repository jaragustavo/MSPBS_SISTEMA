var tabla;
 
//Función que se ejecuta al inicio
function init(){
   
    listar();
   
 
        
}
 
//Función limpiar
function limpiar()
{
    $("#idcodigo").val("");
    $("#fecha_hora").val("");
    $("#numero_expediente").val("");
   
    $(".filas").remove();
  
     
    //Obtenemos la fecha actual

     var hoy = new Date();
 
     
    var fecha = ("0" + hoy.getDate()).slice(-2) + '-' +  ("0" + (hoy.getMonth() + 1)).slice(-2) + '-' + hoy.getFullYear();
    var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
    var fechaHora = fecha + ' ' + hora;
    $('#fecha_hora').val(fechaHora);
   
 
}
 

//Función cancelarform
function cancelarform()
{
    limpiar();
    mostrarform(false);
}
 
function listar()
{
        tabla=$('#tbllistado').dataTable(
        {
                    "lengthMenu": [ 5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
         "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
            buttons: [ 
                {
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
        
          
                 
        
         "ajax":
           {
            url: '../ajax/pagoProveedor.php?op=listar',
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
            "order": [[ 3, "asc" ]]//Ordenar (columna,orden)
        }).DataTable();
  }
    
function mostrarModalLlamadoProveedor(codigo_adjudicacion)
{
            tabla=$('#tblModal').dataTable(
	    {
	        "aProcessing": true,//Activamos el procesamiento del datatables
	        "aServerSide": true,//Paginación y filtrado realizados por el servidor
	        dom: 'Bfrtip',//Definimos los elementos del control de tabla
	        buttons: [                
	                    'copyHtml5',
	                    'excelHtml5',
	                    'csvHtml5'
	                ],
	                
	        "ajax":
	                {
                          url: '../ajax/pagoProveedor.php?op=mostrarModalLlamadoProveedor',
                          //   url: 'https://siciap.mspbs.gov.py/indicadores_historicos/ajax/informe_ejecucion_oc.php?op=mostrarModalOCrecepcion',
                            data:{codigo_adjudicacion : codigo_adjudicacion},
	                    type : "get",
	                    dataType : "json",	                    
	                    error: function(e){
	                        console.log(e.responseText);	                        
	                    }	                    
	                },
	                
	        "bDestroy": true,
	        "iDisplayLength": 8,//Paginación
	        "order": [[ 0, "desc" ]],//Ordenar (columna,orden)	    
	    }).DataTable();
     
     $("#myModal").modal('show'); //concepcion
   

}

function mostrarDatosEspecificos(enlace) {
    // ---------------------------------------------------------------
    var parametros;
    var codigoMedicamento;
    var fila, filaNueva, columna, capa;    
// ---------------------------------------------------------------
  
    fila                = enlace.parentNode.parentNode;
    
   codigo_adjudicacion   = fila.getElementsByTagName( "input" )[0].value;
    codigo_proveedor   = fila.getElementsByTagName( "input" )[1].value;
//   alert(codigo_adjudicacion);
 //   alert(codigo_proveedor);
   
    enlace.setAttribute( "onclick", "eliminarDatosEspecificos( this )" );
    enlace.setAttribute( "onmouseout", "" );
    enlace.setAttribute( "onmouseover", "" );
  //  enlace.setAttribute("class","btn btn-success fa-plus");
    enlace.src           = "../images/MenosNaranja.jpg";

    filaNueva           = document.createElement( "tr" );
    columna             = document.createElement( "td" );
    columna.setAttribute( "colspan", "30" );
    filaNueva.appendChild( columna );
    capa                = document.createElement( "div" );
    capa.id             = "capa" + codigo_adjudicacion + codigo_proveedor;    
    capa.style.padding  = "10 0 10 0";
    columna.appendChild( capa );
    capa.innerHTML      = "...";

    fila.parentNode.insertBefore( filaNueva, fila.nextSibling );
    
    asignarBorde( fila       , "dashed 1px #999999", "none" );
    asignarBorde( filaNueva  , "none", "dashed 1px #999999" );

    var parametros = {
                "codigo_adjudicacion" : codigo_adjudicacion,
                "codigo_proveedor" : codigo_proveedor
                
               
        };
     $.ajax({
         
         url: '../ajax/pagoProveedor.php?op=listarItem',
      //  url: 'https://siciap.mspbs.gov.py/indicadores_historicos/ajax/informe_ejecucion_oc.php?op=listarDetalle',
             
        type:'POST',
        data:parametros,
        dataType:'json',
        beforeSend: function(objeto){
                
        },
        success:function(json){
             $(capa).html(json.contenido);        
     
        },
        error:function(e){
           
        },
        complete:function(objeto,exito,error){
            if(exito==="success"){
                
        }
        }
        
    });
     
   
}

function eliminarDatosEspecificos( enlace ){
// ---------------------------------------------------------------
    var codigoMedicamento;
    var fila;
    var capa;    
// ---------------------------------------------------------------

    fila                = enlace.parentNode.parentNode;
    codigo_adjudicacion   = fila.getElementsByTagName( "input" )[0].value;
    codigo_proveedor   = fila.getElementsByTagName( "input" )[1].value;
    //alert(codigoMedicamento);
    enlace.setAttribute( "onclick", "mostrarDatosEspecificos( this )" );
 //   enlace.setAttribute( "onmouseout", "this.src='../Imagenes/MasBlanco.gif'" );
   // enlace.setAttribute( "onmouseover", "this.src='../Imagenes/MasNaranja.jpg'" );
  //  enlace.setAttribute("class","fa fa-plus fa-10x style='color:#FFFFFF; width:6; height:6;'");
    
    enlace.src           = "../images/MasNaranja.jpg";

    capa                 = document.getElementById( "capa" + codigo_adjudicacion + codigo_proveedor );
    
    fila.parentNode.removeChild( capa.parentNode.parentNode );
    asignarBorde( fila       , "none", "none" );
}

function asignarBorde( fila, estiloArriba, estiloAbajo ){
// ---------------------------------------------------------------
    var indice, cantidadElementos;
// ---------------------------------------------------------------
    cantidadElementos   = fila.cells.length;
    
    for( indice= 0; indice < cantidadElementos; indice++ ){
        fila.cells[ indice ].style.borderTop    = estiloArriba;
        fila.cells[ indice ].style.borderBottom = estiloAbajo;
    }}

function resaltarFila( fila ){
  
    fila.className = "resaltarFila";
}

function noResaltarFila( fila ){

       if( fila.rowIndex%2 == 0)
            fila.className = "";
        else
            fila.className = "listaDiferenciada";    
}
 
init();