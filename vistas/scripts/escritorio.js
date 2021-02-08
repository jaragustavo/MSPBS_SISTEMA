var tabla;
 
//Función que se ejecuta al inicio
function init(){
     // obtenerDatos(); 
      graficar();
    
}
 

/*
function graficar()
{
     medicamento = new Array(); 
     medicamento = (document.getElementsByName("medicamento")[0].value).split("{}"); 
     porcentaje_ejecucion = (document.getElementsByName("porcentaje_ejecucion")[0].value).split("{}"); ; 
    // alert ('op  '+document.getElementsByName("porcentaje_ejecucion")[0].value);
   
    
   var ctx = document.getElementById('grafico1').getContext('2d');

   var chart = new Chart(ctx, {
       
    type: 'doughnut',
       data:{
            labels: [medicamento[0],medicamento[1],medicamento[2],medicamento[3],medicamento[4],medicamento[5],medicamento[6],medicamento[7],medicamento[8],medicamento[9]],
            datasets: [{
               
                    data: [porcentaje_ejecucion[0],porcentaje_ejecucion[1],porcentaje_ejecucion[2],porcentaje_ejecucion[3],porcentaje_ejecucion[4],porcentaje_ejecucion[5],porcentaje_ejecucion[6],porcentaje_ejecucion[7],porcentaje_ejecucion[8],porcentaje_ejecucion[9]],
                    backgroundColor: [getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor()]
                }]
        },
        options: {
            responsive: true, 
            title: {
                display: true,
                text: 'Porcentaje de Ejecucion de los 10 medicamentos más distribuidos',
                fontSize:20,
            //    lineHeight:3
             },
          
            legend: {
               display: true,
               position: 'left',
                labels: {
                    fontColor: '#666',
                    display: 'inline-block',
                    width: '100%',
                    usePointStyle: true,
                   
                }
            }
         }
       
        });

        }
*/        

function graficar()
{
     medicamento = new Array(); 
     medicamento = (document.getElementsByName("medicamento")[0].value).split("{}"); 
     porcentaje_ejecucion = (document.getElementsByName("porcentaje_ejecucion")[0].value).split("{}");
     cantidad_distribuida = (document.getElementsByName("cantidad_distribuida")[0].value).split("{}");  
    // alert ('op  '+document.getElementsByName("porcentaje_ejecucion")[0].value);
   


        var densityCanvas = document.getElementById("grafico1");

        Chart.defaults.global.defaultFontFamily = "Lato";
        Chart.defaults.global.defaultFontSize = 16;

        var densityData = {
          label: 'Cantidad Distribuida',
          data: [cantidad_distribuida[0],cantidad_distribuida[1],cantidad_distribuida[2],cantidad_distribuida[3],cantidad_distribuida[4],cantidad_distribuida[5],cantidad_distribuida[6],cantidad_distribuida[7],cantidad_distribuida[8],cantidad_distribuida[9]],
          backgroundColor: [getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor()],
          borderWidth: 0,
          yAxisID: "y-axis-density"
        };

      /*  var gravityData = {
          label: 'Porcentaje Ejecución',
          data: [porcentaje_ejecucion[0],porcentaje_ejecucion[1],porcentaje_ejecucion[2],porcentaje_ejecucion[3],porcentaje_ejecucion[4],porcentaje_ejecucion[5],porcentaje_ejecucion[6],porcentaje_ejecucion[7],porcentaje_ejecucion[8],porcentaje_ejecucion[9]],
          backgroundColor: [getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor()],
          borderWidth: 0,
          yAxisID: "y-axis-gravity"
        };
*/
        var planetData = {
          labels: [medicamento[0],medicamento[1],medicamento[2],medicamento[3],medicamento[4],medicamento[5],medicamento[6],medicamento[7],medicamento[8],medicamento[9]],
          datasets: [densityData]
        };

        var chartOptions = {
          scales: {
            xAxes: [{
              barPercentage: 1,
              categoryPercentage: 0.6
            }],
            yAxes: [ {
              
              id: "y-axis-density"
            }]
          }
        };

        var barChart = new Chart(densityCanvas, {
          type: 'bar',
          data: planetData,
          options: chartOptions
        });


} 
/*
function graficar()
{
     medicamento = new Array(); 
     medicamento = (document.getElementsByName("medicamento")[0].value).split("{}"); 
     porcentaje_ejecucion = (document.getElementsByName("porcentaje_ejecucion")[0].value).split("{}");
     cantidad_distribuida = (document.getElementsByName("cantidad_distribuida")[0].value).split("{}");  
    // alert ('op  '+document.getElementsByName("porcentaje_ejecucion")[0].value);
   


        var densityCanvas = document.getElementById("grafico1");

        Chart.defaults.global.defaultFontFamily = "Lato";
        Chart.defaults.global.defaultFontSize = 18;

        var densityData = {
          label: 'Cantidad Distribuida',
          data: [cantidad_distribuida[0],cantidad_distribuida[1],cantidad_distribuida[2],cantidad_distribuida[3],cantidad_distribuida[4],cantidad_distribuida[5],cantidad_distribuida[6],cantidad_distribuida[7],cantidad_distribuida[8],cantidad_distribuida[9]],
          backgroundColor: [getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor()],
          borderWidth: 0,
          yAxisID: "y-axis-density"
        };

        var gravityData = {
          label: 'Porcentaje Ejecución',
          data: [porcentaje_ejecucion[0],porcentaje_ejecucion[1],porcentaje_ejecucion[2],porcentaje_ejecucion[3],porcentaje_ejecucion[4],porcentaje_ejecucion[5],porcentaje_ejecucion[6],porcentaje_ejecucion[7],porcentaje_ejecucion[8],porcentaje_ejecucion[9]],
          backgroundColor: [getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor()],
          borderWidth: 0,
          yAxisID: "y-axis-gravity"
        };

        var planetData = {
          labels: [medicamento[0],medicamento[1],medicamento[2],medicamento[3],medicamento[4],medicamento[5],medicamento[6],medicamento[7],medicamento[8],medicamento[9]],
          datasets: [densityData, gravityData]
        };

        var chartOptions = {
          scales: {
            xAxes: [{
              barPercentage: 1,
              categoryPercentage: 0.6
            }],
            yAxes: [{
              id: "y-axis-gravity"
            }, {
              
              id: "y-axis-density"
            }]
          }
        };

        var barChart = new Chart(densityCanvas, {
          type: 'bar',
          data: planetData,
          options: chartOptions
        });


} 
*/        
  function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
   }
  
function obtenerDatos()
{

    
     $.post("../ajax/escritorio.php?op=obtenerDatos",{idcodigo : 1}, function(r)
        {
          $("#detalles").html(r);
            
     });
    
   
   
}


 
init();