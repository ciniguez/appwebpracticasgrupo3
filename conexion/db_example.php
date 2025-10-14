<?php
require_once __DIR__ . '/DBConnection.php';

try {
    $db = new DBConnection();

    // Lista todos los continentes (similar a cnn.php)
    $rows = $db->fetchAll('SELECT CONT_ID, CONT_NOMBRE FROM CONTINENTE');
    if (empty($rows)) {
        echo "No existen resultados\n";
    } else {
        foreach ($rows as $continente) {
            echo $continente['CONT_ID'] . " - " . $continente['CONT_NOMBRE'] . "<br>\n";
        }
    }

    // Ejemplos rápidos (descomentar para usar):
    // Insertar
    // $newId = $db->insert('CONTINENTE', ['CONT_NOMBRE' => 'Atlantis']);
    // echo "Inserted id: $newId\n";

    // Actualizar
    // $affected = $db->update('CONTINENTE', ['CONT_NOMBRE' => 'NuevoNombre'], 'CONT_ID = ?', [5]);
    // echo "Updated rows: $affected\n";

    // Borrar
    // $deleted = $db->delete('CONTINENTE', 'CONT_ID = ?', [5]);
    // echo "Deleted rows: $deleted\n";

    $db->close();

} catch (Exception $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}

?>
