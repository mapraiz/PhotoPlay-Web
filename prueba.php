<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <title>PhotoPlay - Usuarios</title>   
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
                <li class="nav-item px-5"><a class="text-white text-decoration-none" style="font-size: 200%" href="leaderboard.php">Leaderboard</a></li>
                <li class="nav-item px-5"><a class="text-white text-decoration-none" style="font-size: 200%" href="registro.php">Registro</a></li>
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
                            <h2 class="fw-bold mb-2 text-uppercase">Usuarios</h2>

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
                                echo "Conexión exitosa<br>"; // Mostrar mensaje de conexión exitosa
                            }

                            // Consulta SQL para obtener usuarios
                            $query = "SELECT * FROM usuario";
                            $stid = oci_parse($connection, $query);

                            // Ejecutar la consulta
                            $result = oci_execute($stid);

                            if (!$result) {
                                $e = oci_error($stid);
                                echo "Error en la ejecución de la consulta: " . $e['message'];
                                exit;
                            }

                            // Mostrar los resultados
                            echo "<table border='1'>";
                            echo "<tr><th>ID</th><th>Username</th><th>Contraseña</th><th>Admin</th></tr>";
                            while ($row = oci_fetch_array($stid, OCI_ASSOC)) {
                                echo "<tr><td>" . $row['ID_USUARIO'] . "</td><td>" . $row['USERNAME'] . "</td><td>" . $row['CONTRASENA'] . "</td><td>" . $row['ADMIN'] . "</td></tr>";
                            }
                            echo "</table>";

                            // Liberar recursos
                            oci_free_statement($stid);
                            oci_close($connection);
                            ?>
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

</body>
</html>
