<?php

$host = 'localhost';
$usuario = "root";
$clave = "";
$db = "mundo";

$conexion = new mysqli($host, $usuario, $clave, $db) or die($conexion->connect_errno);

$sql = "SELECT CONT_ID, CONT_NOMBRE FROM CONTINENTE";

if (!$resultado =  $conexion->query( $sql )){
    echo "La consulta falló";
}else{
    if ($resultado->num_rows === 0){
        echo "No existen resultados";
    }else{
        while( $continente = $resultado->fetch_assoc()){
            echo $continente['CONT_ID'] . " - " . $continente['CONT_NOMBRE'] . "<br>";
        }
    }
}
$conexion->close();




?>