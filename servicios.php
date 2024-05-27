
<?php
    if(isset($_SERVER['HTTP_ORIGIN']))
    {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Max-Age: 86400");
    }

    if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
    {
        if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");
        if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        exit(0);
    }

    header('Content-Type: application/JSON');

    include_once('bbdd.php');

    $funcion = $_POST['function'];
    if($funcion == "getScoreUsuario")
    {
        $scores_usuarios = get_juegos();
        $scoresUJson = json_encode($scores_usuarios, JSON_UNESCAPED_UNICODE);
        echo $scoresUJson;
    } else if($funcion == "getJuegosCategoria")
    {
        $juegos = get_juegos_categoria($_POST['idCategoria']);
        $juegosJson = json_encode($juegos, JSON_UNESCAPED_UNICODE);
        echo $juegosJson;
    } else if($funcion == "getNombresJuegosCategoria")
    {
        $juegos = get_titulos_juegos_categoria($_POST['idCategoria']);
        $juegosJson = json_encode($juegos, JSON_UNESCAPED_UNICODE);
        echo $juegosJson;
    } else if($funcion == "getJuegoByID")
    {
        $juego = get_juegos_id($_POST['idJuego']);
        $juegoJson = json_encode($juego, JSON_UNESCAPED_UNICODE);
        echo $juegoJson;
    }
    
?>