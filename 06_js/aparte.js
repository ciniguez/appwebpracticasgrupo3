// Obtener Elemento con el id="miElemento"
var elemento = document.getElementById("miElemento");
console.log(elemento.textContent);

console.log(" TODOS LOS ELEMENTOS P");
// Obtener todos los elementos con etiqueta P
var elementos = document.getElementsByTagName("p");
for(var i=0; i< elementos.length; i++){
    console.log(elementos[i].textContent);
}

// Obtener todos los elementos con la clase  miclase
console.log(" TODOS LOS ELEMENTOS CON CLASE miclase");
var elementosConClase = document.getElementsByClassName("miclase");
for(var i = 0; i< elementosConClase.length; i++){
    console.log(elementosConClase[i].textContent)
}

// Uso de QuerySelector
console.log(" Uso de QuerySelector ");
var elementoP = document.querySelector("#principal p");
console.log(elementoP.textContent);

//Uso de QuerySelectorAll
console.log(" ******* Uso de QuerySelectorAll ********");
var listaP = document.querySelectorAll("#principal p");
for(var i= 0; i<listaP.length;i++){
    console.log(listaP[i].textContent);
}

