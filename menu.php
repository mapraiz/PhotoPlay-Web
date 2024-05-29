<div id="menu">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <ul>
            <li><a href="index.php">Inicio</a></li>
           
            <li><a href="leaderboard.html">Leaderboard</a></li>

            <li><a href="discografia.html">Discografía</a></li>
            
            <li><a href="registro.html">Register:</a> </li>
            <li><a href="login.html">Login</a></li>
            
            
        </ul>
        <ul class="right">
            <?php 
              session_start();
              $user = $_SESSION["user"];
            if (!isset($_SESSION['id_usuario'])) {
                echo '<li><a href="login.html">Login</a></li>';
            } else {
                echo '<li><a href="logout.php">Logout</a></li>';
                echo '<li><a href="gestion.php">Gestión</a></li>';
                echo '<li><a href="buscador.php">Buscador</a></li>';
                echo '<li><a href="buscar_noticias_fecha.php">Buscar por fecha</a></li>';
            }
            ?>
        </ul>
    </nav>
</div>