<?php
$conn = oci_connect('c##photoplay', 'almi123', '3.221.255.12:1521/ORCLCDB');

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

echo "Conexión a Oracle establecida correctamente";
oci_close($conn);
?>
