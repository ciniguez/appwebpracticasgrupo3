<?php

class Continente{

    private $continenteId;
    private $continenteNombre;

    function __construct(){
    }

    public function getId(){
        return $this->continenteId;
    }
    public function setId( $idContinente){
        $this->continenteId = $idContinente;
    }
    public function getNombre(){
        return $this->continenteNombre;
    }
    public function setNombre( $nombre ){
        $this->continenteNombre = $nombre;
    }
    public function toString(){
        return $this->continenteId. " | ". $this->continenteNombre;
    }
}

?>