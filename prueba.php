<?php
$db_username = 'c##photoplay';
$db_password = 'almi123';
$db_service = '3.221.255.12:1521/ORCLCDB';

$connection = oci_connect($db_username, $db_password, $db_service);

if (!$connection) {
    $error = oci_error();
    echo "Error de conexion: " . htmlspecialchars($error['message']);
} else {
    echo "Conexion exitosa!";
    oci_close($connection);
    //prueba
}
?>
