<?php

function connect_database()
{
    $username = 'c##photoplay';
    $password = 'almi123';
    $connection_string = '//3.221.255.12:1521/ORCLCDB';  

    $conn = oci_connect($username, $password, $connection_string);

    if (!$conn) {
        $error = oci_error();
        echo "Oracle connection error: " . $error['message'];
        exit;
    }else{
        echo "Oracle connection success";
    }

    return $conn;
}

function insertar_usuario($conn, $username, $contrasena, $admin)
{
    $sql = 'BEGIN insertar_usuario(:p_username, :p_contrasena, :p_admin); END;';

    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ':p_username', $username);
    oci_bind_by_name($stmt, ':p_contrasena', $contrasena);
    oci_bind_by_name($stmt, ':p_admin', $admin);

    oci_execute($stmt);
    oci_free_statement($stmt);

}

function obtener_partidas_por_usuario($conn, $id_usuario)
{
    $sql = 'BEGIN :p_partidas := obtener_partidas_por_usuario(:p_id_usuario); END;';
    $stmt = oci_parse($conn, $sql);

    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ':p_partidas', $cursor, -1, OCI_B_CURSOR);
    oci_bind_by_name($stmt, ':p_id_usuario', $id_usuario);

    oci_execute($stmt);
    oci_execute($cursor);

    $partidas = [];
    while (($row = oci_fetch_assoc($cursor)) != false) {
        $partidas[] = $row;
    }

    oci_free_statement($stmt);
    oci_free_statement($cursor);

    return $partidas;
}

function actualizar_puntuacion_partida($conn, $id_partida, $nueva_puntuacion)
{
    $sql = 'BEGIN actualizar_puntuacion_partida(:p_id_partida, :p_nueva_puntuacion); END;';
    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ':p_id_partida', $id_partida);
    oci_bind_by_name($stmt, ':p_nueva_puntuacion', $nueva_puntuacion);

    oci_execute($stmt);
    oci_free_statement($stmt);
}

function obtenerEstadisticasUsuarios($conn)
{
    $sql = 'BEGIN obtener_estadisticas_usuarios(:p_cursor); END;';
    $stmt = oci_parse($conn, $sql);

    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ':p_cursor', $cursor, -1, OCI_B_CURSOR);

    oci_execute($stmt);
    oci_execute($cursor);

    $result = [];
    while (($row = oci_fetch_assoc($cursor)) != false) {
        $result[] = $row;
    }

    oci_free_statement($stmt);
    oci_free_statement($cursor);

    return $result;
}


function get_user($conn, $username, $password)
{
    $sql = 'SELECT * FROM users WHERE username = :username AND password = :password';

    $stmt = oci_parse($conn, $sql);

    oci_bind_by_name($stmt, ':username', $username);
    oci_bind_by_name($stmt, ':password', $password);

    oci_execute($stmt);

    $row = oci_fetch_assoc($stmt);
    oci_free_statement($stmt);

    return $row;
}


?>
