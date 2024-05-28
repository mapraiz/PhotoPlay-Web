<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <title>PhotoPlay</title>   
    <link rel="stylesheet" href="css/comun.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #685bd9;">
        <a class="navbar-brand" href="index.html">
            <img src="imagenes/preguntados2edit.png" id="logo-preguntados" width="150" height="150" class="d-inline-block align-center">
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item px-5"><a class="text-white text-decoration-none" style="font-size: 200%" href="leaderboard.html">Leaderboard</a></li>
                <li class="nav-item px-5"><a class="text-white text-decoration-none" style="font-size: 200%" href="registro.html">Registro</a></li>
                <li class="nav-item px-5"><a class="text-white text-decoration-none" style="font-size: 200%" href="login.php">Login</a></li>
            </ul>
        </div>
    </nav>
</header>

<section class="vh-100 bg-dark">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-custom-1 text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <div class="mb-md-5 mt-md-4 pb-5">
                            <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                            <p class="text-white-50 mb-5">Please enter your login and password!</p>

                            <?php
                            session_start();

                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $username = $_POST['username'];
                                $password = $_POST['password'];

                                // Configuración de la conexión a la base de datos Oracle
                                $db_username = 'c##photoplay';
                                $db_password = 'almi123';
                                $db_service = '3.221.255.12:1521/ORCLCDB';

                                // Realizar la conexión a la base de datos Oracle
                                $connection = oci_connect($db_username, $db_password, $db_service);

                                if (!$connection) {
                                    $error = oci_error();
                                    echo "Error de conexión: " . $error['message'];
                                    exit;
                                }

                                // Consulta SQL para verificar las credenciales de inicio de sesión
                                $query = "SELECT * FROM usuario WHERE username = :username AND contrasena = :password";
                                $stid = oci_parse($connection, $query);

                                oci_bind_by_name($stid, ':username', $username);
                                oci_bind_by_name($stid, ':password', $password);

                                oci_execute($stid);

                                if ($row = oci_fetch_array($stid, OCI_ASSOC)) {
                                    $_SESSION['username'] = $username;
                                    // Redirigir al usuario a perfil.php
                                    header("Location: perfil.html");
                                    exit();
                                } else {
                                    $loginMessage = "Nombre de usuario o contraseña inválidos";
                                }

                                // Liberar recursos
                                oci_free_statement($stid);
                                oci_close($connection);
                            }
                            ?>

                            <?php if (isset($loginMessage)): ?>
                                <div class="alert alert-danger">
                                    <?php echo $loginMessage; ?>
                                </div>
                            <?php endif; ?>

                            <form action="login.php" method="post">
                                <div class="form-outline form-white mb-4">
                                    <input type="text" id="typeUsernameX" name="username" class="form-control form-control-lg" required />
                                    <label class="form-label" for="typeUsernameX">Username</label>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="password" id="typePasswordX" name="password" class="form-control form-control-lg" required />
                                    <label class="form-label" for="typePasswordX">Password</label>
                                </div>

                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                            </form>

                            <div class="d-flex justify-content-center text-center mt-4 pt-1">
                                <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                                <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                                <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                            </div>
                        </div>

                        <div>
                            <p class="mb-0">Don't have an account? <a href="registro.html" class="text-white">Sign Up</a></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="row text-center">
        <div class="col-md-8"><p>&copy; PhotoPlay. All rights reserved.</p></div>
        <ul class="list-inline footer-links">
            <li class="list-inline-item"><a href="#"><img width="40" height="40" src="/imagenes/facebook.png"></a></li>
            <li class="list-inline-item"><a href="#"><img width="40" height="40" src="/imagenes/signo-de-twitter.png"></a></li>
            <li class="list-inline-item"><a href="#"><img width="40" height="40" src="/imagenes/instagram.png"></a></li>
        </ul>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="js/jquery-3.7.1.min.js"></script>
<script src="js/login.php"></script>

</body>
</html>
