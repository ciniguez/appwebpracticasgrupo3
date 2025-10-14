<?php

//var_dump($_GET);

if( $_GET["borrar"]== 1 && isset($_COOKIE)){
    //borro las cookies y navego hacia el index.php
    foreach($_COOKIE as $name => $value){
        setcookie($name, '', 1); // va a morir el 1 de enero de 1970 00:00:1
    } 
}

header("Location:index.php");

?>