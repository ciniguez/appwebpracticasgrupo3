
var imagen = document.getElementById("imagen");

function tieneAtributo(){
    console.log( imagen.hasAttribute('src') );
}

function obtener(){
    console.log(imagen.getAttribute('src'));
}

function remover(){
    imagen.removeAttribute('src');
}

function configurar(){
    imagen.setAttribute('src','https://picsum.photos/id/64/200/200' );
}