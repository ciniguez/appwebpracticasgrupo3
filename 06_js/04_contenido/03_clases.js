var elemento = document.getElementById("gabriel");

function mostrar(){
     elemento.classList.replace('ocultar', 'mostrar');
}

function ocultar(){
    elemento.classList.replace('mostrar', 'ocultar');
}

function agregarClase(){
    elemento.classList.add('cajaroja');
}
function removerClase(){
    if( elemento.classList.contains('cajaroja') ){
        elemento.classList.remove('cajaroja');
    }

}