<?php
require_once 'bbdd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = connect_database();

    $user = get_user($conn, $username, $password);

    if ($user) {
        // Iniciar sesión y redirigir al usuario a la página de inicio
        session_start();
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
    } else {
        // Mostrar un mensaje de error
        echo "Nombre de usuario o contraseña incorrectos";
    }

    oci_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form method="post" action="login.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <input type="submit" value="Login">
    </form>
</body>
</html>