<?php

echo '<pre>'.print_r($_POST, true). '</pre>';

// Poner en variables
$nombre = $_POST['nombre'];
$clave = $_POST['clave'];
$sexo = $_POST['hm'];
$recordarme =  isset( $_POST['chkRecordarme'] );

if ($recordarme){
    //Seteo las cookies
    //setcookie("c_nombre", $nombre, time()+60*60*24); //expira en un día.
    setcookie("c_nombre", $nombre, 0);
    setcookie("c_clave", $clave, 0);
    setcookie("c_sexo", $sexo, 0);
    setcookie("c_recordarme", $recordarme, 0);
}else{
    //Borro cualquier Cookie que exista
    if (isset($_COOKIE)){
        foreach($_COOKIE as $name => $value){
            setcookie($name, '', 1); // va a morir el 1 de enero de 1970 00:00:1
        }
    }
}


?>


<html>
    <head>
    </head>
    <body>
        <h1>Panel Principal</h1>
        <h1>Bienvenido usuario: <?php echo $nombre ?></h1>
        <hr>
        <a href="borrarcookies.php?borrar=1">Borrar cookies y regresar</a>
        <br>
        <a href="borrarcookies.php?borrar=0">Regresar</a>
    </body>
</html>