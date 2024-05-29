<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jaro:opsz@6..72&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/comun.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body class="text-center">
    
<?php session_start(); ?>

<header >
   
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #000000;">
        
        <a class="navbar-brand" href="index.html" ><img src="imagenes/preguntados2edit.png" id="logo-preguntados" width="150" height="150" class="d-inline-block align-center"></a>
        <div clas="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item px-5"><a class="text-white text-decoration-none " style="font-size: 200%"  href="leaderboard.html">Leaderboard</a></li>
                <li class="nav-item px-5"><a class="text-white text-decoration-none" style="font-size: 200%"   href="registro.php">Register</a> </li>
                <li class="nav-item px-5"><a class="text-white text-decoration-none" style="font-size: 200%"   href="login.php">Login</a></li>
            </ul>
            <ul class="right">
                
            </ul>
        </div>
    </nav>
</header>
<main role="main" class="innercover">
    <div class="container-fluid bg-dark">
        <div class="row">
            <div class="col-md text-white">
              One of three columns
            </div>
            <div class="col-lg text-white text-wrap">
              <h2 class="text-left text-decoration-underline">Preguntados</h2>
              <p class="lh-lg">Preguntados es un juego en el que tus conocimientos de DAM se pondran a prueba. Compite con otros jugadores para conseguir la puntuación mas alta. 
                Puedes contestar a todas las preguntas correctamente?
              </p>
            </div>
           
          </div>
    </div>

</main>


    <footer class="footer">
    <div class="row text-center">
        <div class="col-md-8">
        <p>&copy; <?php echo date("Y"); ?> PhotoPlay. All rights reserved.</p>

        </div>
        <div class="footer-links">
            <a href="#"><img src="/imagenes/facebook.png" alt="Facebook"></a>
            <a href="#"><img src="/imagenes/signo-de-twitter.png" alt="Twitter"></a>
            <a href="#"><img src="/imagenes/instagram.png" alt="Instagram"></a>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="js/jquery-3.7.1.min.js"></script>
</body>
</html>