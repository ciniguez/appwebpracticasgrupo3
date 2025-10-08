
<?php
# impresion en pantalla
echo "Hola Mundo";
echo "<br>";
## Variables
$pais = "Ecuador";
$numero = "2025";
$bandera = true;

echo "$pais es rico y diverso. El $pais del $numero. Bandera 1 (verdadero): $bandera";

#Arrays
echo "<br>";
$estadoCivil = array("soltero", "rejuntado", "casado", "divorciado" );

print_r( $estadoCivil );
echo "<br>";
var_dump( $estadoCivil);

#die();

echo "<h1>ARRAY CON INDICES</h1>";
$arrayConIndices = array("clave1"=>"soltero", "clave2"=>"rejuntado");
echo "<br>";
var_dump($arrayConIndices);

echo "<h1>Cabeceras</h1>";
print_r( getallheaders());
?>
