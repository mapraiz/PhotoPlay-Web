<?php
// Establecer la conexión
$db_username = 'c##photoplay';
$db_password = 'almi123';
$db_service = '3.221.255.12:1521/ORCLCDB';
$connection = oci_connect($db_username, $db_password, $db_service);

// Verificar la conexión
if (!$connection) {
    $error = oci_error();
    echo "Error de conexión: " . $error['message'];
    exit;
}

// Ejecutar una consulta SELECT
$query = "SELECT * FROM usuario";
$stid = oci_parse($connection, $query);
oci_execute($stid);

// Recuperar y mostrar los datos
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Username</th><th>Contraseña</th><th>Admin</th></tr>";
while ($row = oci_fetch_assoc($stid)) {
    echo "<tr>";
    echo "<td>" . $row['ID_USUARIO'] . "</td>";
    echo "<td>" . $row['USERNAME'] . "</td>";
    echo "<td>" . $row['CONTRASENA'] . "</td>";
    echo "<td>" . $row['ADMIN'] . "</td>";
    echo "</tr>";
}
echo "</table>";

// Liberar recursos y cerrar la conexión
oci_free_statement($stid);
oci_close($connection);
?>
