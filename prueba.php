<?php
if (extension_loaded('oci8')) {
    echo "OCI8 está habilitado.";
} else {
    echo "OCI8 no está habilitado.";
}

$db_username = 'c##photoplay';
$db_password = 'almi123';
$db_service = '3.221.255.12:1521/ORCLCDB';

$connection = oci_connect($db_username, $db_password, $db_service);

if (!$connection) {
    $error = oci_error();
    echo "Error de conexión: " . htmlspecialchars($error['message']);
} else {
    echo "Conexión exitosa!";
    oci_close($connection);
    //prueba
}
?>
