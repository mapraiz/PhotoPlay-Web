<?php
session_start();

var_dump("ostias");

// Include the database connection and Oracle functions file
require_once 'bbdd.php';
var_dump("ostias2");
// Handle the login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = connect_database();
    require_once 'bbdd.php';
    var_dump("datavase");
    $user = get($conn, $username, $password);
    oci_close($conn);

    if ($user) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['admin'] = $user['admin'];
        echo json_encode(array('status' => 'success', 'message' => 'Login successful.'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Invalid username or password.'));
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
            <h2>Login</h2>
            <form id="loginForm">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username"><br>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password"><br><br>
                <button type="submit">Login</button>
            </form>
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
            $('#loginForm').submit(function(event) {
                event.preventDefault(); 

                var username = $('#username').val();
                var password = $('#password').val();

                login(username, password);
            });
        });
    </script>
</body>
</html>