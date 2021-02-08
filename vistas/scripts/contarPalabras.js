function contarPalabras(textoObj,cantidadMaxima,name){
    
   //alert(textoObj);
    texto = textoObj.value;
    
    textoSinUltPalabra = texto.split(' ') // separa el string según espacios en blanco
         .slice(0, -1) // toma todos los elementos menos el último
         .join(' ');
    
    
    
     //alert('texto = '+ texto);
	//Obtenemos el texto del campo
	//var texto = document.getElementById("contar_palabras").value;
	//Reemplazamos los saltos de linea por espacios
	texto = texto.replace (/\r?\n/g," ");
	//Reemplazamos los espacios seguidos por uno solo
	texto = texto.replace (/[ ]+/g," ");
	//Quitarmos los espacios del principio y del final
	texto = texto.replace (/^ /,"");
	texto = texto.replace (/ $/,"");
	//Troceamos el texto por los espacios
	var textoTroceado = texto.split (" ");
	//Contamos todos los trozos de cadenas que existen
	var numeroPalabras = textoTroceado.length;
	//Mostramos el número de palabras
        if (numeroPalabras > cantidadMaxima){  
            alert("No puede superar "+cantidadMaxima+" palabras");
            document.getElementById(name).value= textoSinUltPalabra;
        }
}