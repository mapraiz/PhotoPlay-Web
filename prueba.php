<?php
// Configuración de la conexión a la base de datos Oracle
$db_username = 'c##photoplay';
$db_password = 'almi123';
$db_service = '3.221.255.12:1521/ORCLCDB';

// Realizar la conexión a la base de datos Oracle
$connection = oci_connect($db_username, $db_password, $db_service);

// Verificar si la conexión se realizó correctamente
if (!$connection) {
    $error = oci_error();
    echo "Error de conexión: " . $error['message'];
    exit; // Terminar el script si hay un error de conexión
} else {
    echo "Conexión exitosa"; // Mostrar mensaje de conexión exitosa
    oci_close($connection); // Cerrar la conexión después de usarla
}
?>
