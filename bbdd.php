

<?php
    function connect_database()
    {
        $username = 'photoplay';
        $password = 'almi123';
        $connection_string = '100.28.90.231:1521/ORCLCDB';

        $conn = oci_connect($username, $password, $connection_string);

        if (!$conn) {
            $error = oci_error();
            echo "Oracle connection error: " . $error['message'];
            exit;
        }

        echo "Connected to Oracle!";
    }

    
   
    function change_username($username, $newUsername){
        $oci = connect_database();
        
        $sql = "UPDATE usuario SET username=? WHERE username=?";
        $sentencia = oci_parse($oci, $sql);
        if(!oci_execute($sentencia))
        {
            echo "Fallo en la preparación de la sentencia: ".$oci->errno;
            return false;
        }

        $asignar = $sentencia->bind_param("ss", $username, $newUsername);
        if(!$asignar)
        {
            echo "Fallo en la asignacion de parametros ".$oci->errno;
            return false;
        }
        
        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$oci->errno;
            return false;
        }else{
            return true;
        }

        
        
    }

    function change_score($score, $newScore, $fecha, $newFecha){
        $oci = connect_database();
        
        $sql = "UPDATE partida SET puntuacion= :newPuntuacion , fecha= :newFecha WHERE puntuacion= :puntuacion, fecha= :fecha";
        $sentencia = oci_parse($oci, $sql);
        if(!oci_execute($sentencia))
        {
            echo "Fallo en la preparación de la sentencia: ".$oci->errno;
            return false;
        }
        $ba = array(':newPuntuacion' => $newScore, ':newFecha' => $newFecha, ':puntuacion' => $score, ':fecha' => $fecha);

        foreach ($ba as $key => $val) {

            // oci_bind_by_name($stid, $key, $val) does not work
            // because it binds each placeholder to the same location: $val
            // instead use the actual location of the data: $ba[$key]
            $asignar=oci_bind_by_name($sentencia, $key, $ba[$key]);
            if(!$asignar)
            {
                echo "Fallo en la asignacion de parametros ".$oci->errno;
            }
        }
       

       
        
        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$oci->errno;
            return false;
        }else{
            return true;
        }

        
        
    }


    function get_users()
    {
        
        $oci = connect_database();
        
        $sql = "SELECT * FROM usuario";
        $sentencia = oci_parse($oci, $sql);
        if(!oci_execute($sentencia))
        {
            echo "Fallo en la preparación de la sentencia: ".$oci->errno;
        }
       
        
        
        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$oci->errno;
        }
        
        $users = array();

        $id_usuario = -1;
        $username = "";
        $contraseña = "";
        $admin = -1;
       
        $vincular = $sentencia->bind_result($id_usuario, $username, $contraseña, $admin);
        
        if(!$vincular)
        {
            echo "Fallo al vincular la sentencia: ".$oci->errno;
        }
        while($sentencia->fetch())
        {
            $user = array('id_usuario' => $id_usuario, 'username' => $username, 'contraseña' => $contraseña,
                            'admin' => $admin);
            $users[] = $user;
        }
        $oci->close();
        return $users;
    }
    function get_scores_user($id_usuario)
    {
        
        $oci = connect_database();
        
        $sql = "SELECT * FROM partida WHERE id_usuario= :id_usuario";
        $sentencia = oci_parse($oci, $sql);
        if(!oci_execute($sentencia))
        {
            echo "Fallo en la preparación de la sentencia: ".$oci->errno;
        }
        
        $asignar = oci_bind_by_name($sentencia, ':id_usuario', $id_usuario);
        if(!$asignar)
        {
            echo "Fallo en la asignacion de parametros ".$oci->errno;
        }
        
        
        $ejecucion = oci_execute($sentencia);
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$oci->errno;
        }
        
        $scores = array();

        $id_partida = -1;
        $fecha = "";
        $puntuacion = "";
        $id_usuario = -1;
       
        $vincular = $sentencia->bind_result($id_partida, $fecha, $puntuacion, $id_usuario);
        
        if(!$vincular)
        {
            echo "Fallo al vincular la sentencia: ".$oci->errno;
        }
        while($sentencia->fetch())
        {
            $score = array('id_partida' => $id_partida, 'fecha' => $fecha, 'puntuacion' => $puntuacion,
                            'id_usuario' => $id_usuario);
            $scores[] = $score;
        }
        $oci->close();
        return $scores;
    }

    function get_scores()
    {
        
        $oci = connect_database();
        
        $sql = "SELECT usuario.username, partida.puntuacion FROM partida INNER JOIN usuario ON partida.id_usuario = usuario.id_usuario";
        $sentencia = oci_parse($oci, $sql);
        if(!oci_execute($sentencia))
        {
            echo "Fallo en la preparación de la sentencia: ".$oci->errno;
        }
       
        
        
        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$oci->errno;
        }
        
        $scores = array();

        $username= "";
        
        $puntuacion = "";
        
       
        $vincular = $sentencia->bind_result($username, $puntuacion);
        
        if(!$vincular)
        {
            echo "Fallo al vincular la sentencia: ".$oci->errno;
        }
        while($sentencia->fetch())
        {
            $score = array('username' => $username, 'puntuacion' => $puntuacion);
            $scores[] = $score;
        }
        $oci->close();
        return $scores;
    }
    

    function get_juegos_id($idJuego)
    {
        
        $mysqli = connect_database();
        
        $sql = "SELECT * FROM Juego WHERE id_juego = ?";
        $sentencia = $mysqli->prepare($sql);
        if(!$sentencia)
        {
            echo "Fallo en la preparación de la sentencia: ".$mysqli->errno;
        }

        $asignar = $sentencia->bind_param("i",$idJuego);
        if(!$asignar)
        {
            echo "Fallo en la asignacion de parametros ".$mysqli->errno;
        }
        
        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$mysqli->errno;
        }
        
        $juego = array();

        $id_juego = -1;
        $titulo = "";
        $descripcion = "";
        $imagen = "";
        $precio = -1;
        $enlace = "";
        $id_categoria = -1;
        $id_user = -1;
        $vincular = $sentencia->bind_result($id_juego, $titulo, $descripcion, $imagen, $precio,
                                    $enlace, $id_categoria, $id_user);
        
        if(!$vincular)
        {
            echo "Fallo al vincular la sentencia: ".$mysqli->errno;
        }
        if($sentencia->fetch())
        {
            $juego = array('idJuego' => $id_juego, 'titulo' => $titulo, 'descripcion' => $descripcion,
                            'imagen' => $imagen, 'precio' => $precio, 'enlace' => $enlace,
                        'idCategoria' => $id_categoria);
        }
        $mysqli->close();
        return $juego;
    }
    
    function login($user, $password)
    {
        $mysqli = connect_database();

        $sql = "SELECT id_usuario FROM usuarios WHERE usuario = ? 
            AND contraseña = ?";
            
        $sentencia = $mysqli->prepare($sql);
        if(!$sentencia)
        {
            echo "Fallo en la preparación de la sentencia".$mysqli->errno;
        }

        $asignar = $sentencia->bind_param("ss", $user, $password);
        if(!$asignar)
        {
            echo "Fallo en la asignación ".$mysqli->errno;
        }

        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecución ".$mysqli->errno;
        }

        $usuario = -1;
        $vincular = $sentencia->bind_result($usuario);
        if(!$vincular)
        {
            echo "Fallo al asociar parámetros ".$mysqli->errno;
        }

        $result = false;
        if($sentencia->fetch())
        {
            $result = $usuario;
        }

        $mysqli->close();
        return $result;
    }

    function get_noticias()
    {
        $mysqli = connect_database();
        
        
        $sql = "SELECT * FROM noticia ORDER BY id_noticia DESC";
        $sentencia = $mysqli->prepare($sql);
        if(!$sentencia)
        {
            echo "Fallo en la preparación de la sentencia: ".$mysqli->errno;
        }
        
        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$mysqli->errno;
        }
        
        $noticias = array();

        $id_noticia = -1;
        $titulo = "";
        $fecha = "";
        $texto = "";
        $imagen = "";
        $resumen = "";
        $id_autor = -1;
        $vincular = $sentencia->bind_result($id_noticia, $titulo, $fecha, $texto, $imagen,
                                    $resumen, $id_autor);
        
        if(!$vincular)
        {
            echo "Fallo al vincular la sentencia: ".$mysqli->errno;
        }
        while($sentencia->fetch())
        {
            $noticia = array('id_noticia' => $id_noticia, 'titulo' => $titulo, 'fecha' => $fecha,
                            'texto' => $texto, 'imagen' => $imagen, 'resumen' => $resumen,
                        'id_autor' => $id_autor);
            $noticias[] = $noticia;
        }
        
        
        $mysqli->close();
        return $noticias;
    }

    function get_noticia($id_noticia)
    {
         $mysqli = connect_database();
        
        
        $sql = "SELECT * FROM noticia WHERE id_noticia = ?";
        $sentencia = $mysqli->prepare($sql);
        if(!$sentencia)
        {
            echo "Fallo en la preparación de la sentencia: ".$mysqli->errno;
        }

        $asignar = $sentencia->bind_param("i", $id_noticia);
        if(!$asignar)
        {
            echo "Fallo en la asignación ".$mysqli->errno;
        }
        
        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$mysqli->errno;
        }
        
        

        $id_noticia = -1;
        $titulo = "";
        $fecha = "";
        $texto = "";
        $imagen = "";
        $resumen = "";
        $id_autor = -1;
        $vincular = $sentencia->bind_result($id_noticia, $titulo, $fecha, $texto, $imagen,
                                    $resumen, $id_autor);
        
        if(!$vincular)
        {
            echo "Fallo al vincular la sentencia: ".$mysqli->errno;
        }
        while($sentencia->fetch())
        {
            $noticia = array('id_noticia' => $id_noticia, 'titulo' => $titulo, 'fecha' => $fecha,
                            'texto' => $texto, 'imagen' => $imagen, 'resumen' => $resumen,
                        'id_autor' => $id_autor);
            
        }
        
        
        $mysqli->close();
        return $noticia;
    }


    function insert_noticia($titulo, $fecha, $texto, $imagen, $resumen, $idAutor)
    {
        
        $mysqli = connect_database();

        
        
        $sql = "INSERT INTO noticia(titulo, fecha, texto, imagen, resumen, id_autor) 
                        VALUES (?, ?, ?, ?, ?, ?)";
        $sentencia = $mysqli->prepare($sql);
        if(!$sentencia)
        {
            echo "Fallo en la preparación de la sentencia: ".$mysqli->errno;
            
        }

        $asignar = $sentencia->bind_param("sssssi", $titulo, $fecha, $texto, $imagen, $resumen, $idAutor);
        if(!$asignar)
        {         
    
   
            echo "Fallo en la asignacion de parametros ".$mysqli->errno;
            
        }
        
        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$mysqli->errno;
            
        }
        
        $mysqli->close();
        return true;
    }


    function insert_miembro($nombre, $instrumento, $fecha_nacimiento, $ciudad_origen)
    {
        
        $mysqli = connect_database();
        
        $sql = "INSERT INTO miembroGrupo(nombre, instrumento, fecha_nacimiento, ciudad_origen) 
                        VALUES (?, ?, ?, ?)";
        $sentencia = $mysqli->prepare($sql);
        if(!$sentencia)
        {
            echo "Fallo en la preparación de la sentencia: ".$mysqli->errno;
        }

        $asignar = $sentencia->bind_param("ssds", $nombre, $instrumento, $fecha_nacimiento, $ciudad_origen);
        if(!$asignar)
        {
            echo "Fallo en la asignacion de parametros ".$mysqli->errno;
        }
        
        $ejecucion = $sentencia->execute();
        if(!$ejecucion)
        {
            echo "Fallo en la ejecucion: ".$mysqli->errno;
        }
        
        $mysqli->close();
        return true;
    }
    
?>