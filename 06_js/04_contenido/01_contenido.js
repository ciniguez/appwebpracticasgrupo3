function cambiarContenidoElementoHTML(){
    var elementos =  document.getElementsByClassName("div");
    elementos[0].textContent = "Este era el DIV 1";
    elementos[1].textContent = "Este era el DIV 2";
}