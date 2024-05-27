<?php
session_start();

// Incluir archivo de conexión y funciones de Oracle
require_once 'bbdd.php';

// Manejar la inserción de usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'insert_user') {
    $username = $_POST['username'];
    $contrasena = $_POST['contrasena'];
    $admin = $_POST['admin'];

    $conn = connect_database();
    insertar_usuario($conn, $username, $contrasena, $admin);
    oci_close($conn);

    echo json_encode(array('status' => 'success', 'message' => 'Usuario insertado correctamente.'));
    exit;
}

// Manejar la obtención de estadísticas de usuarios
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_user_stats') {
    $conn = connect_database();
    $estadisticas = obtenerEstadisticasUsuarios($conn);
    oci_close($conn);

    echo json_encode(array('status' => 'success', 'stats' => $estadisticas));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="ajax_scripts.js"></script>
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/logo.png" alt="PhotoPlay">
        </div>
        <?php include "menu.php"; ?>
    </header>
    <main>
        <div class="container">
            <h2>Insertar Usuario</h2>
            <form id="insertarUsuarioForm">
                <label for="username">Nombre de Usuario:</label><br>
                <input type="text" id="username" name="username"><br>
                <label for="contrasena">Contraseña:</label><br>
                <input type="password" id="contrasena" name="contrasena"><br>
                <label for="admin">Admin:</label><br>
                <input type="text" id="admin" name="admin"><br><br>
                <button type="submit">Insertar Usuario</button>
            </form>

            <h2>Obtener Estadísticas de Usuarios</h2>
            <button type="button" id="obtenerEstadisticasBtn">Obtener Estadísticas</button>
        </div>
    </main>

    <footer class="footer">
        <ul>
            <li><a href="#">Facebook</a></li>
            <li><a href="#">Twitter</a></li>
            <li><a href="#">Instagram</a></li>
        </ul>
        <p>&copy; <?php echo date("Y"); ?> PhotoPlay. All rights reserved.</p>
    </footer>

    <script>
        $.getScript('ajax_scripts.js', function() {
            $('#insertarUsuarioForm').submit(function(event) {
                event.preventDefault(); 

                var username = $('#username').val();
                var contrasena = $('#contrasena').val();
                var admin = $('#admin').val();

                insertarUsuario(username, contrasena, admin);
            });

            $('#obtenerEstadisticasBtn').click(function() {
                obtenerEstadisticasUsuarios();
            });
        });
    </script>
</body>
</html>
