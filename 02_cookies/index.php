<?php
$nombre = $clave = $sexo = "";
$preferencias = $esHombre = $esMujer = false;

if ( isset( $_COOKIE["c_recordarme"]) && $_COOKIE["c_recordarme"]){
    $preferencias = true;
    $nombre = $_COOKIE["c_nombre"];
    $clave = $_COOKIE["c_clave"];
    $sexo = $_COOKIE["c_sexo"];
    $esHombre = ($sexo == "h")? true: false;
    $esMujer = ($sexo == "m")? true: false;
}
?>

<html>
    <head></head>
    <body>
        <h1>Formulario de Ingreso</h1>

        <form action="pagina2.php" method="POST">
            <fieldset>
                Usuario*:<br>
                <input type="text" name="nombre" value="<?php echo $nombre;?>" id="" required><br>
                Clave*:<br>
                <input type="password" name="clave" value="<?php echo $clave ?>" id="" required><br>
                Sexo*:<br>
                <input type="radio" name="hm" value="h" <?php echo ($esHombre)?"checked" :"" ?>>Hombre
                <input type="radio" name="hm" value="m" <?php echo ($esMujer)?"checked" : "" ?>>Mujer
                <br>
                <br>
                <input type="checkbox" name="chkRecordarme" <?php echo ($preferencias)?"checked":""  ?>>Recordar mis datos
                <br>
                <br>
                <input type="submit" value="Enviar">
            </fieldset>
        </form>
    </body>
</html>