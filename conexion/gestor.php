<?php

include_once 'continente.php';

$continentes = array();

$continente1 = new Continente();
$continente1->setId(1);
$continente1->setNombre("América");

array_push( $continentes, $continente1);

$continente2 = new Continente();
$continente2->setId(2);
$continente2->setNombre("Africa");

array_push( $continentes, $continente2);

foreach( $continentes as $item){
    echo $item->getId() . "-". $item->getNombre();
    echo "<br>";
}





?>